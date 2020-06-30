<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use App\ApprovalTransaction;
use App\SikiAsosiasi;
use App\Provinsi;
use App\TeamProvinsi;
use App\Team;
use App\TeamKontribusiTa;
use App\TeamKontribusiTt;
use App\PersonalRegTa;
use App\PersonalRegTt;
use App\PersonalRegTaSync;
use App\PersonalRegTaApprove;
use App\Pengajuan99;

class LaporanController extends Controller
{
    private $message = "";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $from = $request->from ? Carbon::createFromFormat("d/m/Y", $request->from) : Carbon::now();
        $to = $request->to ? Carbon::createFromFormat("d/m/Y", $request->to) : Carbon::now();
        $provinsi = $request->prv;
        $tim = $request->tim;
        $asosiasi = $request->aso;
        $sertifikat = $request->srtf;
        
        $model = ApprovalTransaction::whereDate("tgl_registrasi", ">=", $from->format('Y-m-d'))
        ->whereDate("tgl_registrasi", "<=", $to->format('Y-m-d'));

        if($asosiasi) $model = $model->where("id_asosiasi_profesi", $asosiasi);
        if($provinsi) $model = $model->where("id_propinsi_reg", $provinsi);
        // if($tim) $model = $model->where("team_id", $tim);

        $pengajuan = $model->orderByDesc("created_at")->get();

        $data['results'] = $pengajuan;
        $data['from'] = $from;
        $data['to'] = $to;
        $data['asosiasi'] = $asosiasi;
        $data['provinsi'] = $provinsi;
        $data['tim'] = $tim;
        $data['sertifikat'] = $sertifikat;
        $data['tim_data'] = Team::all();
        $data['provinsi_data'] = Provinsi::all();

    	return view('laporan/index')->with($data);
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
    }
}
