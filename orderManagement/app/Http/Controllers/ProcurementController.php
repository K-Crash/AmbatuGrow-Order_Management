<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ProcurementController extends Controller
{
    public function index(): View
    {
        return view('procurement');
    }

    public function create(): View
    {
        return view('procurement');
    }

    public function notifications(): View
    {
        return view('procurement');
    }
}