<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users', [
            'users' => User::all(),
            'roles' => Role::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_id' => 'required',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|integer',
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        ]);

        if($validator->failed()) {
            return redirect()->back()->with('error', "Il y'a eu une erreur lors de l'ajout de l'utilisateur.");
        }

        $inputs = $request->all(['role_id', 'firstname', 'lastname', 'email', 'phone']);
        $inputs['uuid'] = Str::uuid();
        $inputs['password'] = Hash::make($request->password);

        if($avatar = $request->file('avatar')) {
            $full_path = $avatar->store('public/users');
            $splited_path = explode('/', $full_path);
            array_shift($splited_path);
            $path = implode('/', $splited_path);
            $inputs['avatar'] = $path;
        }

        User::create($inputs);

        return redirect()->back()->with('success', "Utilisateur ajouté avec succès!");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'role_id' => 'required',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|integer',
        ]);

        $password_condition = $request->password ? $request->password === $request->confirm_password : null;

        if($password_condition === false) {
            return redirect()->back()->with('error', "Il y'a eu une erreur lors de la modification de l'utilisateur.");
        }

        if($validator->failed()) {
            return redirect()->back()->with('error', "Il y'a eu une erreur lors de la modification de l'utilisateur.");
        }

        $inputs = $request->all(['role_id', 'firstname', 'lastname', 'email', 'phone']);
        $inputs['password'] = Hash::make($request->password);

        if($avatar = $request->file('avatar')) {
            $full_path = $avatar->store('public/users');
            $splited_path = explode('/', $full_path);
            array_shift($splited_path);
            $path = implode('/', $splited_path);
            $inputs['avatar'] = $path;
        }

        $user = User::where('uuid', $id)->first();
        $user->update($inputs);

        return redirect()->back()->with('success', "Utilisateur modifié avec succès!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::where('uuid', $id)->first();
        if(!$user) return redirect()->back()->with("error", "Il y'a eu une erreur lors de la suppression de l'utilisateur.");

        User::destroy($user->id);
        return redirect()->back()->with("success", "Utilisateur supprimé avec succès.");
    }
}
