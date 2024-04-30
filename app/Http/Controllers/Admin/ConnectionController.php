<?php

namespace App\Http\Controllers\Admin;

use App\Models\Connection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConnectionController extends Controller
{
    // public function accepted($id)
    // {
    //     $connection = Connection::find($id);

    //     $connection->status = 'Accepted';
    //     $connection->save();

    //     return redirect()->back()->with('success', 'Connection request accepted');
    // }

    // public function rejected($id)
    // {
    //     $connection = Connection::find($id);

    //     $connection->status = 'Rejected';
    //     $connection->save();

    //     return redirect()->back()->with('error', 'Connection request rejected');
    // }
}

