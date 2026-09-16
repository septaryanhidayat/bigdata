<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class SyncSdmEmailsAndKoding extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'erapor:sync-sdm-koding';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ganti ekstensi email akun menjadi @sitrobbani.sch.id dan ganti istilah robotik menjadi koding di seluruh database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memastikan tabel e-rapor & struktur database tersedia...');
        \App\Http\Controllers\Admin\AcademicController::ensureExtendedTablesExist();

        $this->info('Memulai sinkronisasi email SDM @sitrobbani.sch.id dan pembaharuan istilah Koding...');

        // 1. UPDATE USER EMAILS TO @sitrobbani.sch.id
        $usersUpdated = 0;
        $users = User::all();
        foreach ($users as $user) {
            $oldEmail = $user->email;
            if (!str_ends_with(strtolower($oldEmail), '@sitrobbani.sch.id')) {
                // Ambil username sebelum @
                $parts = explode('@', $oldEmail);
                $prefix = $parts[0] ?? 'user';
                $newEmail = strtolower($prefix) . '@sitrobbani.sch.id';

                // Cek apakah email bentrok dengan user lain
                $exists = User::where('email', $newEmail)->where('id', '!=', $user->id)->exists();
                if ($exists) {
                    $newEmail = strtolower($prefix) . $user->id . '@sitrobbani.sch.id';
                }

                $user->email = $newEmail;
                $user->save();
                $this->line("User #{$user->id} ({$user->name}): {$oldEmail} -> {$newEmail}");
                $usersUpdated++;
            }
        }
        $this->info("✓ Selesai perbaharui email akun: {$usersUpdated} akun diperbaharui.");

        // 2. UPDATE EMPLOYEES EMAILS IF TABLE EXISTS
        if (\Illuminate\Support\Facades\Schema::hasTable('employees')) {
            $empUpdated = DB::table('employees')
                ->where('email', 'not like', '%@sitrobbani.sch.id')
                ->whereNotNull('email')
                ->get();
            foreach ($empUpdated as $emp) {
                $prefix = explode('@', $emp->email)[0] ?? 'emp';
                $newEmail = strtolower($prefix) . '@sitrobbani.sch.id';
                DB::table('employees')->where('id', $emp->id)->update(['email' => $newEmail]);
            }
            $this->info("✓ Selesai perbaharui email tabel employees: " . count($empUpdated) . " data.");
        }

        // 3. UPDATE ROBOTIK TO KODING ACROSS RELEVANT TABLES
        $this->info('Memperbaharui istilah Robotik menjadi Koding di database...');

        // homeroom_notes
        if (\Illuminate\Support\Facades\Schema::hasTable('homeroom_notes')) {
            $notes = DB::table('homeroom_notes')->where('extracurriculars', 'like', '%obotik%')->get();
            foreach ($notes as $n) {
                $replaced = str_ireplace(['Robotika', 'robotika', 'Robotik', 'robotik'], 'Koding', $n->extracurriculars);
                DB::table('homeroom_notes')->where('id', $n->id)->update(['extracurriculars' => $replaced]);
            }
            $this->info("✓ Tabel homeroom_notes: " . count($notes) . " baris diperbaharui.");
        }

        // homeroom_records
        if (\Illuminate\Support\Facades\Schema::hasTable('homeroom_records')) {
            $records = DB::table('homeroom_records')->where('extracurriculars', 'like', '%obotik%')->get();
            foreach ($records as $r) {
                $replaced = str_ireplace(['Robotika', 'robotika', 'Robotik', 'robotik'], 'Koding', $r->extracurriculars);
                DB::table('homeroom_records')->where('id', $r->id)->update(['extracurriculars' => $replaced]);
            }
            $this->info("✓ Tabel homeroom_records: " . count($records) . " baris diperbaharui.");
        }

        // extracurriculars
        if (\Illuminate\Support\Facades\Schema::hasTable('extracurriculars')) {
            $ekskuls = DB::table('extracurriculars')->where('name', 'like', '%obotik%')->get();
            foreach ($ekskuls as $e) {
                $replaced = str_ireplace(['Robotika', 'robotika', 'Robotik', 'robotik'], 'Koding', $e->name);
                DB::table('extracurriculars')->where('id', $e->id)->update(['name' => $replaced]);
            }
            $this->info("✓ Tabel extracurriculars: " . count($ekskuls) . " baris diperbaharui.");
        }

        // subjects
        if (\Illuminate\Support\Facades\Schema::hasTable('subjects')) {
            $sbjs = DB::table('subjects')->where('name', 'like', '%obotik%')->get();
            foreach ($sbjs as $s) {
                $replaced = str_ireplace(['Sains & Robotika', 'Sains & Robotik', 'Robotika', 'Robotik'], 'Sains & Koding Digital', $s->name);
                DB::table('subjects')->where('id', $s->id)->update(['name' => $replaced]);
            }
            $this->info("✓ Tabel subjects: " . count($sbjs) . " baris diperbaharui.");
        }

        // rooms
        if (\Illuminate\Support\Facades\Schema::hasTable('rooms')) {
            $rooms = DB::table('rooms')->where('name', 'like', '%obotik%')->get();
            foreach ($rooms as $rm) {
                $replaced = str_ireplace(['Lab Robotika Modern', 'Lab Robotika', 'Robotika', 'Robotik'], 'Lab Koding Digital Modern', $rm->name);
                DB::table('rooms')->where('id', $rm->id)->update(['name' => $replaced]);
            }
            $this->info("✓ Tabel rooms: " . count($rooms) . " baris diperbaharui.");
        }

        // site_settings
        if (\Illuminate\Support\Facades\Schema::hasTable('site_settings')) {
            $settings = DB::table('site_settings')->where('value', 'like', '%obotik%')->get();
            foreach ($settings as $st) {
                $replaced = str_ireplace(['Robotika', 'robotika', 'Robotik', 'robotik'], 'Koding', $st->value);
                if (isset($st->id)) {
                    DB::table('site_settings')->where('id', $st->id)->update(['value' => $replaced]);
                } elseif (isset($st->key)) {
                    DB::table('site_settings')->where('key', $st->key)->update(['value' => $replaced]);
                }
            }
            $this->info("✓ Tabel site_settings: " . count($settings) . " baris diperbaharui.");
        }

        // feature_modules
        if (\Illuminate\Support\Facades\Schema::hasTable('feature_modules')) {
            $modules = DB::table('feature_modules')->where('full_desc', 'like', '%obotik%')->get();
            foreach ($modules as $m) {
                $replaced = str_ireplace(['Robotik', 'robotik'], 'Koding', $m->full_desc);
                DB::table('feature_modules')->where('id', $m->id)->update(['full_desc' => $replaced]);
            }
            $this->info("✓ Tabel feature_modules: " . count($modules) . " baris diperbaharui.");
        }

        // ai_knowledge_bases
        if (\Illuminate\Support\Facades\Schema::hasTable('ai_knowledge_bases')) {
            $aiKb = DB::table('ai_knowledge_bases')->where('raw_content', 'like', '%obotik%')->get();
            foreach ($aiKb as $kb) {
                $replaced = str_ireplace(['Robotika', 'robotika', 'Robotik', 'robotik'], 'Koding', $kb->raw_content);
                DB::table('ai_knowledge_bases')->where('id', $kb->id)->update(['raw_content' => $replaced]);
            }
            $this->info("✓ Tabel ai_knowledge_bases: " . count($aiKb) . " baris diperbaharui.");
        }

        $this->info('🎉 SEMUA SINKRONISASI BERHASIL 100%!');
        return Command::SUCCESS;
    }
}
