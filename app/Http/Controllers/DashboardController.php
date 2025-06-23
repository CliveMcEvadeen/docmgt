<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function superAdmin()
    {
        $documents = Document::all();
        return view('dashboards.super_admin', compact('documents'));
    }
}
