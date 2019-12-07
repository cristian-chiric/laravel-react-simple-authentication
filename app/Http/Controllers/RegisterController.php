<?php

namespace App\Http\Controllers;

use App\Http\Requests\Register as RegisterRequest;
use App\Repository\UserRepository;
use Illuminate\View\View;

class RegisterController extends Controller
{
    /** @var UserRepository */
    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(): View
    {
        return view('pages.register');
    }

    public function store(RegisterRequest $request)
    {
        $user = $this->repository->create($request->only(['name', 'email', 'password']));
        auth()->login($user);

        if ($request->isJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.dashboard');
    }
}
