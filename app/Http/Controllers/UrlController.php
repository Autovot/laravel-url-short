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
        $urlInput = $request->input('url-input');
        if (!$urlInput) {
            return redirect()->route('main');
        }

        $urlOuput = md5($urlInput);

        $urlCheck = Url::where('smashed', $urlOuput)->first();
        if ($urlCheck) {
            return $urlCheck;
        }

        $urlAdd = new Url();
        $urlAdd->origin = $urlInput;
        $urlAdd->smashed = $urlOuput;
        $urlAdd->save();
        // return response()->json(['url-input' => Url::where('smashed', $urlOuput)->first()->smashed]);
        return Url::where('smashed', $urlOuput)->first();

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
