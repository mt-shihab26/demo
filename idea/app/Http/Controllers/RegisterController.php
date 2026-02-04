<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages/register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegisterRequest $request)
    {
        //
    }
}
