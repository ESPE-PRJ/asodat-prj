<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NewsController extends Controller
{
    public function news()
    {
        return Inertia::render('News');
    }
}
