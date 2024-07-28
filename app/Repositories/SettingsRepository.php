<?php

namespace App\Repositories;

use App\Models\Settings;
use Carbon\Carbon;

class SettingsRepository
{
    protected Settings $model;

    public function __construct(Settings $settings)
    {
        $this->model = $settings;
    }

    public function getAll(): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->model->query()->get();
    }

    public function findById(int $id): mixed
    {
        return $this->model->query()->find($id);
    }

    public function findByName(string $name): mixed
    {
        return $this->model->query()->where('name', $name)->first();
    }

    public function create(array $data): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
    {
        return $this->model->query()->create($data);
    }

    public function update(int $id, array $data): bool|int
    {
        return $this->model->query()->find($id)->update($data);
    }
}
