<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            // Password diset ke 'warga123' biar gampang testing
            'password' => static::$password ??= Hash::make('warga123'),
            'remember_token' => Str::random(10),
            
            // --- DATA TAMBAHAN WARGA KAS RT ---
            'role' => 'warga',
            'alamat' => fake()->address(),
            'tanggal_lahir' => fake()->dateTimeBetween('-50 years', '-20 years')->format('Y-m-d'), // Umur acak 20-50 thn
            'jenis_kelamin' => fake()->randomElement(['Laki-laki', 'Perempuan']),
            'no_telp' => fake()->numerify('08##########'), // Bikin nomor HP acak awalan 08
            'agama' => fake()->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha']),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}