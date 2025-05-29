@extends('layouts.master')
@section('css')

@section('title')
    الملف الشخصي
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
    الملف الشخصي
@stop
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->



<div class="card-body">

    <section style="background-color: #eee;">
        <div class="row">
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <img src="{{ URL::asset('assets/images/admin33.png') }}" alt="avatar"
                            class="rounded-circle img-fluid" style="width: 150px;">
                        <h5 style="font-family: Cairo" class="my-3">{{ $information->Name }}</h5>
                        <p class="text-muted mb-1">{{ $information->email }}</p>
                        <p class="text-muted mb-4">{{ $information->roole }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <form action="{{ route('Admin_Profile.update', $information->id) }}" method="post">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">البيانات الشخصية</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">
                                        <label for="">الأسم</label>
                                        <input type="text" name="Name_ar" value="{{ $information->name }}"
                                            class="form-control">
                                    </p>
                                </div>
                            </div>


                        
                    </div>

                </div>
                <div class="card mb-4">

                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">بيانات الأمان</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">
                                    <label for="">كلمة السر الحالية</label>
                                    <input type="password" id="password" class="form-control" name="password">
                                </p><br>
                                {{-- <input type="checkbox" class="form-check-input" onclick="myFunction()"
                                    id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">اظهار كلمة المرور</label> --}}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-3">
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">
                                    <label for="">كلمة السر الجديدة</label>
                                    <input type="password" id="password" class="form-control" name="confirm_password">
                                </p><br>
                                {{-- <input type="checkbox" class="form-check-input" onclick="myFunction()"
                                    id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">اظهار كلمة المرور</label> --}}
                            </div>
                        </div>
                    </div>

                </div>
                <button type="submit" class="button x-small" >تحديث
                    البيانات</button>
            </div>
        </div>
        </form>
    </section>
</div>
<!-- row closed -->
@endsection
@section('js')

{{-- @toastr_render --}}
<script>
    function myFunction() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>
@endsection
