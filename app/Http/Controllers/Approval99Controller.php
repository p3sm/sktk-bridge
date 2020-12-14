<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use App\User;
use App\ApprovalTransaction;
use App\SikiAsosiasi;
use App\BadanUsaha;
use App\Provinsi;
use App\TeamProvinsi;
use App\Team;
use App\TeamKontribusiTa;
use App\TeamKontribusiTt;
use App\TimProduksi;
use App\TimMarketing;
use App\TimMarketingGolHarga;
use App\TimMarketingGolHargaDetail;
use App\PersonalRegTa;
use App\PersonalRegTt;
use App\PersonalRegTaSync;
use App\PersonalRegTaApprove;
use App\Pengajuan99;

class Approval99Controller extends Controller
{
    private $message = "";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $result = new Collection();
        $from = $request->from ? Carbon::createFromFormat("d/m/Y", $request->from) : Carbon::now();
        $to = $request->to ? Carbon::createFromFormat("d/m/Y", $request->to) : Carbon::now();
        $provinsi = $request->prv;
        $tim = $request->tim;
        $asosiasi = $request->aso;
        $sertifikat = $request->srtf;

        $ids = [];

        if(Auth::user()->tipe_akun == 1){
            $ids[] = Auth::user()->id;

            if(Auth::user()->role_id == 1 || Auth::user()->role_id == 4){
                $p = Auth::user()->asosiasi->provinsi_id;
                $a = Auth::user()->asosiasi->asosiasi_id;
                $bu = BadanUsaha::where("asosiasi_id", $a)->first();
                $asosiasi = $a;
                $team = [];

                // foreach($bu->pjk as $pjk){
                //     foreach($pjk->timprod as $timprod){
                //         foreach($timprod->users as $us){
                //             $ids[] = $us->id;
                //         }
                //         foreach($timprod->marketing as $timmktg){
                //             foreach($timmktg->users as $us){
                //                 $ids[] = $us->id;
                //             }
                //         }
                //     }
                // }
                foreach(User::all() as $us){
                    $ids[] = $us->id;
                }
            }

        } else if(Auth::user()->tipe_akun == 2){
            $ids[] = Auth::user()->id;

            foreach(Auth::user()->produksi->marketing as $mar){
                foreach($mar->users as $us){
                    $ids[] = $us->id;
                }
            }
        } else if(Auth::user()->tipe_akun == 3){
            $ids[] = Auth::user()->id;
        } else {
            return redirect('/');
        }

        if($sertifikat == "SKA" || $sertifikat == null) {
        
            $model = PersonalRegTa::whereDate("Tgl_Registrasi", ">=", $from->format('Y-m-d'))
            ->whereDate("Tgl_Registrasi", "<=", $to->format('Y-m-d'))->whereIn('created_by', $ids);
    
            if($asosiasi) $model = $model->where("ID_Asosiasi_Profesi", $asosiasi);
            if($provinsi) $model = $model->where("ID_Propinsi_reg", $provinsi);
            // if($tim) $model = $model->where("team_id", $tim);

            $pengajuan = $model->orderByDesc("created_at")->get();
            // dd($pengajuan);
  
            foreach($pengajuan as $value){
                $value->tipe_sertifikat = 'SKA';
                $value->id = $value->ID_Registrasi_TK_Ahli;
            }
      
            $result = $result->merge($pengajuan);
        }

        if($sertifikat == "SKT" || $sertifikat == null) {
        
            $model = PersonalRegTt::whereDate("Tgl_Registrasi", ">=", $from->format('Y-m-d'))
            ->whereDate("Tgl_Registrasi", "<=", $to->format('Y-m-d'))->whereIn('created_by', $ids);
    
            if($asosiasi) $model = $model->where("ID_Asosiasi_Profesi", $asosiasi);
            if($provinsi) $model = $model->where("ID_propinsi_reg", $provinsi);
            // if($tim) $model = $model->where("team_id", $tim);

            $pengajuan = $model->orderByDesc("created_at")->get();
  
            foreach($pengajuan as $value){
                $value->tipe_sertifikat = 'SKT';
                $value->id = $value->ID_Registrasi_TK_Trampil;
            }
      
            $result = $result->merge($pengajuan);
        }

