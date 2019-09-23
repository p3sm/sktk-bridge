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
        Approval Report
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
              <button type="submit" class="btn btn-primary btn-sm my-1">Apply</button>
            </form>
            {{--  table data  --}}
            <div class="table-responsive" style="">
                <table id="datatable" class="table table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th colspan="3">Uraian Laporan</th>
                            <th>Jml Pemohon</th>
                            <th>Jml SKA & SKT</th>
                            <th>Kls III & Muda</th>
                            <th>Kls II & Madya</th>
                            <th>Kls I & Utama</th>
                            <th>Adm Anggota</th>
                            <th>Kontribusi</th>
                            <th>Total</th>
                          </tr>
                    </thead>
                    <tbody>
                      @foreach($report as $r)
                        @php
                        $ska_pemohon = $ska_jumlah = $ska_muda = $ska_madya = $ska_utama = $ska_kontribusi = $ska_total = 0;
                        $skt_pemohon = $skt_jumlah = $skt_muda = $skt_madya = $skt_utama = $skt_kontribusi = $skt_total = 0;
                        $total_pemohon = $total_jumlah = $total_muda = $total_madya = $total_utama = $total_kontribusi = $total_total = 0;
                        @endphp

                        <tr>
                          @if(count($r->team) == 0)
                            <td>{{$r->id}}</td>
                            <td>{{$r->name}}</td>
                            <td colspan="10"></td>
                          @else
                            <td rowspan="{{count($r->team) * 3}}">{{$r->id}}</td>
                            <td rowspan="{{count($r->team) * 3}}">{{$r->name}}</td>
                          @endif

                        @foreach($r->team as $k => $t)

                        @php
                        $ska_pemohon = $ska_pemohon + $t->transaction->ska->pemohon;
                        $ska_jumlah = $ska_jumlah + $t->transaction->ska->jumlah;
                        $ska_muda = $ska_muda + $t->transaction->ska->muda;
                        $ska_madya = $ska_madya + $t->transaction->ska->madya;
                        $ska_utama = $ska_utama + $t->transaction->ska->utama;
                        $ska_kontribusi = $ska_kontribusi + $t->transaction->ska->kontribusi;
                        $ska_total = $ska_total + $t->transaction->ska->total;
                        $skt_pemohon = $skt_pemohon + $t->transaction->skt->pemohon;
                        $skt_jumlah = $skt_jumlah + $t->transaction->skt->jumlah;
                        $skt_muda = $skt_muda + $t->transaction->skt->kelas3;
                        $skt_madya = $skt_madya + $t->transaction->skt->kelas2;
                        $skt_utama = $skt_utama + $t->transaction->skt->kelas1;
                        $skt_kontribusi = $skt_kontribusi + $t->transaction->skt->kontribusi;
                        $skt_total = $skt_total + $t->transaction->skt->total;
                        $total_pemohon = $total_pemohon + $t->transaction->total->pemohon;
                        $total_jumlah = $total_jumlah + $t->transaction->total->jumlah;
                        $total_muda = $total_muda + $t->transaction->total->muda;
                        $total_madya = $total_madya + $t->transaction->total->madya;
                        $total_utama = $total_utama + $t->transaction->total->utama;
                        $total_kontribusi = $total_kontribusi + $t->transaction->total->kontribusi;
                        $total_total = $total_total + $t->transaction->total->total;
                        @endphp

                        @if($k == 1)
                        </tr>
                        @endif

                        @if($k > 0)
                        <tr>
                        @endif

                          <td rowspan="3">{{$t->name}}</td>
                          <td>SKT</td>
                          <td>{{$t->transaction->skt->pemohon}}</td>
                          <td>{{$t->transaction->skt->jumlah}}</td>
                          <td>{{$t->transaction->skt->kelas3}}</td>
                          <td>{{$t->transaction->skt->kelas2}}</td>
                          <td>{{$t->transaction->skt->kelas1}}</td>
                          <td>0</td>
                          <td>{{number_format($t->transaction->skt->kontribusi)}}</td>
                          <td>{{number_format($t->transaction->skt->total)}}</td>
                        </tr>
                        <tr>
                            <td>SKA</td>
                            <td>{{$t->transaction->ska->pemohon}}</td>
                            <td>{{$t->transaction->ska->jumlah}}</td>
                            <td>{{$t->transaction->ska->muda}}</td>
                            <td>{{$t->transaction->ska->madya}}</td>
                            <td>{{$t->transaction->ska->utama}}</td>
                            <td>0</td>
                            <td>{{number_format($t->transaction->ska->kontribusi)}}</td>
                            <td>{{number_format($t->transaction->ska->total)}}</td>
                        </tr>
                        <tr style="color: #e55039">
                          <td>Total</td>
                          <td>{{$t->transaction->total->pemohon}}</td>
                          <td>{{$t->transaction->total->jumlah}}</td>
                          <td>{{$t->transaction->total->muda}}</td>
                          <td>{{$t->transaction->total->madya}}</td>
                          <td>{{$t->transaction->total->utama}}</td>
                          <td>0</td>
                          <td>{{number_format($t->transaction->total->kontribusi)}}</td>
                          <td>{{number_format($t->transaction->total->total)}}</td>
                        </tr>
                        @endforeach
                        
                        @if(count($r->team) > 1)
                          <tr style="background-color: #EAEAEA">
                            <th style="background-color: #FFF" rowspan="3" colspan="3"></th>
                            <th>Total SKT</th>
                            <th>{{$skt_pemohon}}</th>
                            <th>{{$skt_jumlah}}</th>
                            <th>{{$skt_muda}}</th>
                            <th>{{$skt_madya}}</th>
                            <th>{{$skt_utama}}</th>
                            <th>0</th>
                            <th>{{number_format($skt_kontribusi)}}</th>
                            <th>{{number_format($skt_total)}}</th>
                          </tr>
                          <tr style="background-color: #EAEAEA">
                              <th>Total SKA</th>
                              <th>{{$ska_pemohon}}</th>
                              <th>{{$ska_jumlah}}</th>
                              <th>{{$ska_muda}}</th>
                              <th>{{$ska_madya}}</th>
                              <th>{{$ska_utama}}</th>
                              <th>0</th>
                              <th>{{number_format($ska_kontribusi)}}</th>
                              <th>{{number_format($ska_total)}}</th>
                          </tr>
                          <tr style="background-color: #EAEAEA">
                            <th>Total</th>
                            <th>{{$total_pemohon}}</th>
                            <th>{{$total_jumlah}}</th>
                            <th>{{$total_muda}}</th>
                            <th>{{$total_madya}}</th>
                            <th>{{$total_utama}}</th>
                            <th>0</th>
                            <th>{{number_format($total_kontribusi)}}</th>
                            <th>{{number_format($total_total)}}</th>
                          </tr>
                        @endif
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
  $('#table-personals').DataTable();
});
</script>
@endpush