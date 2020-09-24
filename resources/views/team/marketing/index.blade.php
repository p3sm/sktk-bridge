@extends('templates.header')

@section('content')

<style type="text/css">
.box-header .box-title {font-size: 14px; }
.box-header {padding: 8px; font-weight: bold;}
.box {border-top-width: 1px;}
.box{
  border-top-color: #ced4d8!important;
  border: 1px solid #ced4d8;
  margin-bottom: 5px;
}
.modal-dialog {width: 90%; }
</style>
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{-- <a href="{{url("approval_regta")}}" class="btn btn-danger btn-sm"><i class="fa fa-arrow-left"></i> kembali</a>  --}}
        {{-- Data Registrasi Tenaga Ahli - Tahap {{count($regtas) > 0 ? $regtas[0]->tahap1 : "-"}} --}}
         Tim Marketing
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url("approval_regta")}}">Tim Marketing</a></li>
        {{-- <li class="active"><a href="#">{{count($regtas) > 0 ? $regtas[0]->tahap1 : "-"}}</a></li> --}}
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-body">
          <form method="get" style="margin-bottom: 20px" action="" class="form-inline float-right">
            <label class="" for="inlineFormCustomSelectPref">filter: </label>
            <div style="margin-bottom:5px">
              <select name="jnu" class="form-control input-sm" style="width: 200px">
                <option value="">-- Jenis Usaha --</option>
                @foreach ($jenis_usaha as $data)
                  <option value="{{$data->id}}" {{$request->jnu == $data->id ? "selected" : ""}}>{{$data->nama}}</option>
                @endforeach
              </select>
              <select name="prv" class="form-control input-sm" style="width: 200px" id="provinsi">
                <option value="">-- Provinsi Tim Marketing --</option>
                @foreach ($provinsi_data as $data)
                  <option value="{{str_pad((string)$data->id_provinsi, 2, '0', STR_PAD_LEFT)}}" {{$request->prv == $data->id_provinsi ? "selected" : ""}}>{{$data->nama}}</option>
                @endforeach
              </select>
              <select name="mkt" class="form-control input-sm" style="width: 200px">
                <option value="">-- Tim Marketing --</option>
                @foreach ($tim_marketing as $data)
                  <option value="{{$data->id}}" {{$request->mkt == $data->id ? "selected" : ""}}>{{$data->nama}}</option>
                @endforeach
              </select>
              <select name="lvl" class="form-control input-sm" style="width: 200px">
                <option value="">-- Level Tim Marketing--</option>
                @foreach ($level as $data)
                  <option value="{{$data->id}}" {{$request->lvl == $data->id ? "selected" : ""}}>{{$data->nama}}</option>
                @endforeach
              </select>
              <select name="gol" class="form-control input-sm" style="width: 200px">
                <option value="">-- Golongan Harga --</option>
                @foreach ($gol_harga as $data)
                  <option value="{{$data->id}}" {{$request->gol_harga_id == $data->id ? "selected" : ""}}>{{$data->gol_harga}}</option>
                @endforeach
              </select>
              <a href="/marketing" class="btn btn-default btn-sm my-1">Reset</a>
              <button type="submit" class="btn btn-primary btn-sm my-1">Filter</button>
              {{--<button type="submit" class="btn btn-success btn-sm my-1" name="setuju" value="setuju">Setuju</button> --}}
              <a href="/marketing/create" class="btn btn-success btn-sm my-1">Tambah</a>
              <button type="submit" class="btn btn-warning btn-sm my-1" name="ubah" value="ubah">Ubah</button>
              <button type="submit" class="btn btn-danger btn-sm my-1" name="hapus" value="hapus">Hapus</button>
            </div>
            <div style="margin-bottom:10px">
              <select name="ins" class="form-control input-sm" style="width: 200px">
                <option value="">-- Instansi Reff --</option>
              </select>
              <select name="kot" class="form-control input-sm" style="width: 200px" id="kota">
                <option value="">-- Kota Tim Marketing --</option>
              </select>
              <select name="prd" class="form-control input-sm" style="width: 200px">
                <option value="">-- Tim Produksi --</option>
                @foreach ($tim_produksi as $data)
                  <option value="{{$data->id}}" {{$request->prd == $data->id ? "selected" : ""}}>{{$data->nama}}</option>
                @endforeach
              </select>
              <select name="lvl" class="form-control input-sm" style="width: 200px">
                <option value="">-- Level Tim Produksi--</option>
                @foreach ($level as $data)
                  <option value="{{$data->id}}" {{$request->lvl == $data->id ? "selected" : ""}}>{{$data->nama}}</option>
                @endforeach
              </select>
            </div>

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

            <div class="clearfix">
            </div>

            {{--  table data  --}}
            <div class="table-responsive" style="">
                <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><input id="check_all" type="checkbox"></th>
                            <th>No.</th>
                            <th>Jns Usaha</th>
                            <th>Tim Markt</th>
                            <th>Tim Prod</th>
                            <th>Gol Hrg</th>
                            <th>Prov M</th>
                            <th>Kota M</th>
                            <th>Instansi Reff</th>
                            <th>Nama Pimp</th>
                            <th>Kontak P</th>
                            <th>NPWP</th>
                            <th>Keterangan</th>
                            <th>Pdf NPWP</th>
                            <th>User Waktu Tambah</th>
                            <th>User Waktu Ubah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $k => $result)
                          <tr>
                            <td><input class="check_item" type="checkbox" name="pilih_data[]" value="<?php echo $result->id?>" /></td>
                            <td>{{$k + 1}}</td>
                            <td>{{$result->jenis_usaha->nama}}</td>
                            <td><span data-toggle="tooltip" data-placement="bottom" data-html="true" 
                              title="Kode: {{$result->kode}} <br> 
                              Nama: {{$result->nama}} <br> 
                              Singkatan: {{$result->singkatan}} <br> 
                              Level: {{$result->level->nama}}">
                              {{$result->singkatan}}</span>
                            </td>
                            <td>
                              @if($result->produksi)
                              <span data-toggle="tooltip" data-placement="bottom" data-html="true" 
                              title="Kode: {{$result->produksi->kode}} <br> 
                              Nama: {{$result->produksi->nama}} <br> 
                              Singkatan: {{$result->produksi->singkatan}} <br> 
                              Level: {{$result->produksi->level->nama}}">
                              {{$result->produksi->singkatan}}</span>
                              @endif
                            </td>
                            <td>{{$result->golHarga->gol_harga}}</td>
                            <td><span data-toggle="tooltip" data-placement="bottom" data-html="true" 
                              title="Singkatan: {{$result->provinsi->nama_singkat}} <br> 
                              Provinsi: {{$result->provinsi->nama}}">
                              {{$result->provinsi->nama}}</span></td>
                            <td><span data-toggle="tooltip" data-placement="bottom" data-html="true" 
                              title="Singkatan: {{$result->kota->singkatan_kota}} <br> 
                              Kota: {{$result->kota->nama}} <br> 
                              Alamat: {{$result->alamat}} <br> 
                              No HP: {{$result->no_telp}} <br> 
                              Email: {{$result->email}} <br> 
                              Web: {{$result->web}}">
                              {{$result->kota->nama}}</span></td>
                            <td>{{$result->instansi}}</td>
                            <td><span data-toggle="tooltip" data-placement="bottom" data-html="true" 
                              title="Nama: {{$result->pimpinan_nama}} <br> 
                              Jabatan: {{$result->pimpinan_jabatan}} <br> 
                              No Hp: {{$result->pimpinan_hp}} <br> 
                              Email: {{$result->pimpinan_email}}">
                              {{$result->pimpinan_nama}}</span></td>
                            <td><span data-toggle="tooltip" data-placement="bottom" data-html="true" 
                              title="Nama: {{$result->kontak_p}} <br> 
                              Jabatan: {{$result->jab_kontak_p}} <br> 
                              No Hp: {{$result->no_kontak_p}} <br> 
                              Email: {{$result->email_kontak_p}}">
                              {{$result->kontak_p}}</span></td>
                            <td><span data-toggle="tooltip" data-placement="bottom" data-html="true" 
                              title="NPWP: {{$result->npwp}} <br> 
                              Norek: {{$result->rekening_no}} <br> 
                              Nama: {{$result->rekening_nama}} <br> 
                              Bank: {{$result->rekening_bank}}">
                              {{$result->npwp}}</span></td>
                            <td>{{$result->keterangan}}</td>
                            <td>-</td>
                            <td>{{$result->created_at}}</td>
                            <td>{{$result->updated_at}}</td>
                          </tr>
                        @endforeach
                    </tbody>
                   
                </table>
            </div>
            {{--  end of data  --}}
          </form>

        </div>
        <!-- /.box-body -->
        <div class="box-footer"></div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection

@push('script')
<script>
$(function(){
	$("#check_all").on("click", function(e){
		$(".check_item").each(function(i){
			$(this).prop('checked', e.target.checked);;
		})
  })

  $("#provinsi").on("change", function(){
    $.getJSON("/api/v1/kota?provinsi=" + $(this).val(), function(result){
      $('#kota').find('option').remove()
      $('#kota').append(new Option("-- Kota Tim Marketing --", ""))
      result.forEach(function(val, i) {
        $("#kota").append(new Option(val.nama, val.id));
      })
    });
  })
  
  $('.input-daterange').datepicker({format: 'dd/mm/yyyy'});
	
  var dt = $('#datatable').DataTable( {
      "lengthMenu": [[100, 200, 500],[100, 200, 500]],
      "scrollX": true,
      "scrollY": $( window ).height() - 255,
      "scrollCollapse": true,
      "autoWidth": false,
      "columnDefs": [ {
          "searchable": false,
          "orderable": false,
          "targets": [0,1]
      } ],
      "order": [[ 2, 'asc' ]]
  } );
  
  dt.on( 'order.dt search.dt', function () {
    dt.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
        cell.innerHTML = i+1;
    } );
} ).draw();
});
</script>
@endpush
