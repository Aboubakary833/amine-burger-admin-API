<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\SendCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Nette\Utils\Random;

class AuthController extends Controller
{
    public function login(Request $request) {
        $credentials = $request->all(['email', 'password']);

        if(!Auth::attempt($credentials)) {
            return response()->json(['error' => "Email ou mot de passe incorrect."], 401);
        }

        $user = auth()->user();
        $token = $user->createToken('auth_token');
        $user['auth_token'] = $token->plainTextToken;

        return response()->json($user);
    }

    public function register(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email',
            'confirm_email' => 'required|email|same',
            'phone' => 'required',
            'confirm_phone' => 'required|same:phone',
        ]);

        $code = (int) Random::generate(6, '0-9');

        try {
            Mail::to($request->email)->send(new SendCode($request->firstname, $code));
        } catch (\Throwable $th) {
            return response()->json(['error' => "Il y' a eu un problème. Veuillez reéssayer!"], 401);
        }

        $user = User::create([
            'uuid' => Str::uuid(),
            'code' => $code,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return response()->json([
            'success' => "Votre inscription a réussi!",
            'uuid' => $user->uuid
        ]);
        
    }

    public function password(Request $request) {
        $validator = Validator::make($request->all(), [
            'uuid' => 'required',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        $user = User::where('uuid', $request->uuid)->first();

        if($validator->failed() || !$user || !$user->email_verified_at) {
            return response()->json(['error' => "Il y'a eu une erreur. Veuillez réessayer!"], 401);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return response()->json(['success' => "Bravo! Vous venez de terminer votre inscription."]);
        
    }

    public function confirm(Request $request) {
        $validator = Validator::make($request->all(), [
            'uuid' => 'required',
            'code' => 'required'
        ]);

        $user = User::where('uuid', $request->uuid)->first();

        if($validator->failed()) {
            return response()->json(['error' => "Il y'a eu une erreur. Veuillez réessayer!"], 401);
        }
        if($user->code !== (int) $request->code) {
            return response()->json(['error' => "Code incorrect!"], 401);
        }

        $user->update([
            'email_verified_at' => now()
        ]);

        return response()->json(['success' => "Bravo! Vous venez de terminer votre inscription."]);
    }

    public function update(Request $request) {

            switch ($request->type) {
                case 'IDENTITY':
                    $validator = Validator::make($request->all(), [
                        'firstname' => 'required|string',
                        'lastname' => 'required|string'
                    ]);

                    if($validator->failed()) {
                        return response()->json(['error' => "L'un des champs fournis est incorrect."], 401);
                    }

                    auth()->user()->update([
                        'firstname' => $request->firstname,
                        'lastname' => $request->lastname,
                    ]);
                    return response()->json(['success' => "La modification a été un succès."]);
                
                case 'EMAIL':
                    $validator = Validator::make($request->all(), [
                        'email' => 'required|email',
                        'confirm_email' => 'required|email|same:email'
                    ]);

                    if($validator->failed()) {
                        return response()->json(['error' => "Il y'a eu une erreur lors de la modification."]);
                    }

                    $user->update(['email' => $request->email]);

                    return response()->json(['success' => "La modification a été un succès."]);
                    
                case 'PASSWORD':
                    $validator = Validator::make($request->all(), [
                        'password' => 'required',
                        'confirm_password' => 'required|same:password'
                    ]);

                    if($validator->failed()) {
                        return response()->json(['error' => "Il y'a eu une erreur lors de la modification."]);
                    }

                    $user->update(['password' => $request->password]);

                    return response()->json(['success' => "La modification a été un succès."]);

            }
    }
}
