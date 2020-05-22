<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('getFileFromIco');
    }

    public function getPhoto($filename, $user=null)
    {
        if($user!=null){
            $username = $user;
        }else{
            $username = auth()->user()->id;
        }


        $filePath = storage_path('app').
            DIRECTORY_SEPARATOR.'public'.
            DIRECTORY_SEPARATOR.$filename.
            DIRECTORY_SEPARATOR.$username;

        if (!file_exists($filePath)) {
            $file = public_path('img'.DIRECTORY_SEPARATOR.'nobody_m.original.jpg');
        } else {
            $file = $filePath;
        }

        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

        $contentType = [
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'pdf' => 'application/pdf'
        ];

        $headers = array(
            'Content-Type' => $contentType[$ext],
        );

        $response = response()->download($file, null, $headers);
        ob_end_clean();
        return $response;
    }
    
    public function getFileFromIco($directory, $filename)
    {
        $path = storage_path('app'.DIRECTORY_SEPARATOR.'ico'.DIRECTORY_SEPARATOR.$directory.DIRECTORY_SEPARATOR.$filename);

        try {
            if(!file_exists($path)) {
                throw new FileNotFoundException('Error! file you are looking for doesn\'t exists.');
            }

            $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

            $contentType = [
                'png' => 'image/png',
                'jpg' => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'pdf' => 'application/pdf'
            ];

            $headers = array(
                'Content-Type' => $contentType[$ext],
            );

            $response = response()->download($path, null, $headers);
            ob_end_clean();

            return $response;

        } catch (\Exception $exception) {
            Log::error($exception);
            abort(404);
        }

    }
}
