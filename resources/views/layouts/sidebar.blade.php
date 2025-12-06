<div class="main-sidebar" id="sidebar-scroll">

    <!-- Start::nav -->
    <nav class="main-menu-container nav nav-pills flex-column sub-open">
        <div class="slide-left" id="slide-left">
            <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path> </svg>
        </div>
        <ul class="main-menu">
            <!-- Start::slide__category -->
            <li class="slide__category"><span class="category-name">Main</span></li>
            <!-- End::slide__category -->

            <!-- Start::Dashboard -->
            <li class="slide">
                <a href="{{ route('home') }}" class="side-menu__item {{ request()->routeIs('home') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"/><path d="M133.66,34.34a8,8,0,0,0-11.32,0L40,116.69V216h64V152h48v64h64V116.69Z" opacity="0.2"/><line x1="16" y1="216" x2="240" y2="216" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><polyline points="152 216 152 152 104 152 104 216" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><line x1="40" y1="116.69" x2="40" y2="216" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><line x1="216" y1="216" x2="216" y2="116.69" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><path d="M24,132.69l98.34-98.35a8,8,0,0,1,11.32,0L232,132.69" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/></svg>
                    <span class="side-menu__label">Dashboard</span>
                </a>
            </li>
            <!-- End::Dashboard -->

            @role('superadmin')
            <!-- Start::Superadmin Menu -->
            <li class="slide__category"><span class="category-name">Superadmin</span></li>
            
            <!-- Start::Users Management -->
            <li class="slide has-sub {{ request()->routeIs('admin.users.*') ? 'open' : '' }}">
                <a href="javascript:void(0);" class="side-menu__item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"/><path d="M128,32A96,96,0,0,0,63.8,199.38h0A72,72,0,0,1,128,160a40,40,0,1,1,40-40,40,40,0,0,1-40,40,72,72,0,0,1,64.2,39.37A96,96,0,0,0,128,32Z" opacity="0.2"/><path d="M63.8,199.37a72,72,0,0,1,128.4,0" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><circle cx="128" cy="128" r="96" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><circle cx="128" cy="120" r="40" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/></svg>
                    <span class="side-menu__label">Users</span>
                    <i class="ri-arrow-right-s-line side-menu__angle"></i>
                </a>
                <ul class="slide-menu child1">
                    <li class="slide side-menu__label1">
                        <a href="javascript:void(0)">Users</a>
                    </li>
                    <li class="slide">
                        <a href="{{ route('admin.users.index') }}" class="side-menu__item {{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
                            <i class="ri-group-line me-2"></i> All Users
                        </a>
                    </li>
                    <li class="slide">
                        <a href="{{ route('admin.users.create') }}" class="side-menu__item {{ request()->routeIs('admin.users.create') ? 'active' : '' }}">
                            <i class="ri-user-add-line me-2"></i> Add User
                        </a>
                    </li>
                </ul>
            </li>
            <!-- End::Users Management -->

            <!-- Start::RBAC Management -->
            <li class="slide has-sub {{ request()->routeIs('admin.rbac.*') ? 'open' : '' }}">
                <a href="javascript:void(0);" class="side-menu__item {{ request()->routeIs('admin.rbac.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"/><path d="M128,56C56,56,24,128,24,128s32,72,104,72,104-72,104-72S200,56,128,56Z" opacity="0.2"/><path d="M128,56C56,56,24,128,24,128s32,72,104,72,104-72,104-72S200,56,128,56Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><circle cx="128" cy="128" r="40" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/></svg>
                    <span class="side-menu__label">RBAC</span>
                    <i class="ri-arrow-right-s-line side-menu__angle"></i>
                </a>
                <ul class="slide-menu child1">
                    <li class="slide side-menu__label1">
                        <a href="javascript:void(0)">RBAC Management</a>
                    </li>
                    <li class="slide">
                        <a href="{{ route('admin.rbac.roles') }}" class="side-menu__item {{ request()->routeIs('admin.rbac.roles') ? 'active' : '' }}">
                            <i class="ri-user-settings-line me-2"></i> Roles
                        </a>
                    </li>
                    <li class="slide">
                        <a href="{{ route('admin.rbac.permissions') }}" class="side-menu__item {{ request()->routeIs('admin.rbac.permissions') ? 'active' : '' }}">
                            <i class="ri-shield-keyhole-line me-2"></i> Permissions
                        </a>
                    </li>
                    <li class="slide">
                        <a href="{{ route('admin.rbac.matrix') }}" class="side-menu__item {{ request()->routeIs('admin.rbac.matrix') ? 'active' : '' }}">
                            <i class="ri-table-line me-2"></i> Role-Permission Matrix
                        </a>
                    </li>
                </ul>
            </li>
            <!-- End::RBAC Management -->
            @endrole

        </ul>
        <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path> </svg></div>
    </nav>
    <!-- End::nav -->

</div>
