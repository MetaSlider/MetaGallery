<?php

namespace Extendify\MetaGallery\Database\Factories;

namespace Extendify\MetaGallery\Database\Factories;

use Extendify\MetaGallery\Models\Gallery;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Gallery::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->name,
            'images' => $this->faker->unique()->safeEmail,
            'settings' => [],
        ];
    }
}
