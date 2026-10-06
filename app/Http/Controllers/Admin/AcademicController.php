<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Employee;
use App\Models\Schedule;
use App\Models\KbmJournal;
use App\Models\Grade;
use App\Models\Student;
use App\Models\AcademicYear;
use App\Models\QuranCriterion;
use App\Models\QuranGrade;
use App\Models\CharacterIndicator;
use App\Models\CharacterGrade;
use App\Models\HomeroomNote;
use App\Models\ReportSetting;
use App\Models\LearningObjective;
use App\Models\Level;
use App\Models\Guardian;
use App\Models\Extracurricular;
use App\Models\P5Project;
use App\Models\DigitalSignature;
use App\Models\User;
use App\Services\GeminiEraporService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class AcademicController extends Controller
{
    /**
     * Modul 2.1: Jadwal Pelajaran Mingguan & Jurnal KBM
     */
    public function schedules()
    {
        $schoolId = auth()->user()?->getEffectiveSchoolId();

        $schedulesQuery = Schedule::with(['school', 'classroom', 'subject', 'teacher']);
        $classroomsQuery = Classroom::query();
        $teachersQuery = Employee::whereIn('role_type', ['TEACHER', 'HEADMASTER', 'COUNSELOR']);

        if ($schoolId) {
            $schedulesQuery->where('school_id', $schoolId);
            $classroomsQuery->where('school_id', $schoolId);
            $teachersQuery->where('school_id', $schoolId);
        }

        $schedules = $schedulesQuery->get();
        $schools = $schoolId ? School::where('id', $schoolId)->get() : School::all();
        $classrooms = $classroomsQuery->get();
        $subjects = $schoolId ? Subject::where('school_id', $schoolId)->get() : Subject::all();
        $teachers = $teachersQuery->get();
        if ($teachers->isEmpty()) {
            $teachers = $schoolId ? Employee::where('school_id', $schoolId)->get() : Employee::all();
        }

        return view('admin.academic.schedules', compact('schedules', 'schools', 'classrooms', 'subjects', 'teachers', 'schoolId'));
    }

    public function storeSchedule(Request $request)
    {
        $user = auth()->user();
        $schoolId = $user && $user->school_id ? $user->school_id : $request->school_id;

        $validated = $request->validate([
            'school_id' => 'required|exists:schools,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:employees,id',
            'day' => 'required|string',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $validated['school_id'] = $schoolId;
        $sch = Schedule::create($validated);

        try {
            \App\Models\AuditLog::create([
                'user_id' => auth()->id() ?? 1,
                'action' => 'JADWAL KBM',
                'model_type' => 'Schedule',
                'model_id' => $sch->id,
                'ip_address' => request()->ip(),
            ]);
        } catch(\Throwable $e) {}

        return redirect()->back()->with('success', 'Jadwal Pelajaran Berhasil Ditambahkan!');
    }

    public function destroySchedule($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schoolId = auth()->user()?->getEffectiveSchoolId();
        if ($schoolId && $schedule->school_id != $schoolId) {
            return redirect()->back()->with('error', 'Akses ditolak: Anda tidak memiliki otoritas atas jadwal ini.');
        }

        $schedule->delete();
        return redirect()->back()->with('success', '✓ Jadwal pelajaran berhasil dihapus.');
    }

    /**
     * Jurnal KBM Guru
     */
    public function journals()
    {
        $user = auth()->user();
        $schoolId = $user?->getEffectiveSchoolId();

        $journalsQuery = KbmJournal::with(['schedule.classroom', 'schedule.subject', 'teacher']);
        $schedulesQuery = Schedule::with(['classroom', 'subject']);
        $teachersQuery = Employee::whereIn('role_type', ['TEACHER', 'HEADMASTER', 'COUNSELOR']);

        if ($schoolId) {
            $journalsQuery->whereHas('schedule', fn($q) => $q->where('school_id', $schoolId));
            $schedulesQuery->where('school_id', $schoolId);
            $teachersQuery->where('school_id', $schoolId);
        }

        $journals = $journalsQuery->latest()->paginate(15);
        $schedules = $schedulesQuery->get();
        $teachers = $teachersQuery->get();
        if ($teachers->isEmpty()) {
            $teachers = $schoolId ? Employee::where('school_id', $schoolId)->get() : Employee::all();
        }

        return view('admin.academic.journals', compact('journals', 'schedules', 'teachers'));
    }

    public function storeJournal(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'teacher_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'topic' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $jrn = KbmJournal::create([
            'schedule_id' => $request->schedule_id,
            'teacher_id' => $request->teacher_id,
            'date' => $request->date,
            'topic' => $request->topic,
            'notes' => $request->notes,
        ]);

        try {
            \App\Models\AuditLog::create([
                'user_id' => auth()->id() ?? 1,
                'action' => 'JURNAL KBM',
                'model_type' => 'KbmJournal',
                'model_id' => $jrn->id,
                'ip_address' => request()->ip(),
            ]);
        } catch(\Throwable $e) {}

        return redirect()->back()->with('success', 'Catatan Jurnal KBM Guru Berhasil Disimpan!');
    }

    public function destroyJournal($id)
    {
        $journal = KbmJournal::with('schedule')->findOrFail($id);
        $schoolId = auth()->user()?->getEffectiveSchoolId();
        if ($schoolId && $journal->schedule && $journal->schedule->school_id != $schoolId) {
            return redirect()->back()->with('error', 'Akses ditolak: Anda tidak memiliki otoritas atas jurnal ini.');
        }

        $journal->delete();
        return redirect()->back()->with('success', '✓ Jurnal KBM berhasil dihapus.');
    }

    /**
     * Pastikan tabel-tabel ekstensi e-rapor (Wafa, Karakter, Catatan, Setting, Ekskul, P5)
     * otomatis terbuat jika database produksi belum menjalankan migration.
     */
    public static function ensureExtendedTablesExist(): void
    {
        // 1. quran_criteria
        try {
            if (!Schema::hasTable('quran_criteria')) {
                Schema::create('quran_criteria', function (Blueprint $table) {
                    $table->id();
                    $table->unsignedBigInteger('school_id')->nullable()->index();
                    $table->string('category', 20)->default('tahsin');
                    $table->string('code', 30)->nullable();
                    $table->string('name');
                    $table->text('description')->nullable();
                    $table->unsignedSmallInteger('order_number')->default(0);
                    $table->timestamps();
                });
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('ensure quran_criteria table error: ' . $e->getMessage());
        }

        // 2. quran_grades
        try {
            if (!Schema::hasTable('quran_grades')) {
                Schema::create('quran_grades', function (Blueprint $table) {
                    $table->id();
                    $table->unsignedBigInteger('student_id')->index();
                    $table->unsignedBigInteger('academic_year_id')->nullable()->index();
                    $table->string('tahsin_method')->default('Wafa');
                    $table->string('tahsin_level')->nullable();
                    $table->json('tahsin_scores')->nullable();
                    $table->decimal('tahsin_final_score', 5, 2)->nullable();
                    $table->string('tahsin_predicate', 30)->nullable();
                    $table->text('tahsin_notes')->nullable();
                    $table->string('tahfidz_target')->nullable();
                    $table->string('tahfidz_achievement')->nullable();
                    $table->decimal('tahfidz_score', 5, 2)->nullable();
                    $table->string('tahfidz_predicate', 30)->nullable();
                    $table->string('tasmi_exam_result')->nullable();
                    $table->text('tahfidz_notes')->nullable();
                    $table->unsignedBigInteger('examiner_teacher_id')->nullable()->index();
                    $table->string('quran_group', 100)->nullable();
                    $table->string('tilawah_predicate', 30)->nullable();
                    $table->timestamps();
                });
            } else {
                if (!Schema::hasColumn('quran_grades', 'quran_group')) {
                    Schema::table('quran_grades', function (Blueprint $table) {
                        $table->string('quran_group', 100)->nullable();
                    });
                }
                if (!Schema::hasColumn('quran_grades', 'tilawah_predicate')) {
                    Schema::table('quran_grades', function (Blueprint $table) {
                        $table->string('tilawah_predicate', 30)->nullable();
                    });
                }
                if (!Schema::hasColumn('quran_grades', 'quran_teacher_name')) {
                    Schema::table('quran_grades', function (Blueprint $table) {
                        $table->string('quran_teacher_name', 255)->nullable();
                    });
                }
                if (!Schema::hasColumn('quran_grades', 'quran_teacher_title')) {
                    Schema::table('quran_grades', function (Blueprint $table) {
                        $table->string('quran_teacher_title', 255)->nullable();
                    });
                }
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('ensure quran_grades table error: ' . $e->getMessage());
        }

        // 3. character_indicators
        try {
            if (!Schema::hasTable('character_indicators')) {
                Schema::create('character_indicators', function (Blueprint $table) {
                    $table->id();
                    $table->unsignedBigInteger('school_id')->nullable()->index();
                    $table->string('standard_code', 20);
                    $table->string('standard_name');
                    $table->text('indicator_name');
                    $table->unsignedSmallInteger('order_number')->default(0);
                    $table->timestamps();
                });

                // Seed 7 Standar Karakter JSIT
                $defaults = [
                    ['standard_code' => 'SKL-01', 'standard_name' => 'Akidah yang Lurus (Salimul Aqidah)', 'indicator_name' => 'Mengenal Allah melalui ciptaan-Nya, tidak melakukan syirik, dan ikhlas beribadah.'],
                    ['standard_code' => 'SKL-02', 'standard_name' => 'Ibadah yang Benar (Shahihul Ibadah)', 'indicator_name' => 'Melaksanakan sholat fardhu berjamaah dengan tertib, terbiasa dhuha dan rawatib.'],
                    ['standard_code' => 'SKL-03', 'standard_name' => 'Kepribadian Matang & Berakhlak Mulia (Matinul Khuluq)', 'indicator_name' => 'Santun kepada guru, orang tua, dan teman, bersikap jujur dan amanah.'],
                    ['standard_code' => 'SKL-04', 'standard_name' => 'Pribadi yang Mandiri (Qadirun alal Kasbi)', 'indicator_name' => 'Mandiri dalam mengurus perlengkapan sekolah dan tugas-tugas harian.'],
                    ['standard_code' => 'SKL-05', 'standard_name' => 'Cerdas & Berpengetahuan Luas (Mutsaqqoful Fikri)', 'indicator_name' => 'Memiliki rasa ingin tahu tinggi, gemar membaca dan berpikir kritis.'],
                    ['standard_code' => 'SKL-06', 'standard_name' => 'Sehat & Kuat (Qawiyyul Jismi)', 'indicator_name' => 'Menjaga kebersihan fisik, lingkungan, makan makanan halal & bergizi, gemar berolahraga.'],
                    ['standard_code' => 'SKL-07', 'standard_name' => 'Disiplin & Bermanfaat bagi Sesama (Nafiun Lighairihi)', 'indicator_name' => 'Disiplin waktu, tertib aturan, peduli lingkungan dan suka membantu orang lain.'],
                ];
                foreach ($defaults as $idx => $def) {
                    \Illuminate\Support\Facades\DB::table('character_indicators')->insert([
                        'school_id' => null,
                        'standard_code' => $def['standard_code'],
                        'standard_name' => $def['standard_name'],
                        'indicator_name' => $def['indicator_name'],
                        'order_number' => $idx + 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('ensure character_indicators table error: ' . $e->getMessage());
        }

        // 4. character_grades
        try {
            if (!Schema::hasTable('character_grades')) {
                Schema::create('character_grades', function (Blueprint $table) {
                    $table->id();
                    $table->unsignedBigInteger('student_id')->index();
                    $table->unsignedBigInteger('academic_year_id')->nullable()->index();
                    $table->json('indicator_scores')->nullable();
                    $table->string('mutabaah_sholat_fardhu')->nullable()->default('Selalu Berjamaah');
                    $table->string('mutabaah_sholat_dhuha')->nullable()->default('Rutin Setiap Hari');
                    $table->string('mutabaah_tilawah')->nullable()->default('Rutin 1/2 Juz per Hari');
                    $table->string('mutabaah_infaq')->nullable()->default('Rutin Infaq Jumat');
                    $table->text('bpi_mentor_notes')->nullable();
                    $table->timestamps();
                });
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('ensure character_grades table error: ' . $e->getMessage());
        }

        // 5. homeroom_notes
        try {
            if (!Schema::hasTable('homeroom_notes')) {
                Schema::create('homeroom_notes', function (Blueprint $table) {
                    $table->id();
                    $table->unsignedBigInteger('student_id')->index();
                    $table->unsignedBigInteger('academic_year_id')->nullable()->index();
                    $table->integer('sick_count')->default(0);
                    $table->integer('permission_count')->default(0);
                    $table->integer('absent_count')->default(0);
                    $table->decimal('height_cm', 5, 1)->nullable();
                    $table->decimal('weight_kg', 5, 1)->nullable();
                    $table->string('hearing_health')->nullable()->default('Baik');
                    $table->string('vision_health')->nullable()->default('Baik');
                    $table->string('dental_health')->nullable()->default('Baik');
                    $table->json('extracurriculars')->nullable();
                    $table->text('notes')->nullable();
                    $table->timestamps();
                });
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('ensure homeroom_notes table error: ' . $e->getMessage());
        }

        // 6. report_settings
        try {
            if (!Schema::hasTable('report_settings')) {
                Schema::create('report_settings', function (Blueprint $table) {
                    $table->id();
                    $table->unsignedBigInteger('school_id')->index();
                    $table->text('kop_header_text')->nullable();
                    $table->string('kop_image_url')->nullable();
                    $table->string('school_logo_url')->nullable();
                    $table->string('jsit_logo_url')->nullable();
                    $table->string('foundation_logo_url')->nullable();
                    $table->string('stamp_image_url')->nullable();
                    $table->string('principal_signature_url')->nullable();
                    $table->string('principal_name')->nullable();
                    $table->string('principal_nip')->nullable();
                    $table->string('report_date')->nullable();
                    $table->string('report_city')->nullable()->default('Bandung');
                    $table->string('accreditation')->nullable();
                    $table->string('nss_nds')->nullable();
                    $table->string('signature_mode')->nullable()->default('both');
                    $table->timestamps();
                });
            } else {
                if (!Schema::hasColumn('report_settings', 'accreditation')) {
                    Schema::table('report_settings', function (Blueprint $table) {
                        $table->string('accreditation')->nullable();
                    });
                }
                if (!Schema::hasColumn('report_settings', 'nss_nds')) {
                    Schema::table('report_settings', function (Blueprint $table) {
                        $table->string('nss_nds')->nullable();
                    });
                }
                if (!Schema::hasColumn('report_settings', 'signature_mode')) {
                    Schema::table('report_settings', function (Blueprint $table) {
                        $table->string('signature_mode')->nullable()->default('both');
                    });
                }
                if (!Schema::hasColumn('report_settings', 'quran_teacher_name')) {
                    Schema::table('report_settings', function (Blueprint $table) {
                        $table->string('quran_teacher_name', 255)->nullable();
                    });
                }
                if (!Schema::hasColumn('report_settings', 'quran_teacher_title')) {
                    Schema::table('report_settings', function (Blueprint $table) {
                        $table->string('quran_teacher_title', 255)->nullable();
                    });
                }
            }

            if (Schema::hasTable('classrooms') && !Schema::hasColumn('classrooms', 'quran_teacher_name')) {
                Schema::table('classrooms', function (Blueprint $table) {
                    $table->string('quran_teacher_name', 255)->nullable();
                });
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('ensure report_settings table error: ' . $e->getMessage());
        }

        // 7. extracurriculars
        try {
            if (!Schema::hasTable('extracurriculars')) {
                Schema::create('extracurriculars', function (Blueprint $table) {
                    $table->id();
                    $table->unsignedBigInteger('school_id')->index();
                    $table->string('name');
                    $table->string('coach_name')->nullable();
                    $table->text('description')->nullable();
                    $table->boolean('is_active')->default(true);
                    $table->timestamps();
                });
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('ensure extracurriculars table error: ' . $e->getMessage());
        }

        // 8. p5_projects
        try {
            if (!Schema::hasTable('p5_projects')) {
                Schema::create('p5_projects', function (Blueprint $table) {
                    $table->id();
                    $table->unsignedBigInteger('school_id')->index();
                    $table->unsignedBigInteger('classroom_id')->nullable()->index();
                    $table->unsignedBigInteger('academic_year_id')->nullable()->index();
                    $table->string('theme');
                    $table->string('title');
                    $table->text('description')->nullable();
                    $table->string('coordinator_name')->nullable();
                    $table->json('target_dimensions')->nullable();
                    $table->timestamps();
                });
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('ensure p5_projects table error: ' . $e->getMessage());
        }

        // 9. Classrooms signature column
        try {
            if (Schema::hasTable('classrooms') && !Schema::hasColumn('classrooms', 'homeroom_signature_path')) {
                Schema::table('classrooms', function (Blueprint $table) {
                    $table->string('homeroom_signature_path')->nullable();
                });
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('ensure classrooms homeroom_signature_path error: ' . $e->getMessage());
        }

        // 10. Students bio & parent fields
        try {
            if (Schema::hasTable('students') && !Schema::hasColumn('students', 'father_name')) {
                Schema::table('students', function (Blueprint $table) {
                    $table->string('father_name')->nullable();
                    $table->string('mother_name')->nullable();
                    $table->string('father_job')->nullable();
                    $table->string('mother_job')->nullable();
                    $table->string('guardian_name')->nullable();
                    $table->string('guardian_job')->nullable();
                    $table->string('guardian_address')->nullable();
                    $table->string('previous_school')->nullable();
                    $table->string('address')->nullable();
                    $table->string('village')->nullable();
                    $table->string('district')->nullable();
                    $table->string('city')->nullable();
                    $table->string('province')->nullable();
                    $table->json('bio_data')->nullable();
                });
            }

            if (Schema::hasTable('students') && !Schema::hasColumn('students', 'photo_path')) {
                Schema::table('students', function (Blueprint $table) {
                    $table->string('photo_path')->nullable();
                });
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('ensure students bio & photo fields error: ' . $e->getMessage());
        }

        // 11. Schools profile fields
        try {
            if (Schema::hasTable('schools') && !Schema::hasColumn('schools', 'principal_nip')) {
                Schema::table('schools', function (Blueprint $table) {
                    $table->string('principal_nip')->nullable();
                    $table->string('village')->nullable();
                    $table->string('district')->nullable();
                    $table->string('city')->nullable();
                    $table->string('province')->nullable();
                    $table->string('postal_code')->nullable();
                    $table->string('website')->nullable();
                });
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('ensure schools profile fields error: ' . $e->getMessage());
        }

        // 12. learning_objectives (Tujuan Pembelajaran Kurikulum Merdeka)
        try {
            if (!Schema::hasTable('learning_objectives')) {
                Schema::create('learning_objectives', function (Blueprint $table) {
                    $table->id();
                    $table->unsignedBigInteger('school_id')->nullable()->index();
                    $table->unsignedBigInteger('subject_id')->nullable()->index();
                    $table->unsignedBigInteger('academic_year_id')->nullable()->index();
                    $table->string('grade_level', 20)->default('Semua');
                    $table->string('code', 30);
                    $table->string('short_desc');
                    $table->text('description')->nullable();
                    $table->string('semester', 20)->default('Genap');
                    $table->unsignedSmallInteger('order_number')->default(1);
                    $table->boolean('is_active')->default(true);
                    $table->timestamps();
                });
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('ensure learning_objectives table error: ' . $e->getMessage());
        }
    }

    /**
     * Memastikan seluruh tingkat (level) pada unit sekolah terdaftar lengkap sesuai jenjangnya
     * SD: Tingkat 1 - 6 (6 tingkat)
     * SMP: Tingkat 7 - 9 (3 tingkat)
     * SMA: Tingkat 10 - 12 (3 tingkat)
     * TK/PAUD: Kelompok A & B (2 tingkat)
     */
    public static function ensureSchoolLevels($schoolId, $activeSchool)
    {
        if (!$schoolId || !$activeSchool) return;

        $schoolCode = strtolower($activeSchool->code ?? '');
        $schoolName = strtolower($activeSchool->name ?? '');
        $eduLevel = strtolower($activeSchool->education_level ?? '');

        $isSd = str_contains($schoolCode, 'sd') || str_contains($schoolName, 'sd') || str_contains($eduLevel, 'sd') || str_contains($eduLevel, 'dasar');
        $isSmp = str_contains($schoolCode, 'smp') || str_contains($schoolName, 'smp') || str_contains($eduLevel, 'smp') || str_contains($eduLevel, 'menengah');
        $isSma = str_contains($schoolCode, 'sma') || str_contains($schoolName, 'sma') || str_contains($schoolCode, 'smk') || str_contains($schoolName, 'smk');
        $isTk = str_contains($schoolCode, 'tk') || str_contains($schoolName, 'tk') || str_contains($schoolCode, 'paud') || str_contains($schoolName, 'paud');

        if (!$isSd && !$isSmp && !$isSma && !$isTk) {
            $isSd = true;
        }

        $expectedLevels = [];
        if ($isSd) {
            $expectedLevels = [
                ['code' => '1', 'name' => 'Tingkat 1 (Fase A)', 'sort_order' => 1],
                ['code' => '2', 'name' => 'Tingkat 2 (Fase A)', 'sort_order' => 2],
                ['code' => '3', 'name' => 'Tingkat 3 (Fase B)', 'sort_order' => 3],
                ['code' => '4', 'name' => 'Tingkat 4 (Fase B)', 'sort_order' => 4],
                ['code' => '5', 'name' => 'Tingkat 5 (Fase C)', 'sort_order' => 5],
                ['code' => '6', 'name' => 'Tingkat 6 (Fase C)', 'sort_order' => 6],
            ];
        } elseif ($isSmp) {
            $expectedLevels = [
                ['code' => '7', 'name' => 'Tingkat 7 (Fase D)', 'sort_order' => 7],
                ['code' => '8', 'name' => 'Tingkat 8 (Fase D)', 'sort_order' => 8],
                ['code' => '9', 'name' => 'Tingkat 9 (Fase D)', 'sort_order' => 9],
            ];
        } elseif ($isSma) {
            $expectedLevels = [
                ['code' => '10', 'name' => 'Tingkat 10 (Fase E)', 'sort_order' => 10],
                ['code' => '11', 'name' => 'Tingkat 11 (Fase F)', 'sort_order' => 11],
                ['code' => '12', 'name' => 'Tingkat 12 (Fase F)', 'sort_order' => 12],
            ];
        } elseif ($isTk) {
            $expectedLevels = [
                ['code' => 'A', 'name' => 'Kelompok TK A (Fase Fondasi)', 'sort_order' => 1],
                ['code' => 'B', 'name' => 'Kelompok TK B (Fase Fondasi)', 'sort_order' => 2],
            ];
        }

        foreach ($expectedLevels as $def) {
            $existing = \App\Models\Level::where('school_id', $schoolId)
                ->where(function($q) use ($def) {
                    $q->where('code', $def['code'])
                      ->orWhere('name', 'like', '%' . $def['code'] . '%');
                })
                ->first();

            if (!$existing) {
                \App\Models\Level::create([
                    'school_id' => $schoolId,
                    'code' => $def['code'],
                    'name' => $def['name'],
                    'sort_order' => $def['sort_order'],
                ]);
            } else {
                if ($existing->name !== $def['name'] || $existing->sort_order !== $def['sort_order']) {
                    $existing->update([
                        'name' => $def['name'],
                        'sort_order' => $def['sort_order']
                    ]);
                }
            }
        }
    }

    /**
     * Modul 2.2: Penilaian & E-Rapor Terpadu SIT (Kurikulum Merdeka, Wafa & 7 SKL JSIT)
     */
    public function grades(Request $request)
    {
        self::ensureExtendedTablesExist();

        // Auto-heal any mismatched student school_id with classroom school_id
        try {
            $mismatches = Student::with('classroom')->whereNotNull('classroom_id')->get();
            foreach ($mismatches as $st) {
                if ($st->classroom && $st->classroom->school_id && $st->school_id != $st->classroom->school_id) {
                    $st->update(['school_id' => $st->classroom->school_id]);
                }
            }
        } catch (\Throwable $e) {}

        $user = auth()->user();
        $schools = School::all();
        
        // Strict multi-unit isolation: Non-superadmin users are locked to their own school_id
        if ($user && !$user->isSuperAdmin() && $user->school_id) {
            $schoolId = $user->school_id;
        } else {
            $schoolId = $request->query('school_id');
            if (!$schoolId) {
                $effectiveId = $user?->getEffectiveSchoolId();
                if ($effectiveId && $effectiveId !== 'all') {
                    $schoolId = $effectiveId;
                } else {
                    // Cerdas: Pilih unit sekolah yang memiliki siswa, fallback ke unit pertama
                    $schoolWithStudents = School::whereHas('students')->first();
                    $schoolId = $schoolWithStudents?->id ?? ($schools->first()?->id ?? 1);
                }
            }
        }
        
        $activeSchool = School::find($schoolId) ?? $schools->first();
        $academicYears = AcademicYear::all();
        $activeAcademicYear = AcademicYear::where('is_active', 1)->first() ?? $academicYears->first();
        
        // Active Submenu / Tab
        $activeMenu = $request->query('menu', $request->query('tab', 'dashboard'));

        // Classrooms in this school
        $classrooms = Classroom::where('school_id', $schoolId)->with(['homeroomTeacher'])->get();

        // Selected Classroom:
        $selectedClassroomId = $request->query('classroom_id');
        if ($activeMenu === 'students' && !$request->has('classroom_id')) {
            // Pada menu Data Siswa Unit, default ke semua rombel (jangan batasi ke kelas 1 saja)
            $selectedClassroomId = null;
        } elseif (!$selectedClassroomId && $classrooms->isNotEmpty()) {
            // Prioritaskan rombel yang sudah memiliki siswa
            $firstClassWithStudents = $classrooms->first(function($c) {
                return Student::where('classroom_id', $c->id)->exists();
            });
            $selectedClassroomId = $firstClassWithStudents?->id ?? $classrooms->first()->id;
        }
        $selectedClassroom = $selectedClassroomId ? $classrooms->firstWhere('id', $selectedClassroomId) : null;

        $schoolCode = strtolower($activeSchool->code ?? '');
        $schoolName = strtolower($activeSchool->name ?? '');
        $isSmp = str_contains($schoolCode, 'smp') || str_contains($schoolName, 'smp');
        $isSd = str_contains($schoolCode, 'sd') || str_contains($schoolName, 'sd');

        $classroomGrade = 1;
        if ($selectedClassroom) {
            if (preg_match('/(?:kelas|kls|\b)\s*([1-9]|1[0-2]|i|ii|iii|iv|v|vi|vii|viii|ix|x|xi|xii)\b/i', $selectedClassroom->name, $matches)) {
                $lvl = strtolower($matches[1]);
                $romanMap = ['i' => 1, 'ii' => 2, 'iii' => 3, 'iv' => 4, 'v' => 5, 'vi' => 6, 'vii' => 7, 'viii' => 8, 'ix' => 9, 'x' => 10, 'xi' => 11, 'xii' => 12];
                $classroomGrade = is_numeric($lvl) ? (int)$lvl : ($romanMap[$lvl] ?? 1);
            } elseif (isset($selectedClassroom->level_id)) {
                $classroomGrade = (int)$selectedClassroom->level_id;
            }
        }
        $isBpiAllowed = $isSmp || ($isSd && in_array($classroomGrade, [4, 5, 6]));

        // Subjects in this school
        $subjects = Subject::where(function($q) use ($schoolId) {
            $q->where('school_id', $schoolId)->orWhereNull('school_id');
        })->get();
        if ($subjects->isEmpty()) {
            $subjects = Subject::all();
        }
        $selectedSubjectId = $request->query('subject_id');
        if (!$selectedSubjectId && $subjects->isNotEmpty()) {
            $selectedSubjectId = $subjects->first()->id;
        }
        $selectedSubject = $subjects->firstWhere('id', $selectedSubjectId);

        // Students of Selected Classroom
        $classStudents = collect();
        if ($selectedClassroomId && $selectedClassroomId !== 'unassigned') {
            $classStudents = Student::where('classroom_id', $selectedClassroomId)
                ->whereIn('status', ['ACTIVE', 'AKTIF'])
                ->orderBy('nis')
                ->get();
            if ($classStudents->isEmpty()) {
                $classStudents = Student::where('classroom_id', $selectedClassroomId)->orderBy('nis')->get();
            }
        }

        $studentIds = $classStudents->pluck('id');

        // Pre-fetch existing grades for current class
        $existingGrades = Grade::where('subject_id', $selectedSubjectId)
            ->where('academic_year_id', $activeAcademicYear?->id)
            ->whereIn('student_id', $studentIds)
            ->get()
            ->keyBy('student_id');

        try {
            $existingQuran = QuranGrade::where('academic_year_id', $activeAcademicYear?->id)
                ->whereIn('student_id', $studentIds)
                ->get()
                ->keyBy('student_id');
        } catch (\Throwable $e) {
            $existingQuran = collect();
        }

        try {
            $existingCharacter = CharacterGrade::where('academic_year_id', $activeAcademicYear?->id)
                ->whereIn('student_id', $studentIds)
                ->get()
                ->keyBy('student_id');
        } catch (\Throwable $e) {
            $existingCharacter = collect();
        }

        try {
            $existingHomeroom = HomeroomNote::where('academic_year_id', $activeAcademicYear?->id)
                ->whereIn('student_id', $studentIds)
                ->get()
                ->keyBy('student_id');
        } catch (\Throwable $e) {
            $existingHomeroom = collect();
        }

        // Master Criteria & Settings
        try {
            $quranCriteria = QuranCriterion::where(function($q) use ($schoolId) {
                $q->where('school_id', $schoolId)->orWhereNull('school_id');
            })->orderBy('order_number')->get();
        } catch (\Throwable $e) {
            $quranCriteria = collect();
        }

        try {
            $characterIndicators = CharacterIndicator::where(function($q) use ($schoolId) {
                $q->where('school_id', $schoolId)->orWhereNull('school_id');
            })->orderBy('order_number')->get();
        } catch (\Throwable $e) {
            $characterIndicators = collect();
        }

        try {
            $reportSetting = ReportSetting::firstOrCreate(
                ['school_id' => $schoolId],
                [
                    'kop_header_text' => "YAYASAN GENERASI ROBBANI SUMATERA SELATAN\n" . strtoupper($activeSchool->name ?? 'SD ISLAM TERPADU ROBBANI') . "\nNPSN: " . ($activeSchool->npsn ?? '69957391') . " • Terakreditasi B\nAlamat: " . ($activeSchool->address ?? 'Jln. Sarjana Blok A, Kel. Timbangan, Kec. Indralaya Utara, Kab. Ogan Ilir'),
                    'principal_name' => $activeSchool->principal_name ?? 'Nur Amalia, S.Pd., Gr',
                    'principal_nip' => '19850315 200904 1 003',
                    'report_city' => 'Ogan Ilir',
                    'report_date' => '18 Juni 2026',
                ]
            );
        } catch (\Throwable $e) {
            $reportSetting = new ReportSetting();
        }

        // Dashboard Stats & Classroom Progress Calculation
        $allSchoolStudents = Student::where('school_id', $schoolId)->whereIn('status', ['ACTIVE', 'AKTIF'])->get();
        $totalSchoolStudents = $allSchoolStudents->count();
        $totalClassrooms = $classrooms->count();
        $totalSubjects = $subjects->count();

        $classroomProgress = [];
        foreach ($classrooms as $cls) {
            $clsStudents = Student::where('classroom_id', $cls->id)->whereIn('status', ['ACTIVE', 'AKTIF'])->get();
            $stCount = $clsStudents->count();
            $stIds = $clsStudents->pluck('id');

            $mapelGradesCount = $stCount > 0 ? Grade::whereIn('student_id', $stIds)->distinct('student_id')->count('student_id') : 0;
            $quranGradesCount = 0;
            $charGradesCount = 0;
            $hrNotesCount = 0;
            try {
                if ($stCount > 0 && Schema::hasTable('quran_grades')) {
                    $quranGradesCount = QuranGrade::whereIn('student_id', $stIds)->count();
                }
                if ($stCount > 0 && Schema::hasTable('character_grades')) {
                    $charGradesCount = CharacterGrade::whereIn('student_id', $stIds)->count();
                }
                if ($stCount > 0 && Schema::hasTable('homeroom_notes')) {
                    $hrNotesCount = HomeroomNote::whereIn('student_id', $stIds)->count();
                }
            } catch (\Throwable $e) {}

            $totalExpected = $stCount * 4;
            $totalFilled = $mapelGradesCount + $quranGradesCount + $charGradesCount + $hrNotesCount;
            $pct = $totalExpected > 0 ? min(100, round(($totalFilled / $totalExpected) * 100)) : 0;

            // Projek P5 untuk kelas ini
            $clsP5Count = 0;
            try {
                if (Schema::hasTable('p5_projects')) {
                    $clsP5Count = \App\Models\P5Project::where('school_id', $schoolId)
                        ->where(function($q) use ($cls) {
                            $q->where('classroom_id', $cls->id)->orWhereNull('classroom_id');
                        })->count();
                }
            } catch (\Throwable $e) {}

            // Rata-rata nilai rapor kelas
            $clsAvgScore = null;
            if ($stCount > 0 && $mapelGradesCount > 0) {
                $avg = Grade::whereIn('student_id', $stIds)->avg('score');
                if ($avg !== null) $clsAvgScore = round($avg, 1);
            }

            // Jumlah siswa yang semua komponen rapornya sudah lengkap di kelas ini
            $clsReadyCount = 0;
            if ($stCount > 0) {
                foreach ($clsStudents as $cs) {
                    $hasM = Grade::where('student_id', $cs->id)->exists();
                    $hasQ = Schema::hasTable('quran_grades') && QuranGrade::where('student_id', $cs->id)->exists();
                    $hasC = Schema::hasTable('character_grades') && CharacterGrade::where('student_id', $cs->id)->exists();
                    $hasH = Schema::hasTable('homeroom_notes') && HomeroomNote::where('student_id', $cs->id)->exists();
                    if ($hasM && $hasQ && $hasC && $hasH) $clsReadyCount++;
                }
            }

            // Info kontak guru wali kelas untuk notifikasi pengingat Kepala Sekolah
            $waliEmp = $cls->homeroomTeacher;
            $waliPhone = $waliEmp?->phone ?? $waliEmp?->user?->phone ?? '';
            $waliNip = $waliEmp?->nip ?? '';

            $classroomProgress[$cls->id] = [
                'classroom' => $cls,
                'student_count' => $stCount,
                'mapel_count' => $mapelGradesCount,
                'quran_count' => $quranGradesCount,
                'char_count' => $charGradesCount,
                'hr_count' => $hrNotesCount,
                'p5_count' => $clsP5Count,
                'avg_score' => $clsAvgScore,
                'ready_count' => $clsReadyCount,
                'wali_phone' => $waliPhone,
                'wali_nip' => $waliNip,
                'percentage' => $pct,
            ];
        }

        // Print readiness checklist for each student in selected class
        $printReadiness = [];
        foreach ($classStudents as $st) {
            $hasMapel = Grade::where('student_id', $st->id)->exists();
            $hasQuran = isset($existingQuran[$st->id]);
            $hasChar = isset($existingCharacter[$st->id]);
            $hasHr = isset($existingHomeroom[$st->id]);
            $isReady = $hasMapel && $hasQuran && $hasChar && $hasHr;

            $printReadiness[$st->id] = [
                'mapel' => $hasMapel,
                'quran' => $hasQuran,
                'character' => $hasChar,
                'homeroom' => $hasHr,
                'is_ready' => $isReady,
            ];
        }

        // Map rata-rata nilai riil tiap siswa di kelas (untuk AI catatan & template presisi)
        $studentAverageMap = [];
        foreach ($classStudents as $st) {
            $avgScore = Grade::where('student_id', $st->id)
                ->where('academic_year_id', $activeAcademicYear?->id)
                ->avg('score');
            $studentAverageMap[$st->id] = $avgScore !== null ? round((float)$avgScore, 1) : null;
        }

        // Teachers of this school for assigning Wali Kelas
        $schoolTeachers = Employee::where('school_id', $schoolId)
            ->whereIn('role_type', ['TEACHER', 'HEADMASTER', 'COUNSELOR'])
            ->get();
        if ($schoolTeachers->isEmpty()) {
            $schoolTeachers = Employee::whereIn('role_type', ['TEACHER', 'HEADMASTER', 'COUNSELOR'])->get();
        }

        $rekapGuru = $schoolTeachers->count();
        $assignedWaliCount = $classrooms->whereNotNull('homeroom_teacher_id')->count();
        $rekapMapel = Grade::whereHas('student', fn($q) => $q->where('school_id', $schoolId))->distinct('student_id')->count('student_id');
        $rekapWafa = 0;
        $rekapKarakter = 0;
        $rekapHomeroom = 0;
        try {
            if (Schema::hasTable('quran_grades')) {
                $rekapWafa = QuranGrade::whereHas('student', fn($q) => $q->where('school_id', $schoolId))->distinct('student_id')->count('student_id');
            }
            if (Schema::hasTable('character_grades')) {
                $rekapKarakter = CharacterGrade::whereHas('student', fn($q) => $q->where('school_id', $schoolId))->distinct('student_id')->count('student_id');
            }
            if (Schema::hasTable('homeroom_notes')) {
                $rekapHomeroom = HomeroomNote::whereHas('student', fn($q) => $q->where('school_id', $schoolId))->distinct('student_id')->count('student_id');
            }
        } catch (\Throwable $e) {}

        // All students in this unit for Data Siswa Unit menu
        $unitStudents = Student::where('school_id', $schoolId)
            ->with(['classroom', 'school'])
            ->orderBy('nis')
            ->get();

        self::ensureSchoolLevels($schoolId, $activeSchool);
        $schoolLevels = \App\Models\Level::where('school_id', $schoolId)->orderBy('sort_order')->get();

        // Ekstrakurikuler & Ko-Kurikuler P5
        try {
            $extracurriculars = Schema::hasTable('extracurriculars') ? \App\Models\Extracurricular::where('school_id', $schoolId)->get() : collect();
            $p5Projects = Schema::hasTable('p5_projects') ? \App\Models\P5Project::where('school_id', $schoolId)->with(['classroom'])->get() : collect();
        } catch (\Throwable $e) {
            $extracurriculars = collect();
            $p5Projects = collect();
        }

        // 12. Tujuan Pembelajaran (TP) Kurikulum Merdeka
        try {
            if (LearningObjective::where('school_id', $schoolId)->count() === 0 && $subjects->isNotEmpty()) {
                self::seedDefaultTPForSchool($schoolId, $activeAcademicYear?->id);
            }

            $tpQuery = LearningObjective::where('school_id', $schoolId)->with(['subject']);
            if ($request->filled('subject_id')) {
                $tpQuery->where('subject_id', $request->query('subject_id'));
            }
            if ($request->filled('grade_level') && $request->query('grade_level') !== 'Semua') {
                $tpQuery->where('grade_level', $request->query('grade_level'));
            }
            $learningObjectives = $tpQuery->orderBy('subject_id')->orderBy('order_number')->get();

            $activeLearningObjectives = LearningObjective::where('school_id', $schoolId)
                ->where('subject_id', $selectedSubjectId)
                ->where('is_active', true)
                ->orderBy('order_number')
                ->get();
        } catch (\Throwable $e) {
            $learningObjectives = collect();
            $activeLearningObjectives = collect();
        }

        // Current user role display label
        $currentUser = auth()->user();
        $userRoleLabel = 'Staf Akademik';
        if ($currentUser?->isSuperAdmin()) $userRoleLabel = 'Super Admin Yayasan';
        elseif ($currentUser?->isHeadmaster()) $userRoleLabel = 'Kepala Sekolah (' . ($activeSchool->code ?? 'Unit') . ')';
        elseif ($currentUser?->isTeacher()) $userRoleLabel = 'Guru & Wali Kelas';
        elseif ($currentUser?->isStaffTu()) $userRoleLabel = 'Operator / Tata Usaha';

        // Unit Users for Kepala Sekolah & Super Admin
        $unitUsers = User::where(function($q) use ($schoolId) {
            $q->where('school_id', $schoolId);
        })->whereIn('role', ['TEACHER', 'STAFF_TU', 'HEADMASTER'])->orderBy('name')->get();

        // Chart 1: Rombel Labels & Progress Values
        $chartClassroomLabels = [];
        $chartClassroomValues = [];
        foreach ($classroomProgress as $cp) {
            $chartClassroomLabels[] = $cp['classroom']->name;
            $chartClassroomValues[] = $cp['percentage'];
        }

        // Chart 2: 7 SKL JSIT Radar Averages (Dihitung 100% Real dari character_grades)
        $chartSklLabels = [
            'Akidah Lurus',
            'Ibadah Benar',
            'Akhlak Mulia',
            'Pribadi Mandiri',
            'Cerdas & Kritis',
            'Fisik Tangkas',
            'Tertib & Disiplin'
        ];
        
        $sklKeys = [
            'salimul_aqidah',
            'shahihul_ibadah',
            'matinul_khuluq',
            'qodirun_alal_kasbi',
            'mutsaqqoful_fikri',
            'qowiyyul_jismi',
            'munazzhomun'
        ];

        $unitCharGrades = CharacterGrade::whereHas('student', fn($q) => $q->where('school_id', $schoolId))->get();
        $chartSklValues = [];

        if ($unitCharGrades->isNotEmpty()) {
            foreach ($sklKeys as $k) {
                $totalScore = 0;
                $countScore = 0;
                foreach ($unitCharGrades as $cg) {
                    $scores = is_array($cg->indicator_scores) ? $cg->indicator_scores : json_decode($cg->indicator_scores, true);
                    if ($scores && isset($scores[$k])) {
                        $val = strtoupper(trim((string)$scores[$k]));
                        $numericVal = match($val) {
                            'SB', 'A', 'SANGAT BAIK' => 95,
                            'B', 'BAIK' => 82,
                            'C', 'CUKUP', 'PB' => 70,
                            'K', 'KURANG' => 55,
                            default => is_numeric($val) ? (float)$val : 80
                        };
                        $totalScore += $numericVal;
                        $countScore++;
                    }
                }
                $chartSklValues[] = $countScore > 0 ? round($totalScore / $countScore) : 0;
            }
        } else {
            $chartSklValues = [0, 0, 0, 0, 0, 0, 0];
        }

        // Hitung Radar 7 SKL JSIT per Kelas / Rombel
        $chartSklPerClass = [
            'all' => [
                'name' => 'Semua Kelas (Rata-rata Unit)',
                'values' => $chartSklValues
            ]
        ];

        $unitCharGradesWithStudent = CharacterGrade::with('student')
            ->whereHas('student', fn($q) => $q->where('school_id', $schoolId))
            ->get();

        foreach ($classrooms as $cls) {
            $classCharGrades = $unitCharGradesWithStudent->filter(fn($cg) => $cg->student && $cg->student->classroom_id == $cls->id);
            $clsValues = [];
            if ($classCharGrades->isNotEmpty()) {
                foreach ($sklKeys as $k) {
                    $tScore = 0;
                    $cScore = 0;
                    foreach ($classCharGrades as $cg) {
                        $scores = is_array($cg->indicator_scores) ? $cg->indicator_scores : json_decode($cg->indicator_scores, true);
                        if ($scores && isset($scores[$k])) {
                            $val = strtoupper(trim((string)$scores[$k]));
                            $numericVal = match($val) {
                                'SB', 'A', 'SANGAT BAIK' => 95,
                                'B', 'BAIK' => 82,
                                'C', 'CUKUP', 'PB' => 70,
                                'K', 'KURANG' => 55,
                                default => is_numeric($val) ? (float)$val : 80
                            };
                            $tScore += $numericVal;
                            $cScore++;
                        }
                    }
                    $clsValues[] = $cScore > 0 ? round($tScore / $cScore) : 0;
                }
            } else {
                $clsValues = [0, 0, 0, 0, 0, 0, 0];
            }
            $chartSklPerClass[$cls->id] = [
                'name' => $cls->name,
                'values' => $clsValues
            ];
        }

        // Chart 3: Distribusi Predikat Capaian Akademik & Tilawah Al-Qur'an (100% Data Nyata Database)
        $chartPredicatesPerClass = [];
        
        $unitGrades = Grade::whereHas('student', fn($q) => $q->where('school_id', $schoolId))->pluck('score');
        $unitQuranScores = collect();
        if (Schema::hasTable('quran_grades')) {
            $unitQuranScores = QuranGrade::whereHas('student', fn($q) => $q->where('school_id', $schoolId))
                ->get()
                ->flatMap(fn($qg) => array_filter([(float)$qg->tahsin_final_score, (float)$qg->tahfidz_score]));
        }
        $allUnitScores = $unitGrades->concat($unitQuranScores)->filter(fn($s) => is_numeric($s) && $s > 0);
        $countA = $allUnitScores->filter(fn($s) => $s >= 85)->count();
        $countB = $allUnitScores->filter(fn($s) => $s >= 75 && $s < 85)->count();
        $countC = $allUnitScores->filter(fn($s) => $s >= 65 && $s < 75)->count();
        $countD = $allUnitScores->filter(fn($s) => $s < 65)->count();
        $chartPredicates = [
            'A' => $countA,
            'B' => $countB,
            'C' => $countC,
            'D' => $countD,
        ];
        $chartPredicatesPerClass['all'] = [
            'name' => 'Semua Kelas (Unit ' . ($activeSchool->code ?? 'SIT') . ')',
            'A' => $countA,
            'B' => $countB,
            'C' => $countC,
            'D' => $countD,
            'total' => $countA + $countB + $countC + $countD,
        ];

        // Rincian per Rombel Kelas
        foreach ($classrooms as $cls) {
            $clsGrades = Grade::whereHas('student', fn($q) => $q->where('classroom_id', $cls->id))->pluck('score');
            $clsQuranScores = collect();
            if (Schema::hasTable('quran_grades')) {
                $clsQuranScores = QuranGrade::whereHas('student', fn($q) => $q->where('classroom_id', $cls->id))
                    ->get()
                    ->flatMap(fn($qg) => array_filter([(float)$qg->tahsin_final_score, (float)$qg->tahfidz_score]));
            }
            $allClsScores = $clsGrades->concat($clsQuranScores)->filter(fn($s) => is_numeric($s) && $s > 0);
            $cA = $allClsScores->filter(fn($s) => $s >= 85)->count();
            $cB = $allClsScores->filter(fn($s) => $s >= 75 && $s < 85)->count();
            $cC = $allClsScores->filter(fn($s) => $s >= 65 && $s < 75)->count();
            $cD = $allClsScores->filter(fn($s) => $s < 65)->count();
            $chartPredicatesPerClass[$cls->id] = [
                'name' => $cls->name,
                'A' => $cA,
                'B' => $cB,
                'C' => $cC,
                'D' => $cD,
                'total' => $cA + $cB + $cC + $cD,
            ];
        }

        // Executive Metrics Real
        $averageUnitScore = $unitGrades->isNotEmpty() ? round($unitGrades->avg(), 1) : 0;
        
        $unitHomeroomNotes = HomeroomNote::whereHas('student', fn($q) => $q->where('school_id', $schoolId))->get();
        if ($unitHomeroomNotes->isNotEmpty() && $totalSchoolStudents > 0) {
            $totalSick = $unitHomeroomNotes->sum('sick_count');
            $totalPermission = $unitHomeroomNotes->sum('permission_count');
            $totalAbsent = $unitHomeroomNotes->sum('absent_count');
            $totalDaysOff = $totalSick + $totalPermission + $totalAbsent;
            $totalMaxDays = max(1, $totalSchoolStudents * 100);
            $presentRate = max(0, min(100, round((($totalMaxDays - $totalDaysOff) / $totalMaxDays) * 100, 1)));
            $overallAttendancePct = $presentRate . '%';
        } else {
            $overallAttendancePct = $totalSchoolStudents > 0 ? '100%' : '0%';
        }

        $tahfidzCompletionPct = $totalSchoolStudents > 0 ? round(($rekapWafa / $totalSchoolStudents) * 100) . '%' : '0%';
        $readyToPrintCount = collect($printReadiness)->filter(fn($r) => $r['is_ready'])->count();

        // Kinerja Wali Kelas Unit
        $completedWaliCount = collect($classroomProgress)->where('percentage', '>=', 100)->count();
        $inProgressWaliCount = collect($classroomProgress)->filter(fn($c) => $c['percentage'] > 0 && $c['percentage'] < 100)->count();
        $notStartedWaliCount = collect($classroomProgress)->where('percentage', '<=', 0)->count();

        // Total Fitur Baru (TP, P5, Ekstrakurikuler)
        $totalTpCount = 0;
        try {
            if (Schema::hasTable('learning_objectives')) {
                $totalTpCount = LearningObjective::where('school_id', $schoolId)->count();
            }
        } catch (\Throwable $e) {}
        $totalP5Count = $p5Projects->count();
        $totalEkskulCount = $extracurriculars->count();

        return view('admin.academic.grades', compact(
            'schools',
            'activeSchool',
            'schoolId',
            'activeMenu',
            'classrooms',
            'selectedClassroomId',
            'selectedClassroom',
            'subjects',
            'selectedSubjectId',
            'selectedSubject',
            'classStudents',
            'academicYears',
            'activeAcademicYear',
            'existingGrades',
            'existingQuran',
            'existingCharacter',
            'existingHomeroom',
            'quranCriteria',
            'characterIndicators',
            'reportSetting',
            'totalSchoolStudents',
            'totalClassrooms',
            'totalSubjects',
            'classroomProgress',
            'printReadiness',
            'schoolTeachers',
            'rekapGuru',
            'assignedWaliCount',
            'rekapMapel',
            'rekapWafa',
            'rekapKarakter',
            'rekapHomeroom',
            'unitStudents',
            'schoolLevels',
            'userRoleLabel',
            'extracurriculars',
            'p5Projects',
            'unitUsers',
            'chartClassroomLabels',
            'chartClassroomValues',
            'chartSklLabels',
            'chartSklValues',
            'chartSklPerClass',
            'chartPredicates',
            'chartPredicatesPerClass',
            'averageUnitScore',
            'overallAttendancePct',
            'tahfidzCompletionPct',
            'readyToPrintCount',
            'completedWaliCount',
            'inProgressWaliCount',
            'notStartedWaliCount',
            'totalTpCount',
            'totalP5Count',
            'totalEkskulCount',
            'isSmp',
            'isSd',
            'classroomGrade',
            'isBpiAllowed',
            'learningObjectives',
            'activeLearningObjectives',
            'studentAverageMap'
        ));
    }

    /**
     * Simpan / Update Rombel & Penetapan Wali Kelas oleh Kepsek / Operator
     */
    public function saveClassroom(Request $request)
    {
        $schoolId = $request->input('school_id');
        $classroomId = $request->input('classroom_id');
        $activeSchool = School::find($schoolId);
        self::ensureSchoolLevels($schoolId, $activeSchool);

        $request->validate([
            'school_id' => 'required|exists:schools,id',
            'name' => 'required|string|max:100',
            'level_id' => 'nullable|exists:levels,id',
            'homeroom_teacher_id' => 'nullable|exists:employees,id',
            'capacity' => 'nullable|integer|min:1|max:100',
            'room_number' => 'nullable|string|max:50',
        ]);

        if ($classroomId) {
            $classroom = Classroom::where('school_id', $schoolId)->findOrFail($classroomId);
            $classroom->update([
                'name' => $request->name,
                'level_id' => $request->level_id ?: $classroom->level_id,
                'capacity' => $request->capacity ?: ($classroom->capacity ?: 28),
                'room_number' => $request->room_number ?: $classroom->room_number,
                'homeroom_teacher_id' => $request->homeroom_teacher_id ?: null,
            ]);
            $msg = "✓ Data Rombel {$classroom->name} berhasil diperbarui!";
        } else {
            $activeYear = AcademicYear::where('is_active', true)->first() ?? AcademicYear::first();
            $level = Level::where('school_id', $schoolId)->orderBy('sort_order')->first();
            $classroom = Classroom::create([
                'school_id' => $schoolId,
                'level_id' => $request->level_id ?: ($level ? $level->id : 1),
                'academic_year_id' => $activeYear ? $activeYear->id : 1,
                'name' => $request->name,
                'capacity' => $request->capacity ?: 28,
                'room_number' => $request->room_number ?: null,
                'homeroom_teacher_id' => $request->homeroom_teacher_id ?: null,
            ]);
            $msg = "✓ Rombel Baru {$classroom->name} berhasil ditambahkan!";
        }

        return redirect()->route('admin.academic.grades', [
            'school_id' => $schoolId,
            'menu' => 'classrooms'
        ])->with('success', $msg);
    }

    /**
     * Simpan / Perbarui Profil Resmi Sekolah & Pengaturan Dokumen Rapor
     */
    public function saveSchoolProfile(Request $request)
    {
        $request->validate([
            'school_id' => 'required|exists:schools,id',
            'name' => 'required|string|max:255',
        ]);

        $school = School::findOrFail($request->school_id);
        $school->name = $request->name;
        if ($request->has('npsn')) $school->npsn = $request->npsn;
        if ($request->has('address')) $school->address = $request->address;
        if ($request->has('village')) $school->village = $request->village;
        if ($request->has('district')) $school->district = $request->district;
        if ($request->has('city')) $school->city = $request->city;
        if ($request->has('province')) $school->province = $request->province;
        if ($request->has('postal_code')) $school->postal_code = $request->postal_code;
        if ($request->has('phone')) $school->phone = $request->phone;
        if ($request->has('email')) $school->email = $request->email;
        if ($request->has('website')) $school->website = $request->website;
        if ($request->has('principal_name')) $school->principal_name = $request->principal_name;
        if ($request->has('principal_nip')) $school->principal_nip = $request->principal_nip;
        $school->save();

        // Update corresponding report settings
        $setting = ReportSetting::firstOrNew(['school_id' => $school->id]);
        if ($request->filled('principal_name')) $setting->principal_name = $request->principal_name;
        if ($request->filled('principal_nip')) $setting->principal_nip = $request->principal_nip;
        if ($request->filled('city')) $setting->report_city = $request->city;
        if ($request->filled('report_date')) $setting->report_date = $request->report_date;
        if ($request->filled('accreditation')) $setting->accreditation = $request->accreditation;
        if ($request->filled('nss_nds')) $setting->nss_nds = $request->nss_nds;
        $setting->save();

        return redirect()->route('admin.academic.grades', [
            'school_id' => $school->id,
            'menu' => 'settings'
        ])->with('success', "✓ Data profil sekolah {$school->name} berhasil diperbarui!");
    }

    /**
     * Kompresi dan simpan foto ke format WebP berkualitas tinggi dengan ukuran file minimal
     */
    protected function saveCompressedWebp($uploadedFile, $targetDir, $prefix = 'photo', $maxWidth = 480, $maxHeight = 640, $quality = 82): string
    {
        if (!file_exists($targetDir)) {
            @mkdir($targetDir, 0755, true);
        }

        $filename = $prefix . '_' . uniqid() . '_' . time() . '.webp';
        $targetPath = $targetDir . DIRECTORY_SEPARATOR . $filename;
        $filePath = $uploadedFile->getPathname();

        try {
            $imageInfo = @getimagesize($filePath);
            if ($imageInfo && extension_loaded('gd') && function_exists('imagewebp')) {
                $mime = $imageInfo['mime'] ?? '';
                $srcImage = null;

                switch ($mime) {
                    case 'image/jpeg':
                        $srcImage = @imagecreatefromjpeg($filePath);
                        break;
                    case 'image/png':
                        $srcImage = @imagecreatefrompng($filePath);
                        break;
                    case 'image/webp':
                        $srcImage = @imagecreatefromwebp($filePath);
                        break;
                    case 'image/gif':
                        $srcImage = @imagecreatefromgif($filePath);
                        break;
                    default:
                        $content = @file_get_contents($filePath);
                        if ($content) {
                            $srcImage = @imagecreatefromstring($content);
                        }
                        break;
                }

                if ($srcImage) {
                    $origWidth = imagesx($srcImage);
                    $origHeight = imagesy($srcImage);

                    // Resize proporsional jika melebihi batas maksimal pas foto 3x4
                    $ratio = min($maxWidth / max(1, $origWidth), $maxHeight / max(1, $origHeight), 1.0);
                    $newWidth = (int) round($origWidth * $ratio);
                    $newHeight = (int) round($origHeight * $ratio);

                    $dstImage = imagecreatetruecolor($newWidth, $newHeight);

                    // Preservasi transparansi atau latar bersih
                    imagealphablending($dstImage, false);
                    imagesavealpha($dstImage, true);
                    $transparent = imagecolorallocatealpha($dstImage, 255, 255, 255, 127);
                    imagefilledrectangle($dstImage, 0, 0, $newWidth, $newHeight, $transparent);

                    imagecopyresampled($dstImage, $srcImage, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);

                    imagewebp($dstImage, $targetPath, $quality);

                    imagedestroy($dstImage);
                    imagedestroy($srcImage);

                    return $filename;
                }
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('saveCompressedWebp error: ' . $e->getMessage());
        }

        // Fallback standar jika GD tidak tersedia
        $ext = strtolower($uploadedFile->getClientOriginalExtension() ?: 'webp');
        $fallbackName = $prefix . '_' . uniqid() . '_' . time() . '.' . $ext;
        $uploadedFile->move($targetDir, $fallbackName);
        return $fallbackName;
    }

    /**
     * Simpan / Tambah / Edit Lengkap Data Siswa oleh Kepsek / Operator
     */
    public function saveStudent(Request $request)
    {
        $request->validate([
            'school_id' => 'required|exists:schools,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'nis' => 'required|string',
            'full_name' => 'required|string|max:255',
        ]);

        $gender = strtoupper(trim((string)$request->gender));
        if ($gender === 'M' || $gender === 'L' || str_starts_with($gender, 'L')) {
            $gender = 'M';
        } else {
            $gender = 'F';
        }

        $studentData = [
            'classroom_id' => $request->classroom_id,
            'nis' => $request->nis,
            'nisn' => $request->nisn,
            'full_name' => $request->full_name,
            'nickname' => $request->nickname ?? null,
            'gender' => $gender,
            'pob' => $request->pob ?? $request->birth_place ?? null,
            'dob' => $request->dob ?? $request->birth_date ?? null,
            'status' => $request->status ?: 'ACTIVE',
            'father_name' => $request->father_name ?? null,
            'mother_name' => $request->mother_name ?? null,
            'father_job' => $request->father_job ?? null,
            'mother_job' => $request->mother_job ?? null,
            'guardian_name' => $request->guardian_name ?? null,
            'guardian_job' => $request->guardian_job ?? null,
            'guardian_address' => $request->guardian_address ?? null,
            'previous_school' => $request->previous_school ?? null,
            'address' => $request->address ?? null,
            'village' => $request->village ?? null,
            'district' => $request->district ?? null,
            'city' => $request->city ?? null,
            'province' => $request->province ?? null,
        ];

        // Handle upload pas foto siswa (3x4) terkompresi WebP
        if ($request->hasFile('photo')) {
            $photoFile = $request->file('photo');
            if ($photoFile->isValid()) {
                $targetDir = public_path('uploads/students');
                $photoName = $this->saveCompressedWebp($photoFile, $targetDir, 'student_' . ($request->student_id ?: time()), 480, 640, 82);
                $studentData['photo_path'] = 'uploads/students/' . $photoName;
            }
        }

        if ($request->filled('student_id')) {
            $student = Student::findOrFail($request->student_id);
            $student->update($studentData);
        } else {
            $student = Student::updateOrCreate(
                [
                    'school_id' => $request->school_id,
                    'nis' => $request->nis,
                ],
                $studentData
            );
        }

        // Tautkan Guardian jika data orang tua terisi
        if (!empty($request->father_name) || !empty($request->guardian_name)) {
            $parentName = !empty($request->father_name) ? $request->father_name : $request->guardian_name;
            $guardian = Guardian::firstOrCreate(
                [
                    'full_name' => $parentName,
                ],
                [
                    'address' => $request->address ?: 'Ogan Ilir',
                    'relationship' => !empty($request->father_name) ? 'FATHER' : 'GUARDIAN',
                    'occupation' => $request->father_job ?: ($request->guardian_job ?: 'Wiraswasta'),
                    'phone' => $request->parent_phone ?: ('0812' . rand(10000000, 99999999)),
                ]
            );
            $student->guardian_id = $guardian->id;
            $student->save();
        }

        // Buat atau tautkan User Portal jika belum ada
        if (!$student->user_id) {
            $cleanNis = preg_replace('/[^A-Za-z0-9]/', '', $student->nis ?: 'S' . $student->id);
            $email = strtolower($cleanNis) . '@siswa.sitrobbani.sch.id';
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $student->full_name,
                    'password' => Hash::make('robbani123'),
                    'role' => 'STUDENT',
                    'school_id' => $request->school_id,
                    'is_active' => true,
                ]
            );
            $student->user_id = $user->id;
            $student->save();
        }

        return redirect()->route('admin.academic.grades', [
            'school_id' => $request->school_id,
            'classroom_id' => $request->classroom_id,
            'menu' => 'students'
        ])->with('success', "✓ Data Siswa {$request->full_name} (NIS: {$request->nis}) berhasil disimpan & profil data diri diperbarui!");
    }

    /**
     * Hapus Siswa oleh Kepsek / Operator
     */
    public function deleteStudent($studentId, Request $request)
    {
        $student = Student::findOrFail($studentId);
        $schoolId = $student->school_id;
        $name = $student->full_name;
        $student->delete();

        return redirect()->route('admin.academic.grades', [
            'school_id' => $schoolId,
            'menu' => 'students'
        ])->with('success', "Data Siswa {$name} berhasil dihapus dari sistem.");
    }

    /**
     * Sinkronisasi Siswa dari Data Master ke Unit e-Rapor
     */
    public function syncMasterStudents(Request $request)
    {
        $schoolId = $request->input('school_id');
        $school = School::findOrFail($schoolId);

        // 1. Auto-heal: jika siswa punya rombel yang sekolahnya adalah unit ini, update school_id siswa ke unit ini
        $unitClassroomIds = Classroom::where('school_id', $schoolId)->pluck('id');
        Student::whereIn('classroom_id', $unitClassroomIds)
            ->where('school_id', '!=', $schoolId)
            ->update(['school_id' => $schoolId]);

        // 2. Perbaiki mismatch global
        $allMismatches = Student::with('classroom')->whereNotNull('classroom_id')->get();
        foreach ($allMismatches as $st) {
            if ($st->classroom && $st->classroom->school_id && $st->school_id != $st->classroom->school_id) {
                $st->update(['school_id' => $st->classroom->school_id]);
            }
        }

        // 3. Normalisasi status siswa di unit ini agar selalu ACTIVE
        Student::where('school_id', $schoolId)
            ->where(function($q) {
                $q->whereNull('status')->orWhere('status', '')->orWhere('status', 'aktif');
            })
            ->update(['status' => 'ACTIVE']);

        // 4. Hitung total siswa di unit ini
        $totalInUnit = Student::where('school_id', $schoolId)->count();
        $inRombel = Student::where('school_id', $schoolId)->whereNotNull('classroom_id')->count();
        $noRombel = $totalInUnit - $inRombel;

        $msg = "✓ Sinkronisasi berhasil! Ditemukan {$totalInUnit} siswa pada unit {$school->name} ({$inRombel} sudah terdaftar di Rombel" . ($noRombel > 0 ? ", {$noRombel} siswa belum masuk Rombel" : "") . ").";

        return redirect()->route('admin.academic.grades', [
            'school_id' => $schoolId,
            'menu' => 'students'
        ])->with('success', $msg);
    }

    /**
     * Sinkronisasi Dua Arah: Tarik/Kirim Data Siswa E-Rapor ke Data Master Siswa
     */
    public function pushStudentsToMaster(Request $request)
    {
        $schoolId = $request->input('school_id');
        $school = School::findOrFail($schoolId);
        
        $students = Student::where('school_id', $schoolId)->get();
        $syncedCount = 0;
        $createdUserCount = 0;

        foreach ($students as $st) {
            // Normalisasi status siswa aktif
            if (empty($st->status) || strtolower($st->status) === 'aktif') {
                $st->status = 'ACTIVE';
            }

            // Hubungkan akun User Portal Siswa jika belum ada
            if (!$st->user_id) {
                $cleanNis = preg_replace('/[^A-Za-z0-9]/', '', $st->nis ?: 'S' . $st->id);
                $email = strtolower($cleanNis) . '@siswa.sitrobbani.sch.id';
                
                $user = User::firstOrCreate(
                    ['email' => $email],
                    [
                        'name' => $st->full_name,
                        'password' => Hash::make('robbani123'),
                        'role' => 'STUDENT',
                        'school_id' => $schoolId,
                        'is_active' => true,
                    ]
                );
                $st->user_id = $user->id;
                $createdUserCount++;
            }

            // Hubungkan Guardian jika ada data orang tua
            if (!$st->guardian_id && (!empty($st->father_name) || !empty($st->guardian_name))) {
                $parentName = !empty($st->father_name) ? $st->father_name : $st->guardian_name;
                $guardian = Guardian::firstOrCreate(
                    [
                        'full_name' => $parentName,
                    ],
                    [
                        'address' => $st->address ?: 'Ogan Ilir',
                        'relationship' => !empty($st->father_name) ? 'FATHER' : 'GUARDIAN',
                        'occupation' => $st->father_job ?: ($request->guardian_job ?: 'Wiraswasta'),
                        'phone' => '0812' . rand(10000000, 99999999),
                    ]
                );
                $st->guardian_id = $guardian->id;
            }

            $st->save();
            $syncedCount++;
        }

        $msg = "✓ Berhasil menyinkronkan {$syncedCount} siswa e-Rapor ke Data Master Siswa!" . ($createdUserCount > 0 ? " ({$createdUserCount} akun portal siswa baru dibuat)." : "");

        return redirect()->route('admin.academic.grades', [
            'school_id' => $schoolId,
            'menu' => 'students'
        ])->with('success', $msg);
    }

    /**
     * Unduh Template CSV Import Siswa
     */
    public function downloadStudentTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="Template_Import_Siswa.csv"',
        ];

        $callback = function () {
            $output = fopen('php://output', 'w');
            fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM
            fputcsv($output, ['NIS', 'NISN', 'Nama_Lengkap', 'Jenis_Kelamin_L_P', 'Nama_Rombel']);
            fputcsv($output, ['SMP-2026-0099', '0099123456', 'Ahmad Demo Siswa', 'L', 'Kelas 7A Tahfidz Unggulan']);
            fputcsv($output, ['SMP-2026-0100', '0099123457', 'Fatimah Az-Zahra', 'P', 'Kelas 7A Tahfidz Unggulan']);
            fclose($output);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Import Data Siswa dari File CSV
     */
    public function importStudents(Request $request)
    {
        $request->validate([
            'school_id' => 'required|exists:schools,id',
            'csv_file' => 'required|file|mimes:csv,txt|max:5120',
        ]);

        $schoolId = $request->input('school_id');
        $file = $request->file('csv_file');
        $handle = fopen($file->getRealPath(), 'r');
        
        $header = fgetcsv($handle);
        $count = 0;

        while (($row = fgetcsv($handle)) !== false) {
            if (empty($row[0]) || empty($row[2])) continue;
            $nis = trim($row[0]);
            $nisn = !empty($row[1]) ? trim($row[1]) : null;
            $name = trim($row[2]);
            $gender = strtoupper(trim($row[3] ?? 'L'));
            if (!in_array($gender, ['L', 'P', 'M', 'F'])) $gender = 'L';
            if ($gender === 'M') $gender = 'L';
            if ($gender === 'F') $gender = 'P';

            $classroomName = !empty($row[4]) ? trim($row[4]) : null;
            $classroomId = null;
            if ($classroomName) {
                $cls = Classroom::firstOrCreate(
                    ['school_id' => $schoolId, 'name' => $classroomName],
                    ['capacity' => 30, 'level_id' => 1]
                );
                $classroomId = $cls->id;
            }

            Student::updateOrCreate(
                ['school_id' => $schoolId, 'nis' => $nis],
                [
                    'nisn' => $nisn,
                    'full_name' => $name,
                    'gender' => $gender,
                    'classroom_id' => $classroomId,
                    'status' => 'ACTIVE',
                ]
            );
            $count++;
        }
        fclose($handle);

        return redirect()->route('admin.academic.grades', [
            'school_id' => $schoolId,
            'menu' => 'students',
        ])->with('success', "Alhamdulillah! Berhasil mengimpor {$count} data siswa ke sistem.");
    }

    /**
     * Hapus Rombel oleh Kepsek / Operator
     */
    public function deleteClassroom($classroomId, Request $request)
    {
        $cls = Classroom::findOrFail($classroomId);
        $schoolId = $cls->school_id;
        $name = $cls->name;
        $stCount = Student::where('classroom_id', $classroomId)->count();
        Student::where('classroom_id', $classroomId)->update(['classroom_id' => null]);
        $cls->delete();

        $msg = "✓ Rombel {$name} berhasil dihapus.";
        if ($stCount > 0) {
            $msg .= " Sebanyak {$stCount} siswa telah dialihkan ke status 'Belum Masuk Rombel'.";
        }

        return redirect()->route('admin.academic.grades', [
            'school_id' => $schoolId,
            'menu' => 'classrooms'
        ])->with('success', $msg);
    }

    /**
     * Upload Tanda Tangan Wali Kelas per Rombel
     */
    public function uploadHomeroomSignature($classroomId, Request $request)
    {
        $request->validate([
            'homeroom_signature' => 'required|image|mimes:png,jpg,jpeg,webp|max:2048',
        ]);

        $classroom = Classroom::findOrFail($classroomId);
        $file = $request->file('homeroom_signature');
        $filename = 'ttd_walas_' . $classroomId . '_' . time() . '.' . $file->getClientOriginalExtension();
        $dest = public_path('uploads/signatures');
        if (!file_exists($dest)) {
            mkdir($dest, 0755, true);
        }
        $file->move($dest, $filename);

        $classroom->homeroom_signature_path = '/uploads/signatures/' . $filename;
        $classroom->save();

        return redirect()->route('admin.academic.grades', [
            'school_id' => $classroom->school_id,
            'menu' => 'classrooms',
        ])->with('success', "Tanda tangan digital Wali Kelas untuk {$classroom->name} berhasil disimpan!");
    }

    /**
     * Simpan / Tambah / Update Mata Pelajaran
     */
    public function saveSubject(Request $request)
    {
        $request->validate([
            'school_id' => 'required|exists:schools,id',
            'code' => 'required|string|max:30',
            'name' => 'required|string|max:255',
            'passing_grade' => 'nullable|numeric|min:0|max:100',
        ]);

        $subject = Subject::updateOrCreate(
            [
                'id' => $request->subject_id,
            ],
            [
                'school_id' => $request->school_id,
                'code' => strtoupper($request->code),
                'name' => $request->name,
                'category' => $request->category ?? 'Kelompok A (Umum)',
                'passing_grade' => $request->passing_grade ?: 75,
            ]
        );

        return redirect()->route('admin.academic.grades', [
            'school_id' => $request->school_id,
            'menu' => 'subjects',
        ])->with('success', "Mata Pelajaran {$subject->name} ({$subject->code}) Berhasil Disimpan!");
    }

    /**
     * Hapus Mata Pelajaran
     */
    public function deleteSubject($subjectId, Request $request)
    {
        $sub = Subject::findOrFail($subjectId);
        $schoolId = $sub->school_id;
        $name = $sub->name;
        $sub->delete();

        return redirect()->route('admin.academic.grades', [
            'school_id' => $schoolId,
            'menu' => 'subjects',
        ])->with('success', "Mata Pelajaran {$name} berhasil dihapus.");
    }

    /**
     * Unduh Template CSV Mata Pelajaran
     */
    public function downloadSubjectTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="Template_Import_Mapel.csv"',
        ];

        $callback = function () {
            $output = fopen('php://output', 'w');
            fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($output, ['Kode_Mapel', 'Nama_Mata_Pelajaran', 'Kelompok_Kurikulum', 'KKTP_KKM']);
            fputcsv($output, ['PAI-01', 'Pendidikan Agama Islam & Budi Pekerti', 'Kelompok A (Umum)', '75']);
            fputcsv($output, ['TQ-01', 'Tahsin & Tahfidz Al-Qur\'an', 'Muatan Khusus JSIT', '80']);
            fputcsv($output, ['MTK-01', 'Matematika', 'Kelompok A (Umum)', '75']);
            fclose($output);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Import Data Mapel dari File CSV
     */
    public function importSubjects(Request $request)
    {
        $request->validate([
            'school_id' => 'required|exists:schools,id',
            'csv_file' => 'required|file|mimes:csv,txt|max:5120',
        ]);

        $schoolId = $request->input('school_id');
        $file = $request->file('csv_file');
        $handle = fopen($file->getRealPath(), 'r');
        
        $header = fgetcsv($handle);
        $count = 0;

        while (($row = fgetcsv($handle)) !== false) {
            if (empty($row[0]) || empty($row[1])) continue;
            $code = strtoupper(trim($row[0]));
            $name = trim($row[1]);
            $category = !empty($row[2]) ? trim($row[2]) : 'Kelompok A (Umum)';
            $kktp = !empty($row[3]) ? (float) $row[3] : 75;

            Subject::updateOrCreate(
                ['school_id' => $schoolId, 'code' => $code],
                [
                    'name' => $name,
                    'category' => $category,
                    'passing_grade' => $kktp,
                ]
            );
            $count++;
        }
        fclose($handle);

        return redirect()->route('admin.academic.grades', [
            'school_id' => $schoolId,
            'menu' => 'subjects',
        ])->with('success', "Alhamdulillah! Berhasil mengimpor {$count} mata pelajaran.");
    }

    /**
     * Simpan / Tambah / Update Tujuan Pembelajaran (TP) Kurikulum Merdeka
     */
    public function saveLearningObjective(Request $request)
    {
        $request->validate([
            'school_id' => 'required|exists:schools,id',
            'subject_id' => 'required|exists:subjects,id',
            'code' => 'required|string|max:30',
            'short_desc' => 'required|string|max:255',
        ]);

        $tp = LearningObjective::updateOrCreate(
            ['id' => $request->id],
            [
                'school_id' => $request->school_id,
                'subject_id' => $request->subject_id,
                'academic_year_id' => $request->academic_year_id,
                'grade_level' => $request->grade_level ?? 'Semua',
                'code' => strtoupper(trim($request->code)),
                'short_desc' => trim($request->short_desc),
                'description' => trim($request->description ?? $request->short_desc),
                'semester' => $request->semester ?? 'Genap',
                'order_number' => (int)($request->order_number ?: 1),
                'is_active' => $request->has('is_active') ? (bool)$request->is_active : true,
            ]
        );

        return redirect()->route('admin.academic.grades', [
            'school_id' => $request->school_id,
            'menu' => 'tp',
            'subject_id' => $request->subject_id,
        ])->with('success', "Tujuan Pembelajaran ({$tp->code}) Berhasil Disimpan!");
    }

    /**
     * Hapus Tujuan Pembelajaran (TP)
     */
    public function deleteLearningObjective($id, Request $request)
    {
        $tp = LearningObjective::findOrFail($id);
        $schoolId = $tp->school_id;
        $subjectId = $tp->subject_id;
        $code = $tp->code;
        $tp->delete();

        return redirect()->route('admin.academic.grades', [
            'school_id' => $schoolId,
            'menu' => 'tp',
            'subject_id' => $subjectId,
        ])->with('success', "Tujuan Pembelajaran {$code} berhasil dihapus.");
    }

    /**
     * Seed Paket Template Standar TP Kurikulum Merdeka Kemendikbudristek
     */
    public function seedDefaultLearningObjectives(Request $request)
    {
        $schoolId = $request->input('school_id', auth()->user()?->getEffectiveSchoolId() ?? 1);
        $activeAy = AcademicYear::where('is_active', true)->first();
        $seededCount = self::seedDefaultTPForSchool((int)$schoolId, $activeAy?->id);

        return redirect()->route('admin.academic.grades', [
            'school_id' => $schoolId,
            'menu' => 'tp',
            'subject_id' => $request->subject_id,
        ])->with('success', "Alhamdulillah! Berhasil men-generate {$seededCount} Tujuan Pembelajaran standar Kurikulum Merdeka!");
    }

    /**
     * Helper Seeder Paket TP Standar Kurikulum Merdeka
     */
    public static function seedDefaultTPForSchool(int $schoolId, ?int $academicYearId = null): int
    {
        self::ensureExtendedTablesExist();

        $subjects = Subject::where('school_id', $schoolId)->orWhereNull('school_id')->get();
        if ($subjects->isEmpty()) {
            $subjects = Subject::all();
        }

        $templates = [
            'PAI' => [
                ['code' => 'TP 1', 'short' => 'memahami pesan pokok Surah Al-Fatihah dan surah pendek', 'desc' => 'Peserta didik mampu memahami dan melafalkan pesan pokok Surah Al-Fatihah dan surah-surah pendek pilihan dengan tartil.'],
                ['code' => 'TP 2', 'short' => 'mengenal Asmaul Husna dan rukun iman', 'desc' => 'Peserta didik mampu mengenal dan meneladani Asmaul Husna serta rukun iman dalam kehidupan sehari-hari.'],
                ['code' => 'TP 3', 'short' => 'mempraktikkan thaharah dan sholat fardhu berjamaah', 'desc' => 'Peserta didik mampu mempraktikkan tata cara bersuci (thaharah), sholat fardhu berjamaah, dan adab islami.'],
                ['code' => 'TP 4', 'short' => 'meneladani kisah keteladanan Nabi dan Rasul', 'desc' => 'Peserta didik mampu menceritakan dan meneladani akhlak mulia Nabi dan Rasul Allah SWT.']
            ],
            'PPKN' => [
                ['code' => 'TP 1', 'short' => 'memahami arti simbol dan sila-sila Pancasila', 'desc' => 'Peserta didik mampu memahami arti dan makna simbol sila-sila Pancasila serta penerapannya di lingkungan sekolah dan rumah.'],
                ['code' => 'TP 2', 'short' => 'mengidentifikasi aturan dan norma yang berlaku', 'desc' => 'Peserta didik mampu mengidentifikasi dan menaati aturan serta norma yang berlaku dalam musyawarah bersama.'],
                ['code' => 'TP 3', 'short' => 'menghargai keberagaman suku dan budaya', 'desc' => 'Peserta didik mampu menghargai dan merawat kerukunan di tengah keberagaman suku, agama, dan budaya.'],
                ['code' => 'TP 4', 'short' => 'mempraktikkan sikap gotong royong dan tolong-menolong', 'desc' => 'Peserta didik mampu menunjukkan perilaku gotong royong dan saling tolong-menolong sesama warga sekolah.']
            ],
            'BIND' => [
                ['code' => 'TP 1', 'short' => 'menyimak dan memahami informasi dari teks lisan', 'desc' => 'Peserta didik mampu menyimak dengan saksama dan memahami ide pokok serta informasi penting dari teks lisan.'],
                ['code' => 'TP 2', 'short' => 'membaca lancar dengan lafal dan intonasi tepat', 'desc' => 'Peserta didik mampu membaca teks narasi dan deskripsi dengan lancar, intonasi tepat, serta memahami kosakata baru.'],
                ['code' => 'TP 3', 'short' => 'menyampaikan gagasan dan pendapat secara santun', 'desc' => 'Peserta didik mampu menyampaikan ide, perasaan, dan tanggapan secara lisan dengan santun dan percaya diri.'],
                ['code' => 'TP 4', 'short' => 'menulis paragraf deskriptif dengan ejaan benar', 'desc' => 'Peserta didik mampu menulis kalimat dan paragraf sederhana sesuai kaidah ejaan bahasa Indonesia yang baik.']
            ],
            'MTK' => [
                ['code' => 'TP 1', 'short' => 'memahami konsep bilangan cacah dan nilai tempat', 'desc' => 'Peserta didik mampu membaca, menulis, menentukan nilai tempat, dan membandingkan bilangan cacah.'],
                ['code' => 'TP 2', 'short' => 'melakukan operasi hitung penjumlahan dan pengurangan', 'desc' => 'Peserta didik mampu menyelesaikan masalah sehari-hari yang berkaitan dengan operasi hitung penjumlahan dan pengurangan.'],
                ['code' => 'TP 3', 'short' => 'mengidentifikasi bangun datar dan bangun ruang', 'desc' => 'Peserta didik mampu mengenal, mengelompokkan, dan mendeskripsikan ciri-ciri bangun datar dan bangun ruang.'],
                ['code' => 'TP 4', 'short' => 'mengumpulkan dan menyajikan data sederhana', 'desc' => 'Peserta didik mampu mengumpulkan, menyajikan, dan menafsirkan data dalam bentuk tabel atau diagram batang.']
            ],
            'IPA' => [
                ['code' => 'TP 1', 'short' => 'mengidentifikasi bagian tubuh makhluk hidup dan fungsinya', 'desc' => 'Peserta didik mampu menganalisis hubungan antara bentuk dan fungsi bagian tubuh tumbuhan serta hewan.'],
                ['code' => 'TP 2', 'short' => 'menganalisis interaksi antar komponen dalam ekosistem', 'desc' => 'Peserta didik mampu memahami rantai makanan dan keseimbangan ekosistem di lingkungan sekitar.'],
                ['code' => 'TP 3', 'short' => 'memahami wujud zat dan perubahan bentuk energi', 'desc' => 'Peserta didik mampu mengidentifikasi wujud benda serta pemanfaatan perubahan energi dalam kehidupan.'],
                ['code' => 'TP 4', 'short' => 'melakukan pengamatan ilmiah sederhana', 'desc' => 'Peserta didik mampu merancang penyelidikan ilmiah sederhana, mencatat data, dan menarik kesimpulan.']
            ],
            'IPS' => [
                ['code' => 'TP 1', 'short' => 'memahami kenampakan alam dan potensi lingkungan', 'desc' => 'Peserta didik mampu menjelaskan kenampakan alam dan buatan serta dampaknya terhadap mata pencaharian.'],
                ['code' => 'TP 2', 'short' => 'menganalisis kegiatan ekonomi dan peran pelaku usaha', 'desc' => 'Peserta didik mampu mengidentifikasi aktivitas produksi, distribusi, dan konsumsi masyarakat.'],
                ['code' => 'TP 3', 'short' => 'menghargai peninggalan sejarah dan kearifan lokal', 'desc' => 'Peserta didik mampu menceritakan peninggalan sejarah dan melestarikan kearifan lokal daerah.'],
                ['code' => 'TP 4', 'short' => 'menjaga kelestarian lingkungan dan sumber daya alam', 'desc' => 'Peserta didik mampu mengusulkan tindakan nyata dalam melestarikan sumber daya alam sekitar.']
            ],
            'BING' => [
                ['code' => 'TP 1', 'short' => 'merespons ungkapan sapaan dan instruksi lisan', 'desc' => 'Peserta didik mampu memahami dan merespons sapaan (*greeting*), salam perpisahan, dan instruksi kelas sederhana.'],
                ['code' => 'TP 2', 'short' => 'memahami teks deskripsi pendek tentang benda dan keluarga', 'desc' => 'Peserta didik mampu membaca dan mengidentifikasi informasi penting dari teks deskripsi pendek bahasa Inggris.'],
                ['code' => 'TP 3', 'short' => 'berinteraksi lisan sederhana tentang hobi dan lingkungan', 'desc' => 'Peserta didik mampu berkomunikasi lisan menggunakan kalimat deklaratif dan tanya sederhana.'],
                ['code' => 'TP 4', 'short' => 'menulis kata dan frasa bahasa Inggris dengan ejaan tepat', 'desc' => 'Peserta didik mampu menyusun kata dan kalimat sederhana dengan ejaan dan tanda baca yang tepat.']
            ],
            'PJOK' => [
                ['code' => 'TP 1', 'short' => 'mempraktikkan gerak dasar lokomotor dan non-lokomotor', 'desc' => 'Peserta didik mampu mempraktikkan kombinasi gerak dasar lokomotor, non-lokomotor, dan manipulatif dengan benar.'],
                ['code' => 'TP 2', 'short' => 'memahami sportivitas dalam permainan olahraga', 'desc' => 'Peserta didik mampu menerapkan aturan keselamatan, sportivitas, dan kerja sama dalam permainan tim.'],
                ['code' => 'TP 3', 'short' => 'menerapkan kebiasaan hidup bersih dan menjaga kebugaran', 'desc' => 'Peserta didik mampu menjelaskan pentingnya menjaga kebersihan tubuh, pola istirahat, dan gizi seimbang.']
            ],
            'SBK' => [
                ['code' => 'TP 1', 'short' => 'mengenal unsur seni rupa, nada, dan gerak pertunjukan', 'desc' => 'Peserta didik mampu mengidentifikasi unsur garis, bentuk, warna, irama musik, dan pola gerak ekspresif.'],
                ['code' => 'TP 2', 'short' => 'mengeksplorasi pembuatan karya seni kreatif', 'desc' => 'Peserta didik mampu menciptakan karya seni rupa atau gerak pertunjukan dengan memanfaatkan bahan sekitar.'],
                ['code' => 'TP 3', 'short' => 'mengapresiasi keindahan karya seni tradisional dan islami', 'desc' => 'Peserta didik mampu mengapresiasi dan menjelaskan makna karya seni budaya lokal nusantara.']
            ],
            'INF' => [
                ['code' => 'TP 1', 'short' => 'memahami perangkat keras dan lunak komputer', 'desc' => 'Peserta didik mampu mengidentifikasi komponen teknologi informasi dan komunikasi serta fungsinya.'],
                ['code' => 'TP 2', 'short' => 'menerapkan berpikir komputasional dalam logika sederhana', 'desc' => 'Peserta didik mampu memecahkan masalah melalui pola logika, dekomposisi, dan algoritma sederhana.'],
                ['code' => 'TP 3', 'short' => 'memahami etika digital dan keamanan data pribadi', 'desc' => 'Peserta didik mampu menerapkan tata krama bermedia digital dan menjaga kerahasiaan data pribadi.']
            ],
            'HADIST' => [
                ['code' => 'TP 1', 'short' => 'menghafal hadist pilihan tentang niat dan akhlak mulia', 'desc' => 'Peserta didik mampu menghafal matan dan terjemahan hadist tentang niat, menuntut ilmu, dan berbakti kepada orang tua.'],
                ['code' => 'TP 2', 'short' => 'mengamalkan kandungan hadist dalam pembiasaan harian', 'desc' => 'Peserta didik mampu meneladani dan membiasakan akhlak mulia sebagaimana dicontohkan Rasulullah SAW.']
            ],
            'ARAB' => [
                ['code' => 'TP 1', 'short' => 'melafalkan mufrodat perkenalan dan benda di sekolah', 'desc' => 'Peserta didik mampu melafalkan mufrodat perkenalan (*ta\'aruf*), benda kelas, dan anggota keluarga dengan makhraj fasih.'],
                ['code' => 'TP 2', 'short' => 'mempraktikkan percakapan sederhana bahasa Arab', 'desc' => 'Peserta didik mampu melakukan tanya jawab sederhana dalam bahasa Arab dengan intonasi yang baik.']
            ],
        ];

        $totalSeeded = 0;
        foreach ($subjects as $sb) {
            $codeUpper = strtoupper($sb->code ?? '');
            $nameUpper = strtoupper($sb->name ?? '');

            $matchedTemplate = null;
            if (str_contains($codeUpper, 'PAI') || str_contains($nameUpper, 'AGAMA') || str_contains($nameUpper, 'ISLAM')) {
                $matchedTemplate = $templates['PAI'];
            } elseif (str_contains($codeUpper, 'PKN') || str_contains($codeUpper, 'PPKN') || str_contains($nameUpper, 'PANCASILA')) {
                $matchedTemplate = $templates['PPKN'];
            } elseif (str_contains($codeUpper, 'BIN') || str_contains($nameUpper, 'INDONESIA')) {
                $matchedTemplate = $templates['BIND'];
            } elseif (str_contains($codeUpper, 'MTK') || str_contains($nameUpper, 'MATEMATIKA')) {
                $matchedTemplate = $templates['MTK'];
            } elseif (str_contains($codeUpper, 'IPA') || str_contains($nameUpper, 'ALAM')) {
                $matchedTemplate = $templates['IPA'];
            } elseif (str_contains($codeUpper, 'IPS') || str_contains($nameUpper, 'SOSIAL')) {
                $matchedTemplate = $templates['IPS'];
            } elseif (str_contains($codeUpper, 'BIG') || str_contains($codeUpper, 'BING') || str_contains($nameUpper, 'INGGRIS')) {
                $matchedTemplate = $templates['BING'];
            } elseif (str_contains($codeUpper, 'PJOK') || str_contains($nameUpper, 'JASMANI') || str_contains($nameUpper, 'OLAHRAGA')) {
                $matchedTemplate = $templates['PJOK'];
            } elseif (str_contains($codeUpper, 'SBK') || str_contains($codeUpper, 'SENI') || str_contains($nameUpper, 'SENI') || str_contains($nameUpper, 'TARI') || str_contains($nameUpper, 'TEATER')) {
                $matchedTemplate = $templates['SBK'];
            } elseif (str_contains($codeUpper, 'INF') || str_contains($codeUpper, 'KKA') || str_contains($nameUpper, 'INFORMATIKA') || str_contains($nameUpper, 'KODING')) {
                $matchedTemplate = $templates['INF'];
            } elseif (str_contains($codeUpper, 'HADIST') || str_contains($nameUpper, 'HADIST')) {
                $matchedTemplate = $templates['HADIST'];
            } elseif (str_contains($codeUpper, 'ARAB') || str_contains($nameUpper, 'ARAB')) {
                $matchedTemplate = $templates['ARAB'];
            } else {
                $matchedTemplate = [
                    ['code' => 'TP 1', 'short' => 'memahami konsep dasar dan materi pokok ' . $sb->name, 'desc' => 'Peserta didik mampu memahami prinsip, definisi, dan konsep utama materi ' . $sb->name . ' dengan baik.'],
                    ['code' => 'TP 2', 'short' => 'menerapkan keterampilan praktis dan analisis dalam ' . $sb->name, 'desc' => 'Peserta didik mampu mengaplikasikan pemahaman materi untuk memecahkan persoalan kontekstual.'],
                    ['code' => 'TP 3', 'short' => 'mengevaluasi dan menyajikan hasil belajar ' . $sb->name, 'desc' => 'Peserta didik mampu menyajikan hasil karya dan evaluasi pemahaman materi dengan mandiri dan bertanggung jawab.']
                ];
            }

            if ($matchedTemplate) {
                foreach ($matchedTemplate as $idx => $tpData) {
                    LearningObjective::updateOrCreate(
                        [
                            'school_id' => $schoolId,
                            'subject_id' => $sb->id,
                            'code' => $tpData['code'],
                        ],
                        [
                            'academic_year_id' => $academicYearId,
                            'grade_level' => 'Semua',
                            'short_desc' => $tpData['short'],
                            'description' => $tpData['desc'],
                            'semester' => 'Genap',
                            'order_number' => $idx + 1,
                            'is_active' => true,
                        ]
                    );
                    $totalSeeded++;
                }
            }
        }

        return $totalSeeded;
    }

    /**
     * Simpan / Tambah / Update Ekstrakurikuler
     */
    public function saveExtracurricular(Request $request)
    {
        $request->validate([
            'school_id' => 'required|exists:schools,id',
            'name' => 'required|string|max:255',
        ]);

        $ekskul = \App\Models\Extracurricular::updateOrCreate(
            ['id' => $request->id],
            [
                'school_id' => $request->school_id,
                'name' => $request->name,
                'coach_name' => $request->coach_name,
                'description' => $request->description,
                'is_active' => true,
            ]
        );

        return redirect()->route('admin.academic.grades', [
            'school_id' => $request->school_id,
            'menu' => 'extracurriculars',
        ])->with('success', "Ekstrakurikuler {$ekskul->name} Berhasil Disimpan!");
    }

    /**
     * Hapus Ekstrakurikuler
     */
    public function deleteExtracurricular($id, Request $request)
    {
        $ekskul = \App\Models\Extracurricular::findOrFail($id);
        $schoolId = $ekskul->school_id;
        $name = $ekskul->name;
        $ekskul->delete();

        return redirect()->route('admin.academic.grades', [
            'school_id' => $schoolId,
            'menu' => 'extracurriculars',
        ])->with('success', "Ekstrakurikuler {$name} berhasil dihapus.");
    }

    /**
     * Simpan / Tambah / Update Projek P5 / Kokurikuler
     */
    public function saveProjectP5(Request $request)
    {
        $request->validate([
            'school_id' => 'required|exists:schools,id',
            'theme' => 'required|string|max:255',
            'title' => 'required|string|max:255',
        ]);

        $dims = $request->target_dimensions;
        if (is_string($dims)) {
            $dims = array_map('trim', explode(',', $dims));
        }

        $p5 = \App\Models\P5Project::updateOrCreate(
            ['id' => $request->id],
            [
                'school_id' => $request->school_id,
                'classroom_id' => $request->classroom_id ?: null,
                'academic_year_id' => $request->academic_year_id ?: null,
                'theme' => $request->theme,
                'title' => $request->title,
                'description' => $request->description,
                'coordinator_name' => $request->coordinator_name,
                'target_dimensions' => $dims ?: ['Beriman & Berakhlak Mulia', 'Gotong Royong', 'Kreatif'],
            ]
        );

        return redirect()->route('admin.academic.grades', [
            'school_id' => $request->school_id,
            'menu' => 'p5',
        ])->with('success', "Projek Kokurikuler / P5 {$p5->title} Berhasil Disimpan!");
    }

    /**
     * Hapus Projek P5 / Kokurikuler
     */
    public function deleteProjectP5($id, Request $request)
    {
        $p5 = \App\Models\P5Project::findOrFail($id);
        $schoolId = $p5->school_id;
        $title = $p5->title;
        $p5->delete();

        return redirect()->route('admin.academic.grades', [
            'school_id' => $schoolId,
            'menu' => 'p5',
        ])->with('success', "Projek Kokurikuler / P5 {$title} berhasil dihapus.");
    }

    /**
     * Batch Store Nilai Mata Pelajaran 1 Kelas Sekaligus (Guru Mapel)
     */
    public function batchStoreGrades(Request $request)
    {
        $academicYearId = $request->academic_year_id ?? AcademicYear::where('is_active', 1)->first()?->id ?? AcademicYear::first()?->id;

        $request->validate([
            'school_id' => 'required',
            'classroom_id' => 'required|exists:classrooms,id',
            'subject_id' => 'required|exists:subjects,id',
            'grades' => 'required|array',
        ]);

        $savedCount = 0;
        foreach ($request->grades as $studentId => $data) {
            $score = null;
            if (isset($data['score']) && $data['score'] !== '') {
                $score = (float) $data['score'];
            } elseif (isset($data['score_sas']) && $data['score_sas'] !== '' && isset($data['score_tp']) && $data['score_tp'] !== '') {
                $score = round(((float)$data['score_tp'] + (float)$data['score_sas']) / 2, 1);
            } elseif (isset($data['score_sas']) && $data['score_sas'] !== '') {
                $score = (float) $data['score_sas'];
            } elseif (isset($data['score_tp']) && $data['score_tp'] !== '') {
                $score = (float) $data['score_tp'];
            }

            if (is_null($score)) continue;

            $notes = $data['notes'] ?? '';
            if (empty(trim($notes))) {
                if ($score >= 90) {
                    $notes = 'Menunjukkan penguasaan capaian pembelajaran yang sangat istimewa (Mumtaz) serta mampu bernalar kritis secara mandiri.';
                } elseif ($score >= 80) {
                    $notes = 'Menunjukkan penguasaan capaian pembelajaran yang amat baik dan aktif dalam pemecahan masalah.';
                } elseif ($score >= 70) {
                    $notes = 'Menunjukkan penguasaan capaian pembelajaran yang cukup baik, perlu sedikit penguatan pada materi lanjutan.';
                } else {
                    $notes = 'Memerlukan bimbingan dan remedial intensif untuk mencapai kriteria ketuntasan tujuan pembelajaran.';
                }
            }

            Grade::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'subject_id' => $request->subject_id,
                    'academic_year_id' => $academicYearId,
                ],
                [
                    'assessment_type' => $data['assessment_type'] ?? 'Sumatif Akhir Semester (SAS)',
                    'competency_code' => $data['competency_code'] ?? 'TP-MERDEKA',
                    'score' => $score,
                    'notes' => $notes,
                ]
            );
            $savedCount++;
        }

        try {
            \App\Models\AuditLog::create([
                'user_id' => auth()->id() ?? 1,
                'action' => 'BATCH NILAI MAPEL',
                'model_type' => 'Grade',
                'model_id' => $request->classroom_id,
                'ip_address' => request()->ip(),
            ]);
        } catch(\Throwable $e) {}

        return redirect()->route('admin.academic.grades', [
            'school_id' => $request->school_id,
            'classroom_id' => $request->classroom_id,
            'subject_id' => $request->subject_id,
            'menu' => 'academic'
        ])->with('success', "Berhasil menyimpan nilai untuk {$savedCount} siswa secara bersamaan!");
    }

    /**
     * Batch Store Nilai Al-Qur'an Metode Wafa & Tahfidz 1 Kelas Sekaligus
     */
    public function batchStoreQuran(Request $request)
    {
        $request->validate([
            'school_id' => 'required',
            'classroom_id' => 'required|exists:classrooms,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'quran' => 'required|array',
        ]);

        if ($request->filled('classroom_quran_teacher_name')) {
            try {
                $cls = \App\Models\Classroom::find($request->classroom_id);
                if ($cls) {
                    $cls->quran_teacher_name = $request->classroom_quran_teacher_name;
                    $cls->save();
                }
            } catch (\Throwable $e) {}
        }

        $savedCount = 0;
        foreach ($request->quran as $studentId => $data) {
            $makhraj = (isset($data['makhraj']) && is_numeric($data['makhraj'])) ? (float)$data['makhraj'] : null;
            $tajwid = (isset($data['tajwid']) && is_numeric($data['tajwid'])) ? (float)$data['tajwid'] : null;
            $lagu = (isset($data['lagu_hijaz']) && is_numeric($data['lagu_hijaz'])) ? (float)$data['lagu_hijaz'] : null;
            $adab = (isset($data['adab']) && is_numeric($data['adab'])) ? (float)$data['adab'] : null;

            $scores = [
                'makhraj' => $makhraj ?? 0,
                'tajwid' => $tajwid ?? 0,
                'lagu_hijaz' => $lagu ?? 0,
                'adab' => $adab ?? 0,
            ];

            $validScores = array_filter([$makhraj, $tajwid, $lagu, $adab], fn($v) => $v !== null);
            $finalScore = !empty($validScores) ? round(array_sum($validScores) / count($validScores), 1) : 0;

            $predicate = '-';
            if ($finalScore >= 90) $predicate = 'Mumtaz (Istimewa)';
            elseif ($finalScore >= 80) $predicate = 'Jayyid Jiddan (Sangat Baik)';
            elseif ($finalScore >= 70) $predicate = 'Jayyid (Baik)';
            elseif ($finalScore > 0) $predicate = 'Maqbul (Cukup)';

            QuranGrade::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'academic_year_id' => $request->academic_year_id,
                ],
                [
                    'tahsin_method' => $data['tahsin_method'] ?? 'Wafa',
                    'tahsin_level' => $data['tahsin_level'] ?? null,
                    'tahsin_scores' => $scores,
                    'tahsin_final_score' => $finalScore,
                    'tahsin_predicate' => $predicate,
                    'tahsin_notes' => $data['tahsin_notes'] ?? null,
                    'tahfidz_target' => $data['tahfidz_target'] ?? null,
                    'tahfidz_achievement' => $data['tahfidz_achievement'] ?? null,
                    'tahfidz_score' => (isset($data['tahfidz_score']) && is_numeric($data['tahfidz_score'])) ? (float)$data['tahfidz_score'] : null,
                    'tahfidz_predicate' => $data['tahfidz_predicate'] ?? null,
                    'tasmi_exam_result' => $data['tasmi_exam_result'] ?? null,
                    'tahfidz_notes' => $data['tahfidz_notes'] ?? null,
                    'quran_teacher_name' => $data['quran_teacher_name'] ?? $request->classroom_quran_teacher_name ?? null,
                    'quran_teacher_title' => $data['quran_teacher_title'] ?? $request->classroom_quran_teacher_title ?? null,
                ]
            );
            $savedCount++;
        }

        try {
            \App\Models\AuditLog::create([
                'user_id' => auth()->id() ?? 1,
                'action' => 'BATCH NILAI WAFA & TAHFIDZ',
                'model_type' => 'QuranGrade',
                'model_id' => $request->classroom_id,
                'ip_address' => request()->ip(),
            ]);
        } catch(\Throwable $e) {}

        return redirect()->route('admin.academic.grades', [
            'school_id' => $request->school_id,
            'classroom_id' => $request->classroom_id,
            'menu' => 'quran'
        ])->with('success', "Berhasil menyimpan penilaian Al-Qur'an (Metode Wafa & Tahfidz) untuk {$savedCount} siswa!");
    }

    /**
     * Batch Store Penilaian Karakter 7 SKL JSIT & BPI 1 Kelas Sekaligus
     */
    public function batchStoreCharacter(Request $request)
    {
        $request->validate([
            'school_id' => 'required',
            'classroom_id' => 'required|exists:classrooms,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'character' => 'required|array',
        ]);

        $savedCount = 0;
        foreach ($request->character as $studentId => $data) {
            $indicators = $data['indicators'] ?? [
                'salimul_aqidah' => 'SB',
                'shahihul_ibadah' => 'SB',
                'matinul_khuluq' => 'SB',
                'qowiyyul_jismi' => 'B',
                'mutsaqqoful_fikri' => 'SB',
                'qodirun_alal_kasbi' => 'B',
                'munazzhomun' => 'SB',
            ];

            CharacterGrade::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'academic_year_id' => $request->academic_year_id,
                ],
                [
                    'indicator_scores' => $indicators,
                    'mutabaah_sholat_fardhu' => $data['mutabaah_sholat_fardhu'] ?? 'Selalu Berjamaah di Masjid',
                    'mutabaah_sholat_dhuha' => $data['mutabaah_sholat_dhuha'] ?? 'Rutin Setiap Hari',
                    'mutabaah_tilawah' => $data['mutabaah_tilawah'] ?? 'Rutin 1/2 Juz per Hari',
                    'mutabaah_infaq' => $data['mutabaah_infaq'] ?? 'Rutin Infaq Jumat',
                    'bpi_mentor_notes' => $data['bpi_mentor_notes'] ?? 'Ananda menunjukkan profil karakter muslim tangguh dan istiqomah dalam ibadah yaumiyah.',
                ]
            );
            $savedCount++;
        }

        try {
            \App\Models\AuditLog::create([
                'user_id' => auth()->id() ?? 1,
                'action' => 'BATCH KARAKTER 7 SKL JSIT',
                'model_type' => 'CharacterGrade',
                'model_id' => $request->classroom_id,
                'ip_address' => request()->ip(),
            ]);
        } catch(\Throwable $e) {}

        return redirect()->route('admin.academic.grades', [
            'school_id' => $request->school_id,
            'classroom_id' => $request->classroom_id,
            'menu' => 'character'
        ])->with('success', "Berhasil menyimpan evaluasi Karakter 7 SKL JSIT & BPI untuk {$savedCount} siswa!");
    }

    /**
     * Batch Store Catatan Wali Kelas, Presensi & Kesehatan 1 Kelas Sekaligus
     */
    public function batchStoreHomeroom(Request $request)
    {
        $request->validate([
            'school_id' => 'required',
            'classroom_id' => 'required|exists:classrooms,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'homeroom' => 'required|array',
        ]);

        $savedCount = 0;
        foreach ($request->homeroom as $studentId => $data) {
            $ekskul = [];
            if (!empty($data['ekskul_name'])) {
                $ekskul[] = [
                    'name' => $data['ekskul_name'],
                    'score' => $data['ekskul_score'] ?? 'A',
                    'notes' => $data['ekskul_notes'] ?? 'Disiplin dan berjiwa ksatria',
                ];
            }

            HomeroomNote::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'academic_year_id' => $request->academic_year_id,
                ],
                [
                    'sick_count' => (int) ($data['sick_count'] ?? 0),
                    'permission_count' => (int) ($data['permission_count'] ?? 0),
                    'absent_count' => (int) ($data['absent_count'] ?? 0),
                    'height_cm' => !empty($data['height_cm']) ? (float)$data['height_cm'] : null,
                    'weight_kg' => !empty($data['weight_kg']) ? (float)$data['weight_kg'] : null,
                    'hearing_health' => $data['hearing_health'] ?? 'Sangat Baik / Normal',
                    'vision_health' => $data['vision_health'] ?? 'Sangat Baik / Normal',
                    'dental_health' => $data['dental_health'] ?? 'Bersih & Terawat',
                    'extracurriculars' => !empty($ekskul) ? $ekskul : null,
                    'notes' => $data['notes'] ?? 'Pertahankan prestasi ananda dan terus bersemangat menggapai cita-cita mulia.',
                ]
            );
            $savedCount++;
        }

        try {
            \App\Models\AuditLog::create([
                'user_id' => auth()->id() ?? 1,
                'action' => 'BATCH WALI KELAS & PRESENSI',
                'model_type' => 'HomeroomNote',
                'model_id' => $request->classroom_id,
                'ip_address' => request()->ip(),
            ]);
        } catch(\Throwable $e) {}

        return redirect()->route('admin.academic.grades', [
            'school_id' => $request->school_id,
            'classroom_id' => $request->classroom_id,
            'menu' => 'homeroom'
        ])->with('success', "Berhasil menyimpan rekap kehadiran dan catatan wali kelas untuk {$savedCount} siswa!");
    }

    public function storeGrade(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'type' => 'required|string',
            'score' => 'required|numeric|min:0|max:100',
            'notes' => 'nullable|string',
        ]);

        $score = (float) $request->score;
        $notes = $request->notes;
        if (empty($notes)) {
            if ($score >= 90) {
                $notes = 'Menunjukkan penguasaan capaian pembelajaran yang sangat istimewa (Mumtaz) dan mampu bernalar kritis secara mandiri.';
            } elseif ($score >= 80) {
                $notes = 'Menunjukkan penguasaan capaian pembelajaran yang amat baik dan aktif dalam pemecahan masalah.';
            } elseif ($score >= 70) {
                $notes = 'Menunjukkan penguasaan capaian pembelajaran yang cukup baik, perlu peningkatan pada materi lanjutan.';
            } else {
                $notes = 'Memerlukan bimbingan dan remedial berkelanjutan untuk mencapai ketuntasan tujuan pembelajaran.';
            }
        }

        $grd = Grade::updateOrCreate(
            [
                'student_id' => $request->student_id,
                'subject_id' => $request->subject_id,
                'academic_year_id' => $request->academic_year_id,
                'assessment_type' => $request->type,
            ],
            [
                'competency_code' => $request->competency_code ?? 'TP-MERDEKA',
                'score' => $score,
                'notes' => $notes,
            ]
        );

        try {
            \App\Models\AuditLog::create([
                'user_id' => auth()->id() ?? 1,
                'action' => 'PENILAIAN AKADEMIK',
                'model_type' => 'Grade',
                'model_id' => $grd->id,
                'ip_address' => request()->ip(),
            ]);
        } catch(\Throwable $e) {}

        return redirect()->back()->with('success', 'Nilai Akademik Siswa Berhasil Disimpan!');
    }

    public function destroyGrade($id)
    {
        $grade = Grade::with('student')->findOrFail($id);
        $schoolId = auth()->user()?->getEffectiveSchoolId();
        if ($schoolId && $grade->student && $grade->student->school_id != $schoolId) {
            return redirect()->back()->with('error', 'Akses ditolak: Anda tidak memiliki otoritas atas nilai siswa ini.');
        }

        $grade->delete();
        return redirect()->back()->with('success', '✓ Nilai siswa berhasil dihapus.');
    }

    public function storeQuranGrade(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'academic_year_id' => 'required|exists:academic_years,id',
        ]);

        $scores = $request->input('scores', []);
        $scoresFloat = array_filter(array_map(fn($v) => is_numeric($v) ? (float) $v : null, $scores), fn($v) => $v !== null);
        $finalScore = !empty($scoresFloat) ? round(array_sum($scoresFloat) / count($scoresFloat), 1) : ((float) $request->tahsin_final_score ?: 0);

        $predicate = '-';
        if ($finalScore >= 90) $predicate = 'Mumtaz (Istimewa)';
        elseif ($finalScore >= 80) $predicate = 'Jayyid Jiddan (Sangat Baik)';
        elseif ($finalScore >= 70) $predicate = 'Jayyid (Baik)';
        elseif ($finalScore > 0) $predicate = 'Maqbul (Cukup)';

        QuranGrade::updateOrCreate(
            [
                'student_id' => $request->student_id,
                'academic_year_id' => $request->academic_year_id,
            ],
            [
                'tahsin_method' => $request->tahsin_method ?? 'Wafa',
                'tahsin_level' => $request->tahsin_level ?? null,
                'tahsin_scores' => $scores,
                'tahsin_final_score' => $finalScore,
                'tahsin_predicate' => $request->tahsin_predicate ?? $predicate,
                'tahsin_notes' => $request->tahsin_notes ?? null,
                'tahfidz_target' => $request->tahfidz_target ?? null,
                'tahfidz_achievement' => $request->tahfidz_achievement ?? null,
                'tahfidz_score' => (isset($request->tahfidz_score) && is_numeric($request->tahfidz_score)) ? (float)$request->tahfidz_score : null,
                'tahfidz_predicate' => $request->tahfidz_predicate ?? null,
                'tasmi_exam_result' => $request->tasmi_exam_result ?? null,
                'tahfidz_notes' => $request->tahfidz_notes ?? null,
                'quran_teacher_name' => $request->quran_teacher_name ?? null,
                'quran_teacher_title' => $request->quran_teacher_title ?? null,
            ]
        );

        return redirect()->back()->with('success', 'Nilai Al-Qur\'an Metode Wafa & Tahfidz Berhasil Disimpan!');
    }

    public function storeCharacterGrade(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'academic_year_id' => 'required|exists:academic_years,id',
        ]);

        CharacterGrade::updateOrCreate(
            [
                'student_id' => $request->student_id,
                'academic_year_id' => $request->academic_year_id,
            ],
            [
                'indicator_scores' => $request->input('indicators', []),
                'mutabaah_sholat_fardhu' => $request->mutabaah_sholat_fardhu ?? 'Selalu Berjamaah di Masjid',
                'mutabaah_sholat_dhuha' => $request->mutabaah_sholat_dhuha ?? 'Rutin Setiap Hari',
                'mutabaah_tilawah' => $request->mutabaah_tilawah ?? 'Rutin 1/2 Juz per Hari',
                'mutabaah_infaq' => $request->mutabaah_infaq ?? 'Rutin Infaq Jumat',
                'bpi_mentor_notes' => $request->bpi_mentor_notes,
            ]
        );

        return redirect()->back()->with('success', 'Penilaian Karakter 7 SKL JSIT & Mutaba\'ah BPI Berhasil Disimpan!');
    }

    public function storeHomeroomNote(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'academic_year_id' => 'required|exists:academic_years,id',
        ]);

        $ekskul = [];
        if ($request->filled('ekskul_name')) {
            $ekskul[] = [
                'name' => $request->ekskul_name,
                'score' => $request->ekskul_score ?? 'A',
                'notes' => $request->ekskul_notes ?? 'Sangat Aktif & Berprestasi',
            ];
        }

        HomeroomNote::updateOrCreate(
            [
                'student_id' => $request->student_id,
                'academic_year_id' => $request->academic_year_id,
            ],
            [
                'sick_count' => (int) $request->sick_count,
                'permission_count' => (int) $request->permission_count,
                'absent_count' => (int) $request->absent_count,
                'height_cm' => $request->height_cm ?: null,
                'weight_kg' => $request->weight_kg ?: null,
                'hearing_health' => $request->hearing_health ?? 'Sangat Baik / Normal',
                'vision_health' => $request->vision_health ?? 'Sangat Baik / Normal',
                'dental_health' => $request->dental_health ?? 'Bersih & Terawat',
                'extracurriculars' => !empty($ekskul) ? $ekskul : null,
                'notes' => $request->notes ?? 'Pertahankan prestasi ananda dan terus bersemangat menggapai cita-cita.',
            ]
        );

        return redirect()->back()->with('success', 'Catatan Wali Kelas & Presensi Berhasil Disimpan!');
    }

    public function storeReportSettings(Request $request)
    {
        $request->validate([
            'school_id' => 'required|exists:schools,id',
            'school_logo_file' => 'nullable|file|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'kop_image_file' => 'nullable|file|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'stamp_image_file' => 'nullable|file|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'principal_signature_file' => 'nullable|file|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
        ]);

        $setting = ReportSetting::firstOrNew(['school_id' => $request->school_id]);
        $setting->kop_header_text = $request->kop_header_text;
        $setting->principal_name = $request->principal_name;
        $setting->principal_nip = $request->principal_nip;
        if ($request->has('quran_teacher_name')) $setting->quran_teacher_name = $request->quran_teacher_name;
        if ($request->has('quran_teacher_title')) $setting->quran_teacher_title = $request->quran_teacher_title;
        $setting->report_city = $request->report_city ?? 'Ogan Ilir';
        $setting->report_date = $request->report_date ?? '18 Juni 2026';
        if ($request->has('accreditation')) $setting->accreditation = $request->accreditation;
        if ($request->has('nss_nds')) $setting->nss_nds = $request->nss_nds;
        if ($request->has('signature_mode')) $setting->signature_mode = $request->signature_mode;

        // Opsi Kosongkan / Hapus File
        if ($request->boolean('clear_stamp') || $request->input('clear_stamp') == '1') {
            $setting->stamp_image_url = null;
        }
        if ($request->boolean('clear_signature') || $request->input('clear_signature') == '1') {
            $setting->principal_signature_url = null;
        }
        if ($request->boolean('clear_logo') || $request->input('clear_logo') == '1') {
            $setting->school_logo_url = null;
        }

        $destinationPath = public_path('uploads/reports');
        if (!file_exists($destinationPath)) {
            @mkdir($destinationPath, 0755, true);
        }

        // 1. Logo Sekolah / Yayasan
        if ($request->hasFile('school_logo_file')) {
            $file = $request->file('school_logo_file');
            $filename = 'logo_' . $request->school_id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
            $setting->school_logo_url = '/uploads/reports/' . $filename;
            $school = School::find($request->school_id);
            if ($school) {
                $school->logo_url = '/uploads/reports/' . $filename;
                $school->save();
            }
        } elseif ($request->filled('school_logo_url')) {
            $setting->school_logo_url = $request->school_logo_url;
            $school = School::find($request->school_id);
            if ($school) {
                $school->logo_url = $request->school_logo_url;
                $school->save();
            }
        }

        // 2. Kop Header Image
        if ($request->hasFile('kop_image_file')) {
            $file = $request->file('kop_image_file');
            $filename = 'kop_' . $request->school_id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
            $setting->kop_image_url = '/uploads/reports/' . $filename;
        } elseif ($request->filled('kop_image_url')) {
            $setting->kop_image_url = $request->kop_image_url;
        }

        // 3. Stempel Resmi Sekolah
        if ($request->hasFile('stamp_image_file')) {
            $file = $request->file('stamp_image_file');
            $filename = 'stamp_' . $request->school_id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
            $setting->stamp_image_url = '/uploads/reports/' . $filename;
        } elseif ($request->filled('stamp_image_url')) {
            $setting->stamp_image_url = $request->stamp_image_url;
        }

        // 4. Tanda Tangan Digital Kepala Sekolah
        if ($request->hasFile('principal_signature_file')) {
            $file = $request->file('principal_signature_file');
            $filename = 'ttd_' . $request->school_id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
            $setting->principal_signature_url = '/uploads/reports/' . $filename;
        } elseif ($request->filled('principal_signature_url')) {
            $setting->principal_signature_url = $request->principal_signature_url;
        }

        $setting->save();

        return redirect()->route('admin.academic.grades', [
            'school_id' => $request->school_id,
            'menu' => 'settings'
        ])->with('success', 'Pengaturan Dokumen Rapor, Kop Surat, File Logo & Tanda Tangan Berhasil Disimpan!');
    }

    /**
     * Modul 2.3: Cetak Rapor Siswa SIT (Pilihan Terpisah, Gabungan All-in-One & Leger)
     */
    public function reportCard($studentId, ?Request $request = null)
    {
        $request = $request ?? request();
        $user = auth()->user();
        $student = Student::with(['school', 'classroom.homeroomTeacher', 'guardian'])->findOrFail($studentId);

        // Strict multi-unit access restriction:
        if ($user && !$user->isSuperAdmin() && $user->school_id && $student->school_id != $user->school_id) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki wewenang untuk mengakses rapor siswa di unit sekolah lain.');
        }

        self::ensureExtendedTablesExist();
        $academicYear = AcademicYear::where('is_active', 1)->first() ?? AcademicYear::first();
        
        $gradesQuery = Grade::where('student_id', $studentId)->with('subject');
        if ($academicYear) {
            $yearGrades = (clone $gradesQuery)->where('academic_year_id', $academicYear->id)->get();
            if ($yearGrades->isNotEmpty()) {
                $grades = $yearGrades;
            } else {
                $grades = $gradesQuery->get();
            }
        } else {
            $grades = $gradesQuery->get();
        }
        $grades = $grades->filter(fn($g) => !empty($g->subject_id))
                         ->sortByDesc('updated_at')
                         ->unique('subject_id')
                         ->values();
        try {
            $quranGrade = QuranGrade::where('student_id', $studentId)->first();
        } catch (\Throwable $e) { $quranGrade = null; }
        
        try {
            $characterGrade = CharacterGrade::where('student_id', $studentId)->first();
        } catch (\Throwable $e) { $characterGrade = null; }
        
        try {
            $homeroomNote = HomeroomNote::where('student_id', $studentId)->first();
        } catch (\Throwable $e) { $homeroomNote = null; }
        
        try {
            $reportSetting = ReportSetting::where('school_id', $student->school_id)->first();
        } catch (\Throwable $e) { $reportSetting = null; }

        $schoolCode = strtolower($student->school->code ?? '');
        $schoolName = strtolower($student->school->name ?? '');
        $isSmp = str_contains($schoolCode, 'smp') || str_contains($schoolName, 'smp');
        $isSd = str_contains($schoolCode, 'sd') || str_contains($schoolName, 'sd');
        $isTk = str_contains($schoolCode, 'tk') || str_contains($schoolName, 'tk') || str_contains($schoolCode, 'paud') || str_contains($schoolName, 'paud') || str_contains($schoolCode, 'ra') || str_contains($schoolName, 'ra');

        $classroomGrade = 1;
        if ($student->classroom) {
            if (preg_match('/(?:kelas|kls|\b)\s*([1-9]|1[0-2]|i|ii|iii|iv|v|vi|vii|viii|ix|x|xi|xii)\b/i', $student->classroom->name, $matches)) {
                $lvl = strtolower($matches[1]);
                $romanMap = ['i' => 1, 'ii' => 2, 'iii' => 3, 'iv' => 4, 'v' => 5, 'vi' => 6, 'vii' => 7, 'viii' => 8, 'ix' => 9, 'x' => 10, 'xi' => 11, 'xii' => 12];
                $classroomGrade = is_numeric($lvl) ? (int)$lvl : ($romanMap[$lvl] ?? 1);
            } elseif (isset($student->classroom->level_id)) {
                $classroomGrade = (int)$student->classroom->level_id;
            }
        }
        $isBpiAllowed = $isSmp || ($isSd && in_array($classroomGrade, [4, 5, 6]));

        if (!$reportSetting) {
            $reportSetting = new ReportSetting([
                'school_id' => $student->school_id ?? 1,
                'kop_image_url' => file_exists(public_path('uploads/reports/kop_smp_robbani.png')) ? 'uploads/reports/kop_smp_robbani.png' : (file_exists(public_path('uploads/reports/kop_sd_robbani.png')) ? 'uploads/reports/kop_sd_robbani.png' : null),
                'school_logo_url' => $student->school?->logo_url ?: (file_exists(public_path('uploads/reports/logo_sd_robbani_cover.jpg')) ? '/uploads/reports/logo_sd_robbani_cover.jpg' : null),
                'principal_name' => $student->school?->principal_name ?: ($isSmp ? 'Tia Wulandari, S.Pd.,Gr.' : 'Nur Amalia, S.Pd., Gr'),
                'principal_nip' => $isSmp ? '142062021012' : '142102020009',
                'report_city' => 'Ogan Ilir',
                'report_date' => $isSmp ? '19 Juni 2026' : '18 Juni 2026',
                'stamp_image_url' => file_exists(public_path('uploads/reports/stempel_resmi.png')) ? 'uploads/reports/stempel_resmi.png' : null,
                'principal_signature_url' => file_exists(public_path('uploads/reports/ttd_kepsek.png')) ? 'uploads/reports/ttd_kepsek.png' : null,
            ]);
        }
        
        try {
            $quranCriteria = QuranCriterion::where(fn($q) => $q->where('school_id', $student->school_id)->orWhereNull('school_id'))->orderBy('order_number')->get();
        } catch (\Throwable $e) { $quranCriteria = collect(); }
        
        try {
            $characterIndicators = CharacterIndicator::where(fn($q) => $q->where('school_id', $student->school_id)->orWhereNull('school_id'))->orderBy('order_number')->get();
        } catch (\Throwable $e) { $characterIndicators = collect(); }

        // Pisahkan Mata Pelajaran Kurikulum Nasional vs Muatan Lokal / Kekhasan
        $nationalGrades = $grades->filter(function($g) {
            $cat = strtoupper($g->subject->category ?? 'NASIONAL');
            $code = strtoupper($g->subject->code ?? '');
            $name = strtoupper($g->subject->name ?? '');
            if ($cat === 'MULOK' || $cat === 'QURAN' || str_contains($cat, 'LOKAL') || str_contains($name, 'TAHSIN') || str_contains($name, 'TAHFIDZ') || str_contains($name, 'ARAB')) {
                return false;
            }
            return true;
        })->values();

        $mulokGrades = $grades->filter(function($g) {
            $cat = strtoupper($g->subject->category ?? '');
            $name = strtoupper($g->subject->name ?? '');
            return $cat === 'MULOK' || $cat === 'QURAN' || $cat === 'KEKHASAN' || str_contains($cat, 'LOKAL') || str_contains($name, 'TAHSIN') || str_contains($name, 'TAHFIDZ') || str_contains($name, 'ARAB');
        })->values();

        // Fallback jika tidak terpisah: tampilkan di tabel nasional
        if ($nationalGrades->isEmpty() && $grades->isNotEmpty()) {
            $nationalGrades = $grades;
        }

        $printType = $request->query('type', 'all_in_one'); // all_in_one, cover, identity, academic, quran, character, leger

        $classStudents = collect();
        $classSubjects = collect();
        if ($printType === 'leger') {
            $classStudents = Student::where('classroom_id', $student->classroom_id)->with(['grades.subject'])->get();
            $classSubjects = Subject::where(fn($q) => $q->where('school_id', $student->school_id)->orWhereNull('school_id'))->get();
        }

        $schoolAccreditation = $reportSetting?->accreditation;
        if (empty($schoolAccreditation)) {
            if (str_contains($schoolCode, 'tk') || str_contains($schoolName, 'tk') || str_contains($schoolName, 'tkit') || str_contains($schoolName, 'paud')) {
                $schoolAccreditation = 'Terakreditasi A (BAN-PAUD)';
            } elseif ($isSmp) {
                $schoolAccreditation = 'Terakreditasi B (BAN-S/M)';
            } else {
                $schoolAccreditation = 'Terakreditasi B (BAN-S/M)';
            }
        }
        $nssNds = $reportSetting?->nss_nds ?: ($isSmp ? '202110304002' : '102110304001');

        $defaultTeacherName = $isSmp 
            ? 'Nurul Hamidah Yanti, S.E' 
            : ($isTk ? 'Amah Nurul Hamidah, S.Pd.' : 'Bunda Nurul Hamidah, S.Pd.');

        $defaultTeacherTitle = $isSmp 
            ? 'Guru Tahfidz SMPIT Robbani' 
            : ($isTk ? 'Sertifikasi Wafa Indonesia (Amah Wafa)' : 'Sertifikasi Wafa Indonesia (Bunda Wafa)');

        $wafaTeacherName = $quranGrade?->quran_teacher_name 
            ?: ($student->classroom?->quran_teacher_name 
            ?: ($quranGrade?->examiner?->full_name 
            ?: ($reportSetting?->quran_teacher_name 
            ?: $defaultTeacherName)));

        $wafaTeacherTitle = $quranGrade?->quran_teacher_title 
            ?: ($reportSetting?->quran_teacher_title 
            ?: $defaultTeacherTitle);

        return view('admin.academic.report_card', compact(
            'student',
            'grades',
            'nationalGrades',
            'mulokGrades',
            'academicYear',
            'quranGrade',
            'characterGrade',
            'homeroomNote',
            'reportSetting',
            'schoolAccreditation',
            'nssNds',
            'quranCriteria',
            'characterIndicators',
            'printType',
            'classStudents',
            'classSubjects',
            'isSmp',
            'isSd',
            'isTk',
            'classroomGrade',
            'isBpiAllowed',
            'wafaTeacherName',
            'wafaTeacherTitle'
        ));
    }

    /**
     * Download / Export Leger Nilai Rombel ke format CSV/Excel (Sesuai e-Rapor SD)
     */
    public function exportLeger($request = null)
    {
        if (is_numeric($request)) {
            $classroomId = (int)$request;
            $request = request();
        } else {
            $request = $request ?? request();
            $classroomId = $request->query('classroom_id');
        }
        $user = auth()->user();
        $classroom = Classroom::with(['school', 'homeroomTeacher'])->findOrFail($classroomId);

        // Strict multi-unit access restriction:
        if ($user && !$user->isSuperAdmin() && $user->school_id && $classroom->school_id != $user->school_id) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki wewenang untuk mengunduh leger dari unit sekolah lain.');
        }

        $academicYear = AcademicYear::where('is_active', 1)->first() ?? AcademicYear::first();
        
        $classStudents = Student::where('classroom_id', $classroomId)
            ->with(['grades.subject'])
            ->orderBy('nis')
            ->get();
            
        $classSubjects = Subject::where(fn($q) => $q->where('school_id', $classroom->school_id)->orWhereNull('school_id'))->get();
        
        $cleanClassName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $classroom->name);
        $filename = 'Leger_Nilai_' . $cleanClassName . '_' . date('Ymd_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];
        
        $callback = function() use ($classroom, $academicYear, $classStudents, $classSubjects) {
            $output = fopen('php://output', 'w');
            
            // UTF-8 BOM for Microsoft Excel compatibility
            fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Document Header
            fputcsv($output, ['LEGER REKAPITULASI NILAI HASIL BELAJAR SISWA']);
            fputcsv($output, ['Satuan Pendidikan', $classroom->school->name ?? 'SIT Robbani']);
            fputcsv($output, ['Rombongan Belajar', $classroom->name]);
            fputcsv($output, ['Wali Kelas', $classroom->homeroomTeacher->name ?? '-']);
            fputcsv($output, ['Tahun Pelajaran / Semester', ($academicYear->name ?? '2026/2027') . ' / ' . ($academicYear->semester ?? 'Ganjil')]);
            fputcsv($output, ['Tanggal Unduh', date('d/m/Y H:i')]);
            fputcsv($output, []); // Empty row
            
            // Table Header
            $tableHeaders = ['No', 'NIS', 'NISN', 'Nama Lengkap Siswa', 'L/P'];
            foreach ($classSubjects as $sb) {
                $tableHeaders[] = $sb->name . ' (' . ($sb->code ?? 'MP') . ')';
            }
            $tableHeaders[] = 'Rata-Rata';
            $tableHeaders[] = 'Predikat';
            fputcsv($output, $tableHeaders);
            
            // Rows
            foreach ($classStudents as $idx => $st) {
                $scores = [];
                $numericScores = [];
                foreach ($classSubjects as $sb) {
                    $grade = $st->grades->firstWhere('subject_id', $sb->id);
                    if ($grade && $grade->score !== null && $grade->score !== '') {
                        $scores[] = $grade->score;
                        $numericScores[] = (float)$grade->score;
                    } else {
                        $scores[] = '-';
                    }
                }
                
                $avg = !empty($numericScores) ? round(array_sum($numericScores) / count($numericScores), 1) : '-';
                $pred = is_numeric($avg) ? ($avg >= 85 ? 'A' : ($avg >= 75 ? 'B' : ($avg >= 65 ? 'C' : 'D'))) : '-';
                
                $row = [
                    $idx + 1,
                    $st->nis,
                    $st->nisn ?? '-',
                    $st->full_name,
                    $st->gender ?? 'L',
                ];
                
                foreach ($scores as $s) {
                    $row[] = $s;
                }
                
                $row[] = $avg;
                $row[] = $pred;
                
                fputcsv($output, $row);
            }
            
            fclose($output);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    /**
     * Helper untuk mengambil data lengkap rapor siswa untuk export Word / Multi-student
     */
    private function getStudentReportData($studentId)
    {
        self::ensureExtendedTablesExist();
        $student = Student::with(['school', 'classroom.homeroomTeacher', 'guardian'])->findOrFail($studentId);
        $academicYear = AcademicYear::where('is_active', 1)->first() ?? AcademicYear::first();
        
        $gradesQuery = Grade::where('student_id', $studentId)->with('subject');
        if ($academicYear) {
            $yearGrades = (clone $gradesQuery)->where('academic_year_id', $academicYear->id)->get();
            $grades = $yearGrades->isNotEmpty() ? $yearGrades : $gradesQuery->get();
        } else {
            $grades = $gradesQuery->get();
        }
        $grades = $grades->filter(fn($g) => !empty($g->subject_id))
                         ->sortByDesc('updated_at')
                         ->unique('subject_id')
                         ->values();
        
        try {
            $quranGrade = QuranGrade::where('student_id', $studentId)->first();
        } catch (\Throwable $e) { $quranGrade = null; }
        
        try {
            $characterGrade = CharacterGrade::where('student_id', $studentId)->first();
        } catch (\Throwable $e) { $characterGrade = null; }
        
        try {
            $homeroomNote = HomeroomNote::where('student_id', $studentId)->first();
        } catch (\Throwable $e) { $homeroomNote = null; }
        
        try {
            $reportSetting = ReportSetting::where('school_id', $student->school_id)->first();
        } catch (\Throwable $e) { $reportSetting = null; }

        $schoolCode = strtolower($student->school->code ?? '');
        $schoolName = strtolower($student->school->name ?? '');
        $isSmp = str_contains($schoolCode, 'smp') || str_contains($schoolName, 'smp');
        $isSd = str_contains($schoolCode, 'sd') || str_contains($schoolName, 'sd');
        $isTk = str_contains($schoolCode, 'tk') || str_contains($schoolName, 'tk') || str_contains($schoolCode, 'paud') || str_contains($schoolName, 'paud') || str_contains($schoolCode, 'ra') || str_contains($schoolName, 'ra');

        $classroomGrade = 1;
        if ($student->classroom) {
            if (preg_match('/(?:kelas|kls|\b)\s*([1-9]|1[0-2]|i|ii|iii|iv|v|vi|vii|viii|ix|x|xi|xii)\b/i', $student->classroom->name, $matches)) {
                $lvl = strtolower($matches[1]);
                $romanMap = ['i' => 1, 'ii' => 2, 'iii' => 3, 'iv' => 4, 'v' => 5, 'vi' => 6, 'vii' => 7, 'viii' => 8, 'ix' => 9, 'x' => 10, 'xi' => 11, 'xii' => 12];
                $classroomGrade = is_numeric($lvl) ? (int)$lvl : ($romanMap[$lvl] ?? 1);
            } elseif (isset($student->classroom->level_id)) {
                $classroomGrade = (int)$student->classroom->level_id;
            }
        }
        $isBpiAllowed = $isSmp || ($isSd && in_array($classroomGrade, [4, 5, 6]));

        if (!$reportSetting) {
            $reportSetting = new ReportSetting([
                'school_id' => $student->school_id ?? 1,
                'kop_image_url' => file_exists(public_path('uploads/reports/kop_smp_robbani.png')) ? 'uploads/reports/kop_smp_robbani.png' : (file_exists(public_path('uploads/reports/kop_sd_robbani.png')) ? 'uploads/reports/kop_sd_robbani.png' : null),
                'school_logo_url' => $student->school?->logo_url ?: (file_exists(public_path('uploads/reports/logo_sd_robbani_cover.jpg')) ? '/uploads/reports/logo_sd_robbani_cover.jpg' : null),
                'principal_name' => $student->school?->principal_name ?: ($isSmp ? 'Tia Wulandari, S.Pd.,Gr.' : 'Nur Amalia, S.Pd., Gr'),
                'principal_nip' => $isSmp ? '142062021012' : '142102020009',
                'report_city' => 'Ogan Ilir',
                'report_date' => $isSmp ? '19 Juni 2026' : '18 Juni 2026',
                'stamp_image_url' => file_exists(public_path('uploads/reports/stempel_resmi.png')) ? 'uploads/reports/stempel_resmi.png' : null,
                'principal_signature_url' => file_exists(public_path('uploads/reports/ttd_kepsek.png')) ? 'uploads/reports/ttd_kepsek.png' : null,
            ]);
        }
        
        try {
            $quranCriteria = QuranCriterion::where(fn($q) => $q->where('school_id', $student->school_id)->orWhereNull('school_id'))->orderBy('order_number')->get();
        } catch (\Throwable $e) { $quranCriteria = collect(); }
        
        try {
            $characterIndicators = CharacterIndicator::where(fn($q) => $q->where('school_id', $student->school_id)->orWhereNull('school_id'))->orderBy('order_number')->get();
        } catch (\Throwable $e) { $characterIndicators = collect(); }

        $nationalGrades = $grades->filter(function($g) {
            $cat = strtoupper($g->subject->category ?? 'NASIONAL');
            $name = strtoupper($g->subject->name ?? '');
            if ($cat === 'MULOK' || $cat === 'QURAN' || str_contains($cat, 'LOKAL') || str_contains($name, 'TAHSIN') || str_contains($name, 'TAHFIDZ') || str_contains($name, 'ARAB')) {
                return false;
            }
            return true;
        })->values();

        $mulokGrades = $grades->filter(function($g) {
            $cat = strtoupper($g->subject->category ?? '');
            $name = strtoupper($g->subject->name ?? '');
            return $cat === 'MULOK' || $cat === 'QURAN' || $cat === 'KEKHASAN' || str_contains($cat, 'LOKAL') || str_contains($name, 'TAHSIN') || str_contains($name, 'TAHFIDZ') || str_contains($name, 'ARAB');
        })->values();

        if ($nationalGrades->isEmpty() && $grades->isNotEmpty()) {
            $nationalGrades = $grades;
        }

        $schoolAccreditation = $reportSetting?->accreditation;
        if (empty($schoolAccreditation)) {
            if (str_contains($schoolCode, 'tk') || str_contains($schoolName, 'tk') || str_contains($schoolName, 'tkit') || str_contains($schoolName, 'paud')) {
                $schoolAccreditation = 'Terakreditasi A (BAN-PAUD)';
            } elseif ($isSmp) {
                $schoolAccreditation = 'Terakreditasi B (BAN-S/M)';
            } else {
                $schoolAccreditation = 'Terakreditasi B (BAN-S/M)';
            }
        }
        $nssNds = $reportSetting?->nss_nds ?: ($isSmp ? '202110304002' : '102110304001');

        $defaultTeacherName = $isSmp 
            ? 'Nurul Hamidah Yanti, S.E' 
            : ($isTk ? 'Amah Nurul Hamidah, S.Pd.' : 'Bunda Nurul Hamidah, S.Pd.');

        $defaultTeacherTitle = $isSmp 
            ? 'Guru Tahfidz SMPIT Robbani' 
            : ($isTk ? 'Sertifikasi Wafa Indonesia (Amah Wafa)' : 'Sertifikasi Wafa Indonesia (Bunda Wafa)');

        $wafaTeacherName = $quranGrade?->quran_teacher_name 
            ?: ($student->classroom?->quran_teacher_name 
            ?: ($quranGrade?->examiner?->full_name 
            ?: ($reportSetting?->quran_teacher_name 
            ?: $defaultTeacherName)));

        $wafaTeacherTitle = $quranGrade?->quran_teacher_title 
            ?: ($reportSetting?->quran_teacher_title 
            ?: $defaultTeacherTitle);

        return compact(
            'student',
            'grades',
            'nationalGrades',
            'mulokGrades',
            'academicYear',
            'quranGrade',
            'characterGrade',
            'homeroomNote',
            'reportSetting',
            'schoolAccreditation',
            'nssNds',
            'quranCriteria',
            'characterIndicators',
            'isSmp',
            'isSd',
            'isTk',
            'classroomGrade',
            'isBpiAllowed',
            'wafaTeacherName',
            'wafaTeacherTitle'
        );
    }

    /**
     * Export Rapor Siswa Individual ke Dokumen Word (.doc) yang dapat diedit manual
     */
    public function exportWordReportCard($studentId, ?Request $request = null)
    {
        $user = auth()->user();
        $student = Student::findOrFail($studentId);
        if ($user && !$user->isSuperAdmin() && $user->school_id && $student->school_id != $user->school_id) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki wewenang untuk mengunduh dokumen siswa ini.');
        }

        $data = $this->getStudentReportData($studentId);
        $studentsData = [$data];

        $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $student->full_name);
        $cleanNis = preg_replace('/[^A-Za-z0-9_\-]/', '_', $student->nis ?? 'NIS');
        $filename = "eRapor_SIT_{$cleanNis}_{$cleanName}.doc";

        $html = view('admin.academic.report_card_word', compact('studentsData'))->render();

        return response($html, 200, [
            'Content-Type' => 'application/vnd.ms-word; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

    /**
     * Export Rapor 1 Rombel / Kelas ke Dokumen Word (.doc) Sekaligus
     */
    public function exportWordClassroom($classroomId, ?Request $request = null)
    {
        $user = auth()->user();
        $classroom = Classroom::findOrFail($classroomId);
        if ($user && !$user->isSuperAdmin() && $user->school_id && $classroom->school_id != $user->school_id) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki wewenang untuk mengunduh dokumen kelas ini.');
        }

        $students = Student::where('classroom_id', $classroomId)->orderBy('nis')->get();
        if ($students->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data siswa di kelas ini.');
        }

        $studentsData = [];
        foreach ($students as $st) {
            $studentsData[] = $this->getStudentReportData($st->id);
        }

        $cleanClassName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $classroom->name);
        $filename = "eRapor_1Kelas_{$cleanClassName}_" . date('Ymd') . ".doc";

        $html = view('admin.academic.report_card_word', compact('studentsData'))->render();

        return response($html, 200, [
            'Content-Type' => 'application/vnd.ms-word; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

    /**
     * AI Assistant: Generate Catatan Motivasi Wali Kelas Islami
     */
    public function aiGenerateHomeroom(Request $request, GeminiEraporService $ai)
    {
        $studentName = $request->input('student_name', 'Siswa');
        $academicAverage = (float) ($request->input('academic_average') ?? $request->input('average_score') ?? 85);
        $characterHighlights = $request->input('character_highlights', 'Sholeh, santun, dan rajin beribadah');
        
        $sickCount = (int) $request->input('sick_count', 0);
        $permissionCount = (int) $request->input('permission_count', 0);
        $absentCount = (int) $request->input('absent_count', 0);

        if ($absentCount >= 3) {
            $attendanceInfo = "Tercatat {$absentCount} hari Alpha (tanpa keterangan), perlu pembinaan kedisiplinan";
        } elseif ($absentCount > 0) {
            $attendanceInfo = "Terdapat catatan Alpha {$absentCount} hari";
        } elseif ($sickCount >= 5) {
            $attendanceInfo = "Sering izin sakit ({$sickCount} hari)";
        } elseif ($absentCount == 0 && ($sickCount + $permissionCount) <= 2) {
            $attendanceInfo = "Hadir 100% tepat waktu tanpa alpha";
        } else {
            $attendanceInfo = "Sakit: {$sickCount}, Izin: {$permissionCount}, Alpha: {$absentCount}";
        }

        if ($request->filled('attendance_info')) {
            $attendanceInfo = $request->input('attendance_info');
        }

        $ekskulInfo = $request->input('ekskul_info', 'Pramuka SIT & Tahfidz');

        $result = $ai->generateHomeroomNote(
            $studentName,
            $academicAverage,
            $characterHighlights,
            $attendanceInfo,
            $ekskulInfo,
            $sickCount,
            $permissionCount,
            $absentCount
        );

        return response()->json([
            'status' => 'success',
            'text' => $result,
            'note' => $result,
            'narrative' => $result
        ]);
    }

    /**
     * AI Assistant: Generate Narasi Capaian Pembelajaran (CP/TP) Kurikulum Merdeka
     */
    public function aiGenerateNarrative(Request $request, GeminiEraporService $ai)
    {
        $studentName = $request->input('student_name', 'Siswa');
        $subjectName = $request->input('subject_name', 'Mata Pelajaran');
        
        $rawScore = $request->input('score');
        $score = $rawScore !== null && $rawScore !== '' ? (float) $rawScore : 0.0;
        $competencyContext = $request->input('competency_context', 'Tujuan Pembelajaran Semester Ini');

        $result = $ai->generateSubjectNarrative(
            $studentName,
            $subjectName,
            $score,
            $competencyContext
        );

        return response()->json([
            'status' => 'success',
            'text' => $result,
            'narrative' => $result,
            'note' => $result
        ]);
    }

    /**
     * AI Assistant: Generate Evaluasi Al-Qur'an Wafa & Tahfidz
     */
    public function aiGenerateQuran(Request $request, GeminiEraporService $ai)
    {
        $studentName = $request->input('student_name', 'Siswa');
        $tahsinLevel = $request->input('tahsin_level') ?? $request->input('level', 'Buku Wafa 3');
        
        $makhrajScore = $request->filled('makhraj_score') ? (float) $request->input('makhraj_score') : ($request->filled('makhraj') ? (float) $request->input('makhraj') : 0.0);
        $tajwidScore = $request->filled('tajwid_score') ? (float) $request->input('tajwid_score') : ($request->filled('tajwid') ? (float) $request->input('tajwid') : 0.0);
        $tahfidzTarget = $request->input('tahfidz_target', 'Juz 30 (An-Naba s/d An-Nas)');
        $tahfidzAchievement = $request->input('tahfidz_achievement') ?? $request->input('achievement', 'Tuntas Juz 30');

        $result = $ai->generateQuranEvaluation(
            $studentName,
            $tahsinLevel,
            $makhrajScore,
            $tajwidScore,
            $tahfidzTarget,
            $tahfidzAchievement
        );

        return response()->json([
            'status' => 'success',
            'text' => $result,
            'evaluation' => $result,
            'narrative' => $result,
            'note' => $result
        ]);
    }

    /**
     * AI Assistant: Analisis Kesiapan & Mutu Rombel Kelas (Per Kelas atau Seluruh Unit)
     */
    public function aiAnalyzeClass(Request $request, GeminiEraporService $ai)
    {
        $classroomId = $request->input('classroom_id');
        $schoolId = $request->input('school_id') ?: (auth()->user()?->school_id ?: 1);

        // KASUS 1: AUDIT SELURUH ROMBEL DI UNIT SEKOLAH
        if (empty($classroomId) || $classroomId === 'all' || $classroomId == '0') {
            $classrooms = Classroom::with(['homeroomTeacher', 'school'])
                ->where('school_id', $schoolId)
                ->orderBy('name')
                ->get();

            $classSummaries = [];
            $totalStudentsAll = 0;
            $completedClassrooms = 0;
            $emptyClassrooms = 0;
            $inProgressClassrooms = 0;

            foreach ($classrooms as $cls) {
                $clsStudents = Student::where('classroom_id', $cls->id)->whereIn('status', ['ACTIVE', 'AKTIF'])->get();
                $stCount = $clsStudents->count();
                $totalStudentsAll += $stCount;
                $stIds = $clsStudents->pluck('id');
                $walasName = $cls->homeroomTeacher->name ?? 'Belum Ditunjuk';

                if ($stCount === 0) {
                    $emptyClassrooms++;
                    $classSummaries[] = [
                        'id' => $cls->id,
                        'name' => $cls->name,
                        'walas' => $walasName,
                        'students' => 0,
                        'status' => '⚠️ Kosong (0 Siswa)',
                        'progress_pct' => 0,
                        'note' => 'Belum ada siswa aktif terdaftar di rombel ini.'
                    ];
                    continue;
                }

                $mapelCount = Grade::whereIn('student_id', $stIds)->distinct('student_id')->count('student_id');
                $quranCount = QuranGrade::whereIn('student_id', $stIds)->count();
                $charCount = CharacterGrade::whereIn('student_id', $stIds)->count();
                $hrCount = HomeroomNote::whereIn('student_id', $stIds)->count();

                $pct = round((($mapelCount + $quranCount + $charCount + $hrCount) / ($stCount * 4)) * 100);
                if ($pct >= 100) {
                    $completedClassrooms++;
                    $stLabel = '✅ Tuntas Lengkap (100%)';
                    $note = "Seluruh komponen ({$stCount} siswa) lengkap 100% dan siap cetak.";
                } elseif ($pct > 0) {
                    $inProgressClassrooms++;
                    $stLabel = "⏳ Dalam Proses ({$pct}%)";
                    $note = "Nilai terisi sebagian (Mapel: {$mapelCount}/{$stCount}, Qur'an: {$quranCount}/{$stCount}, Karakter: {$charCount}/{$stCount}, Catatan Walas: {$hrCount}/{$stCount}).";
                } else {
                    $emptyClassrooms++;
                    $stLabel = '❌ Belum Mengisi Nilai (0%)';
                    $note = "Seluruh komponen nilai masih kosong 0/{$stCount} siswa (Wali Kelas {$walasName} belum menginput nilai Mapel, Al-Qur'an Wafa, Karakter 7 SKL, maupun Catatan Walas).";
                }

                $classSummaries[] = [
                    'id' => $cls->id,
                    'name' => $cls->name,
                    'walas' => $walasName,
                    'students' => $stCount,
                    'status' => $stLabel,
                    'progress_pct' => $pct,
                    'note' => $note
                ];
            }

            $school = School::find($schoolId);
            $schoolName = $school->name ?? 'SIT Robbani';

            $overallStats = [
                'total_classrooms' => $classrooms->count(),
                'total_students' => $totalStudentsAll,
                'completed_count' => $completedClassrooms,
                'in_progress_count' => $inProgressClassrooms,
                'empty_count' => $emptyClassrooms,
            ];

            $analysis = $ai->analyzeSchoolOverallReadiness($schoolName, $classSummaries, $overallStats);

            return response()->json([
                'status' => 'success',
                'classroom_name' => "Seluruh Rombel ({$schoolName})",
                'overall_stats' => $overallStats,
                'class_summaries' => $classSummaries,
                'analysis' => $analysis
            ]);
        }

        // KASUS 2: AUDIT KELAS SPESIFIK
        $classroom = Classroom::with(['school', 'homeroomTeacher'])->findOrFail($classroomId);
        $clsStudents = Student::where('classroom_id', $classroom->id)->whereIn('status', ['ACTIVE', 'AKTIF'])->get();
        $stCount = $clsStudents->count();
        $stIds = $clsStudents->pluck('id');
        $walasName = $classroom->homeroomTeacher->name ?? 'Belum Ditunjuk';

        if ($stCount === 0) {
            $stats = [
                'total_students' => 0,
                'mapel_progress' => '0%',
                'quran_progress' => '0%',
                'character_progress' => '0%',
                'homeroom_progress' => '0%',
                'average_score' => 0,
                'is_empty' => true,
                'walas' => $walasName
            ];

            $analysis = "### 1. Status Kesiapan Rapor: {$classroom->name}\n\n" .
                "**Status:** Rombongan belajar saat ini tercatat **Belum Memiliki Siswa Aktif (0 Siswa Terdaftar)**.\n\n" .
                "- **Wali Kelas:** {$walasName}\n" .
                "- **Kelengkapan Nilai:** Belum dapat diisi karena rombel belum memiliki peserta didik aktif.\n\n" .
                "### 2. Arahan Tindak Lanjut Kepala Sekolah & Operator\n\n" .
                "1. Segera lakukan penempatan / plotting siswa ke dalam rombel **{$classroom->name}** melalui menu Data Siswa Unit.\n" .
                "2. Hubungi Wali Kelas ({$walasName}) untuk bersiap melakukan penginputan setelah data siswa terisi.";

            return response()->json([
                'status' => 'success',
                'classroom_name' => $classroom->name,
                'stats' => $stats,
                'analysis' => $analysis
            ]);
        }

        $mapelCount = Grade::whereIn('student_id', $stIds)->distinct('student_id')->count('student_id');
        $quranCount = QuranGrade::whereIn('student_id', $stIds)->count();
        $charCount = CharacterGrade::whereIn('student_id', $stIds)->count();
        $hrCount = HomeroomNote::whereIn('student_id', $stIds)->count();
        $avgScore = Grade::whereIn('student_id', $stIds)->avg('score') ?: 0;

        $stats = [
            'total_students' => $stCount,
            'mapel_progress' => round(($mapelCount / $stCount) * 100) . '%',
            'quran_progress' => round(($quranCount / $stCount) * 100) . '%',
            'character_progress' => round(($charCount / $stCount) * 100) . '%',
            'homeroom_progress' => round(($hrCount / $stCount) * 100) . '%',
            'average_score' => round($avgScore, 1),
            'walas' => $walasName
        ];

        $analysis = $ai->analyzeClassroomReadiness($classroom->name, $stats);

        return response()->json([
            'status' => 'success',
            'classroom_name' => $classroom->name,
            'stats' => $stats,
            'analysis' => $analysis
        ]);
    }

    /**
     * AI Assistant: Generate Narasi Karakter 7 SKL JSIT & BPI
     */
    public function aiGenerateBpi(Request $request, GeminiEraporService $ai)
    {
        $studentName = $request->input('student_name', 'Siswa');
        $indicators = (array) $request->input('indicators', []);
        $sholatFardhu = (string) $request->input('sholat_fardhu', 'Selalu Berjamaah di Masjid');

        $result = $ai->generateBpiEvaluation(
            $studentName,
            $indicators,
            $sholatFardhu
        );

        return response()->json([
            'status' => 'success',
            'text' => $result,
            'evaluation' => $result,
            'narrative' => $result,
            'note' => $result
        ]);
    }

    /**
     * Manajemen Pengguna Unit oleh Kepala Sekolah / Operator / Super Admin
     */
    public function saveUnitUser(Request $request)
    {
        $currentUser = auth()->user();
        $isSuperAdmin = $currentUser->isSuperAdmin() || $currentUser->role === 'SUPER_ADMIN';
        $isHeadmaster = $currentUser->isHeadmaster() || $currentUser->role === 'HEADMASTER';
        $isStaffTu = $currentUser->isStaffTu() || $currentUser->role === 'STAFF_TU';

        if (!$isSuperAdmin && !$isHeadmaster && !$isStaffTu) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki hak mengelola akun pengguna unit.');
        }

        $schoolId = $isSuperAdmin ? ($request->school_id ?: ($currentUser->school_id ?: 1)) : $currentUser->school_id;

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'role' => 'required',
            'password' => $request->filled('user_id') ? 'nullable|min:6' : 'required|min:6',
        ];
        $request->validate($rules);

        $userId = $request->input('user_id');
        if ($userId) {
            $targetUser = User::findOrFail($userId);
            // Security isolation: Non-superadmin cannot touch users from other schools or Super Admins
            if (!$isSuperAdmin) {
                if ($targetUser->school_id != $schoolId || $targetUser->role === 'SUPER_ADMIN') {
                    abort(403, 'Akses Ditolak: Anda tidak memiliki wewenang mengedit akun ini.');
                }
            }

            // Check email uniqueness excluding self
            if (User::where('email', $request->email)->where('id', '!=', $userId)->exists()) {
                return redirect()->back()->with('error', "Email {$request->email} sudah digunakan oleh pengguna lain!");
            }

            $targetUser->name = $request->name;
            $targetUser->email = $request->email;
            $targetUser->role = $request->role;
            if ($request->filled('password')) {
                $targetUser->password = Hash::make($request->password);
            }
            if ($request->has('phone')) {
                $targetUser->phone = $request->phone;
            }
            $targetUser->save();

            // Sync Employee record agar langsung tampil di pilihan Wali Kelas jika pendidik
            if (in_array($targetUser->role, ['TEACHER', 'HEADMASTER'])) {
                try {
                    Employee::updateOrCreate(
                        ['user_id' => $targetUser->id],
                        [
                            'school_id' => $schoolId,
                            'full_name' => $targetUser->name,
                            'role_type' => $targetUser->role === 'HEADMASTER' ? 'HEADMASTER' : 'TEACHER',
                            'is_active' => true,
                        ]
                    );
                } catch (\Throwable $e) {}
            }

            $msg = "✓ Akun pengguna {$targetUser->name} berhasil diperbarui!";
        } else {
            // Check unique email
            if (User::where('email', $request->email)->exists()) {
                return redirect()->back()->with('error', "Email {$request->email} sudah terdaftar dalam sistem!");
            }

            $newUser = new User();
            $newUser->name = $request->name;
            $newUser->email = $request->email;
            $newUser->password = Hash::make($request->password);
            $newUser->role = $request->role;
            $newUser->school_id = $schoolId;
            if ($request->has('phone')) {
                $newUser->phone = $request->phone;
            }
            $newUser->save();

            // Sync Employee record agar langsung tampil di pilihan Wali Kelas jika pendidik
            if (in_array($newUser->role, ['TEACHER', 'HEADMASTER'])) {
                try {
                    Employee::create([
                        'user_id' => $newUser->id,
                        'school_id' => $schoolId,
                        'full_name' => $newUser->name,
                        'role_type' => $newUser->role === 'HEADMASTER' ? 'HEADMASTER' : 'TEACHER',
                        'is_active' => true,
                    ]);
                } catch (\Throwable $e) {}
            }

            $msg = "✓ Akun pengguna baru {$newUser->name} berhasil ditambahkan ke unit!";
        }

        return redirect()->route('admin.academic.grades', [
            'school_id' => $schoolId,
            'menu' => 'users'
        ])->with('success', $msg);
    }

    public function deleteUnitUser($id)
    {
        $currentUser = auth()->user();
        $isSuperAdmin = $currentUser->isSuperAdmin() || $currentUser->role === 'SUPER_ADMIN';
        $isHeadmaster = $currentUser->isHeadmaster() || $currentUser->role === 'HEADMASTER';
        $isStaffTu = $currentUser->isStaffTu() || $currentUser->role === 'STAFF_TU';

        if (!$isSuperAdmin && !$isHeadmaster && !$isStaffTu) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki wewenang menghapus akun pengguna.');
        }

        if ($currentUser->id == $id) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif!');
        }

        $targetUser = User::findOrFail($id);
        if ($targetUser->role === 'SUPER_ADMIN') {
            abort(403, 'Akses Ditolak: Akun Super Admin Yayasan tidak dapat dihapus.');
        }

        if (!$isSuperAdmin && $targetUser->school_id != $currentUser->school_id) {
            abort(403, 'Akses Ditolak: Anda tidak dapat menghapus akun dari unit sekolah lain.');
        }

        $name = $targetUser->name;
        try {
            Employee::where('user_id', $targetUser->id)->delete();
        } catch (\Throwable $e) {}
        $targetUser->delete();

        return redirect()->back()->with('success', "✓ Akun pengguna {$name} berhasil dihapus dari unit sekolah.");
    }
}
