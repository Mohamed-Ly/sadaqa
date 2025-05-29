@extends('layouts.master')
@section('css')

@section('title')
    إدارة المستخدمين
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
    إدارة المستخدمين
@stop
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">


    @if ($errors->any())
        <div class="error">{{ $errors->first('Name') }}</div>
    @endif



    <div class="col-xl-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <button type="button" class="button x-small"  data-toggle="modal"
                    data-target="#exampleModal">
                    {{ 'إضافة مستخدم' }}
                </button>
                <br><br>

                <div class="table-responsive">
                    <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
                        style="text-align: center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ 'الإسم' }}</th>
                                <th>{{ 'رقم الهاتف' }}</th>
                                <th>{{ 'العمليات' }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->phone }}</td>

                                    <td>
                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                            data-target="#edit{{ $user->id }}"
                                            title="{{ trans('Grades_trans.Edit') }}"><i
                                                class="fa fa-edit"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#delete{{ $user->id }}"
                                            title="{{ trans('Grades_trans.Delete') }}"><i
                                                class="fa fa-trash"></i></button>
                                    </td>
                                </tr>

                                <!-- edit_modal_Grade -->
                                <div class="modal fade" id="edit{{ $user->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                    id="exampleModalLabel">
                                                    {{ 'تعديل بيانات المستخدم' . ' ' . $user->name }}
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- add_form -->
                                                <form action="{{ route('Admin_Users.update', 'test') }}"
                                                    method="post">
                                                    {{ method_field('patch') }}
                                                    @csrf
                                                    <input type="hidden" value="{{ $user->id }}" name="id">

                                                    <div class="row">
                                                        <div class="col">
                                                            <label for="Name" class="mr-sm-2">الإسم
                                                                : <span class="text-danger">*</span></label>
                                                            <input id="Name" required type="text"
                                                                value="{{ $user->name }}" name="name"
                                                                class="form-control">
                                                        </div>

                                                       

                                                    </div>
                                                    <br>


                                                    <div class="row">
                                                        <div class="col">
                                                            <label for="Name" class="mr-sm-2">رقم الهاتف
                                                                : <span class="text-danger">*</span></label>
                                                            <input id="Name" required value="{{ $user->phone }}"
                                                                type="number" name="phone" class="form-control">
                                                        </div>

                                                       

                                                    </div>
                                                    <br>

                                                    



                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger"
                                                            data-dismiss="modal">{{ 'إلغاء' }}</button>
                                                        <button type="submit" class="btn"
                                                            style="background: #957958;color:#fff">{{ 'تعديل' }}</button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- delete_modal_Grade -->
                                <div class="modal fade" id="delete{{ $user->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                    id="exampleModalLabel">
                                                    {{ 'حذف المستخدم' . ' ' . $user->name }}
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('Admin_Users.destroy', 'test') }}"
                                                    method="post">
                                                    {{ method_field('Delete') }}
                                                    @csrf
                                                    {{ trans('هل انت متاكد من عملية الحذف ؟') }}
                                                    <input id="id" type="hidden" name="id"
                                                        class="form-control" value="{{ $user->id }}">


                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">{{ trans('إلغاء') }}</button>
                                                        <button type="submit"
                                                            class="btn btn-danger">{{ trans('حذف') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- add_modal_Grade -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                        {{ 'إضافة موظف جديد' }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- add_form -->
                    <form action="{{ route('Admin_Users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <label for="Name" class="mr-sm-2">الإسم
                                    : <span class="text-danger">*</span></label>
                                <input id="Name" required type="text" name="name" class="form-control">
                            </div>


                        </div>
                        <br>


                        <div class="row">
                            <div class="col">
                                <label for="Name" class="mr-sm-2">رقم الهاتف
                                    : <span class="text-danger">*</span></label>
                                <input id="Name" required type="number" placeholder="091xxxxxxx" name="phone" class="form-control">
                            </div>

                        </div>
                        <br>



                        <div class="row">
                            <div class="col">
                                <label for="Name" class="mr-sm-2">كلمة السر
                                    : <span class="text-danger">*</span></label>
                                <input id="Name" required type="password" name="password" class="form-control">
                            </div>
                        </div>
                        <br>

                        <div class="row">

                            <div class="col">
                                <label for="Name" class="mr-sm-2">تأكيد كلمة السر
                                    : <span class="text-danger">*</span></label>
                                <input id="Name" required type="password" name="confirm_password"
                                    class="form-control">
                            </div>

                        </div>
                        <br>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger"
                                data-dismiss="modal">{{ 'إلغاء' }}</button>
                            <button type="submit" class="btn"
                                style="background: #957958;color:#fff">{{ 'إضافة' }}</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>

    <!-- row closed -->
@endsection
@section('js')
    {{-- @toastr_js
    @toastr_render --}}
@endsection
