<?php

namespace Database\Factories\Dealskoo\Tag\Models;

use Dealskoo\Country\Models\Country;
use Dealskoo\Tag\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tag::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'slug' => $this->faker->unique()->slug(),
            'name' => $this->faker->name,
            'country_id' => Country::factory(),
        ];
    }
}
