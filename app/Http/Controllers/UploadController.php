<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{

    /**
     * sendFile: Método responsável por enviar o arquivo no formato base64
     */
    public function sendFile(Request $request)
    {
        if($request->has('file') && strpos($request->file, ';base64')){
            $base64 = $request->file;
            //obtem a extensão
            $extension = explode('/', $base64);
            $extension = explode(';', $extension[1]);
            $extension = '.'.$extension[0];
            //gera o nome
            $name = time().$extension;
            //obtem o arquivo
            $separatorFile = explode(',', $base64);
            $file = $separatorFile[1];
            $path = 'public/base64-files/';
            //envia o arquivo
            Storage::put($path.$name, base64_decode($file));

            return response()
            ->json(['content' => ['file' => $name], 'Message' => 'Arquivo enviado com sucesso'], 201);

        }else{
            return response()
            ->json(['message' => 'Envie o atributo file no formato base64'], 422);
        }
    }
}
