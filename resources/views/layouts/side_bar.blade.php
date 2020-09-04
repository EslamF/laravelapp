        
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4" >
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link" >
                <img src="{{asset('asset/')}}/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">M.O.M</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar" style="direction: rtl">

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false" >
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item has-treeview"  >
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-edit"></i>
                                <p>
                                    <i class="fas fa-angle-left right" style="margin-right:110px" ></i>
                                    الخامات
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{Route('material.type.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>أنواع الخامات</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-edit"></i>
                                <p>
                                    <i class="fas fa-angle-left right" style="margin-right:110px" ></i>
                                    الأذونات
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{Route('order.receiving.material')}}" class="nav-link"">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>إذن إستلام خامات</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{Route('spreading.material.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>إذن الفرش</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{Route('cutting.material.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>إذن القص</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{Route('produce.order.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>إذن تصنيع</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{Route('receiving.product.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>إذن إستلام منتجات</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{Route('sort.order.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>إذن فرز</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{Route('fix.product.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>إذن خروج منتجات تالفة</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{Route('receiving.damaged_product.create_page')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>إذن إستلام منتجات معدلة</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{Route('send.end_product.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>إرسال المنتج الي المخزن</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{Route('store.end_product.list')}}" class="nav-link" >
                                         <i class="far fa-circle nav-icon"></i>
                                        <p>إستلام المنتج بلمخزن</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{Route('buy.list_page')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>إذن البيع</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{Route('process.get_list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>المخزن</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{Route('shipping.get_list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>إذن الشحن</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview"  >
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-table"></i>
                                <p>
                                    <i class="fas fa-angle-left right" style="margin-right:110px" ></i>
                                    المنتجات
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{Route('product.type.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>أنواع المنتجات</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{Route('product.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>المنتجات</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-table"></i>
                                <p>
                                    <i class="fas fa-angle-left right" style="margin-right:110px" ></i>
                                    المنظمات
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{Route('factory.type.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>أنواع المصانع</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{Route('factory.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>المصانع</p>
                                    </a>
                                </li>  <li class="nav-item">
                                    <a href="{{Route('shippingcompany.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>شركات الشحن</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview"  >
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-edit"></i>
                                <p>
                                    <i class="fas fa-angle-left right" style="margin-right:110px" ></i>
                                    اختيارات
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{Route('size.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>المقاسات</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview"  >
                            <a href="#" class="nav-link">
                                <i class="nav-icon far fa-plus-square"></i>
                                <p>
                                    <i class="fas fa-angle-left right" style="margin-right:110px" ></i>
                                    الموظفين
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{Route('supplier.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>المورد</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{Route('customer.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>العملاء</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{Route('employee.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>الموظفين</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>