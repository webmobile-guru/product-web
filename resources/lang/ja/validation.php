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

    'accepted'             => '：attributeを受け入れる必要があります。',
    'active_url'           => '：attributeは有効なURLではありません。',
    'after'                => '：attributeは：dateより後の日付でなければなりません。',
    'after_or_equal'       => '：attributeは、：date以降の日付でなければなりません。',
    'alpha'                => '：attributeには文字のみを含めることができます。',
    'alpha_dash'           => '：attributeには、文字、数字、ダッシュのみを含めることができます。',
    'alpha_num'            => '：attributeには文字と数字のみを含めることができます。',
    'array'                => '：attributeは配列でなければなりません。',
    'before'               => '：attributeは：dateより前の日付でなければなりません。',
    'before_or_equal'      => '：attributeは、：date以前の日付でなければなりません。',
    'between'              => [
        'numeric' => '：attributeは：minと：maxの間でなければなりません。',
        'file'    => '：attributeは：minから：maxキロバイトの間になければなりません。',
        'string'  => '：attributeは：min〜：max文字の間になければなりません。',
        'array'   => '：attributeには：min〜：maxのアイテムが必要です。',
    ],
    'boolean'              => '：attributeフィールドはtrueまたはfalseでなければなりません。',
    'confirmed'            => '：attributeの確認が一致しません。',
    'date'                 => '：attributeは有効な日付ではありません。',
    'date_format'          => '：attributeは：formatの形式と一致しません。',
    'different'            => '：attributeと：otherは異なっていなければなりません。',
    'digits'               => '：attributeは：digits桁でなければなりません。',
    'digits_between'       => '：attributeは、：min〜：maxの数字である必要があります。',
    'dimensions'           => '：attributeの画像の寸法が無効です。',
    'distinct'             => '：attributeフィールドに重複した値があります。',
    'email'                => '：attributeは有効なメールアドレスでなければなりません。',
    'exists'               => '選択された：attributeは無効です。',
    'file'                 => '：attributeはファイルでなければなりません。',
    'filled'               => '：attributeフィールドには値が必要です。',
    'image'                => '：attributeは画像でなければなりません。',
    'in'                   => '選択された：attributeは無効です。',
    'in_array'             => '：attributeフィールドは：otherに存在しません。',
    'integer'              => '：attributeは整数でなければなりません.',
    'ip'                   => '：attributeは有効なIPアドレスでなければなりません。',
    'ipv4'                 => '：attributeは有効なIPv4アドレスでなければなりません。',
    'ipv6'                 => '：attributeは有効なIPv6アドレスでなければなりません。',
    'json'                 => '：attributeは有効なJSON文字列でなければなりません。',
    'max'                  => [
        'numeric' => '：attributeは：maxより大きくてはいけません。',
        'file'    => '：attributeは：maxキロバイトを超えることはできません。',
        'string'  => '：attributeは、：max文字を超えることはできません。',
        'array'   => '：attributeには、：maxアイテムを超えることはできません。',
    ],
    'mimes'                => '：attributeは、タイプ：valuesのファイルでなければなりません。',
    'mimetypes'            => '：attributeは、タイプ：valuesのファイルでなければなりません。',
    'min'                  => [
        'numeric' => '：attributeは少なくとも：minでなければなりません。',
        'file'    => '：attributeは少なくとも：minキロバイトでなければなりません。',
        'string'  => '：attributeは少なくとも：min文字でなければなりません。',
        'array'   => '：attributeには少なくとも：min個のアイテムが必要です。',
    ],
    'not_in'               => '選択された：attributeは無効です。',
    'numeric'              => '：attributeは数値でなければなりません。',
    'present'              => '：attributeフィールドが存在する必要があります。',
    'regex'                => '：attribute形式は無効です。',
    'required'             => '：attributeフィールドは必須です。',
    'required_if'          => '：otherが：valueの場合、：attributeフィールドは必須です。',
    'required_unless'      => '：othersが：valuesにない限り、：attributeフィールドは必須です。',
    'required_with'        => '：valuesが存在する場合、：attributeフィールドは必須です.',
    'required_with_all'    => '：valuesが存在する場合、：attributeフィールドは必須です。',
    'required_without'     => '：valuesが存在しない場合、：attributeフィールドは必須です。',
    'required_without_all' => '：valuesが存在しない場合、：attributeフィールドは必須です。',
    'same'                 => '：attributeと：otherは一致する必要があります。',
    'size'                 => [
        'numeric' => '：attributeは：sizeでなければなりません。',
        'file'    => '：attributeは：sizeキロバイトでなければなりません.',
        'string'  => '：attributeは：size文字でなければなりません。',
        'array'   => '：attributeには：sizeアイテムを含める必要があります。',
    ],
    'string'               => '：attributeは文字列でなければなりません。',
    'timezone'             => '：attributeは有効なゾーンでなければなりません.',
    'unique'               => '：attributeはすでに使用されています。',
    'uploaded'             => '：attributeはアップロードに失敗しました。',
    'url'                  => '：attribute形式は無効です。',

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
