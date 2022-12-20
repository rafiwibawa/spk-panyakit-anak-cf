@php
    $segment2 = Request::segment(2);
    $segment3 = Request::segment(3);
@endphp
<!-- Page Sidebar Start-->
<div class="sidebar-wrapper">
    <div>
        <div class="logo-wrapper" style="height: 81px;">
            <a href="{{url('/')}}">
                <img class="img-fluid for-light" src="{{asset('assets/logo/logo-small.png')}}" style="margin-top: -26px; height: 70px;">
            </a>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
            {{-- <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"></i></div> --}}
        </div>
        <div class="logo-icon-wrapper">
            <a href="{{url('/')}}">
                <img class="img-fluid" src="{{asset('assets/logo/logo.png')}}" alt="">
            </a>
        </div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn">
                        <div class="mobile-back text-end">
                            <span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i>
                        </div>
                    </li>
                     <li class="sidebar-main-title">
                        <div>
                            <h6>Dashboard</h6>
                            <p>workplace</p>
                        </div>
                    </li>
                    
                    {{--<li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav @if($segment2 == 'dashboard') {{'active'}} @endif" href="{{url('admin/dashboard')}}">
                            <i data-feather="home"></i><span>Dashboard</span>
                        </a>
                    </li> --}}

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav @if($segment2 == 'session') {{'active'}} @endif" href="{{url('admin/session')}}">
                            <i data-feather="archive"></i><span>Link Class</span>
                        </a>
                    </li>

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav @if($segment2 == 'session-detail') {{'active'}} @endif" href="{{url('admin/session-detail')}}">
                            <i data-feather="database"></i><span>Registrant</span>
                        </a>
                    </li>

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav @if($segment2 == 'session-email-blast') {{'active'}} @endif" href="{{url('admin/session-email-blast')}}">
                            <i data-feather="database"></i><span>Email Blast</span>
                        </a>
                    </li>

                    {{-- <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav @if($segment2 == 're-registrasi-detail') {{'active'}} @endif" href="{{url('admin/re-registration/detail')}}">
                            <i data-feather="database"></i><span>Re-registration</span>
                        </a>
                    </li> --}}
                    {{-- <li class="sidebar-main-title">
                        <div>
                            <h6>Respondent</h6>
                            <p>Data penjawab</p>
                        </div>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav @if($segment2 == 'respondent' && $segment3 == 'recruitment') {{'active'}} @endif" href="{{url('admin/respondent/recruitment')}}">
                            <i data-feather="user-plus"></i><span>Recruitment</span>
                        </a>
                    </li> --}}
                    {{-- @if (!config('additional.client_app')) --}}
                    {{-- <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav @if($segment2 == 'respondent' && $segment3 == 'employee') {{'active'}} @endif" href="{{url('admin/respondent/employee')}}">
                            <i data-feather="user-check"></i>Employees</span>
                        </a>
                    </li> --}}
                    {{-- <li class="sidebar-main-title">
                        <div>
                            <h6>Master Data</h6>
                            <p>Data inti yang harus terisi</p>
                        </div>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav @if($segment2 == 'master' && $segment3 == 'category') {{'active'}} @endif" href="{{url('admin/master/category')}}">
                            <i data-feather="grid"></i><span>Kategori</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav @if($segment2 == 'master' && $segment3 == 'question') {{'active'}} @endif" href="{{url('admin/master/question')}}">
                            <i data-feather="message-square"></i><span>Pertanyaan</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav @if($segment2 == 'master' && $segment3 == 'user') {{'active'}} @endif" href="{{url('admin/master/user')}}">
                            <i data-feather="user"></i><span>User</span>
                        </a>
                    </li> --}}
                    {{-- @endif --}}
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
<!-- Page Sidebar Ends-->
