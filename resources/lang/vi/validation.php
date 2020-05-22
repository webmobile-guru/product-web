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

    'accepted'             => 'Thuộc tính: phải được chấp nhận.',
    'active_url'           => 'Thuộc tính: không phải là một URL hợp lệ.',
    'after'                => 'Thuộc tính: phải là một ngày sau: ngày.',
    'after_or_equal'       => 'Thuộc tính: phải là một ngày sau hoặc bằng: ngày.',
    'alpha'                => 'Thuộc tính: chỉ có thể chứa các chữ cái.',
    'alpha_dash'           => 'Thuộc tính: chỉ có thể chứa các chữ cái, số và dấu gạch ngang.',
    'alpha_num'            => 'Thuộc tính: chỉ có thể chứa các chữ cái và số.',
    'array'                => 'Thuộc tính: phải là một mảng.',
    'before'               => 'Thuộc tính: phải là một ngày trước: ngày.',
    'before_or_equal'      => 'Thuộc tính: phải là một ngày trước hoặc bằng: ngày.',
    'between'              => [
        'numeric' => 'Thuộc tính: phải nằm giữa: min và: max.',
        'file'    => 'Thuộc tính: phải nằm trong khoảng: min và: kilobyte tối đa.',
        'string'  => 'Thuộc tính: phải nằm giữa: min và: max character.',
        'array'   => 'Thuộc tính: phải có giữa: min và: max item.',
    ],
    'boolean'              => 'Trường thuộc tính: phải đúng hoặc sai.',
    'confirmed'            => 'Xác nhận thuộc tính: không khớp.',
    'date'                 => 'Thuộc tính: không phải là một ngày hợp lệ.',
    'date_format'          => 'Thuộc tính: không khớp với định dạng: định dạng.',
    'different'            => 'Thuộc tính: và khác phải khác.',
    'digits'               => 'Thuộc tính: phải là: chữ số chữ số.',
    'digits_between'       => 'Thuộc tính: phải nằm trong khoảng: min và: chữ số tối đa.',
    'dimensions'           => 'Thuộc tính: có kích thước hình ảnh không hợp lệ.',
    'distinct'             => 'Trường thuộc tính: có một giá trị trùng lặp.',
    'email'                => 'Thuộc tính: phải là một địa chỉ email hợp lệ.',
    'exists'               => 'Thuộc tính được chọn: không hợp lệ.',
    'file'                 => 'Thuộc tính: phải là một tệp.',
    'filled'               => 'Trường thuộc tính: phải có giá trị.',
    'image'                => 'Thuộc tính: phải là một hình ảnh.',
    'in'                   => 'Thuộc tính được chọn: không hợp lệ.',
    'in_array'             => 'Trường thuộc tính: không tồn tại trong: khác.',
    'integer'              => 'Thuộc tính: phải là một số nguyên.',
    'ip'                   => 'Thuộc tính: phải là một địa chỉ IP hợp lệ.',
    'ipv4'                 => 'Thuộc tính: phải là một địa chỉ IPv4 hợp lệ..',
    'ipv6'                 => 'Thuộc tính: phải là một địa chỉ IPv6 hợp lệ.',
    'json'                 => 'Thuộc tính: phải là một chuỗi JSON hợp lệ.',
    'max'                  => [
        'numeric' => 'Thuộc tính: có thể không lớn hơn: max.',
        'file'    => 'Thuộc tính: có thể không lớn hơn: kilobyte tối đa.',
        'string'  => 'Thuộc tính: có thể không lớn hơn: ký tự tối đa.',
        'array'   => 'Thuộc tính: có thể không có nhiều hơn: các mục tối đa.',
    ],
    'mimes'                => 'Thuộc tính: phải là một tệp có kiểu :: giá trị.',
    'mimetypes'            => 'Thuộc tính: phải là một tệp có kiểu :: giá trị.',
    'min'                  => [
        'numeric' => 'Thuộc tính: ít nhất phải là: min.',
        'file'    => 'Thuộc tính: ít nhất phải là: min kilobyte.',
        'string'  => 'Thuộc tính: ít nhất phải là: ký tự tối thiểu.',
        'array'   => 'Thuộc tính: phải có ít nhất: các mục tối thiểu.',
    ],
    'not_in'               => 'Thuộc tính được chọn: không hợp lệ.',
    'numeric'              => 'Thuộc tính: phải là một số.',
    'present'              => 'Trường thuộc tính: phải có mặt.',
    'regex'                => 'Định dạng thuộc tính: không hợp lệ.',
    'required'             => 'Trường thuộc tính: là bắt buộc.',
    'required_if'          => 'Trường thuộc tính: được yêu cầu khi: other là: value.',
    'required_unless'      => 'Trường thuộc tính: được yêu cầu trừ khi: khác nằm trong: giá trị.',
    'required_with'        => 'Trường thuộc tính: được yêu cầu khi có: giá trị.',
    'required_with_all'    => 'Trường thuộc tính: được yêu cầu khi có: giá trị.',
    'required_without'     => 'Trường thuộc tính: được yêu cầu khi: không có giá trị.',
    'required_without_all' => 'Trường thuộc tính: được yêu cầu khi không có giá trị:',
    'same'                 => 'Thuộc tính: và khác phải khớp.',
    'size'                 => [
        'numeric' => 'Thuộc tính: phải là: kích thước.',
        'file'    => 'Thuộc tính: phải là: kích thước kilobyte.',
        'string'  => 'Thuộc tính: phải là: ký tự kích thước.',
        'array'   => 'Thuộc tính: phải chứa: các mục kích thước.',
    ],
    'string'               => 'Thuộc tính: phải là một chuỗi.',
    'timezone'             => 'Thuộc tính: phải là một vùng hợp lệ.',
    'unique'               => 'Thuộc tính: đã được sử dụng.',
    'uploaded'             => 'Thuộc tính: không thể tải lên.',
    'url'                  => 'Định dạng thuộc tính: không hợp lệ.',

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
