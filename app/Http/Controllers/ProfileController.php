<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return response()->json([
            'user'        => $user,
            // 'roles'       => $user->getRoleNames(),
            // 'permissions' => $user->getAllPermissions()->pluck('name')
        ]);
    }

    public function changeTheme($theme)
    {
        $userId = Auth::user()->id;

        User::where('id', $userId)
            ->update(
                [
                    'theme' => $theme
                ]
            );

        return response()->json([
            'message' => "Change theme successfully."
        ]);
    }
}
