<?php
use function PHPSTORM_META\type;

/***********************************************************************************/
// get every rate
if (!function_exists('every_rate')) {
    function every_rate($rates) {
        $rates = collect($rates);
        $rate_1 = $rates->filter(function ($rate) { return $rate->rate == 1; });
        $rate_2 = $rates->filter(function ($rate) { return $rate->rate == 2; });
        $rate_3 = $rates->filter(function ($rate) { return $rate->rate == 3; });
        $rate_4 = $rates->filter(function ($rate) { return $rate->rate == 4; });
        $rate_5 = $rates->filter(function ($rate) { return $rate->rate == 5; });

        $result = [
            ['level_rate' => '1', 'rate' => $rate_1->count()],
            ['level_rate' => '2', 'rate' => $rate_2->count()],
            ['level_rate' => '3', 'rate' => $rate_3->count()],
            ['level_rate' => '4', 'rate' => $rate_4->count()],
            ['level_rate' => '5', 'rate' => $rate_5->count()]
        ];
        return $result;
    }
}


/***********************************************************************************/
if (!function_exists('convert_str_to_array')) {
    function convert_str_to_array($arr, $column) {
        $column_str = $arr[$column];
        $column_arr = [];
        if ($column_str != null && trim($column_str) != '') {
            $column_str = explode(',', $column_str);
            $i = 1;
            foreach ($column_str as $columnValue) {
                $column_arr[] = ['id' => $i, 'value' => $columnValue];
                $i++;
            }
        }
        $arr[$column] = $column_arr;
        return $arr;
    }
}

/***********************************************************************************/
// convert features from string to array
if (!function_exists('convert_column_to_array')) {
    function convert_column_to_array($items_arr, $column) {
        $items_arr = is_array($items_arr) ?  $items_arr : $items_arr->toArray();
        $items_result = [];
        if (array_key_exists(0, $items_arr)) {
            foreach ($items_arr as $item) {
                $items_result[] = convert_str_to_array($item, $column);
            }
        } else {
            $items_result = convert_str_to_array($items_arr, $column);
        }
        return collect($items_result);
    }
}

/***********************************************************************************/
if (!function_exists('paginate_collection')) {
    function paginate_collection($collection, $perPage, $pageName = 'page', $fragment = null)
    {
        $currentPage = \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage($pageName);
        $currentPageItems = count($collection) > 0 ? $collection->slice(($currentPage - 1) * $perPage, $perPage) : collect($collection);
        parse_str(request()->getQueryString(), $query);
        unset($query[$pageName]);
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $currentPageItems,
            count($collection),
            $perPage,
            $currentPage,
            [
                'pageName' => $pageName,
                'path' => \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPath(),
                'query' => $query,
                'fragment' => $fragment
            ]
        );

        return $paginator;
    }
}

/***********************************************************************************/
// add Prefix in url admin [control panel]
if (!function_exists('aurl')) {
    function aurl($url = null) {
        $name = env('CP_PREFIX');
        if ($url !== null) {
            return url($name . '/' . $url);
        }
        return '';
    }
}
/***********************************************************************************/


/***********************************************************************************/
// add class active in links active
if (!function_exists('active_link')) {
    function active_link($uri, $recursive = true, $indexSegment = 1, $class_name = 'active') {
        if ($recursive === true) {
            if ($uri === Request::segment($indexSegment)) {
                return $class_name;
            }
        } else if ($recursive === false) {
            if (url($uri) === Request::url()) {
                return $class_name;
            }
        }
        return '';
    }
}
/***********************************************************************************/
if (!function_exists('active_link_url')) {
    function active_link_url($url, $class_name = 'active') {
        if ($url === Request::url()) {
            return $class_name;
        }
        return '';
    }
}
/***********************************************************************************/


/***********************************************************************************/
// add class active in links active
if (!function_exists('active_link_cp')) {
    function active_link_cp($uri, $recursive = true, $indexSegment = 2, $class_name = 'active') {
        if ($recursive === true) {
            if ($uri === Request::segment($indexSegment)) {
                return $class_name;
            }
        } else if ($recursive === false) {
            if (aurl($uri) === Request::url()) {
                return $class_name;
            }
        }
        return '';
    }
}
/***********************************************************************************/


/***********************************************************************************/
if (!function_exists('lang')) {
    function lang() {
        $name_cookies = env('LARAVEL_COOKIES_LANG_NAME', 'laravel_cookies_lang');
        $defaultLang = Cookie::get($name_cookies) !== null ? Cookie::get($name_cookies) : 'en';
        if (env('USER_LANG_ALLOW') === true) {
            if (auth()->check()) {
                session()->put($name_cookies, auth()->user()->lang);
            }
        }
        if (session()->has($name_cookies)) {
            $currentLang = session($name_cookies);
        } else {
            session()->put($name_cookies, $defaultLang);
            $currentLang = $defaultLang;
        }
        setcookie($name_cookies, $currentLang, time() + (60 * 24 * 30 * 12), '/'); // expired after 1 year.
        return $currentLang;
    }
}
if (!function_exists('get_lang')) {
    function get_lang() {
        return lang();
    }
}
if (!function_exists('default_lang')) {
    function default_lang() {
        return lang();
    }
}
/***********************************************************************************/
// Ge Direction
if (!function_exists('direction')) {
    function direction() {
        $name_cookies = env('LARAVEL_COOKIES_LANG_NAME', 'laravel_cookies_lang');
        if (session()->has($name_cookies)) {
            if (session($name_cookies) == 'ar') {
                return 'rtl';
            } else {
                return 'ltr';
            }
        } else {
            return 'ltr';
        }
    }
}
if (!function_exists('dir')) {
    function dir() {
        return direction();
    }
}
if (!function_exists('get_dir')) {
    function get_dir() {
        return direction();
    }
}
if (!function_exists('get_dir_css')) {
    function get_dir_css() {
        return direction() == 'rtl' ? 'right' : 'left';
    }
}
/***********************************************************************************/
