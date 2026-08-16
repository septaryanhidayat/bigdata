<?php

namespace App\Http\Controllers;

use App\Models\DigitalSignature;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class PublicLetterVerificationController extends Controller
{
    /**
     * Halaman Publik Verifikasi Keaslian Dokumen & TTE (Scan QR Code)
     */
    public function verify($token)
    {
        $signature = DigitalSignature::with(['letter.school', 'signer.school'])
            ->where('verify_token', $token)
            ->firstOrFail();

        $settings = [
            'school_name' => SiteSetting::get('school_name', 'Yayasan Generasi Robbani Sumatera Selatan'),
            'tagline' => SiteSetting::get('tagline', 'Sekolah Islam Terpadu Robbani Ogan Ilir'),
        ];

        return view('school.letter_verify', compact('signature', 'settings'));
    }
}
