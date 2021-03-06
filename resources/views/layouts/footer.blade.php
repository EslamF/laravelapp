        <footer class="main-footer noprint">
            <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.0.1-pre
            </div>
        </footer>
        
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
        </div>
        {{-- <script src="{{asset('asset/dist/js/jquery/jquery.form.js')}}"></script>
        <script src="{{asset('asset/dist/js/jquery/jquery.validate.min.js')}}"></script>
        <script src="{{asset('asset/dist/js/jquery/jquery.methods.min.js')}}"></script>
        <script src="{{asset('asset/dist/js/jquery/messages_ar.js')}}"></script> --}}
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <!-- ./wrapper -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
        <!-- jQuery -->

        <script src="{{asset('asset/')}}/plugins/jquery/jquery.min.js"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="{{asset('asset/')}}/plugins/jquery-ui/jquery-ui.min.js"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
            $.widget.bridge('uibutton', $.ui.button)
        </script>
        <!-- Bootstrap 4 -->
        <script src="{{asset('asset/')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- ChartJS -->
        <script src="{{asset('asset/')}}/plugins/chart.js/Chart.min.js"></script>
        <!-- Sparkline -->
        <script src="{{asset('asset/')}}/plugins/sparklines/sparkline.js"></script>
        <!-- JQVMap -->
        <script src="{{asset('asset/')}}/plugins/jqvmap/jquery.vmap.min.js"></script>
        <script src="{{asset('asset/')}}/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
        <!-- jQuery Knob Chart -->
        <script src="{{asset('asset/')}}/plugins/jquery-knob/jquery.knob.min.js"></script>
        <!-- daterangepicker -->
        <script src="{{asset('asset/')}}/plugins/moment/moment.min.js"></script>
        <script src="{{asset('asset/')}}/plugins/daterangepicker/daterangepicker.js"></script>
        <!-- Tempusdominus Bootstrap 4 -->
        <script src="{{asset('asset/')}}/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js">
        </script>
        <!-- Summernote -->
        <script src="{{asset('asset/')}}/plugins/summernote/summernote-bs4.min.js"></script>
        <!-- overlayScrollbars -->
        <script src="{{asset('asset/')}}/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
        <!-- AdminLTE App -->
        <script src="{{asset('asset/')}}/dist/js/adminlte.js"></script>


        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="{{asset('asset/')}}/dist/js/pages/dashboard.js"></script>

        <!-- AdminLTE for demo purposes -->
        <script src="{{asset('asset/')}}/dist/js/demo.js"></script>
        <script src="{{asset('/js/bootstrap-tagsinput.min.js')}}"></script>
        <!-- Select2 -->
        {{--<script src="{{asset('asset/plugins/select2/js/select2.full.min.js')}}"></script>--}}
        <script src="{{asset('asset/jquery/jquery.min.js')}}"></script>
        <!-- Select2 -->
        <script src="{{asset('asset/select2/js/select2.full.min.js')}}"></script>
        <script src = "{{asset('asset/tagselect/jquery.tagselect.js')}}"></script>
        <script>
            $('.select2').select2();
        </script>
        <script>
            $('#submit').click(function() {
                console.log('test');
                $(this).attr('disabled', 'disabled');
            });
            $(".input_focus").focus();
        </script>
        @yield('footer-script')
        @stack('scripts')
        </body>

        </html>