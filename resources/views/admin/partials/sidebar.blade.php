<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link collapsed @yield('dashboard')" href="{{ route('dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed @yield('job_types')" href="{{ route('job-types') }}">
                <i class="bi bi-type"></i>
                <span>Job Types</span>
            </a>
        </li><!-- End Dashboard Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed @yield('jobs')" href="{{ route('jobs') }}">
                <i class="bi bi-file"></i>
                <span>Jobs</span>
            </a>
        </li><!-- End Dashboard Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed @yield('applicants')" href="{{ route('applicants') }}">
                <i class="bi bi-people"></i>
                <span>Applicants</span>
            </a>
        </li><!-- End Dashboard Nav -->
    </ul>
</aside><!-- End Sidebar-->
