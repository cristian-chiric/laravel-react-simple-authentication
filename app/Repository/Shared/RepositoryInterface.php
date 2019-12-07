<?php

namespace App\Repository\Shared;

use Illuminate\Support\Collection;

interface RepositoryInterface
{
    public function all(): Collection;

    public function count(): int;

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);

    public function show($id);
}
