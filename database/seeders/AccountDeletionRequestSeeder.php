<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\AccountDeletionRequest;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountDeletionRequestSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $clientUsers = User::whereHas('roles', function ($query) {
            $query->where('name', 'Client');
        })->get();

        if ($clientUsers->isEmpty()) {
            $clientUser = User::create([
                'name' => 'Test Client',
                'email' => 'client@test.com',
                'full_mobile' => '+966501234501',
                'password' => 'password123',
                'is_active' => true,
                'is_registered' => true,
            ]);
            $clientUser->assignRole(RoleEnum::CLIENT);
            $clientUsers = collect([$clientUser]);
            
            $this->command->info('Created test client user: client@test.com / password123');
        }

        foreach ($clientUsers->take(3) as $user) {
            $requestedAt = now()->subDays(5);
            $scheduledAt = $requestedAt->copy()->addDays(15);
            
            AccountDeletionRequest::factory()->create([
                'user_id' => $user->id,
                'status' => 'pending',
                'requested_at' => $requestedAt,
                'scheduled_deletion_at' => $scheduledAt,
                'reason' => fake()->optional()->sentence()
            ]);
        }

        $this->command->info('Account deletion requests seeded successfully!');
    }
}
