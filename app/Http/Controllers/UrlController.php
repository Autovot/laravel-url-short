<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
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
        } else {
            // var_dump($urlCheck);
            var_dump("No deberias estar aqui");
        }
        // Main `RETURN` si todo esta correcto devuelve el json
        return response()->json([
            'status' => 'created',
            'smashed' => Url::where('smashed', $urlOuput)->first()->smashed,
        ]);
    }


    public function checkDB($smashed)
    {
        return Url::where('smashed', $smashed)->first();
    }

    //
    public function incrementUsed($smashed)
    {
        $urlModel = Url::where('smashed', $smashed)->first();
        if ($urlModel) {
            $url = $urlModel->value('origin');
            $urlModel->increment('used');
            return redirect($url)->with('success', 'Se ha encontrado una url acortada, incrementando uso y redireccionando a la ruta');
        } else {
            Log::error('URL model not found for smashed value: ' . $smashed);
            return redirect()->route('main')->with('error', 'No se ha encontrado ninguna url acortada con esa id');
        }
    }
}
