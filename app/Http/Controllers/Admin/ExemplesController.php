<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExemplesController extends Controller
{
    /**
     * Afficher la page d'exemples d'éléments UI
     *
     * @return \Illuminate\View\View
     */
    public function uiElements()
    {
        return view('admin.exemples.ui-elements');
    }
}

