<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected  $fillable = ['titulo','contenido','Categorias_id', 'fecha_creacion', 'fecha_actualizacion'];
}
