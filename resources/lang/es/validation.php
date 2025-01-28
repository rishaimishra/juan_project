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
    'required' => 'El campo :attribute es obligatorio.',
    'email' => 'El campo :attribute debe ser una dirección de correo electrónico válida.',
    'minlength' => 'El campo :attribute debe tener al menos :min caracteres.',
    'digits' => 'El campo :attribute debe contener solo dígitos.',
    'equalTo' => 'El campo :attribute debe coincidir con :other.',
    'unique' => 'El :attribute ya ha sido tomado.',

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
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'required' => ':attribute el campo de atributo es obligatorio',
    'email' => ':attribute Por favor, introduce una dirección de correo electrónico válida',
    'minlength' => ':attribute debe tener al menos :min caracteres',
    'digits' => ':attribute El atributo debe contener sólo dígitos',
    'equalTo' => ':attribute El atributo debe coincidir con :other',

    'attributes' => [
        'name'=> 'nombre',
        'company_name' => 'nombre de la empresa',
        'company_email' => 'correo electrónico de la empresa',
        'country' => 'país',
        'license_num' => 'número de licencia',
        'insurance_num' => 'número de seguro',
        'address' => 'dirección',
        'postal_code' => 'código postal',
        'city' => 'ciudad',
        'state' => 'estado',
        'last_name' => 'apellido',
        'company_telephone' => 'teléfono de la empresa',
        'mobile_num' => 'número de móvil',
        'company_type[]' => 'tipo de empresa',
        'state_modal[]' => 'área geográfica',
        'email' => 'correo electrónico',
        'password' => 'contraseña',
        'password_confirmation' => 'confirmación de contraseña',
        'term_accept_value' => 'aceptar términos',
        'term_accept' => 'Aceptar los Términos y Condiciones y el Aviso de Privacidad'
    ],

];
