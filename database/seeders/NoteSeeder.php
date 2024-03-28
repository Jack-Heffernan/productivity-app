<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('notes')->insert([
            'title' => Str::random(10),
            'content' => Str::random(10),
            // 'user_id' => 1,
            // 'category_id' => 1,
        ]);
    }
}
