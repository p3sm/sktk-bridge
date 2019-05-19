@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Registrasi Tenaga Ahli
        {{--  <small>it all starts here</small>  --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#">Reg TA</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-body">
            {{--  table data of car  --}}
            <div class="table-responsive">
                <table id="table-personals" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Sub Bidang</th>
                            <th>Admin</th>
                            <th>No Tahap</th>
                            <th>Tgl Tahap</th>
                            <th>Jam Tahap</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($regtas as $k => $regta)
                        <tr>
                            <td>{{$k + 1}}</td>
                            <td>{{$regta->ID_Sub_Bidang}}</td>
                            <td>{{$regta->id_user}}</td>
                            <td>{{$regta->tahap1}}</td>
                            <td>{{$regta->tgl_thp}}</td>
                            <td>{{$regta->jam_thp}}</td>
                        <td><a href="{{url("siki_regta")."/".$regta->tahap}}" class="btn btn-success btn-xs">View</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                   
                </table>
            </div>
            {{--  end of car data  --}}

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
  $('#table-personals').DataTable();
});
</script>
@endpush
