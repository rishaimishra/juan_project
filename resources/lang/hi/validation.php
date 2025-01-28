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
    'required' => ':attribute फ़ील्ड आवश्यक है।',
    'email' => ':attribute एक मान्य ईमेल पता होना चाहिए।',
    'minlength' => ':attribute कम से कम :min अक्षरों का होना चाहिए।',
    'digits' => ':attribute केवल अंकों में होना चाहिए।',
    'equalTo' => ':attribute को :other से मेल खाना चाहिए।',
    'unique' => ':attribute पहले से ही लिया जा चुका है',

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
        'name'=> 'नाम',
        'company_name' => 'कंपनी का नाम',
        'company_email' => 'कंपनी का ईमेल',
        'country' => 'देश',
        'license_num' => 'लाइसेंस नंबर',
        'insurance_num' => 'बीमा नंबर',
        'address' => 'पता',
        'postal_code' => 'पोस्टल कोड',
        'city' => 'शहर',
        'state' => 'राज्य',
        'last_name' => 'अंतिम नाम',
        'company_telephone' => 'कंपनी का टेलीफोन',
        'mobile_num' => 'मोबाइल नंबर',
        'company_type[]' => 'कंपनी का प्रकार',
        'state_modal[]' => 'भौगोलिक क्षेत्र',
        'email' => 'ईमेल',
        'password' => 'पासवर्ड',
        'password_confirmation' => 'पासवर्ड की पुष्टि',
        'term_accept_value' => 'टर्म्स को स्वीकार करें',
        'term_accept' => 'नियम और शर्तें तथा गोपनीयता सूचना को स्वीकार करें'
    ],

];
