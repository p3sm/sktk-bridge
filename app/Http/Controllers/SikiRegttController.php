<?php

namespace App\Http\Controllers;

use App\SikiRegtt;
use App\PersonalRegTtSync;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Storage;

class SikiRegttController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['regtts'] = SikiRegtt::take(100)->groupBy('tahap1')->orderByDesc("tgl_thp")->get();

        return view('siki/regtt/index')->with($data);
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
        $data['regtts'] = SikiRegtt::where("tahap", $id)->orderByDesc("ID_Registrasi_TK_Trampil")->get();

        return view('siki/regtt/show')->with($data);
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

    public function createSyncLog($reg, $sync)
    {
        if($reg->sync){
            $data = PersonalRegTtSync::find($reg->sync->id);
            $data->updated_at = Carbon::now();
        } else {
            $data = new PersonalRegTtSync();
        }

        $data->registrasi_tk_trampil_id = $reg->ID_Registrasi_TK_Trampil;
        $data->sync_id = $sync->ID_Registrasi_TK_Trampil;
        $data->approved_by = Auth::id();

        if($data->save())
            return true;
        else
            return false;
    }

    public function createApproveLog($reg)
    {
        if($reg->sync){
            $data = PersonalRegTtApprove::find($reg->sync->id);
            $data->updated_at = Carbon::now();
        } else {
            $data = new PersonalRegTtApprove();
        }

        $data->registrasi_tk_trampil_id = $reg->ID_Registrasi_TK_Trampil;
        $data->approved_by = Auth::id();
        
        if($data->save())
            return true;
        else
            return false;
    }

    public function sync($id)
    {
        $reg = SikiRegtt::find($id);

        if(!file_exists("uploads/source/dokumen-upload/TAHAP/" . $reg->tahap1 . "/VVA_" . $reg->ID_Personal . "_" . $reg->ID_Sub_Bidang . ".pdf")){
            return redirect()->back()->with('error', 'File VVA tidak tersedia');
        }
        if(!file_exists("uploads/source/dokumen-upload/TAHAP/" . $reg->tahap1 . "/SPENG_" . $reg->ID_Personal . "_" . $reg->ID_Sub_Bidang . ".pdf")){
            return redirect()->back()->with('error', 'File SPENG tidak tersedia');
        }
        if(!file_exists("uploads/source/dokumen-upload/TAHAP/" . $reg->tahap1 . "/SUB_" . $reg->ID_Personal . "_" . $reg->ID_Sub_Bidang . ".pdf")){
            return redirect()->back()->with('error', 'File SUB tidak tersedia');
        }

        $postData = [
          "id_registrasi_tk_trampil" => $reg->sync ? $reg->sync->sync_id : 0,
          "id_personal"              => $reg->ID_Personal,
          "id_sub_bidang"            => $reg->ID_Sub_Bidang,
          "id_asosiasi_profesi"      => $reg->ID_Asosiasi_Profesi,
          "id_kualifikasi"           => $reg->ID_Kualifikasi,
          "tgl_registrasi"           => $reg->Tgl_Registrasi,
          "id_propinsi_reg"          => $reg->ID_propinsi_reg,
          "no_sk"                    => $reg->no_sk ? $reg->no_sk : "-",
          "id_unit_sertifikasi"      => $reg->id_unit_sertifikasi,
          "id_permohonan"            => $reg->id_permohonan,
          "url_pdf_berita_acara_vva"          => curl_file_create(realpath("uploads/source/dokumen-upload/TAHAP/" . $reg->tahap1 . "/VVA_" . $reg->ID_Personal . "_" . $reg->ID_Sub_Bidang . ".pdf")),
          "url_pdf_surat_permohonan_asosiasi" => curl_file_create(realpath("uploads/source/dokumen-upload/TAHAP/" . $reg->tahap1 . "/SPENG_" . $reg->ID_Personal . "_" . $reg->ID_Sub_Bidang . ".pdf")),
          "url_pdf_surat_permohonan"          => curl_file_create(realpath("uploads/source/dokumen-upload/TAHAP/" . $reg->tahap1 . "/SUB_" . $reg->ID_Personal . "_" . $reg->ID_Sub_Bidang . ".pdf")),
        //   "url_pdf_penilaian_mandiri_f19"     => curl_file_create(realpath("uploads/source/dokumen-upload/TAHAP/" . $reg->tahap1 . "/SA_" . $reg->ID_Personal . "_" . $reg->ID_Sub_Bidang . ".pdf")),
        ];

        // dd($reg);

        $curl = curl_init();
        $header[] = "X-Api-Key:" . env("LPJK_KEY");
        // $header[] = "Token:Rm1ydmpGbGQzcUxqR0J0Vis4cTlkZ1lKMUMzTDZDeEV5N2hZbVNSKzdGQ04xb1RyU3UwZDVIZmJ6OG81cTZ0Vg==";
        // $header[] = "Token:Rm1ydmpGbGQzcUxqR0J0Vis4cTlkZ1lKMUMzTDZDeEV5N2hZbVNSKzdGQk9JMm50Z1dKdW5SZlJLc1h0c0gyRA==";
        $header[] = "Token:Q0lLNkJYNHdqK3FxS0tZeEdUR2FYcTJRRWpiZ0N3ejhvcGRlRjd5blNrUlpGb0pBUi93MStNZkZzdTJMdTliOHZQV0JiTkp1UDZpOWxSdkVoVjM5YXc9PQ==";
        $header[] = "Content-Type:multipart/form-data";
        curl_setopt_array($curl, array(
            CURLOPT_URL => env("LPJK_ENDPOINT") . "Service/Klasifikasi/" . ($reg->sync ? "Ubah" : "Tambah") . "-TT",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $postData,
        CURLOPT_HTTPHEADER => $header,
        ));
        $response = curl_exec($curl);
        
        if($obj = json_decode($response)){
            if($obj->response) {
                if($this->createSyncLog($reg, $obj))
                    return redirect()->back()->with('success', $obj->message);
            }
            return redirect()->back()->with('error', $obj->message);
        }

        return redirect()->back()->with('error', "An error has occurred");
    }

    public function approve($id)
    {
        $reg = SikiRegtt::find($id);

        $postData = [
          "id_personal"           => $reg->ID_Personal,
          "id_sub_bidang"         => $reg->ID_Sub_Bidang,
          "id_kualifikasi"        => $reg->ID_Kualifikasi,
          "id_unit_sertifikasi"   => $reg->id_unit_sertifikasi,
          "tahun"                 => Carbon::parse($reg->Tgl_Registrasi)->format("Y"),
          "tgl_permohonan"        => Carbon::parse($reg->Tgl_Registrasi)->format("Y-m-d"), 
          "id_provinsi"           => $reg->ID_propinsi_reg,
          "id_permohonan"         => $reg->id_permohonan,
          "id_status"             => 99,
          "catatan"               => ""
        ];

        // dd($postData);

        $curl = curl_init();
        $header[] = "X-Api-Key:" . env("LPJK_KEY");
        // $header[] = "Token:Rm1ydmpGbGQzcUxqR0J0Vis4cTlkZ1lKMUMzTDZDeEV5N2hZbVNSKzdGQ04xb1RyU3UwZDVIZmJ6OG81cTZ0Vg==";
        // $header[] = "Token:Rm1ydmpGbGQzcUxqR0J0Vis4cTlkZ1lKMUMzTDZDeEV5N2hZbVNSKzdGQk9JMm50Z1dKdW5SZlJLc1h0c0gyRA==";
        $header[] = "Token:Q0lLNkJYNHdqK3FxS0tZeEdUR2FYcTJRRWpiZ0N3ejhvcGRlRjd5blNrUlpGb0pBUi93MStNZkZzdTJMdTliOHZQV0JiTkp1UDZpOWxSdkVoVjM5YXc9PQ==";
        $header[] = "Content-Type:multipart/form-data";
        curl_setopt_array($curl, array(
            CURLOPT_URL => env("LPJK_ENDPOINT") . "Service/History/TT",
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
            if($obj->response) {
                if($this->createApproveLog($reg))
                    return redirect()->back()->with('success', $obj->message);
            }
            return redirect()->back()->with('error', $obj->message);
        }

        return redirect()->back()->with('error', "An error has occurred");
    }
}
