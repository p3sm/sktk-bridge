<?php

namespace App\Http\Controllers;

use App\TeamKontribusiTa;
use App\Provinsi;
use App\Kota;
use App\Asosiasi;
use App\BadanUsaha;
use App\BentukUsaha;
use App\JenisUsaha;
use App\PjkLpjk;
use App\Bank;
use App\Team;
use App\TimProduksi;
use App\TimProduksiLevel;
use App\TimMarketing;
use App\TimMarketingLevel;
use App\TimMarketingGolHarga;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarketingController extends Controller
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
            return redirect('marketing/' . $request->pilih_data[0] . '/edit');
          } else {
            return redirect('marketing')->with('error', 'Pilih data yang akan ubah');
          }
      }

      if($request->hapus){
          if($request->pilih_data){
              foreach($request->pilih_data as $res){
                $del = TimMarketing::findOrFail($res);
                if(!$del->delete()){
                  return redirect('marketing')->with('error', 'Gagal menghapus data');
                }
              }
              return redirect('marketing')->with('success', 'Data berhasil dihapus');
          } else {                
            return redirect('marketing')->with('error', 'Pilih data yang akan dihapus');
          }
      }

      $model = new TimMarketing();

      if($request->prd) $model = $model->where(function ($query) use ($request) {
        $query->where("parent_id", $request->prd)
              ->orWhere("id", $request->prd);
      });
      if($request->mkt) $model = $model->where(function ($query) use ($request) {
        $query->where("parent_id", $request->mkt)
              ->orWhere("id", $request->mkt);
      });
      if($request->prv) $model = $model->where("provinsi_id", $request->prv);
      if($request->pjk) $model = $model->where("pjk_lpjk_id", $request->pjk);
      if($request->lvl) $model = $model->where("level_id", $request->lvl);
      if($request->kot) $model = $model->where("kota_id", $request->kot);
      if($request->jnu) $model = $model->where("jenis_usaha_id", $request->jnu);
      if($request->gol) $model = $model->where("gol_harga_id", $request->gol);

      $data['tim_produksi'] = TimProduksi::where("parent_id", null)->get()->sortBy("name");
      $data['tim_marketing'] = TimMarketing::where("parent_id", null)->get()->sortBy("name");
      $data['provinsi'] = Provinsi::all();
      $data['gol_harga'] = TimMarketingGolHarga::all();
      $data['level'] = TimProduksiLevel::all();
      $data['jenis_usaha'] = JenisUsaha::all()->sortBy("nama");
      $data['request'] = $request;
      $data['results'] = $model->get();
      $data['provinsi_data'] = Provinsi::all();

    	return view('team/marketing/index')->with($data);
    }

    public function viewList(Request $request)
    {      
      $model = new TimMarketing();

      if($request->prd) $model = $model->where(function ($query) use ($request) {
        $query->where("parent_id", $request->prd)
              ->orWhere("id", $request->prd);
      });
      if($request->mkt) $model = $model->where(function ($query) use ($request) {
        $query->where("parent_id", $request->mkt)
              ->orWhere("id", $request->mkt);
      });
      if($request->prv) $model = $model->where("provinsi_id", $request->prv);
      if($request->pjk) $model = $model->where("pjk_lpjk_id", $request->pjk);
      if($request->lvl) $model = $model->where("level_id", $request->lvl);
      if($request->kot) $model = $model->where("kota_id", $request->kot);
      if($request->jnu) $model = $model->where("jenis_usaha_id", $request->jnu);
      if($request->gol) $model = $model->where("gol_harga_id", $request->gol);

      $data['tim_produksi'] = TimProduksi::where("parent_id", null)->get()->sortBy("name");
      $data['tim_marketing'] = TimMarketing::where("parent_id", null)->get()->sortBy("name");
      $data['provinsi'] = Provinsi::all();
      $data['gol_harga'] = TimMarketingGolHarga::all();
      $data['level'] = TimProduksiLevel::all();
      $data['jenis_usaha'] = JenisUsaha::all()->sortBy("nama");
      $data['request'] = $request;
      $data['results'] = $model->get();
      $data['provinsi_data'] = Provinsi::all();

    	return view('team/marketing/index_view')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $data["teams"] = Team::all()->sortBy("name");
      $data['tim_produksi'] = TimProduksi::all()->sortBy("name");
      $data["tim_produksi_level"] = TimProduksiLevel::all();
      $data['tim_marketing'] = TimMarketing::where("parent_id", null)->get()->sortBy("name");
      $data["tim_marketing_level"] = TimMarketingLevel::all();
      $data["tim_marketing_gol_harga"] = TimMarketingGolHarga::all()->sortBy("gol_harga");
      $data["asosiasi"] = Asosiasi::all()->sortBy("nama");
      $data["provinsi"] = Provinsi::all();
      $data["badan_usaha"] = BadanUsaha::all();
      $data["bentuk_usaha"] = BentukUsaha::all()->sortBy("nama");
      $data["jenis_usaha"] = JenisUsaha::all()->sortBy("nama");
      $data["pjk_lpjk"] = PjkLpjk::all();
      $data["banks"] = Bank::all();

      return view('team/marketing/create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $produksi = TimProduksi::find($request->tim_produksi_id);

      if($request->parent_id == null){
        $existing = TimMarketing::where("parent_id", null)->where("tim_produksi_id", $request->tim_produksi_id)->get();
        $kode = $produksi->kode . "." . (count($existing) + 1);
      } else {
        $parent = TimMarketing::find($request->parent_id);
        $existing = TimMarketing::where("parent_id", $request->parent_id)->where("tim_produksi_id", $request->tim_produksi_id)->get();
        $kode = $parent->kode . "." . (count($existing) + 1);
      }

      // dd($kode);
      // dd($existing);

      $timProduksi = new TimMarketing();

      $timProduksi->tim_produksi_id = $request->tim_produksi_id;
      $timProduksi->parent_id = $request->level_id == 1 ? null : $request->parent_id;
      $timProduksi->jenis_usaha_id = $request->jenis_usaha;
      $timProduksi->badan_usaha_id = $request->badan_usaha;
      $timProduksi->bentuk_usaha_id = $request->bentuk_usaha;
      $timProduksi->level_id = $request->level;
      $timProduksi->kualifikasi_type = $request->kualifikasi_type;
      $timProduksi->gol_harga_id = $request->gol_harga;
      $timProduksi->kode = $kode;
      $timProduksi->nama = $request->nama;
      $timProduksi->singkatan = $request->nama_singkat;
      $timProduksi->provinsi_id = $request->provinsi_id;
      $timProduksi->kota_id = $request->kota_id;
      $timProduksi->alamat = $request->alamat;
      $timProduksi->no_tlp = $request->no_telp;
      $timProduksi->email = $request->email;
      $timProduksi->web = $request->web;
      $timProduksi->instansi = $request->instansi;
      $timProduksi->pimpinan_nama = $request->pimpinan;
      $timProduksi->pimpinan_jabatan = $request->pimpinan_jabatan;
      $timProduksi->pimpinan_hp = $request->pimpinan_hp;
      $timProduksi->pimpinan_email = $request->pimpinan_email;
      $timProduksi->kontak_p = $request->pic;
      $timProduksi->no_kontak_p = $request->pic_no;
      $timProduksi->jab_kontak_p = $request->pic_jabatan;
      $timProduksi->email_kontak_p = $request->pic_email;
      $timProduksi->npwp = $request->npwp;
      $timProduksi->npwp_pdf = $request->npwp_file;
      $timProduksi->rekening_no = $request->rek;
      $timProduksi->rekening_nama = $request->rek_name;
      $timProduksi->rekening_bank = $request->bank;
      $timProduksi->keterangan = $request->keterangan;
      $timProduksi->is_active = 1;
      $timProduksi->created_by = Auth::id();
      $timProduksi->updated_by = Auth::id();

      // dd($timProduksi);

      $timProduksi->save();

      return redirect('/marketing')->with('success', 'User berhasil dibuat');

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
      $data['data'] = TimMarketing::find($id);

      $data["teams"] = Team::all()->sortBy("name");
      $data['tim_produksi'] = TimProduksi::all()->sortBy("name");
      $data["tim_produksi_level"] = TimProduksiLevel::all();
      $data['tim_marketing'] = TimMarketing::where("parent_id", null)->get()->sortBy("name");
      $data["tim_marketing_level"] = TimMarketingLevel::all();
      $data["tim_marketing_gol_harga"] = TimMarketingGolHarga::all()->sortBy("gol_harga");
      $data["asosiasi"] = Asosiasi::all()->sortBy("nama");
      $data["provinsi"] = Provinsi::all();
      $data["kota"] = Kota::where('provinsi_id', $data['data']->provinsi_id)->get();
      $data["badan_usaha"] = BadanUsaha::all();
      $data["bentuk_usaha"] = BentukUsaha::all()->sortBy("nama");
      $data["jenis_usaha"] = JenisUsaha::all()->sortBy("nama");
      $data["pjk_lpjk"] = PjkLpjk::all();
      $data["banks"] = Bank::all();

      return view('team/marketing/edit')->with($data);
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
      $timMktg = TimMarketing::find($id);
      
      $timMktg->tim_produksi_id = $request->tim_produksi_id;
      $timMktg->parent_id = $request->level_id == 1 ? null : $request->parent_id;
      $timMktg->jenis_usaha_id = $request->jenis_usaha;
      $timMktg->badan_usaha_id = $request->badan_usaha;
      $timMktg->bentuk_usaha_id = $request->bentuk_usaha;
      $timMktg->level_id = $request->level;
      $timMktg->kualifikasi_type = $request->kualifikasi_type;
      $timMktg->gol_harga_id = $request->gol_harga;
      $timMktg->nama = $request->nama;
      $timMktg->singkatan = $request->nama_singkat;
      $timMktg->provinsi_id = $request->provinsi_id;
      $timMktg->kota_id = $request->kota_id;
      $timMktg->alamat = $request->alamat;
      $timMktg->no_tlp = $request->no_telp;
      $timMktg->email = $request->email;
      $timMktg->web = $request->web;
      $timMktg->instansi = $request->instansi;
      $timMktg->pimpinan_nama = $request->pimpinan;
      $timMktg->pimpinan_jabatan = $request->pimpinan_jabatan;
      $timMktg->pimpinan_hp = $request->pimpinan_hp;
      $timMktg->pimpinan_email = $request->pimpinan_email;
      $timMktg->kontak_p = $request->pic;
      $timMktg->no_kontak_p = $request->pic_no;
      $timMktg->jab_kontak_p = $request->pic_jabatan;
      $timMktg->email_kontak_p = $request->pic_email;
      $timMktg->npwp = $request->npwp;
      $timMktg->npwp_pdf = $request->npwp_file;
      $timMktg->rekening_no = $request->rek;
      $timMktg->rekening_nama = $request->rek_name;
      $timMktg->rekening_bank = $request->bank;
      $timMktg->keterangan = $request->keterangan;
      $timMktg->is_active = 1;
      $timMktg->updated_by = Auth::id();

      $timMktg->save();

      
      if($timMktg->save())
        return redirect('/marketing')->with('success', 'Berhasil merubah data');
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
