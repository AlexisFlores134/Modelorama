<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mercancia extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre', 
        'precio', 
        'cantidad',
        'tipo_id'];
    public function categorias(){
        return $this->belongsToMany(Categoria::class);
    }
}
