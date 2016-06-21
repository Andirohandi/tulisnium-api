<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class InputController extends Controller
{
    public function halamanInput($user)
    {
      return view('input',[ 'name' => $user ]);
    }
}
