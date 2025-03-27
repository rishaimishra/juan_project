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

        @media only screen and (max-width: 500px) {
            .login_section {
                margin-top: 45px !important;
            }
        }
    </style>
    <!-- Success Message -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
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
                <!-- <h3 class="white fz36 mb-0 font_bold">{{ __('lang.text_user_area') }}</h3> -->
                <h3 class="white fz36 mb-0 font_bold">{{ __('lang.contractor_area') }}</h3>
            </section>
            <div class="login_form p-5 font_bold c-form">
                <form action="{{ route('update-opportunity') }}" method="POST">
                    @csrf
                    <input name="submit_bit" id="submit_bit" type="hidden" value="" />
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label
                                        class="col-form-label input_color fz16 pt-3">{{ __('lang.text_opportunity_name') }}</label>
                                    <input readonly class="form-control pl-4 pr-4 input_bg border_radius custom_input"
                                        value="{{ $opportunity->opportunity_name }}" name="name" type="text"
                                        placeholder="Opportunity Name" />
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label
                                        class="col-form-label input_color fz16 pt-3">{{ __('lang.text_provincia') }}</label>
                                    <select disabled class="form-control" name="state">
                                        <option value="0">-- choose --</option>
                                        @foreach ($states as $state)
                                            <option value="{{ $state->id }}"
                                                @if ($state->id == $opportunity->state) selected @endif>{{ $state->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{-- <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label
                                        class="col-form-label input_color fz16 pt-3">{{ __('lang.text_window_with_names') }}</label>
                                    <input readonly class="form-control pl-4 pr-4 input_bg border_radius custom_input"
                                        value={{ $opportunity->window_with_name }} name="window_with_name" type="text"
                                        placeholder="Window With Name" />
                                </div>
                            </div> --}}
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label
                                        class="col-form-label input_color fz16 pt-3">{{ __('lang.text_ciudad') }}</label>
                                    <input readonly class="form-control pl-4 pr-4 input_bg border_radius custom_input"
                                        value="{{ $opportunity->city }}" name="city" type="text"
                                        placeholder="Enter City" />
                                </div>
                            </div>
                            {{-- <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label
                                        class="col-form-label input_color fz16 pt-3">{{ __('lang.text_tipo_empresa') }}*</label>
                                    <select disabled class="js-example-basic-multiple form-control" name="company_type[]"
                                        multiple="multiple">
                                        <option value="0">{{ __('lang.choose') }}</option>
                                        <option value="1"
                                            {{ in_array(1, json_decode($opportunity->project_type)) ? 'selected' : '' }}>
                                            {{ __('lang.general_contractor') }}</option>
                                        <option value="2"
                                            {{ in_array(2, json_decode($opportunity->project_type)) ? 'selected' : '' }}>
                                            {{ __('lang.construction_manager') }}</option>
                                        <option value="3"
                                            {{ in_array(3, json_decode($opportunity->project_type)) ? 'selected' : '' }}>
                                            {{ __('lang.electrical_contractor') }}</option>
                                        <option value="4"
                                            {{ in_array(4, json_decode($opportunity->project_type)) ? 'selected' : '' }}>
                                            {{ __('lang.plumbing_contractor') }}</option>
                                        <option value="5"
                                            {{ in_array(5, json_decode($opportunity->project_type)) ? 'selected' : '' }}>
                                            {{ __('lang.hvac_contractor') }}</option>
                                        <option value="6"
                                            {{ in_array(6, json_decode($opportunity->project_type)) ? 'selected' : '' }}>
                                            {{ __('lang.roofing_contractor') }}</option>
                                        <option value="7"
                                            {{ in_array(7, json_decode($opportunity->project_type)) ? 'selected' : '' }}>
                                            {{ __('lang.masonry_contractor') }}</option>
                                        <option value="8"
                                            {{ in_array(8, json_decode($opportunity->project_type)) ? 'selected' : '' }}>
                                            {{ __('lang.drywall_contractor') }}</option>
                                        <option value="9"
                                            {{ in_array(9, json_decode($opportunity->project_type)) ? 'selected' : '' }}>
                                            {{ __('lang.carpenter_contractor') }}</option>
                                        <option value="10"
                                            {{ in_array(10, json_decode($opportunity->project_type)) ? 'selected' : '' }}>
                                            {{ __('lang.painting_contractor') }}</option>
                                        <option value="11"
                                            {{ in_array(11, json_decode($opportunity->project_type)) ? 'selected' : '' }}>
                                            {{ __('lang.landscaping_contractor') }}</option>
                                        <option value="12"
                                            {{ in_array(12, json_decode($opportunity->project_type)) ? 'selected' : '' }}>
                                            {{ __('lang.remodeling_contractor') }}</option>
                                        <option value="13"
                                            {{ in_array(13, json_decode($opportunity->project_type)) ? 'selected' : '' }}>
                                            {{ __('lang.concrete_contractor') }}</option>
                                        <option value="14"
                                            {{ in_array(14, json_decode($opportunity->project_type)) ? 'selected' : '' }}>
                                            {{ __('lang.excavation_contractor') }}</option>
                                        <option value="15"
                                            {{ in_array(15, json_decode($opportunity->project_type)) ? 'selected' : '' }}>
                                            {{ __('lang.foundation_contractor') }}</option>
                                        <option value="16"
                                            {{ in_array(16, json_decode($opportunity->project_type)) ? 'selected' : '' }}>
                                            {{ __('lang.paving_contractor') }}</option>
                                        <option value="17"
                                            {{ in_array(17, json_decode($opportunity->project_type)) ? 'selected' : '' }}>
                                            {{ __('lang.insulation_contractor') }}</option>
                                        <option value="18"
                                            {{ in_array(18, json_decode($opportunity->project_type)) ? 'selected' : '' }}>
                                            {{ __('lang.glass_contractor') }}</option>
                                        <option value="19"
                                            {{ in_array(19, json_decode($opportunity->project_type)) ? 'selected' : '' }}>
                                            {{ __('lang.interior_designer') }}</option>
                                        <option value="20"
                                            {{ in_array(20, json_decode($opportunity->project_type)) ? 'selected' : '' }}>
                                            {{ __('lang.home_improvement_contractor') }}</option>
                                        <option value="21"
                                            {{ in_array(21, json_decode($opportunity->project_type)) ? 'selected' : '' }}>
                                            {{ __('lang.home_inspector') }}</option>
                                        <option value="22"
                                            {{ in_array(22, json_decode($opportunity->project_type)) ? 'selected' : '' }}>
                                            {{ __('lang.structural_engineer') }}</option>
                                        @if (session('localization') === 'es')
                                            <option value="23"
                                                {{ in_array(23, json_decode($opportunity->project_type)) ? 'selected' : '' }}>
                                                {{ __('lang.reforms_engineer') }}
                                            </option>
                                        @endif
                                        <option value="24"
                                            {{ in_array(24, json_decode($opportunity->project_type)) ? 'selected' : '' }}>
                                            Testing Inspector</option>

                                        @if (session('localization') === 'es' || session('localization') === 'en' || session('localization') == '')
                                            <option value="25"
                                                {{ in_array(25, json_decode($opportunity->project_type)) ? 'selected' : '' }}>
                                                TESTING 01</option>
                                            <option value="26"
                                                {{ in_array(26, json_decode($opportunity->project_type)) ? 'selected' : '' }}>
                                                TESTING 02</option>
                                        @endif
                                        <!-- <option value="23" {{ in_array(23, json_decode($opportunity->project_type)) ? 'selected' : '' }}>{{ __('lang.reforms_engineer') }}</option> -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label
                                        class="col-form-label input_color fz16 pt-3">{{ __('lang.text_estimated_amount') }}</label>
                                    <select disabled class="form-control" name="estmiated_amount">
                                        <option value="0"
                                            {{ old('est_amount', $opportunity->est_amount) == 0 ? 'selected' : '' }}>--
                                            choose --</option>
                                        <option value="1"
                                            {{ old('est_amount', $opportunity->est_amount) == 1 ? 'selected' : '' }}>Less
                                            than 5000 USD</option>
                                        <option value="2"
                                            {{ old('est_amount', $opportunity->est_amount) == 2 ? 'selected' : '' }}>
                                            Between 5000 and 15000 USD</option>
                                        <option value="3"
                                            {{ old('est_amount', $opportunity->est_amount) == 3 ? 'selected' : '' }}>More
                                            Than 15000 USD</option>
                                    </select>
                                </div>
                            </div> --}}
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label
                                        class="col-form-label input_color fz16 pt-3">{{ __('lang.text_estimated_datetime') }}</label>
                                    <input readonly class="form-control pl-4 pr-4 input_bg border_radius custom_input"
                                        name="date" type="date"
                                        value="{{ old('est_time', \Illuminate\Support\Carbon::parse($opportunity->est_time)->format('Y-m-d')) }}"
                                        placeholder="Enter Date" />
                                </div>
                            </div>
                            {{-- <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label
                                        class="col-form-label input_color fz16 pt-3">{{ __('lang.text_best_time_to_reach') }}</label>
                                    <input readonly class="form-control pl-4 pr-4 input_bg border_radius custom_input"
                                        name="time" type="time"
                                        value="{{ old('best_time', $opportunity->best_time) }}" placeholder="Enter Time" />
                                </div>
                            </div> --}}
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label
                                        class="col-form-label input_color fz16 pt-3">{{ __('lang.text_descripcion') }}</label>
                                    <!-- <input readonly class="form-control pl-4 pr-4 input_bg border_radius custom_input"
                                        value="{{ $opportunity->detail_description }}" name="description" type="text"
                                        placeholder="Enter Description" /> -->
                                        <style>
                                            .no-extra-space {
    line-height: 1.2; /* Adjust line height to make it tighter */
    padding: 10px; /* Modify as needed */
    margin: 0; /* Remove extra margins */
    white-space: pre-wrap; /* Ensure text wraps properly */
}

                                        </style>
                                        <textarea readonly class="form-control pl-4 pr-4 input_bg border_radius custom_input no-extra-space" 
          name="description" rows="4" placeholder="Enter Description">{{ $opportunity->detail_description }}</textarea>

                                </div>
                            </div>
                            {{-- <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label
                                        class="col-form-label input_color fz16 pt-3">{{ __('lang.text_purchase_finalized_by') }}:</label>
                                    <select disabled class="form-control" name="finalize_by">
                                        <option value="0"
                                            {{ old('purchase_finalize', $opportunity->purchase_finalize) == 0 ? 'selected' : '' }}>
                                            -- choose --</option>
                                        <option value="1"
                                            {{ old('purchase_finalize', $opportunity->purchase_finalize) == 1 ? 'selected' : '' }}>
                                            User</option>
                                        <option value="2"
                                            {{ old('purchase_finalize', $opportunity->purchase_finalize) == 2 ? 'selected' : '' }}>
                                            BIDINLINE</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label
                                        class="col-form-label input_color fz16 pt-3">{{ __('lang.text_room_open_for') }}</label>
                                    <select disabled class="form-control" name="keep_open">
                                        <option value="0"
                                            {{ old('opp_keep_time', $opportunity->opp_keep_time) == 0 ? 'selected' : '' }}>
                                            -- choose --</option>
                                        <option value="1"
                                            {{ old('opp_keep_time', $opportunity->opp_keep_time) == 1 ? 'selected' : '' }}>
                                            1 Week</option>
                                        <option value="2"
                                            {{ old('opp_keep_time', $opportunity->opp_keep_time) == 2 ? 'selected' : '' }}>
                                            2 Weeks</option>
                                        <option value="3"
                                            {{ old('opp_keep_time', $opportunity->opp_keep_time) == 3 ? 'selected' : '' }}>
                                            3 Weeks</option>
                                        <option value="4"
                                            {{ old('opp_keep_time', $opportunity->opp_keep_time) == 4 ? 'selected' : '' }}>
                                            6 Months</option>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" id="submit_bit" name="submit_bit" value=""> --}}
                            @if (empty($already_exists_invoice->status))
                                <button type="button" onclick="showSimpleModal('approve')"
                                    class="btn fz20 w-100 mt-4 custom_input line_btn btn-success">{{ __('lang.interested') }}</button>
                                <a href="{{ route('reject-contractor-opportunity', ['id' => $opportunity->id]) }}"
                                    class="btn fz20 w-100 mt-4 custom_input line_btn btn-danger">{{ __('lang.not_interested') }}</a>
                                {{-- <button type="submit"
                                    class="btn fz20 w-100 mt-4 custom_input line_btn btn-success">{{ __('lang.text_approve') }}</button>
                                <button type="submit"
                                    class="btn fz20 w-100 mt-4 custom_input line_btn btn-danger">{{ __('lang.text_reject') }}</button> --}}
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal fade" id="simpleConfirmModal" tabindex="-1" aria-labelledby="simpleConfirmModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="simpleConfirmModalLabel">{{ __('lang.confirmation') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="simpleModalMessage">
                        @if ($opportunity->est_amount == 1)
                            {{-- <p>{{ __('lang.show_interest') }}</p> --}}
                            {{-- <p>{{ __('lang.generate_invoice_confirmation') }} €10 {{ __('lang.like_to_proceed') }}?</p> --}}
                            <p>{{ __('lang.show_interest') }} €3.00. {{ __('lang.like_to_proceed') }}?</p>
                        @endif
                        @if ($opportunity->est_amount == 2)
                            {{-- <p>{{ __('lang.show_interest') }}</p> --}}
                            <p>{{ __('lang.show_interest') }} €15.00. {{ __('lang.like_to_proceed') }}?</p>
                        @endif
                        @if ($opportunity->est_amount == 3)
                            {{-- <p>{{ __('lang.show_interest') }}</p> --}}
                            <p>{{ __('lang.show_interest') }} €20.00. {{ __('lang.like_to_proceed') }}?</p>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <!-- No Button -->
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>

                        <!-- Yes Button -->
                        <a href="{{ route('invoice_generate', ['id' => $opportunity->id, 'amount' => $opportunity->est_amount == 1 ? 10 : ($opportunity->est_amount == 2 ? 20 : 30)]) }}"
                            id="confirmAction" class="btn">Yes</a>
                    </div>
                </div>
            </div>
    </section>
    <script>
        function setSubmitValue(value) {
            // Set the value of the hidden input
            document.getElementById('submit_bit').value = value;
        }
    </script>
    <script>
        function showSimpleModal(action) {

            // Show the modal
            const modal = new bootstrap.Modal(document.getElementById('simpleConfirmModal'));
            modal.show();
        }
    </script>
@endsection
