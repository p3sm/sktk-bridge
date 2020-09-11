<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\User;
use App\UserAsosiasi;
use App\Role;
use App\Asosiasi;
use App\Provinsi;
use App\Team;
use App\TimProduksi;
use App\TimMarketing;

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
        $teams = Team::all()->sortBy("name");
        $tim_produksi = TimProduksi::all()->sortBy("name");
        $tim_marketing = TimMarketing::all()->sortBy("name");
        $asosiasi = Asosiasi::all()->sortBy("nama");
        $provinsi = Provinsi::all()->sortBy("nama");

        return view('user/create', [
            "tim_produksi" => $tim_produksi,
            "tim_marketing" => $tim_marketing,
            "teams" => $teams,
            "roles" => $roles,
            "asosiasi" => $asosiasi,
            "provinsi" => $provinsi
        ]);
    }

    public function store(Request $request)
    {
        $find = User::where("username", $request->get('username'))->first();
        dd($find);
        if($find != null){
            return redirect('/users/create')->with('error', 'User sudah ada');
        }

        $user = new User();
        $user->username  = $request->get('username');
        $user->password  = Hash::make($request->get('password'));
        $user->name      = $request->get('name');
        $user->tipe_akun   = $request->get('tipe_akun');

        if($request->get('tipe_akun') == 2){
            $user->team_id   = $request->get('team_id');
            $user->marketing_id   = NULL;
        } else if ($request->get('tipe_akun') == 3) {
            $user->team_id   = NULL;
            $user->marketing_id   = $request->get('marketing_id');
        } else {
            $user->team_id   = NULL;
            $user->marketing_id   = NULL;
        }

        $user->role_id   = $request->get('role_id');
        $user->is_active = $request->get('is_active') ? 1 : 0;

        if($user->save()){
            $uAsosiasi = new UserAsosiasi();
            $uAsosiasi->user_id = $user->id;
            $uAsosiasi->asosiasi_id = $request->get('asosiasi_id');
            $uAsosiasi->provinsi_id = $request->get('provinsi_id');
            $uAsosiasi->save();
        }

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
        $teams = Team::all()->sortBy("name");
        $tim_produksi = TimProduksi::all()->sortBy("name");
        $tim_marketing = TimMarketing::all()->sortBy("name");
        $asosiasi = Asosiasi::all()->sortBy("nama");
        $provinsi = Provinsi::all()->sortBy("nama");

        return view('user/edit', [
            "teams" => $teams,
            "tim_produksi" => $tim_produksi,
            "tim_marketing" => $tim_marketing,
            "user" => $user,
            "roles" => $roles,
            "asosiasi" => $asosiasi,
            "provinsi" => $provinsi
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
        $user->tipe_akun   = $request->get('tipe_akun');

        if($request->get('tipe_akun') == 2){
            $user->team_id   = $request->get('team_id');
            $user->marketing_id   = NULL;
        } else if ($request->get('tipe_akun') == 3) {
            $user->team_id   = NULL;
            $user->marketing_id   = $request->get('marketing_id');
        } else {
            $user->team_id   = NULL;
            $user->marketing_id   = NULL;
        }
        
        $user->role_id   = $request->get('role_id');
        $user->is_active = $request->get('is_active') ? 1 : 0;

        if($user->save()){
            $uAsosiasi = UserAsosiasi::where("user_id", $user->id)->first();
            if(!$uAsosiasi){
                $uAsosiasi = new UserAsosiasi();
                $uAsosiasi->user_id = $user->id;
            }
            $uAsosiasi->asosiasi_id = $request->get('asosiasi_id');
            $uAsosiasi->provinsi_id = $request->get('provinsi_id');
            $uAsosiasi->save();

            return redirect('/users')->with('success', 'User berhasil diupdate');
        }

        return redirect('/users')->with('error', 'User gagal diupdate');
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
