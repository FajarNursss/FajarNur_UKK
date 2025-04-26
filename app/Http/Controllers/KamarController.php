<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kamar;


class KamarController extends Controller
{
    public function index()
    {
        // Ambil data kamar dari model Kamar
        $kamars = Kamar::all(); // Ini misalnya ambil semua data kamar

        // Kirim ke view
        return view('admin.kamar.index', compact('kamars'));
    }


    public function create()
    {
        return view('admin.kamar.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipe' => 'required',
            'fasilitas' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $namaGambar = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->storeAs('public/kamar', $namaGambar);
            $data['gambar'] = $namaGambar;
        }

        Kamar::create($data);


        return redirect()->route('admin.kamar.index')->with('success', 'Kamar berhasil ditambahkan.');
    }


    public function edit(Kamar $kamar)
    {
        return view('admin.kamar.edit', compact('kamar'));
    }

    public function update(Request $request, Kamar $kamar)
    {
        $request->validate([
            'tipe' => 'required',
            'fasilitas' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($kamar->gambar && file_exists(storage_path('app/public/kamar/' . $kamar->gambar))) {
                unlink(storage_path('app/public/kamar/' . $kamar->gambar));
            }

            $gambar = $request->file('gambar');
            $namaGambar = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->storeAs('public/kamar', $namaGambar);
            $data['gambar'] = $namaGambar;
        }

        $kamar->update($data);

        return redirect()->route('admin.kamar.index')->with('success', 'Kamar berhasil diupdateee.');
    }


    public function destroy(Kamar $kamar)
    {
        $kamar->delete();
        return redirect()->route('admin.kamar.index')->with('success', 'Kamar berhasil dihapus.');
    }
}
