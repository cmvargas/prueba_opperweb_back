<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoriaFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    //protected $model = Categoria::class;
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
            'nombre' => $this->faker->name(),
            'fecha_creacion' => $date_,
            'fecha_actualizacion' => $date_
        ];
    }
}
