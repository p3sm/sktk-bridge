<?php

namespace App\Http\Controllers;

use App\SikiPersonalProyek;
use App\PersonalProyekSync;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Storage;

class SikiProyekController extends Controller
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

    public function createSyncLog($proyek, $sync)
    {
        if($proyek->sync){
            $data = PersonalProyekSync::find($proyek->sync->id);
            $data->updated_at = Carbon::now();
        } else {
            $data = new PersonalProyekSync();
        }

        $data->personal_proyek_id = $proyek->id_personal_proyek;
        $data->sync_id = $sync->id_personal_proyek;
        $data->synced_by = Auth::id();
        
        if($data->save())
            return true;
        else
            return false;
    }

    public function sync($id)
    {
        $date = Carbon::now();
        $proyek = SikiPersonalProyek::find($id);

        if(!file_exists("uploads/source/dokumen-upload/BIODATA/" . $date->format("Y/m/d/") . $proyek->id_personal . "/IJZ.pdf")){
            return redirect()->back()->with('error', 'File Ijazah tidak tersedia');
        }

        $postData = [
            "id_personal_proyek"                    => $proyek->sync ? $proyek->sync->sync_id : 0,
            "id_personal"                           => $proyek->id_personal,
            "nama_proyek"                           => $proyek->Proyek,
            "lokasi"                                => $proyek->Lokasi,
            "tgl_mulai"                             => $proyek->Tgl_Mulai,
            "tgl_selesai"                           => $proyek->Tgl_Selesai,
            "jabatan"                               => $proyek->Jabatan,
            "nilai_proyek"                          => $proyek->Nilai,
            "url_pdf_persyaratan_pengalaman_proyek" => curl_file_create(realpath("uploads/source/dokumen-upload/BIODATA/" . $date->format("Y/m/d/") . $proyek->id_personal . "/IJZ.pdf")),
        ];

        $curl = curl_init();
        $header[] = "X-Api-Key:" . env("LPJK_KEY");
        // $header[] = "Token:Rm1ydmpGbGQzcUxqR0J0Vis4cTlkZ1lKMUMzTDZDeEV5N2hZbVNSKzdGQ04xb1RyU3UwZDVIZmJ6OG81cTZ0Vg==";
        // $header[] = "Token:Rm1ydmpGbGQzcUxqR0J0Vis4cTlkZ1lKMUMzTDZDeEV5N2hZbVNSKzdGQk9JMm50Z1dKdW5SZlJLc1h0c0gyRA==";
        $header[] = "Token:Q0lLNkJYNHdqK3FxS0tZeEdUR2FYcTJRRWpiZ0N3ejhvcGRlRjd5blNrUlpGb0pBUi93MStNZkZzdTJMdTliOHZQV0JiTkp1UDZpOWxSdkVoVjM5YXc9PQ==";
        $header[] = "Content-Type:multipart/form-data";
        curl_setopt_array($curl, array(
        CURLOPT_URL => env("LPJK_ENDPOINT") . "Service/Proyek/" . ($proyek->sync ? "Ubah" : "Tambah"),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $postData,
        CURLOPT_HTTPHEADER => $header,
        ));
        $response = curl_exec($curl);

        // echo $response;
        // exit;
        
        if($obj = json_decode($response)){
            if($obj->response) {
                if($this->createSyncLog($proyek, $obj))
                    return redirect()->back()->with('success', $obj->message);
            }
            return redirect()->back()->with('error', $obj->message);
        }

        return redirect()->back()->with('error', "An error has occurred");
    }
}
