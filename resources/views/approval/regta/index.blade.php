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
        <a href="{{url("siki_regta")}}" class="btn btn-danger btn-sm"><i class="fa fa-arrow-left"></i> kembali</a> 
        {{-- Data Registrasi Tenaga Ahli - Tahap {{count($regtas) > 0 ? $regtas[0]->tahap1 : "-"}} --}}
        {{--  <small>it all starts here</small>  --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url("siki_regta")}}">Approval Tenaga Ahli</a></li>
        {{-- <li class="active"><a href="#">{{count($regtas) > 0 ? $regtas[0]->tahap1 : "-"}}</a></li> --}}
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-body">
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

          <form method="get" style="margin-bottom: 20px" action="" class="form-inline float-right">
            <label class="" for="inlineFormCustomSelectPref">filter: </label>
            <div class="input-group input-daterange">
              <input type="text" name="from" class="form-control input-sm" value="{{$from->format("d/m/Y")}}">
              <div class="input-group-addon">to</div>
              <input type="text" name="to" class="form-control input-sm" value="{{$to->format("d/m/Y")}}">
            </div>
            <button type="submit" class="btn btn-primary btn-sm my-1">Apply</button>
          </form>

            {{--  table data  --}}
            <div class="table-responsive" style="">
                <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>NIK</th>
                            <th>Sub Bidang</th>
                            <th>Asosiasi</th>
                            <th>Kualifikasi</th>
                            <th>Tgl Registrasi</th>
                            <th>Provinsi</th>
                            <th>Unit Sertifikasi</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $k => $result)
                          <tr>
                            <td>{{$k + 1}}</td>
                            <td>{{$result->ID_Personal}}</td>
                            <td>{{$result->ID_Sub_Bidang}}</td>
                            <td>{{$result->ID_Asosiasi_Profesi}}</td>
                            <td>{{$result->ID_Kualifikasi}}</td>
                            <td>{{$result->Tgl_Registrasi}}</td>
                            <td>{{$result->ID_Propinsi_reg}}</td>
                            <td>{{$result->id_unit_sertifikasi}}</td>
                            <td>
                              {{-- <a href="{{url("approval_regta/".$sync->permohonan->ID_Registrasi_TK_Ahli."/approve")}}" class="btn btn-primary btn-xs">Approve</a> --}}
                            </td>
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
  $('#datatable').DataTable();
});
</script>
@endpush
