<?php

namespace App\Http\Controllers\DashboardUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rules;
use App\Models\Session;
use Laravel\Passport\Token;
use Laravel\Passport\Client;

class GeneralController extends Controller
{
    public function changePassword(Request $request) {
        $request->validate([
            'old_password' => ['required', Rules\Password::defaults()],
            'password' => ['required', Rules\Password::defaults(), 'confirmed'],
            'password_confirmation' => ['required', Rules\Password::defaults()],
        ]);

        $user_id = Auth::id();

        if(Auth::attempt(['id' => $user_id, 'password' => $request->old_password])) {
            Auth::user()->password = Hash::make($request->password);
            Auth::user()->save();
            return Response::json(['status' => 'success']);
        } else {
            return Response::json(['status' => 'failed']);
        }

    }

    public static function getSessions($user_id) {
        $all_sessions = Session::select('id','user_id', 'ip_address', 'last_activity', 'user_agent')
            ->where(['user_id' => $user_id])
            ->orderByDesc('last_activity')
            ->get();
        foreach ($all_sessions as &$value) {
            $value['last_activity'] = Carbon::now()->getTimestamp() - $value['last_activity'];
        }
        return $all_sessions;
    }

    public function deleteSession(Request $request) {
        $request->validate([
            'id' => 'required|string',
        ]);
        $auth_id = Auth::id();
        $session_id = Session::select('user_id')->where(['id' => $request->id])->first()['user_id'];
        if ($auth_id == $session_id) {
            Session::where(['id' => $request->id])->first()->delete();
            return Response::json(['status' => 'success']);
        } else {
            return Response::json(['status' => 'failed']);
        }
    }

    public static function getTokens($user_id) {
        $all_tokens = Token::where(['user_id' => $user_id])->get();
        foreach ($all_tokens as &$value) {
            $value['client_name'] = Client::select('name')->where(['id' => $value['client_id']])->first()['name'];
        }
        return $all_tokens;
    }

    public function deleteToken(Request $request) {
        $request->validate([
            'id' => 'required|string',
        ]);
        $auth_id = Auth::id();
        $token_id = Token::select('user_id')->where(['id' => $request->id])->first()['user_id'];
        if ($auth_id == $token_id) {
            Token::where(['id' => $request->id])->first()->delete();
            return Response::json(['status' => 'success']);
        } else {
            return Response::json(['status' => 'failed']);
        }
    }
}