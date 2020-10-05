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
        PJS LPJK
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url("approval_regta")}}">PJS LPJK</a></li>
        {{-- <li class="active"><a href="#">{{count($regtas) > 0 ? $regtas[0]->tahap1 : "-"}}</a></li> --}}
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box box-content">
        <div class="box-body">
          <form method="get" style="margin-bottom: 20px" action="" class="form-inline float-right">
            <label class="" for="inlineFormCustomSelectPref">filter: </label>
            <div style="margin-bottom:5px">
              <select name="jnu" class="form-control input-sm" style="width: 200px">
                <option value="">-- Jenis Usaha --</option>
              </select>
              <select name="prv" class="form-control input-sm" style="width: 200px" id="provinsi">
                <option value="">-- Provinsi Tim Marketing --</option>
              </select>
              <select name="mkt" class="form-control input-sm" style="width: 200px">
                <option value="">-- Tim Marketing --</option>
              </select>
              <select name="lvl" class="form-control input-sm" style="width: 200px">
                <option value="">-- Level Tim Marketing--</option>
              </select>
              <select name="gol" class="form-control input-sm" style="width: 200px">
                <option value="">-- Golongan Harga --</option>
              </select>
              <a href="/master_pjklpjk" class="btn btn-default btn-sm my-1">Reset</a>
              <button type="submit" class="btn btn-primary btn-sm my-1">Filter</button>
              {{--<button type="submit" class="btn btn-success btn-sm my-1" name="setuju" value="setuju">Setuju</button> --}}
              <a href="/master_pjklpjk/create" class="btn btn-success btn-sm my-1">Tambah</a>
              <button type="submit" class="btn btn-warning btn-sm my-1" name="ubah" value="ubah">Ubah</button>
              <button type="submit" class="btn btn-danger btn-sm my-1" name="hapus" value="hapus">Hapus</button>
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
                <table id="datatable" class="table table-striped table-bordered dataTable customTable no-footer" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><input id="check_all" type="checkbox"></th>
                            <th>No.</th>
                            <th>Badan Usaha</th>
                            <th>No SK</th>
                            <th>Tanggal SK</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $k => $result)
                          <tr>
                            <td><input class="check_item" type="checkbox" name="pilih_data[]" value="<?php echo $result->id?>" /></td>
                            <td>{{$k + 1}}</td>
                            <td>{{$result->badanUsaha->nama}}</td>
                            <td>{{$result->no_sk}}</td>
                            <td>{{\Carbon\Carbon::parse($result->tgl_sk)->format("d M Y")}} - {{\Carbon\Carbon::parse($result->tgl_sk_akhir)->format("d M Y")}}</td>
                            <td>{{$result->keterangan}}</td>
                            {{-- <td>
                              <a href="{{url("approval_99/" . $result->id . "/approve")}}" class="btn btn-primary btn-xs approve">Approve</a>
                            </td> --}}
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
