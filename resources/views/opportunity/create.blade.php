@extends('layouts.home')

@section('content')
    {{-- @dd($current_language) --}}
    @php
        $country_fees = [
            'hi' => ['Less than 5000 INR', 'Between 5000 and 15000 INR', 'More Than 15000 INR'],
            'en' => ['Less than 5000 USD', 'Between 5000 and 15000 USD', 'More Than 15000 USD'],
            'es' => ['Less than 5000 EUR', 'Between 5000 and 15000 EUR', 'More Than 15000 EUR'],
            'pt' => ['Less than 5000 EUR', 'Between 5000 and 15000 EUR', 'More Than 15000 EUR'],
            'it' => ['Less than 5000 EUR', 'Between 5000 and 15000 EUR', 'More Than 15000 EUR'],
        ];

        // Choose fees based on locale or default
        $fees = $country_fees[$current_language];
    @endphp
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

        @media only screen and (max-width: 500px) {
            .login_section {
                margin-top: 45px !important;
            }
        }
    </style>
    <style>
        .select2-container {
            display: block;
            width: 100% !important;

        }

        .select2-container--default .select2-selection--multiple {
            background-color: #ececec !important;
            min-height: 60px !important;
            border-radius: 50px !important;
        }

        .left_btn {
            float: right;
            margin-top: 12px;
            margin-right: 10px;

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
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>Whoops! Something went wrong.</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <section>
        <div>
            <section class="text-center bg_color login_section">
                <h3 class="white fz36 mb-0 font_bold">{{ __('lang.text_user_area') }}</h3>
            </section>
            <div class="login_form p-5 font_bold c-form">
                <form action="{{ route('store-opportunity') }}" method="POST">
                    @csrf
                    <input name="submit_bit" id="submit_bit" type="hidden" value="" />
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label
                                        class="col-form-label input_color fz16 pt-3">{{ __('lang.text_opportunity_name') }}</label>
                                    <input class="form-control pl-4 pr-4 input_bg border_radius custom_input" name="name"
                                        type="text" placeholder="Opportunity Name" />
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label
                                        class="col-form-label input_color fz16 pt-3">{{ __('lang.text_provincia') }}</label>
                                    <select class="form-control" name="state">
                                        <option value="0">-- choose --</option>
                                        @foreach ($states as $state)
                                            <option value="{{ $state->id }}">{{ $state->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{--  <div class="col-md-6 col-12">
                        <div class="form-group">
                        <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_window_with_names')}}</label>
                        <input class="form-control pl-4 pr-4 input_bg border_radius custom_input" name="window_with_name" type="text" placeholder="Window With Name" />
                        </div>
                    </div>  --}}
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="col-form-label input_color fz16 pt-3">{{ __('lang.text_ciudad') }}</label>
                                    <input class="form-control pl-4 pr-4 input_bg border_radius custom_input" name="city"
                                        type="text" placeholder="Enter City" />
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label
                                        class="col-form-label input_color fz16 pt-3">{{ __('lang.text_tipo_empresa') }}*</label>
                                    <select class="js-example-basic-multiple form-control" name="company_type[]"
                                        multiple="multiple">
                                        <option value="0" disabled="disabled">{{ __('lang.choose') }}</option>
                                        @foreach ($company_type as $item)
                                            <option value="{{ $item->id }}">
                                                @if ($current_language == 'es')
                                                    {{ $item->es_text }}
                                                @elseif($current_language == 'hi')
                                                    {{ $item->hi_text }}
                                                @elseif($current_language == 'it')
                                                    {{ $item->pur_text }}
                                                @elseif($current_language == 'pt')
                                                    {{ $item->br_text }}
                                                @else
                                                    {{ $item->name }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    {{-- <option value="1">{{ __('lang.general_contractor') }}</option>
                                        <option value="2">{{ __('lang.construction_manager') }}</option>
                                        <option value="3">{{ __('lang.electrical_contractor') }}</option>
                                        <option value="4">{{ __('lang.plumbing_contractor') }}</option>
                                        <option value="5">{{ __('lang.hvac_contractor') }}</option>
                                        <option value="6">{{ __('lang.roofing_contractor') }}</option>
                                        <option value="7">{{ __('lang.masonry_contractor') }}</option>
                                        <option value="8">{{ __('lang.drywall_contractor') }}</option>
                                        <option value="9">{{ __('lang.carpenter_contractor') }}</option>
                                        <option value="10">{{ __('lang.painting_contractor') }}</option>
                                        <option value="11">{{ __('lang.landscaping_contractor') }}</option>
                                        <option value="12">{{ __('lang.remodeling_contractor') }}</option>
                                        <option value="13">{{ __('lang.concrete_contractor') }}</option>
                                        <option value="14">{{ __('lang.excavation_contractor') }}</option>
                                        <option value="15">{{ __('lang.foundation_contractor') }}</option>
                                        <option value="16">{{ __('lang.paving_contractor') }}</option>
                                        <option value="17">{{ __('lang.insulation_contractor') }}</option>
                                        <option value="18">{{ __('lang.glass_contractor') }}</option>
                                        <option value="19">{{ __('lang.interior_designer') }}</option>
                                        <option value="20">{{ __('lang.home_improvement_contractor') }}</option>
                                        <option value="21">{{ __('lang.home_inspector') }}</option>
                                        <option value="22">{{ __('lang.structural_engineer') }}</option>
                                        @if (session('localization') === 'es')
                                            <option value="23">{{ __('lang.reforms_engineer') }}</option>
                                        @endif
                                        <option value="24">Testing Inspector</option>

                                        @if (session('localization') === 'es' || session('localization') === 'en' || session('localization') == '')
                                            <option value="25">TESTING 01</option>
                                            <option value="26">TESTING 02</option>
                                        @endif --}}
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label
                                        class="col-form-label input_color fz16 pt-3">{{ __('lang.text_estimated_amount') }}</label>
                                    <select class="form-control" name="estimated_amount">
                                        <option value="0">-- choose --</option>
                                        @foreach ($fees as $key => $fee)
                                            <option value="{{ $key + 1 }}">{{ $fee }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label
                                        class="col-form-label input_color fz16 pt-3">{{ __('lang.estimate_start_project') }}</label>
                                    <input class="form-control pl-4 pr-4 input_bg border_radius custom_input" name="date"
                                        type="datetime-local" placeholder="Enter Date" id="datetimeInput"
                                        min="{{ now()->format('Y-m-d\TH:i') }}" {{-- Server-side min date (today) --}} />
                                </div>
                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const datetimeInput = document.getElementById('datetimeInput');
                                    const now = new Date();

                                    // Set min to current date/time (client-side)
                                    const year = now.getFullYear();
                                    const month = String(now.getMonth() + 1).padStart(2, '0');
                                    const day = String(now.getDate()).padStart(2, '0');
                                    const hours = String(now.getHours()).padStart(2, '0');
                                    const minutes = String(now.getMinutes()).padStart(2, '0');

                                    const minDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
                                    datetimeInput.min = minDateTime;

                                    // Client-side validation (only needed if browser doesn't enforce min)
                                    datetimeInput.addEventListener('change', function() {
                                        const selectedDate = new Date(this.value);
                                        const today = new Date();

                                        // Allow same day (ignore time comparison)
                                        if (selectedDate < today && selectedDate.toDateString() !== today.toDateString()) {
                                            alert('You cannot select a past date.');
                                            this.value = '';
                                        }
                                    });
                                });
                            </script>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label
                                        class="col-form-label input_color fz16 pt-3">{{ __('lang.text_best_time_to_reach') }}</label>
                                    <input class="form-control pl-4 pr-4 input_bg border_radius custom_input" name="time"
                                        type="time" placeholder="Enter City" />
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label
                                        class="col-form-label input_color fz16 pt-3">{{ __('lang.text_descripcion') }}</label>
                                    <textarea name="description" class="form-control pl-4 pr-4 input_bg border_radius custom_input"
                                        style="line-height: 1.3;height: 80px;"></textarea>
                                    {{-- <input class="form-control pl-4 pr-4 input_bg border_radius custom_input" name="description" type="text" placeholder="Enter Description" /> --}}
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label
                                        class="col-form-label input_color fz16 pt-3">{{ __('lang.text_purchase_finalized_by') }}</label>
                                    <select class="form-control" name="finalize_by">
                                        <option value="0">-- choose --</option>
                                        <option value="1">User</option>
                                        <option value="2">BIDINLINE</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label
                                        class="col-form-label input_color fz16 pt-3">{{ __('lang.text_room_open_for') }}</label>
                                    <select class="form-control" name="keep_open">
                                        <option value="0">-- choose --</option>
                                        <option value="1">{{ __('lang.one_week') }}</option>
                                        <option value="2">{{ __('lang.two_week') }}</option>
                                        <option value="3">{{ __('lang.three_week') }}</option>
                                        <option value="4">{{ __('lang.six_month') }}</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn base_btn fz20 w-100 mt-4 custom_input line_btn"
                                onclick="setSubmitValue(0)">{{ __('lang.tx_g_guardar') }}</button>
                            <button type="submit" class="btn base_btn fz20 w-100 mt-4 custom_input line_btn"
                                onclick="setSubmitValue(1)">{{ __('lang.text_publicar') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script>
        function setSubmitValue(value) {
            // Set the value of the hidden input
            document.getElementById('submit_bit').value = value;
        }
    </script>
@endsection
