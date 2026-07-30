<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\View\View;

class BeritaController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index(): View
    {
        $data = Berita::latest()
            ->paginate(9);

        return view('public.berita.index', compact('data'));
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */
    public function show(int $id): View
    {
        $data = Berita::findOrFail($id);

        $related = Berita::where('id', '!=', $data->id)
            ->latest()
            ->take(3)
            ->get();

        return view('public.berita.show', compact(
            'data',
            'related'
        ));
    }
}