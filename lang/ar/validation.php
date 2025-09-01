<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'حقل :attribute must be accepted.',
    'active_url'           => 'حقل :attribute is not a valid URL.',
    'after'                => 'حقل :attribute must be a date after :date.',
    'after_or_equal'       => 'حقل :attribute must be a date after or equal to :date.',
    'alpha'                => 'حقل :attribute may only contain letters.',
    'alpha_dash'           => 'حقل :attribute may only contain letters, numbers, and dashes.',
    'alpha_num'            => 'حقل :attribute may only contain letters and numbers.',
    'array'                => 'حقل :attribute must be an array.',
    'before'               => 'حقل :attribute must be a date before :date.',
    'before_or_equal'      => 'حقل :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => 'حقل :attribute must be between :min and :max.',
        'file'    => 'حقل :attribute must be between :min and :max kilobytes.',
        'string'  => 'حقل :attribute must be between :min and :max characters.',
        'array'   => 'حقل :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'حقل :attribute field must be true or false.',
    'confirmed'            => 'حقل :attribute confirmation does not match.',
    'date'                 => 'حقل :attribute is not a valid date.',
    'date_format'          => 'حقل :attribute does not match the format :format.',
    'different'            => 'حقل :attribute and :other must be different.',
    'digits'               => 'حقل :attribute must be :digits digits.',
    'digits_between'       => 'حقل :attribute must be between :min and :max digits.',
    'dimensions'           => 'حقل :attribute has invalid image dimensions.',
    'distinct'             => 'حقل :attribute يحتوى على بيانات مكررة.',
    'email'                => 'حقل :attribute must be a valid email address.',
    'exists'               => 'حقل selected :attribute is invalid.',
    'file'                 => 'حقل :attribute must be a file.',
    'filled'               => 'حقل :attribute يجب ان يحتوى على بيانات.',
    'images'                => 'عفوا! , يرجى اختيار صور للتحميل',
    'in'                   => 'حقل selected :attribute is invalid.',
    'in_array'             => 'حقل :attribute field does not exist in :other.',
    'integer'              => 'حقل :attribute must be an integer.',
    'ip'                   => 'حقل :attribute must be a valid IP address.',
    'ipv4'                 => 'حقل :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'حقل :attribute must be a valid IPv6 address.',
    'json'                 => 'حقل :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => 'حقل :attribute may not be greater than :max.',
        'file'    => 'حقل :attribute may not be greater than :max kilobytes.',
        'string'  => 'حقل :attribute may not be greater than :max characters.',
        'array'   => 'حقل :attribute may not have more than :max items.',
    ],
    'mimes'                => 'حقل الصور يجب ان يكون من نوع : :values.',
    'mimetypes'            => 'حقل الصور يجب ان يكون من نوع: :values.',
    'min'                  => [
        'numeric' => 'حقل :attribute must be at least :min.',
        'file'    => 'حقل :attribute must be at least :min kilobytes.',
        'string'  => 'حقل :attribute يجب ان يكون :min حروف على الاقل.',
        'array'   => 'حقل :attribute must have at least :min items.',
    ],
    'not_in'               => 'حقل selected :attribute is invalid.',
    'numeric'              => 'حقل :attribute يجب ان يكون رقم.',
    'present'              => 'حقل :attribute field must be present.',
    'regex'                => 'حقل :attribute format is invalid.',
    'required'             => 'حقل :attribute مطلوب.',
    'required_if'          => 'حقل :attribute field is required when :other is :value.',
    'required_unless'      => 'حقل :attribute field is required unless :other is in :values.',
    'required_with'        => 'حقل :attribute field is required when :values is present.',
    'required_with_all'    => 'حقل :attribute field is required when :values is present.',
    'required_without'     => 'حقل :attribute field is required when :values is not present.',
    'required_without_all' => 'حقل :attribute field is required when none of :values are present.',
    'same'                 => 'حقل :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'حقل :attribute must be :size.',
        'file'    => 'حقل :attribute must be :size kilobytes.',
        'string'  => 'حقل :attribute must be :size characters.',
        'array'   => 'حقل :attribute must contain :size items.',
    ],
    'string'               => 'حقل :attribute must be a string.',
    'timezone'             => 'حقل :attribute must be a valid zone.',
    'unique'               => ':attribute مسجل مسبقا.',
    'uploaded'             => 'فشل فى التحميل.',
    'url'                  => 'حقل :attribute format is invalid.',

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

    'attributes' => [],

];
