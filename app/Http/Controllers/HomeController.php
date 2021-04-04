<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Music;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $music_model = new Music();
        $popular = $music_model->getPopular(3);
        $latest = $music_model->getLatest(6);
        return view('home', compact('popular', 'latest'));
    }
}
