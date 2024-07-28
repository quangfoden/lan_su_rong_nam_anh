<?php

namespace App\Repositories;

use App\Models\Post;

class PostRepository
{
    protected Post $model;

    public function __construct(Post $post)
    {
        $this->model = $post;
    }

    public function getAll(array $requests): array
    {
        $result = $this->model->query()->with('categories')->active();

        if ($requests['slug'] !== 'all') {
            $result = $result->whereHas('categories', function ($query) use ($requests) {
                $query->where('slug', $requests['slug']);
            });
        }

        if (isset($requests['year'])) {
            $result = $result->whereYear('created_at', $requests['year']);
        }

        if (isset($requests['title'])) {
            $result = $result->where('title', 'like', '%' . $requests['title'] . '%');
        }

        $countAll = $result->count();

        if (isset($requests['offset'])) {
            $result = $result->offset($requests['offset']);
        }

        return [
            'posts' => $result->orderByDesc('id')->limit($requests['limit'])->get()->toArray(),
            'count_all' => $countAll
        ];
    }

    public function getLatestPosts(int $limit)
    {
        return $this->model->query()->with('categories')->latest()->take($limit)->get();
    }

    public function findBySlug(string $slug): mixed
    {
        return $this->model->query()->where('slug', $slug)->active()->first();
    }

    public function findById(int $id): mixed
    {
        return $this->model->query()->find($id);
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
        return $this->model->query()->with('categories')->get()->toArray();
    }
}
