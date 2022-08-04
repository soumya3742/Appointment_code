<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="side-header">
        <a class="header-brand1" href="#">
          
        </a>
        <a aria-label="Hide Sidebar" class="app-sidebar__toggle ml-auto" data-toggle="sidebar" href="#"></a><!-- sidebar-toggle-->
    </div>
    <div class="app-sidebar__user">
        <div class="dropdown user-pro-body text-center">
            <div class="user-pic">
                <img src="{{ asset('/public/'.auth()->user()->profile_image) }}" alt="user-img" class="avatar-xl rounded-circle">
            </div>
            <div class="user-info">
                <h6 class=" mb-0 text-dark">{{auth()->user()->name}}</h6>
                <span class="text-muted app-sidebar__user-name text-sm">{{auth()->user()->getRoleNames()}}</span>
            </div>
        </div>
    </div>
    <div class="sidebar-navs">
        <ul class="nav  nav-pills-circle">
            <li class="nav-item" data-toggle="tooltip" data-placement="top" title="Settings">
                <a class="nav-link text-center m-2" href="{{ route('setting') }}">
                    <i class="fe fe-settings"></i>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="top" title="Chat">
                <a class="nav-link text-center m-2">
                    <i class="fe fe-mail"></i>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="top" title="Profile">
                <a class="nav-link text-center m-2"  href="{{ route('setting') }}">
                    <i class="fe fe-user"></i>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="top" title="Logout">
                <a class="nav-link text-center m-2" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    <i class="fe fe-power"></i>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </div>


    <ul class="side-menu">
        <li><a class="side-menu__item" href="{{ route('admin.dashboard') }}"><i class="side-menu__icon ti-home"></i><span class="side-menu__label">Dashboard</span></a></li>




   

        @can('Category Master')
    <li class="slide">
        <a class="side-menu__item" data-toggle="slide" href="#"><i class="side-menu__icon fa fa-list-alt"></i><span class="side-menu__label">Front Users</span><i class="angle fa fa-angle-right"></i></a>
        <ul class="slide-menu">
        @can('Category List')
            <li>
                <a href="{{ route('front-users') }}" class="slide-item">Front User List<a>
            </li>
        @endcan

        @can('Category Create')
            <li>
                <a href="{{ route('front-users-create') }}" class="slide-item">Create Front User<a>
            </li>
        @endcan
        </ul>
    </li>
    @endcan




    @can('Doctor Master')
    <li class="slide">
        <a class="side-menu__item" data-toggle="slide" href="#"><i class="side-menu__icon  fa fa-user-md"></i><span class="side-menu__label">Doctor</span><i class="angle fa fa-angle-right"></i></a>
        <ul class="slide-menu">

        @can('Doctor List')
        <li><a href="{{route('category-doctor-list')}}" class="slide-item">Category List<a></li>
        @endcan

        @can('Doctor Create')
        <li><a href="{{route('category-doctor-create')}}" class="slide-item">Create Category<a></li>
        @endcan

        @can('Doctor Create')
            <li><a href="{{route('our-expert')}}" class="slide-item">Our Expert<a></li>
        @endcan

        @can('Doctor List')
        <li> <a href="{{route('doctor-list')}}" class="slide-item">Doctor List<a></li>
        @endcan

        @can('Doctor Create')
            <li><a href="{{route('doctor-create')}}" class="slide-item">Create Doctor<a></li>
        @endcan

        @can('Doctor List')
            <li><a href="{{route('appointment-list')}}" class="slide-item">Appointment List<a></li>
        @endcan
        </ul>
    </li>
    @endcan



</ul>

</aside>
