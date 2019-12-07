<?php

namespace App\Http\Controllers;

use App\Http\Requests\Login as LoginRequest;

class SessionsController
{
    public function create()
    {
        return view('pages.login');
    }

    public function store(LoginRequest $request)
    {
        if (auth()->attempt(request(['email', 'password'])) === false) {

            if ($request->isJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'The email or password is incorrect, please try again',
                ], 400);
            }

            return back()->withErrors([
                'message' => 'The email or password is incorrect, please try again'
            ]);
        }

        if ($request->isJson()) {
            return response()->json([ 'success' => true ]);
        }

        return redirect()->route('admin.dashboard');
    }

    public function destroy()
    {
        auth()->logout();

        return redirect()->route('home');
    }
}
