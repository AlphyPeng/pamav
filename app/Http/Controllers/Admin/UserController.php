<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->integer('per_page', 10);

        $search = $request->search;
        $status = $request->status;

        $users = User::query()
            ->select(
                'id',
                'employee_id',
                'first_name',
                'last_name',
                'email',
                'status'
            )
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

        return response()->json($users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
