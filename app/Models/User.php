<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_SUPER_ADMIN = 'SUPER_ADMIN';
    public const ROLE_YAYASAN_CHAIRMAN = 'YAYASAN_CHAIRMAN';
    public const ROLE_HEADMASTER = 'HEADMASTER';
    public const ROLE_STAFF_TU = 'STAFF_TU';
    public const ROLE_STAFF_KEUANGAN = 'STAFF_KEUANGAN';
    public const ROLE_TEACHER = 'TEACHER';
    public const ROLE_GURU_BK = 'GURU_BK';
    public const ROLE_MUSYRIF_ASRAMA = 'MUSYRIF_ASRAMA';
    public const ROLE_PETUGAS_PERPUS = 'PETUGAS_PERPUS';
    public const ROLE_PETUGAS_KANTIN = 'PETUGAS_KANTIN';
    public const ROLE_PANITIA_PPDB = 'PANITIA_PPDB';
    public const ROLE_PETUGAS_SARPRAS = 'PETUGAS_SARPRAS';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'school_id',
        'is_active',
        'phone',
        'avatar_url',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'is_active' => 'boolean',
            'password' => 'hashed',
        ];
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function employee(): HasOne
    {
        return $this->hasOne(Employee::class, 'user_id');
    }

    /**
     * Check if user has specific role(s)
     */
    public function hasRole(string|array $roles): bool
    {
        if ($this->role === self::ROLE_SUPER_ADMIN) {
            return true; // Super admin always passes
        }

        if (is_array($roles)) {
            return in_array($this->role, $roles, true);
        }

        return $this->role === $roles;
    }

    /**
     * Check if user is Super Admin
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === self::ROLE_SUPER_ADMIN;
    }

    /**
     * Check if user is Ketua Yayasan
     */
    public function isYayasan(): bool
    {
        return $this->role === self::ROLE_YAYASAN_CHAIRMAN || $this->role === self::ROLE_SUPER_ADMIN;
    }

    /**
     * Check if user is Kepala Unit Sekolah
     */
    public function isHeadmaster(): bool
    {
        return $this->role === self::ROLE_HEADMASTER || $this->role === self::ROLE_SUPER_ADMIN;
    }

    /**
     * Check permission access for SmartEdu modules
     */
    public function canAccessModule(string $module): bool
    {
        if ($this->role === self::ROLE_SUPER_ADMIN) {
            return true;
        }

        $modulePermissions = [
            'dashboard' => [
                self::ROLE_SUPER_ADMIN, self::ROLE_YAYASAN_CHAIRMAN, self::ROLE_HEADMASTER,
                self::ROLE_STAFF_TU, self::ROLE_STAFF_KEUANGAN, self::ROLE_TEACHER,
                self::ROLE_GURU_BK, self::ROLE_MUSYRIF_ASRAMA, self::ROLE_PETUGAS_PERPUS,
                self::ROLE_PETUGAS_KANTIN, self::ROLE_PANITIA_PPDB, self::ROLE_PETUGAS_SARPRAS,
            ],
            'master' => [
                self::ROLE_SUPER_ADMIN, self::ROLE_HEADMASTER, self::ROLE_STAFF_TU,
            ],
            'academic' => [
                self::ROLE_SUPER_ADMIN, self::ROLE_HEADMASTER, self::ROLE_STAFF_TU, self::ROLE_TEACHER,
            ],
            'attendance' => [
                self::ROLE_SUPER_ADMIN, self::ROLE_HEADMASTER, self::ROLE_STAFF_TU, self::ROLE_TEACHER, self::ROLE_GURU_BK,
            ],
            'finance' => [
                self::ROLE_SUPER_ADMIN, self::ROLE_YAYASAN_CHAIRMAN, self::ROLE_STAFF_KEUANGAN,
            ],
            'savings' => [
                self::ROLE_SUPER_ADMIN, self::ROLE_STAFF_KEUANGAN,
            ],
            'canteen' => [
                self::ROLE_SUPER_ADMIN, self::ROLE_STAFF_KEUANGAN, self::ROLE_PETUGAS_KANTIN,
            ],
            'cbt_ppdb' => [
                self::ROLE_SUPER_ADMIN, self::ROLE_HEADMASTER, self::ROLE_STAFF_TU, self::ROLE_PANITIA_PPDB,
            ],
            'hris' => [
                self::ROLE_SUPER_ADMIN, self::ROLE_YAYASAN_CHAIRMAN, self::ROLE_HEADMASTER, self::ROLE_STAFF_KEUANGAN,
            ],
            'sarpras' => [
                self::ROLE_SUPER_ADMIN, self::ROLE_YAYASAN_CHAIRMAN, self::ROLE_HEADMASTER, self::ROLE_PETUGAS_SARPRAS,
            ],
            'library' => [
                self::ROLE_SUPER_ADMIN, self::ROLE_HEADMASTER, self::ROLE_PETUGAS_PERPUS, self::ROLE_TEACHER,
            ],
            'lms' => [
                self::ROLE_SUPER_ADMIN, self::ROLE_HEADMASTER, self::ROLE_TEACHER,
            ],
            'bk' => [
                self::ROLE_SUPER_ADMIN, self::ROLE_HEADMASTER, self::ROLE_GURU_BK, self::ROLE_TEACHER,
            ],
            'bpi' => [
                self::ROLE_SUPER_ADMIN, self::ROLE_HEADMASTER, self::ROLE_TEACHER, self::ROLE_MUSYRIF_ASRAMA,
            ],
            'letters' => [
                self::ROLE_SUPER_ADMIN, self::ROLE_YAYASAN_CHAIRMAN, self::ROLE_HEADMASTER, self::ROLE_STAFF_TU,
            ],
            'settings' => [
                self::ROLE_SUPER_ADMIN, self::ROLE_YAYASAN_CHAIRMAN, self::ROLE_HEADMASTER, self::ROLE_STAFF_TU,
            ],
        ];

        $allowedRoles = $modulePermissions[$module] ?? [self::ROLE_SUPER_ADMIN];

        return in_array($this->role, $allowedRoles, true);
    }

    /**
     * Check if user is allowed to manage a specific school unit
     */
    public function canManageUnit(int|string|null $schoolId): bool
    {
        if ($this->isSuperAdmin() || $this->role === self::ROLE_YAYASAN_CHAIRMAN || is_null($this->school_id)) {
            return true;
        }

        if (is_null($schoolId) || $schoolId === 'all') {
            return false;
        }

        return (int)$this->school_id === (int)$schoolId;
    }

    /**
     * Get the effective school ID for database queries
     */
    public function getEffectiveSchoolId(): ?int
    {
        if ($this->school_id) {
            return (int)$this->school_id;
        }

        $sessionVal = session('dashboard_school_id', 'all');
        return ($sessionVal === 'all' || empty($sessionVal)) ? null : (int)$sessionVal;
    }

    /**
     * Human-friendly Indonesian role label
     */
    public function getRoleNameLabelAttribute(): string
    {
        return match ($this->role) {
            self::ROLE_SUPER_ADMIN => '👑 Super Admin IT',
            self::ROLE_YAYASAN_CHAIRMAN => '🏛️ Ketua Yayasan',
            self::ROLE_HEADMASTER => '🏫 Kepala Sekolah' . ($this->school ? ' ' . $this->school->code : ''),
            self::ROLE_STAFF_TU => '📋 Tata Usaha (TU)',
            self::ROLE_STAFF_KEUANGAN => '💰 Bendahara / Keuangan',
            self::ROLE_TEACHER => '👨‍🏫 Dewan Guru',
            self::ROLE_GURU_BK => '👥 Guru BK (Konseling)',
            self::ROLE_MUSYRIF_ASRAMA => '🕌 Pembina Asrama / Musyrif',
            self::ROLE_PETUGAS_PERPUS => '📚 Pustakawan',
            self::ROLE_PETUGAS_KANTIN => '🍽️ Kasir Kantin RFID',
            self::ROLE_PANITIA_PPDB => '🎯 Panitia PPDB & CBT',
            self::ROLE_PETUGAS_SARPRAS => '🏢 Pengelola Sarpras & Aset',
            default => 'Pengguna ' . $this->role,
        };
    }

    /**
     * Tailwind role badge class
     */
    public function getRoleBadgeClassAttribute(): string
    {
        return match ($this->role) {
            self::ROLE_SUPER_ADMIN => 'bg-rose-500/20 text-rose-300 border-rose-500/40',
            self::ROLE_YAYASAN_CHAIRMAN => 'bg-purple-500/20 text-purple-300 border-purple-500/40',
            self::ROLE_HEADMASTER => 'bg-blue-500/20 text-blue-300 border-blue-500/40',
            self::ROLE_STAFF_TU => 'bg-cyan-500/20 text-cyan-300 border-cyan-500/40',
            self::ROLE_STAFF_KEUANGAN => 'bg-emerald-500/20 text-emerald-300 border-emerald-500/40',
            self::ROLE_TEACHER => 'bg-amber-500/20 text-amber-300 border-amber-500/40',
            self::ROLE_GURU_BK => 'bg-orange-500/20 text-orange-300 border-orange-500/40',
            self::ROLE_MUSYRIF_ASRAMA => 'bg-teal-500/20 text-teal-300 border-teal-500/40',
            self::ROLE_PETUGAS_PERPUS => 'bg-indigo-500/20 text-indigo-300 border-indigo-500/40',
            self::ROLE_PETUGAS_KANTIN => 'bg-pink-500/20 text-pink-300 border-pink-500/40',
            self::ROLE_PANITIA_PPDB => 'bg-violet-500/20 text-violet-300 border-violet-500/40',
            self::ROLE_PETUGAS_SARPRAS => 'bg-slate-500/20 text-slate-300 border-slate-500/40',
            default => 'bg-slate-500/20 text-slate-300 border-slate-500/40',
        };
    }
}
