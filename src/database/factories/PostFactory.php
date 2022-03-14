<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Categoria;

class PostFactory extends Factory
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
            'titulo' => $this->faker->title(),
            'contenido' => $this->faker->sentence(),
            'Categorias_id' => Categoria::inRandomOrder()->first()->id,
            'fecha_creacion' => $date_,
            'fecha_actualizacion' => $date_
        ];
    }
}
