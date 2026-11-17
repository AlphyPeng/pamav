<?php

namespace App\Services\Admin;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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
                        ->orWhere('middle_name', 'like', $search . '%')
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

    public function updateUser(User $user, array $data): User
    {
        return DB::transaction(function () use ($user, $data) {
            $avatarPath = $user->avatar;

            if (isset($data['avatar']) && $data['avatar'] instanceof \Illuminate\Http\UploadedFile) {
                $validator = Validator::make(
                    ['avatar' => $data['avatar']],
                    ['avatar' => 'image|mimes:jpeg,jpg,png|max:2048']
                );

                if ($validator->fails()) {
                    throw new ValidationException($validator);
                }

                // Delete existing avatar
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }

                // Store new avatar
                $avatarPath = Storage::disk('public')->putFile('avatars', $data['avatar']);
            }

            $updateData = [
                'employee_id' => $data['employee_id'] ?? $user->employee_id,
                'first_name'  => $data['first_name'] ?? $user->first_name,
                'middle_name' => $data['middle_name'] ?? $user->middle_name,
                'last_name'   => $data['last_name'] ?? $user->last_name,
                'email'       => $data['email'] ?? $user->email,
                'street'      => $data['street'] ?? $user->street,
                'barangay'    => $data['barangay'] ?? $user->barangay,
                'city'        => $data['city'] ?? $user->city,
                'province'    => $data['province'] ?? $user->province,
                'zip'         => $data['zip'] ?? $user->zip,
                'avatar'      => $avatarPath,
            ];

            if (isset($data['contact_number'])) {
                $updateData['contact_number'] = '+63' . $data['contact_number'];
            }

            if (!empty($data['password'])) {
                $updateData['password'] = Hash::make($data['password']);
            }

            $user->update($updateData);

            return $user->fresh();
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
