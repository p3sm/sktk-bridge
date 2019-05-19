<div class="table-responsive">
  <h4>Biodata</h4>
  <table id="" class="table table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
      <tr>
        <th>KTP</th>
        <th>Nama</th>
        <th>Nama Tanpa Gelar</th>
        <th width="30%">Alamat</th>
        <th>Kodepos</th>
        <th>Kabupaten Alamat</th>
        <th>Provinsi Alamat</th>
        <th>Tanggal Lahir</th>
        <th>Tempat Lahir</th>
        <th>Kabupaten Lahir</th>
        <th>Jenis Kelamin</th>
        <th>NPWP</th>
        <th>Email</th>
        <th>No HP</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>{{$personal->No_KTP}}</td>
        <td>{{$personal->Nama}}</td>
        <td>{{$personal->nama_tanpa_gelar}}</td>
        <td>{{$personal->Alamat1}}</td>
        <td>{{$personal->Kodepos}}</td>
        <td>{{$personal->ID_Kabupaten_Alamat}}</td>
        <td>{{$personal->ID_Propinsi}}</td>
        <td>{{$personal->Tgl_Lahir}}</td>
        <td>{{$personal->Tempat_Lahir}}</td>
        <td>{{$personal->ID_Kabupaten_Lahir}}</td>
        <td>{{$personal->jenis_kelamin}}</td>
        <td>{{$personal->npwp}}</td>
        <td>{{$personal->email}}</td>
        <td>{{$personal->hp_personal}}</td>
        <td><a href="{{url("siki_personal/".$personal->id_personal."/sync")}}" class="btn btn-warning btn-xs">Sync</a></td>
      </tr>
    </tbody>
  </table>
</div>
<div class="table-responsive">
  <h4>Pendidikan</h4>
  <table id="" class="table table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
        <tr>
          <th>No.</th>
          <th>Nama Sekolah</th>
          <th>Alamat</th>
          <th>Jurusan</th>
          <th>Tahun</th>
          <th>No Ijazah</th>
          <th>Last Sync Date</th>
          <th>Synced ID</th>
          <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($personal->pendidikan as $k => $pendidikan)
        <tr>
          <td>{{$k + 1}}</td>
          <td>{{$pendidikan->Nama_Sekolah}}</td>
          <td>{{$pendidikan->Alamat1}}</td>
          <td>{{$pendidikan->Jurusan}}</td>
          <td>{{$pendidikan->Tahun}}</td>
          <td>{{$pendidikan->No_Ijazah}}</td>
          <td>{{$pendidikan->sync ? $pendidikan->sync->updated_at : "-"}}</td>
          <td>{{$pendidikan->sync ? $pendidikan->sync->id : "-"}}</td>
          <td><a href="{{url("siki_pendidikan") . "/" . $pendidikan->ID_Personal_Pendidikan . "/sync"}}" class="btn btn-warning btn-xs">Sync</a></td>
        </tr>
        @endforeach
    </tbody>
  </table>
</div>
<div class="table-responsive">
  <h4>Pengalaman Proyek</h4>
  <table id="" class="table table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
      <tr>
        <th>No.</th>
        <th>Proyek</th>
        <th>Lokasi</th>
        <th>Jabatan</th>
        <th>Tanggal</th>
        <th>Nilai</th>
        <th>Last Sync Date</th>
        <th>Synced ID</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach($personal->proyek as $k => $proyek)
      <tr>
        <td>{{$k + 1}}</td>
        <td>{{$proyek->Proyek}}</td>
        <td>{{$proyek->Lokasi}}</td>
        <td>{{$proyek->Jabatan}}</td>
        <td>{{\Carbon\Carbon::parse($proyek->Tgl_Mulai)->format("d F Y")}} - {{\Carbon\Carbon::parse($proyek->Tgl_Selesai)->format("d F Y")}}</td>
        <td>{{number_format($proyek->Nilai, 0, ",", ".")}}</td>
        <td>{{$proyek->sync ? $proyek->sync->updated_at : "-"}}</td>
        <td>{{$proyek->sync ? $proyek->sync->id : "-"}}</td>
        <td><a href="{{url("siki_proyek") . "/" . $proyek->id_personal_proyek . "/sync"}}" class="btn btn-warning btn-xs">Sync</a></td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>