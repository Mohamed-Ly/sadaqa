@extends('layouts.master')
@section('css')
    <!-- Lightbox CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
    <style>
        .gallery-img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            transition: transform 0.3s;
            cursor: pointer;
        }

        .gallery-img:hover {
            transform: scale(1.02);
        }

        @media (max-width: 576px) {
            .modal-dialog {
                margin: 0;
                width: 100%;
                max-width: 100%;
                height: 100%;
            }

            .modal-content {
                height: 100%;
                border-radius: 0;
            }

            .modal-body {
                overflow-y: auto;
                -webkit-overflow-scrolling: touch;
            }

            .gallery-img {
                height: 120px;
            }

            .col-md-4 {
                padding: 5px;
            }
        }
    </style>

@section('title')
    إدارة الصدقات
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
    إدارة الصدقات
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



                <div class="table-responsive">
                    <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
                        style="text-align: center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ 'الإسم' }}</th>
                                <th>{{ 'عنوان الصدقة' }}</th>
                                <th>{{ 'وصف الصدقة' }}</th>
                                <th>{{ 'عدد المستفيدين' }}</th>
                                <th>{{ 'المدينة' }}</th>
                                <th>{{ 'المنطقة' }}</th>
                                <th>{{ 'رقم الهاتف' }}</th>
                                <th>{{ 'رقم الهاتف الإحتياطي' }}</th>
                                <th>{{ 'صور الصدقة' }}</th>
                                <th>{{ 'حالة الصدقة' }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Donations as $Donation)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $Donation->user->name }}</td>
                                    <td>{{ $Donation->title }}</td>
                                    <td>
                                        <textarea class="form-control" name="" id="" cols="30" rows="1">{{ $Donation->description }}</textarea>
                                    </td>
                                    <td>{{ $Donation->Number_beneficiaries }}</td>
                                    <td>{{ $Donation->city }}</td>
                                    <td>{{ $Donation->state }}</td>
                                    <td>{{ $Donation->phoen }}</td>
                                    <td>{{ $Donation->backup_number }}</td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm show-images-btn"
                                            data-donation-id="{{ $Donation->id }}" data-toggle="modal"
                                            data-target="#imagesModal">
                                            عرض الصور
                                        </button>
                                    </td>
                                    <td><button type="button" class="btn btn-success btn-sm">مقبولة</button></td>



                                </tr>



                                <!-- Modal to show images -->
                                <div class="modal fade" id="imagesModal" tabindex="-1" role="dialog"
                                    aria-labelledby="imagesModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="imagesModalLabel">صور الصدقة</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body p-0" id="modalImagesBody">
                                                <!-- Images will be loaded here via AJAX -->
                                            </div>
                                            <div class="modal-footer py-2">
                                                <button type="button" class="btn btn-secondary btn-sm"
                                                    data-dismiss="modal">إغلاق</button>
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




    <!-- row closed -->
    @section('js')
        <!-- Lightbox JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

        <script>
            $(document).ready(function() {
                // إعدادات lightbox
                lightbox.option({
                    'resizeDuration': 200,
                    'wrapAround': true,
                    'albumLabel': 'صورة %1 من %2',
                    'fadeDuration': 300,
                    'disableScrolling': true,
                    'positionFromTop': 50,
                    'alwaysShowNavOnTouchDevices': true
                });

                $('.show-images-btn').on('click', function() {
                    var donationId = $(this).data('donation-id');
                    var modalBody = $('#modalImagesBody');

                    modalBody.html(`
                    <div class="d-flex justify-content-center align-items-center" style="height: 200px;">
                        <div class="text-center">
                            <i class="fas fa-spinner fa-spin fa-2x"></i>
                            <p class="mt-2">جاري تحميل الصور...</p>
                        </div>
                    </div>
                `);

                    $.ajax({
                        url: '/donations/' + donationId + '/images',
                        method: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            if (response.success && response.images.length > 0) {
                                var html = '<div class="row gallery mx-0">';
                                response.images.forEach(function(image, index) {
                                    html += `
                                <div class="col-6 col-md-4 col-lg-3 p-1">
                                    <a href="${image.path}" data-lightbox="donation-${donationId}" 
                                       data-title="${image.original_name || 'صورة التبرع'}" class="d-block">
                                        <img src="${image.path}" 
                                             class="img-fluid rounded gallery-img"
                                             alt="${image.original_name || 'صورة التبرع'}"
                                             loading="lazy">
                                    </a>
                                </div>`;
                                });
                                html += '</div>';
                                modalBody.html(html);

                                // فتح أول صورة تلقائياً بعد تحميلها
                                if (response.images.length > 0) {
                                    setTimeout(function() {
                                        $('[data-lightbox="donation-' + donationId + '"]')
                                            .first().trigger('click');
                                    }, 300);
                                }
                            } else {
                                modalBody.html(`
                                <div class="d-flex justify-content-center align-items-center" style="height: 200px;">
                                    <div class="text-center">
                                        <i class="far fa-image fa-2x text-muted"></i>
                                        <p class="mt-2">لا توجد صور متاحة</p>
                                    </div>
                                </div>
                            `);
                            }
                        },
                        error: function() {
                            modalBody.html(`
                            <div class="d-flex justify-content-center align-items-center" style="height: 200px;">
                                <div class="alert alert-danger text-center m-0">
                                    حدث خطأ أثناء تحميل الصور
                                </div>
                            </div>
                        `);
                        }
                    });
                });

                // إغلاق المودال عند النقر خارج المحتوى على الهاتف
                $('#imagesModal').on('click', function(e) {
                    if ($(window).width() < 768 && $(e.target).hasClass('modal')) {
                        $(this).modal('hide');
                    }
                });
            });
        </script>
    @endsection
