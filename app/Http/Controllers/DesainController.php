<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoredesainRequest;
use App\Http\Requests\UpdatedesainRequest;
use Illuminate\Http\Request;
use App\Models\desain;

class DesainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth('sanctum')->user();

        $desain = $user
            ? desain::where('id_user', null)->orWhere('id_user', $user->id_user)->get()
            : desain::where('id_user', null)->get();

        return $desain->map(function ($item) use ($user) {
            return [
                'id_desain' => $item->id_desain,
                'judul' => $item->judul,
                'luas' => $item->luas,
                'harga' => $item->harga,
                'mine' => $user && $item->id_user === $user->id_user ? "1" : "0"
            ];
        });
    }

    /**
     * Display the image file associated with the desain.
     */
    public function getImage($id_desain)
    {
        $desain = desain::find($id_desain);

        if ($desain && file_exists(public_path($desain->imageUrl))) {
            return response()->file(public_path($desain->imageUrl));
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Gambar desain tidak ditemukan',
        ], 404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoredesainRequest $request)
    {
        $request->validate([
            "judul" => ["required", "string", "max:255"],
            "luas" => ["required", "string", "max:255"],
            "harga" => ["required", "numeric"],
            "image" => ["required", "image"],
        ]);

        $image = $request->file('image');
        $filename = 'image_' . time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('upload'), $filename);

        desain::create([
            "judul" => $request->judul,
            "luas" => $request->luas,
            "harga" => $request->harga,
            "imageUrl" => "upload/$filename",
            "id_user" => $request->user()->id_user
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'desain baru berhasil ditambahkan',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatedesainRequest $request, $id_desain)
    {
        $request->validate([
            "judul" => ["required", "string", "max:255"],
            "luas" => ["required", "string", "max:255"],
            "harga" => ["required", "numeric"],
            "image" => ["image"],
        ]);

        $desain = desain::find($id_desain);

        if (!$desain) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data desain tidak ditemukan',
            ]);
        }

        if ($desain->id_user !== $request->user()->id_user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda tidak diizinkan mengedit desain ini',
            ]);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = 'image_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload'), $filename);
            $desain->imageUrl = "upload/$filename";
        }

        $desain->judul = $request->judul;
        $desain->luas = $request->luas;
        $desain->harga = $request->harga;
        $desain->save();

        return response()->json([
            'status' => 'success',
            'message' => 'desain berhasil diperbarui',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id_desain)
    {
        $desain = desain::find($id_desain);

        if (!$desain) {
            return response()->json([
                'status' => 'error',
                'message' => 'desain tidak ditemukan dalam sistem',
            ]);
        }

        if ($desain->id_user !== $request->user()->id_user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda tidak memiliki akses untuk menghapus desain ini',
            ]);
        }

        $desain->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'desain berhasil dihapus dari sistem',
        ]);
    }
}
