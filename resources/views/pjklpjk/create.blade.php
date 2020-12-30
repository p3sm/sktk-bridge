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
        <li><a href="{{url("master_pjklpjk")}}">PJS LPJK</a></li>
        <li class="active"><a href="#">Create</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	<div class="row">

	      <div class="col-md-12">

        <!-- form start -->
        <form role="form" method="post" action="{{url("master_pjklpjk")}}">
          @csrf
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
	            <div class="box-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Nama PJS LPJK</label>
                      <select class="form-control select2" id="badan_usaha" name="badan_usaha">
                        <option value="">-- nama pjs lpjk --</option>
                        @foreach ($badan_usaha as $bu)
                        <option value="{{$bu->id}}">{{$bu->nama}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="alamat">Alamat</label>
                      <textarea type="text" disabled class="form-control" rows="1" name="alamat" id="alamat" placeholder="Masukan alamat" required></textarea>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="provinsi">Provinsi</label>
                      <input type="text" disabled class="form-control" name="provinsi" id="provinsi" placeholder="Masukan Provinsi">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="kota">Kota</label>
                      <input type="text" disabled class="form-control" name="kota_id" id="kota" placeholder="Masukan Kota">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="no_telp">No Telp</label>
                      <input type="text" disabled class="form-control" name="no_telp" id="no_telp" placeholder="Masukan no telp" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="email">Email</label>
                      <input type="text" disabled class="form-control" name="email" id="email" placeholder="Masukan email" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="instansi">Instansi Reff</label>
                      <input type="text" disabled class="form-control" name="instansi" id="instansi" placeholder="Masukan Instansi Ref">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="web">Web</label>
                      <input type="text" disabled class="form-control" name="web" id="web" placeholder="Masukan Website">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="pimpinan_nama">Nama Pimpinan</label>
                      <input type="text" class="form-control" name="pimpinan_nama" id="pimpinan_nama" placeholder="Masukan Nama Pimpinan">
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
                      <label for="pimpinan_hp">No Hp Pimpinan</label>
                      <input type="text" class="form-control" name="pimpinan_hp" id="pimpinan_hp" placeholder="Masukan No Pimpinan">
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
                      <label for="kontak_p">Nama Kontak Person</label>
                      <input type="text" class="form-control" name="kontak_p" id="kontak_p" placeholder="Masukan nama kontak person">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="jab_kontak_p">Jabatan Kontak Person</label>
                      <input type="text" class="form-control" name="jab_kontak_p" id="jab_kontak_p" placeholder="Masukan jabatan kontak person">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="no_kontak_p">No Hp Kontak Person</label>
                      <input type="text" class="form-control" name="no_kontak_p" id="no_kontak_p" placeholder="Masukan no hp kontak person">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="email_kontak_p">Email Kontak Person</label>
                      <input type="text" class="form-control" name="email_kontak_p" id="email_kontak_p" placeholder="Masukan email kontak person">
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
                      <label for="rekening_no">No Rek Bank</label>
                      <input type="text" class="form-control" name="rekening_no" id="rekening_no" placeholder="Masukan no rekening">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="rekening_nama">Nama Rekening Bank</label>
                      <input type="text" class="form-control" name="rekening_nama" id="rekening_nama" placeholder="Masukan nama rekening">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Nama Bank</label>
                      <select class="form-control select2" name="rekening_bank" id="rekening_bank">
                        <option value="">-- pilih nama bank --</option>
                        @foreach ($banks as $bank)
                        <option value="{{$bank->nama}}">{{$bank->nama}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="keterangan">Keterangan</label>
                      <textarea type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan" required></textarea>
                    </div>
                  </div>
                  {{-- <div class="col-md-12">
                    <div class="form-group">
                      <label for="no_sk">No SK</label>
                      <input type="text" class="form-control" name="no_sk" id="no_sk" placeholder="Masukan No SK" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="tgl_sk">Tgl SK</label>
                      <input type="text" class="form-control datepicker" name="tgl_sk" id="tgl_sk" placeholder="Tanggal SK" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="tgl_sk_akhir">Tgl SK AKhir</label>
                      <input type="text" class="form-control datepicker" name="tgl_sk_akhir" id="tgl_sk_akhir" placeholder="Tanggal SK Akhir" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="npwp_file">File SK</label>
                      <input type="file" name="pdf_sk" id="pdf_sk">
                    </div>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="is_active" checked="checked"> Active
                      </label>
                    </div>
                  </div> --}}
                </div>
                <h4>Detail</h4>
                <div id="add-pjs-detail"></div>
              </div>
	            <!-- /.box-body -->

	            <div class="box-footer">
	              <button type="submit" name="submit" value="submit" class="btn btn-primary btn-block">Submit</button>
	            </div>
	        </div>
	        <!-- /.box -->

        </form>
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

  $("#badan_usaha").on("change", function(){
    $.getJSON("/api/v1/badan_usaha?id=" + $(this).val(), function(result){
      $("#provinsi").val(result.provinsi_id);
      $("#kota").val(result.kota_id);
      $("#alamat").val(result.alamat);
      $("#no_telp").val(result.no_tlp);
      $("#email").val(result.email);
      $("#web").val(result.web);
      $("#instansi").val(result.instansi);
      $("#pimpinan_nama").val(result.pimpinan_nama);
      $("#pimpinan_jabatan").val(result.pimpinan_jabatan);
      $("#pimpinan_hp").val(result.pimpinan_hp);
      $("#pimpinan_email").val(result.pimpinan_email);
      $("#kontak_p").val(result.kontak_p);
      $("#no_kontak_p").val(result.no_kontak_p);
      $("#jab_kontak_p").val(result.jab_kontak_p);
      $("#email_kontak_p").val(result.email_kontak_p);
      $("#npwp").val(result.npwp);
      $("#rekening_no").val(result.rekening_no);
      $("#rekening_nama").val(result.rekening_nama);
      $("#rekening_bank").val(result.rekening_bank);
    });
  })

  // $(".bidang").on("change", function(){
  //   var subbidang = $(this).parents('tr').find('.subbidang')

  //   $.getJSON("/api/v1/sub_bidang?bidang=" + $(this).val(), function(result){
  //     subbidang.find('option').remove()
  //     subbidang.append(new Option("Semua Sub klasifikasi", "0"))
  //     result.forEach(function(val, i) {
  //       subbidang.append(new Option(val.id_sub_bidang + " - " + val.deskripsi, val.id_sub_bidang));
  //     })
  //   });
  // })
});
</script>
@endpush
