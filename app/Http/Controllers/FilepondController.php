<?php
namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

    class FilepondController extends Controller
    {
        public function index()
        {
            $questions = Question::all();
            return view('form', [
                'questions' => $questions
            ]);
        }


        public function post(Request $request)
        {
            // Menampilkan semua data request untuk debugging
            // return dd($request->all());

            $data = []; // Inisialisasi array untuk menyimpan data

            // Loop melalui semua input yang dikirimkan
            foreach ($request->all() as $key => $value) {
                // Cek apakah input adalah file
                if ($request->hasFile($key)) {
                    $files = $request->file($key); // Mengambil file
                    $storedFiles = []; // Array untuk menyimpan path file

                    // Jika file adalah array (beberapa file)
                    if (is_array($files)) {
                        foreach ($files as $file) {
                            if ($file instanceof \Illuminate\Http\UploadedFile) {
                                $path = $file->store('upload', 'public');
                                $storedFiles[] = asset('storage/' . $path); // Menyimpan path file
                            }
                        }
                    } elseif ($files instanceof \Illuminate\Http\UploadedFile) {
                        // Jika hanya ada satu file
                        $path = $files->store('upload', 'public');
                        $storedFiles[] = asset('storage/' . $path); // Menyimpan path file
                    }

                    // Menyimpan hasil file ke dalam data
                    $data[$key] = $storedFiles;
                } else {
                    // Jika input bukan file, simpan langsung ke data
                    $data[$key] = $value; // Simpan input string atau lainnya
                }
            }

            return response()->json($data);
        }
    }
