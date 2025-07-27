<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MembershipsController extends Controller
{
    public function memberships()
    {
        return Inertia::render('Memberships');
    }
}
