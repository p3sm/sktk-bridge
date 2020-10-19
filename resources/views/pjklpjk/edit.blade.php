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
        <li class="active"><a href="#">Edit</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	<div class="row">

	      <div class="col-md-12">

        <!-- form start -->
        <form role="form" method="post" action="{{route("master_pjklpjk.update", $data->id)}}">
          @csrf
          @method('PATCH') 
	        <!-- general form elements -->
	        <div class="box box-primary">
	          <div class="box-header with-border">
	            <h3 class="box-title">Edit PJS LPJK</h3>
	          </div>
	          <!-- /.box-header -->
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
	            <div class="box-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Badan Usaha</label>
                      <select class="form-control" name="badan_usaha">
                        <option value="">-- pilih badan usaha --</option>
                        @foreach ($badan_usaha as $bu)
                        <option value="{{$bu->id}}" {{$data->badan_usaha_id == $bu->id ? "selected" : ""}}>{{$bu->nama}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="provinsi">Provinsi</label>
                      <input type="text" disabled class="form-control" value="{{$data->badanUsaha->provinsi->nama}}" name="provinsi" id="provinsi" placeholder="Masukan Provinsi">
                    </div>
                    <div class="form-group">
                      <label for="alamat">Alamat</label>
                      <textarea type="text" disabled class="form-control" rows="1" name="alamat" id="alamat" placeholder="Masukan alamat" required>{{$data->badanUsaha->alamat}}</textarea>
                    </div>
                    <div class="form-group">
                      <label for="instansi">Instansi Reff</label>
                      <input type="text" disabled class="form-control" value="{{$data->badanUsaha->instansi}}" name="instansi" id="instansi" placeholder="Masukan Instansi Ref">
                    </div>
                    <div class="form-group">
                      <label for="pimpinan_nama">Nama Pimpinan</label>
                      <input type="text" class="form-control" name="pimpinan_nama" id="pimpinan_nama" value="{{$data->pimpinan_nama}}" placeholder="Masukan Nama Pimpinan">
                    </div>
                    <div class="form-group">
                      <label for="pimpinan_hp">No Hp Pimpinan</label>
                      <input type="text" class="form-control" name="pimpinan_hp" id="pimpinan_hp" value="{{$data->pimpinan_hp}}" placeholder="Masukan No Pimpinan">
                    </div>
                    <div class="form-group">
                      <label for="kontak_p">Nama Kontak Person</label>
                      <input type="text" class="form-control" name="kontak_p" id="kontak_p" value="{{$data->kontak_p}}" placeholder="Masukan nama kontak person">
                    </div>
                    <div class="form-group">
                      <label for="no_kontak_p">No Hp Kontak Person</label>
                      <input type="text" class="form-control" name="no_kontak_p" id="no_kontak_p" value="{{$data->no_kontak_p}}" placeholder="Masukan no hp kontak person">
                    </div>
                    <div class="form-group">
                      <label for="npwp">No NPWP</label>
                      <input type="text" class="form-control" name="npwp" id="npwp" value="{{$data->badanUsaha->npwp}}" placeholder="Masukan no npwp">
                    </div>
                    <div class="form-group">
                      <label for="rekening_no">No Rek Bank</label>
                      <input type="text" class="form-control" name="rekening_no" id="rekening_no" value="{{$data->rekening_no}}" placeholder="Masukan no rekening">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="kota">Kota</label>
                      <input type="text" disabled class="form-control" name="kota_id" id="kota" value="{{$data->badanUsaha->kota->nama}}" placeholder="Masukan Kota">
                    </div>
                    <div class="form-group">
                      <label for="no_telp">No Telp</label>
                      <input type="text" disabled class="form-control" name="no_telp" id="no_telp" value="{{$data->badanUsaha->no_tlp}}" placeholder="Masukan no telp" required>
                    </div>
                    <div class="form-group">
                      <label for="email">Email</label>
                      <input type="text" disabled class="form-control" name="email" id="email" placeholder="Masukan email" value="{{$data->badanUsaha->email}}" required>
                    </div>
                    <div class="form-group">
                      <label for="web">Web</label>
                      <input type="text" disabled class="form-control" name="web" id="web" value="{{$data->badanUsaha->web}}" placeholder="Masukan Website">
                    </div>
                    <div class="form-group">
                      <label for="pimpinan_jabatan">Jabatan Pimpinan</label>
                      <input type="text" class="form-control" name="pimpinan_jabatan" id="pimpinan_jabatan" value="{{$data->pimpinan_jabatan}}" placeholder="Masukan Jabatan Pimpinan">
                    </div>
                    <div class="form-group">
                      <label for="pimpinan_email">Email Pimpinan</label>
                      <input type="text" class="form-control" name="pimpinan_email" id="pimpinan_email" value="{{$data->pimpinan_email}}" placeholder="Masukan No Pimpinan">
                    </div>
                    <div class="form-group">
                      <label for="jab_kontak_p">Jabatan Kontak Person</label>
                      <input type="text" class="form-control" name="jab_kontak_p" id="jab_kontak_p" value="{{$data->jab_kontak_p}}" placeholder="Masukan jabatan kontak person">
                    </div>
                    <div class="form-group">
                      <label for="email_kontak_p">Email Kontak Person</label>
                      <input type="text" class="form-control" name="email_kontak_p" id="email_kontak_p" value="{{$data->email_kontak_p}}" placeholder="Masukan email kontak person">
                    </div>
                    <div class="form-group">
                      <label for="rekening_nama">Nama Rekening Bank</label>
                      <input type="text" class="form-control" name="rekening_nama" id="rekening_nama" value="{{$data->rekening_nama}}" placeholder="Masukan nama rekening">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Nama Bank</label>
                      <select class="form-control select2" name="rekening_bank" id="rekening_bank">
                        <option value="">-- pilih nama bank --</option>
                        @foreach ($banks as $bank)
                        <option value="{{$bank->nama}}" selected="{{$data->rekening_bank == $bank->nama ? "selected" : ""}}">{{$bank->nama}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="no_sk">No SK</label>
                      <input type="text" class="form-control" name="no_sk" id="no_sk" placeholder="Masukan No SK" value="{{$data->no_sk}}" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="tgl_sk">Tgl SK</label>
                      <input type="text" class="form-control datepicker" name="tgl_sk" id="tgl_sk" placeholder="Tanggal SK" value="{{\Carbon\Carbon::parse($data->tgl_sk)->format("d/m/Y")}}" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="tgl_sk_akhir">Tgl SK AKhir</label>
                      <input type="text" class="form-control datepicker" name="tgl_sk_akhir" id="tgl_sk_akhir" placeholder="Tanggal SK Akhir" value="{{\Carbon\Carbon::parse($data->tgl_sk_akhir)->format("d/m/Y")}}" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="npwp_file">File SK</label>
                      <input type="file" name="pdf_sk" id="pdf_sk">
                    </div>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="is_active" {{$data->is_active == 1 ? "checked" : ""}}> Active
                      </label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="keterangan">Keterangan</label>
                      <textarea type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan" required>{{$data->keterangan}}</textarea>
                    </div>
                  </div>
                </div>
                <h4>Detail</h4>
                
                <table class="table">
                  <tr>
                    <th>Provinsi</th>
                    <th>Klasifikasi</th>
                    <th>Sub Klasifikasi</th>
                    <th>Kualifikasi</th>
                    <th>Sub Kualifikasi</th>
                    <th>Keterangan</th>
                    <th>Active</th>
                    <th>Action</th>
                  </tr>
                  @foreach($data->detail as $i => $detail)
                  <tr id="detail">
                    <td>
                      <select class="form-control" name="provinsi[{{$i}}]">
                        <option value="">-- pilih provinsi --</option>
                        @foreach ($provinsi as $pr)
                        <option value="{{$pr->id_provinsi}}" {{$detail->provinsi_id == $pr->id_provinsi ? "selected" : ""}}>{{$pr->nama}}</option>
                        @endforeach
                      </select>
                    </td>
                    <td>
                      <select class="form-control bidang" name="klasifikasi[{{$i}}]">
                        <option value="0">Semua klasifikasi</option>
                        @foreach ($bidang as $bid)
                        <option value="{{$bid->id_bidang}}" {{$detail->klasifikasi == $bid->id_bidang ? "selected" : ""}}>{{$bid->id_bidang}} - {{$bid->deskripsi}}</option>
                        @endforeach
                      </select>
                    </td>
                    <td>
                      <select class="form-control subbidang" name="sub_klasifikasi[{{$i}}]">
                        <option value="0">Semua Sub klasifikasi</option>
                        @foreach ($sub_bidang[$i] as $bid)
                        <option value="{{$bid->id_sub_bidang}}" {{$detail->sub_klasifikasi == $bid->id_sub_bidang ? "selected" : ""}}>{{$bid->id_sub_bidang}} - {{$bid->deskripsi}}</option>
                        @endforeach
                      </select>
                    </td>
                    <td>
                      <select class="form-control"  name="kualifikasi[{{$i}}]">
                        <option value="">-- pilih kualifikasi --</option>
                        <option value="SKA" {{$detail->kualifikasi == "SKA" ? "selected" : ""}}>SKA</option>
                        <option value="SKT" {{$detail->kualifikasi == "SKT" ? "selected" : ""}}>SKT</option>
                      </select>
                    </td>
                    <td>
                      <select class="form-control" name="sub_kualifikasi[{{$i}}]">
                        <option value="">-- pilih sub kualifikasi --</option>
                        <option value="1" {{$detail->sub_kualifikasi == "1" ? "selected" : ""}}>Utama / Kelas 1</option>
                        <option value="2" {{$detail->sub_kualifikasi == "2" ? "selected" : ""}}>Madya / Kelas 2</option>
                        <option value="3" {{$detail->sub_kualifikasi == "3" ? "selected" : ""}}>Muda / Kelas 3</option>
                      </select>
                    </td>
                    <td><textarea name="keterangan_detail[{{$i}}]" rows="1" class="form-control">{{$detail->keterangan}}</textarea></td>
                    <td>
                      <label>
                        <input type="checkbox" name="is_active_detail[{{$i}}]" {{$detail->is_active == 1 ? "checked" : ""}}> Active
                      </label>
                    </td>
                    <td>
                      <button class="btn btn-danger btn-xs delete">delete</button>
                    </td>
                  </tr>
                  @endforeach
                  <tbody style="border-top: none;" id="edit-pjs-detail"></tbody>
                </table>
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

  $(".bidang").on("change", function(){
    var subbidang = $(this).parents('tr').find('.subbidang')

    $.getJSON("/api/v1/sub_bidang?bidang=" + $(this).val(), function(result){
      subbidang.find('option').remove()
      subbidang.append(new Option("Semua Sub klasifikasi", "0"))
      result.forEach(function(val, i) {
        subbidang.append(new Option(val.id_sub_bidang + " - " + val.deskripsi, val.id_sub_bidang));
      })
    });
  })

  $(".delete").on("click", function(e){
    e.preventDefault();
    $(this).parents("tr").remove();
  })
});
</script>
@endpush
