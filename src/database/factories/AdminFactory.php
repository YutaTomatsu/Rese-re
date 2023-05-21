<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Admin;
use App\Models\User;

class AdminFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Admin::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'role' => $this->faker->randomElement(['admin', 'owner']),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Admin $admin) {
            if ($admin->id === 1) {
                $admin->user_id = 2;
                $admin->role = 'admin';
            } elseif ($admin->id === 2) {
                $admin->user_id = 3;
                $admin->role = 'owner';
            } 

            $admin->save();
        });
    }
}
