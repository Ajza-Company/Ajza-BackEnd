<?php

namespace Database\Factories;

use App\Models\AccountDeletionRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountDeletionRequestFactory extends Factory
{
    protected $model = AccountDeletionRequest::class;

    public function definition(): array
    {
        $requestedAt = $this->faker->dateTimeBetween('-30 days', 'now');
        $scheduledDeletionAt = $requestedAt->modify('+15 days');
        
        return [
            'user_id' => User::factory(),
            'requested_at' => $requestedAt,
            'scheduled_deletion_at' => $scheduledDeletionAt,
            'status' => $this->faker->randomElement(['pending', 'cancelled', 'completed']),
            'reason' => $this->faker->optional()->sentence(),
            'cancelled_at' => null,
            'completed_at' => null,
        ];
    }

    public function pending()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'pending',
                'cancelled_at' => null,
                'completed_at' => null,
            ];
        });
    }

    public function cancelled()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'cancelled',
                'cancelled_at' => $this->faker->dateTimeBetween($attributes['requested_at'], 'now'),
                'completed_at' => null,
            ];
        });
    }

    public function completed()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'completed',
                'cancelled_at' => null,
                'completed_at' => $this->faker->dateTimeBetween($attributes['requested_at'], 'now'),
            ];
        });
    }
}
