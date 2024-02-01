<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    function index()
    {
        return view('auth.login');

    }
    function login(Request $request)
    {
        // dd($request->all());
        $request->validate(
            [
                'email' => 'required',
                'password' => 'required',
            ],
            [
                'email.required' => 'email harus diisi',
                'password.required' => 'password harus diisi',
            ]
            );

            $infologin = [
                'email' => $request->email,
                'password' => $request->password,
            ];

            if(Auth::attempt($infologin)){
                if (Auth::user()->role == "admin") {
                    return redirect()->route('admin.index');
                } else if (Auth::user()->role == "customer") {
                    return redirect()->route('customer.index');
                } else if (Auth::user()->role == "bank") {
                    return redirect()->route('bank.index');
                } else if (Auth::user()->role == "kantin") {
                    return redirect()->route('kantin.index');

                }
            }else {

                return redirect(route('login'))->withErrors('Email dan password yang dimasukan tidak sesuai')->withInput();
                
            }


    }

    function logout(Request $request)
    {
        Auth::logout();


        return redirect()->route('login')->withErrors('success', 'anda berhasil logout');
    }
}
