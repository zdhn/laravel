<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class KantinController extends Controller
{
    public function index(){

        return view('kantin.index');
    }
}
