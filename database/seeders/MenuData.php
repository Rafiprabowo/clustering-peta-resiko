<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menu = [
    [
        'id' => 1,
        'name' => 'Dashboard',
        'link' => '/dashboard',
        'icon' => 'fas fa-gauge',
        'id_head_menu' => null,
    ],
    [
        'id' => 2,
        'name' => 'Rencana Kegiatan',
        'link' => '/posts',
        'icon' => 'fas fa-list-check',
        'id_head_menu' => null,
    ],
    [
        'id' => 3,
        'name' => 'Tindak Lanjut',
        'link' => '/tindak-lanjut',
        'icon' => 'fas fa-notes-medical',
        'id_head_menu' => null,
    ],
    [
        'id' => 4,
        'name' => 'RTM',
        'link' => '/rtm',
        'icon' => 'fas fa-toolbox',
        'id_head_menu' => null,
    ],
    [
    'id' => 6,
    'name' => 'Analisis Peta Risiko',
    'link' => '/analisis/petas',
    'icon' => 'fas fa-chart-pie', // Tetap
    'id_head_menu' => 1,
    ],
    [
        'id' => 7,
        'name' => 'Data Peta Risiko',
        'link' => '/petas',
        'icon' => 'fas fa-table', // Ganti jadi icon data/table
        'id_head_menu' => 1,
    ],

    [
        'id' => 8,
        'name' => 'Dokumen Reviu',
        'link' => '/dokumens',
        'icon' => 'fas fa-file',
        'id_head_menu' => null,
    ],
    [
        'id' => 9,
        'name' => 'Setting Menu',
        'link' => '/admin/panel',
        'icon' => 'fas fa-gear',
        'id_head_menu' => null,
    ],
    [
        'id' => 10,
        'name' => 'Manajemen User',
        'link' => '/users',
        'icon' => 'fas fa-user',
        'id_head_menu' => null,
    ],
    [
        'id' => 17,
        'name' => 'Unit Kerja',
        'link' => '/unit-kerja',
        'icon' => 'far fa-bookmark',
        'id_head_menu' => null,
    ],
    [
        'id' => 18,
        'name' => 'Maturity Rating',
        'link' => '/MR',
        'icon' => 'fas fa-star',
        'id_head_menu' => null,
    ],
    [
        'id' => 19,
        'name' => 'Template Dokumen',
        'link' => '/template-dokumen',
        'icon' => 'fas fa-paste',
        'id_head_menu' => null,
    ],
];

    foreach ($menu as $value) {
        Menu::create($value);
    }

    }
}
