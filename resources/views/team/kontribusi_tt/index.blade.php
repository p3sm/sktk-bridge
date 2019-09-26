@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Kontribusi
        {{--  <small>it all starts here</small>  --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#">Kontribusi TT</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-body">
          @if(session()->get('success'))
          <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button><strong>{{ session()->get('success') }}</strong>
          </div>
          @endif

          @if(session()->get('error'))
          <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button><strong>{{ session()->get('error') }}</strong>
          </div>
          @endif

          <form method="get" style="margin-bottom: 20px" action="" class="form-inline float-right">
            <label class="" for="">Asosiasi: </label>
            <select name="aso" class="form-control input-sm">
              <option value="">-- Semua Asosiasi --</option>
              <option value="142" {{Request()->aso == 142 ? "selected" : ""}}>ASTEKINDO</option>
              <option value="148" {{Request()->aso == 148 ? "selected" : ""}}>GATAKI</option>
            </select>
            <label class="" for=""> Provinsi: </label>
            <select name="prv" class="form-control input-sm">
              <option value="">-- Semua Provinsi --</option>
              @foreach ($provinsi as $data)
                <option value="{{str_pad((string)$data->ID_Propinsi, 2, '0', STR_PAD_LEFT)}}" {{Request()->prv == $data->ID_Propinsi ? "selected" : ""}}>{{$data->Nama}}</option>
              @endforeach
            </select>
            <label class="" for=""> Tim: </label>
            <select name="tim" class="form-control input-sm">
              <option value="">-- Semua Tim --</option>
              @foreach ($tim as $data)
                <option value="{{$data->id}}" {{Request()->tim == $data->id ? "selected" : ""}}>{{$data->name}}</option>
              @endforeach
            </select>
            <label class="" for=""> Kualifikasi: </label>
            <select name="kua" class="form-control input-sm">
              <option value="">-- Semua Kualifikasi --</option>
              <option value="1" {{Request()->kua == 1 ? "selected" : ""}}>Kelas 1</option>
              <option value="2" {{Request()->kua == 2 ? "selected" : ""}}>Kelas 2</option>
              <option value="3" {{Request()->kua == 3 ? "selected" : ""}}>Kelas 3</option>
            </select>
            <button type="submit" class="btn btn-primary btn-sm my-1">Apply</button>
          </form>
            {{--  table data of car  --}}
            <div class="table-responsive">
                <table id="table-pemohons" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Team</th>
                            <th>Asosiasi</th>
                            <th>Provinsi</th>
                            <th>Kualifikasi</th>
                            <th>Kontribusi</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kontribusi as $k => $knt)
                        <tr>
                          <td>{{$k + 1}}</td>
                          <td>{{$knt->team->name}}</td>
                          <td>{{$knt->id_asosiasi_profesi}}</td>
                          <td>{{$knt->provinsi->Nama_Singkat}}</td>
                          <td>{{$knt->id_kualifikasi}}</td>
                          <td>
                            <span class="kontribusi">{{number_format($knt->kontribusi)}}</span>
                            <form class="form-inline edit-kontribusi" style="display: none" method="post" action="{{route('team_kontribusi_tt.update', $knt->id)}}">
                              @method('PATCH') @csrf
                              <input type="number" min="0" step="1" class="form-control input-sm" name="kontribusi" value="{{$knt->kontribusi}}">
	                            <button type="submit" name="submit" class="btn btn-primary btn-sm"><span class='glyphicon glyphicon-ok'></span></button>
	                            <button class="btn btn-danger btn-sm edit-cancel"><span class='glyphicon glyphicon-remove'></span></button>
                            </form>
                          </td>
                          <td><button class='btn btn-xs btn-warning edit'><span class='glyphicon glyphicon-pencil'></span></button></td>
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
      $('#table-pemohons').DataTable({
        "paging": false
      });
    
      $('.edit').on('click', function(){
        $(this).parents('tr').find('.edit-kontribusi').show()
        $(this).parents('tr').find('.kontribusi').hide()
      })
    
      $('.edit-cancel').on('click', function(e){
        e.preventDefault()
    
        $(this).parent().hide()
        $(this).parents('td').find('.kontribusi').show()
      })
    });
</script>
@endpush
