@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Tim Marketing
        {{--  <small>it all starts here</small>  --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url("")}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url("marketing")}}">Tim Marketing</a></li>
        <li class="active"><a href="#">Edit</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	<div class="row">

	      <div class="col-md-12">

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

	        <!-- general form elements -->
	        <div class="box box-primary">
	          <div class="box-header with-border">
	            <h3 class="box-title">Edit Tim Marketing</h3>
	          </div>
	          <!-- /.box-header -->

	          <!-- form start -->
	          <form role="form" method="post" action="{{route('marketing.update', $data->id)}}">
	          	@method('PATCH') 
              @csrf
	            <div class="box-body row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" name="nama" id="nama" placeholder="Masukan nama" value="{{$data->nama}}" required>
                  </div>
                  <div class="form-group">
                    <label>Badan Usaha</label>
                    <select class="form-control" name="badan_usaha">
                      @foreach ($badan_usaha as $bu)
                      <option value="{{$bu->id}}" {{$data->badan_usaha_id == $bu->id ? "selected" : ""}}>{{$bu->nama}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Jenis Usaha</label>
                    <select class="form-control" name="jenis_usaha">
                      <option value="">-- pilih jenis usaha --</option>
                      @foreach ($jenis_usaha as $ju)
                      <option value="{{$ju->id}}" {{$data->jenis_usaha_id == $ju->id ? "selected" : ""}}>{{$ju->nama}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Level</label>
                    <select class="form-control" name="level">
                      <option value="">-- pilih level --</option>
                      @foreach ($tim_produksi_level as $lv)
                      <option value="{{$lv->id}}" {{$data->level_id == $lv->id ? "selected" : ""}}>{{$lv->nama}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Tipe Kualifikasi</label>
                    <select class="form-control" name="kualifikasi_type">
                      <option value="">-- pilih tipe kualifikasi --</option>
                      <option value="UTAMA" {{$data->kualifikasi_type == 'UTAMA' ? "selected" : ""}}>UTAMA</option>
                      <option value="NON_UTAMA" {{$data->kualifikasi_type == 'NON_UTAMA' ? "selected" : ""}}>NON UTAMA</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="nama_singkat">Nama Singkat</label>
                    <input type="text" class="form-control" name="nama_singkat" id="nama_singkat" placeholder="Masukan Nama Singkat" value="{{$data->singkatan}}" required>
                  </div>
                  <div class="form-group">
                    <label>Bentuk Usaha</label>
                    <select class="form-control" name="bentuk_usaha">
                      <option value="">-- pilih badan usaha --</option>
                      @foreach ($bentuk_usaha as $bu)
                      <option value="{{$bu->id}}" {{$data->bentuk_usaha_id == $bu->id ? "selected" : ""}}>{{$bu->nama}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Tim Produksi</label>
                    <select class="form-control" name="tim_produksi_id">
                      <option value="">-- pilih tim produksi --</option>
                      @foreach ($tim_produksi as $team)
                      <option value="{{$team->id}}" {{$data->tim_produksi_id == $team->id ? "selected" : ""}}>{{$team->nama}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Tim Marketing Level Diatasnya</label>
                    <select class="form-control" name="parent_id">
                      <option value="">-- pilih tim marketing --</option>
                      @foreach ($tim_marketing as $team)
                      <option value="{{$team->id}}" {{$data->parent_id == $team->id ? "selected" : ""}}>{{$team->nama}}</option>
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
                    <label>Provinsi</label>
                    <select class="form-control" name="provinsi_id" id="provinsi">
                      <option value="">-- pilih provinsi --</option>
                      @foreach ($provinsi as $prov)
                      <option value="{{$prov->id_provinsi}}" {{$data->provinsi_id == $prov->id_provinsi ? "selected" : ""}}>{{$prov->id_provinsi}} - {{$prov->nama}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="no_telp">No Telp</label>
                    <input type="text" class="form-control" name="no_telp" id="no_telp" placeholder="Masukan no telp" value="{{$data->no_tlp}}" required>
                  </div>
                  <div class="form-group">
                    <label for="instansi">Instansi Reff</label>
                    <input type="text" class="form-control" name="instansi" id="instansi" placeholder="Masukan Instansi Ref" value="{{$data->instansi}}">
                  </div>
                  <div class="form-group">
                    <label for="pimpinan">Nama Pimpinan</label>
                    <input type="text" class="form-control" name="pimpinan" id="pimpinan" placeholder="Masukan Nama Pimpinan" value="{{$data->pimpinan_nama}}">
                  </div>
                  <div class="form-group">
                    <label for="pimpinan_hp">No Hp Pimpinan</label>
                    <input type="text" class="form-control" name="pimpinan_hp" id="pimpinan_hp" placeholder="Masukan No Pimpinan" value="{{$data->pimpinan_hp}}">
                  </div>
                  <div class="form-group">
                    <label for="pic">Nama Kontak Person</label>
                    <input type="text" class="form-control" name="pic" id="pic" placeholder="Masukan nama kontak person" value="{{$data->kontak_p}}">
                  </div>
                  <div class="form-group">
                    <label for="pic_no">No Hp Kontak Person</label>
                    <input type="text" class="form-control" name="pic_no" id="pic_no" placeholder="Masukan no hp kontak person" value="{{$data->no_kontak_p}}">
                  </div>
                  <div class="form-group">
                    <label for="npwp">No NPWP</label>
                    <input type="text" class="form-control" name="npwp" id="npwp" placeholder="Masukan no npwp" value="{{$data->npwp}}">
                  </div>
                  <div class="form-group">
                    <label for="rek">No Rek Bank</label>
                    <input type="text" class="form-control" name="rek" id="rek" placeholder="Masukan no rekening" value="{{$data->rekening_no}}">
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
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" name="email" id="email" placeholder="Masukan email" value="{{$data->email}}" required>
                  </div>
                  <div class="form-group">
                    <label for="web">Web</label>
                    <input type="text" class="form-control" name="web" id="web" placeholder="Masukan Website" value="{{$data->web}}">
                  </div>
                  <div class="form-group">
                    <label for="pimpinan_jabatan">Jabatan Pimpinan</label>
                    <input type="text" class="form-control" name="pimpinan_jabatan" id="pimpinan_jabatan" placeholder="Masukan Jabatan Pimpinan" value="{{$data->pimpinan_jabatan}}">
                  </div>
                  <div class="form-group">
                    <label for="pimpinan_email">Email Pimpinan</label>
                    <input type="text" class="form-control" name="pimpinan_email" id="pimpinan_email" placeholder="Masukan No Pimpinan" value="{{$data->pimpinan_email}}">
                  </div>
                  <div class="form-group">
                    <label for="pic_jabatan">Jabatan Kontak Person</label>
                    <input type="text" class="form-control" name="pic_jabatan" id="pic_jabatan" placeholder="Masukan jabatan kontak person" value="{{$data->jab_kontak_p}}">
                  </div>
                  <div class="form-group">
                    <label for="pic_email">Email Kontak Person</label>
                    <input type="text" class="form-control" name="pic_email" id="pic_email" placeholder="Masukan email kontak person" value="{{$data->email_kontak_p}}">
                  </div>
                  <div class="form-group">
                    <label for="npwp_file">File NPWP</label>
                    <input type="file" name="npwp_file" id="npwp_file">
                  </div>
                  <div class="form-group">
                    <label for="rek_name">Nama Rekening Bank</label>
                    <input type="text" class="form-control" name="rek_name" id="rek_name" placeholder="Masukan nama rekening" value="{{$data->rekening_nama}}">
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Nama Bank</label>
                    <select class="form-control" name="bank">
                      <option value="">-- pilih nama bank --</option>
                      @foreach ($banks as $bank)
                      <option value="{{$bank->id}}" {{$data->rekening_bank == $bank->id ? "selected" : ""}}>{{$bank->nama}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan" value="{{$data->keterangan}}">
                  </div>
                  <div class="form-group">
                    <label>Golongan Harga Marketing</label>
                    <select class="form-control" name="gol_harga">
                      <option value="">-- pilih gol harga tim marketing --</option>
                      @foreach ($tim_marketing_gol_harga as $harga)
                      <option value="{{$harga->id}}" {{$data->gol_harga_id == $harga->id ? "selected" : ""}}>{{$harga->gol_harga}}</option>
                      @endforeach
                    </select>
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
    findKota($(this).val());
  })

  function findKota(provId){
    $.getJSON("/api/v1/kota?provinsi=" + provId, function(result){
      $('#kota').find('option').remove()
      $('#kota').append(new Option("-- pilih kota --", ""))
      result.forEach(function(val, i) {
        $("#kota").append(new Option(val.nama, val.id));
      })
    });
  }
});
</script>
@endpush
