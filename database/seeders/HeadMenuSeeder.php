<?php

namespace Database\Seeders;

use App\Models\Head_menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HeadMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Head_menu::create([
            'name' => 'Peta Risiko',
            'icon' => 'fas fa-map', // Ganti jadi icon peta
        ]);

    }
}
