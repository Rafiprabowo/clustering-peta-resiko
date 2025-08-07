<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuData extends Seeder
{
    public function run()
    {
        $menu = [
            [
                'id' => 1,
                'name' => 'Dashboard',
                'link' => '/dashboard',
                'icon' => 'fas fa-gauge',
            ],
            [
                'id' => 2,
                'name' => 'Rencana Kegiatan',
                'link' => '/posts',
                'icon' => 'fas fa-list-check',
            ],
            [
                'id' => 3,
                'name' => 'Tindak Lanjut',
                'link' => '/tindak-lanjut',
                'icon' => 'fas fa-notes-medical',
            ],
            [
                'id' => 4,
                'name' => 'RTM',
                'link' => '/rtm',
                'icon' => 'fas fa-toolbox',
            ],

            // --- Static Dropdown: PETA RISIKO ---
            [
                'id' => 21,
                'name' => 'Analisis Peta Risiko',
                'link' => '/analisis',
                'icon' => '',
            ],
            [
                'id' => 7,
                'name' => 'Peta Risiko',
                'link' => '/petas',
                'icon' => 'far fa-newspaper',
            ],

            // --- Static Dropdown: CLUSTERING ---
            [
                'id' => 20,
                'name' => 'Unggah Dataset',
                'link' => '/dataset',
                'icon' => '',
            ],

            [
                'id' => 25,
                'name' => 'Proses Clustering',
                'link' => '/proses-clustering',
                'icon' => '',
            ],

            [
                'id' => 26,
                'name' => 'Riwayat Clustering',
                'link' => '/riwayat-clustering',
                'icon' => '',
            ],


            [
                'id' => 8,
                'name' => 'Dokumen Reviu',
                'link' => '/dokumens',
                'icon' => 'fas fa-file',
            ],
            [
                'id' => 9,
                'name' => 'Setting Menu',
                'link' => '/admin/panel',
                'icon' => 'fas fa-gear',
            ],
            [
                'id' => 10,
                'name' => 'Manajemen User',
                'link' => '/users',
                'icon' => 'fas fa-user',
            ],
            [
                'id' => 17,
                'name' => 'Unit Kerja',
                'link' => '/unit-kerja',
                'icon' => 'far fa-bookmark',
            ],
            [
                'id' => 18,
                'name' => 'Maturity Rating',
                'link' => '/MR',
                'icon' => 'fas fa-star',
            ],
            [
                'id' => 19,
                'name' => 'Template Dokumen',
                'link' => '/template-dokumen',
                'icon' => 'fas fa-paste',
            ],

            [
                'id' => 22,
                'name' => 'Manual Book',
                'link' => '/manual-book',
                'icon' => 'fas fa-book-open',
            ],
            [
                'id' => 23,
                'name' => 'Kuisioner',
                'link' => '/kuisioner',
                'icon' => 'fas fa-clipboard-list',
            ],

        ];

        foreach ($menu as $value) {
            Menu::create($value);
        }
    }
}
