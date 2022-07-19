<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'first_name'        => 'Admin',
            'last_name'         => 'admin',
            'birthday'          => '66.66.1666',
            'district_id'       => 1,
            'address'           => 'test Address',
            'uuid'              => Str::uuid(),
            'phone'             => '+7(999)9999999',
            'email'             => 'testless@test.ru',
            'email_verified_at' => now(),
            'password'          => password_hash('testless', PASSWORD_DEFAULT),
            'is_admin'          => true,
            'is_active'         => true,
            'ip_address'        => '127.0.0.1',
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
