<?php

namespace App\Repositories;

use App\Models\Product;

class ProductsRepository
{
    protected Product $model;

    public function __construct(Product $product)
    {
        $this->model = $product;
    }

    public function getAll(): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->model->query()->latest()->get();
    }

    public function findById(int $id): mixed
    {
        return $this->model->query()->find($id);
    }

    public function create(array $data): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
    {
        $data['created_by'] = auth()->user()->id;

        return $this->model->query()->create($data);
    }

    public function update(int $id, array $data): bool|int
    {
        return $this->model->query()->find($id)->update($data);
    }

    public function getList(array $requests): array
    {
        $query = $this->model->query();

        if (isset($requests['title'])) {
            $title = $requests['title'];
            $query->where(function($query) use ($title) {
                $query->where('name', 'like', '%' . $title . '%')
                      ->orWhere('des', 'like', '%' . $title . '%');
            });
        }

        $countAll = $query->count();

        if (isset($requests['offset'])) {
            $query->offset($requests['offset']);
        }

        $query->orderByDesc('id');

        if (isset($requests['limit'])) {
            $query->limit($requests['limit']);
        }

        return [
            'products' => $query->get()->toArray(),
            'count_all' => $countAll
        ];
    }

    public function getListIsHot(): array
    {
        return $this->model->where('is_hot', 1)->get()->toArray();
    }
}
