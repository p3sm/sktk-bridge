@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Registrasi Tenaga Trampil
        {{--  <small>it all starts here</small>  --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#">Reg TT</a></li>
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
                            <th>Admin</th>
                            <th>No Tahap</th>
                            <th>Tgl Tahap</th>
                            <th>Jam Tahap</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($regtts as $k => $regtt)
                        <tr>
                            <td>{{$k + 1}}</td>
                            <td>{{$regtt->id_user}}</td>
                            <td>{{$regtt->tahap1}}</td>
                            <td>{{$regtt->tgl_thp}}</td>
                            <td>{{$regtt->jam_thp}}</td>
                        <td><a href="{{url("siki_regtt")."/".$regtt->tahap}}" class="btn btn-success btn-xs">View</a></td>
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
