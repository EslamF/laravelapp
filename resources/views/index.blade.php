@include('layouts.header')
@include('layouts.nav')
@include('layouts.side_bar')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper noprint">
    <!-- Content Header (Page header) -->
    <div class="content-header noprint" >
        <div class="container-fluid noprint" >
            <div class="row mb-2 noprint">

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content noprint"  style="direction: rtl">
        <div class="container-fluid noprint">
            @yield('content')
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@include('layouts.footer')