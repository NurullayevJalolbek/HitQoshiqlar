<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('languages')->insert([
            [
                'name' => 'O\'zbek',
                'url' => 'uz',
                'icon' => 'https://flagcdn.com/uz.svg',
                'default' => true,
                'status' => 'active',
            ],
            [
                'name' => 'Русский',
                'url' => 'ru',
                'icon' => 'https://flagcdn.com/ru.svg',
                'default' => false,
                'status' => 'active',
            ],
            [
                'name' => 'English',
                'url' => 'en',
                'icon' => 'https://flagcdn.com/gb.svg',
                'default' => false,
                'status' => 'active',
            ],
            [
                'name' => 'العربية',
                'url' => 'ar',
                'icon' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Flag_of_Saudi_Arabia.svg',
                'default' => false,
                'status' => 'active',
            ],
        ]);

        $id = DB::table('languages')->orderBy('id', 'desc')->first()?->id;
        DB::statement('alter sequence languages_id_seq restart with ' . ($id + 1));
    }

}
