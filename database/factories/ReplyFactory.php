<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Reply;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reply>
 */
class ReplyFactory extends Factory
{

    protected $model = Reply::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fn () => User::factory()->create()->id,
            'comment_id' => fn () => Comment::factory()->create()->id,
            'reply_text' => $this->faker->text()
        ];
    }
}
