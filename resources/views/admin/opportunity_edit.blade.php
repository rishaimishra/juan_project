@extends('layouts.app')

@section('content')
<style>
    ul{
        list-style-type: none;
    }
    .opp_list li a{
        color: #0772b1;
    }
    .opp_list li a:hover{
        color: #0772b1;
    }
</style>
<style>
    .select2-container{
        display: block;
        width: 100% !important;

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
        <div class="container">
            <section class="text-center bg_color login_section d-flex justify-content-between">
                {{--  <h3 class="white fz36 mb-0 font_bold">{{__('lang.text_user_area')}}</h3>  --}}
                <h3 class="white fz36 mb-0 font_bold">Edit Opportunity</h3>
                <a href="{{ route('getadminopp') }}" class="btn btn-primary">Back</a>
              </section>
        </div>
       
        <div class="login_form p-5 font_bold c-form">
            <form action="{{ route('admin_update_opportunity') }}" method="POST">
              @csrf
              <input name="submit_bit" id="submit_bit" type="hidden" value="" />
              <input name="admin_bit"  type="hidden" value="0" />
              <input name="id" id="id" type="hidden" value="{{ $opportunity->id }}" />
              <div class="container">
                  <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                        <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_opportunity_name')}}</label>
                        <input class="form-control pl-4 pr-4 input_bg border_radius custom_input" value="{{ $opportunity->opportunity_name }}" name="name" type="text" placeholder="Opportunity Name" />
                        </div>
                    </div>
                     
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_provincia')}}</label>
                            <select class="form-control" name="state">
                                <option value="0">-- choose --</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state->id }}" @if($state->id == $opportunity->state) selected @endif>{{$state->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                     <!-- <div class="col-md-6 col-12">
                        <div class="form-group">
                        <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_window_with_names')}}</label>
                        <input class="form-control pl-4 pr-4 input_bg border_radius custom_input" value={{ $opportunity->window_with_name }} name="window_with_name" type="text" placeholder="Window With Name" />
                        </div>
                    </div> -->
                     <div class="col-md-6 col-12">
                        <div class="form-group">
                        <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_ciudad')}}</label>
                        <input class="form-control pl-4 pr-4 input_bg border_radius custom_input" value="{{ $opportunity->city }}" name="city" type="text" placeholder="Enter City" />
                        </div>
                    </div>
                      <div class="col-md-6 col-12">
                        <div class="form-group">
                        <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_tipo_empresa')}}*</label>
                       <select class="js-example-basic-multiple form-control" name="company_type[]" multiple="multiple">
                            <option value="0">{{ __('lang.choose') }}</option>
                            <option value="1" {{ in_array(1, json_decode($opportunity->project_type ?? '[]')) ? 'selected' : '' }}>{{ __('lang.general_contractor') }} </option>
                            <option value="2" {{ in_array(2, json_decode($opportunity->project_type ?? '[]')) ? 'selected' : '' }}>{{ __('lang.construction_manager') }} </option>
                            <option value="3" {{ in_array(3, json_decode($opportunity->project_type ?? '[]')) ? 'selected' : '' }}>{{ __('lang.electrical_contractor') }} </option>
                            <option value="4" {{ in_array(4, json_decode($opportunity->project_type ?? '[]')) ? 'selected' : '' }}>{{ __('lang.plumbing_contractor') }} </option>
                            <option value="5" {{ in_array(5, json_decode($opportunity->project_type ?? '[]')) ? 'selected' : '' }}>{{ __('lang.hvac_contractor') }} </option>
                            <option value="6" {{ in_array(6, json_decode($opportunity->project_type ?? '[]')) ? 'selected' : '' }}>{{ __('lang.roofing_contractor') }} </option>
                            <option value="7" {{ in_array(7, json_decode($opportunity->project_type ?? '[]')) ? 'selected' : '' }}>{{ __('lang.masonry_contractor') }} </option>
                            <option value="8" {{ in_array(8, json_decode($opportunity->project_type ?? '[]')) ? 'selected' : '' }}>{{ __('lang.drywall_contractor') }} </option>
                            <option value="9" {{ in_array(9, json_decode($opportunity->project_type ?? '[]')) ? 'selected' : '' }}>{{ __('lang.carpenter_contractor') }} </option>
                            <option value="10" {{ in_array(10, json_decode($opportunity->project_type ?? '[]')) ? 'selected' : '' }}>{{ __('lang.painting_contractor') }} </option>
                            <option value="11" {{ in_array(11, json_decode($opportunity->project_type ?? '[]')) ? 'selected' : '' }}>{{ __('lang.landscaping_contractor') }} </option>
                            <option value="12" {{ in_array(12, json_decode($opportunity->project_type ?? '[]')) ? 'selected' : '' }}>{{ __('lang.remodeling_contractor') }} </option>
                            <option value="13" {{ in_array(13, json_decode($opportunity->project_type ?? '[]')) ? 'selected' : '' }}>{{ __('lang.concrete_contractor') }} </option>
                            <option value="14" {{ in_array(14, json_decode($opportunity->project_type ?? '[]')) ? 'selected' : '' }}>{{ __('lang.excavation_contractor') }} </option>
                            <option value="15" {{ in_array(15, json_decode($opportunity->project_type ?? '[]')) ? 'selected' : '' }}>{{ __('lang.foundation_contractor') }} </option>
                            <option value="16" {{ in_array(16, json_decode($opportunity->project_type ?? '[]')) ? 'selected' : '' }}>{{ __('lang.paving_contractor') }} </option>
                            <option value="17" {{ in_array(17, json_decode($opportunity->project_type ?? '[]')) ? 'selected' : '' }}>{{ __('lang.insulation_contractor') }} </option>
                            <option value="18" {{ in_array(18, json_decode($opportunity->project_type ?? '[]')) ? 'selected' : '' }}>{{ __('lang.glass_contractor') }} </option>
                            <option value="19" {{ in_array(19, json_decode($opportunity->project_type ?? '[]')) ? 'selected' : '' }}>{{ __('lang.interior_designer') }} </option>
                            <option value="20" {{ in_array(20, json_decode($opportunity->project_type ?? '[]')) ? 'selected' : '' }}>{{ __('lang.home_improvement_contractor') }} </option>
                            <option value="21" {{ in_array(21, json_decode($opportunity->project_type ?? '[]')) ? 'selected' : '' }}>{{ __('lang.home_inspector') }} </option>
                            <option value="22" {{ in_array(22, json_decode($opportunity->project_type ?? '[]')) ? 'selected' : '' }}>{{ __('lang.structural_engineer') }} </option>
                            @if (session('localization') === 'es')
                                <option value="23" {{ in_array(23, json_decode($opportunity->project_type ?? '[]')) ? 'selected' : '' }}>
                                    {{ __('lang.reforms_engineer') }}
                                </option>
                            @endif

                            <option value="24" {{ in_array(24, json_decode($opportunity->project_type ?? '[]')) ? 'selected' : '' }}>Testing Inspector</option>

                            @if (session('localization') === 'es' || session('localization') === 'en' || session('localization') == '')
                             <option value="25" {{ in_array(25, json_decode($opportunity->project_type ?? '[]')) ? 'selected' : '' }}>TESTING 01</option>
                             <option value="26" {{ in_array(26, json_decode($opportunity->project_type ?? '[]')) ? 'selected' : '' }}>TESTING 02</option>
                             @endif

                        </select>
                        </div>
                    </div>
                     <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_estimated_amount')}}</label>
                            <select class="form-control" name="estimated_amount">
                                <option value="0" {{ old('est_amount', $opportunity->est_amount) == 0 ? 'selected' : '' }}>-- choose --</option>
                                <option value="1" {{ old('est_amount', $opportunity->est_amount) == 1 ? 'selected' : '' }}>Less than 5000 USD</option>
                                <option value="2" {{ old('est_amount', $opportunity->est_amount) == 2 ? 'selected' : '' }}>Between 5000 and 15000 USD</option>
                                <option value="3" {{ old('est_amount', $opportunity->est_amount) == 3 ? 'selected' : '' }}>More Than 15000 USD</option>
                            </select>
                        </div>
                    </div>
                     <div class="col-md-6 col-12">
                        <div class="form-group">
                            <!-- <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_estimated_datetime')}}</label> -->
                            <label class="col-form-label input_color fz16 pt-3">{{__('lang.estimate_start_project')}}</label>
                            <input class="form-control pl-4 pr-4 input_bg border_radius custom_input" name="date" type="datetime-local" value="{{ old('est_time', $opportunity->est_time) }}" placeholder="Enter City" />
                        </div>
                    </div>
                     <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_best_time_to_reach')}}</label>
                          <input class="form-control pl-4 pr-4 input_bg border_radius custom_input" name="time" type="time" value="{{ old('best_time', $opportunity->best_time) }}" placeholder="Enter Time" />
                        </div>
                    </div>
                     <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_descripcion')}}</label>
                            <textarea name="description" class="form-control pl-4 pr-4 input_bg border_radius custom_input" style="line-height: 1.3;height: 80px;">{{ $opportunity->detail_description }}</textarea>
                            <!-- <input class="form-control pl-4 pr-4 input_bg border_radius custom_input" value={{ $opportunity->detail_description }} name="description" type="text" placeholder="Enter Description" /> -->
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_purchase_finalized_by')}}:</label>
                            <select class="form-control" name="finalize_by">
                                <option value="0" {{ old('purchase_finalize', $opportunity->purchase_finalize) == 0 ? 'selected' : '' }}>-- choose --</option>
                                <option value="1" {{ old('purchase_finalize', $opportunity->purchase_finalize) == 1 ? 'selected' : '' }}>User</option>
                                <option value="2" {{ old('purchase_finalize', $opportunity->purchase_finalize) == 2 ? 'selected' : '' }}>BIDINLINE</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_room_open_for')}}</label>
                           <select class="form-control" name="keep_open">
                            <option value="0" {{ old('opp_keep_time', $opportunity->opp_keep_time) == 0 ? 'selected' : '' }}>-- choose --</option>
                            <option value="1" {{ old('opp_keep_time', $opportunity->opp_keep_time) == 1 ? 'selected' : '' }}>{{__('lang.one_week')}}</option>
                            <option value="2" {{ old('opp_keep_time', $opportunity->opp_keep_time) == 2 ? 'selected' : '' }}>{{__('lang.two_week')}}</option>
                            <option value="3" {{ old('opp_keep_time', $opportunity->opp_keep_time) == 3 ? 'selected' : '' }}>{{__('lang.three_week')}}</option>
                            <option value="4" {{ old('opp_keep_time', $opportunity->opp_keep_time) == 4 ? 'selected' : '' }}>{{__('lang.six_month')}}</option>
                        </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-5" onclick="setSubmitValue(0)">{{__('lang.tx_g_guardar')}}</button>
                    {{--  <button type="submit" class="btn base_btn fz20 w-100 mt-4 custom_input line_btn" onclick="setSubmitValue(1)">{{__('lang.text_publicar')}}</button>  --}}
                    

                  </div>
              </div>
            </form>
        </div>
      </div>
</section>
<script>
    function setSubmitValue(value) {
        console.log(value);
        // Set the value of the hidden input
        document.getElementById('submit_bit').value = value;
    }
</script>
@endsection