        if($request->setuju){
            if($request->pilih_permohonan){
                foreach($result as $res){
                    if (in_array($res->id, $request->pilih_permohonan)) {
                        if(!$this->approveV2($res)){
                            return redirect('approval_99?from='.$from->format("d/m/Y").'&to='.$to->format("d/m/Y").'&srtf='.$sertifikat.'&prv='.$provinsi.'&aso='.$asosiasi.'&tim=' . $tim)->with('error', $this->message);
                        }
                    }
                }
                return redirect('approval_99?from='.$from->format("d/m/Y").'&to='.$to->format("d/m/Y").'&srtf='.$sertifikat.'&prv='.$provinsi.'&aso='.$asosiasi.'&tim=' . $tim)->with('success', $this->message);
            } else {
                return redirect('approval_99?from='.$from->format("d/m/Y").'&to='.$to->format("d/m/Y").'&srtf='.$sertifikat.'&prv='.$provinsi.'&aso='.$asosiasi.'&tim=' . $tim)->with('error', 'Pilih data yang akan disetujui');
            }
        }

        if($request->hapus){
            if($request->pilih_permohonan){
                foreach($result as $res){
                    if (in_array($res->id, $request->pilih_permohonan)) {
                        if(!$this->delete($res)){
                            return redirect('approval_99?from='.$from->format("d/m/Y").'&to='.$to->format("d/m/Y").'&srtf='.$sertifikat.'&prv='.$provinsi.'&aso='.$asosiasi.'&tim=' . $tim)->with('error', $this->message);
                        }
                    }
                }
                return redirect('approval_99?from='.$from->format("d/m/Y").'&to='.$to->format("d/m/Y").'&srtf='.$sertifikat.'&prv='.$provinsi.'&aso='.$asosiasi.'&tim=' . $tim)->with('success', $this->message);
            } else {                
                return redirect('approval_99?from='.$from->format("d/m/Y").'&to='.$to->format("d/m/Y").'&srtf='.$sertifikat.'&prv='.$provinsi.'&aso='.$asosiasi.'&tim=' . $tim)->with('error', 'Pilih data yang akan dihapus');
            }
        }

        $data['results'] = $result;
        $data['from'] = $from;
        $data['to'] = $to;
        $data['asosiasi'] = $asosiasi;
        $data['provinsi'] = $provinsi;
        $data['tim'] = $tim;
        $data['sertifikat'] = $sertifikat;
        $data['tim_data'] = Team::all();
        $data['provinsi_data'] = Provinsi::all();

