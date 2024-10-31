<?php

namespace Database\Seeders;

use \App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Question::create([
            'code' => null,
            'question_type' => 'text',
            'question' => 'Isikan Nama Lengkap',
            'atributs' => null,
        ]);

        Question::create([
            'code' => null,
            'question_type' => 'number',
            'question' => 'Isikan Nim',
            'atributs' => null,
        ]);

        Question::create([
            'code' => null,
            'question_type' => 'file',
            'question' => 'Upload File Foto',
            'atributs' => null,
        ]);
    }
}
