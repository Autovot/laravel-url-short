<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Url;

class UrlController extends Controller
{
    //
    public function show()
    {

    }

    // API /shortener call this function
    public function add(Request $request)
    {
        // $urlInput = $request->query('url-input');
        // return $urlInput;
        return $request;
    }

    //
    public function incrementUsed($smashed)
    {
        $url = Url::where('smashed', $smashed)->increment('used');
        if ($url) {
            return redirect()->route('url')->with('success', 'Se ha encontrado una url acortada, incrementando uso y redireccionando a la ruta');
        } else {
            return redirect()->route('main')->with('error', 'No se ha encontrado ninguna url acortada con esa id');
        }
    }
}
