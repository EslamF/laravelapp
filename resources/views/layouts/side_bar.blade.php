        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <img src="{{asset('asset/')}}/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">M.O.M</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item has-treeview">
                            <a href="" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Materials
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{Route('material.type.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Material Type</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-edit"></i>
                                <p>
                                    Orders
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{Route('order.receiving.material')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Receiving Material Order</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{Route('spreading.material.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Spreading Out Order</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{Route('cutting.material.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Cutting Order</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{Route('produce.order.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Produce Order</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{Route('receiving.product.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Receiving Product Order</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{Route('sort.order.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Sort Order</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{Route('fix.product.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Fix Product Order</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{Route('receiving.damaged_product.create_page')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Receiving damaged product</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{Route('send.end_product.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Send Product to Repository</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{Route('store.end_product.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Store Product Order</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-table"></i>
                                <p>
                                    Products
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{Route('product.type.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Product Type</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{Route('product.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Product</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-table"></i>
                                <p>
                                    Organizations
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{Route('factory.type.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Factory Type</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{Route('factory.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Factory</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon far fa-plus-square"></i>
                                <p>
                                    Option
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="pages/tables/simple.html" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Sizes</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon far fa-plus-square"></i>
                                <p>
                                    Persons
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{Route('supplier.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Supplier</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{Route('customer.list')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Customer</p>
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