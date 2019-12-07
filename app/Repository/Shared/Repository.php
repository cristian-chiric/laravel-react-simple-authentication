<?php

namespace App\Repository\Shared;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Repository implements RepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function count(): int
    {
        return $this->model->count();
    }

    public function beforeCreate(&$data)
    {
    }

    public function afterCreate($model, $data)
    {
    }

    public function beforeUpdate($model, &$data)
    {
    }

    public function create(array $data)
    {
        $this->beforeCreate($data);

        $model = $this->model->create($data);

        $this->afterCreate($model, $data);
        return $model;
    }

    public function update(array $data, $id)
    {
        $record = $this->model->findOrFail($id);
        $this->beforeUpdate($record, $data);
        return $record->update($data);
    }

    public function beforeDelete($model)
    {
    }

    public function delete($id)
    {
        $this->beforeDelete($this->model->findOrFail($id));
        return $this->model->destroy($id);
    }

    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    public function getModel()
    {
        return $this->model;
    }

    public function with($relations)
    {
        return $this->model->with($relations);
    }
}
