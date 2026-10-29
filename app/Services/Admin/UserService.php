<?php

namespace App\Services\Admin;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
                'avatar'
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

    public function createUser(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $avatarPath = null;

            if (isset($data['avatar']) && $data['avatar'] instanceof \Illuminate\Http\UploadedFile) {
                $avatarPath = Storage::disk('public')->putFile('avatars', $data['avatar']);
            }

            return User::create([
                'employee_id'    => $data['employee_id'],
                'first_name'     => $data['first_name'],
                'middle_name'    => $data['middle_name'],
                'last_name'      => $data['last_name'],
                'email'          => $data['email'],
                'contact_number' => '+63' . $data['contact_number'],
                'street'         => $data['street'] ?? null,
                'barangay'       => $data['barangay'] ?? null,
                'city'           => $data['city'] ?? null,
                'province'       => $data['province'] ?? null,
                'zip'            => $data['zip'] ?? null,
                'password'       => Hash::make($data['password']),
                'avatar'         => $avatarPath ?? null
            ]);
        });
    }

    public function deleteUser(User $user): bool
    {
        return DB::transaction(function () use ($user) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            return $user->delete();
        });
    }
}
