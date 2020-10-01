<?php

namespace App\Http\Controllers;

use App\TeamKontribusiTa;
use App\Provinsi;
use App\Asosiasi;
use App\BadanUsaha;
use App\Bidang;
use App\BidangSub;
use App\BentukUsaha;
use App\JenisUsaha;
use App\TimProduksiLevel;
use App\PjkLpjk;
use App\PjkLpjkDetail;
use App\Bank;
use App\Team;
use App\TimProduksi;
use App\TimProduksiGolHarga;
use App\StatusKantor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PjkLpjkController extends Controller
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
            return redirect('master_pjklpjk/' . $request->pilih_data[0] . '/edit');
          } else {
            return redirect('master_pjklpjk')->with('error', 'Pilih data yang akan ubah');
          }
      }

      if($request->hapus){
          if($request->pilih_data){
              foreach($request->pilih_data as $res){
                PjkLpjkDetail::where("pjk_lpjk_id", $res)->delete();
                $del = PjkLpjk::findOrFail($res);
                if(!$del->delete()){
                  return redirect('master_pjklpjk')->with('error', 'Gagal menghapus data');
                }
              }
              return redirect('master_pjklpjk')->with('success', 'Data berhasil dihapus');
          } else {                
            return redirect('master_pjklpjk')->with('error', 'Pilih data yang akan dihapus');
          }
      }

      $from = $request->from ? Carbon::createFromFormat("d/m/Y", $request->from) : Carbon::now();
      $to = $request->to ? Carbon::createFromFormat("d/m/Y", $request->to) : Carbon::now();
      $provinsi = $request->prv;
      $tim = $request->tim;
      $asosiasi = $request->aso;

      $model = new PjkLpjk();

      if($request->prv) $model = $model->where("id_propinsi_reg", $request->prv);
      if($request->aso) $model = $model->where("id_asosiasi_profesi", $request->aso);
      if($request->tim) $model = $model->where("team_id", $request->tim);
      if($request->kua) $model = $model->where("id_kualifikasi", $request->kua);

      $data['from'] = $from;
      $data['to'] = $to;
      $data['asosiasi'] = $asosiasi;
      $data['provinsi'] = $provinsi;
      $data['results'] = $model->get();
      $data['provinsi_data'] = Provinsi::all();

    	return view('pjklpjk/index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $data["badan_usaha"] = BadanUsaha::all();
      $data["bidang"] = Bidang::all();
      $data["provinsi"] = Provinsi::all();

      return view('pjklpjk/create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $pj = new PjkLpjk();

      $pj->badan_usaha_id = $request->badan_usaha;
      $pj->no_sk = $request->no_sk;
      $pj->tgl_sk = Carbon::createFromFormat("d/m/Y", $request->tgl_sk);
      $pj->tgl_sk_akhir = Carbon::createFromFormat("d/m/Y", $request->tgl_sk_akhir);
      $pj->keterangan = $request->keterangan;
      $pj->is_active = $request->is_active ? 1 : 0;
      $pj->created_by = Auth::id();
      $pj->updated_by = Auth::id();

      if($pj->save()){
        foreach($request->provinsi as $i => $prov){
          $pjd = new PjkLpjkDetail();

          $pjd->pjk_lpjk_id = $pj->id;
          $pjd->provinsi_id = $request->provinsi[$i];
          $pjd->klasifikasi = $request->klasifikasi[$i];
          $pjd->sub_klasifikasi = $request->sub_klasifikasi[$i];
          $pjd->kualifikasi = $request->kualifikasi[$i];
          $pjd->sub_kualifikasi = $request->sub_kualifikasi[$i];
          $pjd->keterangan = $request->keterangan_detail[$i];
          $pjd->is_active = array_key_exists($i, $request->is_active_detail) ? 1 : 0;
          $pjd->save();
        }
      }

      return redirect('/master_pjklpjk')->with('success', 'PJS LPJK berhasil dibuat');

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
      $data['data'] = PjkLpjk::find($id);

      $data["badan_usaha"] = BadanUsaha::all();
      $data["bidang"] = Bidang::all();

      $subbidang = [];
      foreach($data['data']->detail as $detail){
        $subbidang[] = BidangSub::where('bidang_id', $detail->klasifikasi)->get();
      }

      $data["sub_bidang"] = $subbidang;
      $data["provinsi"] = Provinsi::all();

      return view('pjklpjk/edit')->with($data);
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
      $pj = PjkLpjk::find($id);

      $pj->badan_usaha_id = $request->badan_usaha;
      $pj->no_sk = $request->no_sk;
      $pj->tgl_sk = Carbon::createFromFormat("d/m/Y", $request->tgl_sk);
      $pj->tgl_sk_akhir = Carbon::createFromFormat("d/m/Y", $request->tgl_sk_akhir);
      $pj->keterangan = $request->keterangan;
      $pj->is_active = $request->is_active ? 1 : 0;
      $pj->updated_by = Auth::id();

      if($pj->save()){
        $exist = PjkLpjkDetail::where("pjk_lpjk_id", $pj->id);
        $exist->delete();

        if($request->has('provinsi')){
          foreach($request->provinsi as $i => $prov){
            $pjd = new PjkLpjkDetail();

            $pjd->pjk_lpjk_id = $pj->id;
            $pjd->provinsi_id = $request->provinsi[$i];
            $pjd->klasifikasi = $request->klasifikasi[$i];
            $pjd->sub_klasifikasi = $request->sub_klasifikasi[$i];
            $pjd->kualifikasi = $request->kualifikasi[$i];
            $pjd->sub_kualifikasi = $request->sub_kualifikasi[$i];
            $pjd->keterangan = $request->keterangan_detail[$i];
            $pjd->is_active = array_key_exists($i, $request->is_active_detail) ? 1 : 0;
            $pjd->save();
          }
        }
        
        if($request->has('provinsi_new')){
          foreach($request->provinsi_new as $i => $prov){
            $pjd = new PjkLpjkDetail();
  
            $pjd->pjk_lpjk_id = $pj->id;
            $pjd->provinsi_id = $request->provinsi_new[$i];
            $pjd->klasifikasi = $request->klasifikasi_new[$i];
            $pjd->sub_klasifikasi = $request->sub_klasifikasi_new[$i];
            $pjd->kualifikasi = $request->kualifikasi_new[$i];
            $pjd->sub_kualifikasi = $request->sub_kualifikasi_new[$i];
            $pjd->keterangan = $request->keterangan_detail_new[$i];
            $pjd->is_active = array_key_exists($i, $request->is_active_detail_new) ? 1 : 0;
            $pjd->save();
          }
        }

        return redirect()->back()->with('success', "Edited successfully");
      } else {
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
