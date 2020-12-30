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
        <li class="active"><a href="#">Edit</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	<div class="row">

	      <div class="col-md-12">
	        <!-- general form elements -->
	        <div class="box box-primary">

            @if(session()->get('success'))
            <div class="alert alert-success alert-block" style="margin-top: 10px;">
              <button type="button" class="close" data-dismiss="alert">×</button>   
                    <strong>{{ session()->get('success') }}</strong>
            </div>
            @endif
  
            @if(session()->get('error'))
            <div class="alert alert-danger alert-block" style="margin-top: 10px;">
              <button type="button" class="close" data-dismiss="alert">×</button>   
                    <strong>{{ session()->get('error') }}</strong>
            </div>
            @endif

	          <div class="box-header with-border">
	            <h3 class="box-title">Edit Badan Usaha</h3>
	          </div>
            <!-- /.box-header -->
            
	          <!-- form start -->
	          <form role="form" method="post" action="{{route('master_badanusaha.update', $data->id)}}">
	          	@method('PATCH') 
              @csrf
	            <div class="box-body row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="nama">Nama Badan Usaha</label>
                    <input type="text" class="form-control" name="nama" id="nama" placeholder="Masukan nama" value="{{$data->nama}}" required>
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
                    <input type="text" class="form-control" name="nama_singkat" id="nama_singkat" placeholder="Masukan Nama Singkat" value="{{$data->singkatan}}" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Bentuk BU</label>
                    <select class="form-control" name="bentuk_usaha">
                      <option value="">-- pilih badan usaha --</option>
                      @foreach ($bentuk_usaha as $bu)
                      <option value="{{$bu->id}}" {{$data->bentuk_usaha_id == $bu->id ? "selected" : ""}}>{{$bu->nama}}</option>
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
                      <option value="{{$sk->id}}" {{$data->status_kantor_proyek == $sk->id ? "selected" : ""}}>{{$sk->nama}}</option>
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
                <div class="col-md-6" style="display: {{$data->status_kantor_proyek == 2 ? 'none' : 'block'}}" id="kantor_pusat_block">
                  <div class="form-group">
                    <label>Kantor Pusat</label>
                    <select class="form-control" name="kantor_pusat">
                      <option value="">-- pilih status kantor --</option>
                      @foreach ($badan_usaha as $bu)
                        <option value="{{$bu->id}}">{{$bu->nama}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea type="text" class="form-control" name="alamat" id="alamat" placeholder="Masukan alamat" required>{{$data->alamat}}</textarea>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Provinsi BU</label>
                    <select class="form-control" name="provinsi_id" id="provinsi">
                      <option value="">-- pilih provinsi --</option>
                      @foreach ($provinsi as $prov)
                      <option value="{{$prov->id_provinsi}}" {{$data->provinsi_id == $prov->id_provinsi ? "selected" : ""}}>{{$prov->id_provinsi}} - {{$prov->nama}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Kota</label>
                    <select class="form-control" name="kota_id" id="kota">
                      <option value="">-- pilih kota --</option>
                      @foreach ($kota as $kot)
                      <option value="{{$kot->id}}" {{$data->kota_id == $kot->id ? "selected" : ""}}>{{$kot->nama}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="no_telp">No Telp</label>
                    <input type="text" class="form-control" name="no_telp" id="no_telp" placeholder="Masukan no telp" value="{{$data->no_tlp}}" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" name="email" id="email" placeholder="Masukan email" value="{{$data->email}}" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="instansi">Instansi Reff</label>
                    <input type="text" class="form-control" name="instansi" id="instansi" value="{{$data->instansi}}" placeholder="Masukan Instansi Ref">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="web">Web</label>
                    <input type="text" class="form-control" name="web" id="web" value="{{$data->web}}" placeholder="Masukan Website">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="pimpinan">Nama Pimpinan</label>
                    <input type="text" class="form-control" name="pimpinan" id="pimpinan" value="{{$data->pimpinan_nama}}" placeholder="Masukan Nama Pimpinan">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="pimpinan_jabatan">Jabatan Pimpinan</label>
                    <input type="text" class="form-control" name="pimpinan_jabatan" id="pimpinan_jabatan" value="{{$data->pimpinan_jabatan}}" placeholder="Masukan Jabatan Pimpinan">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="pimpinan_no">No Hp Pimpinan</label>
                    <input type="text" class="form-control" name="pimpinan_no" id="pimpinan_no" value="{{$data->pimpinan_hp}}" placeholder="Masukan No Pimpinan">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="pimpinan_email">Email Pimpinan</label>
                    <input type="text" class="form-control" name="pimpinan_email" id="pimpinan_email" value="{{$data->pimpinan_email}}" placeholder="Masukan No Pimpinan">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="pic">Nama Kontak Person</label>
                    <input type="text" class="form-control" name="pic" id="pic" value="{{$data->kontak_p}}" placeholder="Masukan nama kontak person">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="pic_jabatan">Jabatan Kontak Person</label>
                    <input type="text" class="form-control" name="pic_jabatan" id="pic_jabatan" value="{{$data->jab_kontak_p}}" placeholder="Masukan jabatan kontak person">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="pic_no">No Hp Kontak Person</label>
                    <input type="text" class="form-control" name="pic_no" id="pic_no" value="{{$data->no_kontak_p}}" placeholder="Masukan no hp kontak person">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="pic_email">Email Kontak Person</label>
                    <input type="text" class="form-control" name="pic_email" id="pic_email" value="{{$data->email_kontak_p}}" placeholder="Masukan email kontak person">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="npwp">No NPWP</label>
                    <input type="text" class="form-control" name="npwp" id="npwp" value="{{$data->npwp}}" placeholder="Masukan no npwp">
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
                    <input type="text" class="form-control" name="rek" id="rek" value="{{$data->rekening_no}}" placeholder="Masukan no rekening">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="rek_name">Nama Rekening Bank</label>
                    <input type="text" class="form-control" name="rek_name" id="rek_name" value="{{$data->rekening_nama}}" placeholder="Masukan nama rekening">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Nama Bank</label>
                    <select class="form-control" name="bank">
                      <option value="">-- pilih nama bank --</option>
                      @foreach ($banks as $bank)
                      <option value="{{$bank->id}}" {{$data->rekening_bank == $bank->id ? "selected" : ""}}>{{$bank->nama}}</option>
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
                    <input type="text" class="form-control" name="keterangan" id="keterangan" value="{{$data->keterangan}}" placeholder="Keterangan">
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
