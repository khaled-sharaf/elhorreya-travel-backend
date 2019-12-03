
<!DOCTYPE html><html lang=en><head><meta charset=utf-8><meta http-equiv=X-UA-Compatible content="IE=edge"><meta name=viewport content="width=device-width,user-scalable=no,initial-scale=1,shrink-to-fit=no"><link rel=icon href="{{ url('/favicon.ico') }}"><title>الحرية للسياحة</title>
<link href="{{ url('/css/app.32b2064b.css') }}" rel=preload as=style>
<link href="{{ url('/css/chunk-vendors.180c9e4c.css') }}" rel=preload as=style>
<link href="{{ url('/js/app.004b1b4a.js') }}" rel=preload as=script>
<link href="{{ url('/js/chunk-vendors.03e343c7.js') }}" rel=preload as=script>
<link href="{{ url('/css/chunk-vendors.180c9e4c.css') }}" rel=stylesheet>
<link href="{{ url('/css/app.32b2064b.css') }}" rel=stylesheet>
</head><body style="overflow: hidden"><noscript><strong>We're sorry but Elhorreya Travel doesn't work properly without JavaScript enabled. Please enable it to continue.</strong></noscript><div id=app></div>
<div class=loader-global><div class=wrapper-loader><div class=loader><span class="spinner-border"></span></div><h2 class=site-name>الحرية للسياحة</h2></div></div>
<script src="{{ url('/js/jquery-1.12.1.min.js') }}"></script>
<script>
    function initMapCompanyLoop(eleMap) {
        var elMap = eleMap.querySelector('.location_map_company'),
            latitude = window.parseFloat(eleMap.getAttribute('data-lat')),
            longitude = window.parseFloat(eleMap.getAttribute('data-long'));

        var uluru = {lat: latitude, lng: longitude};
        var map = new google.maps.Map(elMap, {
            zoom: 16,
            center: uluru
        });
        var marker = new google.maps.Marker({
            position: uluru,
            map: map
        });
    }

    function initMapCompany() {
        var my_map_modal = document.querySelectorAll('.map-company');
        for (var i = 0; i < my_map_modal.length; i++) {
            initMapCompanyLoop(my_map_modal[i]);
        }
    }
</script>
<script src="{{ url('/js/chunk-vendors.03e343c7.js') }}"></script>
<script src="{{ url('/js/app.004b1b4a.js') }}"></script>
@include('messages-alert.mailing-list')
</body></html>

