<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    // ==========================================
    // AREA ADMIN / BIDAN (MANAJEMEN ARTIKEL)
    // ==========================================
    
    // 1. TAMPILKAN DAFTAR ARTIKEL
    public function index()
    {
        $articles = Article::latest()->get();
        // Mengarah ke folder resources/views/artikel/index.blade.php
        return view('artikel.index', compact('articles'));
    }

    // 2. FORM TAMBAH ARTIKEL
    public function create()
    {
        return view('artikel.create');
    }

    // 3. PROSES SIMPAN ARTIKEL
    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'category' => 'required|string',
            'content'  => 'required',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title) . '-' . time();

        // Upload Gambar
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('articles', 'public');
        }

        Article::create($data);

        return redirect()->route('artikel.index')->with('success', 'Artikel berhasil diterbitkan!');
    }

    // 4. FORM EDIT ARTIKEL (TAMBAHAN PENTING)
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return view('artikel.edit', compact('article'));
    }

    // 5. PROSES UPDATE ARTIKEL
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'category' => 'required|string',
            'content'  => 'required',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $article = Article::findOrFail($id);
        $data = $request->all();

        // Update Slug jika judul berubah
        if($request->title != $article->title){
            $data['slug'] = Str::slug($request->title) . '-' . time();
        }

        // Cek Gambar Baru
        if ($request->hasFile('image')) {
            if($article->image) {
                Storage::disk('public')->delete($article->image); // Hapus yg lama
            }
            $data['image'] = $request->file('image')->store('articles', 'public');
        }

        $article->update($data);

        return redirect()->route('artikel.index')->with('success', 'Artikel diperbarui.');
    }

    // 6. HAPUS ARTIKEL
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        if($article->image) {
            Storage::disk('public')->delete($article->image);
        }
        $article->delete();
        return back()->with('success', 'Artikel dihapus.');
    }

    // ==========================================
    // AREA ORANG TUA (BACA ARTIKEL)
    // ==========================================

    public function show($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();
        
        // Rekomendasi artikel sejenis (kecuali artikel yg sedang dibuka)
        $relatedArticles = Article::where('id', '!=', $article->id)
                            ->where('category', $article->category)
                            ->latest()
                            ->take(3)
                            ->get();

        return view('artikel.show', compact('article', 'relatedArticles'));
    }
}