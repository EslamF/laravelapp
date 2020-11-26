        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <img src="{{asset('asset/')}}/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">M.O.M</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar" style="direction: rtl">

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    

                    

                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               @can('show-materials','show-role','show-typefactory','show-prodacttype' )
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i style="margin-right:-7px" class="nav-icon fas fa-edit"></i>
                                <p>
                                    <i class="fas fa-angle-left right" style="margin-right:160px"></i>
                                    البيانات الاساسية
                                </p>
                            </a>

                            @can('show-materials')
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{Route('material.type.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>أنواع الخامات</p>
                                    </a>
                                </li>
                            </ul>
                            @endcan

                            @can('show-typefactory')
                            <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{Route('factory.type.list')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>أنواع المصانع</p>
                                </a>
                            </li>
                            </ul>
                            @endcan

                            @can('show-prodacttype')
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{Route('product.type.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>أنواع المنتجات</p>
                                    </a>
                                </li>
                            </ul>
                                @endcan


                            @can('show-role')
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{Route('role.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>الوظائف</p>
                                    </a>
                                </li>
                            </ul>
                            @endcan
                            
                        </li>

                    @endcan
                        @can('show-matrialreceiving','show-spreading','show-cutting','show-produceorder','show-receivingproduct','show-sortorders','show-fixproductout','show-receivingordersfix','show-sendorders','show-storeorders','show-buyorders','show-shappingorders','show-process')
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i style="margin-right:-7px" class="nav-icon fas fa-edit"></i>
                                <p >
                                    <i class="fas fa-angle-left right" style="margin-right:110px"></i>
                                    الأذونات
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('show-matrialreceiving')
                                <li class="nav-item"> 
                                    <a href="{{Route('order.receiving.material')}}" class="nav-link"">
                                        <i class=" far fa-circle nav-icon"></i>
                                        <p>إذن إستلام خامات</p>
                                    </a>
                                </li>
                                @endcan
                                @can('show-spreading')
                                <li class="nav-item">
                                    <a href="{{Route('spreading.material.counter_list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>إذن الفرش</p>
                                    </a>
                                </li>
                                @endcan
                                @can('show-cutting')
                                <li class="nav-item">
                                    <a href="{{Route('cutting.outer_list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>إذن القص</p>
                                    </a>
                                </li>
                                @endcan
                                @can('show-produceorder')
                                <li class="nav-item">
                                    <a href="{{Route('produce.order.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>إذن تصنيع</p>
                                    </a>
                                </li>
                                @endcan
                                @can('show-receivingproduct')
                                <li class="nav-item">
                                    <a href="{{Route('receiving.product.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>إذن إستلام منتجات(مصنع)</p>
                                    </a>
                                </li>
                                @endcan
                                @can('show-sortorders')
                                <li class="nav-item">
                                    <a href="{{Route('sort.order.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>إذن فرز</p>
                                    </a>
                                </li>
                                @endcan
                                @can('show-fixproductout')
                                <li class="nav-item">
                                    <a href="{{Route('fix.product.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>إذن خروج منتجات تالفة</p>
                                    </a>
                                </li>
                                @endcan
                                @can('show-receivingordersfix')
                                <li class="nav-item">
                                    <a href="{{Route('receiving.damaged_product.create_page')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>إذن إستلام منتجات معدلة</p>
                                    </a>
                                </li>
                                @endcan
                                @can('show-sendorders')
                                <li class="nav-item">
                                    <a href="{{Route('send.end_product.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>إذن خروج منتجات (مصنع) </p>
                                    </a>
                                </li>
                                @endcan
                                @can('show-storeorders')
                                <li class="nav-item">
                                    <a href="{{Route('store.end_product.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p> إذن إستلام منتجات (الشركة) </p>
                                    </a>
                                </li>
                                @endcan
                                @can('show-buyorders')
                                <li class="nav-item">
                                    <a href="{{Route('buy.list_page')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>إذن البيع</p>
                                    </a>
                                </li>
                                @endcan
                                @can('show-process')
                                <li class="nav-item">
                                    <a href="{{Route('process.get_list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>المخزن</p>
                                    </a>
                                </li>
                                @endcan
                                @can('show-shappingorders')
                                <li class="nav-item">
                                    <a href="{{Route('shipping.get_list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>إذن الشحن</p>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan


                        @can('show-shapping')
                        <ul class="nav has-treeview">
                        <li class="nav-item">
                            <a href="{{Route('shippingcompany.list')}}" class="nav-link">
                                <i class="fa fa-circle nav-icon"></i>
                                <p>شركات الشحن</p>
                            </a>
                        </li>
                        </ul>
                        @endcan
                        @can('show-factory')
                        <ul class="nav has-treeview">
                        <li class="nav-item">
                            <a href="{{Route('factory.list')}}" class="nav-link">
                                <i class="fa fa-circle nav-icon"></i>
                                <p>المصانع</p>
                            </a>
                        </li>
                        </ul>
                        @endcan

                        @can('show-size')
                        <ul class="nav has-treeview">
                            <li class="nav-item">
                                <a href="{{Route('size.list')}}" class="nav-link">
                                    <i class="fa fa-circle nav-icon"></i>
                                    <p>المقاسات</p>
                                </a>
                            </li>
                        </ul>
                        @endcan


                        @can('show-employee')
                            <ul class="nav has-treeview">
                                <li class="nav-item">
                                    <a href="{{Route('employee.list')}}" class="nav-link">
                                        <i class="fa fa-circle nav-icon"></i>
                                        <p>الموظفين</p>
                                    </a>
                                </li>
                            </ul>
                            @endcan

                            @can('show-supplier')
                            <ul class="nav has-treeview">
                                <li class="nav-item">
                                    <a href="{{Route('supplier.list')}}" class="nav-link">
                                        <i class="fa fa-circle nav-icon"></i>
                                        <p>الموردين</p>
                                    </a>    
                                </li>
                            </ul>
                            @endcan

                            @can('show-customer')
                            <ul class="nav has-treeview">
                                <li class="nav-item">
                                    <a href="{{Route('customer.list')}}" class="nav-link">
                                        <i class="fa fa-circle nav-icon"></i>
                                        <p>العملاء</p>
                                    </a>
                                </li>
                            </ul>
                            @endcan

                            
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>