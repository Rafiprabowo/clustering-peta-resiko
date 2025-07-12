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
                'order' => 1,
            ],
            [
                'id' => 2,
                'name' => 'Rencana Kegiatan',
                'link' => '/posts',
                'icon' => 'fas fa-list-check',
                'order' => 2,
            ],
            [
                'id' => 3,
                'name' => 'Tindak Lanjut',
                'link' => '/tindak-lanjut',
                'icon' => 'fas fa-notes-medical',
                'order' => 3,
            ],
            [
                'id' => 4,
                'name' => 'RTM',
                'link' => '/rtm',
                'icon' => 'fas fa-toolbox',
                'order' => 4,
            ],
            // [
            //     'id' => 5,
            //     'name' => 'Master Kegiatan',
            //     'link' => '/kegiatan',
            //     'icon' => 'fas fa-paperclip',
            // ],
            // [
            //     'id' => 7,
            //     'name' => 'Peta Risiko',
            //     'link' => '/petas',
            //     'icon' => 'far fa-newspaper',
            // ],
            [
                'id' => 8,
                'name' => 'Dokumen Reviu',
                'link' => '/dokumens',
                'icon' => 'fas fa-file',
                'order' => 7,
            ],
            [
                'id' => 9,
                'name' => 'Setting Menu',
                'link' => '/admin/panel',
                'icon' => 'fas fa-gear',
                'order' => 8,
            ],
            [
                'id' => 10,
                'name' => 'Manajemen User',
                'link' => '/users',
                'icon' => 'fas fa-user',
                'order' => 9,
            ],
            [
                'id' => 17,
                'name' => 'Unit Kerja',
                'link' => '/unit-kerja',
                'icon' => 'far fa-bookmark',
                'order' => 10,
            ],
            [
                'id' => 18,
                'name' => 'Maturity Rating',
                'link' => '/MR',
                'icon' => 'fas fa-star',
                'order' => 11,
            ],
            [
                'id' => 19,
                'name' => 'Template Dokumen',
                'link' => '/template-dokumen',
                'icon' => 'fas fa-paste',
                'order' => 12,
            ],
           [
                'id' => 28,
                'name' => 'Manual Book Fitur Clustering',
                'link' => '/manual-book',
                'icon' => 'fas fa-book',
                'order' => 13,
            ],
            [
                'id' => 29,
                'name' => 'Link Kuisioner Fitur Clustering',
                'link' => '/kuisioner',
                'icon' => 'fas fa-clipboard-question',
                'order' => 14,
            ],

        ];

        foreach ($menu as $key => $value) {
            Menu::create($value);
        }
    }
}
