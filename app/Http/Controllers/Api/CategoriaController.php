<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Http\Resources\CategoriaResource;
use App\Http\Resources\CategoriaCollection;

class CategoriaController extends Controller
{
    public function index(){
        return new CategoriaCollection(Categoria::all());
    }
}