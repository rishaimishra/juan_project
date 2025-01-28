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
    'required' => 'O campo :attribute é obrigatório.',
    'email' => 'O campo :attribute deve ser um endereço de e-mail válido.',
    'minlength' => 'O campo :attribute deve ter pelo menos :min caracteres.',
    'digits' => 'O campo :attribute deve conter apenas dígitos.',
    'equalTo' => 'O campo :attribute deve corresponder a :other.',
    'unique' => 'O campo :attribute já foi tomada.',

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

    'attributes' => [
        'name'=> 'nome',
        'company_name' => 'nome da empresa',
        'company_email' => 'email da empresa',
        'country' => 'país',
        'license_num' => 'número da licença',
        'insurance_num' => 'número do seguro',
        'address' => 'endereço',
        'postal_code' => 'código postal',
        'city' => 'cidade',
        'state' => 'estado',
        'last_name' => 'sobrenome',
        'company_telephone' => 'telefone da empresa',
        'mobile_num' => 'número de celular',
        'company_type[]' => 'tipo de empresa',
        'state_modal[]' => 'área geográfica',
        'email' => 'email',
        'password' => 'senha',
        'password_confirmation' => 'confirmação da senha',
        'term_accept_value' => 'aceitar termos',
        'term_accept' => 'Aceitar os Termos e Condições e o Aviso de Privacidade'
    ],

];
