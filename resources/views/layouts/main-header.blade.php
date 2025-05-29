<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">


<!--=================================
header start-->
<nav class="admin-header navbar navbar-default col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <!-- logo -->
    <div class="text-left navbar-brand-wrapper">
        {{-- <a class="navbar-brand brand-logo" href="{{ url('/dashboard') }}"><img src="{{ URL::asset('index/img/future-logo.jpg') }}" alt=""></a> --}}
        @if (isset(Auth()->user()->Grade_id))
            {{-- @forelse (\App\Models\Grade::where('id',Auth()->user()->Grade_id)->get() as $info)
                <div
                    style="display: flex; flex-direction: row-reverse; align-items: center; justify-content: space-between;">
                    <h3 style="margin: 10px 0 0 0;">{{ $info->Name }}</h3>
                    <a class="navbar-brand brand-logo-mini" href="{{ route('dashboard.Students') }}"><img
                            src="{{ URL::asset('attachments/logo/' . $info->file_name) }}" alt=""></a>
                </div>
            @empty
            @endforelse --}}
        @else
            <div
                style="display: flex; flex-direction: row-reverse; align-items: center; justify-content: center;">
                
                <a class="navbar-brand brand-logo-mini" href="{{ url('/dashboard') }}"><img
                        src="{{ URL::asset('attachments/img/logo_sadaqa.png') }}" width="150px" height="70%" alt=""></a>
            </div>
            
        @endif


    </div>
    <!-- Top bar left -->
    <ul class="nav navbar-nav mr-auto" style="align-items: center;">
        <li class="nav-item">
            <a id="button-toggle" class="button-toggle-nav inline-block ml-20 pull-left" href="javascript:void(0);"><i
                    class="zmdi zmdi-menu ti-align-right"></i></a>
        </li>
        {{-- <li class="nav-item">
            <div class="search">
                <a class="search-btn not_click" href="javascript:void(0);"></a>
                <div class="search-box not-click">
                    <input type="text" class="not-click form-control" placeholder="Search" value=""
                        name="search">
                    <button class="search-button" type="submit"> <i class="fa fa-search not-click"></i></button>
                </div>
            </div>
        </li> --}}
        <li class="nav-item fullscreen">
            <a id="btnFullscreen" href="#" class="nav-link"><i class="ti-fullscreen"></i></a>
        </li>
    </ul>
    <!-- top bar right -->
    <ul class="nav navbar-nav ml-auto" style="align-items: center;">

        {{-- <div class="btn-group mb-1">
            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              @if (App::getLocale() == 'ar')
              {{ LaravelLocalization::getCurrentLocaleName() }}
             <img src="{{ URL::asset('assets/images/flags/libya.png') }}" alt="" width="23px">
              @else
              {{ LaravelLocalization::getCurrentLocaleName() }}
              <img src="{{ URL::asset('assets/images/flags/US.png') }}" alt="">
              @endif
              </button>
            <div class="dropdown-menu">
                @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                            {{ $properties['native'] }}
                        </a>
                @endforeach
            </div>
        </div> --}}

       













        <li class="nav-item">
            
                <h5 style="color: #fff">{{ Auth()->user()->name }}</h5>
            
        </li>

        <li class="nav-item dropdown mr-30">
            <a class="nav-link nav-pill user-avatar" data-toggle="dropdown" href="#" role="button"
                aria-haspopup="true" aria-expanded="false">
                
                <img src="{{ URL::asset('assets/images/admin33.png') }}" alt="avatar">
                    

                


            </a>
            <div class="dropdown-menu dropdown-menu-right">
                {{-- <div class="dropdown-header">
                    <div class="media">
                        <div class="media-body">
                            <h5 class="mt-0 mb-0">{{ Auth::user()->name }}</h5>
                            <span>{{ Auth::user()->email }}</span>
                        </div>
                    </div>
                </div> --}}
                {{-- <div class="dropdown-divider"></div> --}}
                {{-- <a class="dropdown-item" href="#"><i class="text-secondary ti-reload"></i>Activity</a> --}}
                
                    <a class="dropdown-item" href="{{ route('Admin_Profile.index') }}"><i class="fa-solid fa-user"></i>الملف الشخصي</a>
               


                {{-- <a class="dropdown-item" href="#"><i class="text-dark ti-layers-alt"></i>Projects <span
                        class="badge badge-info">6</span> </a> --}}
                <div class="dropdown-divider"></div>

                
                    {{-- <a class="dropdown-item" href=""><i
                            class="text-info ti-settings"></i>الإعدادات</a> --}}
               

                
                    {{-- <form method="GET" action="{{ route('logout', 'student') }}">
                    @elseif(auth('teacher')->check())
                        <form method="GET" action="{{ route('logout', 'teacher') }}">
                        @elseif(auth('parent')->check())
                            <form method="GET" action="{{ route('logout', 'parent') }}">
                            @else
                                <form method="GET" action="{{ route('logout', 'web') }}"> --}}
                <form action="{{route('logout')}}" method="post">

                @csrf
                <a class="dropdown-item" href="{{route('logout')}}"
                    onclick="event.preventDefault();this.closest('form').submit();"><i class="fa-solid fa-right-from-bracket"></i>تسجيل
                    الخروج</a>
                </form>

            </div>
        </li>
    </ul>
</nav>

<!--=================================
header End-->
