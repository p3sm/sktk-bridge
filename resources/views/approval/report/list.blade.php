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
        Approval Report Detail
        {{--  <small>it all starts here</small>  --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url("approval_regta")}}">Approval Report</a></li>
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
            <label class="" for="">Asosiasi: </label>
            <select name="aso" class="form-control input-sm">
              <option value="">-- Pilih Asosiasi --</option>
              <option value="142" {{$asosiasi == 142 ? "selected" : ""}}>ASTEKINDO</option>
              <option value="148" {{$asosiasi == 148 ? "selected" : ""}}>GATAKI</option>
            </select>
            <label class="" for="">Provinsi: </label>
            <select name="prv" class="form-control input-sm">
              <option value="">-- Pilih Provinsi --</option>
              @foreach ($provinsi_data as $data)
                <option value="{{str_pad((string)$data->ID_Propinsi, 2, '0', STR_PAD_LEFT)}}" {{$provinsi == $data->ID_Propinsi ? "selected" : ""}}>{{$data->Nama}}</option>
              @endforeach
            </select>
            <label class="" for="">Tim: </label>
            <select name="tim" class="form-control input-sm">
              <option value="">-- Pilih Tim --</option>
              @foreach ($tim_data as $data)
                <option value="{{$data->id}}" {{$tim == $data->id ? "selected" : ""}}>{{$data->name}}</option>
              @endforeach
            </select>
            <button type="submit" class="btn btn-primary btn-sm my-1">Apply</button>
          </form>

          @if(session()->get('success'))
          <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>   
                  <strong>{{ session()->get('success') }}</strong>
          </div>
          @endif

          @if(session()->get('error'))
          <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>   
                  <strong>{{ session()->get('error') }}</strong>
          </div>
          @endif

            {{--  table data  --}}
            <div class="table-responsive" style="">
                <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Provinsi</th>
                            <th>Tim Produksi</th>
                            <th>Jenis SRTF</th>
                            <th>No KTP</th>
                            <th>Nama</th>
                            <th>Sub Klasifikasi</th>
                            <th>ID USTK</th>
                            <th>Tgl Permohonan</th>
                            <th>Tgl Approval</th>
                            <th>Kualifikasi</th>
                            <th>Jns Permohonan</th>
                            <th>Kontribusi</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $k => $result)
                          <tr>
                            <td>{{$k + 1}}</td>
                            <td>{{$result->provinsi->Nama_Singkat}}</td>
                            <td>{{$result->team->name}}</td>
                            <td>{{$result->tipe_sertifikat}}</td>
                            <td>{{$result->id_personal}}</td>
                            <td>{{$result->nama}}</td>
                            <td>{{$result->id_sub_bidang}}</td>
                            <td>{{$result->id_unit_sertifikasi}}</td>
                            <td>{{$result->tgl_registrasi}}</td>
                            <td>{{$result->created_at}}</td>
                            <td>{{($result->tipe_sertifikat == "SKA" ? $result->kualifikasi->Deskripsi_ahli : $result->kualifikasi->Deskripsi_trampil)}}</td>
                            <td>{{$result->id_permohonan == 1 ? "Baru" : ($result->id_permohonan == 2 ? "Perpanjangan" : "Perubahan")}}</td>
                            <td>{{number_format($result->dpp_kontribusi)}}</td>
                            <td>{{number_format($result->dpp_total)}}</td>
                          </tr>
                        @endforeach
                    </tbody>
                   
                </table>
            </div>
            {{--  end of data  --}}

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
  $('.input-daterange').datepicker({format: 'dd/mm/yyyy'});
  $('#datatable').DataTable({"paging": false});
});
</script>
@endpush
