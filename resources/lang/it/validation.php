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
   'required' => 'Il campo :attribute è obbligatorio.',
    'email' => ':attribute deve essere un indirizzo email valido.',
    'minlength' => ':attribute deve essere di almeno :min caratteri.',
    'digits' => ':attribute deve contenere solo cifre.',
    'equalTo' => ':attribute deve corrispondere a :other.',
    'unique' => ':attribute è già stata presa.',

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
        'company_name' => 'nome dell\'azienda',
        'company_email' => 'email dell\'azienda',
        'country' => 'paese',
        'license_num' => 'numero di licenza',
        'insurance_num' => 'numero di assicurazione',
        'address' => 'indirizzo',
        'postal_code' => 'codice postale',
        'city' => 'città',
        'state' => 'stato',
        'last_name' => 'cognome',
        'company_telephone' => 'telefono dell\'azienda',
        'mobile_num' => 'numero di cellulare',
        'company_type[]' => 'tipo di azienda',
        'state_modal[]' => 'area geografica',
        'email' => 'email',
        'password' => 'password',
        'password_confirmation' => 'conferma password',
        'term_accept_value' => 'accettare i termini',
        'term_accept' => 'Accettare i Termini e le Condizioni e l`Informativa sulla Privacy'
    ],

];
