@extends('layouts.home')

@section('content')
    @php
        $country_fees = [
            'hi' => ['Less than 5000 INR', 'Between 5000 and 15000 INR', 'More Than 15000 INR'],
            'en' => ['Less than 5000 EUR', 'Between 5000 and 15000 EUR', 'More Than 15000 EUR'],
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
            {{-- <strong>Whoops! Something went wrong.</strong> --}}
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
                <h3 class="white fz36 mb-0 font_bold">{{ __('lang.text_register_for_user') }}</h3>
            </section>

            <div class="login_form p-5 font_bold c-form">
                <form action="{{ route('user.userWithJobCreate') }}" method="POST" id="userForm">
                    @csrf
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label
                                        class="col-form-label input_color fz16 pt-3">{{ __('lang.text_nombre') }}*</label>
                                    <input class="form-control pl-4 pr-4 input_bg border_radius custom_input" name="name"
                                        type="text" placeholder="Name" />
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="col-form-label input_color fz16 pt-3">{{ __('lang.text_apellidos') }}*
                                    </label>
                                    <input class="form-control pl-4 pr-4 input_bg border_radius custom_input"
                                        name="last_name" type="text" placeholder="Last Name " />
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label
                                        class="col-form-label input_color fz16 pt-3">{{ __('lang.text_direccion') }}*</label>
                                    <input class="form-control pl-4 pr-4 input_bg border_radius custom_input" name="address"
                                        type="text" placeholder="Address" />
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label
                                        class="col-form-label input_color fz16 pt-3">{{ __('lang.text_codigo_postal') }}*</label>
                                    <input class="form-control pl-4 pr-4 input_bg border_radius custom_input"
                                        name="postal_code" type="text" placeholder="Postal Code" />
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label
                                        class="col-form-label input_color fz16 pt-3">{{ __('lang.text_ciudad') }}*</label>
                                    <input class="form-control pl-4 pr-4 input_bg border_radius custom_input" name="city"
                                        type="text" placeholder="City" />
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="col-form-label input_color fz16 pt-3">{{ __('lang.text_pais') }}*</label>
                                    <select class="form-control" id="country" name="country">
                                        <option value="0" selected="">-</option>
                                        <option value="2">Albania</option>
                                        <option value="3">Algérie</option>
                                        <option value="5">Andorra</option>
                                        <option value="302">Angola</option>
                                        <option value="7">Anguilla</option>
                                        <option value="9">Antigua &amp; Barbuda</option>
                                        <option value="10">Argentina</option>
                                        <option value="12">Aruba</option>
                                        <option value="13">Australia</option>
                                        <option value="14">Austria</option>
                                        <option value="15">Azerbaijan</option>
                                        <option value="16">Bahamas</option>
                                        <option value="19">Barbados</option>
                                        <option value="20">Belarus</option>
                                        <option value="21">Belgium</option>
                                        <option value="22">Belize</option>
                                        <option value="303">Benín</option>
                                        <option value="24">Bermuda</option>
                                        <option value="26">Bolivia</option>
                                        <option value="27">Bosnia &amp; Herzegovina</option>
                                        <option value="304">Botsuana</option>
                                        <option value="30">Brazil</option>
                                        <option value="33">Bulgary</option>
                                        <option value="305">Burkina Faso</option>
                                        <option value="306">Burundi</option>
                                        <option value="307">Cabo Verde</option>
                                        <option value="308">Camer'n</option>
                                        <option value="38">Canada</option>
                                        <option value="154">Caribbean Netherlands</option>
                                        <option value="40">Cayman Islands</option>
                                        <option value="309">Centroafricana&nbsp;(República)</option>
                                        <option value="312">Chad</option>
                                        <option value="43">Chile</option>
                                        <option value="300">China </option>
                                        <option value="236">Cità del Vaticano</option>
                                        <option value="47">Colombia</option>
                                        <option value="310">Comores</option>
                                        <option value="311">Costa de Marfil</option>
                                        <option value="52">Costa Rica</option>
                                        <option value="54">Croatia</option>
                                        <option value="56">Cyprus</option>
                                        <option value="57">Czech Republic</option>
                                        <option value="58">Denmark</option>
                                        <option value="60">Dominica</option>
                                        <option value="63">Ecuador</option>
                                        <option value="64">Egypt</option>
                                        <option value="65">El Salvador</option>
                                        <option value="313">Eritrea</option>
                                        <option value="205">España</option>
                                        <option value="68">Estonia</option>
                                        <option value="314">Etiopia</option>
                                        <option value="71">Falkland Island</option>
                                        <option value="72">Feroe Islands</option>
                                        <option value="74">Finland</option>
                                        <option value="75">France</option>
                                        <option value="76">French Guiana</option>
                                        <option value="315">Gabon</option>
                                        <option value="316">Gambia</option>
                                        <option value="81">Georgia</option>
                                        <option value="82">Germany</option>
                                        <option value="317">Ghana</option>
                                        <option value="84">Gibraltar</option>
                                        <option value="85">Greece</option>
                                        <option value="86">Greenland</option>
                                        <option value="87">Grenada</option>
                                        <option value="88">Guadeloupe</option>
                                        <option value="90">Guatemala</option>
                                        <option value="94">Guiana</option>
                                        <option value="318">Guinea</option>
                                        <option value="320">Guinea Ecuatorial</option>
                                        <option value="319">Guinea-Bissau</option>
                                        <option value="97">Honduras</option>
                                        <option value="99">Hungary</option>
                                        <option value="100">Iceland</option>
                                        <option value="101">India</option>
                                        <option value="352">Iraq</option>
                                        <option value="105">Ireland</option>
                                        <option value="107">Italy</option>
                                        <option value="108">Jamaica</option>
                                        <option value="109">Japan</option>
                                        <option value="321">Kenia</option>
                                        <option value="120">Latvia</option>
                                        <option value="322">Lesoto</option>
                                        <option value="323">Liberia</option>
                                        <option value="324">Libia</option>
                                        <option value="125">Liechtenstein</option>
                                        <option value="126">Lithuania</option>
                                        <option value="127">Luxemburg</option>
                                        <option value="129">Macedonia</option>
                                        <option value="325">Madagascar</option>
                                        <option value="326">Malaui</option>
                                        <option value="327">Mali</option>
                                        <option value="135">Malta</option>
                                        <option value="148">Maroc</option>
                                        <option value="138">Martinique</option>
                                        <option value="328">Mauricio</option>
                                        <option value="329">Mauritania</option>
                                        <option value="142">México</option>
                                        <option value="144">Moldova</option>
                                        <option value="145">Monaco</option>
                                        <option value="299">Montenegro</option>
                                        <option value="147">Montserrat</option>
                                        <option value="330">Mozambique</option>
                                        <option value="332">Niger</option>
                                        <option value="331">Namibia</option>
                                        <option value="155">Netherlands</option>
                                        <option value="157">New Zealand</option>
                                        <option value="158">Nicaragua</option>
                                        <option value="333">Nigeria</option>
                                        <option value="164">Norway</option>
                                        <option value="169">Panamá</option>
                                        <option value="171">Paraguay</option>
                                        <option value="172">Perú</option>
                                        <option value="353">Philippines</option>
                                        <option value="175">Poland</option>
                                        <option value="176">Portugal</option>
                                        <option value="335">Republica del Congo</option>
                                        <option value="336">Republica Democratica del congo</option>
                                        <option value="61">República Dominicana</option>
                                        <option value="334">Ruanda</option>
                                        <option value="180">Rumania</option>
                                        <option value="181">Russia</option>
                                        <option value="187">Saint Vicente &amp; the Granadines</option>
                                        <option value="185">Saint Lucia</option>
                                        <option value="184">San Kitts &amp; Nevis</option>
                                        <option value="189">San Marino</option>
                                        <option value="186">San Pierre et Miquelon</option>
                                        <option value="337">Santo Tome y Principe</option>
                                        <option value="338">Senegal</option>
                                        <option value="193">Serbia</option>
                                        <option value="339">Seychelles</option>
                                        <option value="340">Sierra Leona</option>
                                        <option value="197">Slovakia</option>
                                        <option value="198">Slovenia</option>
                                        <option value="341">Somalia</option>
                                        <option value="202">South Africa</option>
                                        <option value="344">Suazilandia</option>
                                        <option value="342">Sudan</option>
                                        <option value="343">Sudan del Sur</option>
                                        <option value="208">Suriname</option>
                                        <option value="211">Sweden</option>
                                        <option value="212">Switzerland</option>
                                        <option value="351">Syria</option>
                                        <option value="345">Tanzania</option>
                                        <option value="346">Togo</option>
                                        <option value="221">Trinidad &amp; Tobago</option>
                                        <option value="222">Tunisie</option>
                                        <option value="223">Turkey</option>
                                        <option value="225">Turks &amp; Caicos Islands</option>
                                        <option value="347">Uganda</option>
                                        <option value="228">Ukraine</option>
                                        <option value="301">United Arab Emirates</option>
                                        <option value="230">United Kingdom</option>
                                        <option value="233">Uruguay</option>
                                        <option value="231">USA</option>
                                        <option value="237">Venezuela</option>
                                        <option value="239">Virgin Islands (UK)</option>
                                        <option value="348">Yibuti</option>
                                        <option value="349">Zambia</option>
                                        <option value="350">Zimbabue</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label
                                        class="col-form-label input_color fz16 pt-3">{{ __('lang.text_provincia') }}*</label>
                                    <select class="form-control" id="state" name="state">
                                        <option value="0">-- choose --</option>
                                    </select>
                                </div>
                            </div>




                            {{-- <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="col-form-label input_color fz16 pt-3">{{ __('lang.text_dni') }} </label>
                                    <input class="form-control pl-4 pr-4 input_bg border_radius custom_input"
                                        name="identity_document" type="text" placeholder="Identity Document " />
                                </div>
                            </div> --}}
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label
                                        class="col-form-label input_color fz16 pt-3">{{ __('lang.text_telefono_home') }}
                                    </label>
                                    <input class="form-control pl-4 pr-4 input_bg border_radius custom_input"
                                        name="home_telephone" type="text" placeholder="Company Telephone " />
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label
                                        class="col-form-label input_color fz16 pt-3">{{ __('lang.text_telefono_movil') }}*
                                    </label>
                                    <input class="form-control pl-4 pr-4 input_bg border_radius custom_input"
                                        name="mobile_num" type="text" placeholder="Mobile Telephone " />
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label
                                        class="col-form-label input_color fz16 pt-3">{{ __('lang.state_referral_code') }}
                                    </label>
                                    <select class="form-control" name="association">
                                        @foreach ($accossiations as $acc)
                                            <option value="{{ $acc['nombre'] }}">{{ $acc['nombre'] }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label
                                        class="col-form-label input_color fz16 pt-3">{{ __('lang.text_email') }}*</label>
                                    <input class="form-control pl-4 pr-4 input_bg border_radius custom_input"
                                        name="email" type="text" />
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label
                                        class="col-form-label input_color fz16 pt-3">{{ __('lang.text_contrasena') }}*</label>
                                    <input class="form-control pl-4 pr-4 input_bg border_radius custom_input"
                                        id="password" name="password" type="password" />
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label
                                        class="col-form-label input_color fz16 pt-3">{{ __('lang.text_confirmar_contrasena') }}*</label>
                                    <input class="form-control pl-4 pr-4 input_bg border_radius custom_input"
                                        name="password_confirmation" type="password" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <input name="submit_bit" id="submit_bit" type="hidden" value="" />
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label
                                        class="col-form-label input_color fz16 pt-3">{{ __('lang.text_opportunity_name') }}</label>
                                    <input class="form-control pl-4 pr-4 input_bg border_radius custom_input"
                                        name="name" type="text" placeholder="Opportunity Name" />
                                </div>
                            </div>

                            {{-- <div class="col-md-6 col-12">
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
                            </div> --}}
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label
                                        class="col-form-label input_color fz16 pt-3">{{ __('lang.text_window_with_names') }}</label>
                                    <input class="form-control pl-4 pr-4 input_bg border_radius custom_input"
                                        name="window_with_name" type="text" placeholder="Window With Name" />
                                </div>
                            </div>
                            {{-- <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label
                                        class="col-form-label input_color fz16 pt-3">{{ __('lang.text_ciudad') }}</label>
                                    <input class="form-control pl-4 pr-4 input_bg border_radius custom_input"
                                        name="city" type="text" placeholder="Enter City" />
                                </div>
                            </div> --}}
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
                                    {{--  <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_estimated_datetime')}}</label>  --}}
                                    <label
                                        class="col-form-label input_color fz16 pt-3">{{ __('lang.estimate_start_project') }}</label>
                                    <input class="form-control pl-4 pr-4 input_bg border_radius custom_input"
                                        name="date" type="datetime-local" placeholder="Enter City" />
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label
                                        class="col-form-label input_color fz16 pt-3">{{ __('lang.text_best_time_to_reach') }}</label>
                                    <input class="form-control pl-4 pr-4 input_bg border_radius custom_input"
                                        name="time" type="time" placeholder="Enter City" />
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
                            <div class="col-md-6 col-12" style="display: flex; align-items: center; min-height: 100px">
                                <div class="form-group custom_checkbox" style="margin: 0">
                                    <label style="font-size: 20px; margin: 0">
                                        <input type="checkbox" name="term_accept" />
                                        {{ __('lang.text_aceptar') }}
                                        <span> <a href="javascript:void(0);">{{ __('lang.text_condiciones') }}</a> </span>
                                        and
                                        <span> <a href="javascript:void(0);">{{ __('lang.text_privacidad') }}</a> </span>
                                    </label>
                                </div>
                            </div>
                            <button type="submit" class="btn base_btn fz20 w-100 mt-4 custom_input line_btn"
                                onclick="setSubmitValue(0)">{{ __('lang.tx_g_guardar') }}</button>
                            <div id="singleError" style="color: red; display: none;"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@section('scripts')
    <script>
        function setSubmitValue(value) {
            // Set the value of the hidden input
            document.getElementById('submit_bit').value = value;
        }
    </script>
    <x-script-component /> <!-- Include the script component here -->
@endsection
@endsection
