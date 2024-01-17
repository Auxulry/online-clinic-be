<?php

namespace Database\Seeders;

use App\Models\Poli;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PoliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Poli::create([
            'name' => 'Poli Umum',
            'doctor_name' => 'Ahmad',
            'image' => 'dump/online-clinic-sample-1.png',
        ]);
        Poli::create([
            'name' => 'Poli Kandungan',
            'doctor_name' => 'Ahmad',
            'image' => 'dump/online-clinic-sample-2.png',
        ]);
        Poli::create([
            'name' => 'Poli Gigi',
            'doctor_name' => 'Ahmad',
            'image' => 'dump/online-clinic-sample-3.png',
        ]);
        Poli::create([
            'name' => 'Poli THT',
            'doctor_name' => 'Ahmad',
            'image' => 'dump/online-clinic-sample-3.png',
        ]);
    }
}
