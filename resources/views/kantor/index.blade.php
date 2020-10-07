@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Kantor
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#">Daftar Kantor</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box box-content">
        <div class="box-body">

            @if(session()->get('message'))
            <div class="alert alert-success alert-dismissible fade in"> {{ session()->get('message') }}
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            </div>
            @endif

            {{-- sub menu  --}}
            <form action="{{ url('kantor/filter') }}" enctype="multipart/form-data" name="filterData"
                id="filterData" method="post">
                <!-- @method("PUT") -->
                @csrf
                <!-- <input type="hidden" name="key" id="key">
                <input type="hidden" name="_method" id="_method"> -->
                <div class="row">
                    <div class="col-sm-3">

                        <!-- Table Filter -->
                        <table class="table table-condensed table-filter">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="input-group customSelect2md">
                                            <select class="form-control select2" name="f_level" id="f_level">
                                                <option selected value="">Level_Kantor</option>
                                                @foreach($level as $key)
                                                <option value="{{ $key->id }}"
                                                    {{ request()->get('f_level') == $key->id ? 'selected' : '' }}>
                                                    {{ $key->nama_level }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group customSelect2md">
                                            <select class="form-control select2" name="f_provinsi" id="f_provinsi">
                                                <option value="">Provinsi</option>
                                                @foreach($prov as $key)
                                                <option value="{{ $key->id }}"
                                                    {{ request()->get('f_provinsi') == $key->id ? 'selected' : '' }}>
                                                    {{ $key->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td style="padding-right: 0px">
                                        <button type="submit" class="btn btn-sm btn-info"> <i class="fa fa-filter"></i>
                                            Filter</button>
                                    </td>
                                    <td style="padding-left: 0px">
                                        <a href="{{ url('kantor') }}" class="btn btn-sm btn-default"> <i
                                                class="fa fa-refresh"></i>
                                            Reset</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="input-group customSelect2md">
                                            <select class="form-control select2" name="f_kantor" id="f_kantor">
                                                <option selected value="">Kantor</option>
                                                @foreach($kantor as $key)
                                                <option value="{{ $key->nama_singkat }}"
                                                    {{ request()->get('f_kantor') == $key->nama_singkat ? 'selected' : '' }}>
                                                    {{ $key->nama_singkat }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="input-group customSelect2md">
                                            <select class="form-control select2" name="f_kota" id="f_kota">
                                                <option selected value="">Kota</option>
                                                @foreach($kota as $key)
                                                <option value="{{ $key->id }}"
                                                    {{ request()->get('f_kota') == $key->id ? 'selected' : '' }}>
                                                    {{ $key->nama }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>

                                    <td>

                                    </td>
                                    <td>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- End -->
                    </div>

                    <div class="col-sm-7">

                    </div>

                    <div class="col-sm-2" style='text-align:right'>
                        <div class="btn-group">
                            <a href="{{ route('master_kantor.create') }}" class="btn btn-info"> <i class="fa fa-plus"></i>
                                Tambah</a>
                            <button class="btn btn-success" id="btnEdit" name="btnEdit"> <i class="fa fa-edit"></i>
                                Ubah</button>
                            <button class="btn btn-danger" id="btnHapus" name="btnHapus"> <i class="fa fa-trash"></i>
                                Hapus</button>
                        </div>
                    </div>
                </div>
            </form>
            <!-- /.box-footer -->
            {{-- end of sub menu  --}}
            <!-- <hr> -->
            {{-- table data of car  --}}
            {{-- <div class="table-responsive"> --}}
            <table id="data-tables" class="table table-striped table-bordered dataTable customTable">
                <thead>
                    <tr>
                        <th style="text-indent: 12px;"><i class="fa fa-check-square-o"></i></th>
                        <th style="text-indent: 22px;">No</th>
                        <th>Nama_Ktr</th>
                        <th>Level_Ktr</th>
                        <th>Provinsi</th>
                        <th>Nama_Pimp</th>
                        <th>Kontak_P</th>
                        <th>Keterangan</th>
                        <th>User_Tgl_Tambah</th>
                        <th>User_Tgl_Ubah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $key)
                    <tr>
                        <td style='text-align:center;width:1%'><input type="checkbox" data-id="{{ $key->id }}" class="selection"
                                id="selection[]" name="selection[]"></td>
                        <td style='text-align:center;width:1%'>{{ $loop->iteration }}</td>
                        <td data-toggle="tooltip" data-placement="bottom" data-html="true"
                            title="Nama : {{$key->nama_kantor}}<br>
                                Singkatan Kantor : {{$key->nama_singkat}}
                               ">{{$key->nama_singkat}}</td>
                        {{-- <td style='text-align:center' data-toggle="tooltip" data-placement="bottom" data-html="true" --}}
                            {{-- title="Level Atas : @if($key->level_atas) {{$key->level_atas_r->nama_singkat}} ({{$key->level_atas_r->nama_kantor}}) @else - @endif ">{{$key->levelkantor->nama_level}} --}}</td>
                        {{-- <td style='text-align:center' data-toggle="tooltip" data-placement="bottom" data-html="true"
                            title="
                            Provinsi : {{$key->provinsi->nama}}<br>
                            Kab/Kota : {{$key->kotakantor->nama}}<br>
                            Alamat : {{$key->alamat}}<br>
                            No Telp : {{$key->no_telp}}<br>
                            Email : {{$key->email}}<br>
                            ">{{$key->provinsi->nama_singkat}}</td> --}}
                        <td data-toggle="tooltip" data-placement="bottom" data-html="true"
                            title="Jabatan : {{$key->jab_pimp}}<br>
                            No HP : {{$key->hp_pimp}}<br>
                            Email : {{$key->email_pimp}}<br>
                            ">{{$key->nama_pimp}}</td>
                        <td data-toggle="tooltip" data-placement="bottom" data-html="true"
                            title="Jabatan : {{$key->jab_kontak_p}}<br>
                            No HP : {{$key->no_kontak_p}}<br>
                            Email : {{$key->email_kontak_p}}<br>
                            ">{{$key->kontak_p}}</td>
                        <td>{{$key->keterangan}}
                        </td>
                        <td style='text-align:right'>
                        @if (isset($key->created_at))
                            {{ \Carbon\Carbon::parse($key->created_at)->format("DD MMMM YYYY H:mm:s") }}
                            @endif
                        </td>
                        <td style='text-align:right'>
                        @if (isset($key->updated_at))
                            {{ \Carbon\Carbon::parse($key->updated_at)->format("DD MMMM YYYY H:mm:s") }}
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- </div> --}}
            {{-- end of car data  --}}
        </div>
        <!-- /.box-body -->
        <div class="box-footer"></div>
        <!-- /.box-footer-->
    </div>
    <!-- /.box -->

</section>
<!-- /.content -->

<!-- modal konfirmasi -->
<div class="modal fade" id="modal-konfirmasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <form action="{{ url('kantor/destroy') }}" class="form-horizontal" id="formDelete" name="formDelete"
        method="post" enctype="multipart/form-data">
        @method("DELETE")
        @csrf
        <input type="hidden" value="" name="idHapusData" id="idHapusData">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Konfirmasi</h4>
                </div>
                <div class="modal-body" id="konfirmasi-body">
                    Yakin ingin menghapus data?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger" data-id=""
                        data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Deleting..."
                        id="confirm-delete">Hapus</button>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- end of modal konfirmais -->

<!-- modal lampiran -->
<div class="modal fade" id="modalLampiran" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="lampiranTitle"></h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <iframe src="" id="iframeLampiran" width="100%" height="500px" frameborder="0"
                            allowtransparency="true"></iframe>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>

        </div>
    </div>
</div>
<!-- end of modal lampiran -->
@endsection

@push('script')
<!-- <script type="text/javascript" src="{{ asset('chained.js') }}"></script> -->
<script type="text/javascript">
    var save_method = "add";
    $(function () {

        // Rubah Warna Filter
        selectFilter("f_level");
        selectFilter("f_kantor");
        selectFilter("f_provinsi");
        selectFilter("f_kota");

        // Cache Warna Filter
        if ("{{request()->get('f_level')}}" != "") {
            selectFilterCache("f_level");
        }
        if ("{{request()->get('f_kantor')}}" != "") {
            selectFilterCache("f_kantor");
        }
        if ("{{request()->get('f_provinsi')}}" != "") {
            selectFilterCache("f_provinsi");
        }
        if ("{{request()->get('f_kota')}}" != "") {
            selectFilterCache("f_kota");
        }
  
        // Filter kota berdasarkan provinsi
        $('#f_provinsi').on('select2:select', function () {
            var url = `{{ url('chain/filterprovinsikantor') }}`;
            chainedProvinsiKantor(url, 'f_provinsi', 'f_kota', "Kota");
        });

        // Input data mask
        $('[data-mask]').inputmask();

        // Button edit click
        $('#btnEdit').on('click', function (e) {
            e.preventDefault();
            var id = [];
            $('.selection:checked').each(function () {
                id.push($(this).data('id'));
            });
            if (id.length == 0) {
                Swal.fire({
                    title: "Tidak ada data yang terpilih",
                    type: 'warning',
                    confirmButtonText: 'Close',
                    confirmButtonColor: '#AAA'
                });
            } else if (id.length > 1) {
                Swal.fire({
                    title: "Harap pilih satu data untuk diubah",
                    type: 'warning',
                    confirmButtonText: 'Close',
                    confirmButtonColor: '#AAA'
                });
            } else {
                url = id[0];
                window.location.href = "{{ url('kantor') }}/" + url + "/edit";
            }
        });

        // Button hapus click
        $('#btnHapus').on('click', function (e) {
            e.preventDefault();
            var id = [];
            $('.selection:checked').each(function () {
                id.push($(this).data('id'));
            });
            $("#idHapusData").val(id);
            if (id.length == 0) {
                Swal.fire({
                    title: "Tidak ada data yang terpilih",
                    type: 'warning',
                    confirmButtonText: 'Close',
                    confirmButtonColor: '#AAA'
                });
            } else {
                $('#modal-konfirmasi').modal('show');
            }
        });
    });

    //Initialize Select2 Elements
    $('.select2').select2();

    //Initialize datetimepicker
    $('.datepicker').datepicker({
        format: 'yyyy/mm/dd',
        autoclose: true
    });

</script>
@endpush
