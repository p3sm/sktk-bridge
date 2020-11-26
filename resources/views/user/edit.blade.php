@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Users Management
        {{--  <small>it all starts here</small>  --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url("")}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url("users")}}">Users</a></li>
        <li class="active"><a href="#">Create</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	<div class="row">

	      <div class="col-md-6  col-md-offset-3">

	        <!-- general form elements -->
	        <div class="box box-primary">
	          <div class="box-header with-border">
	            <h3 class="box-title">Edit User</h3>
	          </div>
	          <!-- /.box-header -->
	          <!-- form start -->
	          <form role="form" method="post" action="{{route('users.update', $user->id)}}">
	          	@method('PATCH') 
              @csrf
	            <div class="box-body">
	              <div class="form-group">
	                <label for="name">Nama</label>
	                <input type="text" class="form-control" name="name" id="name" value="{{$user->name}}" placeholder="Enter name">
	              </div>
	              <div class="form-group">
	                <label for="username">Username</label>
	                <input type="text" class="form-control" name="username" id="username" value="{{$user->username}}" placeholder="Enter username">
	              </div>
	              <div class="form-group">
	                <label for="password">Password</label>
	                <input type="password" class="form-control" name="password" id="password" placeholder="**current password**">
	              </div>
	              <div class="form-group">
                  <label>Tipe Akun</label>
                  <select class="form-control" id="tipe_akun" name="tipe_akun">
										<option value="1" {{$user->tipe_akun == "1" ? "selected" : ""}}>Akun General</option>
										<option value="2" {{$user->tipe_akun == "2" ? "selected" : ""}}>Akun Tim Produksi</option>
										<option value="3" {{$user->tipe_akun == "3" ? "selected" : ""}}>Akun Tim Marketing</option>
                  </select>
                </div>
	              <div class="form-group" id="block_tim_produksi">
                  <label>Tim Produksi</label>
                  <select class="form-control" name="team_id">
										<option value="">-- pilih tim produksi --</option>
                    @foreach ($tim_produksi as $team)
                    <option value="{{$team->id}}" {{$user->team_id == $team->id ? "selected" : ""}}>{{$team->nama}}</option>
                    @endforeach
                  </select>
                </div>
	              <div class="form-group" id="block_tim_marketing">
                  <label>Tim Marketing</label>
                  <select class="form-control" name="marketing_id">
										<option value="">-- pilih tim marketing --</option>
                    @foreach ($tim_marketing as $team)
                    <option value="{{$team->id}}" {{$user->marketing_id == $team->id ? "selected" : ""}}>{{$team->nama}}</option>
                    @endforeach
                  </select>
                </div>
	              <div class="form-group">
                  <label>Role</label>
                  <select class="form-control" name="role_id">
                    @foreach ($roles as $role)
                    <option value="{{$role->id}}" {{$user->role_id == $role->id ? "selected" : ""}}>{{$role->name}}</option>
                    @endforeach
                  </select>
                </div>
	              <div class="form-group">
                  <label>Asosiasi</label>
                  <select class="form-control" name="asosiasi_id">
										<option value="">-- pilih asosiasi --</option>
                    @foreach ($asosiasi as $as)
											@if($as->id_asosiasi == "142" || $as->id_asosiasi == "148")
												<option value="{{$as->id_asosiasi}}" {{$user->asosiasi && $user->asosiasi->asosiasi_id == $as->id_asosiasi ? "selected" : ""}}>{{$as->nama}}</option>
											@endif
										@endforeach
                  </select>
                </div>
	              <div class="form-group">
                  <label>Provinsi</label>
                  <select class="form-control" name="provinsi_id">
										<option value="">-- pilih provinsi --</option>
                    @foreach ($provinsi as $prov)
                    <option value="{{$prov->id_provinsi}}" {{$user->asosiasi && $user->asosiasi->provinsi_id == $prov->id_provinsi ? "selected" : ""}}>{{$prov->nama}}</option>
                    @endforeach
                  </select>
                </div>
	              <div class="checkbox">
	                <label>
	                  <input type="checkbox" name="is_active" {{$user->is_active ? "checked" : ""}}> Active
	                </label>
	              </div>
	            </div>
	            <!-- /.box-body -->

	            <div class="box-footer">
	              <button type="submit" name="submit" class="btn btn-primary">Submit</button>
	            </div>
	          </form>
	        </div>
	        <!-- /.box -->

	      </div>

	    </div>
    </section>
    <!-- /.content -->
@endsection

@push('script')
	<script>
		$(document).ready(function(){
			tipeAkunCheck($("#tipe_akun").val());

			$("#tipe_akun").on("change", function(){
				tipeAkunCheck($(this).val());
			})
		});

		function tipeAkunCheck(val){
			if(val == "2"){
				$("#block_tim_produksi").show();
				$("#block_tim_marketing").hide();
			} else if (val == "3") {
				$("#block_tim_produksi").hide();
				$("#block_tim_marketing").show();
			} else {
				$("#block_tim_produksi").hide();
				$("#block_tim_marketing").hide();
			}
		}
	</script>
@endpush