<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $counter = 0;
        while($counter < 50)
        {
            Post::create([
                'title' => fake()->title(),
                'uuid' => Str::uuid(),
                'user_id' => rand(1,9),
                'description' => implode("\n\n", fake()->paragraphs(3)), 
             ]);
            $counter++;
        }
    }
}
