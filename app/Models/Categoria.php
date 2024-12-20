<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    protected $fillable = ['tipo'];
    public function mercancias(){
        return $this->hasMany(Mercancia::class, 'tipo_id');
    }
}
