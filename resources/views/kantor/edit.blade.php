@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
<style>
    .input-group-addon::after {
        content: " :";
    }

    .input-group-addon {
        width: 180px;
        border-radius: 4px !important;
        text-align: left;
        font-weight: bold;
    }

    .input-group-addon:after {
        content: " :";
    }

    .input-group {
        width: 100%;
    }

    input {
        height: 28.8px !important;
        border-radius: 4px !important;
        width: 100%;
        /* border-color: #aaaaaa !important; */
    }

    input::placeholder {
        color: #444 !important;
    }

    .bintang {
        color: red;
    }

    .form-control {
        border-color: #aaaaaa;
    }

</style>
<section class="content-header">
    <h1>
        Ubah Kantor PJK3 Mandiri
        {{-- <small>it all starts here</small>  --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#">Badan Usaha P3SM</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box box-content">
        <div class="box-body">

            @if(session()->get('success'))
            <div class="alert alert-success alert-dismissible fade in"> {{ session()->get('success') }}
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            </div>
            @endif

            <form action="{{ route('master_kantor.update', $data->id) }}" class="form-horizontal" id="formAdd"
                name="formAdd" method="post" enctype="multipart/form-data">
                @method("PATCH")
                @csrf
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-6 {{ $errors->first('id_nama_kantor') ? 'has-error' : '' }}">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="bintang">*</span> Nama Kantor
                                </div>
                                <input name="id_nama_kantor" id="id_nama_kantor" class="form-control"
                                    placeholder="Nama Kantor"
                                    value="{{old('id_nama_kantor') ? old('id_nama_kantor') : $data->nama}}">
                            </div>

                            <span id="id_nama_kantor"
                                class="help-block customspan">{{ $errors->first('id_nama_kantor') }}
                            </span>
                        </div>

                        <div class="col-sm-6 {{ $errors->first('id_singkat_kantor') ? 'has-error' : '' }}">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="bintang">*</span> Singkat Nama Kantor
                                </div>
                                <input name="id_singkat_kantor" id="id_singkat_kantor" class="form-control"
                                    placeholder="*Singkatan Nama Kantor"
                                    value="{{old('id_singkat_kantor') ? old('id_singkat_kantor') : $data->singkatan}}">
                            </div>

                            <span id="id_singkat_kantor"
                                class="help-block customspan">{{ $errors->first('id_singkat_kantor') }} </span>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-sm-6 {{ $errors->first('id_level_k') ? 'has-error has-error-select' : '' }}">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="bintang">*</span> Level Kantor
                                </div>
                                <select class="form-control select2" name="id_level_k" id="id_level_k"
                                    style="width: 100%;">
                                    <option value="" disabled selected>Level Kantor</option>
                                    @foreach($level as $key)
                                    <option value="{{ $key->id }}" {{ $key->id == $data->level_id ? 'selected' : '' }}>
                                        {{ $key->nama }} </option>
                                    @endforeach
                                </select>
                            </div>

                            <span id="id_level_k" class="help-block customspan">{{ $errors->first('id_level_k') }}
                            </span>
                        </div>

                        <div class="col-sm-6 {{ $errors->first('id_level_atas') ? 'has-error has-error-select' : '' }}">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Level Diatasnya
                                </div>
                                <select class="form-control select2" name="id_level_atas" id="id_level_atas"
                                    style="width: 100%;">
                                    <option value="" disabled selected>Kantor Level Diatasnya</option>
                                </select>
                            </div>

                            <span id="id_level_atas" class="help-block customspan">{{ $errors->first('id_level_atas') }}
                            </span>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-sm-12 {{ $errors->first('id_alamat') ? 'has-error' : '' }} ">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="bintang">*</span> Alamat
                                </div>
                                <input name="id_alamat" id="id_alamat" class="form-control"
                                    placeholder="*Alamat Jalan, Kelurahan, Kecamatan"
                                    value="{{old('id_alamat') ? old('id_alamat') : $data->alamat}}">
                            </div>

                            <span id="id_alamat" class="help-block customspan">{{ $errors->first('id_alamat') }}
                            </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 {{ $errors->first('id_prov') ? 'has-error has-error-select' : '' }}">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="bintang">*</span> Provinsi
                                </div>
                                <select class="form-control select2" name="id_prov" id="id_prov" style="width: 100%;">
                                    <option value="" disabled selected>*Provinsi</option>
                                    @foreach($prov as $key)
                                    <option value="{{ $key->id_provinsi }}" {{ $key->id_provinsi == $data->provinsi_id ? 'selected' : '' }}>
                                        {{ $key->nama }} </option>
                                    @endforeach
                                </select>
                            </div>

                            <span id="id_prov" class="help-block customspan">{{ $errors->first('id_prov') }}
                            </span>
                        </div>

                        <div class="col-sm-6 {{ $errors->first('id_kota') ? 'has-error has-error-select' : '' }}">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="bintang">*</span> Kota
                                </div>
                                <select class="form-control select2" name="id_kota" id="id_kota" style="width: 100%;">
                                    <option value="" disabled selected>*Kota</option>
                                    @foreach($kotapil as $key)
                                    <option value="{{ $key->id }}" {{ $key->id == $data->kota_id ? 'selected' : '' }}>
                                        {{ $key->nama }} </option>
                                    @endforeach
                                </select>
                            </div>

                            <span id="id_kota" class="help-block customspan">{{ $errors->first('id_kota') }}
                            </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 {{ $errors->first('id_no_telp') ? 'has-error' : '' }}">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="bintang">*</span> No Telpon
                                </div>
                                <input name="id_no_telp" id="id_no_telp" type="text" class="form-control"
                                    placeholder="*No Tlp"
                                    value="{{old('id_no_telp') ? old('id_no_telp') : $data->no_tlp}}">
                            </div>

                            <span id="id_no_telp" class="help-block customspan">{{ $errors->first('id_no_telp') }}
                            </span>
                        </div>

                        <div class="col-sm-6 {{ $errors->first('id_email') ? 'has-error' : '' }}">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="bintang">*</span> Email
                                </div>
                                <input name="id_email" id="id_email" type="email" class="form-control"
                                    placeholder="*Email" value="{{old('id_email') ? old('id_email') : $data->email}}">
                            </div>

                            <span id="id_email" class="help-block customspan">{{ $errors->first('id_email') }} </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Instansi Reff
                                </div>
                                <input name="id_instansi" id="id_instansi" type="text" class="form-control"
                                    placeholder="Instansi Reff"
                                    value="{{old('id_instansi') ? old('id_instansi') : $data->instansi}}">
                            </div>

                            <span id="id_instansi" class="help-block customspan">{{ $errors->first('id_instansi') }}
                            </span>
                        </div>

                        <div class="col-sm-6">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Web
                                </div>
                                <input name="id_web" id="id_web" type="text" class="form-control" placeholder="Web"
                                    value="{{old('id_web') ? old('id_web') : $data->web}}">
                            </div>

                            <span id="id_web" class="help-block customspan">{{ $errors->first('id_web') }} </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Nama Pimpinan
                                </div>
                                <input name="id_nama_p" id="id_nama_p" type="text" class="form-control"
                                    placeholder="Nama Pimpinan"
                                    value="{{old('id_nama_p') ? old('id_nama_p') : $data->pimpinan_nama}}">
                            </div>

                            <span id="id_nama_p" class="help-block customspan">{{ $errors->first('id_nama_p') }} </span>
                        </div>

                        <div class="col-sm-6">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Jabatan Pimpinan
                                </div>
                                <input name="id_jab_p" id="id_jab_p" type="text" class="form-control"
                                    placeholder="Jabatan Pimpinan"
                                    value="{{old('id_jab_p') ? old('id_jab_p') : $data->pimpinan_jabatan}}">
                            </div>

                            <span id="id_jab_p" class="help-block customspan">{{ $errors->first('id_jab_p') }} </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    No HP Pimpinan
                                </div>
                                <input name="id_hp_p" id="id_hp_p" type="text" class="form-control"
                                    placeholder="No Hp Pimpinan"
                                    value="{{old('id_hp_p') ? old('id_hp_p') : $data->pimpinan_hp}}">
                            </div>

                            <span id="id_hp_p" class="help-block customspan">{{ $errors->first('id_hp_p') }} </span>
                        </div>

                        <div class="col-sm-6">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Email Pimpinan
                                </div>
                                <input name="id_email_p" id="id_email_p" type="email" class="form-control"
                                    placeholder="Email Pimpinan"
                                    value="{{old('id_email_p') ? old('id_email_p') : $data->pimpinan_email}}">
                            </div>
                            <span id="id_email_p" class="help-block customspan">{{ $errors->first('id_email_p') }}
                            </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 {{ $errors->first('id_nama_kp') ? 'has-error' : '' }}">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="bintang">*</span> Nama Kontak Person
                                </div>
                                <input name="id_nama_kp" id="id_nama_kp" type="text" class="form-control"
                                    placeholder="*Nama Kontak Person"
                                    value="{{old('id_nama_kp') ? old('id_nama_kp') : $data->kontak_p}}">
                            </div>

                            <span id="id_nama_kp" class="help-block customspan">{{ $errors->first('id_nama_kp') }}
                            </span>
                        </div>

                        <div class="col-sm-6">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Jabatan Kontak Person
                                </div>
                                <input name="id_jab_kp" id="id_jab_kp" type="text" class="form-control"
                                    placeholder="Jabatan Kontak Person"
                                    value="{{old('id_jab_kp') ? old('id_jab_kp') : $data->jab_kontak_p}}">
                            </div>

                            <span id="id_jab_kp" class="help-block customspan">{{ $errors->first('id_jab_kp') }} </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 {{ $errors->first('id_hp_kp') ? 'has-error' : '' }}">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="bintang">*</span> No HP Kontak Person
                                </div>
                                <input name="id_hp_kp" id="id_hp_kp" type="text" class="form-control"
                                    placeholder="*No HP Kontak Person"
                                    value="{{old('id_hp_kp') ? old('id_hp_kp') : $data->no_kontak_p}}">
                            </div>
                            <span id="id_hp_kp" class="help-block customspan">{{ $errors->first('id_hp_kp') }} </span>
                        </div>

                        <div class="col-sm-6 {{ $errors->first('id_email_kp') ? 'has-error' : '' }}">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="bintang">*</span> Email Kontak Person
                                </div>
                                <input name="id_email_kp" id="id_email_kp" type="email" class="form-control"
                                    placeholder="*Email Kontak Person"
                                    value="{{old('id_email_kp') ? old('id_email_kp') : $data->email_kontak_p}}">
                            </div>
                            <span id="id_email_kp" class="help-block customspan">{{ $errors->first('id_email_kp') }}
                            </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 {{ $errors->first('id_keterangan') ? 'has-error' : '' }} ">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Keterangan
                                </div>
                                <input name="id_keterangan" id="id_keterangan" class="form-control"
                                    placeholder="Keterangan"
                                    value="{{old('id_keterangan') ? old('id_keterangan') : $data->keterangan}}">
                            </div>
                            <span id="id_keterangan" class="help-block customspan">{{ $errors->first('id_keterangan') }}
                            </span>
                        </div>
                    </div>

                    <div class="row" style="text-align:right">
                        <div class="col-sm-12">
                            <span class="bintang"><b>*</b></span> Wajib Diisi
                        </div>
                    </div>

                </div>


                <div class="box-footer" style="text-align:center">
                    <div class="row">
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-md btn-info"> <i class="fa fa-save"></i>
                                Simpan</button>
                        </div>
                        <div class="col-sm-6">
                            <button type="button" onclick="goBack()" class="btn btn-md btn-default"><i
                                    class="fa fa-times-circle"></i>
                                Batal</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

</section>
<!-- /.content -->

@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/input-mask/jquery.inputmask.js')}}"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
<script type="text/javascript">
    // $('.select2').val(null).trigger('change');
    $(function () {

        // untuk dropdown cari berdasarkan nama

        // Readonly Level Kantor
        $("#id_level_k").parent().find('.select2-container--default').css(
            'pointer-events',
            'none');
        $("#id_level_k").parent().find('.select2-selection--single').css(
            'background', '#eee');

        // Level Kantor Change
        $('#id_level_k').on('select2:select', function () {
            changelevelatas();
        });

        // format input
        $('[data-mask]').inputmask()

        // Filter Kota Berdasarkan Provinsi

        $("#id_prov").on("change", function(){
          $.getJSON("/api/v1/kota?provinsi=" + $(this).val(), function(result){
            $('#id_kota').find('option').remove()
            $('#id_kota').append(new Option("*Kota", ""))
            result.forEach(function(val, i) {
              $("#id_kota").append(new Option(val.nama, val.id));
            })
          });
        })

        //Kunci Input No Hp Hanya Angka
        $('#id_no_telp,#id_hp_p,#id_hp_kp').on('input blur paste', function () {
            $(this).val($(this).val().replace(/\D/g, ''))
        })

        function changelevelatas() {
            var url = "{{ url('daftarkantor/changelevelatas') }}";
            var id_level_k = $("#id_level_k").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    id_level_k: id_level_k
                },
                success: function (data) {
                    level = $('#id_level_k').val();
                    if (level != 1 && data.length <= 0) {
                        alert('Level atas belum terdaftar');
                        $('#id_level_k').val("").trigger('change.select2');
                        $("#id_level_atas").html(
                            "<option value='' disabled selected>Kantor Level Diatasnya</option>"
                        );
                    } else {
                        $("#id_level_atas").html(
                            "<option value='' disabled>Kantor Level Diatasnya</option>");
                        $("#id_level_atas").select2({
                            data: data
                        }).val(null).trigger('change');
                        $('#id_level_atas').val($('#id_level_atas option:eq(1)').val()).trigger(
                            'change.select2');
                        // $('#timprodatas').select2("val", $('#timprodatas option:eq(1)').val());
                    }
                },
                error: function (xhr, status) {
                    alert('Error');
                }
            });
        }

    });

    //Initialize Select2 Elements
    $('.select2').select2()

    $('.datepicker').datepicker({
        format: 'yyyy/mm/dd',
        autoclose: true
    })

</script>
@endpush
