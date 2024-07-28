<?php

namespace App\Repositories;

use App\Models\ContactUs;
use Carbon\Carbon;

class ContactUsRepository
{
    protected ContactUs $model;

    public function __construct(ContactUs $contactUs)
    {
        $this->model = $contactUs;
    }

    public function getAll(array $requests): \Illuminate\Database\Eloquent\Collection|array
    {
        $contacts = $this->model->query();
        if (isset($requests['status'])) {
            $contacts->where('status', $requests['status']);
        }

        return $contacts->latest()->get();
    }

    public function findById(int $id): mixed
    {
        return $this->model->query()->find($id);
    }

    public function create(array $data): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
    {
        return $this->model->query()->create($data);
    }

    public function update(int $id, array $data): bool|int
    {
        return $this->model->query()->find($id)->update($data);
    }

    public function countSpam(string $ip): int
    {
        return $this->model->query()
            ->where('ip', $ip)
            ->whereDate('created_at', Carbon::today())
            ->count();
    }
}
