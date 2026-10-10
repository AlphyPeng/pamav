<?php

namespace App\Services\Admin;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserService
{
    public function getPaginatedUsers(array $filters, int $perPage): LengthAwarePaginator
    {
        $search = $filters['search'] ?? null;
        $status = $filters['status'] ?? null;

        return User::query()
            ->select([
                'id',
                'employee_id',
                'first_name',
                'last_name',
                'email',
                'status',
            ])
            // SEARCH
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('employee_id', 'like', $search . '%')
                        ->orWhere('first_name', 'like', $search . '%')
                        ->orWhere('last_name', 'like', $search . '%')
                        ->orWhere('email', 'like', $search . '%');
                });
            })
            // STATUS FILTER
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest('created_at')
            ->paginate($perPage);
    }

    public function createUser() {}
}
