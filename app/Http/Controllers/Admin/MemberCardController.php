<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class MemberCardController extends Controller
{
    public function card()
    {
        return view('components.memberCard');
    }
}
