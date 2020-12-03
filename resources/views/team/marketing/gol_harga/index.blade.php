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
         Golongan Harga Marketing
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url("gol_harga_produksi")}}">Golongan Harga Marketing</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-body">
          <form method="get" style="margin-bottom: 20px" action="" class="form-inline float-right">
            <div style="margin-bottom: 10px">
              <label class="" for="inlineFormCustomSelectPref">filter: </label>
              <select name="aso" class="form-control input-sm">
                <option value="">-- Pilih Asosiasi --</option>
                <option value="142" {{$asosiasi == 142 ? "selected" : ""}}>ASTEKINDO</option>
                <option value="148" {{$asosiasi == 148 ? "selected" : ""}}>GATAKI</option>
              </select>
              <select name="gol" class="form-control input-sm">
                <option value="">-- Pilih Golongan --</option>
                <?php foreach ($master_gol as $mg) { ?>
                  <option value="<?php echo $mg->id?>" {{$gol == $mg->id ? "selected" : ""}}><?php echo $mg->gol_harga?></option>
                <?php }?>
              </select>
              <a href="/gol_harga_marketing" class="btn btn-default btn-sm my-1">Reset</a>
              <button type="submit" class="btn btn-primary btn-sm my-1">Filter</button>
              {{-- <button type="submit" class="btn btn-danger btn-sm my-1" name="hapus" value="hapus">Hapus</button>
              <button type="submit" class="btn btn-success btn-sm my-1" name="setuju" value="setuju">Setuju</button> --}}
              <a href="/gol_harga_marketing/create" class="btn btn-success btn-sm my-1">Tambah</a>
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
                            <th>Golongan</th>
                            <th>Asosiasi</th>
                            <th>Harga</th>
                            <th>Jenis Permohonan</th>
                            <th>Klasifikasi</th>
                            <th>Sub Klasifikasi</th>
                            <th>Kualifikasi</th>
                            <th>Sub Kualifikasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $k => $result)
                          <tr>
                            <td><input class="check_item" type="checkbox" name="pilih_permohonan[]" value="<?php echo $result->id?>" /></td>
                            <td>{{$k + 1}}</td>
                            <td>{{$result->head->gol_harga}}</td>
                            <td>{{$result->asosiasi_id}}</td>
                            <td>{{number_format(intval($result->harga))}}</td>
                            <td>{{$result->id_permohonan == "1" ? "baru" : ($result->id_permohonan == "2" ? "Perpanjangan" : "Perubahan")}}</td>
                            <td>{{$result->klasifikasi == 0 ? "Semua": $result->klasifikasi}}</td>
                            <td>{{$result->sub_klasifikasi == 0 ? "Semua" : $result->sub_klasifikasi}}</td>
                            <td>{{$result->kualifikasi}}</td>
                            <td>{{$result->sub_kualifikasi}}</td>
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
	
});
</script>
@endpush
