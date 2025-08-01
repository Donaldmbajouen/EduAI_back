<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categorie;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Développement Web'],
            ['name' => 'Développement Mobile'],
            ['name' => 'Design UI/UX'],
            ['name' => 'Marketing Digital'],
            ['name' => 'Gestion de Projet'],
            ['name' => 'Intelligence Artificielle'],
            ['name' => 'Cybersécurité'],
            ['name' => 'Cloud Computing'],
            ['name' => 'DevOps'],
            ['name' => 'Data Science'],
        ];

        foreach ($categories as $category) {
            Categorie::create($category);
        }
    }
}
