<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class WelcomeController extends Controller
{
    public function welcome()
    {
        return Inertia::render('welcome');
    }
}
