<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;

class UserController extends Controller
{
	public function __construct(User $user){
		$this->user = $user;
	}

    public function index(){
    	return view('user/index');
    }

    public function create(){
        $roles = Role::all()->sortBy("name");

        return view('user/create', [
            "roles" => $roles
        ]);
    }

    public function store(Request $request)
    {
        $user = new User();
        $user->username  = $request->get('username');
        $user->password  = Hash::make($request->get('password'));
        $user->name      = $request->get('name');
        $user->role_id   = $request->get('role_id');
        $user->is_active = $request->get('is_active') ? 1 : 0;

        $user->save();
        return redirect('/users')->with('success', 'User berhasil dibuat');
    }

    public function show($id)
    {
        echo $id;
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all()->sortBy("name");

        return view('user/edit', [
            "user" => $user,
            "roles" => $roles
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->username  = $request->get('username');

        if($request->get('password') != null){
            $user->password  = Hash::make($request->get('password'));
        }

        $user->name      = $request->get('name');
        $user->role_id   = $request->get('role_id');
        $user->is_active = $request->get('is_active') ? 1 : 0;

        $user->save();
        return redirect('/users')->with('success', 'User berhasil diupdate');
    }

    public function destroy($id)
    {
        $item = User::findOrFail($id);
        $item->delete();

        return response()->json(['status'=>'berhasil hapus']);
    }

    public function getData(){
    	$data1 = $this->user->all();
    	return response()->json(['data1' => $data1], 200);
    }
}