    	return view('approval/approval_99/list')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $data = $this->getKlasifikasi($id);
    	return view('approval/regta/list')->with($data);
    }

    public function getKlasifikasi($id)
    {
      
      $asosiasi = SikiAsosiasi::find($id);

      $postData = [
          "status_99" => 0,
          // "limit" => 10
        ];

      $curl = curl_init();
      $header[] = "X-Api-Key:" . $asosiasi->apikey->lpjk_key;
      $header[] = "Token:" . $asosiasi->apikey->token;
      $header[] = "Content-Type:multipart/form-data";
      curl_setopt_array($curl, array(
          CURLOPT_URL => config("app.lpjk_endpoint") . "Service/Klasifikasi/Get-TA",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => $postData,
          CURLOPT_HTTPHEADER => $header,
          CURLOPT_SSL_VERIFYHOST => 0,
          CURLOPT_SSL_VERIFYPEER => 0
      ));
      $response = curl_exec($curl);

      $obj = json_decode($response);
      
      if($obj->message == "Token Anda Sudah Expired ! Silahkan Lakukan Aktivasi Token Untuk Mendapatkan Token Baru." || $obj->message == "Token Anda Tidak Terdaftar ! Silahkan Lakukan Aktivasi Token Untuk Mendapatkan Token Baru."){
          if($this->refreshToken()){
              return $this->getKlasifikasi($id);
          } else {
              $result = new \stdClass();
              $result->message = "Error while refreshing token, please contact Administrator";
              $result->status = 401;

              return response()->json($result, 401);
          }
      }

      $data['response'] = $obj->response;
      $data['results'] = $obj->response > 0 ? $obj->result : [];
      $data['role'] = Auth::user()->role_id;

      return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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

    public function approve($id)
    {
        $pengajuan = Pengajuan99::find($id);
        // exit;
        // dd($request);
        // $asosiasiId = 142;
        $asosiasi = SikiAsosiasi::find(Auth::user()->myAsosiasi()->id_asosiasi);
        // $reg = SikiRegta::find($id);

        $postData = [
          "id_personal"           => $pengajuan->id_personal,
          "id_sub_bidang"         => $pengajuan->sub_bidang,
          "id_kualifikasi"        => $pengajuan->kualifikasi,
          "id_unit_sertifikasi"   => $pengajuan->ustk,
          "tgl_permohonan"        => $pengajuan->tgl_registrasi,
          "tahun"                 => Carbon::parse($pengajuan->tgl_registrasi)->format("Y"),
          "id_provinsi"           => $pengajuan->provinsi,
          "id_permohonan"         => $pengajuan->id_permohonan,
          "id_status"             => 99,
          "catatan"               => ""
        ];

        // dd($postData);

        $curl = curl_init();
        $header[] = "X-Api-Key:" . $asosiasi->apikey->lpjk_key;
        $header[] = "Token:" . $asosiasi->apikey->token;
        $header[] = "Content-Type:multipart/form-data";
        curl_setopt_array($curl, array(
            CURLOPT_URL => config("app.lpjk_endpoint") . "Service/History/" . ($pengajuan->tipe_sertifikat == "SKA" ? "TA" : "TT"),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0
        ));
        $response = curl_exec($curl);
        // dd($response);

        // echo $response;
        // exit;
        
        if($obj = json_decode($response)){
      
            if($obj->message == "Token Anda Sudah Expired ! Silahkan Lakukan Aktivasi Token Untuk Mendapatkan Token Baru." || $obj->message == "Token Anda Tidak Terdaftar ! Silahkan Lakukan Aktivasi Token Untuk Mendapatkan Token Baru."){
                if($this->refreshToken()){
                    return $this->approve($id);
                } else {
                    $result = new \stdClass();
                    $result->message = "Error while refreshing token, please contact Administrator";
                    $result->status = 401;
      
                    return response()->json($result, 401);
                }
            }
            
            if($obj->response) {
                $this->ApproveTransaction($pengajuan);
                // if($this->createApproveLog($reg))
                return redirect()->back()->with('success', $obj->message);
            }
            return redirect()->back()->with('error', $obj->message);
        }

        return redirect()->back()->with('error', "An error has occurred");
    }

    public function approveV2($pengajuan)
    {
        // $asosiasi = SikiAsosiasi::find(Auth::user()->myAsosiasi()->id_asosiasi);
        $asosiasi = SikiAsosiasi::find($pengajuan->ID_Asosiasi_Profesi);
        // $reg = SikiRegta::find($id);

        $postData = [
          "id_personal"           => $pengajuan->ID_Personal,
          "id_sub_bidang"         => $pengajuan->ID_Sub_Bidang,
          "id_kualifikasi"        => $pengajuan->ID_Kualifikasi,
          "id_unit_sertifikasi"   => $pengajuan->id_unit_sertifikasi,
        //   "tgl_permohonan"        => $pengajuan->Tgl_Registrasi,
          "tgl_permohonan"        => Carbon::parse($pengajuan->created_at)->format("Y-m-d"),
          "tahun"                 => Carbon::parse($pengajuan->Tgl_Registrasi)->format("Y"),
          "id_provinsi"           => $pengajuan->tipe_sertifikat == "SKA" ? $pengajuan->ID_Propinsi_reg : $pengajuan->ID_propinsi_reg,
          "id_permohonan"         => $pengajuan->id_permohonan,
          "id_status"             => 99,
          "catatan"               => ""
        ];

        // dd($postData);

        $curl = curl_init();
        $header[] = "X-Api-Key:" . $asosiasi->apikey->lpjk_key;
        $header[] = "Token:" . $asosiasi->apikey->token;
        $header[] = "Content-Type:multipart/form-data";
        curl_setopt_array($curl, array(
            CURLOPT_URL => config("app.lpjk_endpoint") . "Service/History/" . ($pengajuan->tipe_sertifikat == "SKA" ? "TA" : "TT"),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0
        ));
        $response = curl_exec($curl);
        // dd($response);

        // echo $response;
        // exit;
        
        if($obj = json_decode($response)){
      
            if($obj->message == "Token Anda Sudah Expired ! Silahkan Lakukan Aktivasi Token Untuk Mendapatkan Token Baru." || $obj->message == "Token Anda Tidak Terdaftar ! Silahkan Lakukan Aktivasi Token Untuk Mendapatkan Token Baru."){
                if($this->refreshToken()){
                    return $this->approveV2($pengajuan);
                } else {
                    $result = new \stdClass();
                    $result->message = "Error while refreshing token, please contact Administrator";
                    $result->status = 401;
      
                    return response()->json($result, 401);
                }
            }
            
            if($obj->response) {
                $this->ApproveTransactionV2($pengajuan);
                // if($this->createApproveLog($reg))
                $this->message = $obj->message;
                return true;
            }
            $this->message = $obj->message;
            return false;
        }

        $this->message = "An error has occurred";
        return false;
    }

    public function ApproveTransaction($pengajuan){
        
        $pengajuanModel = Pengajuan99::find($pengajuan->id);
        $pengajuanModel->approved = 1;
        $pengajuanModel->approved_by = Auth::user()->id;
        $pengajuanModel->approved_at = Carbon::now();
        $pengajuanModel->save();
        
        if($pengajuan->tipe_sertifikat == "SKA"){
            $data = PersonalRegTa::where("Tgl_Registrasi", $pengajuan->tgl_registrasi)
            ->where("ID_Personal", $pengajuan->id_personal)
            ->where("ID_Sub_Bidang", $pengajuan->sub_bidang)
            ->where("ID_Asosiasi_Profesi", $pengajuan->asosiasi)->first();
            
            if($data){
                $data->status_terbaru = 99;
                $data->save();
            }
        } else {
            $data = PersonalRegTt::where("Tgl_Registrasi", $pengajuan->tgl_registrasi)
            ->where("ID_Personal", $pengajuan->id_personal)
            ->where("ID_Sub_Bidang", $pengajuan->sub_bidang)
            ->where("ID_Asosiasi_Profesi", $pengajuan->asosiasi)->first();
            
            if($data){
                $data->status_terbaru = 99;
                $data->save();
            }
        }

        
        if($pengajuan->tipe_sertifikat == "SKA"){
            $teamKontribusi = TeamKontribusiTa::where("team_id", $pengajuan->user->team_id)
            ->where("id_asosiasi_profesi", $pengajuan->asosiasi)
            ->where("id_propinsi_reg", $pengajuan->provinsi)
            ->where("id_kualifikasi", $pengajuan->kualifikasi)
            ->first();
        } else {
            $teamKontribusi = TeamKontribusiTt::where("team_id", $pengajuan->user->team_id)
            ->where("id_asosiasi_profesi", $pengajuan->asosiasi)
            ->where("id_propinsi_reg", $pengajuan->provinsi)
            ->where("id_kualifikasi", $pengajuan->kualifikasi)
            ->first();
        }

        $exist = ApprovalTransaction::where("tgl_registrasi", $pengajuan->tgl_registrasi)
                                    ->where("tipe_sertifikat", $pengajuan->tipe_sertifikat)
                                    ->where("id_personal", $pengajuan->id_personal)
                                    ->where("id_sub_bidang", $pengajuan->sub_bidang)
                                    ->where("id_asosiasi_profesi", $pengajuan->asosiasi)->first();
        
        if(!$exist){
            $approvalTrx                      = new ApprovalTransaction();
            $approvalTrx->id_asosiasi_profesi = $pengajuan->asosiasi;
            $approvalTrx->id_propinsi_reg     = $pengajuan->provinsi;
            $approvalTrx->team_id             = $pengajuan->user->team_id;
            $approvalTrx->tipe_sertifikat     = $pengajuan->tipe_sertifikat;
            $approvalTrx->id_personal         = $pengajuan->id_personal;
            $approvalTrx->nama                = $pengajuan->nama;
            $approvalTrx->id_sub_bidang       = $pengajuan->sub_bidang;
            $approvalTrx->id_unit_sertifikasi = $pengajuan->ustk;
            $approvalTrx->tgl_registrasi      = $pengajuan->tgl_registrasi;
            $approvalTrx->id_kualifikasi      = $pengajuan->kualifikasi;
            $approvalTrx->id_permohonan       = $pengajuan->id_permohonan;
            $approvalTrx->dpp_adm_anggota     = 0;
            $approvalTrx->dpp_kontribusi      = $teamKontribusi->kontribusi;
            $approvalTrx->dpp_total           = $teamKontribusi->kontribusi;
            $approvalTrx->owner               = $pengajuan->created_by;
            $approvalTrx->created_by          = Auth::id();
            $approvalTrx->save();
        }
    }

    public function ApproveTransactionV2($pengajuan){

        if($pengajuan->tipe_sertifikat == "SKA"){
            $data = PersonalRegTa::find($pengajuan->id);
            
            if($data){
                $data->approved = 1;
                $data->approved_by = Auth::id();
                $data->approved_at = Carbon::now();
                $data->status_terbaru = 99;
                $data->save();
            }
        } else {
            $data = PersonalRegTt::find($pengajuan->id);
            
            if($data){
                $data->approved = 1;
                $data->approved_by = Auth::id();
                $data->approved_at = Carbon::now();
                $data->status_terbaru = 99;
                $data->save();
            }
        }

        
        if($pengajuan->tipe_sertifikat == "SKA"){
            $teamKontribusi = TeamKontribusiTa::where("team_id", $pengajuan->user->team_id)
            ->where("id_asosiasi_profesi", $pengajuan->ID_Asosiasi_Profesi)
            ->where("id_propinsi_reg", $pengajuan->ID_Propinsi_reg)
            ->where("id_kualifikasi", $pengajuan->ID_Kualifikasi)
            ->first();
        } else {
            $teamKontribusi = TeamKontribusiTt::where("team_id", $pengajuan->user->team_id)
            ->where("id_asosiasi_profesi", $pengajuan->ID_Asosiasi_Profesi)
            ->where("id_propinsi_reg", $pengajuan->ID_propinsi_reg)
            ->where("id_kualifikasi", $pengajuan->ID_Kualifikasi)
            ->first();
        }

        $exist = ApprovalTransaction::where("tgl_registrasi", $pengajuan->Tgl_Registrasi)
                                    ->where("tipe_sertifikat", $pengajuan->tipe_sertifikat)
                                    ->where("id_personal", $pengajuan->ID_Personal)
                                    ->where("id_sub_bidang", $pengajuan->ID_Sub_Bidang)
                                    ->where("id_asosiasi_profesi", $pengajuan->ID_Asosiasi_Profesi)->first();

        if($pengajuan->user->marketing_id){
            $golharga = TimMarketingGolHargaDetail::where("gol_harga_id", $pengajuan->user->marketing->gol_harga_id)
            ->where('id_permohonan', $pengajuan->id_permohonan)
            ->where('kualifikasi', $pengajuan->tipe_sertifikat)
            ->where('sub_kualifikasi', $pengajuan->ID_Kualifikasi)
            ->first();
            $harga = $golharga->harga;
        } else {
            $harga = 0;
        }
        
        if(!$exist){
            $approvalTrx                      = new ApprovalTransaction();
            $approvalTrx->id_asosiasi_profesi = $pengajuan->ID_Asosiasi_Profesi;
            $approvalTrx->id_propinsi_reg     = $pengajuan->tipe_sertifikat == "SKA" ? $pengajuan->ID_Propinsi_reg : $pengajuan->ID_propinsi_reg;
            $approvalTrx->team_id             = $pengajuan->user->marketing_id ? $pengajuan->user->marketing->produksi->id : $pengajuan->user->team_id ;
            $approvalTrx->tipe_sertifikat     = $pengajuan->tipe_sertifikat;
            $approvalTrx->id_personal         = $pengajuan->ID_Personal;
            $approvalTrx->nama                = $pengajuan->personal->Nama;
            $approvalTrx->id_sub_bidang       = $pengajuan->ID_Sub_Bidang;
            $approvalTrx->id_unit_sertifikasi = $pengajuan->id_unit_sertifikasi;
            $approvalTrx->tgl_registrasi      = $pengajuan->Tgl_Registrasi;
            $approvalTrx->id_kualifikasi      = $pengajuan->ID_Kualifikasi;
            $approvalTrx->id_permohonan       = $pengajuan->id_permohonan;
            $approvalTrx->dpp_adm_anggota     = 0;
            // $approvalTrx->dpp_kontribusi      = $teamKontribusi->kontribusi;
            // $approvalTrx->dpp_total           = $teamKontribusi->kontribusi;
            $approvalTrx->dpp_kontribusi      = $harga;
            $approvalTrx->dpp_total           = $harga;
            $approvalTrx->owner               = $pengajuan->created_by;
            $approvalTrx->created_by          = Auth::id();
            $approvalTrx->save();
        }
    }

    public function delete($pengajuan){
        if($pengajuan->tipe_sertifikat == "SKA"){
            $data = PersonalRegTa::find($pengajuan->id);
            
            if($data){
                $data->deleted = 1;
                $data->deleted_by = Auth::id();
                $data->deleted_at = Carbon::now();
                if($data->save()){
                    $this->message = "data berhasil dihapus";
                    return true;
                }
            }
        } else {
            $data = PersonalRegTt::find($pengajuan->id);
            
            if($data){
                $data->deleted = 1;
                $data->deleted_by = Auth::id();
                $data->deleted_at = Carbon::now();
                if($data->save()){
                    $this->message = "data berhasil dihapus";
                    return true;
                }
            }
        }
        $this->message = "An error has occurred";
        return false;
    }
}
