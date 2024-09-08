<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('home') }}" class="brand-link">
        <img src="{{ asset('layout/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">LIS LABORATORY</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('layout/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                @role('Administrator')
                    <li class="nav-item">
                        <a href="{{ route('home') }}"
                            class="nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-header">MANAGE</li>
                    <li class="nav-item">
                        <a href="{{ route('attendance.index') }}"
                            class="nav-link {{ Route::currentRouteName() == 'attendance.index' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-list"></i>
                            <p>Attendance</p>
                        </a>
                    </li>
                    <li
                        class="nav-item {{ Route::currentRouteName() == 'faculty.index' || Route::currentRouteName() == 'user.index' || Route::currentRouteName() == 'faculty-subject.index' ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-user-plus"></i>
                            <p>
                                Users
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('faculty.index') }}"
                                    class="nav-link {{ Route::currentRouteName() == 'faculty.index' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Faculty</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('user.index') }}"
                                    class="nav-link {{ Route::currentRouteName() == 'user.index' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Student</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('faculty-subject.index') }}"
                                    class="nav-link {{ Route::currentRouteName() == 'faculty-subject.index' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Faculty Subjects</p>
                                </a>
                            </li>
                            {{-- <li class="nav-item">
                                <a href="{{ route('faculty-students.index') }}"
                                    class="nav-link {{ Route::currentRouteName() == 'faculty-students.index' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Faculty Students</p>
                                </a>
                            </li> --}}
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('year-sections.index') }}"
                            class="nav-link {{ Route::currentRouteName() == 'year-sections.index' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>Year And Sections</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('logs.index') }}"
                            class="nav-link {{ Route::currentRouteName() == 'logs.index' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>Logs</p>
                        </a>
                    </li>
                @endrole

                @role('Faculty')
                    <li class="nav-header">MANAGE</li>
                    <li class="nav-item">
                        <a href="{{ route('faculty-management.index') }}"
                            class="nav-link {{ Route::currentRouteName() == 'faculty-management.index' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('students') }}"
                            class="nav-link {{ Route::currentRouteName() == 'students' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user"></i>
                            <p>Student Information</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-clock"></i>
                            <p>
                                Attendance Monitoring
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('faculty-session.index') }}" class="nav-link ">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Class Session</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('attendance.index') }}" class="nav-link ">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Attendances</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endrole

                @role('Student')
                    <li class="nav-item">
                        <a href="{{ route('my-attendance.index') }}"
                            class="nav-link {{ Route::currentRouteName() == 'my-attendance.index' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-calendar-check"></i>
                            <p>My Attendance</p>
                        </a>
                    </li>
                @endrole

            </ul>
        </nav>
    </div>
</aside>
