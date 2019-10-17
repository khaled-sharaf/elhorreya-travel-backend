<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cairo:400,600,700&display=swap&subset=arabic">
    <!-- ================================================================================== -->
    <!-- ================================================================================== -->
    <style>
        body {
            margin: 0;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            text-align: left;
            background-color: #fff;
        }
        ol,
        ul,
        dl {
            margin-top: 0;
            margin-bottom: 1rem;
        }

        ol ol,
        ul ul,
        ol ul,
        ul ol {
            margin-bottom: 0;
        }
        a {
            color: #007bff;
            text-decoration: none;
            background-color: transparent;
        }
        a:hover {
            color: #0056b3;
            text-decoration: underline;
        }
        a:not([href]):not([tabindex]) {
            color: inherit;
            text-decoration: none;
        }
        a:not([href]):not([tabindex]):hover, a:not([href]):not([tabindex]):focus {
            color: inherit;
            text-decoration: none;
        }
        a:not([href]):not([tabindex]):focus {
            outline: 0;
        }
        .btn {
            display: inline-block;
            font-weight: 400;
            color: #212529;
            text-align: center;
            vertical-align: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-color: transparent;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.25rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        .btn:hover {
            color: #212529;
            text-decoration: none;
        }
        .btn:focus, .btn.focus {
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        .btn-primary {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            color: #fff;
            background-color: #0069d9;
            border-color: #0062cc;
        }
        .btn-primary:focus, .btn-primary.focus {
            box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.5);
        }
        .btn-secondary {
            color: #fff;
            background-color: #6c757d;
            border-color: #6c757d;
        }
        .btn-secondary:hover {
            color: #fff;
            background-color: #5a6268;
            border-color: #545b62;
        }
        .btn-secondary:focus, .btn-secondary.focus {
            box-shadow: 0 0 0 0.2rem rgba(130, 138, 145, 0.5);
        }
        .btn-success {
            color: #fff;
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-success:hover {
            color: #fff;
            background-color: #218838;
            border-color: #1e7e34;
        }
        .btn-success:focus, .btn-success.focus {
            box-shadow: 0 0 0 0.2rem rgba(72, 180, 97, 0.5);
        }
        .btn-info {
            color: #fff;
            background-color: #17a2b8;
            border-color: #17a2b8;
        }
        .btn-info:hover {
            color: #fff;
            background-color: #138496;
            border-color: #117a8b;
        }
        .btn-info:focus, .btn-info.focus {
            box-shadow: 0 0 0 0.2rem rgba(58, 176, 195, 0.5);
        }
        .btn-warning {
            color: #212529;
            background-color: #ffc107;
            border-color: #ffc107;
        }
        .btn-warning:hover {
            color: #212529;
            background-color: #e0a800;
            border-color: #d39e00;
        }
        .btn-warning:focus, .btn-warning.focus {
            box-shadow: 0 0 0 0.2rem rgba(222, 170, 12, 0.5);
        }
        .btn-danger {
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-danger:hover {
            color: #fff;
            background-color: #c82333;
            border-color: #bd2130;
        }
        .btn-danger:focus, .btn-danger.focus {
            box-shadow: 0 0 0 0.2rem rgba(225, 83, 97, 0.5);
        }
        .btn-light {
            color: #212529;
            background-color: #f8f9fa;
            border-color: #f8f9fa;
        }
        .btn-light:hover {
            color: #212529;
            background-color: #e2e6ea;
            border-color: #dae0e5;
        }
        .btn-light:focus, .btn-light.focus {
            box-shadow: 0 0 0 0.2rem rgba(216, 217, 219, 0.5);
        }
        .btn-dark {
            color: #fff;
            background-color: #343a40;
            border-color: #343a40;
        }
        .btn-dark:hover {
            color: #fff;
            background-color: #23272b;
            border-color: #1d2124;
        }
        .btn-dark:focus, .btn-dark.focus {
            box-shadow: 0 0 0 0.2rem rgba(82, 88, 93, 0.5);
        }
        .btn-sm, .btn-group-sm > .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            line-height: 1.5;
            border-radius: 0.2rem;
        }
        .btn-block {
            display: block;
            width: 100%;
        }
        .btn-block + .btn-block {
            margin-top: 0.5rem;
        }
        input[type="submit"].btn-block,
        input[type="reset"].btn-block,
        input[type="button"].btn-block {
            width: 100%;
        }
        .float-left {
            float: left !important;
        }
        .float-right {
            float: right !important;
        }
        .float-none {
            float: none !important;
        }
    </style>
    <!-- ================================================================================== -->
    <!-- ================================================================================== -->
    <style>
        * {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }
        body {
            text-align: right !important;
            direction: rtl !important;
            font-family: 'Cairo', sans-serif, 'Arial', 'Verdana' !important;
            padding-top: 120px;
        }
        .mark {
            margin: 0 5px;
            display: inline-block;
            font-weight: bold;
        }
        .mark.info {
            color: #3498db;
        }
        .separator {
            display: block;
            margin: 10px auto;
            width: 90%;
            height: 1px;
            background-color: #DDD;
        }
        .text-center {
            text-align: center;
        }
        /* header ===================================================================== */
        .header {
            padding: 0 10px;
            background-color: #EEE;
            font-size: 20px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 9999;
            width: 100%;
            height: 120px;
            line-height: 120px;
            text-align: center;
        }
        .header .title {
            color: #555;
            padding: 0;
            margin: 0;
        }
        @media (max-width: 500px) {
            .header .title {
                font-size: 20px;
            }
        }
        @media (max-width: 380px) {
            .header .title {
                font-size: 18px;
            }
        }
        @media (max-width: 300px) {
            .header .title {
                font-size: 16px;
            }
        }
        /* ./header ===================================================================== */


        /* content ===================================================================== */
        .content {
            padding: 30px;
        }
        .content .intro {
            line-height: 1.8;
        }


        .content .travel > .title {
            padding: 0;
            margin: 0;
        }
        @media (max-width: 400px) {
            .content .travel > .title {
                font-size: 22px;
            }
        }
        .content .travel .box-image {
            overflow: hidden;
            padding: 10px;
        }
        .content .travel .box-image .text {
            float: right;
            width: 60%;
            padding-right: 10px;
        }
        .content .travel .box-image .text .desc {
            max-height: 300px;
            overflow: hidden;
            line-height: 1.9;
        }

        .content .travel .box-image .image {
            float: right;
            width: 40%;
            padding: 15px 10px;
        }
        @media (max-width: 768px) {
            .content .travel .box-image .text,
            .content .travel .box-image .image {
                float: none;
                width: 100%;
                padding-right: 0;
                padding-left: 0;
            }
            .content .travel .box-image .text .desc {
                max-height: none;
                overflow: visible;
            }
        }
        .content .travel .box-image .image .travel-image {
            text-align: center;
        }
        .content .travel .box-image .image .travel-image img {
            padding: 4px;
            background-color: #FFF;
            box-shadow: 0px 6px 6px -3px rgba(0, 0, 0, 0.2), 0px 10px 14px 1px rgba(0, 0, 0, 0.14), 0px 4px 18px 3px rgba(0, 0, 0, 0.12) !important;
            border-radius: 5px;
            border: 1px solid #DDD;
            height: auto;
            max-width: 100%;
            max-height: 300px;
        }


        .content .list {
            padding: 20px;
        }
        .content .list .item {
            margin-bottom: 10px;
            overflow: hidden;
        }
        .content .list .item .item-label {
            width: 150px;
            float: right;
        }
        .content .list .item .item-value {
            width: calc(100% - 150px);
            float: right;

        }
        @media (max-width: 768px) {
            .content .list .item .item-label,
            .content .list .item .item-value {
                width: 100%;
                float: none;
            }
            .content .list .item .item-value {
                padding-right: 10px;
            }
        }
        .content .show-more-details {
            padding-right: 20px;
        }

        .content .show-all {
            overflow: hidden;
            padding: 20px 0;
        }

        /* ./content ===================================================================== */


        /* footer ===================================================================== */
        .footer {
            padding: 30px 10px;
            background-color: #EEE;
            overflow: hidden;
        }
        @media (max-width: 700px) {
            .footer .thank {
                margin-bottom: 20px;
            }
        }
        /* ./footer ===================================================================== */
    </style>
</head>

@php
    $settings = App\Setting::getSettings();
@endphp

<body>
    <header class="header">
        <h3 class="title">
            {{ $settings['site_name_ar'] . ' - ' . $settings['site_name_en'] }}
        </h3>
    </header>


    <!-- content -->
    <main class="content">
        <p class="intro">
            @if($travel->type === 'pilgrimage')
                عملائنا الكرام كل عام وأنتم بخير بمناسبة حلول موسم الحج، رزقنا الله وإياكم حج بيته الحرام.
                <br>
                نعلن لكم عن رحلة حج جديدة على موقعنا
            @elseif($travel->type === 'umrah')
                عملائنا الكرام نعلن لكم عن رحلة عمرة جديدة على موقعنا
            @else
                عملائنا الكرام نعلن لكم عن رحلة جديدة إلى
                (
                    {{ $travel->hotel->address }}
                )
                على موقعنا
            @endif

            <a href="{{url('/')}}">
            الحرية للسياحة
            -
            Horreya Travel
            </a>
            وهذه بعض التفاصيل الرحلة وللمزيد من التفاصيل يرجى زيارة موقعنا أو الإتصال على أرقامنا التالية:

            <span class="mark info">011515151541</span> -
            <span class="mark info">010084841540</span>.
        </p>

        <div class="separator"></div>

        <div class="travel">
            <h1 class="title">
                {{ $travel->name }}
            </h1>
            <div class="box-image">
                <div class="text">
                    <p class="desc">
                        {!! str_limit($travel->info, 600,
                            '<a href="' . url('travel/' . $travel->id) . '"> اقرأ المزيد </a> ... ') !!}
                    </p>
                </div>
                <div class="image">
                    <div class="travel-image">
                        <img src="{{ url($travel->image) }}">
                    </div>
                </div>
            </div><!-- ./box-image -->

            <div class="list">
                <div class="item">
                    <b class="item-label">
                    اسم الفندق
                    </b>
                    <span class="item-value">
                        {{ $travel->hotel->name }}
                    </span>
                </div>
                <!-- ======================================= -->

                <div class="item">
                    <b class="item-label">
                    مكان الفندق
                    </b>
                    <span class="item-value">
                        {{ $travel->hotel->address }}
                    </span>
                </div>
                <!-- ======================================= -->

                <div class="item">
                    <b class="item-label">
                    التوقيت
                    </b>
                    <span class="item-value">
                        @if($travel->offers[0]->time_period === 1)
                            يوم واحد فقط -
                        @elseif($travel->offers[0]->time_period === 2)
                            يومين
                        @elseif($travel->offers[0]->time_period > 2 && $travel->offers[0]->time_period < 11)
                            <span class="mark info"> {{ $travel->offers[0]->time_period }} </span> أيام
                        @elseif($travel->offers[0]->time_period > 10)
                            <span class="mark info"> {{ $travel->offers[0]->time_period }} يوم </span>
                        @endif
                        من
                        <span class="mark info format-date"> {{ $travel->offers[0]->date_from }} </span>
                        إلى
                        <span class="mark info format-date"> {{ $travel->offers[0]->date_to }} </span>
                    </span>
                </div>
                <!-- ======================================= -->

                <div class="item">
                    <b class="item-label">
                        أسعارنا تبدأ من
                    </b>
                    <span class="item-value">
                        {{ $travel->offers[0]->single_price }} جنية
                    </span>
                </div>
                <!-- ======================================= -->

            </div> <!-- ./list -->
        </div>

        <div class="show-more-details">
            <a class="btn btn-info btn-sm" href="{{ url('travel/' . $travel->id) }}">
                للمزيد من التفاصيل
            </a>
        </div>

        <br>
        <div class="separator"></div>
        <div class="text-center show-all">
            <a class="btn btn-primary btn-lg" href="{{ url('travels') }}">
                مشاهدة رحلات وعروض أخرى
            </a>
        </div>
    </main>
    <!-- ./content -->

    <footer class="footer">
        <div class="thank float-right">
            <a href="{{url('/')}}">
                {{ $settings['site_name_ar'] }}
            </a>
            تشكرك على متابعتك لها.
        </div>

        <a class="btn btn-secondary btn-sm float-left" href="{{ url('mailing_list/unsubscripe') }}">
            إلغاء الإشتراك فى خدمة القائمة البريدية
        </a>
    </footer>
</body>
</html>
