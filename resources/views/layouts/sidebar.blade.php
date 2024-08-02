<aside class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <img src="{{ asset('images/pms.png') }}" style="width:80%; height: 100px;margin-top:-12px;" alt="logo">
        </div>
        <div class="sidebar-nav-wrapper">
            <nav>
                <ul>
                    <li>
                        <a href="{{route('admin.dashboard')}}" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}"><i class="fa fa-home"></i>Dashboard</a>
                    </li>

                    <li class="{{request()->is('admin/country/create') ||  request()->is('admin/country/create') ? 'open' : '' }}">
                        <p><i class="fa fa-photo"></i>Country <i class="fa fa-chevron-right"></i></p>
                        <ul class="side-dropdown">

                            <li><a href="{{route('admin.country.create')}}" class="{{ request()->is('admin/country/create') ? 'active' : '' }}">Create</a></li>

                            <li><a href="{{route('admin.country')}}" class="{{ request()->is('admin/country') ? 'active' : '' }}">View</a></li>

                        </ul>
                    </li>

                    <li class="{{request()->is('admin/position/create') ||  request()->is('admin/position/create') ? 'open' : '' }}">
                        <p><i class="fa fa-list"></i>Position <i class="fa fa-chevron-right"></i></p>
                        <ul class="side-dropdown">

                            <li><a href="{{route('admin.position.create')}}" class="{{ request()->is('admin/position/create') ? 'active' : '' }}">Create</a></li>

                            <li><a href="{{route('admin.position')}}" class="{{ request()->is('admin/position') ? 'active' : '' }}">View</a></li>

                        </ul>
                    </li>

                    <li class="{{request()->is('admin/demand/create') ||  request()->is('admin/demand/create') ? 'open' : '' }}">
                        <p><i class="fa fa-users"></i>Demand <i class="fa fa-chevron-right"></i></p>
                        <ul class="side-dropdown">

                            <li><a href="{{route('admin.demand.create')}}" class="{{ request()->is('admin/demand/create') ? 'active' : '' }}">Create</a></li>

                            <li><a href="{{route('admin.demand')}}" class="{{ request()->is('admin/demand') ? 'active' : '' }}">View</a></li>

                        </ul>
                    </li>

                    <li class="{{request()->is('admin/user/create') ||  request()->is('admin/user/create') ? 'open' : '' }}">
                        <p><i class="fa fa-user"></i>All Users <i class="fa fa-chevron-right"></i></p>
                        <ul class="side-dropdown">

                            <li><a href="{{route('admin.user.create')}}" class="{{ request()->is('admin/user/create') ? 'active' : '' }}">Create</a></li>
                            <li><a href="{{route('admin.user')}}" class="{{ request()->is('admin/user') ? 'active' : '' }}">View</a></li>

                        </ul>
                    </li>

                    <li class="{{request()->is('admin/permission/create') ||  request()->is('admin/permission/create') ? 'open' : '' }}">
                        <p><i class="fa fa-user"></i>All Permissions <i class="fa fa-chevron-right"></i></p>
                        <ul class="side-dropdown">

                            <li><a href="{{route('admin.permission.create')}}" class="{{ request()->is('admin/permission/create') ? 'active' : '' }}">Create</a></li>
                            <li><a href="{{route('admin.permission')}}" class="{{ request()->is('admin/permission') ? 'active' : '' }}">View</a></li>

                        </ul>
                    </li>

                    <li class="{{request()->is('admin/role/create') ||  request()->is('admin/role/create') ? 'open' : '' }}">
                        <p><i class="fa fa-user"></i>All Roles <i class="fa fa-chevron-right"></i></p>
                        <ul class="side-dropdown">

                            <li><a href="{{route('admin.role.create')}}" class="{{ request()->is('admin/role/create') ? 'active' : '' }}">Create</a></li>
                            <li><a href="{{route('admin.role')}}" class="{{ request()->is('admin/role') ? 'active' : '' }}">View</a></li>

                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</aside>