
  <header class="main-header">
    <!-- Logo -->
    <a href="../../index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>SB</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>SKTK</b>Bridge</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{ asset('AdminLTE-2.3.11/dist/img/avatar.png') }}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{\Auth::user()->name}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- Menu Body -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div >
                  <!-- <a href="#" class="btn btn-default btn-flat">Sign out</a> -->
                  <form method="post" action="{{ url('logout') }}" style="display: inline">
                      {{ csrf_field() }}
                    <button class="btn btn-default" type="submit">Sign Out</button>
                  </form>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ asset('AdminLTE-2.3.11/dist/img/avatar.png') }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{\Auth::user()->name}}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <li class="treeview {{Request::is('/') ? 'active' : ''}}">
          <a href="{{ url('') }}">
            <i class="fa fa-dashboard"></i> <span>Beranda</span>
          </a>
        </li>

        <li class="{{Request::is('file_manager') ? 'active' : ''}}">
            <a href="{{ url('file_manager') }}">
              <i class="fa fa-folder-open"></i> <span>File Manager</span>
            </a>
        </li>

        @if(Helpers::checkPermission('master') )
          <li class="treeview {{Request::is('master*') ? 'active' : ''}}">
            <a href=""><i class="fa fa-tasks"></i><span>PJS Profesi LPJK Mandiri</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
              <li class=""> <a href="{{ url('#') }}"><span>Kantor PJS LPJK Mandiri</span> </a> </li>
              <li class="{{Request::is('master_badanusaha*') ? 'active' : ''}}"> <a href="{{ url('master_badanusaha') }}"><span>Badan Usaha  PJS LPJK Mandiri</span> </a> </li>
              <li class=""> <a href="{{ url('#') }}"><span>Ijin PJS LPJK Mandiri</span> </a> </li>
              <li class=""> <a href="{{ url('#') }}"><span>Personil PJS LPJK Mandiri</span> </a> </li>
              <li class=""> <a href="{{ url('#') }}"><span>Dokumen Personil PJS LPJK Mandiri</span> </a> </li>
              <li class="{{Request::is('master_pjklpjk*') ? 'active' : ''}}"> <a href="{{ url('master_pjklpjk') }}"><span>PJS LPJK</span> </a> </li>
            </ul>
          </li>
        @endif

        @if(Helpers::checkPermission('upsiki') )
          <li class="treeview {{Request::is('siki*') ? 'active' : ''}}">
            <a href=""><i class="fa fa-tasks"></i><span>UPSIKI</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
              <li class="{{Request::is('siki_regta*') ? 'active' : ''}}"> <a href="{{ url('siki_regta') }}"><span>Registrasi Tenaga Ahli</span> </a> </li>
              <li class="{{Request::is('siki_regtt*') ? 'active' : ''}}"> <a href="{{ url('siki_regtt') }}"><span>Registrasi Tenaga Trampil</span> </a> </li>
              {{-- <li class="{{Request::is('siki_personal') ? 'active' : ''}}"> <a href="{{ url('siki_personal') }}"><span>Personal</span> </a> </li> --}}
            </ul>
          </li>
        @endif

        @if(Helpers::checkPermission('status_99') )
          <li class="treeview {{Request::is('approval_re*') || Request::is('approval_detail*') ? 'active' : ''}}">
            <a href=""><i class="fa fa-tasks"></i><span>Approval</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
              <li class="{{Request::is('approval_regta*') ? 'active' : ''}}"> <a href="{{ url('approval_regta') }}"><span>Tenaga Ahli</span> </a> </li>
              <li class="{{Request::is('approval_regtt*') ? 'active' : ''}}"> <a href="{{ url('approval_regtt') }}"><span>Tenaga Trampil</span> </a> </li>
            </ul>
          </li>

        @endif

        {{-- <li class="{{Request::is('hapus_99*') ? 'active' : ''}}">
            <a href="{{ url('hapus_99') }}">
              <i class="fa fa-tasks"></i> <span>Permohonan Hapus 99</span>
            </a>
        </li> --}}

        @if(Helpers::checkPermission('report') )
          <li class="{{Request::is('laporan*') ? 'active' : ''}}">
            <a href="{{ url('laporan') }}">
              <i class="fa fa-tasks"></i> <span>Laporan SKA & SKT</span>
            </a>
          </li>
          <li class="{{Request::is('approval_report*') ? 'active' : ''}}"> <a href="{{ url('approval_report') }}"><span>Report</span> </a> </li>
          <li class="{{Request::is('approval_detail*') ? 'active' : ''}}"> <a href="{{ url('approval_detail') }}"><span>Report Detail</span> </a> </li>
        @endif

        @if(Helpers::checkPermission('team') )
          <li class="treeview {{Request::is('produksi*') || Request::is('marketing*') || Request::is('gol*') ? 'active' : ''}}">
            <a href=""><i class="fa fa-tasks"></i><span>Tim Produksi Profesi</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
              <li class="{{Request::is('produksi*') ? 'active' : ''}}"> <a href="{{ url('produksi') }}"><span>Tim Produksi PJS LPJK Mandiri</span> </a> </li>
              <li class=""> <a href="{{ url('#') }}"><span>Asesor PJS LPJK Mandiri</span> </a> </li>
              <li class="{{Request::is('approval_99*') ? 'active' : ''}}">
                  <a href="{{ url('approval_99') }}">
                    <span>Kgt Produksi Persetujuan Pusat</span>
                  </a>
              </li>
              <li class="{{Request::is('gol_harga_produksi*') ? 'active' : ''}}"> <a href="{{ url('gol_harga_produksi') }}"><span>Gol Harga Produksi</span> </a> </li>
              <li class="{{Request::is('team_kontribusi_ta*') ? 'active' : ''}}"> <a href="{{ url('team_kontribusi_ta') }}"><span>Kontribusi Ahli</span> </a> </li>
              <li class="{{Request::is('team_kontribusi_tt*') ? 'active' : ''}}"> <a href="{{ url('team_kontribusi_tt') }}"><span>Kontribusi Trampil</span> </a> </li>
            </ul>
          </li>
          <li class="treeview {{Request::is('produksi*') || Request::is('marketing*') || Request::is('gol*') ? 'active' : ''}}">
            <a href=""><i class="fa fa-tasks"></i><span>Tim Marketing & Keuangan</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
              <li class="{{Request::is('marketing*') ? 'active' : ''}}"> <a href="{{ url('marketing') }}"><span>Tim Marketing PJS LPJK Mandiri</span> </a> </li>
              <li class=""> <a href="{{ url('#') }}"><span>Kgt Persetujuan Pusat PJS LPJK Mandiri</span> </a> </li>
              <li class="{{Request::is('gol_harga_marketing*') ? 'active' : ''}}"> <a href="{{ url('gol_harga_marketing') }}"><span>Kontribusi PJS LPJK Mandiri</span> </a> </li>
              <li class=""> <a href="{{ url('#') }}"><span>Tagihan Kontribusi PJS LPJK Mandiri</span> </a> </li>
            </ul>
          </li>
        @endif
        {{-- <li class="{{Request::is('pemohon') ? 'active' : ''}}">
          <a href="{{ url('pemohon') }}">
            <i class="fa fa-user"></i> <span>Pemohon</span>
          </a>
        </li> --}}
        <li class="treeview">
          <a href=""><i class="fa fa-tasks"></i><span>Master 1</span> <i class="fa fa-angle-left pull-right"></i></a>
          <ul class="treeview-menu">
            <li class=""> <a href=""><span>Data Jenis Usaha</span> </a> </li>
            <li class=""> <a href=""><span>Data Klasifikasi</span> </a> </li>
            <li class=""> <a href=""><span>Data Sub Klasifikasi</span> </a> </li>
            <li class=""> <a href=""><span>Data Kualifikasi</span> </a> </li>
            <li class=""> <a href=""><span>Data Sub Kualifikasi</span> </a> </li>
          </ul>
        </li>
        <li class="treeview">
          <a href=""><i class="fa fa-tasks"></i><span>Master 2</span> <i class="fa fa-angle-left pull-right"></i></a>
          <ul class="treeview-menu">
            <li class=""> <a href=""><span>Data Provinsi</span> </a> </li>
            <li class=""> <a href=""><span>Data Kota</span> </a> </li>
          </ul>
        </li>

        @if(Helpers::checkPermission('user') )
        <li class="treeview {{Request::is('users*') ? 'active' : ''}}">
          <a href=""><i class="fa fa-users"></i><span>Referensi</span> <i class="fa fa-angle-left pull-right"></i></a>
          <ul class="treeview-menu">
            <li class=""> <a href="{{ url('users') }}"><span>Daftar User</span> </a> </li>
          </ul>
        </li>
        @endif

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
