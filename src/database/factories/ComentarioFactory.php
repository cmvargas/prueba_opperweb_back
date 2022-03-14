<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;

class ComentarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        //$date_=date("Y-m-d h:i:s",  strtotime('-5 hour'));
        $date_=$this->faker->date('Y-m-d h:i:s');
        return [
            'contenido' => $this->faker->sentence(),
            'Posts_id' => Post::inRandomOrder()->first()->id,
            'fecha_creacion' => $date_,
            'fecha_actualizacion' => $date_
        ];
    }
}
