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
        {{-- <a href="{{url("siki_regta")}}" class="btn btn-danger btn-sm"><i class="fa fa-arrow-left"></i> kembali</a>  --}}
        Pilih Asosiasi
        {{--  <small>it all starts here</small>  --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url("approval_regta")}}">Approval Tenaga Ahli</a></li>
        {{-- <li class="active"><a href="#">{{count($regtas) > 0 ? $regtas[0]->tahap1 : "-"}}</a></li> --}}
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-body">
          <a href="{{url('approval_regta/142')}}" class="btn btn-warning btn-lg">
            ASTEKINDO
          </a>
          <a href="{{url('approval_regta/148')}}" class="btn btn-warning btn-lg">
            GATAKI
          </a>
        </div>
        <!-- /.box-body -->
        <div class="box-footer"></div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection