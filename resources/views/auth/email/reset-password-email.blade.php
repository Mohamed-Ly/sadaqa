<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طلب إعادة تعيين كلمة المرور - {{ config('app.name') }}</title>
    <style>
        /* أنماط عامة */
        body {
            font-family: 'Tahoma', 'Arial', sans-serif;
            text-align: right;
            direction: rtl;
            line-height: 1.8;
            color: #333;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .header {
            background-color: #2d3748;
            padding: 25px;
            text-align: center;
        }
        
        .logo {
            height: 60px;
        }
        
        .content {
            padding: 30px;
        }
        
        h1 {
            color: #2d3748;
            margin-top: 0;
            font-size: 24px;
        }
        
        .button {
            display: inline-block;
            padding: 12px 30px;
            background-color: #4CAF50;
            color: white !important;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin: 20px 0;
            transition: background-color 0.3s;
        }
        
        .button:hover {
            background-color: #3e8e41;
        }
        
        .notice {
            margin-top: 30px;
            padding: 15px;
            background-color: #f8f9fa;
            border-right: 4px solid #e53e3e;
            border-radius: 4px;
        }
        
        .footer {
            text-align: center;
            padding: 20px;
            background-color: #f0f0f0;
            color: #666;
            font-size: 14px;
        }
        
        ul {
            padding-right: 20px;
        }
        
        li {
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" class="logo">
        </div>
        
        <div class="content">
            <h1>إعادة تعيين كلمة المرور</h1>
            
            <p>الأخ/الأخت الكريم/ة <strong>{{ $user->name }}</strong>،</p>
            
            <p>نشكرك لاستخدامك منصة <strong>{{ config('app.name') }}</strong>. لقد تلقينا طلباً لإعادة تعيين كلمة المرور الخاصة بحسابك.</p>
            
            <p>لإكمال عملية إعادة التعيين، يرجى الضغط على الزر التالي:</p>
            
            <div style="text-align: center; margin: 25px 0;">
                <a href="{{ $url }}" class="button">تغيير كلمة المرور</a>
            </div>
            
            <p><strong>ملاحظة هامة:</strong> سينتهي مفعول هذا الرابط خلال <span style="color: #e53e3e; font-weight: bold;">{{ $expire }} دقيقة</span> من تاريخ هذا البريد.</p>
            
            <div class="notice">
                <h4 style="margin-top: 0; color: #e53e3e;">إرشادات أمانية:</h4>
                <ul>
                    <li>هذا الرابط خاص بك فقط، لا تشاركه مع أي شخص</li>
                    <li>تأكد أن عنوان الرابط يبدأ بـ: <strong>{{ config('app.url') }}</strong></li>
                    <li>اختر كلمة مرور قوية تحتوي على أحرف كبيرة وصغيرة وأرقام</li>
                    <li>إذا لم تطلب إعادة التعيين، يرجى إبلاغنا فوراً</li>
                </ul>
            </div>
            
            <p style="margin-top: 25px;">مع خالص التقدير،<br>فريق <strong>{{ config('app.name') }}</strong></p>
        </div>
        
        <div class="footer">
            © {{ date('Y') }} {{ config('app.name') }}. جميع الحقوق محفوظة.
            <br>
            <small>هذه رسالة تلقائية، يرجى عدم الرد عليها</small>
        </div>
    </div>
</body>
</html>