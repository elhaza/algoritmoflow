<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;

class HomeController extends Controller
{
    public function index()
    {
        $albums = Album::all();
        return view('home', [
            'albums' => $albums,
        ]);
    }
}
