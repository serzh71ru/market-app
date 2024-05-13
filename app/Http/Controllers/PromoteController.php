<?php

namespace App\Http\Controllers;
use App\Models\Promote;
use Illuminate\Http\Request;

class PromoteController extends Controller
{
    public function show() {
        $promotions = Promote::all();

        return view('promote', compact('promotions'));
    }
}
