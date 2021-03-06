@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Golongan Harga Produksi
        {{--  <small>it all starts here</small>  --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url("")}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url("users")}}">Golongan Harga Produksi</a></li>
        <li class="active"><a href="#">Create</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	<div class="row">

	      <div class="col-md-6  col-md-offset-3">

	        <!-- general form elements -->
	        <div class="box box-primary">
	          <div class="box-header with-border">
	            <h3 class="box-title">Create Golongan Harga Produksi</h3>
	          </div>
	          <!-- /.box-header -->
            @if(session()->get('error'))
            <div class="alert alert-error">
              {{ session()->get('error') }}  
            </div><br />
            @endif
	          <!-- form start -->
	          <form role="form" method="post" action="{{url("gol_harga_produksi")}}">
              @csrf
	            <div class="box-body row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="gol_harga">Golongan Harga</label>
                    <input type="text" class="form-control" name="gol_harga" id="gol_harga" placeholder="Masukan Golongan Harga" required>
                  </div>
                  <div class="form-group">
                    <label>Jenis Usaha</label>
                    <select class="form-control" name="jenis_usaha">
                      <option value="">-- pilih jenis usaha --</option>
                      @foreach ($teams as $team)
                      <option value="{{$team->id}}">{{$team->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Klasifikasi</label>
                    <select class="form-control" name="klasifikasi">
                      <option value="">-- pilih jenis usaha --</option>
                      @foreach ($teams as $team)
                      <option value="{{$team->id}}">{{$team->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Sub Klasifikasi</label>
                    <select class="form-control" name="sub_klasifikasi">
                      <option value="">-- pilih jenis usaha --</option>
                      @foreach ($teams as $team)
                      <option value="{{$team->id}}">{{$team->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Kualifikasi</label>
                    <select class="form-control" name="kualifikasi">
                      <option value="">-- pilih kualifikasi --</option>
                      <option value="SKA">SKA</option>
                      <option value="SKT">SKT</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Sub Kualifikasi</label>
                    <select class="form-control" name="sub_kualifikasi">
                      <option value="">-- pilih sub kualifikasi --</option>
                      <option value="1">Ahli / Kelas 1</option>
                      <option value="2">Madya / Kelas 2</option>
                      <option value="3">Muda / Kelas 3</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="harga">Harga</label>
                    <input type="text" class="form-control" name="harga" id="harga" placeholder="Masukan Harga" required>
                  </div>
                  <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Masukan Keterangan">
                  </div>
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
