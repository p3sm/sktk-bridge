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
         Permohonan Approval & Hapus 99
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url("approval_regta")}}">Approval 99</a></li>
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
            <div class="input-group input-daterange">
              <input type="text" name="from" class="form-control input-sm" value="{{$from->format("d/m/Y")}}">
              <div class="input-group-addon">to</div>
              <input type="text" name="to" class="form-control input-sm" value="{{$to->format("d/m/Y")}}">
            </div>
            <select name="srtf" class="form-control input-sm">
              <option value="">-- Pilih Sertifikat --</option>
              <option value="SKA" {{$sertifikat == "SKA" ? "selected" : ""}}>SKA</option>
              <option value="SKT" {{$sertifikat == "SKT" ? "selected" : ""}}>SKT</option>
            </select>
            <select name="prv" class="form-control input-sm">
              <option value="">-- Pilih Provinsi --</option>
              @foreach ($provinsi_data as $data)
                <option value="{{str_pad((string)$data->id_provinsi, 2, '0', STR_PAD_LEFT)}}" {{$provinsi == $data->id_provinsi ? "selected" : ""}}>{{$data->nama}}</option>
              @endforeach
            </select>
            <select name="aso" class="form-control input-sm">
              <option value="">-- Pilih Asosiasi --</option>
              <option value="142" {{$asosiasi == 142 ? "selected" : ""}}>ASTEKINDO</option>
              <option value="148" {{$asosiasi == 148 ? "selected" : ""}}>GATAKI</option>
            </select>
            <select name="tim" class="form-control input-sm">
              <option value="">-- Pilih Tim --</option>
              @foreach ($tim_data as $data)
                <option value="{{$data->id}}" {{$tim == $data->id ? "selected" : ""}}>{{$data->name}}</option>
              @endforeach
            </select>
            <a href="/approval_99" class="btn btn-default btn-sm my-1">Reset</a>
            <button type="submit" class="btn btn-primary btn-sm my-1">Filter</button>
            <button type="submit" class="btn btn-danger btn-sm my-1" name="hapus" value="hapus">Hapus</button>
            <button type="submit" class="btn btn-success btn-sm my-1" name="setuju" value="setuju">Setuju</button>

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
                            <th>Sts Mohon</th>
                            <th>Tgl Mohon</th>
                            <th>Jns Mohon</th>
                            <th>Tim Prod</th>
                            <th>Tim Marketing</th>
                            <th>Asosiasi</th>
                            <th>USTK</th>
                            <th>Prov Reg</th>
                            <th>Nama</th>
                            <th>NIK</th>
                            <th>Prov P</th>
                            <th>Sub Klasfks</th>
                            <th>Sub Kualfks</th>
                            <th>Sts Akhir</th>
                            {{-- <th>Action</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $k => $result)
                          <tr>
                            <td><input class="check_item" type="checkbox" name="pilih_permohonan[]" value="<?php echo $result->id?>" /></td>
                            <td>{{$k + 1}}</td>
                            <td>{!!
                              $result->deleted == 1 ? 
                              "<span class='label label-danger'>Dihapus</span>" :
                              (
                                $result->diajukan_hapus == 1 ? 
                                "<span class='label label-warning'>Minta Hapus</span>" : 
                                (
                                  $result->diajukan == 1 && $result->status_terbaru == null ? 
                                  '<span class="label label-primary">Minta Setuju</span>' : 
                                  (
                                    $result->diajukan == 1 && $result->status_terbaru == 99 ? 
                                    '<span class="label label-success">Setuju</span>' : 
                                    ''
                                  )
                                )
                              )
                            !!}</td>
                            <td>{{$result->Tgl_Registrasi}}</td>
                            <td>{{$result->id_permohonan == 1 ? "Baru" : ($result->id_permohonan == 2 ? "Perpanjangan" : "Perubahan")}}</td>
                            
                            @if($result->user->role_id == 2 && $result->user->multiMarketing)
                              @php
                                $mktgs = $result->user->multiMarketing->where('asosiasi_id', $result->ID_Asosiasi_Profesi);
                              @endphp
                              
                              @if(count($mktgs) > 0)
                                <td>{{$mktgs->first()->mktg->produksi->nama}}</td>
                                <td>{{$mktgs->first()->mktg->nama}}</td>
                              @else
                                <td>-</td>
                                <td>-</td>
                              @endif
                            @else
                              <td>{{$result->user->marketing_id ? $result->user->marketing->produksi->nama : ($result->user->team_id ? $result->user->team->nama : "-")}}</td>
                              <td>{{$result->user->marketing_id ? $result->user->marketing->nama : "-"}}</td>
                            @endif

                            <td>{{$result->ID_Asosiasi_Profesi}}</td>
                            <td>{{$result->id_unit_sertifikasi}}</td>
                            <td>{{$result->provinsi->nama_singkat}}</td>
                            <td>{{$result->personal->Nama}}</td>
                            <td>{{$result->ID_Personal}}</td>
                            <td>{{$result->personal->provinsi->nama_singkat}}</td>
                            <td>{{$result->ID_Sub_Bidang}}</td>
                            <td>{{$result->tipe_sertifikat == "SKA" ? $result->kualifikasi->deskripsi_ahli : $result->kualifikasi->deskripsi_trampil}}</td>
                            <td>{{$result->status_terbaru}}</td>
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
	
});
</script>
@endpush
