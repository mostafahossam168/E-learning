<div class="sidebar">
    <div class="tog-active d-none d-lg-block" data-tog="true" data-active=".app">
        <i class="fas fa-bars"></i>
    </div>
    <ul class="list">
        <li class="list-item {{ request()->routeIs('dashboard.home') ? 'active' : '' }}">
            <a href="{{ route('dashboard.home') }}">
                <div>
                    <i class="fa-solid fa-grip"></i>
                    الرئيسية
                </div>
            </a>
        </li>
        <li class="list-item">
            <a href="index.html">
                <div>
                    <i class="fa-solid fa-grip"></i>
                    اشعارات المشتركين
                </div>
            </a>
        </li>
        <li class="list-item">
            <a data-bs-toggle="collapse" href="#collapse-1" aria-expanded="false">
                <div>
                    <i class="fa-solid fa-gear icon"></i>
                    الإعدادات
                </div>
                <i class="fa-solid fa-angle-right arrow"></i>
            </a>
        </li>
        <div id="collapse-1" class="collapse item-collapse">
            <li class="list-item">
                <a href="settings.html" class="">
                    <div>
                        <i class="fa-solid fa-gear icon"></i>
                        الإعدادات
                    </div>
                </a>
            </li>
        </div>
        @can('read_settings')
            <li class="list-item {{ request()->routeIs('dashboard.settings') ? 'active' : '' }}">
                <a href="{{ route('dashboard.settings') }}">
                    <div>
                        <i class="fa-solid fa-gear icon"></i>
                        الإعدادات
                    </div>
                </a>
            </li>
        @endcan
        @can('read_admins')
            <li class="list-item {{ request()->routeIs('dashboard.admins.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.admins.index') }}">
                    <div>
                        <i class="fa-solid fa-grip"></i>
                        المشرفين
                    </div>
                </a>
            </li>
        @endcan
        @can('read_teachers')
            <li class="list-item {{ request()->routeIs('dashboard.teachers.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.teachers.index') }}">
                    <div>
                        <i class="fa-solid fa-grip"></i>
                        المعلمين
                    </div>
                </a>
            </li>
        @endcan
        @can('read_students')
            <li class="list-item {{ request()->routeIs('dashboard.students.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.students.index') }}">
                    <div>
                        <i class="fa-solid fa-grip"></i>
                        الطلاب
                    </div>
                </a>
            </li>
        @endcan
        @can('read_roles')
            <li class="list-item {{ request()->routeIs('dashboard.roles.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.roles.index') }}">
                    <div>
                        <i class="fa-solid fa-grip"></i>
                        الصلاحيات
                    </div>
                </a>
            </li>
        @endcan
    </ul>
</div>
