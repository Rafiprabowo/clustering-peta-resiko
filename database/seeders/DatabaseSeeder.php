<?php

namespace Database\Seeders;

use App\Models\Head_menu;
use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use PhpOffice\PhpWord\Writer\HTML\Part\Head;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Head_menu::create([
            'name' => 'Peta Risiko',
            'icon' => 'fas fa-map', // Ganti jadi icon peta
            'order' => 5,
        ]);

        Menu::create([
            'id' => 23,
            'name' => 'Analisis Peta Risiko',
            'link' => '/analisis-peta-risiko',
            'icon' => 'fas fa-chart-line', // Representasi analisis risiko
            'id_head_menu' => 1,
            'order' => 1,
        ]);

        Menu::create([
            'id' => 24,
            'name' => 'Data Peta Risiko',
            'link' => '/petas',
            'icon' => 'fas fa-table', // Ganti jadi icon data/table
            'id_head_menu' => 1,
            'order' => 2,
        ]);

        Head_menu::create([
            'name' => 'Clustering',
            'icon' => 'fas fa-diagram-project',
            'order' => 6,
        ]);


        Menu::create([
            'id' => 20,
            'name' => 'Dataset',
            'link' => '/dataset',
            'icon' => 'fas fa-file-upload',
            'id_head_menu' => 2,
            'order' => 1,
        ]);

          Menu::create([
            'id' => 21,
            'name' => 'Proses Clustering',
            'link' => '/proses',
            'icon' => 'fas fa-gears',
            'id_head_menu' => 2,
            'order' => 2,

        ]);

        Menu::create([
            'id' => 22,
            'name' => 'Riwayat Clustering',
            'link' => '/riwayat',
            'icon' => 'fas fa-clock-rotate-left', // Representasi riwayat / history
            'id_head_menu' => 2,
            'order' => 3,

        ]);


        $this->call(MenuData::class);
        $this->call(LevelSeeder::class);
        $this->call(LevelMenuSeeder::class);
        $this->call(UnitKerjaData::class);
        $this->call(UserData::class);
        $this->call(PostSeeder::class);
        $this->call(ManagementElementSeeder::class);
        $this->call(ManagementSubElementSeeder::class);
        $this->call(ManagementTopicSeeder::class);
        $this->call(UraianSeeder::class);
        $this->call(ManagementPengawasanSeeder::class);
        $this->call(JenisKegiatanSeeder::class);
    }
}
