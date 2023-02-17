<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithFaker;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->setUpFaker();

        /** @var User $user */
        $user = \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $notifications = [];

        foreach (range(1, 1000) as $i) {
            $notifications[] = Notification::make()
                    ->title($this->faker->sentence)
                    ->body($this->faker->paragraph)
                    ->getDatabaseMessage();
        }

        foreach ($notifications as $notification) {
            $user->notifications()->create([
                'id' => (string) Str::uuid(),
                'type' => 'App\Notifications\Notification',
                'data' => $notification,
                'read_at' => null,
            ]);
        }
    }
}
