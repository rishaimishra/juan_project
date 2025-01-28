@extends('layouts.home')

@section('content')
<style>
    .select2-container{
        display: block;
        width: 100% !important;

    }
    .select2-container--default .select2-selection--multiple{
      background-color: #ececec !important;
      min-height: 60px !important;
      border-radius: 50px !important;
    }
    .left_btn{
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

<section>
      <div>
        <section class="text-center bg_color login_section">
          <h3 class="white fz36 mb-0 font_bold">{{__('lang.text_register_for_contractor')}}</h3>
        </section>

        <div class="login_form p-5 font_bold c-form">
          <form action="{{ route('contractor.create') }}" method="POST" id="myForm">
            @csrf
            <div class="container">
                <div class="row">
                  <div class="col-md-6 col-12">
                    <div class="form-group">
                      <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_razon_social')}}*</label>
                      <input class="form-control pl-4 pr-4 input_bg border_radius custom_input" name="company_name" type="text" required placeholder="Company Name" />
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group">
                      <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_pais')}}*</label>
                      <select class="form-control" id="country" name="country">
                        <option value="0" selected="">-</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->nombre }}</option>
                        @endforeach
                    </select>
                    </div>
                  </div>

                  <div class="col-md-6 col-12" id="lic_num" style="display:none;">
                    <div class="form-group">
                      <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_license')}}*</label>
                      <input class="form-control pl-4 pr-4 input_bg border_radius custom_input" name="license_num" type="text" placeholder="License Number" />
                    </div>
                  </div>
                  <div class="col-md-6 col-12" id="ins_num" style="display:none;">
                    <div class="form-group">
                      <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_insurance')}}*</label>
                      <input class="form-control pl-4 pr-4 input_bg border_radius custom_input" name="insurance_num" type="text" placeholder="Insurance Number" />
                    </div>
                  </div>

                  <div class="col-md-6 col-12">
                    <div class="form-group">
                      <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_direccion')}}*</label>
                      <input class="form-control pl-4 pr-4 input_bg border_radius custom_input" name="address" type="text" placeholder="Address" />
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group">
                      <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_codigo_postal')}}*</label>
                      <input class="form-control pl-4 pr-4 input_bg border_radius custom_input" name="postal_code" type="text" placeholder="Postal Code" />
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group">
                      <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_cif')}}</label>
                      <input class="form-control pl-4 pr-4 input_bg border_radius custom_input" name="tin" type="text" placeholder="Tax Identification Number" />
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group">
                      <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_ciudad')}}*</label>
                      <input class="form-control pl-4 pr-4 input_bg border_radius custom_input" name="city" type="text" placeholder="City" />
                    </div>
                  </div>


                  <div class="col-md-6 col-12">
                    <div class="form-group">
                      <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_provincia')}}*</label>
                      <select class="form-control" id="state" name="state">
                        <option value="0">-- choose --</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-12">
                    <h2 class="fz28 mb-5 mt-4">{{__('lang.text_representante')}}</h2>
                  </div>

                  <div class="col-md-6 col-12">
                    <div class="form-group">
                      <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_nombre')}}* </label>
                      <input class="form-control pl-4 pr-4 input_bg border_radius custom_input" name="representative_name" type="text" placeholder="Name " />
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group">
                      <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_apellidos')}}* </label>
                      <input class="form-control pl-4 pr-4 input_bg border_radius custom_input" name="last_name" type="text" placeholder="Last Name " />
                    </div>
                  </div>
                  <div class="col-md-6 col-12" id="dni">
                    <div class="form-group">
                      <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_dni')}} </label>
                      <input class="form-control pl-4 pr-4 input_bg border_radius custom_input" name="identity_document" type="text" placeholder="Identity Document " />
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group">
                      <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_telefono_empresa')}}* </label>
                      <input class="form-control pl-4 pr-4 input_bg border_radius custom_input" name="company_telephone" type="text" placeholder="Company Telephone " />
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group">
                      <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_telefono_movil')}}* </label>
                      <input class="form-control pl-4 pr-4 input_bg border_radius custom_input" name="mobile_num" type="text" placeholder="Mobile Telephone " />
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group">
                      <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_cargo')}} </label>
                      <input class="form-control pl-4 pr-4 input_bg border_radius custom_input" name="position" type="text" placeholder="Position " />
                    </div>
                  </div>

                  <div class="col-md-6 col-12">
                    <div class="form-group">
                      <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_tipo_empresa')}}*</label>
                      <select class="js-example-basic-multiple form-control" name="company_type[]" multiple="multiple">
                        {{--  <option value="0">-- choose --</option>
                        <option value="1">General Contractor</option>
                        <option value="2">Construction Manager</option>
                        <option value="3">Electrical Contractor</option>
                        <option value="4">Plumbing Contractor</option>
                        <option value="5">HVAC Contractor</option>
                        <option value="6">Roofing Contractor</option>
                        <option value="7">Masonry Contractor</option>
                        <option value="8">Drywall Contractor</option>
                        <option value="9">Carpenter Contractor</option>
                        <option value="10">Painting Contractor</option>
                        <option value="11">Landscaping Contractor</option>
                        <option value="12">Remodeling Contractor</option>
                        <option value="13">Concrete Contractor</option>
                        <option value="14">Excavation Contractor</option>
                        <option value="15">Foundation Contractor</option>
                        <option value="16">Paving Contractor</option>
                        <option value="17">Insulation Contractor</option>
                        <option value="18">Glass Contractor</option>
                        <option value="19">Interior Designer</option>
                        <option value="20">Home Improvement Contractor</option>
                        <option value="21">Home Inspector</option>
                        <option value="22">Structural Engineer</option>  --}}
                       
                        <option value="0">{{__('lang.choose')}}</option>
                        <option value="1">{{__('lang.general_contractor')}}</option>
                        <option value="2">{{__('lang.construction_manager')}}</option>
                        <option value="3">{{__('lang.electrical_contractor')}}</option>
                        <option value="4">{{__('lang.plumbing_contractor')}}</option>
                        <option value="5">{{__('lang.hvac_contractor')}}</option>
                        <option value="6">{{__('lang.roofing_contractor')}}</option>
                        <option value="7">{{__('lang.masonry_contractor')}}</option>
                        <option value="8">{{__('lang.drywall_contractor')}}</option>
                        <option value="9">{{__('lang.carpenter_contractor')}}</option>
                        <option value="10">{{__('lang.painting_contractor')}}</option>
                        <option value="11">{{__('lang.landscaping_contractor')}}</option>
                        <option value="12">{{__('lang.remodeling_contractor')}}</option>
                        <option value="13">{{__('lang.concrete_contractor')}}</option>
                        <option value="14">{{__('lang.excavation_contractor')}}</option>
                        <option value="15">{{__('lang.foundation_contractor')}}</option>
                        <option value="16">{{__('lang.paving_contractor')}}</option>
                        <option value="17">{{__('lang.insulation_contractor')}}</option>
                        <option value="18">{{__('lang.glass_contractor')}}</option>
                        <option value="19">{{__('lang.interior_designer')}}</option>
                        <option value="20">{{__('lang.home_improvement_contractor')}}</option>
                        <option value="21">{{__('lang.home_inspector')}}</option>
                        <option value="22">{{__('lang.structural_engineer')}}</option>
                        @if (session('localization') === 'es')
                           
                            <option value="23">{{__('lang.reforms_engineer')}}</option>
                            @endif
                        <!-- <option value="23">{{__('lang.reforms_engineer')}}</option> -->
                      </select>
                      {{dd(11)}}
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group">
                        <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_area_geografica')}}*</label>
                          <select class="js-example-basic-multiple3 form-control" id="state_modal" name="state_modal[]" multiple="multiple">
                          <option value="0">-- choose --</option>
                        </select>
                      <!-- <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_area_geografica')}}*</label>
                      <select class="form-control" id="geo_area_change" name="geographic_area">
                        <option value="0">-- choose --</option>
                          <option value="1">National</option>
                        <option value="2">State</option>
                      </select> -->
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group">
                      <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_email')}}*</label>
                      <input class="form-control pl-4 pr-4 input_bg border_radius custom_input" name="email" type="text" />
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group">
                      <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_contrasena')}}*</label>
                      <input class="form-control pl-4 pr-4 input_bg border_radius custom_input" name="password" type="password" />
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group">
                      <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_confirmar_contrasena')}}*</label>
                      <input class="form-control pl-4 pr-4 input_bg border_radius custom_input" name="password_confirmation" type="password" />
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group">
                      <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_accept_bidinline')}}*</label>
                      <select class="form-control" name="term_accept_value">
                          <option value="on">{{__('lang.text_yes')}}</option>
                        <option value="off">{{__('lang.text_no')}}</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6 col-12" style="display: flex; align-items: center; min-height: 100px">
                    <div class="form-group custom_checkbox" style="margin: 0">
                      <input type="hidden" value="en" name="lng" />
                      <label style="font-size: 20px; margin: 0">
                        <input type="checkbox" name="term_accept" />
                        {{__('lang.text_aceptar')}}
                        <span> <a href="javascript:void(0);">{{__('lang.text_condiciones')}}</a> </span>
                        and
                        <span> <a href="javascript:void(0);">{{__('lang.text_privacidad')}}</a> </span>
                      </label>
                    </div>
                  </div>
                  <div class="col-12">
                    <button id="button" name="button" class="btn base_btn fz20 w-100 mt-4 custom_input line_btn" type="submit">{{__('lang.text_register_company')}}</button>
                  </div>
                  <div id="singleError" style="color: red; display: none;"></div>
                  <!-- @if ($errors->any())

                      <p class="text-danger" style="text-align: center;width: 100%;margin-top: 10px;">Please fill in the required fields (*).</p>

                @endif -->



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
                </div>
              </div>
              <!-- National Modal -->



          </form>
        </div>
      </div>
    </section>


    @section('scripts')
    <x-script-component /> <!-- Include the script component here -->

        <script type="text/javascript">
          $(document).ready(function() {
              $('#country').on('change', function() {
                  var countryId = $(this).val();
                  if (countryId) {
                    $.ajax({
                        url: "{{ route('getStatesByCountry', ':country_id') }}".replace(':country_id', countryId),
                        type: 'GET',
                        success: function(data) {
                          console.log(data);
                            $('#state').empty(); // Clear any existing options
                            $('#state').append('<option value="">Select State</option>');

                            // Accessing the states property in the response
                            $.each(data.states, function(key, state) {
                                $('#state').append('<option value="' + state.id + '">' + state.nombre + '</option>');
                            });
                            $('#state_modal').empty(); // Clear any existing options
                            $('#state_modal').append('<option value="">Select State</option>');

                            // Accessing the states property in the response
                            $.each(data.states, function(key, state) {
                                $('#state_modal').append('<option value="' + state.id + '">' + state.nombre + '</option>');
                            });
                        }
                    });
                } else {
                    $('#state').empty(); // If no country selected, clear the states dropdown
                    $('#state').append('<option value="">Select State</option>');
                }
                if (countryId == 231) {
                  $("#dni").hide();
                  $("#lic_num").show();
                  $("#ins_num").show();

                }else{
                  $("#dni").show();
                  $("#ins_num").hide();
                  $("#lic_num").hide();
                }

              });
          });
        </script>

         <script type="text/javascript">
          $(document).ready(function() {
              $('#geo_area_change').on('change', function() {
               var country = document.getElementById('country');
                    countryId = country.value;
                  if (countryId) {
                      $.ajax({
                           url: "{{ route('getallStates', ':country_id') }}".replace(':country_id', countryId),
                          type: 'GET',
                          success: function(data) {
                            $('#state_modal').empty();
                            $('#state_modal').append('<option value="">Select State</option>');

                            // Populate the state dropdown with the returned states
                            $.each(data.state, function(key, state) {
                                $('#state_modal').append('<option value="' + state.id + '">' + state.nombre + '</option>');
                            });

                            // Clear the existing options in the national dropdown
                            $('#country_modal_dropdown').empty();
                            $('#country_modal_dropdown').append('<option value="">Select National</option>');

                            // Populate the national dropdown with the returned national states
                            $.each(data.national, function(key, national) {
                                $('#country_modal_dropdown').append('<option value="' + national.id + '">' + national.nombre + '</option>');
                            });
                          }
                      });
                  } else {
                      $('#state_modal').empty(); // If no country selected, clear the states dropdown
                      $('#state_modal').append('<option value="">Select State</option>');
                  }
              });
          });
        </script>


    @endsection
@endsection
