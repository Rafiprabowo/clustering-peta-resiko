<?php

namespace Database\Seeders;

use App\Models\Head_menu;
use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
        ]);

        Menu::create([
            'id' => 20,
            'name' => 'Clustering',
            'link' => '/clustering-peta-risiko',
            'icon' => 'fas fa-diagram-project', // Representasi proses clustering
            'id_head_menu' => 1,
        ]);

        Menu::create([
            'id' => 21,
            'name' => 'Riwayat Clustering',
            'link' => '/riwayat-clustering',
            'icon' => 'fas fa-clock-rotate-left', // Representasi riwayat / history
            'id_head_menu' => 1,
        ]);

        Menu::create([
            'id' => 22,
            'name' => 'Hasil Cluster',
            'link' => '/hasil-cluster',
            'icon' => 'fas fa-layer-group', // Representasi hasil kelompok/cluster
            'id_head_menu' => 1,
        ]);

        Menu::create([
            'id' => 23,
            'name' => 'Analisis Peta Risiko',
            'link' => '/analisis-peta-risiko',
            'icon' => 'fas fa-chart-line', // Representasi analisis risiko
            'id_head_menu' => 1,
        ]);


        Menu::create([
            'id' => 24,
            'name' => 'Data Peta Risiko',
            'link' => '/petas',
            'icon' => 'fas fa-table', // Ganti jadi icon data/table
            'id_head_menu' => 1,
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
