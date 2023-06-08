<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function currentUser(Request $request)
    {
        return $request->user();
    }

    public function show(string $id)
    {
        return User::findOrFail($id);
    }

    public function store(Request $request) {
        // Check for priviledge (admin)
        // if user->role_id etc
        $role_id = $request->role_id ? $request->role_id : 0;
        return User::create([
            'role_id' => 0,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    }

    public function resetPassword(Request $request, string $id)
    {
        // Check for priviledge (current user)
        // if user->id = request->id? etc
        if(User::where('id', $id)->exists()) {
            $user = User::find($id);
            if ($user->password == Hash::make($request->old_password)) {
                $user->password = Hash::make($request->new_password);
                $user->save();
                return response()->json(['message'=>'updated password'], 200);
            }
            return response()->json(['message'=>'invalid password'], 401);
            
        } 
        return response()->json(['message'=>'user not found'], 404);
    }

    public function adminPasswordReset(Request $request, string $id)
    {
        // Check for priviledge (admin)
        // if user->role_id etc
        if(User::where('id', $id)->exists()) {
            $user = User::find($id);

            $user->password = Hash::make($request->new_password);
            $user->save();
            return response()->json(['message'=>'updated password'], 200);
            
        } 
        return response()->json(['message'=>'user not found'], 404);
    }

    public function update(Request $request, string $id)
    {
        // Check for priviledge (admin)
        // if user->role_id etc
        if(User::where('id', $id)->exists()) {
            $user = User::find($id);
            $user->role_id = $request->role_id;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->save();
            return response()->json(['message'=>'updated user'], 200);
        }
        return response()->json(['message'=>'user not found'], 404);
    }

    public function destroy(string $id)
    {
        // Check for priviledge (admin)
        // if user->role_id etc
        if(User::where('id', $id)->exists()) {
            User::destroy($id);
            return response()->json(['message'=>'user removed'], 200);
        }
        return response()->json(['message'=>'user not found'], 404);
    }

    public function logout(Request $request)
    {
        // I dont think this actually does anything...
        $request->user()->tokens()->delete();
    
        return response()->json(['message'=>'user logged out'], 200);
    }

    // Model User{
    //     id bigint UN AI PK 
    //     role_id int UN 
    //     first_name varchar(255) 
    //     last_name varchar(255) 
    //     email varchar(255) 
    //     password varchar(255) 
    //     remember_token varchar(100) 
    //     created_at timestamp 
    //     updated_at timestamp
    // }

    /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
    // Create an add admin user endpoint (UserController)
    // Only super admin


    // Create a route where the super admin can change a users role (UserController)
    // Only super admin
    // public function adminRole(Request $request)
    // {
    //     $user = User::findOrFail($request->id);
    //     $user->role_id = $request->role_id;
    //     $user->save();
    //     return $user;
    // }


    /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
    // Create an user endpoint that only shows admins created after (UserController)
    public function adminUsers()
    {
        // datetime format is "Y-m-d H:i:s"
        $date = "2023-5-24";
        return User::
                where('role_id', '>=', 1) // 0, 1, 2
                ->whereDate('created_at', '>', $date)
                ->get();
    }

    // Create an user endpoint that changes a users role (UserConroller) (post)
    public function adminRole(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->role_id = $request->role_id;
        $user->save();
        return $user;
    }
    // Get SuperAdmin ID
    public function getSuperAdmin()
    {
        $getSuperAdmin = User:: 
                where ('role_id', '2')
                ->get();

    //$getSuperAdmin = DB::select('select * from users where role_id = 2');
    return $getSuperAdmin;
    }

    public function SA_role_changer(Request $request)
    {
        if ($request->role_id > 1 || $request->role_id < 0) {
            return response()->json(['message'=>'invalid role_id in request'], 404);
        }
        $user = User::findOrFail($request->id);

        if ($user->role_id != 2) {
            $user->role_id = $request->role_id;
            $user->save();
        }
        return $user;
    }
}

