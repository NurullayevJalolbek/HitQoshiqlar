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
                'icon' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/84/Flag_of_Uzbekistan.svg/960px-Flag_of_Uzbekistan.svg.png?20250418015555',
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
        ]);

        $id = DB::table('languages')->orderBy('id', 'desc')->first()?->id;
        DB::statement('alter sequence languages_id_seq restart with ' . ($id + 1));
    }

}
