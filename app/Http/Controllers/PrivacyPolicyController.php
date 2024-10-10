<?php

namespace App\Http\Controllers;

use App\Utils\ErrorLogger;
use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('permission:policy-index', ['only' => ['index', 'view']]);
    // }

    public function index()
    {
        try {
            return view('privacypolicy.index');
        } catch (\Throwable $th) {
            // Log the error
            ErrorLogger::logError($th, request()->fullUrl());

            // Return a generic error view
            return response()->view('servererror');
        }
    }

}
