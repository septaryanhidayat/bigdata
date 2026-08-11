<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Models\School;
use App\Models\Student;
use App\Models\Employee;
use App\Models\Classroom;
use Illuminate\Http\Request;

class SchoolWebsiteController extends Controller
{
    public function index()
    {
        $settings = [
            'school_name' => SiteSetting::get('school_name', 'Sekolah Islam Terpadu Robbani'),
            'tagline' => SiteSetting::get('tagline', 'Membentuk Generasi Rabbani Berakhlak Mulia & Berprestasi Digital'),
            'hero_badge' => SiteSetting::get('school_hero_badge', '✨ YAYASAN PENDIDIKAN ISLAM TERPADU ROBBANI'),
            'hero_title' => SiteSetting::get('school_hero_title', 'Pendidikan Karakter Islami & Keunggulan Akademik Digital'),
            'hero_desc' => SiteSetting::get('school_hero_desc', 'Sekolah Islam Terpadu Robbani menyelenggarakan pendidikan terpadu dari jenjang TK, SD, SMP hingga SMA dengan Kurikulum Merdeka, Kekhasan JSIT, Pembiasaan Al-Qur\'an (Tahfidz), Mutaba\'ah BPI, dan Platform Digital SmartEdu.'),
            'principal_greeting' => SiteSetting::get('principal_greeting', 'Assalamu\'alaikum Warahmatullahi Wabarakatuh. Selamat datang di portal resmi Sekolah Islam Terpadu Robbani. Kami berkomitmen mendidik ananda menjadi pribadi beriman, bertakwa, berakhlak karimah, serta siap menghadapi era digital.'),
            'principal_name' => SiteSetting::get('principal_name', 'Ustadz Ahmad Fauzi, S.Pd.I, M.Pd'),
            'principal_title' => SiteSetting::get('principal_title', 'Ketua Yayasan / Kepala Sekolah SIT Robbani'),
            'ppdb_status' => SiteSetting::get('ppdb_status', 'GELOMBANG 1 DIBUKA'),
            'ppdb_desc' => SiteSetting::get('ppdb_desc', 'Penerimaan Peserta Didik Baru (PPDB) Tahun Ajaran 2026/2027 telah dibuka untuk jenjang TK, SDIT, SMPIT, & SMAIT.'),
            'contact_phone' => SiteSetting::get('contact_phone', '0812-3456-7890'),
            'contact_email' => SiteSetting::get('contact_email', 'info@robbani.sch.id'),
            'contact_address' => SiteSetting::get('contact_address', 'Jl. Pendidikan Karakter No. 1-2, Kota Bandung, Jawa Barat'),
            'website_theme' => SiteSetting::get('website_theme', 'theme-emerald'),
        ];

        $schools = School::withCount(['students', 'employees', 'classrooms'])->where('is_active', true)->get();
        $totalStudents = Student::count();
        $totalEmployees = Employee::count();
        $totalClassrooms = Classroom::count();

        return view('school.home', compact('settings', 'schools', 'totalStudents', 'totalEmployees', 'totalClassrooms'));
    }

    public function unitProfile($code)
    {
        $school = School::withCount(['students', 'employees', 'classrooms'])
            ->where('code', strtoupper($code))
            ->firstOrFail();

        $students = Student::where('school_id', $school->id)->where('status', 'aktif')->take(10)->get();
        $teachers = Employee::where('school_id', $school->id)->where('status', 'aktif')->take(8)->get();
        $classrooms = Classroom::where('school_id', $school->id)->with('level')->get();

        $settings = [
            'school_name' => SiteSetting::get('school_name', 'Sekolah Islam Terpadu Robbani'),
            'contact_phone' => SiteSetting::get('contact_phone', '0812-3456-7890'),
            'contact_email' => SiteSetting::get('contact_email', 'info@robbani.sch.id'),
            'website_theme' => SiteSetting::get('website_theme', 'theme-emerald'),
        ];

        return view('school.unit', compact('school', 'students', 'teachers', 'classrooms', 'settings'));
    }
}
