<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\School;
use App\Models\Employee;
use App\Models\OfficialLetter;
use App\Models\LetterTemplate;
use App\Models\LetterDisposition;
use App\Models\DigitalSignature;
use App\Models\LetterAuditTrail;
use Illuminate\Support\Str;

class LetterSeeder extends Seeder
{
    public function run(): void
    {
        $sdit = School::where('code', 'SDIT')->first() ?? School::first();
        $smpit = School::where('code', 'SMPIT')->first() ?? School::first();
        $smait = School::where('code', 'SMAIT')->first() ?? School::first();

        $principals = Employee::whereIn('role_type', ['HEADMASTER', 'TEACHER'])->get();
        $principalSmp = $principals->first() ?? Employee::first();
        $teacherStaff = $principals->skip(1)->first() ?? $principalSmp;

        // 1. Seed Templates
        LetterTemplate::updateOrCreate(
            ['code' => 'TPL-SE-01'],
            [
                'name' => 'Surat Edaran Libur / Pemberitahuan KBM',
                'category' => 'SURAT_EDARAN',
                'format_number_pattern' => '{NO}/SIT-ROBBANI/SE/{ROMAN_MONTH}/{YEAR}',
                'content_template' => "Assalamu'alaikum Warahmatullahi Wabarakatuh,\n\nSehubungan dengan datangnya bulan suci Ramadhan 1447 H, kami memberitahukan kepada seluruh orang tua/wali siswa bahwa kegiatan belajar mengajar (KBM) akan diliburkan mulai tanggal 1 s/d 5 Ramadhan.\n\nDemikian surat edaran ini kami sampaikan, atas perhatian dan kerjasama Bapak/Ibu kami ucapkan terima kasih.\n\nWassalamu'alaikum Warahmatullahi Wabarakatuh.",
                'is_active' => true,
            ]
        );

        LetterTemplate::updateOrCreate(
            ['code' => 'TPL-UND-01'],
            [
                'name' => 'Surat Undangan Rapat / Kajian Parenting',
                'category' => 'UNDANGAN',
                'format_number_pattern' => '{NO}/SIT-ROBBANI/UND/{ROMAN_MONTH}/{YEAR}',
                'content_template' => "Assalamu'alaikum Warahmatullahi Wabarakatuh,\n\nDengan hormat, kami mengundang Bapak/Ibu untuk menghadiri agenda Rapat Pleno dan Sosialisasi Program Sekolah yang insya Allah akan dilaksanakan pada:\n\nHari / Tanggal : Sabtu, 22 Agustus 2026\nWaktu / Pukul  : 08.30 WIB s.d Selesai\nTempat         : Aula Utama Yayasan Generasi Robbani\nAgenda         : Sosialisasi Kurikulum JSIT & Evaluasi Tahfidz\nPembicara      : Ustadz Dr. H. Ahmad Fauzi, M.Pd.I\n\nMengingat pentingnya agenda tersebut, kami sangat mengharapkan kehadiran Bapak/Ibu tepat pada waktunya.\n\nWassalamu'alaikum Warahmatullahi Wabarakatuh.",
                'is_active' => true,
            ]
        );

        LetterTemplate::updateOrCreate(
            ['code' => 'TPL-ST-01'],
            [
                'name' => 'Surat Tugas Pelatihan / Dinas Guru',
                'category' => 'SURAT_TUGAS',
                'format_number_pattern' => '{NO}/SIT-ROBBANI/ST/{ROMAN_MONTH}/{YEAR}',
                'content_template' => "Yang bertanda tangan di bawah ini Kepala Sekolah Islam Terpadu Robbani menugaskan kepada:\n\nNama           : Ustadz Rizky, S.Pd.I\nNIP            : 198505122026011001\nJabatan        : Guru Pembina Akademik & Kurikulum\n\nUntuk menghadiri dan mengikuti kegiatan Pelatihan Penguatan Asesmen Nasional Berbasis Komputer (ANBK) yang diselenggarakan pada:\n\nHari / Tanggal : Rabu s.d Kamis, 19 - 20 Agustus 2026\nWaktu          : 08.00 WIB s.d Selesai\nTempat         : Gedung Pertemuan Dinas Pendidikan Kab. Ogan Ilir\n\nDemikian surat tugas ini dibuat agar dapat dilaksanakan dengan penuh amanah dan tanggung jawab.",
                'is_active' => true,
            ]
        );

        LetterTemplate::updateOrCreate(
            ['code' => 'TPL-SK-01'],
            [
                'name' => 'Surat Keterangan Aktif Belajar Siswa',
                'category' => 'SURAT_KETERANGAN',
                'format_number_pattern' => '{NO}/SIT-ROBBANI/SKet/{ROMAN_MONTH}/{YEAR}',
                'content_template' => "Yang bertanda tangan di bawah ini Kepala Sekolah Islam Terpadu Robbani menerangkan bahwa:\n\nNama Siswa     : Fatih Abdullah Prasetyo\nNIS / NISN     : 20267001 / 0061234567\nTempat/Tgl Lahir: Palembang, 12 Mei 2013\nKelas / Rombel : 7-Umar bin Khattab\n\nAdalah benar siswa yang terdaftar aktif mengikuti kegiatan belajar mengajar pada Sekolah Islam Terpadu Robbani Tahun Ajaran 2026/2027.\n\nSurat keterangan ini diterbitkan untuk keperluan kelengkapan administrasi beasiswa / pendaftaran dinas.\n\nDemikian surat keterangan ini kami buat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.",
                'is_active' => true,
            ]
        );

        LetterTemplate::updateOrCreate(
            ['code' => 'TPL-SPG-01'],
            [
                'name' => 'Surat Undangan Konseling Orang Tua (BK)',
                'category' => 'SURAT_PANGGILAN',
                'format_number_pattern' => '{NO}/SIT-ROBBANI/SPG/{ROMAN_MONTH}/{YEAR}',
                'content_template' => "Assalamu'alaikum Warahmatullahi Wabarakatuh,\n\nSemoga Bapak/Ibu senantiasa dalam limpahan rahmat Allah SWT. Sehubungan dengan perkembangan belajar dan pembinaan ananda Muhammad Rayhan (Kelas 7-Umar), kami mengharapkan kehadiran Bapak/Ibu di sekolah pada:\n\nHari / Tanggal : Selasa, 25 Agustus 2026\nPukul          : 09.00 WIB\nTempat         : Ruang Bimbingan Konseling (BK) Lt. 1\nMenemui        : Ustadzah Fitriana, S.Si (Guru BK & Wali Kelas)\n\nAtas kehadiran dan kerjasama Bapak/Ibu demi kemajuan ananda, kami ucapkan terima kasih.\n\nWassalamu'alaikum Warahmatullahi Wabarakatuh.",
                'is_active' => true,
            ]
        );

        // 2. Seed Incoming Letters (Surat Masuk)
        $in1 = OfficialLetter::updateOrCreate(
            ['reference_number' => '420/892/Disdik.OI/2026'],
            [
                'school_id' => $smpit?->id,
                'type' => 'INCOMING',
                'letter_category' => 'UNDANGAN',
                'agenda_number' => 'AGD-2026-0001',
                'title' => 'Undangan Rapat Koordinasi Asesmen Nasional Berbasis Komputer (ANBK) 2026',
                'sender' => 'Dinas Pendidikan & Kebudayaan Kab. Ogan Ilir',
                'recipient' => 'Kepala SMPIT Robbani Ogan Ilir',
                'letter_date' => '2026-08-10',
                'received_date' => '2026-08-11',
                'content' => 'Sehubungan dengan persiapan pelaksanaan ANBK jenjang SMP tahun 2026, dimohon kehadiran Kepala Sekolah dan Proktor pada rapat koordinasi teknis.',
                'security_level' => 'SEGERA',
                'status' => 'DISPATCHED',
                'created_by' => 1,
            ]
        );

        $in2 = OfficialLetter::updateOrCreate(
            ['reference_number' => 'B-342/Kk.06.04/PP.00/08/2026'],
            [
                'school_id' => $sdit?->id,
                'type' => 'INCOMING',
                'letter_category' => 'SURAT_EDARAN',
                'agenda_number' => 'AGD-2026-0002',
                'title' => 'Edaran Pelaksanaan Pekan Keterampilan & Seni Pendidikan Agama Islam (Pentas PAI)',
                'sender' => 'Kementerian Agama Kab. Ogan Ilir',
                'recipient' => 'Kepala SDIT Robbani',
                'letter_date' => '2026-08-12',
                'received_date' => '2026-08-13',
                'content' => 'Pemberitahuan petunjuk teknis lomba MHQ, Pidato PAI, dan Kaligrafi Islam tingkat Kabupaten.',
                'security_level' => 'BIASA',
                'status' => 'DISPATCHED',
                'created_by' => 1,
            ]
        );

        // 3. Seed Dispositions
        LetterDisposition::updateOrCreate(
            ['letter_id' => $in1->id, 'to_employee_id' => $teacherStaff->id],
            [
                'from_employee_id' => $principalSmp->id,
                'instruction' => 'Hadir Mewakili Sekolah & Siapkan Bahan ANBK',
                'notes' => 'Tolong koordinasikan juga dengan proktor laboratorium komputer untuk kesiapan perangkat.',
                'due_date' => '2026-08-18',
                'status' => 'IN_PROGRESS',
                'reply_notes' => 'Sedang mempersiapkan data inventaris laboratorium PC untuk dibawa saat rakor.',
            ]
        );

        LetterDisposition::updateOrCreate(
            ['letter_id' => $in2->id, 'to_employee_id' => $teacherStaff->id],
            [
                'from_employee_id' => $principalSmp->id,
                'instruction' => 'Tindak Lanjuti & Seleksi Siswa Berbakat',
                'notes' => 'Segera lakukan pembinaan untuk cabang MHQ dan Kaligrafi.',
                'due_date' => '2026-08-20',
                'status' => 'COMPLETED',
                'reply_notes' => 'Sudah terpilih 3 santri untuk mewakili lomba cabang MHQ Juz 30.',
                'completed_at' => now(),
            ]
        );

        // 4. Seed Outgoing Letters with Internal TTE Signatures (Surat Keluar)
        $out1 = OfficialLetter::updateOrCreate(
            ['reference_number' => '024/SMPIT-ROBBANI/SE/VIII/2026'],
            [
                'school_id' => $smpit?->id,
                'type' => 'OUTGOING',
                'letter_category' => 'SURAT_EDARAN',
                'title' => 'Pemberitahuan Pelaksanaan Ujian Tengah Semester & Pembagian Rapor Siswa',
                'sender' => 'SMPIT Robbani Ogan Ilir',
                'recipient' => 'Seluruh Orang Tua / Wali Santri SMPIT Robbani',
                'letter_date' => '2026-08-15',
                'content' => "Assalamu'alaikum Warahmatullahi Wabarakatuh,\n\nDengan hormat, kami sampaikan bahwa pelaksanaan Asesmen Sumatif Tengah Semester (ASTS) Ganjil Tahun Ajaran 2026/2027 akan diselenggarakan pada tanggal 1 s/d 8 September 2026.\n\nDemikian pemberitahuan ini kami sampaikan, mohon bimbingan dan doa Bapak/Ibu di rumah.\n\nWassalamu'alaikum Warahmatullahi Wabarakatuh.",
                'security_level' => 'BIASA',
                'status' => 'SIGNED',
                'created_by' => 1,
            ]
        );

        $token1 = Str::random(32);
        DigitalSignature::updateOrCreate(
            ['letter_id' => $out1->id],
            [
                'signer_employee_id' => $principalSmp->id,
                'certificate_issuer' => 'Sistem TTE Digital Internal SIT Robbani (SmartEdu Secure QR)',
                'certificate_serial' => 'TTE-ROBBANI-77889900-2026',
                'signature_hash' => hash('sha256', $out1->reference_number . '|' . $out1->title . '|' . $principalSmp->nip),
                'verify_token' => $token1,
                'signed_at' => now()->subDay(),
                'ip_address' => '127.0.0.1',
                'passphrase_validated' => true,
                'status' => 'VALID',
            ]
        );

        LetterAuditTrail::create([
            'letter_id' => $out1->id,
            'user_id' => 1,
            'action' => 'SIGNED_TTE_INTERNAL',
            'description' => "Dokumen ditandatangani secara elektronik (TTE Internal) oleh {$principalSmp->full_name} (Serial: TTE-ROBBANI-77889900-2026)",
            'ip_address' => '127.0.0.1',
        ]);

        $out2 = OfficialLetter::updateOrCreate(
            ['reference_number' => '025/SMAIT-ROBBANI/ST/VIII/2026'],
            [
                'school_id' => $smait?->id,
                'type' => 'OUTGOING',
                'letter_category' => 'SURAT_TUGAS',
                'title' => 'Surat Tugas Pendampingan Lomba Olimpiade Sains Nasional (OSN) 2026',
                'sender' => 'SMAIT Robbani Ogan Ilir',
                'recipient' => 'Ustadz Drs. Abdullah S.Pd',
                'letter_date' => '2026-08-16',
                'content' => "Yang bertanda tangan di bawah ini Kepala Sekolah SMAIT Robbani menugaskan kepada Guru Pembimbing untuk mendampingi kontingen siswa pada ajang OSN Tingkat Provinsi Sumatera Selatan.\n\nDemikian surat tugas ini dibuat untuk dilaksanakan dengan sebaik-baiknya.",
                'security_level' => 'SEGERA',
                'status' => 'WAITING_SIGNATURE',
                'created_by' => 1,
            ]
        );
    }
}
