<?php

namespace App\Http\Controllers;

use App\SikiAsosiasi;
use App\PersonalRegTaSync;
use App\PersonalRegTaApprove;
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
        $asosiasiId = 142;
        $asosiasi = SikiAsosiasi::find($asosiasiId);

        $user = Auth::user();
        
        $from = $request->from ? Carbon::createFromFormat("d/m/Y", $request->from) : Carbon::now();
        $to = $request->to ? Carbon::createFromFormat("d/m/Y", $request->to) : Carbon::now();

        // $postData = [
        //     "status_99" => 0,
        //   ];

        // $curl = curl_init();
        // $header[] = "X-Api-Key:" . $asosiasi->apikey->lpjk_key;
        // $header[] = "Token:" . $asosiasi->apikey->token;
        // $header[] = "Content-Type:multipart/form-data";
        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => env("LPJK_ENDPOINT") . "Service/Klasifikasi/Get-TA?status_99=0",
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_CUSTOMREQUEST => "POST",
        //     CURLOPT_POSTFIELDS => $postData,
        //     CURLOPT_HTTPHEADER => $header,
        // ));
        // $response = curl_exec($curl);

        // $data['response'] = $response->response;
        // $data['results'] = $response->result;

        // dd($response);

        // echo $response;
        // exit;

        if($user->role->id == 1){
            $data['syncs'] = PersonalRegTaSync::whereDate("created_at", ">=", $from->format('Y-m-d'))
            ->whereDate("created_at", "<=", $to->format('Y-m-d'))
            ->orderByDesc("id")
            ->get();
        } else {
            $data['syncs'] = PersonalRegTaSync::where("synced_by", $user->id)
            ->whereDate("created_at", ">=", $from->format('Y-m-d'))
            ->whereDate("created_at", "<=", $to->format('Y-m-d'))
            ->orderByDesc("id")
            ->get();
        }

        $data['from'] = $from;
        $data['to'] = $to;

    	return view('approval/regta/index')->with($data);
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
}
