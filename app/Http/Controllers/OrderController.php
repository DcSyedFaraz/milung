<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function orderentry(Request $request){
        dd($request->all());
    }
}
