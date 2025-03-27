@extends('layouts.home')

@section('content')
    <style>
        ul {
            list-style-type: none;
        }

        .opp_list li a {
            color: #0772b1;
        }

        .opp_list li a:hover {
            color: #0772b1;
        }
    </style>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <section>
        <div>
            <section class="text-center bg_color login_section">
                <h3 class="white fz36 mb-0 font_bold">{{ __('lang.contractor_area') }}</h3>
            </section>
            <div class="login_form p-5 font_bold c-form">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <ul class="opp_list">
                                <li><a href="{{ route('users-dashboard') }}">{{ __('lang.text_opportunity_list') }}</a></li>
                                <li><a href="{{ route('invoice-list') }}">{{ __('lang.text_facturas') }}</a></li>
                            </ul>
                        </div>
                        <div class="col-md-8">
                            <h1>{{ __('lang.text_facturas') }}</h1>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">{{ __('lang.text_status') }}</th>
                                        <th scope="col"></th>
                                        <th scope="col">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoices as $opp)
                                        <tr>
                                            <td>{{ $opp->opportunity->opportunity_name ?? '' }}</td>
                                            <td>{{ $opp->status }}</td>
                                            <td>
                                                @if ($opp->status == 'unpaid')
                                                    @php
                                                        // Debug the opportunity and est_amount first
                                                        // dd($opp->opportunity); // Uncomment to check the opportunity object

                                                        // More robust amount calculation
                                                        $amount = $opp->opportunity->est_amount ?? 0;
                                                        $pay_amount = 0;

                                                        if ($amount == 1) {
                                                            $pay_amount = 3;
                                                        } elseif ($amount == 2) {
                                                            $pay_amount = 15;
                                                        } elseif ($amount == 3) {
                                                            $pay_amount = 20;
                                                        }

                                                        // Debug output - view page source to see this
                                                        echo "<!-- DEBUG: opportunity_id: {$opp->opportunity_id}, est_amount: {$amount}, pay_amount: {$pay_amount} -->";
                                                    @endphp
                                                    <div class="d-flex flex-wrap align-items-center gap-2">
                                                        {{ __('lang.pay_via') }}:
                                                        <a href="{{ route('paypal.payment', ['amount' => $pay_amount, 'id' => $opp->id]) }}"
                                                            class="btn btn-primary btn-sm" style="margin-left: 5px;">
                                                            {{ __('lang.pay_invoice') }}
                                                        </a>

                                                        <form id="form-{{ $opp->id }}"
                                                            action="https://pgw.ceca.es/tpvweb/tpv/compra.action"
                                                            method="POST" enctype="application/x-www-form-urlencoded"
                                                            style="display: inline">
                                                            @csrf
                                                            <input type="hidden" name="Key_encryption" value="02WLXVR4">
                                                            <input name="MerchantID" type="hidden" value="086941259">
                                                            <input name="AcquirerBIN" type="hidden" value="0000554026">
                                                            <input name="TerminalID" type="hidden" value="00000003">
                                                            <input name="URL_OK" type="hidden"
                                                                value="{{ route('card.success', ['id' => $opp->id]) }}">
                                                            <input name="URL_NOK" type="hidden"
                                                                value="{{ route('invoice-list') }}">
                                                            <input name="Firma" type="hidden" value="">
                                                            <input name="Cifrado" type="hidden" value="SHA2">
                                                            <input name="Num_operacion" type="hidden"
                                                                value="{{ str_pad($opp->id, 4, '0', STR_PAD_LEFT) }}">
                                                            <input name="Importe" type="hidden"
                                                                value="{{ round($pay_amount, 2) * 100 }}">
                                                            <input name="TipoMoneda" type="hidden" value="978">
                                                            <input name="Exponente" type="hidden" value="2">
                                                            <input name="Pago_soportado" type="hidden" value="SSL">
                                                            <input name="Idioma" type="hidden" value="6">

                                                            <button type="submit"
                                                                class="btn btn-primary generate-hash btn-sm"
                                                                style="margin-left:8px" data-id="{{ $opp->id }}"
                                                                data-key-encryption="02WLXVR4">
                                                                {{ __('lang.card') }}
                                                            </button>
                                                        </form>
                                            <td>{{ $pay_amount }} EURO</td>
                        </div>
                    @else
                        <!-- Paid invoice options remain unchanged -->
                        @endif
                        </td>
                        </tr>
                        @endforeach
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

    <script>
        $(document).ready(function() {
            $(".generate-hash").on("click", function(e) {
                e.preventDefault();

                var $button = $(this);
                var id = $button.data("id");
                var keyEncryption = $button.data("key-encryption");

                // Create a unique operation number (4 digits)
                var numOperacion = String(id).padStart(4, '0');

                // Gather all form data including the encryption key
                var formData = {
                    merchant_id: $("input[name='MerchantID']", "#form-" + id).val(),
                    AcquirerBIN: $("input[name='AcquirerBIN']", "#form-" + id).val(),
                    TerminalID: $("input[name='TerminalID']", "#form-" + id).val(),
                    Num_operacion: numOperacion,
                    Importe: $("input[name='Importe']", "#form-" + id).val(),
                    TipoMoneda: $("input[name='TipoMoneda']", "#form-" + id).val(),
                    Exponente: $("input[name='Exponente']", "#form-" + id).val(),
                    Cifrado: $("input[name='Cifrado']", "#form-" + id).val(),
                    URL_OK: $("input[name='URL_OK']", "#form-" + id).val(),
                    URL_NOK: $("input[name='URL_NOK']", "#form-" + id).val(),
                    Key_encryption: keyEncryption // Include the encryption key
                };

                console.log("Sending for hash generation:", formData);

                // Disable button to prevent multiple clicks
                $button.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing'
                    );

                $.ajax({
                    type: "POST",
                    url: "{{ route('generate.hash') }}",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        ...formData
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log("Hash received:", response);
                        if (response.hash) {
                            $("input[name='Firma']", "#form-" + id).val(response.hash);
                            $("input[name='Num_operacion']", "#form-" + id).val(numOperacion);
                            $("#form-" + id).submit();
                        } else {
                            alert("Error: No hash received from server");
                            $button.prop('disabled', false).text("{{ __('lang.card') }}");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", xhr.responseText);
                        alert("Error generating payment signature. Please try again.");
                        $button.prop('disabled', false).text("{{ __('lang.card') }}");
                    }
                });
            });
        });
    </script>
@endsection
