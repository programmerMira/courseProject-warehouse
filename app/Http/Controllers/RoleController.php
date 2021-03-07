<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleStoreRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = Role::all('id', 'title');

        return response()->json($roles);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('role.create');
    }

    /**
     * @param \App\Http\Requests\RoleStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleStoreRequest $request)
    {
        $request->validated();
        $role = new Role;
        $role->title = $request->input('title');
        $role->permissions = $request->input('permissions');
        $product->save();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Role $role
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Role $role)
    {
        return view('role.show', compact('role'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Role $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Role $role)
    {
        return view('role.edit', compact('role'));
    }

    /**
     * @param \App\Http\Requests\RoleUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleUpdateRequest $request, $id)
    {
        $request->validated();
        $role = Role::find($id);
        $role->title = $request->input('title');
        $role->permissions = $request->input('permissions');
        $role->save();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $role = Role::find($id);
        $role->delete();
    }
}
