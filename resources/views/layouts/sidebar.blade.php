@php
    $user = Auth::user();
    $role = $user->role;
@endphp

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a class="brand-link">
        <img src="{{ asset('img/emblem.png') }}" alt="Logo SMA YP 17" class="brand-image img-circle elevation-3">

        <span class="brand-text font-weight-light text-light">SMA YP 17</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-widget="treeview" data-accordion="false">
                @if ($role === 'admin')
                    <x-nav.group icon="fa-home" label="Dashboard" :patterns="['/', 'dashboard']">

                        <x-nav.item label="Home" route="home" pattern="/" />

                        <x-nav.item label="Dashboard" route="home.dashboard" pattern="dashboard" />
                    </x-nav.group>
                @elseif ($role === 'guru')
                    <x-nav.item label="Home" route="home" pattern="/" />
                @endif

                @if ($role === 'admin')
                    <x-nav.group icon="fa-edit" label="Master Data" :patterns="['master-data/*']">

                        <x-nav.item label="Data Mapel" route="mapel.index" :pattern="['master-data/mapel*','master-data/kelompok-mapel*']" />

                        <x-nav.item label="Data Guru" route="guru.index" :pattern="['master-data/guru*','master-data/jabatan*']" />

                        <x-nav.item label="Data Kelas" route="kelas.index" :pattern="['master-data/kelas*', 'master-data/siswa*', 'master-data/jadwal*']" />

                        <x-nav.item label="Data User" route="user.index" pattern="master-data/user*" />
                    </x-nav.group>
                @endif

                {{--
                @if ($role === 'guru')
                <x-nav.item label="Jadwal" icon="fas fa-calendar-alt" route="jadwal.guru" pattern="jadwal/guru" />
                @endif
                --}}

                <x-nav.item label="{{ $role === 'admin' ? 'Absensi Guru' : 'Absen' }}" icon="fas fa-calendar-check"
                    route="absen-guru.index" pattern="absen-guru" />

                @if ($role === 'admin' || ($role === 'guru' && $user->guru->kelasWali))
                    <x-nav.item label="Absen Siswa" icon="fas fa-clipboard" route="absen-siswa.index"
                        pattern="absen-siswa" />
                @endif

                <x-nav.group icon="fa-file-signature" label="Nilai & Rapot" :patterns="['nilai*', 'rapot*', 'predikat*', 'deskripsi-predikat*']">
                    <x-nav.item label="Nilai" route="nilai.index" pattern="nilai" />

                    <x-nav.item label="Rapot UTS" route="rapot-uts.index" pattern="rapot-uts" />

                    <x-nav.item label="Rapot UAS" route="rapot-uas.index" pattern="rapot-uas" />

                    @if ($role === 'admin')
                        <x-nav.item label="Predikat" route="predikat.index" pattern="predikat" />
                    @endif

                    <x-nav.item label="Deskripsi Predikat" route="deskripsi-predikat.index"
                        pattern="deskripsi-predikat" />
                </x-nav.group>

                @if ($role === 'admin')
                    <x-nav.item label="Periode" icon="fas fa-clipboard" route="periode.index" pattern="periode" />

                    <x-nav.item label="Pengumuman" icon="fas fa-clipboard" route="pengumuman.index" pattern="pengumuman" />
                @endif
            </ul>
        </nav>
    </div>
</aside>