<?php

namespace App\Http\Controllers;

use App\SikiPersonalPendidikan;
use App\PersonalPendidikanSync;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Storage;

class SikiPendidikanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    public function createSyncLog($pendidikan, $sync)
    {
        if($pendidikan->sync){
            $data = PersonalPendidikanSync::find($pendidikan->sync->id);
            $data->updated_at = Carbon::now();
        } else {
            $data = new PersonalPendidikanSync();
        }

        $data->personal_pendidikan_id = $pendidikan->ID_Personal_Pendidikan;
        $data->sync_id = $sync->ID_Personal_Pendidikan;
        if($data->save())
            return true;
        else
            return false;
    }

    public function sync($id)
    {
        $pendidikan = SikiPersonalPendidikan::find($id);

        $postData = [
            "id_personal_pendidikan"                     => $pendidikan->sync ? $pendidikan->sync->sync_id : 0,
            "id_personal"                                => $pendidikan->ID_Personal,
            "nama_sekolah"                               => $pendidikan->Nama_Sekolah,
            "alamat_sekolah"                             => $pendidikan->Alamat1,
            "id_propinsi_sekolah"                        => "05",
            "id_kabupaten_sekolah"                       => "1505",
            "id_negara_sekolah"                          => $pendidikan->ID_Countries,
            "tahun"                                      => $pendidikan->Tahun,
            "jenjang"                                    => $pendidikan->Jenjang,
            "jurusan"                                    => $pendidikan->Jurusan,
            "no_ijazah"                                  => $pendidikan->No_Ijazah,
            "url_pdf_ijazah"                             => asset("uploads/source/dokumen-upload/ijazah-" . $pendidikan->ID_Personal . ".pdf"),
            "url_pdf_data_pendidikan"                    => asset("uploads/source/dokumen-upload/data-pendidikan-" . $pendidikan->ID_Personal . ".pdf"),
            "url_pdf_data_surat_keterangan_dari_sekolah" => asset("uploads/source/dokumen-upload/sk_sekolah-" . $pendidikan->ID_Personal . ".pdf"),
        ];

        $curl = curl_init();
        $header[] = "X-Api-Key:Dev-Rest-API-2019";
        $header[] = "content-type:application/json";
        curl_setopt_array($curl, array(
        CURLOPT_URL => "http://202.152.17.10/rest-api/Service/Pendidikan/" . ($pendidikan->sync ? "Ubah" : "Tambah"),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($postData),
        CURLOPT_HTTPHEADER => $header,
        ));
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $httpstatus = Response::$statusTexts[$httpcode];
        
        if($httpcode == Response::HTTP_OK){
            if($obj = json_decode($response)){
                if($obj->response) {
                    if($this->createSyncLog($pendidikan, $obj))
                        return response()->json(['code' => $httpcode, 'status' => $httpstatus, 'data' => $obj]);
                }
                return response()->json(['code' => $httpcode, 'status' => $httpstatus, 'data' => $obj]);
            }
        }

        return response()->json(['code' => $httpcode, 'status' => $httpstatus, 'data' => '']);
    }
}
