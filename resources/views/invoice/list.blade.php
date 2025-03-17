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
    <!-- Success Message -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Validation Errors -->

    <section>
        <div>
            <section class="text-center bg_color login_section">
                {{-- <h3 class="white fz36 mb-0 font_bold">{{ __('lang.text_ventas') }}</h3> --}}
                <h3 class="white fz36 mb-0 font_bold">{{ __('lang.contractor_area') }}</h3>
            </section>
            <div class="login_form p-5 font_bold c-form">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <ul class="opp_list">
                                <li><a href="{{ route('users-dashboard') }}">{{ __('lang.text_opportunity_list') }}</a>
                                </li>
                                <li><a href="{{ route('invoice-list') }}">{{ __('lang.text_facturas') }}</a></li>
                            </ul>
                        </div>
                        <div class="col-md-8">
                            {{-- <h1>{{ __('lang.text_purchase_order_list') }}</h1> --}}
                            <h1>{{ __('lang.text_facturas') }}</h1>
                            <table class="table">
                                <thead>
                                    <tr>
                                        {{-- <th scope="col">{{ __('lang.text_branch') }}</th> --}}
                                        <th scope="col">Name</th>
                                        {{-- <th scope="col">{{ __('lang.text_email') }}</th>
                                            <th scope="col">{{ __('lang.text_po_name') }}</th> --}}
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
                                                        $amount = optional(
                                                            App\Models\Opportunity::find($opp->opportunity_id),
                                                        )->est_amount;

                                                        if ($amount == 1) {
                                                            // $pay_amount = 10;
                                                            $pay_amount = 3;
                                                        } elseif ($amount == 2) {
                                                            $pay_amount = 15;
                                                            // $pay_amount = 0.15;
                                                        } elseif ($amount == 3) {
                                                            $pay_amount = 20;
                                                            // $pay_amount = 0.20;
                                                        } else {
                                                            $pay_amount = 0;
                                                        }
                                                    @endphp
                                                    <div class="d-flex flex-wrap align-items-center gap-2">

                                                        {{ __('lang.pay_via') }}:<a
                                                            href="{{ route('paypal.payment', ['amount' => $pay_amount, 'id' => $opp->id]) }}"
                                                            class="btn btn-primary btn-sm"
                                                            style="margin-left: 5px;">{{ __('lang.pay_invoice') }}</a>
                                                        <!-- {{ $opp->amount }} -->
                                                        <form id="form-{{ $opp->id }}"
                                                            action="https://pgw.ceca.es/tpvweb/tpv/compra.action"
                                                            method="POST" enctype="application/x-www-form-urlencoded"
                                                            style="display: inline">
                                                            @csrf
                                                            <input type="hidden" name="Key_encryption" value="02WLXVR4">
                                                            <input name="MerchantID" type="hidden" value="086941259"
                                                                id="merchant_id-{{ $opp->id }}">
                                                            <input name="AcquirerBIN" type="hidden" value="0000554026"
                                                                id="AcquirerBIN-{{ $opp->id }}">
                                                            <input name="TerminalID" type="hidden" value="00000003"
                                                                id="TerminalID-{{ $opp->id }}">

                                                            <input name="URL_OK" type="hidden"
                                                                value="{{ route('card.success', ['id' => $opp->id]) }}"
                                                                id="URL_OK-{{ $opp->id }}">
                                                            <input name="URL_NOK" type="hidden"
                                                                value="{{ route('invoice-list') }}"
                                                                id="URL_NOK-{{ $opp->id }}">

                                                            <input name="Firma" type="hidden" value=""
                                                                id="Firma-{{ $opp->id }}">
                                                            <input name="Cifrado" type="hidden" value="SHA2"
                                                                id="Cifrado-{{ $opp->id }}">

                                                            <input name="Num_operacion" class="form-control" type="hidden"
                                                                value="{{ $opp->id }}"
                                                                id="Num_operacion-{{ $opp->id }}">
                                                            <!-- <input name="Importe" class="form-control" type="hidden"
                                                                        value="{{ $opp->amount }}" id="Importe-{{ $opp->id }}"> -->



                                                            <input name="Importe" class="form-control" type="hidden"
                                                                value="{{ round($pay_amount, 2) * 100 }}"
                                                                id="Importe-{{ $opp->id }}">


                                                            <!-- opportunity_id -->







                                                            <input name="TipoMoneda" type="hidden" value="978"
                                                                id="TipoMoneda-{{ $opp->id }}">
                                                            <input name="Exponente" type="hidden" value="2"
                                                                id="Exponente-{{ $opp->id }}">
                                                            <input name="Pago_soportado" type="hidden" value="SSL"
                                                                id="Pago_soportado-{{ $opp->id }}">
                                                            <input name="Idioma" class="form-control" type="hidden"
                                                                value="6" id="Idioma-{{ $opp->id }}" readonly>
                                                            <button type="submit" value="Make Payment"
                                                                class="btn btn-primary generate-hash btn-sm"
                                                                style="margin-left:8px"
                                                                data-id="{{ $opp->id }}">{{ __('lang.card') }} </button>
                                                        </form>
                                                        <td>{{$pay_amount}} EURO</td>
                                                    </div>
                                                @else
                                                    @if ($todayMessages->isNotEmpty())
                                                        <style>
                                                            .new-message-icon {
                                                                display: inline-block;
                                                                margin-right: 5px;
                                                            }

                                                            .animated-arrow {
                                                                width: 18px;
                                                                height: 18px;
                                                                animation: bounce 0.8s infinite;
                                                            }

                                                            @keyframes bounce {

                                                                0%,
                                                                100% {
                                                                    transform: translateY(0);
                                                                }

                                                                50% {
                                                                    transform: translateY(-5px);
                                                                }
                                                            }
                                                        </style>
                                                        <div class="new-message-icon">
                                                            <svg class="animated-arrow" xmlns="http://www.w3.org/2000/svg"
                                                                fill="none" viewBox="0 0 24 24" stroke-width="2"
                                                                stroke="red">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M9 5l7 7-7 7" />
                                                            </svg>
                                                        </div>
                                                    @endif
                                                    @if ($opp->opportunity->admin_bit !== 3)
                                                        <a href="{{ asset('public/' . $opp->invoice_path) }}" download>
                                                            <svg style="width:30px;" xmlns="http://www.w3.org/2000/svg"
                                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor" class="size-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                                            </svg>
                                                        </a>

                                                        <a href="{{ route('contractor-message-opportunity', ['id' => $opp->id, 'oppId' => $opp->opportunity_id]) }}"
                                                            class="btn btn-primary btn-sm">{{ __('lang.message') }}</a>
                                                    @else
                                                        Window Closed
                                                    @endif
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
        <div class="modal fade" id="simpleConfirmModal" tabindex="-1" aria-labelledby="simpleConfirmModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="simpleConfirmModalLabel">Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="simpleModalMessage">
                        <!-- Message will be set dynamically -->
                    </div>
                    <div class="modal-footer">
                        <!-- No Button -->
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>

                        <!-- Yes Button -->
                        <a href="#" id="confirmAction" class="btn">Yes</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        function showSimpleModal(action) {
            const modalMessage = document.getElementById('simpleModalMessage');
            const confirmAction = document.getElementById('confirmAction');

            // Set modal message and action URL based on the button clicked
            if (action === 'approve') {
                modalMessage.textContent = "Are you sure you want to approve this item?";
                confirmAction.href = "{{ url('admin/approve') }}"; // Set the URL for approve action
                confirmAction.className = "btn btn-success"; // Set button style for approve
            } else if (action === 'reject') {
                modalMessage.textContent = "Are you sure you want to reject this item?";
                confirmAction.href = "{{ url('admin/reject') }}"; // Set the URL for reject action
                confirmAction.className = "btn btn-danger"; // Set button style for reject
            }

            // Show the modal
            const modal = new bootstrap.Modal(document.getElementById('simpleConfirmModal'));
            modal.show();
        }
    </script>

    <script>
        $(document).ready(function() {
            $(".generate-hash").on("click", function(e) {
                e.preventDefault();

                var id = $(this).data("id"); // Get the unique ID from data-id
                var merchant_id = $("#merchant_id-" + id).val();
                var AcquirerBIN = $("#AcquirerBIN-" + id).val();
                var TerminalID = $("#TerminalID-" + id).val();
                var Num_operacion = $("#Num_operacion-" + id).val();
                var Importe = $("#Importe-" + id).val();
                var TipoMoneda = $("#TipoMoneda-" + id).val();
                var Exponente = $("#Exponente-" + id).val();
                var Cifrado = $("#Cifrado-" + id).val();
                var URL_OK = $("#URL_OK-" + id).val();
                var URL_NOK = $("#URL_NOK-" + id).val();

                $.ajax({
                    type: "POST",
                    url: "{{ route('generate.hash') }}", // Laravel route
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'), // CSRF token
                        merchant_id: merchant_id,
                        AcquirerBIN: AcquirerBIN,
                        TerminalID: TerminalID,
                        Num_operacion: Num_operacion,
                        Importe: Importe,
                        TipoMoneda: TipoMoneda,
                        Exponente: Exponente,
                        Cifrado: Cifrado,
                        URL_OK: URL_OK,
                        URL_NOK: URL_NOK
                    },
                    dataType: "json",
                    success: function(response) {
                        $("#Firma-" + id).val(response.hash);
                        console.log("Hash generated:", response.hash);
                        // Submit the form after hash is generated
                        $("#form-" + id).submit();
                    },
                    error: function(xhr, status, error) {
                        console.error("Error generating hash:", error);
                    }
                });
            });
        });
    </script>
@endsection
