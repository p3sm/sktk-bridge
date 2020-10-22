<?php

namespace App\Http\Controllers;

use App\TeamKontribusiTa;
use App\Provinsi;
use App\Kota;
use App\Asosiasi;
use App\BadanUsaha;
use App\BentukUsaha;
use App\JenisUsaha;
use App\TimProduksiLevel;
use App\PjkLpjk;
use App\Bank;
use App\Team;
use App\TimProduksi;
use App\TimProduksiGolHarga;
use App\StatusKantor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BadanUsahaController extends Controller
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
            return redirect('master_badanusaha/' . $request->pilih_data[0] . '/edit');
          } else {
            return redirect('master_badanusaha')->with('error', 'Pilih data yang akan ubah');
          }
      }

      $model = new BadanUsaha();

      if($request->prv) $model = $model->where("provinsi_id", $request->prv);
      if($request->kot) $model = $model->where("kota_id", $request->kot);

      $data['results'] = $model->get();
      $data['provinsi_data'] = Provinsi::all();
      $data['request'] = $request;

    	return view('badanusaha/index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $data["asosiasi"] = Asosiasi::all()->sortBy("nama");
      $data["provinsi"] = Provinsi::all();
      $data["badan_usaha"] = BadanUsaha::where('status_kantor_proyek', 2)->get();
      $data["bentuk_usaha"] = BentukUsaha::all()->sortBy("nama");
      $data["jenis_usaha"] = JenisUsaha::all()->sortBy("nama");
      $data["banks"] = Bank::all();
      $data["status_kantor"] = StatusKantor::all();

      return view('badanusaha/create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $bu = new BadanUsaha();

      $bu->jenis_usaha_id = $request->jenis_usaha;
      $bu->asosiasi_id = $request->asosiasi;
      $bu->status_kantor_proyek = $request->status_kantor;
      $bu->bentuk_usaha_id = $request->bentuk_usaha;
      $bu->nama = $request->nama;
      $bu->singkatan = $request->nama_singkat;
      $bu->provinsi_id = $request->provinsi_id;
      $bu->kota_id = $request->kota_id;
      $bu->alamat = $request->alamat;
      $bu->no_tlp = $request->no_telp;
      $bu->email = $request->email;
      $bu->web = $request->web;
      $bu->instansi = $request->instansi;
      $bu->pimpinan_nama = $request->pimpinan;
      $bu->pimpinan_jabatan = $request->pimpinan_jabatan;
      $bu->pimpinan_hp = $request->pimpinan_no;
      $bu->pimpinan_email = $request->pimpinan_email;
      $bu->kontak_p = $request->pic;
      $bu->no_kontak_p = $request->pic_no;
      $bu->jab_kontak_p = $request->pic_jabatan;
      $bu->email_kontak_p = $request->pic_email;
      $bu->npwp = $request->npwp;
      $bu->npwp_pdf = $request->npwp_file;
      $bu->rekening_no = $request->rek;
      $bu->rekening_nama = $request->rek_name;
      $bu->rekening_bank = $request->bank;
      $bu->keterangan = $request->keterangan;
      $bu->is_active = 1;
      $bu->created_by = Auth::id();
      $bu->updated_by = Auth::id();

      $bu->save();

      return redirect('/master_badanusaha')->with('success', 'Badan Usaha berhasil dibuat');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $data['data'] = BadanUsaha::find($id);

      $data["asosiasi"] = Asosiasi::all()->sortBy("nama");
      $data["provinsi"] = Provinsi::all();
      $data["kota"] = Kota::where('provinsi_id', $data['data']->provinsi_id)->get();
      $data["badan_usaha"] = BadanUsaha::where('status_kantor_proyek', 2)->get();
      $data["bentuk_usaha"] = BentukUsaha::all()->sortBy("nama");
      $data["jenis_usaha"] = JenisUsaha::all()->sortBy("nama");
      $data["banks"] = Bank::all();
      $data["status_kantor"] = StatusKantor::all();

      return view('badanusaha/edit')->with($data);
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
      $data = BadanUsaha::find($id);

      $data->jenis_usaha_id = $request->jenis_usaha;
      $data->asosiasi_id = $request->asosiasi;
      $data->status_kantor_proyek = $request->status_kantor;
      $data->bentuk_usaha_id = $request->bentuk_usaha;
      $data->nama = $request->nama;
      $data->singkatan = $request->nama_singkat;
      $data->provinsi_id = $request->provinsi_id;
      $data->kota_id = $request->kota_id;
      $data->alamat = $request->alamat;
      $data->no_tlp = $request->no_telp;
      $data->email = $request->email;
      $data->web = $request->web;
      $data->instansi = $request->instansi;
      $data->pimpinan_nama = $request->pimpinan;
      $data->pimpinan_jabatan = $request->pimpinan_jabatan;
      $data->pimpinan_hp = $request->pimpinan_no;
      $data->pimpinan_email = $request->pimpinan_email;
      $data->kontak_p = $request->pic;
      $data->no_kontak_p = $request->pic_no;
      $data->jab_kontak_p = $request->pic_jabatan;
      $data->email_kontak_p = $request->pic_email;
      $data->npwp = $request->npwp;
      $data->npwp_pdf = $request->npwp_file;
      $data->rekening_no = $request->rek;
      $data->rekening_nama = $request->rek_name;
      $data->rekening_bank = $request->bank;
      $data->keterangan = $request->keterangan;
      $data->is_active = 1;
      $data->created_by = Auth::id();
      $data->updated_by = Auth::id();
      
      if($data->save())
        return redirect()->back()->with('success', "Edited successfully");
      else {
        return redirect()->back()->with('error', "An error occurred");
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
