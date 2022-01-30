<?php

namespace Database\Factories;

use App\Models\BlogPost;
use App\Models\BlogPostStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogPostFactory extends Factory
{
    protected $model = BlogPost::class;

    public function definition()
    {
        return [
            'title' => $this->faker->words($this->faker->numberBetween(1,5),true),
            'date' => $this->date ?? $this->faker->date,
            'body' => $body ?? $this->faker->paragraph(),
            'author' => 'Bashar',
            'status' => $this->faker->randomElement([
                BlogPostStatus::DRAFT()['value'],
                BlogPostStatus::PUBLISHED()['value'],
            ]),
            'likes' => $this->faker->numberBetween(10,1000)
        ];
    }

    public function published()
    {
        return $this->state(function(array $attributes){
            return [
                'status' => BlogPostStatus::PUBLISHED()['value']
            ];
        });
    }

    public function draft()
    {
        return $this->state(function(array $attributes){
            return [
                'status' => BlogPostStatus::DRAFT()['value']
            ];
        });
    }
}
