@extends('layouts.master')
@section('css')

@section('title')
    إدارة الأدوار والصلاحيات
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
    إدارة الأدوار والصلاحيات
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
                    {{ 'إضافة دور وتحديد صلاحياتة' }}
                </button>
                <br><br>

                <div class="table-responsive">
                    <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
                        style="text-align: center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ 'الدور' }}</th>
                                <th>{{ 'الصلاحيات' }}</th>
                                <th>{{ 'العمليات' }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $role->name }}</td>



                                    <td>
                                        {{-- <textarea name="" id="" class="form-control" cols="20" rows="1">
                                        @foreach ($role->permissions as $permission)
                                        {{ $permission->name }}
                                        @endforeach
                                        </textarea> --}}

                                        {{-- <textarea name="" id="" class="form-control" cols="20" rows="1"> --}}
                                        {{-- </textarea> --}}
                                        {{-- <div class="col">

                                            <div class="form-group"
                                                style="max-height: 200px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; border-radius: 4px;">
                                                @foreach ($role->permissions as $permission)
                                                    <button class="btn btn-info btn-sm">{{ $permission->name  }}</button>
                                                @endforeach
                                            </div>
                                        </div> --}}
                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                            data-target="#permission{{ $role->id }}"
                                            ><i
                                                class="fa fa-key"></i>{{' الصلاحيات الممنوحة ' .' '. count($role->permissions)}}</button>


                                    </td>


                                    <td>
                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                            data-target="#edit{{ $role->id }}"
                                            title="{{ trans('Grades_trans.Edit') }}"><i
                                                class="fa fa-edit"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#delete{{ $role->id }}"
                                            title="{{ trans('Grades_trans.Delete') }}"><i
                                                class="fa fa-trash"></i></button>
                                    </td>
                                </tr>

                                <!-- edit_modal_Grade -->
                                <div class="modal fade" id="edit{{ $role->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                    id="exampleModalLabel">
                                                    {{ 'تعديل البيانات' }}
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- add_form -->
                                                <form action="{{ route('Admin_RoleAndPerimissions.update', 'test') }}"
                                                    method="post">
                                                    {{ method_field('patch') }}
                                                    @csrf
                                                    <input type="hidden" value="{{ $role->id }}" name="id">

                                                    <div class="row">
                                                        <div class="col">
                                                            <label for="Name" class="mr-sm-2">الدور
                                                                : <span class="text-danger">*</span></label>
                                                            <input id="Name" value="{{ $role->name }}"
                                                                type="text" name="role" class="form-control">
                                                        </div>

                                                    </div>
                                                    <br>





                                                    <div class="col">
                                                        <label class="control-label">{{ 'الصلاحيات' }} : <span
                                                                class="text-danger">*</span></label>
                                                        <div class="form-group"
                                                            style="max-height: 200px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; border-radius: 4px;">
                                                            @if ($permissions->count() > 0)
                                                                @foreach (Spatie\Permission\Models\Permission::all() as $value)
                                                                    <div class="form-check">
                                                                        <input type="checkbox" name="permission[]"
                                                                            @foreach ($role->permissions as $permission)
                                                                            @if ($permission->id == $value->id)
                                                                            checked
                                                                            @endif @endforeach
                                                                            id="permission_{{ $value->id }}"
                                                                            value="{{ $value->name }}"
                                                                            class="form-check-input"
                                                                            {{ old('permission') && in_array($value->name, old('permission')) ? 'checked' : '' }}>
                                                                        <label class="form-check-label"
                                                                            for="permission_{{ $value->id }}">
                                                                            {{ $value->name }}
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            @else
                                                                <div class="alert alert-warning">لا توجد صلاحيات متاحة
                                                                </div>
                                                            @endif
                                                        </div>
                                                        @error('permission')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
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
                                <div class="modal fade" id="delete{{ $role->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                    id="exampleModalLabel">

                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form
                                                    action="{{ route('Admin_RoleAndPerimissions.destroy', 'test') }}"
                                                    method="post">
                                                    {{ method_field('Delete') }}
                                                    @csrf
                                                    {{ trans('هل انت متاكد من عملية الحذف ؟') }}
                                                    <input id="id" type="hidden" name="id"
                                                        class="form-control" value="{{ $role->id }}">


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

                                    <div class="modal fade" id="permission{{ $role->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                    id="exampleModalLabel">
                                                {{ 'الصلاحيات الممنوحة لي ' . $role->name }}
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                
                                            @foreach($role->permissions as $permission)
                                                <span class="d-block p-1">
                                                    <i class="fas fa-check-circle text-success mr-1"></i>
                                                    {{ $permission->name }}
                                                </span>
                                            @endforeach
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger"
                                                            data-dismiss="modal">{{ trans('إغلاق') }}</button>
                                                    </div>
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
                    <h5 class="modal-title" style="font-family: 'Cairo', sans-serif;" id="exampleModalLabel">
                        {{ 'إضافة دور وتحديد صلاحياتة' }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="{{ route('Admin_RoleAndPerimissions.store') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col">
                                <label for="Name" class="mr-sm-2">الدور
                                    : <span class="text-danger">*</span></label>
                                <input id="Name" type="text" name="role" class="form-control">
                            </div>

                        </div>
                        <br>




                        <div class="col">
                            <label class="control-label">{{ 'الصلاحيات' }} : <span
                                    class="text-danger">*</span></label>
                            <div class="form-group"
                                style="max-height: 200px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; border-radius: 4px;">
                                @if ($permissions->count() > 0)
                                    @foreach (Spatie\Permission\Models\Permission::all() as $permission)
                                        <div class="form-check">
                                            <input type="checkbox" name="permission[]"
                                                id="permission_{{ $permission->id }}"
                                                value="{{ $permission->name }}" class="form-check-input"
                                                {{ old('permission') && in_array($permission->name, old('permission')) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="alert alert-warning">لا توجد صلاحيات متاحة</div>
                                @endif
                            </div>
                            @error('permission')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">{{ 'إلغاء' }}</button>
                    <button type="submit" class="btn"
                        style="background: #957958;color:#fff">{{ 'إضافة' }}</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- row closed -->
@endsection
@section('js')
    {{-- @toastr_js
    @toastr_render --}}
@endsection
