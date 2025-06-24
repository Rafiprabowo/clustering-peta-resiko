<?php

namespace Database\Seeders;

use App\Models\MasterIku;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterIkuData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $list_iku = [
    [
        'kode_iku' => 'IKU 1',
        'uraian' => 'Persentase lulusan S1 dan D4/D3/D2/D1 yang berhasil memiliki pekerjaan; melanjutkan studi; atau menjadi wiraswasta',
    ],
    [
        'kode_iku' => 'IKU 1.1',
        'uraian' => 'Persentase lulusan D4/D3/D2 yang berhasil mendapat pekerjaan sesuai kriteria IKU',
    ],
    [
        'kode_iku' => 'IKU 1.2',
        'uraian' => 'Persentase lulusan D4/D3/D2 yang melanjutkan studi',
    ],
    [
        'kode_iku' => 'IKU 1.3',
        'uraian' => 'Persentase lulusan D4/D3/D2 yang menjadi wiraswasta',
    ],
    [
        'kode_iku' => 'IKT 1.1',
        'uraian' => 'Jumlah lulusan D4/D3/D2 yang berhasil mendapat pekerjaan',
    ],
    [
        'kode_iku' => 'IKT 1.2',
        'uraian' => 'Jumlah lulusan D4/D3/D2 yang melanjutkan studi',
    ],
    [
        'kode_iku' => 'IKT 1.3',
        'uraian' => 'Jumlah lulusan D4/D3/D2 yang menjadi wiraswasta',
    ],
    [
        'kode_iku' => 'IKT 1.4',
        'uraian' => 'Jumlah lulusan D4/D3/D2 bekerja di perusahaan multinasional dan melanjutkan studi di luar negeri',
    ],
    [
        'kode_iku' => 'IKT 1.5',
        'uraian' => 'Jumlah Program Studi Profesi/S2/S3',
    ],
    [
        'kode_iku' => 'IKT 1.6',
        'uraian' => 'Jumlah Mahasiswa Kelas Kerjasama/Ikatan Dinas dalam Satu Angkatan',
    ],
    [
        'kode_iku' => 'IKT 1.7',
        'uraian' => 'Jumlah Prodi dengan Kelas Internasional',
    ],
    [
        'kode_iku' => 'IKT 1.8',
        'uraian' => 'Jumlah perusahaan yang melakukan rekrutmen lulusan',
    ],
    [
        'kode_iku' => 'IKT 1.9',
        'uraian' => 'Jumlah skema sertifikasi sesuai rumpun ilmu',
    ],
    [
        'kode_iku' => 'IKU 2',
        'uraian' => 'Persentase mahasiswa S1 dan D4/D3/D2/D1 yang menjalankan kegiatan pembelajaran di luar program studi; atau meraih prestasi',
    ],
    ['kode_iku' => 'IKU 2.1', 'uraian' => 'Persentase mahasiswa yang menempuh minimal 10 sks untuk mahasiswa D4/D3 dan 5 sks untuk mahasiswa D2'],
    ['kode_iku' => 'IKU 2.2', 'uraian' => 'Persentase mahasiswa D4/D3/D2 yang mengikuti magang wajib 10 sks'],
    ['kode_iku' => 'IKU 2.3', 'uraian' => 'Persentase mahasiswa D4/D3/D2 meraih prestasi tingkat nasional/provinsi'],
    ['kode_iku' => 'IKU 2.4', 'uraian' => 'Persentase mahasiswa D4/D3/D2 meraih prestasi tingkat internasional'],
    ['kode_iku' => 'IKU 2.5', 'uraian' => 'Persentase mahasiswa inbound DN dan LN'],

    [
        'kode_iku' => 'IKU 3',
        'uraian' => 'Persentase dosen yang berkegiatan tridharma di perguruan tinggi lain, bekerja sebagai praktisi di dunia industri, atau membimbing mahasiswa berkegiatan di luar program studi',
    ],
    ['kode_iku' => 'IKU 3.1', 'uraian' => 'Persentase dosen berkegiatan tridharma di perguruan tinggi lain, bekerja sebagai praktisi di dunia industri'],
    ['kode_iku' => 'IKU 3.2', 'uraian' => 'Persentase dosen membimbing mahasiswa berkegiatan di luar program studi (MBKM, kompetisi, produk, sertikom)'],

    [
        'kode_iku' => 'IKU 4',
        'uraian' => 'Persentase dosen yang memiliki sertifikat kompetensi/profesi yang diakui oleh dunia usaha dan dunia industri atau persentase pengajar yang berasal dari kalangan praktisi profesional, dunia usaha, atau dunia industri',
    ],
    ['kode_iku' => 'IKU 4.1', 'uraian' => 'Persentase dosen bersertifikat kompetensi/profesi/industri'],
    ['kode_iku' => 'IKU 4.2', 'uraian' => 'Persentase praktisi industri sebagai dosen'],

    [
        'kode_iku' => 'IKU 5',
        'uraian' => 'Jumlah keluaran dosen yang berhasil mendapatkan rekognisi internasional atau diterapkan oleh masyarakat/industri/pemerintah per jumlah dosen',
    ],

    [
        'kode_iku' => 'IKU 6',
        'uraian' => 'Jumlah kerjasama per program studi S1 dan D4/D3/D2/D1',
    ],
     [
        'kode_iku' => 'IKU 7',
        'uraian' => 'Persentase mata kuliah S1 dan D4/D3/D2/D1 yang menggunakan metode pembelajaran pemecahan kasus (case method) atau pembelajaran kelompok berbasis project (team-based project) sebagai bagian dari bobot evaluasi',
    ],
    [
        'kode_iku' => 'IKU 7.1',
        'uraian' => 'Persentase mata kuliah D4/D3/D2 yang menggunakan metode pembelajaran pemecahan kasus atau pembelajaran kelompok berbasis project sebagai bagian dari bobot evaluasi',
    ],
    [
        'kode_iku' => 'IKT 7.1',
        'uraian' => 'Jumlah mata kuliah D4/D3/D2 yang menggunakan metode pembelajaran pemecahan kasus atau pembelajaran kelompok berbasis project sebagai bagian dari bobot evaluasi',
    ],
    [
        'kode_iku' => 'IKT 7.2',
        'uraian' => 'Jumlah mata kuliah yang menggunakan Buku Ajar/Modul Ajar/Book Chapter hasil penelitian/PkM',
    ],
    [
        'kode_iku' => 'IKT 7.3',
        'uraian' => 'Jumlah prodi dengan kurikulum sesuai standar',
    ],
    [
        'kode_iku' => 'IKT 7.4',
        'uraian' => 'Jumlah buku ajar ber-ISBN baru berbahasa Indonesia',
    ],
    [
        'kode_iku' => 'IKT 7.5',
        'uraian' => 'Jumlah buku ajar ber-ISBN baru berbahasa Inggris',
    ],
    [
        'kode_iku' => 'IKT 7.6',
        'uraian' => 'Jumlah koleksi pustaka hard copy dan e-book',
    ],
    [
        'kode_iku' => 'IKT 7.7',
        'uraian' => 'Jumlah e-journal yang dilanggan',
    ],
    [
        'kode_iku' => 'IKT 7.8',
        'uraian' => 'Persentase digitalisasi perpustakaan',
    ],
    [
        'kode_iku' => 'IKT 7.9',
        'uraian' => 'Jumlah mata kuliah online open course',
    ],
    [
        'kode_iku' => 'IKT 7.10',
        'uraian' => 'Jumlah dosen menggunakan bahan ajar elektronik/digital karya dosen',
    ],
    [
        'kode_iku' => 'IKT 7.11',
        'uraian' => 'Jumlah TEFA yang dapat menghasilkan revenue generating',
    ],
    [
        'kode_iku' => 'IKU 8',
        'uraian' => 'Persentase program studi S1 dan D4/D3 yang memiliki akreditasi atau sertifikasi internasional yang diakui pemerintah',
    ],
    [
        'kode_iku' => 'IKU 8.1',
        'uraian' => 'Persentase program studi yang telah terakreditasi atau tersertifikasi internasional dan diakui pemerintah',
    ],
    [
        'kode_iku' => 'IKT 8.1',
        'uraian' => 'Jumlah prodi terakreditasi Internasional',
    ],
    [
        'kode_iku' => 'IKT 8.2',
        'uraian' => 'Akreditasi institusi',
    ],
    [
        'kode_iku' => 'IKT 8.3',
        'uraian' => 'Jumlah prodi terakreditasi Unggul',
    ],
    [
        'kode_iku' => 'IKT 8.4',
        'uraian' => 'Sertifikasi untuk Standar Mutu Institusi',
    ],
    [
        'kode_iku' => 'IKT 8.5',
        'uraian' => 'Peringkat Institusi di Perangkingan Internasional Webometrics',
    ],
    [
        'kode_iku' => 'IKT 8.6',
        'uraian' => 'Peringkat Institusi di Perangkingan Internasional AppliedHE',
    ],
    [
        'kode_iku' => 'IKT 8.7',
        'uraian' => 'Persentase kesiapan laboratorium/bengkel/studio yang berstandar/bersertifikasi internasional',
    ],
    [
        'kode_iku' => 'IKT 8.8',
        'uraian' => 'Jumlah auditor mutu internal',
    ],
    [
        'kode_iku' => 'IKT 8.9',
        'uraian' => 'Persentase alat laboratorium / bengkel / studio yang Berfungsi dengan Baik',
    ],
    [
        'kode_iku' => 'IKT 8.10',
        'uraian' => 'Jumlah Alat laboratorium / bengkel / studio yang Terdigitalisasi / Modern',
    ],
    [
        'kode_iku' => 'IKT 8.11',
        'uraian' => 'Jumlah kapasitas bandwith dan infrastruktur pendukung',
    ],
    [
        'kode_iku' => 'IKT 8.12',
        'uraian' => 'Luas tanah',
    ],
    [
        'kode_iku' => 'IKT 8.13',
        'uraian' => 'Luas gedung',
    ],
    [
        'kode_iku' => 'IKU 9',
        'uraian' => 'Predikat SAKIP',
    ],
    [
        'kode_iku' => 'IKU 9.1',
        'uraian' => 'Hasil evaluasi implementasi SAKIP oleh Kemenpan bernilai BB',
    ],
    [
        'kode_iku' => 'IKT 9.1',
        'uraian' => 'Nilai akuntabilitas pada aspek perencanaan dan implementasi kinerja',
    ],
    [
        'kode_iku' => 'IKT 9.2',
        'uraian' => 'Nilai akuntabilitas pada aspek pengukuran kinerja',
    ],
    [
        'kode_iku' => 'IKT 9.3',
        'uraian' => 'Nilai akuntabilitas pada aspek pelaporan kinerja',
    ],
    [
        'kode_iku' => 'IKT 9.4',
        'uraian' => 'Nilai akuntabilitas pada aspek evaluasi kinerja internal',
    ],
    [
        'kode_iku' => 'IKT 9.5',
        'uraian' => 'Persentase capaian kinerja institusi',
    ],
    [
        'kode_iku' => 'IKT 9.6',
        'uraian' => 'Predikat atas hasil audit Laporan Keuangan',
    ],
    [
        'kode_iku' => 'IKT 9.7',
        'uraian' => 'Jumlah tenaga kependidikan dengan jabatan fungsional',
    ],
    [
        'kode_iku' => 'IKU 10',
        'uraian' => 'Nilai Kinerja Anggaran atas Pelaksanaan RKA-K/L',
    ],
    [
        'kode_iku' => 'IKT 10.1',
        'uraian' => 'Nilai Kinerja Anggaran (NKA) aspek Efektivitas',
    ],
    [
        'kode_iku' => 'IKT 10.2',
        'uraian' => 'Nilai Kinerja Anggaran (NKA) aspek Efisiensi',
    ],
    [
        'kode_iku' => 'IKT 10.3',
        'uraian' => 'IKPA aspek Kualitas Perencanaan',
    ],
    [
        'kode_iku' => 'IKT 10.4',
        'uraian' => 'IKPA aspek Kualitas Pelaksanaan Anggaran',
    ],
    [
        'kode_iku' => 'IKT 10.5',
        'uraian' => 'IKPA aspek Kualitas Hasil',
    ],
    [
        'kode_iku' => 'IKT 10.6',
        'uraian' => 'IKPA aspek Capaian Output',
    ],
    [
        'kode_iku' => 'IKT 10.7',
        'uraian' => 'Jumlah paket hibah pengembangan sarana dan prasarana',
    ],
    [
        'kode_iku' => 'IKT 10.8',
        'uraian' => 'Rasio Pendapatan BLU terhadap Biaya Operasional (POBO)',
    ],
    [
        'kode_iku' => 'IKT 10.9',
        'uraian' => 'Jumlah pendapatan BLU',
    ],
    [
        'kode_iku' => 'IKT 10.10',
        'uraian' => 'Jumlah pendapatan BLU yang berasal dari pengelolaan aset',
    ],
    [
        'kode_iku' => 'IKT 10.11',
        'uraian' => 'Persentase penyelesaian modernisasi pengelolaan BLU',
    ],
    [
        'kode_iku' => 'IKT 10.12',
        'uraian' => 'Indeks Akurasi Proyeksi Pendapatan BLU',
    ],
    [
        'kode_iku' => 'IKT 10.13',
        'uraian' => 'Tingkat kematangan BLU',
    ],
    [
        'kode_iku' => 'IKT 10.14',
        'uraian' => 'Tingkat kematangan domain proses/IT Maturity Index',
    ],
    [
        'kode_iku' => 'IKT 10.15',
        'uraian' => 'Indeks jejak karbon',
    ],
    [
        'kode_iku' => 'IKU 11',
        'uraian' => 'Nilai evaluasi Zona Integritas hasil asesmen asesor Unit Utama minimal 75',
    ],
    [
        'kode_iku' => 'IKT 11.1',
        'uraian' => 'Pemenuhan aspek pengungkit manajemen perubahan',
    ],
    [
        'kode_iku' => 'IKT 11.2',
        'uraian' => 'Persentase proses bisnis yang telah memiliki SOP',
    ],
    [
        'kode_iku' => 'IKT 11.3',
        'uraian' => 'Persentase proses bisnis dengan SOP yang telah diimplementasikan',
    ],
    [
        'kode_iku' => 'IKT 11.4',
        'uraian' => 'Jumlah pelayanan yang menggunakan teknologi informasi',
    ],
    [
        'kode_iku' => 'IKT 11.5',
        'uraian' => 'Persentase layanan keterbukaan informasi publik yang terselesaikan',
    ],
    [
        'kode_iku' => 'IKT 11.6',
        'uraian' => 'Persentase pemenuhan aspek pengungkit manajemen sumber daya manusia',
    ],
    [
        'kode_iku' => 'IKT 11.7',
        'uraian' => 'Persentase berjalannya fungsi pengendalian internal',
    ],
    [
        'kode_iku' => 'IKT 11.8',
        'uraian' => 'Persentase pemenuhan aspek pelayanan prima',
    ],
    [
        'kode_iku' => 'IKT 11.9',
        'uraian' => 'Indeks kepuasan mahasiswa',
    ],
    [
        'kode_iku' => 'IKT 11.10',
        'uraian' => 'Indeks kepuasan dosen dan tenaga kependidikan',
    ],
    [
        'kode_iku' => 'IKT 11.11',
        'uraian' => 'Indeks kepuasan mitra kerja sama',
    ],
    [
        'kode_iku' => 'IKT 11.12',
        'uraian' => 'Indeks kepuasan mitra pengguna lulusan',
    ],
    [
        'kode_iku' => 'IKT 11.13',
        'uraian' => 'Nilai persepsi korupsi',
    ],
    [
        'kode_iku' => 'IKT 11.14',
        'uraian' => 'Persentase Penyelesaian Tindak Lanjut Hasil Pemeriksaan APIP',
    ],
    [
        'kode_iku' => 'IKT 11.15',
        'uraian' => 'Persentase Penyelesaian Tindak Lanjut Hasil Pemeriksaan SPI',
    ],
];

    foreach($list_iku as $key => $value){
        MasterIku::create($value);
    }


    }
}
