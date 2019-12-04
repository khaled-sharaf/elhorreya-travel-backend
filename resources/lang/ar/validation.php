<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages.
    |
    */
    'accepted' => 'يجب قبول :attribute',
    'active_url' => ':attribute لا يُمثّل رابطًا صحيحًا.',
    'after' => 'يجب على :attribute أن يكون تاريخًا لاحقًا للتاريخ :date.',
    'after_or_equal' => ':attribute يجب أن يكون تاريخاً لاحقاً أو مطابقاً للتاريخ :date.',
    'alpha' => 'يجب أن لا يحتوي :attribute سوى على حروف.',
    'alpha_dash' => 'يجب أن لا يحتوي :attribute على حروف، أرقام ومطّات.',
    'alpha_num' => 'يجب أن يحتوي :attribute على حروفٍ وأرقامٍ فقط.',
    'array' => 'يجب أن يكون :attribute ًمصفوفة.',
    'before' => 'يجب على :attribute أن يكون تاريخًا سابقًا للتاريخ :date.',
    'before_or_equal' => ':attribute يجب أن يكون تاريخا سابقا أو مطابقا للتاريخ :date.',
    'between' => [
        'numeric' => 'يجب أن تكون   :attribute بين :min و :max.',
        'file' => 'يجب أن يكون حجم الملف :attribute بين :min و :max كيلوبايت.',
        'string' => 'يجب أن يكون عدد حروف النّص :attribute بين :min و :max.',
        'array' => 'يجب أن يحتوي :attribute على عدد من العناصر بين :min و :max.',
    ],
    'boolean' => 'يجب أن تكون   :attribute إما true أو false .',
    'confirmed' => 'حقل التأكيد غير مُطابق للحقل :attribute.',
    'date' => ':attribute ليس تاريخًا صحيحًا.',
    'date_format' => 'لا يتوافق :attribute مع الشكل :format.',
    'different' => 'يجب أن يكون الحقلان :attribute و :other مُختلفان.',
    'digits' => 'يجب أن يحتوي :attribute على :digits رقمًا/أرقام.',
    'digits_between' => 'يجب أن يحتوي :attribute بين :min و :max رقمًا/أرقام .',
    'dimensions' => 'الـ :attribute يحتوي على أبعاد صورة غير صالحة.',
    'distinct' => 'للحقل :attribute   مُكرّرة.',
    'email' => 'يجب أن يكون :attribute عنوان بريد إلكتروني صحيح البُنية.',
    'exists' => 'ال  المحددة :attribute غير موجودة.',
    'file' => 'الـ :attribute يجب أن يكون ملفا.',
    'filled' => ':attribute إجباري.',
    'image' => 'يجب أن يكون :attribute صورةً.',
    'in' => ':attribute لاغٍ.',
    'in_array' => ':attribute غير موجود في :other.',
    'integer' => 'يجب أن يكون :attribute عددًا صحيحًا.',
    'ip' => 'يجب أن يكون :attribute عنوان IP صحيحًا.',
    'ipv4' => 'يجب أن يكون :attribute عنوان IPv4 صحيحًا.',
    'ipv6' => 'يجب أن يكون :attribute عنوان IPv6 صحيحًا.',
    'json' => 'يجب أن يكون :attribute نصآ من نوع JSON.',
    'max' => [
        'numeric' => 'يجب أن تكون   :attribute مساوية أو أصغر لـ :max.',
        'file' => 'يجب أن لا يتجاوز حجم الملف :attribute :max كيلوبايت.',
        'string' => 'يجب أن لا يتجاوز طول النّص :attribute :max حروفٍ/حرفًا.',
        'array' => 'يجب أن لا يحتوي :attribute على أكثر من :max عناصر/عنصر.',
    ],
    'mimes' => 'يجب أن يكون ملفًا من نوع : :values.',
    'mimetypes' => 'يجب أن يكون ملفًا من نوع : :values.',
    'min' => [
        'numeric' => 'يجب أن تكون   :attribute مساوية أو أكبر لـ :min.',
        'file' => 'يجب أن يكون حجم الملف :attribute على الأقل :min كيلوبايت.',
        'string' => 'يجب أن يكون طول النص :attribute على الأقل :min حروفٍ/حرفًا.',
        'array' => 'يجب أن يحتوي :attribute على الأقل على :min عُنصرًا/عناصر.',
    ],
    'not_in' => ':attribute لاغٍ.',
    'numeric' => 'يجب على :attribute أن يكون رقمًا.',
    'present' => 'يجب تقديم :attribute.',
    'regex' => 'صيغة :attribute .غير صحيحة.',
    'required' => ':attribute مطلوب.',
    'required_if' => ':attribute مطلوب في حال ما إذا كان :other يساوي :value.',
    'required_unless' => ':attribute مطلوب في حال ما لم يكن :other يساوي :values.',
    'required_with' => ':attribute مطلوب إذا توفّر :values.',
    'required_with_all' => ':attribute مطلوب إذا توفّر :values.',
    'required_without' => ':attribute مطلوب إذا لم يتوفّر :values.',
    'required_without_all' => ':attribute مطلوب إذا لم يتوفّر :values.',
    'same' => 'يجب أن يتطابق :attribute مع :other.',
    'size' => [
        'numeric' => 'يجب أن تكون   :attribute مساوية لـ :size.',
        'file' => 'يجب أن يكون حجم الملف :attribute :size كيلوبايت.',
        'string' => 'يجب أن يحتوي النص :attribute على :size حروفٍ/حرفًا بالظبط.',
        'array' => 'يجب أن يحتوي :attribute على :size عنصرٍ/عناصر بالظبط.',
    ],
    'string' => 'يجب أن يكون :attribute نصآ.',
    'timezone' => 'يجب أن يكون :attribute نطاقًا زمنيًا صحيحًا.',
    'unique' => '  :attribute مُستخدم من قبل.',
    'uploaded' => 'فشل في تحميل الـ :attribute.',
    'url' => 'صيغة الرابط :attribute غير صحيحة.',
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */
    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */
    'attributes' => [
        'name' => 'الاسم',
        'username' => 'اسم المُستخدم',
        'adminname' => 'اسم المُشرف',
        'email' => 'البريد الإليكتروني',
        'first_name' => 'الاسم الأول',
        'last_name' => 'اسم العائلة',
        'password' => 'كلمة السر',
        'password_confirmation' => 'تأكيد كلمة السر',
        'city' => 'المدينة',
        'country' => 'الدولة',
        'address' => 'العنوان',
        'phone' => 'الهاتف',
        'mobile' => 'الجوال',
        'age' => 'العمر',
        'sex' => 'الجنس',
        'gender' => 'النوع',
        'day' => 'اليوم',
        'month' => 'الشهر',
        'year' => 'السنة',
        'hour' => 'ساعة',
        'minute' => 'دقيقة',
        'second' => 'ثانية',
        'title' => 'العنوان',
        'content' => 'المُحتوى',
        'description' => 'الوصف',
        'excerpt' => 'المُلخص',
        'date' => 'التاريخ',
        'time' => 'الوقت',
        'available' => 'مُتاح',
        'size' => 'الحجم',
        'travel_category_id' => 'قسم الرحلة',
        'travel_program_id' => 'برنامج الرحلة',


        'photo' => 'الصورة',
        'photos' => 'الصور',
        'image' => 'الصورة',
        'images' => 'الصور',
        'gallery' => 'الصور',

        'logo' => 'صورة الشعار',

        'rule' => 'الصلاحية',
        'active' => 'التفعيل',
        'comapany' => 'الشركة',
        'company_id' => 'الشركة',
        'product_id' => 'المنتج',
        'user_id' => 'المستخدم',
        'hotel_id' => 'الفندق',
        'type_id' => 'النوع',
        'type' => 'النوع',
        'category' => 'القسم',
        'options' => 'الخيارات',
        'info' => 'المعلومات',
        'message' => 'الرسالة',

        'description' => 'الوصف',
        'website' => 'موقع الويب',
        'longitude' => 'خط الطول',
        'latitude' => 'خط العرض',
        'face_link' => 'فيسبوك',
        'tw_link' => 'تويتر',
        'display' => 'الظهور',
        'price' => 'السعر',
        'price_night' => 'سعر الليلة',
        'offer_price' => 'سعر العرض',
        'offer_days' => 'عدد أيام العرض',
        'manufacture_company' => 'الشركة المصنعة',
        'product_count' => 'عدد المنتجات',
        'execute' => 'نفاذ الكمية',
        'discount' => 'الخصم',
        'percent' => 'النسبة المئوية',
        'text_comment' => 'التعليق',
        'positive_product' => 'إيجابيات المنتج',
        'negative_product' => 'سلبيات المنتج',
        'slug' => 'الاسم التعبيرى',
        'value' => 'القيمة',


        'address_from' => 'عنوان الإقلاع',
        'umrah_date' => 'موعد العمرة',
        'haram_distance' => 'المسافة بين الفندق والحرم',
        'itinerary_1' => 'المدينة الأولى',
        'itinerary_2' => 'المدينة الثانية',
        'itinerary_3' => 'المدينة الثالثة',
        'itinerary_4' => 'المدينة الرابعة',
        'itinerary_5' => 'المدينة الخامسة',
        'favorite_company' => 'تفضيل الحرية',
        'offers' => 'العروض',

        'offers.*.name_offer' => 'اسم العرض',
        'offers.*.info_offer' => 'وصف العرض',
        'offers.*.go_and_back' => 'الذهاب والعودة',
        'offers.*.date_from' => 'تاريخ البداية',
        'offers.*.date_to' => 'تاريخ الإنتهاء',
        'offers.*.hotel_days' => 'عدد أيام فندق مكة',
        'offers.*.hotel_2_days' => 'عدد أيام فندق المدينة',
        'offers.*.stay_type' => 'نوع الإقامة',
        'offers.*.stay_type_2' => 'نوع إقامة الفندق الثانى',
        'offers.*.transport' => 'الانتقالات',
        'offers.*.adults' => 'عدد البالغين',
        'offers.*.children' => 'عدد الأطفال',
        'offers.*.single_price' => 'سعر الفرد',
        'offers.*.twin_price' => 'سعر الفردين',
        'offers.*.triple_price' => 'سعر ثلاث أفراد',
        'offers.*.display' => 'ظهور العرض',

        'tabs.*.name' => 'اسم العرض',
        'tabs.*.categories' => 'الأقسام',
        'tabs.*.travels' => 'الرحلات',

        'phone_1' => 'رقم الموبايل الأول',
        'phone_2' => 'رقم الموبايل الثانى',
        'phone_3' => 'رقم الموبايل الثالث',
        'phone_4' => 'رقم الموبايل الرابع',

    ],
];
