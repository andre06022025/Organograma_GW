<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;

class Organograma2Controller extends Controller
{
    public function index()
    {
        $arvore = Colaborador::getArvoreOrganograma();

        return view('organograma2.index', compact('arvore'));
    }
}
