<?php

namespace App\Http\Controllers;

use App\ApprovalTransaction;
use App\SikiAsosiasi;
use App\TeamKontribusiTa;
use App\PersonalRegTa;
use App\PersonalRegTaSync;
use App\PersonalRegTaApprove;
use App\TimMarketing;
use App\TimMarketingGolHarga;
use App\TimMarketingGolHargaDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApprovalRegtaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::user()->myAsosiasi()){
            return redirect('/approval_regta/' . Auth::user()->myAsosiasi()->id_asosiasi);
        }
        
    	return view('approval/regta/index');
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

        $data['response'] = $obj->response;
        $data['results'] = $obj->response > 0 ? $obj->result : [];
        $data['role'] = Auth::user()->role_id;
        $data['asosiasi'] = Auth::user()->asosiasi->asosiasi_id;

    	return view('approval/regta/list')->with($data);
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

    public function approve(Request $request, $id)
    {
        // dd($request);
        // $asosiasiId = 142;
        $asosiasi = SikiAsosiasi::find($id);
        // $reg = SikiRegta::find($id);

        $postData = [
          "id_personal"           => $request->query('ID_Personal'),
          "id_sub_bidang"         => $request->query('ID_Sub_Bidang'),
          "id_kualifikasi"        => $request->query('ID_Kualifikasi'),
          "id_unit_sertifikasi"   => $request->query('id_unit_sertifikasi'),
          "tgl_permohonan"        => $request->query('Tgl_Registrasi'),
          "tahun"                 => Carbon::parse($request->query('Tgl_Registrasi'))->format("Y"),
          "id_provinsi"           => $request->query('ID_Propinsi_reg'),
          "id_permohonan"         => $request->query('id_permohonan'),
          "id_status"             => 99,
          "catatan"               => ""
        ];

        // dd($postData);

        $curl = curl_init();
        $header[] = "X-Api-Key:" . $asosiasi->apikey->lpjk_key;
        $header[] = "Token:" . $asosiasi->apikey->token;
        $header[] = "Content-Type:multipart/form-data";
        curl_setopt_array($curl, array(
            CURLOPT_URL => config("app.lpjk_endpoint") . "Service/History/TA",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_HTTPHEADER => $header,
        ));
        $response = curl_exec($curl);

        // dd($response);

        // echo $response;
        // exit;
        
        if($obj = json_decode($response)){
      
            if($obj->message == "Token Anda Sudah Expired ! Silahkan Lakukan Aktivasi Token Untuk Mendapatkan Token Baru." || $obj->message == "Token Anda Tidak Terdaftar ! Silahkan Lakukan Aktivasi Token Untuk Mendapatkan Token Baru."){
                if($this->refreshToken()){
                    return $this->approve($request, $id);
                } else {
                    $result = new \stdClass();
                    $result->message = "Error while refreshing token, please contact Administrator";
                    $result->status = 401;
      
                    return response()->json($result, 401);
                }
            }

            if($obj->response) {
                $this->ApproveTransaction($request);
                // if($this->createApproveLog($reg))
                return redirect()->back()->with('success', $obj->message);
            }
            return redirect()->back()->with('error', $obj->message);
        }

        return redirect()->back()->with('error', "An error has occurred");
    }

    public function ApproveTransaction($request){
        $regta = PersonalRegTa::where("ID_Registrasi_TK_Ahli", $request->ID_Registrasi_TK_Ahli)->first();

        $teamKontribusi = TeamKontribusiTa::where("team_id", $request->query('team'))
        ->where("id_asosiasi_profesi", $request->query('ID_Asosiasi_Profesi'))
        ->where("id_propinsi_reg", $request->query('ID_Propinsi_reg'))
        ->where("id_kualifikasi", $request->query('ID_Kualifikasi'))
        ->first();

        // if($regta->user->tipe_akun == 2){
        //     $golharga = TimMarketingGolHargaDetail::where("gol_harga_id", $regta->user->marketing->gol_harga_id)->first();
        //     $harga = $golharga->harga;
        // } else {
        //     $harga = 0;
        // }

        if($request->query('team')){
            $mktg = TimMarketing::find($request->query('team'));
            $golharga = TimMarketingGolHargaDetail::where("gol_harga_id", $mktg->gol_harga_id)
            ->where('id_permohonan', $request->query('id_permohonan'))
            ->where('kualifikasi', "SKA")
            ->where('sub_kualifikasi', $request->query('ID_Kualifikasi'))
            ->where('asosiasi_id', $request->query('ID_Asosiasi_Profesi'))
            ->first();
            $harga = $golharga->harga;
        } else {
            $harga = 0;
        }
        
        $approvalTrx                      = new ApprovalTransaction();
        $approvalTrx->id_asosiasi_profesi = $request->query('ID_Asosiasi_Profesi');
        $approvalTrx->id_propinsi_reg     = $request->query('ID_Propinsi_reg');
        $approvalTrx->team_id             = $request->query('team');
        $approvalTrx->tipe_sertifikat     = "SKA";
        $approvalTrx->id_personal         = $request->query('ID_Personal');
        $approvalTrx->nama                = $request->query('Nama');
        $approvalTrx->id_sub_bidang       = $request->query('ID_Sub_Bidang');
        $approvalTrx->id_unit_sertifikasi = $request->query('id_unit_sertifikasi');
        $approvalTrx->tgl_registrasi      = $request->query('Tgl_Registrasi');
        $approvalTrx->id_kualifikasi      = $request->query('ID_Kualifikasi');
        $approvalTrx->id_permohonan       = $request->query('id_permohonan');
        $approvalTrx->dpp_adm_anggota     = 0;
        $approvalTrx->dpp_kontribusi      = $harga;
        $approvalTrx->dpp_total           = $harga;
        $approvalTrx->owner               = Auth::id();
        $approvalTrx->created_by          = Auth::id();
        $approvalTrx->save();
    }
}
