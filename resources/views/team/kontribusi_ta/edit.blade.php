@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Kontribusi Management
        {{--  <small>it all starts here</small>  --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url("")}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url("team_kontribusi_ta")}}">Kontribusi TA</a></li>
        <li class="active"><a href="#">Edit</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	<div class="row">

	      <div class="col-md-6  col-md-offset-3">

	        <!-- general form elements -->
	        <div class="box box-primary">
	          <div class="box-header with-border">
	            <h3 class="box-title">Edit Kontribusi</h3>
	          </div>
	          <!-- /.box-header -->
	          <!-- form start -->
	          <form role="form" method="post" action="{{route('team_kontribusi_ta.update', $kontribusi->id)}}">
	          	@method('PATCH') 
              @csrf
	            <div class="box-body">
	              <div class="form-group">
	                <label for="team">Team</label>
	                <input type="text" class="form-control" disabled name="team" id="team" value="{{$kontribusi->team->name}}">
	              </div>
	              <div class="form-group">
	                <label for="asosiasi">Asosiasi</label>
	                <input type="text" class="form-control" disabled name="asosiasi" id="asosiasi" value="{{$kontribusi->id_asosiasi_profesi}}">
	              </div>
	              <div class="form-group">
	                <label for="provinsi">Provinsi</label>
	                <input type="text" class="form-control" disabled name="provinsi" id="provinsi" value="{{$kontribusi->provinsi->Nama}}">
	              </div>
	              <div class="form-group">
	                <label for="kualifikasi">Kualifikasi</label>
	                <input type="text" class="form-control" disabled name="kualifikasi" id="kualifikasi" value="{{$kontribusi->id_kualifikasi}}">
	              </div>
	              <div class="form-group">
	                <label for="kontribusi">Kontribusi</label>
	                <input type="number" min="0" step="1" class="form-control" name="kontribusi" id="kontribusi" value="{{$kontribusi->kontribusi}}">
	              </div>
	            </div>
	            <!-- /.box-body -->

	            <div class="box-footer">
	              <button type="submit" name="submit" class="btn btn-primary">Submit</button>
	            </div>
	          </form>
	        </div>
	        <!-- /.box -->

	      </div>

	    </div>
    </section>
    <!-- /.content -->
@endsection
