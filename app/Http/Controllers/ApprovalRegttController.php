<?php

namespace App\Http\Controllers;

use App\PersonalRegTtSync;
use App\PersonalRegTtApprove;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApprovalRegttController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $from = $request->from ? Carbon::createFromFormat("d/m/Y", $request->from) : Carbon::now();
        $to = $request->to ? Carbon::createFromFormat("d/m/Y", $request->to) : Carbon::now();

        if($user->role->id == 1){
            $data['syncs'] = PersonalRegTtSync::whereDate("created_at", ">=", $from->format('Y-m-d'))
            ->whereDate("created_at", "<=", $to->format('Y-m-d'))
            ->orderByDesc("id")
            ->get();
        } else {
            $data['syncs'] = PersonalRegTtSync::where("synced_by", $user->id)
            ->whereDate("created_at", ">=", $from->format('Y-m-d'))
            ->whereDate("created_at", "<=", $to->format('Y-m-d'))
            ->orderByDesc("id")
            ->get();
        }

        $data['from'] = $from;
        $data['to'] = $to;

    	return view('approval/regtt/index')->with($data);
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
