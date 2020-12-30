<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Kantor;
use App\Kota;
use App\Provinsi;
use App\KantorLevel;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KantorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      if($request->ubah){
          if($request->pilih_data){
            return redirect('master_kantor/' . $request->pilih_data[0] . '/edit');
          } else {
            return redirect('master_kantor')->with('error', 'Pilih data yang akan ubah');
          }
      }

      if($request->hapus){
          if($request->pilih_data){
              foreach($request->pilih_data as $res){
                $del = Kantor::findOrFail($res);
                if(!$del->delete()){
                  return redirect('master_kantor')->with('error', 'Gagal menghapus data');
                }
              }
              return redirect('master_kantor')->with('success', 'Data berhasil dihapus');
          } else {                
            return redirect('master_kantor')->with('error', 'Pilih data yang akan dihapus');
          }
      }
    
      $idlevel = Kantor::select('level_id')->groupBy('level_id')->whereNotNull('level_id')->get()->toArray();
      $level = KantorLevel::whereIn('id',$idlevel)->get();
      $idprop = Kantor::select('provinsi_id')->groupBy('provinsi_id')->whereNotNull('provinsi_id')->get()->toArray();
      $prov = Provinsi::whereIn('id_provinsi',$idprop)->get();
      $kota = Kota::all();
      $data = Kantor::orderBy('id','asc')->get();
      $kantor = Kantor::orderBy('id','asc')->groupBy('nama')->get();
      return view('kantor.index')->with(compact('data','prov','kota','level','kantor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $prov = Provinsi::all();
        $kota = Kota::all();
        $level = KantorLevel::all();
        return view('kantor.create')->with(compact('prov','kota','level'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_nama_kantor' => 'required',
            'id_singkat_kantor' => 'required',
            'id_level_k' => 'required',
            'id_alamat'=> 'required',
            'id_prov'=> 'required',
            'id_kota'=> 'required',
            'id_no_telp'=> 'required',
            'id_email'=> 'required',
            'id_nama_kp'=> 'required',
            'id_hp_kp'=> 'required',
            'id_email_kp'=> 'required'
        ],
        [
        'id_nama_kantor.required'=>'Nama Kantor harus diisi',
        'id_singkat_kantor.required'=>'Singkatan Nama Kantor harus diisi',
        'id_level_k.required'=>'Level Kantor Kantor harus diisi',
        'id_alamat.required'=>'Alamat harus diisi',
        'id_prov.required'=>'Provinsi harus diisi',
        'id_kota.required'=>'Kota harus diisi',
        'id_no_telp.required'=>'No Tlp harus diisi',
        'id_email.required'=>'Email harus diisi',
        'id_nama_kp.required'=>'Nama Kontak Person harus diisi',
        'id_hp_kp.required'=>'No HP Kontak Person harus diisi',
        'id_email_kp.required'=>'Email Kontak Person harus diisi'
        ]
        );

        // dd($request);
        $kantor = new Kantor();
        $kantor->nama = $request->id_nama_kantor;
        $kantor->singkatan = $request->id_singkat_kantor;
        $kantor->level_id = $request->id_level_k;
        $kantor->provinsi_id = $request->id_prov;
        $kantor->kota_id = $request->id_kota;
        $kantor->alamat = $request->id_alamat;
        $kantor->no_tlp = $request->id_no_telp;
        $kantor->email = $request->id_email;
        $kantor->web = $request->id_web;
        $kantor->instansi = $request->id_instansi;
        $kantor->pimpinan_nama = $request->id_nama_p;
        $kantor->pimpinan_jabatan = $request->id_jab_p;
        $kantor->pimpinan_hp = $request->id_hp_p;
        $kantor->pimpinan_email = $request->id_email_p;
        $kantor->kontak_p = $request->id_nama_kp;
        $kantor->no_kontak_p = $request->id_hp_kp;
        $kantor->jab_kontak_p = $request->id_jab_kp;
        $kantor->email_kontak_p = $request->id_email_kp;
        $kantor->keterangan = $request->id_keterangan;
        $kantor->is_active = 1;
        $kantor->created_by = Auth::id();
        $kantor->created_at = Carbon::now()->toDateTimeString();

        $kantor->save();

        return redirect('master_kantor')->with('message', 'Data berhasil ditambahkan');
      
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Kantor::find($id);
        $prov = Provinsi::all();
        $kota = Kota::all();
        $kotapil = Kota::where('provinsi_id','=',$data->provinsi_id)->get();
        $level = KantorLevel::all();
        return view('kantor.edit')->with(compact('prov','kota','level','data','kotapil'));
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
        $old = Kantor::find($id);
        $olddata['id_kantor'] = $old->id;
        $olddata['nama_kantor'] = $old->nama;
        $olddata['nama_singkat'] = $old->singkatan;
        $olddata['level'] = $old->level_id;
        $olddata['prop'] = $old->provinsi_id;
        $olddata['kota'] = $old->kota_id;
        $olddata['alamat'] = $old->alamat;
        $olddata['no_tlp'] = $old->no_tlp;
        $olddata['email'] = $old->email;
        $olddata['web'] = $old->web;
        $olddata['instansi_reff'] = $old->instansi;
        $olddata['nama_pimp'] = $old->pimpinan_nama;
        $olddata['jab_pimp'] = $old->pimpinan_jabatan;
        $olddata['hp_pimp'] = $old->pimpinan_hp;
        $olddata['email_pimp'] = $old->pimpinan_email;
        $olddata['kontak_p'] = $old->kontak_p;
        $olddata['no_kontak_p'] = $old->no_kontak_p;
        $olddata['jab_kontak_p'] = $old->jab_kontak_p;
        $olddata['email_kontak_p'] = $old->email_kontak_p;
        $olddata['keterangan'] = $old->keterangan;
        $olddata['updated_by'] = Auth::id();
        $olddata['updated_at'] = Carbon::now()->toDateTimeString();

        $request->validate([
            'id_nama_kantor' => 'required',
            'id_singkat_kantor' => 'required',
            'id_level_k' => 'required',
            'id_alamat'=> 'required',
            'id_prov'=> 'required',
            'id_kota'=> 'required',
            'id_no_telp'=> 'required',
            'id_email'=> 'required',
            'id_nama_kp'=> 'required',
            'id_hp_kp'=> 'required',
            'id_email_kp'=> 'required'
        ],
        [
        'id_nama_kantor.required'=>'Nama Kantor harus diisi',    
        'id_singkat_kantor.required'=>'Singkatan Nama Kantor harus diisi',
        'id_level_k.required'=>'Level Kantor Kantor harus diisi',
        'id_alamat.required'=>'Alamat harus diisi',
        'id_prov.required'=>'Provinsi harus diisi',
        'id_kota.required'=>'Kota harus diisi',
        'id_no_telp.required'=>'No Tlp harus diisi',
        'id_email.required'=>'Email harus diisi',
        'id_nama_kp.required'=>'Nama Kontak Person harus diisi',
        'id_hp_kp.required'=>'No HP Kontak Person harus diisi',
        'id_email_kp.required'=>'Email Kontak Person harus diisi'
        ]
        );

        $kantor = Kantor::find($id);

        $kantor->nama = $request->id_nama_kantor;
        $kantor->singkatan = $request->id_singkat_kantor;
        $kantor->level_id = $request->id_level_k;
        $kantor->provinsi_id = $request->id_prov;
        $kantor->kota_id = $request->id_kota;
        $kantor->alamat = $request->id_alamat;
        $kantor->no_tlp = $request->id_no_telp;
        $kantor->email = $request->id_email;
        $kantor->web = $request->id_web;
        $kantor->instansi = $request->id_instansi;
        $kantor->pimpinan_nama = $request->id_nama_p;
        $kantor->pimpinan_jabatan = $request->id_jab_p;
        $kantor->pimpinan_hp = $request->id_hp_p;
        $kantor->pimpinan_email = $request->id_email_p;
        $kantor->kontak_p = $request->id_nama_kp;
        $kantor->no_kontak_p = $request->id_hp_kp;
        $kantor->jab_kontak_p = $request->id_jab_kp;
        $kantor->email_kontak_p = $request->id_email_kp;
        $kantor->keterangan = $request->id_keterangan;
        $kantor->updated_by = Auth::id();
        $kantor->updated_at = Carbon::now()->toDateTimeString();

        // Update Ke table Kantor
        $kantor->save();

        // Insert ke table log kantor
        // LogKantor::create($olddata);

        return redirect('master_kantor')->with('message', 'Data berhasil dirubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $idData = explode(',', $request->idHapusData);
        $old = Kantor::find($idData);

        foreach ($old as $old) {

            $olddata['id_kantor'] = $old->id;
            $olddata['nama_kantor'] = $old->nama_kantor;
            $olddata['nama_singkat'] = $old->nama_singkat;
            $olddata['level'] = $old->level;
            $olddata['prop'] = $old->prop;
            $olddata['kota'] = $old->kota;
            $olddata['alamat'] = $old->alamat;
            $olddata['no_tlp'] = $old->no_tlp;
            $olddata['email'] = $old->email;
            $olddata['web'] = $old->web;
            $olddata['instansi_reff'] = $old->instansi_reff;
            $olddata['nama_pimp'] = $old->nama_pimp;
            $olddata['jab_pimp'] = $old->jab_pimp;
            $olddata['hp_pimp'] = $old->hp_pimp;
            $olddata['email_pimp'] = $old->email_pimp;
            $olddata['kontak_p'] = $old->kontak_p;
            $olddata['no_kontak_p'] = $old->no_kontak_p;
            $olddata['jab_kontak_p'] = $old->jab_kontak_p;
            $olddata['email_kontak_p'] = $old->email_kontak_p;
            $olddata['keterangan'] = $old->keterangan;
            $olddata['deleted_by'] = Auth::id();
            $olddata['deleted_at'] = Carbon::now()->toDateTimeString();
        // Insert ke table log badan usaha
        LogKantor::create($olddata);
        }

        $user_data = [
            'deleted_by' => Auth::id(),
            'deleted_at' => Carbon::now()->toDateTimeString()
        ];
        Kantor::whereIn('id', $idData)->update($user_data);
        return redirect('daftarkantor')->with('message', 'Data berhasil dihapus');
    }

    public function filter(Request $request)
    {
        $idlevel = Kantor::select('level')->groupBy('level')->get()->toArray();
        $level = LevelKantor::where('id',$idlevel)->get();
        $idprop = Kantor::select('prop')->groupBy('prop')->get()->toArray();
        $prov = Provinsi::where('id',$idprop)->get();
        
        $kantor = Kantor::orderBy('id','asc')->groupBy('nama_kantor')->get();
        $data = Kantor::orderBy('id','asc');

        if (!$request->f_level===NULL || !$request->f_level==""){
            $data->where('level', '=', $request->f_level);
        }

        if (!$request->f_provinsi===NULL || !$request->f_provinsi==""){
            $data->where('prop', '=', $request->f_provinsi);
            $idkota = Kantor::select('kota')->groupBy('kota')->get()->toArray();
            $kota = Kota::whereIn('id',$idkota)->where('provinsi_id',$request->f_provinsi)->get();
        }else{
            $kota = Kota::where('id','=','~')->get();
        }

        if (!$request->f_kantor===NULL || !$request->f_kantor==""){
            $data->where('nama_singkat', '=', $request->f_kantor);
        }

        if (!$request->f_kota===NULL || !$request->f_kota==""){
            $data->where('kota', '=', $request->f_kota);
        }

        $data->get();
        $data = $data->get();

        return view('suket.daftarkantor.index')->with(compact('data','prov','kota','level','kantor'));

        // dd($request->f_naker_prov);
    }

    public function changelevelatas(Request $request){
        return $data = Kantor::where('level','=',$request->id_level_k-1)->get(['id','nama_kantor as text']);
    }
}
