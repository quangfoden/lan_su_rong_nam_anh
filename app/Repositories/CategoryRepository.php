<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    protected Category $model;

    public function __construct(Category $category)
    {
        $this->model = $category;
    }

    public function getAll(): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->model->query()->latest()->get();
    }

    public function findById(int $id): mixed
    {
        return $this->model->query()->with('parent')->find($id);
    }

    public function create(array $data): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
    {
        $data['created_by'] = auth()->user()->id ?? 1;

        return $this->model->query()->create($data);
    }

    public function update(int $id, array $data): bool|int
    {
        return $this->model->query()->find($id)->update($data);
    }

    public function getList(): array
    {
        return $this->model->query()->with('parent')->get()->toArray();
    }

    public function getCategoryOpts(int|null $withoutID = null, bool|null $forPost = false): array
    {
        if ($forPost) {
            $result = [];
        } else {
            $result[] = [
                'id' => '',
                'title' => '--Chọn Danh Mục Cha--'
            ];
        }
        $opts = $this->model->query();

        if (!is_null($withoutID)) {
            $opts->where('id', '!=', $withoutID);
        }

        $opts = $opts->get();

        foreach ($opts as $opt) {
            $result[] = [
                'id' => $opt->id,
                'title' => $opt->title,
                'slug' => $opt->slug
            ];
        }

        return $result;
    }
}
