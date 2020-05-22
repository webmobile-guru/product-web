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

    'accepted'             => ': 속성을 수락해야합니다.',
    'active_url'           => ': attribute는 유효한 URL이 아닙니다.',
    'after'                => ': attribute는 : date 이후의 날짜 여야합니다.',
    'after_or_equal'       => ': attribute는 : date 이후의 날짜 여야합니다.',
    'alpha'                => ': 속성에는 문자 만 포함될 수 있습니다.',
    'alpha_dash'           => ': 속성에는 문자, 숫자 및 대시 만 포함될 수 있습니다.',
    'alpha_num'            => ': 속성에는 문자와 숫자 만 포함될 수 있습니다.',
    'array'                => ': attribute는 배열이어야합니다.',
    'before'               => ': attribute는 : date 이전의 날짜 여야합니다..',
    'before_or_equal'      => ': attribute는 : date 이전의 날짜 여야합니다..',
    'between'              => [
        'numeric' => ': attribute는 : min과 : max 사이에 있어야합니다.',
        'file'    => ': attribute는 : min과 : max kilobytes 사이 여야합니다..',
        'string'  => ': attribute는 : min과 : max 사이 여야합니다..',
        'array'   => ': attribute는 : min과 : max 사이에 있어야합니다..',
    ],
    'boolean'              => ': attribute 필드는 true 또는 false 여야합니다.',
    'confirmed'            => ': 속성 확인이 일치하지 않습니다.',
    'date'                 => ': attribute가 유효한 날짜가 아닙니다.',
    'date_format'          => ': attribute가 : format 형식과 일치하지 않습니다.',
    'different'            => ': attribute와 : other는 달라야합니다.',
    'digits'               => ': attribute는 : digitdigits 여야합니다..',
    'digits_between'       => ': attribute는 : min과 : max 사이 여야합니다..',
    'dimensions'           => ': 속성에 잘못된 이미지 크기가 있습니다..',
    'distinct'             => ': attribute 필드에 중복 값이 ​​있습니다.',
    'email'                => ': attribute는 유효한 이메일 주소 여야합니다.',
    'exists'               => '선택한 : 속성이 잘못되었습니다.',
    'file'                 => ': attribute는 파일이어야합니다.',
    'filled'               => ': attribute 필드는 값을 가져야합니다.',
    'image'                => ': 속성 이미지 여야합니다.',
    'in'                   => '선택한 : 속성이 유효하지 않습니다.',
    'in_array'             => ': attribute 필드는 : other에 없습니다..',
    'integer'              => ': attribute는 정수 여야합니다.',
    'ip'                   => ': attribute는 유효한 IP 주소 여야합니다.',
    'ipv4'                 => ': attribute는 유효한 IPv4 주소 여야합니다.',
    'ipv6'                 => ': attribute는 유효한 IPv6 주소 여야합니다.',
    'json'                 => ': attribute는 유효한 JSON 문자열이어야합니다..',
    'max'                  => [
        'numeric' => ': attribute는 : max보다 클 수 없습니다.',
        'file'    => ': attribute는 : max kilobytes보다 클 수 없습니다.',
        'string'  => ': attribute는 : max자를 초과 할 수 없습니다.',
        'array'   => ': attribute의 최대 개수 :.',
    ],
    'mimes'                => ': attribute는 : values ​​유형의 파일이어야합니다.',
    'mimetypes'            => ': attribute는 : values ​​유형의 파일이어야합니다.',
    'min'                  => [
        'numeric' => ': attribute는 최소한 : min이어야합니다.',
        'file'    => ': attribute는 최소한 : min KB 이상이어야합니다.',
        'string'  => ': attribute는 최소한 : min 문자 여야합니다.',
        'array'   => ': attribute에는 최소한 : min 항목이 있어야합니다.',
    ],
    'not_in'               => '선택한 : 속성이 유효하지 않습니다.',
    'numeric'              => 'The :attribute must be a number.',
    'present'              => ': attribute 필드가 있어야합니다.',
    'regex'                => ': 속성 형식이 잘못되었습니다.',
    'required'             => ': attribute 필드는 필수입니다.',
    'required_if'          => ': attribute 필드는 : other가 : value 인 경우 필수입니다.',
    'required_unless'      => ': attribute 필드는 : other가 : values에없는 경우 필수입니다..',
    'required_with'        => ': attribute 필드는 : values가있을 때 필요합니다.',
    'required_with_all'    => ': attribute 필드는 : values가있을 때 필요합니다.',
    'required_without'     => ': attribute 필드는 : values가 없을 때 필요합니다.',
    'required_without_all' => ': attribute 필드는 : values가 없으면 필수입니다.',
    'same'                 => ': attribute 및 : other는 일치해야합니다.',
    'size'                 => [
        'numeric' => ': attribute는 : size 여야합니다.',
        'file'    => ': attribute는 : size 킬로바이트 여야합니다.',
        'string'  => ': attribute는 : size 문자 여야합니다.',
        'array'   => ': attribute는 : size 항목을 포함해야합니다.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => ': attribute는 유효한 영역이어야합니다.',
    'unique'               => ': attribute는 이미 사용되었습니다.',
    'uploaded'             => ': 속성 업로드에 실패했습니다.',
    'url'                  => ': 속성 형식이 잘못되었습니다.',

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
            'rule-name' => '맞춤 메시지',
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
