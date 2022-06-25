<?php

namespace App\Http\Controllers\DashboardAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Date;

class UsersController extends Controller
{
    public static function getUsers() {
        $users = User::all();
        return $users;
    }

    public function createUser(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', Rules\Password::defaults()],
            'verified' => 'required|boolean',
            'admin' => 'required|boolean',
            'enabled' => 'required|boolean',
            'comment' => 'max:255',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => $request->verified?Date::now():'',
            'admin' => false,
            'enabled' => true,
            'comment' => $request->comment,
        ]);

        // event(new Registered($user));

        return Response::json(['status' => 'success']);
    }

    public function updateUser(Request $request) {
        $request->validate([
            'id' => 'required|exists:users',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => ['nullable', Rules\Password::defaults()],
            'verified' => 'required|boolean',
            'admin' => 'required|boolean',
            'enabled' => 'required|boolean',
            'comment' => 'nullable|max:255',
        ]);
        
        $user = User::where('id', $request->id)->first();
        if ($user->name != $request->name) $user->name = $request->name;
        if ($user->email != $request->email) $user->email = $request->email;
        if ($request->password) $user->password = Hash::make($request->password);
        if (!$user->email_verified_at != !$request->verified) $user->email_verified_at = $request->verified?Date::now():null;
        $user->admin = $request->admin;
        $user->enabled = $request->enabled;
        $user->comment = $request->comment;
        
        if ($user->save()) {
            return Response::json(['status' => 'success']);
        } else {
            return Response::json(['status' => 'failed']);
        }
    }

    public function deleteUser(Request $request) {
        $request->validate([
            'id' => 'required|exists:users',
        ]);
        $user = User::where('id', $request->id)->first()->delete();
        return Response::json(['status' => 'success']);
    }

    public function toggleEnableUser(Request $request) {
        $request->validate([
            'id' => 'required|exists:users',
        ]);
        $user = User::where('id', $request->id)->first();
        $user->enabled = !$user->enabled;
        $user->save();
        return Response::json(['status' => 'success']);
    }
}
