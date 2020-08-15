<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrailController extends Controller
{
    public function indexTests()
    {
        return view('trails.trails-index');
    }
}
