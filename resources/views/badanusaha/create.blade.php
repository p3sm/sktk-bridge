@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Badan Usaha
        {{--  <small>it all starts here</small>  --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url("")}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url("master_badanusaha")}}">Badan Usaha</a></li>
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
	            <h3 class="box-title">Create Badan Usaha</h3>
	          </div>
	          <!-- /.box-header -->
            @if(session()->get('error'))
            <div class="alert alert-error">
              {{ session()->get('error') }}  
            </div><br />
            @endif
	          <!-- form start -->
	          <form role="form" method="post" action="{{url("master_badanusaha")}}">
              @csrf
	            <div class="box-body row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="nama">Nama Badan Usaha</label>
                    <input type="text" class="form-control" name="nama" id="nama" placeholder="Masukan nama" required>
                  </div>
                </div>
                {{-- <div class="col-md-6">
                  <div class="form-group">
                    <label>Asosiasi</label>
                    <select class="form-control" name="asosiasi">
                      @foreach ($asosiasi as $as)
                      <option value="{{$as->id_asosiasi}}">{{$as->nama}}</option>
                      @endforeach
                    </select>
                  </div>
                </div> --}}
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="nama_singkat">Nama Singkat</label>
                    <input type="text" class="form-control" name="nama_singkat" id="nama_singkat" placeholder="Masukan Nama Singkat" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Bentuk BU</label>
                    <select class="form-control" name="bentuk_usaha">
                      <option value="">-- pilih badan usaha --</option>
                      @foreach ($bentuk_usaha as $bu)
                      <option value="{{$bu->id}}">{{$bu->nama}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Status Kantor</label>
                    <select class="form-control" name="status_kantor" id="status_kantor">
                      <option value="">-- pilih status kantor --</option>
                      @foreach ($status_kantor as $sk)
                      <option value="{{$sk->id}}">{{$sk->nama}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                {{-- <div class="col-md-6">
                  <div class="form-group">
                    <label>Jenis Usaha</label>
                    <select class="form-control" name="jenis_usaha">
                      <option value="">-- pilih jenis usaha --</option>
                      @foreach ($jenis_usaha as $ju)
                      <option value="{{$ju->id}}">{{$ju->nama}}</option>
                      @endforeach
                    </select>
                  </div>
                </div> --}}
                <div class="col-md-6" style="display: none" id="kantor_pusat_block">
                  <div class="form-group">
                    <label>Kantor Pusat</label>
                    <select class="form-control" name="kantor_pusat">
                      <option value="">-- pilih kantor pusat --</option>
                      @foreach ($badan_usaha as $bu)
                        <option value="{{$bu->id}}">{{$bu->nama}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea type="text" class="form-control" name="alamat" id="alamat" placeholder="Masukan alamat" required></textarea>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Provinsi BU</label>
                    <select class="form-control" name="provinsi_id" id="provinsi">
                      <option value="">-- pilih provinsi --</option>
                      @foreach ($provinsi as $prov)
                      <option value="{{$prov->id_provinsi}}">{{$prov->id_provinsi}} - {{$prov->nama}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Kota</label>
                    <select class="form-control" name="kota_id" id="kota">
                      <option value="">-- pilih kota --</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="no_telp">No Telp</label>
                    <input type="text" class="form-control" name="no_telp" id="no_telp" placeholder="Masukan no telp" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" name="email" id="email" placeholder="Masukan email" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="instansi">Instansi Reff</label>
                    <input type="text" class="form-control" name="instansi" id="instansi" placeholder="Masukan Instansi Ref">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="web">Web</label>
                    <input type="text" class="form-control" name="web" id="web" placeholder="Masukan Website">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="pimpinan">Nama Pimpinan</label>
                    <input type="text" class="form-control" name="pimpinan" id="pimpinan" placeholder="Masukan Nama Pimpinan">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="pimpinan_jabatan">Jabatan Pimpinan</label>
                    <input type="text" class="form-control" name="pimpinan_jabatan" id="pimpinan_jabatan" placeholder="Masukan Jabatan Pimpinan">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="pimpinan_no">No Hp Pimpinan</label>
                    <input type="text" class="form-control" name="pimpinan_no" id="pimpinan_no" placeholder="Masukan No Pimpinan">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="pimpinan_email">Email Pimpinan</label>
                    <input type="text" class="form-control" name="pimpinan_email" id="pimpinan_email" placeholder="Masukan No Pimpinan">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="pic">Nama Kontak Person</label>
                    <input type="text" class="form-control" name="pic" id="pic" placeholder="Masukan nama kontak person">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="pic_jabatan">Jabatan Kontak Person</label>
                    <input type="text" class="form-control" name="pic_jabatan" id="pic_jabatan" placeholder="Masukan jabatan kontak person">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="pic_no">No Hp Kontak Person</label>
                    <input type="text" class="form-control" name="pic_no" id="pic_no" placeholder="Masukan no hp kontak person">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="pic_email">Email Kontak Person</label>
                    <input type="text" class="form-control" name="pic_email" id="pic_email" placeholder="Masukan email kontak person">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="npwp">No NPWP</label>
                    <input type="text" class="form-control" name="npwp" id="npwp" placeholder="Masukan no npwp">
                  </div>
                </div>
                <div class="col-md-6" style="margin-bottom:20px">
                  <div class="form-group">
                    <label for="npwp_file">File NPWP</label>
                    <input type="file" name="npwp_file" id="npwp_file">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="rek">No Rek Bank</label>
                    <input type="text" class="form-control" name="rek" id="rek" placeholder="Masukan no rekening">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="rek_name">Nama Rekening Bank</label>
                    <input type="text" class="form-control" name="rek_name" id="rek_name" placeholder="Masukan nama rekening">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Nama Bank</label>
                    <select class="form-control" name="bank">
                      <option value="">-- pilih nama bank --</option>
                      @foreach ($banks as $bank)
                      <option value="{{$bank->id}}">{{$bank->nama}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="npwp_file">Logo Badan Usaha</label>
                    <input type="file" name="npwp_file" id="npwp_file">
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan">
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
  $("#provinsi").on("change", function(){
    $.getJSON("/api/v1/kota?provinsi=" + $(this).val(), function(result){
      $('#kota').find('option').remove()
      $('#kota').append(new Option("-- pilih kota --", ""))
      result.forEach(function(val, i) {
        $("#kota").append(new Option(val.nama, val.id));
      })
    });
  })
  $("#status_kantor").on("change", function(){
    if($(this).val() === '2'){
      $("#kantor_pusat_block").hide()
    } else {
      $("#kantor_pusat_block").show()
    }
  })
});
</script>
@endpush
