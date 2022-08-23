<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Log;


class UserController extends Controller
{   
    const USER_ROLE = 1;
    const ADMIN_ROLE = 2;
    const SUPER_ADMIN_ROLE = 3;

    public function adSuperAdmin($id)
    {

        try {

            $user = User::query()->find($id);

            $user->roles()->attach(self::SUPER_ADMIN_ROLE);

            return response()->json([
                'success' => true,
                'message' => "Rol superAdmin activated"
            ]);
        } catch (\Exception $exception) {

            Log::error('Error change rol' . $exception->getMessage());
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Error to change rol'

                ],
                404
            );
        };
    }

    public function deleteSuperAdmin($id)
    {

        try {

            $user = User::query()->find($id);
            $user->roles()->detach(self::SUPER_ADMIN_ROLE);

            $user->roles()->attach(self::USER_ROLE);

            return response()->json([
                'success' => true,
                'message' => "Rol superAdmin Deteched",
            ]);
        } catch (\Exception $exception) {

            Log::error('Error change rol' . $exception->getMessage());
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Error to change rol'

                ],
                404
            );
        };
    }
}
