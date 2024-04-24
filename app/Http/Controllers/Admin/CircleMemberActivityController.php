<?php

namespace App\Http\Controllers\Admin;

use App\Models\CircleCall;
use App\Http\Controllers\Controller;

class CircleMemberActivityController extends Controller
{
    public function activity()
    {
        try {
            return view('admin.circlemember.activity', compact('circlecall'));
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    

}
