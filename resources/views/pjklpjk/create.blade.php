@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        PJS LPJK
        {{--  <small>it all starts here</small>  --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url("")}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url("users")}}">PJS LPJK</a></li>
        <li class="active"><a href="#">Create</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	<div class="row">

	      <div class="col-md-12">

	        <!-- general form elements -->
	        <div class="box box-primary">
	          <div class="box-header with-border">
	            <h3 class="box-title">Create PJS LPJK</h3>
	          </div>
	          <!-- /.box-header -->
            @if(session()->get('error'))
            <div class="alert alert-error">
              {{ session()->get('error') }}  
            </div><br />
            @endif
	          <!-- form start -->
	          <form role="form" method="post" action="{{url("master_pjklpjk")}}">
              @csrf
	            <div class="box-body row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Badan Usaha</label>
                    <select class="form-control" name="badan_usaha">
                      <option value="">-- pilih badan usaha --</option>
                      @foreach ($badan_usaha as $bu)
                      <option value="{{$bu->id}}">{{$bu->nama}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="tgl_sk">Tgl SK</label>
                    <input type="text" class="form-control datepicker" name="tgl_sk" id="tgl_sk" placeholder="Tanggal SK" required>
                  </div>
                  <div class="form-group">
                    <label for="npwp_file">File SK</label>
                    <input type="file" name="pdf_sk" id="pdf_sk">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="no_sk">No SK</label>
                    <input type="text" class="form-control" name="no_sk" id="no_sk" placeholder="Masukan No SK" required>
                  </div>
                  <div class="form-group">
                    <label for="tgl_sk_akhir">Tgl SK AKhir</label>
                    <input type="text" class="form-control datepicker" name="tgl_sk_akhir" id="tgl_sk_akhir" placeholder="Tanggal SK Akhir" required>
                  </div>
                  <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <textarea type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan" required></textarea>
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
  $('.datepicker').datepicker({format: 'dd/mm/yyyy'});

  $("#provinsi").on("change", function(){
    $.getJSON("/api/v1/kota?provinsi=" + $(this).val(), function(result){
      $('#kota').find('option').remove()
      $('#kota').append(new Option("-- pilih kota --", ""))
      result.forEach(function(val, i) {
        $("#kota").append(new Option(val.nama, val.id));
      })
    });
  })
});
</script>
@endpush
