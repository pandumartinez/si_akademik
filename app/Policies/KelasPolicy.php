<?php

namespace App\Policies;

use App\Kelas;
use App\Pengaturan;
use App\User;

class KelasPolicy
{
    public function absen(User $user, Kelas $kelas)
    {
        $userAdalahWaliKelas = $user->role === 'guru' &&
            $user->guru->kelasWali?->id === $kelas->id;

        $jam = date('H:i');
        $dalamBatasWaktu = $jam >= '07:00' && $jam <= '08:00';

        $daftarBuka = Pengaturan::getValue('daftar_buka_absen_siswa') ?? [];
        $absenDibukaAdmin = in_array($kelas->id, $daftarBuka);

        return $userAdalahWaliKelas && ($dalamBatasWaktu || $absenDibukaAdmin);
    }
}
