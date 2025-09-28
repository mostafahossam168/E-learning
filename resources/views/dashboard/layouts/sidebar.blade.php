<div class="sidebar">
    <div class="tog-active d-none d-lg-block" data-tog="true" data-active=".app">
        <i class="fas fa-bars"></i>
    </div>
    <ul class="list">
        <li class="list-item {{ request()->routeIs('dashboard.home') ? 'active' : '' }}">
            <a href="{{ route('dashboard.home') }}">
                <div>
                    <i class="fa-solid fa-house"></i>
                    الرئيسية
                </div>
            </a>
        </li>
        {{-- <li class="list-item">
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
        </div> --}}
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
                        <i class="fa-solid fa-users"></i>
                        المشرفين
                    </div>
                </a>
            </li>
        @endcan
        @can('read_teachers')
            <li class="list-item {{ request()->routeIs('dashboard.teachers.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.teachers.index') }}">
                    <div>
                        <i class="fa-solid fa-person-chalkboard"></i>
                        المعلمين
                    </div>
                </a>
            </li>
        @endcan
        @can('read_students')
            <li class="list-item {{ request()->routeIs('dashboard.students.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.students.index') }}">
                    <div>
                        <i class="fa-solid fa-user-tie"></i>
                        الطلاب
                    </div>
                </a>
            </li>
        @endcan
        @can('read_roles')
            <li class="list-item {{ request()->routeIs('dashboard.roles.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.roles.index') }}">
                    <div>
                        <i class="fa-solid fa-user-shield"></i>
                        الصلاحيات
                    </div>
                </a>
            </li>
        @endcan
        @can('read_categories')
            <li class="list-item {{ request()->routeIs('dashboard.categories.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.categories.index') }}">
                    <div>
                        <i class="fa-solid fa-sitemap"></i>
                        الاقسام
                    </div>
                </a>
            </li>
        @endcan
        @can('read_courses')
            <li class="list-item {{ request()->routeIs('dashboard.courses.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.courses.index') }}">
                    <div>
                        <i class="fa-solid fa-graduation-cap"></i>
                        الكورسات
                    </div>
                </a>
            </li>
        @endcan
        @can('read_lessons')
            <li class="list-item {{ request()->routeIs('dashboard.lessons.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.lessons.index') }}">
                    <div>
                        <i class="fa-solid fa-chalkboard-teacher"></i>
                        الدروس
                    </div>
                </a>
            </li>
        @endcan
        @can('read_coupones')
            <li class="list-item {{ request()->routeIs('dashboard.coupones.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.coupones.index') }}">
                    <div>
                        <i class="fa-solid fa-gift"></i>
                        العروض
                    </div>
                </a>
            </li>
        @endcan
        @can('read_enrollments')
            <li class="list-item {{ request()->routeIs('dashboard.enrollments.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.enrollments.index') }}">
                    <div>
                        <i class="fa-solid fa-gift"></i>
                        الاشتراكات
                    </div>
                </a>
            </li>
        @endcan
        @can('read_reviews')
            <li class="list-item {{ request()->routeIs('dashboard.reviews.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.reviews.index') }}">
                    <div>
                        <i class="fa-solid fa-gift"></i>
                        التقيمات
                    </div>
                </a>
            </li>
        @endcan
        @can('read_contacts')
            <li class="list-item {{ request()->routeIs('dashboard.contacts.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.contacts.index') }}">
                    <div>
                        <i class="fa-solid fa-comments"></i>
                        تواصل معنا
                    </div>
                </a>
            </li>
        @endcan
        @can('read_actives')
            <li class="list-item {{ request()->routeIs('dashboard.actives.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.actives.index') }}">
                    <div>
                        <i class="fa-solid fa-chalkboard-teacher"></i>
                        الجلسات النشطة
                    </div>
                </a>
            </li>
        @endcan
    </ul>
</div>
