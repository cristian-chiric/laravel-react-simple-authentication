<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Store as StoreRequest;
use App\Http\Requests\Client\Update as UpdateRequest;
use App\Repository\ClientRepository;
use Illuminate\View\View;

class ClientController extends Controller
{
    /** @var ClientRepository */
    protected $repository;

    public function __construct(ClientRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(): View
    {
        return view('admin.clients.index', [
            'clients' => $this->repository->all(),
            'totalClients' => $this->repository->count(),
        ]);
    }

    public function create(): View
    {
        return view('admin.clients.create');
    }

    public function edit(int $id): View
    {
        return view('admin.clients.edit', ['client' => $this->repository->show($id)]);
    }

    public function destroy(int $id)
    {
        $this->repository->delete($id);

        if (request()->isJson()) {
            return response()->json(['message' => 'Client deleted successfully']);
        }

        return redirect()
            ->route('admin.clients.index')
            ->with('message', 'Client deleted successfully');
    }

    public function update(UpdateRequest $request, int $id)
    {
        $this->repository->update($request->all(), $id);

        if (request()->isJson()) {
            return response()->json(['message' => 'Client updated successfully']);
        }

        return redirect()
            ->route('admin.clients.index')
            ->with('message', 'Client updated successfully');
    }

    public function store(StoreRequest $request)
    {
        $this->repository->create($request->all());

        if (request()->isJson()) {
            return response()->json(['message' => 'Client created successfully']);
        }

        return redirect()
            ->route('admin.clients.index')
            ->with('message', 'Client created successfully');
    }
}
