<!-- jQuery 2.2.3 -->
<script src="{{ asset('AdminLTE-2.3.11/plugins/jQuery/jquery-2.2.3.min.js')}}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ asset('AdminLTE-2.3.11/bootstrap/js/bootstrap.min.js')}}"></script>
<!-- SlimScroll -->
<script src="{{ asset('AdminLTE-2.3.11/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('AdminLTE-2.3.11/plugins/iCheck/icheck.min.js') }}"></script>

<!-- iCheck -->
<script src="{{ asset('AdminLTE-2.3.11/plugins/fastclick/fastclick.js') }}"></script>

<!-- AdminLTE App -->
<script src="{{ asset('AdminLTE-2.3.11/dist/js/app.min.js') }}"></script>

<script src="{{ asset('js/moment.js') }}" defer></script>

<!-- Data Table -->
<script src="{{ asset('AdminLTE-2.3.11/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>

<!-- File input bootstrap -->
<script src="{{ asset('AdminLTE-2.3.11/plugins/fileinput-v4.5.2-0/js/plugins/piexif.min.js') }}"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/fileinput-v4.5.2-0/js/plugins/sortable.min.js') }}"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/fileinput-v4.5.2-0/js/plugins/purify.min.js') }}"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/fileinput-v4.5.2-0/js/fileinput.min.js') }}"></script>

<script src="{{ asset('AdminLTE-2.3.11/plugins/jquery-validation-1.19.0/dist/jquery.validate.min.js') }}"></script>

<script src="{{ asset('AdminLTE-2.3.11/plugins/input-mask/jquery.inputmask.js')}}"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>

<script src="{{ asset('js/app.js') }}" defer></script>
<script src="{{ asset('js/global.js') }}" defer></script>
{{--  my style  --}}
@stack('script')
</body>
</html>