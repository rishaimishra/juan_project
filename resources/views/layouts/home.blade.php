<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Register form</title>
    <meta charset="UTF-8">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Gothic+A1:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('public/assets/css/jquery-ui.css') }}" />
    <link href="{{ asset('public/assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/css/media.css') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.2/emojionearea.min.css" />
    <script type="text/javascript" src="{{ asset('public/assets/js/jquery.min.js') }}"></script>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-PL6B14B177"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        section+div.p-5 { padding: 20px 10px !important; }
    </style>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-PL6B14B177');
    </script>
</head>

<body>
    @include('includes.header')
    @yield('content')
    @include('includes.footer')
    @yield('scripts')
    <!-- <script src="{{ asset('public/assets/js/jquery-2.2.4.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/assets/js/jquery-1.12.4.js') }}" type="text/javascript"></script> -->
    <script src="{{ asset('public/assets/js/jquery-ui.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/assets/js/popper.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/assets/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.2/emojionearea.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#emojionearea1").emojioneArea({
                pickerPosition: "left",
                tonesStyle: "bullet"
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#messageText").emojioneArea({
                pickerPosition: "left",
                tonesStyle: "bullet"
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Get validation messages from Laravel's translation files
            let validationMessages = @json(__('validation'));

            $("#myForm").validate({
                rules: {
                    company_name: {
                        required: true,
                        minlength: 3
                    },
                    country: {
                        required: true
                    },
                    license_num: {
                        required: true
                    },
                    insurance_num: {
                        required: true
                    },
                    address: {
                        required: true
                    },
                    postal_code: {
                        required: true,
                        digits: true,
                        minlength: 5
                    },
                    city: {
                        required: true
                    },
                    state: {
                        required: true
                    },
                    last_name: {
                        required: true
                    },
                    company_telephone: {
                        required: true,
                        digits: true
                    },
                    mobile_num: {
                        required: true,
                        digits: true
                    },
                    "company_type[]": {
                        required: true
                    },
                    "state_modal[]": {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 8
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "input[name='password']"
                    },
                    term_accept_value: {
                        required: true
                    },
                    term_accept: {
                        required: true
                    }
                },
                messages: {
                    company_name: {
                        required: validationMessages.required.replace(':attribute', validationMessages
                            .attributes.company_name),
                        minlength: validationMessages.minlength.replace(':attribute', validationMessages
                            .attributes.company_name).replace(':min', '3')
                    },
                    country: {
                        required: validationMessages.required.replace(':attribute', validationMessages
                            .attributes.country)
                    },
                    license_num: {
                        required: validationMessages.required.replace(':attribute', validationMessages
                            .attributes.license_num)
                    },
                    insurance_num: {
                        required: validationMessages.required.replace(':attribute', validationMessages
                            .attributes.insurance_num)
                    },
                    address: {
                        required: validationMessages.required.replace(':attribute', validationMessages
                            .attributes.address)
                    },
                    postal_code: {
                        required: validationMessages.required.replace(':attribute', validationMessages
                            .attributes.postal_code),
                        digits: validationMessages.digits.replace(':attribute', validationMessages
                            .attributes.postal_code),
                        minlength: validationMessages.minlength.replace(':attribute', validationMessages
                            .attributes.postal_code).replace(':min', '5')
                    },
                    city: {
                        required: validationMessages.required.replace(':attribute', validationMessages
                            .attributes.city)
                    },
                    state: {
                        required: validationMessages.required.replace(':attribute', validationMessages
                            .attributes.state)
                    },
                    last_name: {
                        required: validationMessages.required.replace(':attribute', validationMessages
                            .attributes.last_name)
                    },
                    company_telephone: {
                        required: validationMessages.required.replace(':attribute', validationMessages
                            .attributes.company_telephone),
                        digits: validationMessages.digits.replace(':attribute', validationMessages
                            .attributes.company_telephone)
                    },
                    mobile_num: {
                        required: validationMessages.required.replace(':attribute', validationMessages
                            .attributes.mobile_num),
                        digits: validationMessages.digits.replace(':attribute', validationMessages
                            .attributes.mobile_num)
                    },
                    "company_type[]": {
                        required: validationMessages.required.replace(':attribute', validationMessages
                            .attributes['company_type[]'])
                    },
                    "state_modal[]": {
                        required: validationMessages.required.replace(':attribute', validationMessages
                            .attributes['state_modal[]'])
                    },
                    email: {
                        required: validationMessages.required.replace(':attribute', validationMessages
                            .attributes.email),
                        email: validationMessages.email
                    },
                    password: {
                        required: validationMessages.required.replace(':attribute', validationMessages
                            .attributes.password),
                        minlength: validationMessages.minlength.replace(':attribute', validationMessages
                            .attributes.password).replace(':min', '8')
                    },
                    password_confirmation: {
                        required: validationMessages.required.replace(':attribute', validationMessages
                            .attributes.password_confirmation),
                        equalTo: validationMessages.equalTo.replace(':attribute', validationMessages
                            .attributes.password_confirmation).replace(':other', validationMessages
                            .attributes.password)
                    },
                    term_accept_value: {
                        required: validationMessages.required.replace(':attribute', validationMessages
                            .attributes.term_accept_value)
                    },
                    term_accept: {
                        required: validationMessages.required.replace(':attribute', validationMessages
                            .attributes.term_accept)
                    }
                },
                errorPlacement: function(error, element) {
                    $("#singleError").html(error).show();
                },
                showErrors: function(errorMap, errorList) {
                    if (errorList.length) {
                        $("#singleError").html(errorList[0].message).show();
                    }
                },
                success: function(label) {
                    $("#singleError").hide();
                },
                submitHandler: function(form) {
                    form.submit(); // Or use AJAX to submit the form
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Get validation messages from Laravel's translation files
            let validationMessages = @json(__('validation'));

            $("#userForm").validate({
                rules: {
                    name: {
                        required: true,
                    },
                    last_name: {
                        required: true
                    },
                    address: {
                        required: true
                    },
                    postal_code: {
                        required: true
                    },
                    city: {
                        required: true
                    },
                    country: {
                        required: true,
                    },
                    state: {
                        required: true
                    },
                    // identity_document: {
                    //     required: true,
                    // },
                    mobile_num: {
                        required: true,
                        digits: true
                    },
                    //home_telephone: {
                    //  required: true,
                    //digits: true
                    //},
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 8
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "#password"
                    },
                    term_accept: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: validationMessages.required.replace(':attribute', validationMessages
                            .attributes.name)
                    },
                    last_name: {
                        required: validationMessages.required.replace(':attribute', validationMessages
                            .attributes.last_name)
                    },
                    address: {
                        required: validationMessages.required.replace(':attribute', validationMessages
                            .attributes.address)
                    },
                    postal_code: {
                        required: validationMessages.required.replace(':attribute', validationMessages
                            .attributes.postal_code),
                        digits: validationMessages.digits.replace(':attribute', validationMessages
                            .attributes.postal_code),
                        minlength: validationMessages.minlength.replace(':attribute', validationMessages
                            .attributes.postal_code).replace(':min', '5')
                    },
                    city: {
                        required: validationMessages.required.replace(':attribute', validationMessages
                            .attributes.city)
                    },
                    country: {
                        required: validationMessages.required.replace(':attribute', validationMessages
                            .attributes.country)
                    },
                    state: {
                        required: validationMessages.required.replace(':attribute', validationMessages
                            .attributes.state)
                    },
                    // identity_document: {
                    //     required: validationMessages.required.replace(':attribute', validationMessages.attributes.identity_document)
                    // },
                    mobile_num: {
                        required: validationMessages.required.replace(':attribute', validationMessages
                            .attributes.mobile_num),
                        digits: validationMessages.digits.replace(':attribute', validationMessages
                            .attributes.mobile_num)
                    },
                    // home_telephone: {
                    //     required: validationMessages.required.replace(':attribute', validationMessages.attributes.home_telephone),
                    //     digits: validationMessages.digits.replace(':attribute', validationMessages.attributes.home_telephone)
                    // },
                    email: {
                        required: validationMessages.required.replace(':attribute', validationMessages
                            .attributes.email),
                        email: validationMessages.email
                    },
                    password: {
                        required: validationMessages.required.replace(':attribute', validationMessages
                            .attributes.password),
                        minlength: validationMessages.minlength.replace(':attribute', validationMessages
                            .attributes.password).replace(':min', '8')
                    },
                    password_confirmation: {
                        required: validationMessages.required.replace(':attribute', validationMessages
                            .attributes.password_confirmation),
                        equalTo: validationMessages.equalTo.replace(':attribute', validationMessages
                            .attributes.password_confirmation).replace(':other', validationMessages
                            .attributes.password)
                    },
                    term_accept: {
                        required: validationMessages.required.replace(':attribute', validationMessages
                            .attributes.term_accept)
                    }
                },
                errorPlacement: function(error, element) {
                    $("#singleError").html(error).show();
                },
                showErrors: function(errorMap, errorList) {
                    if (errorList.length) {
                        $("#singleError").html(errorList[0].message).show();
                    }
                },
                success: function(label) {
                    $("#singleError").hide();
                },
                submitHandler: function(form) {
                    form.submit(); // Or use AJAX to submit the form
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
        $(document).ready(function() {
            $('.js-example-basic-multiple1').select2();
        });
        $(document).ready(function() {
            $('.js-example-basic-multiple2').select2();
        });
        $(document).ready(function() {
            $('.js-example-basic-multiple3').select2();
        });
    </script>
    <script>
        $("#mensaje").remove();

        $("input[type=file]").change(function() {
            var filename = $(this).val();
            var name = filename.replace(/^.*[\\/]/, "");
            $(this).next("span").text(name);
        });
    </script>
    <script type="text/javascript">
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-121941137-1']);
        _gaq.push(['_trackPageview']);

        (function() {
            var ga = document.createElement('script');
            ga.type = 'text/javascript';
            ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') +
                '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(ga, s);
        })();
    </script>
    {{-- <script type="text/javascript">
        var result = Date.now();


        $(document).ready(function() {
            $.ajax({
                url: "https://ctbarbanza.com/historic/index.php/web/tick/SOA35byBwgaDmHWhfCIu9QDdmFqe7ZF6b2nkJ48GVJi1YoRshMCxUYl5tjz6GPxVMHfw3LKKpuETydXAXvgR9B0Ev7Lcrt0sOQqS?t=" +
                    result,
                method: "GET"
            });
        });
    </script> --}}
</body>

</html>
