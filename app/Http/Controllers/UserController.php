<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::with('roles')->latest()->get();

        return response()->json($users);
    }

    public function companies(Request $request){
        $companies = User::select('company')
        ->latest()
        ->get()
        ->unique('company');
        return response()->json($companies);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, User $user)
    {
        return view('user.edit', compact('user'));
    }

    /**
     * @param \App\Http\Requests\UserUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $request->validated();
        $user = User::find($id);
        $user->login = $request->input('login');
        $user->email = $request->input('email');
        $user->password = $request->input('password');
        $user->name = $request->input('name');
        $user->surname = $request->input('surname');
        $user->middlename = $request->input('middlename');
        if($request->input('company') != null){
            $user->company = $request->input('company');
        }
        $user->roles()->detach();
        $user->roles()->attach($request->input('role'));
        $user->save();
        \App\Log::create([
            'userId' => \Auth::user()->id,
            'oldValue' => sprintf("Изменен пользователь с id: %d", $user->id),
            'newValue' => "",
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $user = User::find($id);
        $user->delete();
        \App\Log::create([
            'userId' => \Auth::user()->id,
            'oldValue' => sprintf("Удален пользователь с id: %d", $id),
            'newValue' => "",
        ]);
    }
}
