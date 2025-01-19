<?php

namespace Database\Seeders;

use App\Models\Avatar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AvatarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $name = [
            'Shu',
            'Niu',
            'Hu',
            'Tu',
            'Long',
            'She',
            'Ma',
            'Yang',
            'Hou',
            'Ji',
            'Gou',
            'Zhu'
        ];

        for ($i=1; $i <= 12; $i++) { 
            Avatar::create([
                'avatar_name' => $name[$i - 1],
                'avatar_price' => rand(50, 100000),
                'avatar_image' => '/assets/images/avatar/'.$i.'.jpg'
            ]);
        }
    }
}
