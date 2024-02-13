<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Url;

class UrlController extends Controller
{
    //
    public function show()
    {

    }

    // API /shortener call this function
    public function add(Request $request): JsonResponse
    {
        // TODO que solo se pueda mandar un 'url-input a la vez'
        // TODO que pasa cuando no se puede conectar a la base de datos
        $urlValidate = Validator::make($request->all(), [
            'url-input' => 'required|url' // URL localhost con active_url no rula
        ]);

        if ($urlValidate->fails()) {
            return response()->json([
                'status' => 'incorrect',
            ]);
        }


        $urlInput = $request->input('url-input');
        $urlOuput = md5($urlInput);
        $urlCheck = Url::where('smashed', $urlOuput)->first();
        if (!$urlCheck) {
            $urlAdd = new Url();
            $urlAdd->origin = $urlInput;
            $urlAdd->smashed = $urlOuput;
            $urlAdd->save();
        }
        // Main `RETURN` si todo esta correcto devuelve el json
        return response()->json([
            'status' => 'created',
            'smashed' => Url::where('smashed', $urlOuput)->first()->smashed,
        ]);
        // return Url::where('smashed', $urlOuput)->first();

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
