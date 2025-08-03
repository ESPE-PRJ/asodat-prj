<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Noticia;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NewsController extends Controller
{
    public function news()
    {
        $noticias = Noticia::where('publicar_desde', '<=', now())
            ->where(function ($query) {
                $query->where('publicar_hasta', '>=', now())
                    ->orWhereNull('publicar_hasta');
            })
            ->orderBy('publicar_desde', 'desc')
            ->get();

        return Inertia::render('News', [
            'noticias' => $noticias
        ]);
    }
}
