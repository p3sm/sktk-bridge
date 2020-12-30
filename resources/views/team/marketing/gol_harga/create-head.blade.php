@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Golongan Harga Marketing
        {{--  <small>it all starts here</small>  --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url("")}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url("users")}}">Golongan Harga Marketing</a></li>
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
	            <h3 class="box-title">Create Nama Golongan Harga Marketing</h3>
	          </div>
	          <!-- /.box-header -->
            @if(session()->get('error'))
            <div class="alert alert-error">
              {{ session()->get('error') }}  
            </div><br />
            @endif
	          <!-- form start -->
	          <form role="form" method="post" action="{{url("gol_harga_marketing_head")}}">
              @csrf
	            <div class="box-body row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="gol_harga">Gol Harga</label>
                    <input type="text" class="form-control" name="gol_harga" id="gol_harga" placeholder="Masukan Nama Golongan Harga" required>
                  </div>
                  <div class="form-group">
                    <label>Jenis Usaha</label>
                    <select class="form-control" name="jenis_usaha">
                      <option value="">-- pilih jenis usaha --</option>
                      @foreach ($jenis_usaha as $ju)
                      <option value="{{$ju->id}}">{{$ju->nama}}</option>
                      @endforeach
                    </select>
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

@push('script')
<script>
$(function(){
  $("#bidang").on("change", function(){
    $.getJSON("/api/v1/sub_bidang?bidang=" + $(this).val(), function(result){
      $('#subbidang').find('option').remove()
      $('#subbidang').append(new Option("-- pilih sub klasifikasi --", ""))
      result.forEach(function(val, i) {
        $("#subbidang").append(new Option(val.id_sub_bidang + " - " + val.deskripsi, val.id_sub_bidang));
      })
    });
  })
});
</script>
@endpush
