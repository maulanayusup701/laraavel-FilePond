<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FilepondController extends Controller
{
    public function index()
    {
        return view('form');
    }

    public function post(Request $request)
    {
        $files = $request->file('foto');
        $filePaths = [];

        if ($files) {
            foreach ($files as $file) {
                $path = $file->store('uploads', 'public');
                $filePaths[] = $path;
            }
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'fotos' => $filePaths
        ];


        return response()->json([
            'message' => 'Data dan foto berhasil diupload!',
            'file_paths' => $filePaths,
            'data' => $data,

        ]);
    }
}
