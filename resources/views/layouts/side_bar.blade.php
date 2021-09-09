        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4 noprint">
            <!-- Brand Logo -->
            <a href="{{route('home_page')}}" class="brand-link">
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
              
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i style="margin-right:-7px" class="nav-icon fa fa-circle"></i>
                                <p>
                                    <i class="fas fa-angle-left right" style="margin-right:160px"></i>
                                    البيانات الاساسية
                                </p>
                            </a>

                            
                            <ul class="nav nav-treeview">

                                @permission('show-material') 
                                <li class="nav-item">
                                    <a href="{{Route('material.type.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>أنواع الخامات</p>
                                    </a>
                                </li>
                                @endpermission
                            
                                @permission('show-factory-type')
                                <li class="nav-item">
                                    <a href="{{Route('factory.type.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>أنواع المصانع</p>
                                    </a>
                                </li>
                                @endpermission

                                @permission('show-product-type')
                                <li class="nav-item">
                                    <a href="{{Route('product.type.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>أنواع المنتجات</p>
                                    </a>
                                </li>
                                @endpermission

                                @permission('show-product')
                                <li class="nav-item">
                                    <a href="{{Route('product.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>المنتجات</p>
                                    </a>
                                </li>
                                @endpermission

                                @permission('materials-inventory')
                                <li class="nav-item">
                                    <a href="{{Route('receiving.material.pending_vestments')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>جرد الخامات</p>
                                    </a>
                                </li>
                                @endpermission

                                @permission('shipping-following')
                                <li class="nav-item">
                                    <a href="{{Route('buy.shipping_following')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{__('words.shipping_following')}}</p>
                                    </a>
                                </li>
                                @endpermission

                                @permission('sales')
                                <li class="nav-item">
                                    <a href="{{Route('buy.sales')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>المبيعات</p>
                                    </a>
                                </li>
                                @endpermission

                                @permission('show-role')                     
                                <li class="nav-item">
                                    <a href="{{Route('role.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>الوظائف</p>
                                    </a>
                                </li>
                                @endpermission

                                @permission('show-size')
                                <li class="nav-item has-treeview">
                                    <a href="{{Route('size.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>المقاسات</p>
                                    </a>
                                </li>
                                @endpermission

                            </ul>
                        </li>
                    
                        
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i style="margin-right:-7px" class="nav-icon fa fa-circle"></i>
                                <p >
                                    <i class="fas fa-angle-left right" style="margin-right:110px"></i>
                                    الأذونات
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                
                                @permission('show-receiving-material')
                                <li class="nav-item"> 
                                    <a href="{{Route('order.receiving.material')}}" class="nav-link"">
                                        <i class=" far fa-circle nav-icon"></i>
                                        <p>إذن إستلام خامات</p>
                                    </a>
                                </li>
                                @endpermission

                                @permission('show-spreading-order')
                                <li class="nav-item">
                                    <a href="{{Route('spreading.material.counter_list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>إذن الفرش</p>
                                    </a>
                                </li>
                                @endpermission
                                
                                @permission('show-cutting-order')
                                <li class="nav-item">
                                    <a href="{{Route('cutting.outer_list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>إذن القص</p>
                                    </a>
                                </li>
                                @endpermission
                                
                                @permission('show-produce-order')
                                <li class="nav-item">
                                    <a href="{{Route('produce.order.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>إذن تصنيع</p>
                                    </a>
                                </li>
                                @endpermission
                                
                                @permission('show-receiving-product')
                                <li class="nav-item">
                                    <a href="{{Route('receiving.product.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>إذن إستلام منتجات(مصنع)</p>
                                    </a>
                                </li>
                                @endpermission
                                
                                @permission('show-sort-order')
                                <li class="nav-item">
                                    <a href="{{Route('sort.order.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>إذن فرز</p>
                                    </a>
                                </li>
                                @endpermission
                                
                                @permission('show-fix-product-out')
                                <li class="nav-item">
                                    <a href="{{Route('fix.product.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>إذن خروج منتجات تالفة</p>
                                    </a>
                                </li>
                                @endpermission
                                
                                @permission('add-receiving-order-fix')
                                <li class="nav-item">
                                    <a href="{{Route('receiving.damaged_product.create_page')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>إذن إستلام منتجات معدلة</p>
                                    </a>
                                </li>
                                @endpermission
                                
                                @permission('show-send-order')
                                <li class="nav-item">
                                    <a href="{{Route('send.end_product.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>إذن خروج منتجات (مصنع) </p>
                                    </a>
                                </li>
                                @endpermission
                                
                                @permission('show-store-order')
                                <li class="nav-item">
                                    <a href="{{Route('store.end_product.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p> إذن إستلام منتجات (الشركة) </p>
                                    </a>
                                </li>
                                @endpermission
                                
                                @permission('show-buy-order')
                                <li class="nav-item">
                                    <a href="{{Route('buy.list_page')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>إذن البيع</p>
                                    </a>
                                </li>
                                @endpermission
                                
                                @permission('show-process')
                                <li class="nav-item">
                                    <a href="{{Route('process.get_list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>المخزن</p>
                                    </a>
                                </li>
                                @endpermission
                                
                                @permission('show-shipping-order')
                                <li class="nav-item">
                                    <a href="{{Route('shipping.get_list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>إذن الشحن</p>
                                    </a>
                                </li>
                                @endpermission
                                
                            </ul>
                        </li>
                        
                        @permission('show-employee')
                        <li class="nav-item  has-treeview">
                            <a href="{{Route('employee.list')}}" class="nav-link">
                                <i style="margin-right:-7px" class="fa fa-circle nav-icon"></i>
                                <p>الموظفين</p>
                            </a>
                        </li>
                        @endpermission
                            
                        @permission('show-supplier')
                        <li class="nav-item has-treeview">

                            <a href="{{Route('supplier.list')}}" class="nav-link">
                                <i style="margin-right:-7px" class="fa fa-circle nav-icon"></i>
                                <p>الموردين</p>
                            </a>    
                        </li>
                        @endpermission
                            

                        @permission('show-factory')
                        <li class="nav-item has-treeview">

                            <a href="{{Route('factory.list')}}" class="nav-link">
                                <i style="margin-right:-7px" class="fa fa-circle nav-icon"></i>
                                <p>المصانع</p>
                            </a>
                        </li>
                        @endpermission
                        
                        @permission('show-customer')
                        <li style="margin-right:-7px" class="nav-item has-treeview">
                                <a href="{{Route('customer.list')}}" class="nav-link">
                                    <i class="fa fa-circle nav-icon"></i>
                                    <p>العملاء</p>
                                </a>
                        </li>
                        @endpermission
                            
                        @permission('show-shipping-company')
                        <li style="margin-right:-7px" class="nav-item has-treeview">
                            <a href="{{Route('shippingcompany.list')}}" class="nav-link">
                                <i class="fa fa-circle nav-icon"></i>
                                <p>شركات الشحن</p>
                            </a>
                        </li>
                        @endpermission

                        @permission('reports')
                        <li style="margin-right:-7px" class="nav-item">
                            <a href="{{Route('reports.list')}}" class="nav-link">
                                <i class="fa fa-circle nav-icon"></i>
                                <p>التقارير</p>
                            </a>
                        </li>
                        @endpermission
                        
                            
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>