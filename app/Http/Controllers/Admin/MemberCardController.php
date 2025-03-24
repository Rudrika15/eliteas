<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MemberCardController extends Controller
{
    public function card()
    {
        return view('components.memberCard');
    }
}
