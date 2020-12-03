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
        <li><a href="{{url("gol_harga_marketing")}}">Golongan Harga Marketing</a></li>
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
	            <h3 class="box-title">Create Golongan Harga Marketing</h3>
	          </div>
	          <!-- /.box-header -->
            @if(session()->get('error'))
            <div class="alert alert-error">
              {{ session()->get('error') }}  
            </div><br />
            @endif
	          <!-- form start -->
	          <form role="form" method="post" action="{{url("gol_harga_marketing")}}">
              @csrf
	            <div class="box-body row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Golongan Harga</label>
                    <select class="form-control" name="gol_harga">
                      <option value="">-- pilih golongan harga --</option>
                      @foreach ($gol_harga as $gh)
                      <option value="{{$gh->id}}">{{$gh->gol_harga}}</option>
                      @endforeach
                    </select>
                    <a href="{{url("gol_harga_marketing_head")}}">Tambah Golongan Harga</a>
                  </div>
                  <div class="form-group">
                    <label>Asosiasi</label>
                    <select class="form-control" name="asosiasi_id">
                      <option value="">-- pilih asosiasi --</option>
                      @foreach ($asosiasi as $as)
                        @if($as->id_asosiasi == "142" || $as->id_asosiasi == "148")
                          <option value="{{$as->id_asosiasi}}">{{$as->nama}}</option>
                        @endif
                      @endforeach
                    </select>
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
                    <label>Jenis Permohonan</label>
                    <select class="form-control"  name="id_permohonan">
                      <option value="">-- pilih kualifikasi --</option>
                      <option value="1">Baru</option>
                      <option value="2">Perpanjangan</option>
                      <option value="3">Perubahan</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Klasifikasi</label>
                    <select class="form-control" id="bidang" name="klasifikasi">
                      <option value="0">Semua klasifikasi</option>
                      @foreach ($bidang as $bid)
                      <option value="{{$bid->id_bidang}}">{{$bid->id_bidang}} - {{$bid->deskripsi}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Sub Klasifikasi</label>
                    <select class="form-control" id="subbidang" name="sub_klasifikasi">
                      <option value="0">Semua Sub klasifikasi</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Kualifikasi</label>
                    <select class="form-control"  name="kualifikasi">
                      <option value="">-- pilih kualifikasi --</option>
                      <option value="SKA">SKA</option>
                      <option value="SKT">SKT</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Sub Kualifikasi</label>
                    <select class="form-control" name="sub_kualifikasi">
                      <option value="">-- pilih sub kualifikasi --</option>
                      <option value="1">Utama / Kelas 1</option>
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

@push('script')
<script>
$(function(){
  $("#bidang").on("change", function(){
    $.getJSON("/api/v1/sub_bidang?bidang=" + $(this).val(), function(result){
      $('#subbidang').find('option').remove()
      $('#subbidang').append(new Option("Semua Sub klasifikasi", "0"))
      result.forEach(function(val, i) {
        $("#subbidang").append(new Option(val.id_sub_bidang + " - " + val.deskripsi, val.id_sub_bidang));
      })
    });
  })
});
</script>
@endpush
