<div class="scrollbar side-menu-bg" style="overflow: scroll">
    <ul class="nav navbar-nav side-menu" id="sidebarnav">
        <!-- menu item Dashboard-->
        <li>
            <a href="{{ url('dashboard') }}">
                <div class="pull-left"><i class="fa-solid fa-house"></i><span class="right-nav-text">لوحة تحكم</span>
                </div>
                <div class="clearfix"></div>
            </a>
        </li>
        <!-- menu title -->
        <li class="mt-10 mb-10 text-muted pl-4 font-medium menu-title">صدقة</li>



        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#donation">
                <div class="pull-left"><i class="fa fa-cubes"></i></i><span class="right-nav-text">إدارة الصدقات (<span class="text-danger">{{App\Models\Donation::where('approval_status','pending')->count()}}</span>) </span>
                </div>
                <div class="pull-right"><i class="ti-plus" style="color: #222;"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="donation" class="collapse" data-parent="#sidebarnav">
                <li> <a href="{{ route('Admin_Donation.index') }}">صدقات قيد الإنتظار (<span class="text-danger">{{App\Models\Donation::where('approval_status','pending')->count()}}</span>)</a> </li>
                <li> <a href="{{ route('Admin_Donation.show','test') }}"> الصدقات المكتملة</a> </li>
                <li> <a href="{{ route('Admin_Donation.create') }}"> الصدقات الملغية</a> </li>

            </ul>
        </li>



        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#users">
                <div class="pull-left"><i class="fa fa-users"></i></i><span class="right-nav-text">المستخدمين </span>
                </div>
                <div class="pull-right"><i class="ti-plus" style="color: #222;"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="users" class="collapse" data-parent="#sidebarnav">
                <li> <a href="{{ route('Admin_Users.index') }}">إدارة المستخدمين</a> </li>

            </ul>
        </li>



        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#Admin_RoleAndPerimissions">
                <div class="pull-left"><i class="fa fa-universal-access"></i></i><span class="right-nav-text">الأدوار
                        والصلاحيات </span></div>
                <div class="pull-right"><i class="ti-plus" style="color: #222;"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="Admin_RoleAndPerimissions" class="collapse" data-parent="#sidebarnav">
                <li> <a href="{{ route('Admin_RoleAndPerimissions.index') }}">إدارة الأدوار والصلاحيات</a> </li>

            </ul>
        </li>

                <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#employees">
                <div class="pull-left"><i class="fa fa-users"></i></i><span class="right-nav-text">الموظفين </span>
                </div>
                <div class="pull-right"><i class="ti-plus" style="color: #222;"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="employees" class="collapse" data-parent="#sidebarnav">
                <li> <a href="{{ route('Admin_Employees.index') }}">إدارة الموظفين</a> </li>

            </ul>
        </li>


    </ul>
</div>
