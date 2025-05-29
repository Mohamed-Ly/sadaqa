<!DOCTYPE html>
<html lang="ar" dir="rtl">
@section('title')
    {{ config('app.name') }}
@stop

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="HTML5 Template" />
    <meta name="description" content="لوحة تحكم نظام الصدقات" />
    <meta name="author" content="yourcompany.com" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="icon" type="image/x-icon" href="{{ URL::asset('attachments/logo/icoon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" rel="stylesheet">

    @include('layouts.head')
    <style>
        .stat-card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border: none;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            font-size: 2.2rem;
            opacity: 0.8;
        }

        .chart-container {
            position: relative;
            height: 100%;
            min-height: 400px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            padding: 20px;
        }

        .section-title {
            position: relative;
            padding-bottom: 15px;
            margin-bottom: 25px;
            font-weight: 700;
            color: #2c3e50;
        }

        .section-title:after {
            content: "";
            position: absolute;
            bottom: 0;
            right: 0;
            width: 80px;
            height: 4px;
            background: linear-gradient(45deg, #6c5ce7, #a29bfe);
            border-radius: 2px;
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .stat-period {
            font-size: 0.8rem;
            color: #6c757d;
        }

        .period-tabs .nav-link {
            color: #495057;
            font-weight: 600;
            border: none;
            padding: 8px 15px;
        }

        .period-tabs .nav-link.active {
            color: #6c5ce7;
            background: transparent;
            border-bottom: 3px solid #6c5ce7;
        }
        
        .loading-chart {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            font-family: 'Cairo', sans-serif;
            font-size: 16px;
            color: #6c757d;
        }
        
        .top-donors-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-left: 10px;
        }
    </style>
</head>

<body style="font-family: 'Cairo', sans-serif">

    <div class="wrapper" style="font-family: 'Cairo', sans-serif">

        <!-- Preloader -->
        <div id="pre-loader">
            <img src="{{ URL::asset('assets/images/pre-loader/loader-02.svg') }}" alt="">
        </div>

        @include('layouts.main-header')
        @include('layouts.main-sidebar')

        <!-- Main content -->
        <div class="content-wrapper">
            <div class="page-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h4 class="mb-0" style="font-family: 'Cairo', sans-serif">لوحة تحكم نظام الصدقات</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right">
                        </ol>
                    </div>
                </div>
            </div>

            <!-- الإحصائيات السريعة -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stat-card border-left-primary">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="stat-label">إجمالي الصدقات</h5>
                                    <h2 class="stat-value text-primary">{{ App\Models\Donation::count() }}</h2>
                                </div>
                                <i class="bi bi-gift stat-icon text-primary"></i>
                            </div>
                            <div class="mt-3 d-flex justify-content-between text-center">
                                <div>
                                    <h6 class="mb-0">
                                        {{ App\Models\Donation::whereDate('created_at', today())->count() }}</h6>
                                    <small class="stat-period">اليوم</small>
                                </div>
                                <div>
                                    <h6 class="mb-0">
                                        {{ App\Models\Donation::whereMonth('created_at', now()->month)->count() }}</h6>
                                    <small class="stat-period">هذا الشهر</small>
                                </div>
                                <div>
                                    <h6 class="mb-0">
                                        {{ App\Models\Donation::whereYear('created_at', now()->year)->count() }}</h6>
                                    <small class="stat-period">هذه السنة</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stat-card border-left-success">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="stat-label">إجمالي المستفيدين</h5>
                                    <h2 class="stat-value text-success">{{ App\Models\DonationRequest::count() }}</h2>
                                </div>
                                <i class="bi bi-list-check stat-icon text-success"></i>
                            </div>
                            <div class="mt-3 d-flex justify-content-between text-center">
                                <div>
                                    <h6 class="mb-0">
                                        {{ App\Models\DonationRequest::whereDate('created_at', today())->count() }}</h6>
                                    <small class="stat-period">اليوم</small>
                                </div>
                                <div>
                                    <h6 class="mb-0">
                                        {{ App\Models\DonationRequest::whereMonth('created_at', now()->month)->count() }}
                                    </h6>
                                    <small class="stat-period">هذا الشهر</small>
                                </div>
                                <div>
                                    <h6 class="mb-0">
                                        {{ App\Models\DonationRequest::whereYear('created_at', now()->year)->count() }}
                                    </h6>
                                    <small class="stat-period">هذه السنة</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stat-card border-left-info">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="stat-label">حالات الصدقات</h5>
                                    <h2 class="stat-value text-info">
                                        {{ App\Models\Donation::where('approval_status', 'pending')->count() }}</h2>
                                </div>
                                <i class="bi bi-hourglass-split stat-icon text-info"></i>
                            </div>
                            <div class="mt-3 d-flex justify-content-between text-center">
                                <div>
                                    <h6 class="mb-0">
                                        {{ App\Models\Donation::where('approval_status', 'approved')->count() }}</h6>
                                    <small class="stat-period">مقبولة</small>
                                </div>
                                <div>
                                    <h6 class="mb-0">
                                        {{ App\Models\Donation::where('approval_status', 'rejected')->count() }}</h6>
                                    <small class="stat-period">مرفوضة</small>
                                </div>
                                <div>
                                    <h6 class="mb-0">{{ App\Models\Donation::where('status', 'completed')->count() }}
                                    </h6>
                                    <small class="stat-period">مكتملة</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stat-card border-left-warning">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="stat-label">المستخدمين والمسؤولين</h5>
                                    <h2 class="stat-value text-warning">{{ App\Models\User::count() }}</h2>
                                </div>
                                <i class="bi bi-people stat-icon text-warning"></i>
                            </div>
                            <div class="mt-3 d-flex justify-content-between text-center">
                                <div>
                                    <h6 class="mb-0">{{ App\Models\User::where('roole', 'مستخدم')->count() }}</h6>
                                    <small class="stat-period">مستخدمين</small>
                                </div>
                                <div>
                                    <h6 class="mb-0">{{ App\Models\User::where('roole', '!=', 'مستخدم')->count() }}
                                    </h6>
                                    <small class="stat-period">مسؤولين</small>
                                </div>
                                <div>
                                    <h6 class="mb-0">
                                        {{ App\Models\User::whereMonth('created_at', now()->month)->count() }}</h6>
                                    <small class="stat-period">جدد هذا الشهر</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- المخططات البيانية -->
            {{-- <div class="row mb-4">
                <div class="col-12">
                    <h5 class="section-title">الإحصائيات التفصيلية</h5>
                </div>

                <div class="col-lg-8 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs period-tabs" id="chartTabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="monthly-tab" data-toggle="tab" href="#monthly"
                                        role="tab">شهري</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="weekly-tab" data-toggle="tab" href="#weekly"
                                        role="tab">أسبوعي</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="daily-tab" data-toggle="tab" href="#daily"
                                        role="tab">يومي</a>
                                </li>
                            </ul>
                            <div class="tab-content pt-3">
                                <div class="tab-pane fade show active" id="monthly" role="tabpanel">
                                    <div class="chart-container" style="position: relative; height:400px;">
                                        <div class="loading-chart">
                                            <i class="bi bi-arrow-repeat spinner"></i> جاري تحميل البيانات...
                                        </div>
                                        <canvas id="monthlyChart"></canvas>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="weekly" role="tabpanel">
                                    <div class="chart-container" style="position: relative; height:400px;">
                                        <div class="loading-chart">
                                            <i class="bi bi-arrow-repeat spinner"></i> جاري تحميل البيانات...
                                        </div>
                                        <canvas id="weeklyChart"></canvas>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="daily" role="tabpanel">
                                    <div class="chart-container" style="position: relative; height:400px;">
                                        <div class="loading-chart">
                                            <i class="bi bi-arrow-repeat spinner"></i> جاري تحميل البيانات...
                                        </div>
                                        <canvas id="dailyChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">أكثر المتبرعين نشاطاً</h5>
                            <div class="chart-container" style="position: relative; height:400px;">
                                <div class="loading-chart">
                                    <i class="bi bi-arrow-repeat spinner"></i> جاري تحميل البيانات...
                                </div>
                                <canvas id="topDonorsChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

            <!-- آخر الصدقات والطلبات -->
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">آخر الصدقات المضافة</h5>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>عنوان الصدقة</th>
                                            <th>الحالة</th>
                                            <th>التاريخ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (App\Models\Donation::latest()->take(5)->get() as $donation)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ Str::limit($donation->title, 25) }}</td>
                                                <td>
                                                    @if ($donation->approval_status == 'approved')
                                                        <span class="badge badge-success">مقبولة</span>
                                                    @elseif($donation->approval_status == 'pending')
                                                        <span class="badge badge-warning">قيد المراجعة</span>
                                                    @else
                                                        <span class="badge badge-danger">مرفوضة</span>
                                                    @endif
                                                </td>
                                                <td>{{ $donation->created_at->diffForHumans() }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">آخر طلبات الصدقات</h5>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>المستخدم</th>
                                            <th>الحالة</th>
                                            <th>التاريخ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (App\Models\DonationRequest::with('user')->latest()->take(5)->get() as $request)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $request->user->name ?? 'مستخدم محذوف' }}</td>
                                                <td>
                                                    @if ($request->status == 'approved')
                                                        <span class="badge badge-success">مقبولة</span>
                                                    @elseif($request->status == 'pending')
                                                        <span class="badge badge-warning">قيد المراجعة</span>
                                                    @else
                                                        <span class="badge badge-danger">مرفوضة</span>
                                                    @endif
                                                </td>
                                                <td>{{ $request->created_at->diffForHumans() }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @include('layouts.footer')
        </div><!-- main content wrapper end-->

        @include('layouts.footer-scripts')

        {{-- @section('js')
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // إعدادات عامة للمخططات
                    Chart.defaults.font.family = "'Cairo', sans-serif";
                    Chart.defaults.font.size = 12;
                    
                    // تحميل البيانات عند فتح التبويب
                    $('#chartTabs a').on('shown.bs.tab', function (e) {
                        const target = $(e.target).attr("href");
                        
                        if (target === '#monthly') {
                            loadMonthlyData();
                        } else if (target === '#weekly') {
                            loadWeeklyData();
                        } else if (target === '#daily') {
                            loadDailyData();
                        }
                    });
                    
                    // تحميل البيانات الأولية
                    loadMonthlyData();
                    loadTopDonorsData();
                });

                // دالة لتحميل البيانات الشهرية
                function loadMonthlyData() {
                    const container = document.getElementById('monthlyChart').parentElement;
                    const loader = container.querySelector('.loading-chart');
                    const canvas = container.querySelector('canvas');
                    
                    loader.style.display = 'flex';
                    canvas.style.display = 'none';
                    
                    axios.get('/api/dashboard/monthly-stats')
                        .then(response => {
                            const data = response.data;
                            renderMonthlyChart(data);
                            loader.style.display = 'none';
                            canvas.style.display = 'block';
                            window.monthlyChartLoaded = true;
                        })
                        .catch(error => {
                            console.error('Error loading monthly data:', error);
                            loader.innerHTML = 'حدث خطأ أثناء تحميل البيانات.';
                            // عرض بيانات افتراضية في حالة الخطأ
                            renderMonthlyChart(getDefaultMonthlyData());
                            loader.style.display = 'none';
                            canvas.style.display = 'block';
                        });
                }
                
                // دالة لتحميل البيانات الأسبوعية
                function loadWeeklyData() {
                    const container = document.getElementById('weeklyChart').parentElement;
                    const loader = container.querySelector('.loading-chart');
                    const canvas = container.querySelector('canvas');
                    
                    loader.style.display = 'flex';
                    canvas.style.display = 'none';
                    
                    axios.get('/api/dashboard/weekly-stats')
                        .then(response => {
                            const data = response.data;
                            renderWeeklyChart(data);
                            loader.style.display = 'none';
                            canvas.style.display = 'block';
                            window.weeklyChartLoaded = true;
                        })
                        .catch(error => {
                            console.error('Error loading weekly data:', error);
                            loader.innerHTML = 'حدث خطأ أثناء تحميل البيانات.';
                            // عرض بيانات افتراضية في حالة الخطأ
                            renderWeeklyChart(getDefaultWeeklyData());
                            loader.style.display = 'none';
                            canvas.style.display = 'block';
                        });
                }
                
                // دالة لتحميل البيانات اليومية
                function loadDailyData() {
                    const container = document.getElementById('dailyChart').parentElement;
                    const loader = container.querySelector('.loading-chart');
                    const canvas = container.querySelector('canvas');
                    
                    loader.style.display = 'flex';
                    canvas.style.display = 'none';
                    
                    axios.get('/api/dashboard/daily-stats')
                        .then(response => {
                            const data = response.data;
                            renderDailyChart(data);
                            loader.style.display = 'none';
                            canvas.style.display = 'block';
                            window.dailyChartLoaded = true;
                        })
                        .catch(error => {
                            console.error('Error loading daily data:', error);
                            loader.innerHTML = 'حدث خطأ أثناء تحميل البيانات.';
                            // عرض بيانات افتراضية في حالة الخطأ
                            renderDailyChart(getDefaultDailyData());
                            loader.style.display = 'none';
                            canvas.style.display = 'block';
                        });
                }
                
                // دالة لتحميل بيانات المتبرعين الأكثر نشاطاً
                function loadTopDonorsData() {
                    const container = document.getElementById('topDonorsChart').parentElement;
                    const loader = container.querySelector('.loading-chart');
                    const canvas = container.querySelector('canvas');
                    
                    loader.style.display = 'flex';
                    canvas.style.display = 'none';
                    
                    axios.get('/api/dashboard/top-donors')
                        .then(response => {
                            const data = response.data;
                            renderTopDonorsChart(data);
                            loader.style.display = 'none';
                            canvas.style.display = 'block';
                        })
                        .catch(error => {
                            console.error('Error loading top donors data:', error);
                            loader.innerHTML = 'حدث خطأ أثناء تحميل البيانات.';
                            // عرض بيانات افتراضية في حالة الخطأ
                            renderTopDonorsChart(getDefaultTopDonorsData());
                            loader.style.display = 'none';
                            canvas.style.display = 'block';
                        });
                }
                
                // دالة لعرض المخطط الشهري
                function renderMonthlyChart(data) {
                    const ctx = document.getElementById('monthlyChart');
                    if (!ctx) return;
                    
                    // تدمير المخطط القديم إذا كان موجوداً
                    if (window.monthlyChartInstance) {
                        window.monthlyChartInstance.destroy();
                    }
                    
                    const monthlyData = {
                        labels: data.labels,
                        datasets: [{
                                label: 'عدد الصدقات',
                                data: data.donations,
                                backgroundColor: 'rgba(108, 92, 231, 0.7)',
                                borderColor: '#6c5ce7',
                                borderWidth: 2
                            },
                            {
                                label: 'عدد الطلبات',
                                data: data.requests,
                                backgroundColor: 'rgba(0, 184, 148, 0.7)',
                                borderColor: '#00b894',
                                borderWidth: 2
                            }
                        ]
                    };
                    
                    window.monthlyChartInstance = new Chart(ctx, {
                        type: 'bar',
                        data: monthlyData,
                        options: getChartOptions('الإحصائيات الشهرية')
                    });
                }
                
                // دالة لعرض المخطط الأسبوعي
                function renderWeeklyChart(data) {
                    const ctx = document.getElementById('weeklyChart');
                    if (!ctx) return;
                    
                    // تدمير المخطط القديم إذا كان موجوداً
                    if (window.weeklyChartInstance) {
                        window.weeklyChartInstance.destroy();
                    }
                    
                    const weeklyData = {
                        labels: data.labels,
                        datasets: [{
                                label: 'عدد الصدقات',
                                data: data.donations,
                                backgroundColor: 'rgba(108, 92, 231, 0.7)',
                                borderColor: '#6c5ce7',
                                borderWidth: 2,
                                tension: 0.4
                            },
                            {
                                label: 'عدد الطلبات',
                                data: data.requests,
                                backgroundColor: 'rgba(0, 184, 148, 0.7)',
                                borderColor: '#00b894',
                                borderWidth: 2,
                                tension: 0.4
                            }
                        ]
                    };
                    
                    window.weeklyChartInstance = new Chart(ctx, {
                        type: 'line',
                        data: weeklyData,
                        options: getChartOptions('الإحصائيات الأسبوعية')
                    });
                }
                
                // دالة لعرض المخطط اليومي
                function renderDailyChart(data) {
                    const ctx = document.getElementById('dailyChart');
                    if (!ctx) return;
                    
                    // تدمير المخطط القديم إذا كان موجوداً
                    if (window.dailyChartInstance) {
                        window.dailyChartInstance.destroy();
                    }
                    
                    const dailyData = {
                        labels: data.labels,
                        datasets: [{
                            label: 'عدد الصدقات',
                            data: data.donations,
                            backgroundColor: 'rgba(108, 92, 231, 0.7)',
                            borderColor: '#6c5ce7',
                            borderWidth: 2
                        }]
                    };
                    
                    window.dailyChartInstance = new Chart(ctx, {
                        type: 'bar',
                        data: dailyData,
                        options: getChartOptions('الإحصائيات اليومية')
                    });
                }
                
                // دالة لعرض مخطط المتبرعين الأكثر نشاطاً
                function renderTopDonorsChart(data) {
                    const ctx = document.getElementById('topDonorsChart');
                    if (!ctx) return;
                    
                    // تدمير المخطط القديم إذا كان موجوداً
                    if (window.topDonorsChartInstance) {
                        window.topDonorsChartInstance.destroy();
                    }
                    
                    const backgroundColors = [
                        'rgba(108, 92, 231, 0.7)',
                        'rgba(0, 184, 148, 0.7)',
                        'rgba(253, 203, 110, 0.7)',
                        'rgba(225, 112, 85, 0.7)',
                        'rgba(157, 0, 255, 0.7)'
                    ];
                    
                    const borderColors = [
                        '#6c5ce7',
                        '#00b894',
                        '#fdcb6e',
                        '#e17055',
                        '#9d00ff'
                    ];
                    
                    const topDonorsData = {
                        labels: data.labels,
                        datasets: [{
                            label: 'عدد التبرعات',
                            data: data.values,
                            backgroundColor: backgroundColors,
                            borderColor: borderColors,
                            borderWidth: 1
                        }]
                    };
                    
                    window.topDonorsChartInstance = new Chart(ctx, {
                        type: 'bar',
                        data: topDonorsData,
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    rtl: true,
                                    titleFont: {
                                        family: "'Cairo', sans-serif"
                                    },
                                    bodyFont: {
                                        family: "'Cairo', sans-serif"
                                    },
                                    callbacks: {
                                        label: function(context) {
                                            return `عدد التبرعات: ${context.raw}`;
                                        }
                                    }
                                },
                                title: {
                                    display: true,
                                    text: 'أكثر المتبرعين نشاطاً',
                                    font: {
                                        family: "'Cairo', sans-serif",
                                        size: 16
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'عدد التبرعات',
                                        font: {
                                            family: "'Cairo', sans-serif"
                                        }
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'المتبرعون',
                                        font: {
                                            family: "'Cairo', sans-serif"
                                        }
                                    }
                                }
                            }
                        }
                    });
                }
                
                // دالة إعدادات المخططات العامة
                function getChartOptions(title) {
                    return {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                                rtl: true,
                                labels: {
                                    font: {
                                        family: "'Cairo', sans-serif",
                                        size: 12
                                    },
                                    padding: 20
                                }
                            },
                            tooltip: {
                                rtl: true,
                                titleFont: {
                                    family: "'Cairo', sans-serif"
                                },
                                bodyFont: {
                                    family: "'Cairo', sans-serif"
                                }
                            },
                            title: {
                                display: true,
                                text: title,
                                font: {
                                    family: "'Cairo', sans-serif",
                                    size: 16
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'العدد',
                                    font: {
                                        family: "'Cairo', sans-serif"
                                    }
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: title.includes('يومية') ? 'الأيام' : (title.includes('أسبوعية') ? 'الأسابيع' : 'الشهور'),
                                    font: {
                                        family: "'Cairo', sans-serif"
                                    }
                                }
                            }
                        }
                    };
                }
                
                // بيانات افتراضية في حالة فشل تحميل البيانات من الخادم
                function getDefaultMonthlyData() {
                    const months = ['يناير', 'فبراير', 'مارس', 'إبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'];
                    const currentMonth = new Date().getMonth();
                    const labels = months.slice(0, currentMonth + 1);
                    
                    const donations = [];
                    const requests = [];
                    
                    for (let i = 0; i < labels.length; i++) {
                        donations.push(Math.floor(Math.random() * 50) + 10);
                        requests.push(Math.floor(Math.random() * 40) + 5);
                    }
                    
                    return {
                        labels: labels,
                        donations: donations,
                        requests: requests
                    };
                }
                
                function getDefaultWeeklyData() {
                    const weeks = ['الأسبوع 1', 'الأسبوع 2', 'الأسبوع 3', 'الأسبوع 4'];
                    const currentWeek = Math.min(3, Math.floor(new Date().getDate() / 7));
                    const labels = weeks.slice(0, currentWeek + 1);
                    
                    const donations = [];
                    const requests = [];
                    
                    for (let i = 0; i < labels.length; i++) {
                        donations.push(Math.floor(Math.random() * 30) + 15);
                        requests.push(Math.floor(Math.random() * 25) + 10);
                    }
                    
                    return {
                        labels: labels,
                        donations: donations,
                        requests: requests
                    };
                }
                
                function getDefaultDailyData() {
                    const days = [];
                    for (let i = 6; i >= 0; i--) {
                        const date = new Date();
                        date.setDate(date.getDate() - i);
                        days.push(date.toLocaleDateString('ar-EG'));
                    }
                    
                    const donations = [];
                    
                    for (let i = 0; i < days.length; i++) {
                        donations.push(Math.floor(Math.random() * 15) + 5);
                    }
                    
                    return {
                        labels: days,
                        donations: donations
                    };
                }
                
                function getDefaultTopDonorsData() {
                    return {
                        labels: ['أحمد محمد', 'فاطمة علي', 'خالد عبدالله', 'سارة إبراهيم', 'محمد حسن'],
                        values: [25, 18, 15, 12, 10]
                    };
                }
            </script>
        @endsection --}}
    </div>
</body>

</html>