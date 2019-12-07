<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repository\ClientRepository;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /** @var ClientRepository */
    protected $repository;

    public function __construct(ClientRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(): View
    {
        return view('admin.dashboard', ['totalClients' => $this->repository->count()]);
    }
}
