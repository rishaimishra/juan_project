@extends('layouts.home')

@section('content')
<style>
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
          {{--  <h3 class="white fz36 mb-0 font_bold">{{__('lang.text_register_for_user')}}</h3>  --}}
          <h3 class="white fz36 mb-0 font_bold">{{__('lang.edit_profile')}}</h3>
        </section>

        <div class="login_form p-5 font_bold c-form">
        <form action="{{ route('update-profile') }}" method="POST" id="userForm">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            <input type="hidden" name="user_type" value="{{ $user_type }}">
          <div class="container">
              <div class="row">
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_nombre')}}*</label>
                    <input class="form-control pl-4 pr-4 input_bg border_radius custom_input" value="{{ $user->name }}" name="name" type="text" placeholder="Name" />
                  </div>
                </div>

                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_apellidos')}}* </label>
                    <input class="form-control pl-4 pr-4 input_bg border_radius custom_input" value="{{ $user->last_name }}" name="last_name" type="text" placeholder="Last Name " />
                  </div>
                </div>


                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_direccion')}}*</label>
                    <input class="form-control pl-4 pr-4 input_bg border_radius custom_input" value="{{ $user->address }}" name="address" type="text" placeholder="Address" />
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_codigo_postal')}}*</label>
                    <input class="form-control pl-4 pr-4 input_bg border_radius custom_input" value="{{ $user->postal_code }}" name="postal_code" type="text" placeholder="Postal Code" />
                  </div>
                </div>

                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_ciudad')}}*</label>
                    <input class="form-control pl-4 pr-4 input_bg border_radius custom_input" value="{{ $user->city }}" name="city" type="text" placeholder="City" />
                  </div>
                </div>

                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_pais')}}*</label>
                    <select class="form-control" id="country" name="country" disabled>
                      <option value="0" selected="">-</option>
                      <option value="2" @if(@$user->country == "2") selected @endif>Albania</option>
    <option value="3" @if(@$user->country == "3") selected @endif>Algérie</option>
    <option value="5" @if(@$user->country == "5") selected @endif>Andorra</option>
    <option value="302" @if(@$user->country == "302") selected @endif>Angola</option>
    <option value="7" @if(@$user->country == "7") selected @endif>Anguilla</option>
    <option value="9" @if(@$user->country == "9") selected @endif>Antigua &amp; Barbuda</option>
    <option value="10" @if(@$user->country == "10") selected @endif>Argentina</option>
    <option value="12" @if(@$user->country == "12") selected @endif>Aruba</option>
    <option value="13" @if(@$user->country == "13") selected @endif>Australia</option>
    <option value="14" @if(@$user->country == "14") selected @endif>Austria</option>
    <option value="15" @if(@$user->country == "15") selected @endif>Azerbaijan</option>
    <option value="16" @if(@$user->country == "16") selected @endif>Bahamas</option>
    <option value="19" @if(@$user->country == "19") selected @endif>Barbados</option>
    <option value="20" @if(@$user->country == "20") selected @endif>Belarus</option>
    <option value="21" @if(@$user->country == "21") selected @endif>Belgium</option>
    <option value="22" @if(@$user->country == "22") selected @endif>Belize</option>
    <option value="303" @if(@$user->country == "303") selected @endif>Benín</option>
    <option value="24" @if(@$user->country == "24") selected @endif>Bermuda</option>
    <option value="26" @if(@$user->country == "26") selected @endif>Bolivia</option>
    <option value="27" @if(@$user->country == "27") selected @endif>Bosnia &amp; Herzegovina</option>
    <option value="304" @if(@$user->country == "304") selected @endif>Botsuana</option>
    <option value="30" @if(@$user->country == "30") selected @endif>Brazil</option>
    <option value="33" @if(@$user->country == "33") selected @endif>Bulgary</option>
    <option value="305" @if(@$user->country == "305") selected @endif>Burkina Faso</option>
    <option value="306" @if(@$user->country == "306") selected @endif>Burundi</option>
    <option value="307" @if(@$user->country == "307") selected @endif>Cabo Verde</option>
    <option value="308" @if(@$user->country == "308") selected @endif>Camer'n</option>
    <option value="38" @if(@$user->country == "38") selected @endif>Canada</option>
    <option value="154" @if(@$user->country == "154") selected @endif>Caribbean Netherlands</option>
    <option value="40" @if(@$user->country == "40") selected @endif>Cayman Islands</option>
    <option value="309" @if(@$user->country == "309") selected @endif>Centroafricana&nbsp;(República)</option>
    <option value="312" @if(@$user->country == "312") selected @endif>Chad</option>
    <option value="43" @if(@$user->country == "43") selected @endif>Chile</option>
    <option value="300" @if(@$user->country == "300") selected @endif>China</option>
    <option value="236" @if(@$user->country == "236") selected @endif>Cità del Vaticano</option>
    <option value="47" @if(@$user->country == "47") selected @endif>Colombia</option>
    <option value="310" @if(@$user->country == "310") selected @endif>Comores</option>
    <option value="311" @if(@$user->country == "311") selected @endif>Costa de Marfil</option>
    <option value="52" @if(@$user->country == "52") selected @endif>Costa Rica</option>
    <option value="54" @if(@$user->country == "54") selected @endif>Croatia</option>
    <option value="56" @if(@$user->country == "56") selected @endif>Cyprus</option>
    <option value="57" @if(@$user->country == "57") selected @endif>Czech Republic</option>
    <option value="58" @if(@$user->country == "58") selected @endif>Denmark</option>
    <option value="60" @if(@$user->country == "60") selected @endif>Dominica</option>
    <option value="63" @if(@$user->country == "63") selected @endif>Ecuador</option>
    <option value="64" @if(@$user->country == "64") selected @endif>Egypt</option>
    <option value="65" @if(@$user->country == "65") selected @endif>El Salvador</option>
    <option value="313" @if(@$user->country == "313") selected @endif>Eritrea</option>
    <option value="205" @if(@$user->country == "205") selected @endif>España</option>
    <option value="68" @if(@$user->country == "68") selected @endif>Estonia</option>
    <option value="314" @if(@$user->country == "314") selected @endif>Etiopia</option>
    <option value="71" @if(@$user->country == "71") selected @endif>Falkland Island</option>
    <option value="72" @if(@$user->country == "72") selected @endif>Feroe Islands</option>
    <option value="74" @if(@$user->country == "74") selected @endif>Finland</option>
    <option value="75" @if(@$user->country == "75") selected @endif>France</option>
    <option value="76" @if(@$user->country == "76") selected @endif>French Guiana</option>
    <option value="315" @if(@$user->country == "315") selected @endif>Gabon</option>
    <option value="316" @if(@$user->country == "316") selected @endif>Gambia</option>
    <option value="81" @if(@$user->country == "81") selected @endif>Georgia</option>
    <option value="82" @if(@$user->country == "82") selected @endif>Germany</option>
    <option value="317" @if(@$user->country == "317") selected @endif>Ghana</option>
    <option value="84" @if(@$user->country == "84") selected @endif>Gibraltar</option>
    <option value="85" @if(@$user->country == "85") selected @endif>Greece</option>
    <option value="86" @if(@$user->country == "86") selected @endif>Greenland</option>
    <option value="87" @if(@$user->country == "87") selected @endif>Grenada</option>
    <option value="88" @if(@$user->country == "88") selected @endif>Guadeloupe</option>
    <option value="90" @if(@$user->country == "90") selected @endif>Guatemala</option>
    <option value="94" @if(@$user->country == "94") selected @endif>Guiana</option>
    <option value="318" @if(@$user->country == "318") selected @endif>Guinea</option>
    <option value="320" @if(@$user->country == "320") selected @endif>Guinea Ecuatorial</option>
    <option value="319" @if(@$user->country == "319") selected @endif>Guinea-Bissau</option>
    <option value="97" @if(@$user->country == "97") selected @endif>Honduras</option>
    <option value="99" @if(@$user->country == "99") selected @endif>Hungary</option>
                      <option value="100" @if(@$user->country == "100") selected @endif>Iceland</option>
    <option value="101" @if(@$user->country == "101") selected @endif>India</option>
    <option value="352" @if(@$user->country == "352") selected @endif>Iraq</option>
    <option value="105" @if(@$user->country == "105") selected @endif>Ireland</option>
    <option value="107" @if(@$user->country == "107") selected @endif>Italy</option>
    <option value="108" @if(@$user->country == "108") selected @endif>Jamaica</option>
    <option value="109" @if(@$user->country == "109") selected @endif>Japan</option>
    <option value="321" @if(@$user->country == "321") selected @endif>Kenia</option>
    <option value="120" @if(@$user->country == "120") selected @endif>Latvia</option>
    <option value="322" @if(@$user->country == "322") selected @endif>Lesoto</option>
    <option value="323" @if(@$user->country == "323") selected @endif>Liberia</option>
    <option value="324" @if(@$user->country == "324") selected @endif>Libia</option>
    <option value="125" @if(@$user->country == "125") selected @endif>Liechtenstein</option>
    <option value="126" @if(@$user->country == "126") selected @endif>Lithuania</option>
    <option value="127" @if(@$user->country == "127") selected @endif>Luxemburg</option>
    <option value="129" @if(@$user->country == "129") selected @endif>Macedonia</option>
    <option value="325" @if(@$user->country == "325") selected @endif>Madagascar</option>
    <option value="326" @if(@$user->country == "326") selected @endif>Malaui</option>
    <option value="327" @if(@$user->country == "327") selected @endif>Mali</option>
    <option value="135" @if(@$user->country == "135") selected @endif>Malta</option>
    <option value="148" @if(@$user->country == "148") selected @endif>Maroc</option>
    <option value="138" @if(@$user->country == "138") selected @endif>Martinique</option>
    <option value="328" @if(@$user->country == "328") selected @endif>Mauricio</option>
    <option value="329" @if(@$user->country == "329") selected @endif>Mauritania</option>
    <option value="142" @if(@$user->country == "142") selected @endif>México</option>
    <option value="144" @if(@$user->country == "144") selected @endif>Moldova</option>
    <option value="145" @if(@$user->country == "145") selected @endif>Monaco</option>
    <option value="299" @if(@$user->country == "299") selected @endif>Montenegro</option>
    <option value="147" @if(@$user->country == "147") selected @endif>Montserrat</option>
    <option value="330" @if(@$user->country == "330") selected @endif>Mozambique</option>
    <option value="332" @if(@$user->country == "332") selected @endif>Niger</option>
    <option value="331" @if(@$user->country == "331") selected @endif>Namibia</option>
    <option value="155" @if(@$user->country == "155") selected @endif>Netherlands</option>
    <option value="157" @if(@$user->country == "157") selected @endif>New Zealand</option>
    <option value="158" @if(@$user->country == "158") selected @endif>Nicaragua</option>
    <option value="333" @if(@$user->country == "333") selected @endif>Nigeria</option>
    <option value="164" @if(@$user->country == "164") selected @endif>Norway</option>
    <option value="169" @if(@$user->country == "169") selected @endif>Panamá</option>
    <option value="171" @if(@$user->country == "171") selected @endif>Paraguay</option>
    <option value="172" @if(@$user->country == "172") selected @endif>Perú</option>
    <option value="353" @if(@$user->country == "353") selected @endif>Philippines</option>
    <option value="175" @if(@$user->country == "175") selected @endif>Poland</option>
    <option value="176" @if(@$user->country == "176") selected @endif>Portugal</option>
    <option value="335" @if(@$user->country == "335") selected @endif>Republica del Congo</option>
    <option value="336" @if(@$user->country == "336") selected @endif>Republica Democratica del Congo</option>
    <option value="61" @if(@$user->country == "61") selected @endif>República Dominicana</option>
    <option value="334" @if(@$user->country == "334") selected @endif>Ruanda</option>
    <option value="180" @if(@$user->country == "180") selected @endif>Rumania</option>
    <option value="181" @if(@$user->country == "181") selected @endif>Russia</option>
    <option value="187" @if(@$user->country == "187") selected @endif>Saint Vicente &amp; the Granadines</option>
    <option value="185" @if(@$user->country == "185") selected @endif>Saint Lucia</option>
    <option value="184" @if(@$user->country == "184") selected @endif>San Kitts &amp; Nevis</option>
    <option value="189" @if(@$user->country == "189") selected @endif>San Marino</option>
    <option value="186" @if(@$user->country == "186") selected @endif>San Pierre et Miquelon</option>
    <option value="337" @if(@$user->country == "337") selected @endif>Santo Tome y Principe</option>
    <option value="338" @if(@$user->country == "338") selected @endif>Senegal</option>
    <option value="193" @if(@$user->country == "193") selected @endif>Serbia</option>
    <option value="339" @if(@$user->country == "339") selected @endif>Seychelles</option>
    <option value="340" @if(@$user->country == "340") selected @endif>Sierra Leona</option>
    <option value="197" @if(@$user->country == "197") selected @endif>Slovakia</option>
    <option value="198" @if(@$user->country == "198") selected @endif>Slovenia</option>
    <option value="341" @if(@$user->country == "341") selected @endif>Somalia</option>
    <option value="202" @if(@$user->country == "202") selected @endif>South Africa</option>
    <option value="344" @if(@$user->country == "344") selected @endif>Suazilandia</option>
    <option value="342" @if(@$user->country == "342") selected @endif>Sudan</option>
    <option value="343" @if(@$user->country == "343") selected @endif>Sudan del Sur</option>
    <option value="208" @if(@$user->country == "208") selected @endif>Suriname</option>
    <option value="211" @if(@$user->country == "211") selected @endif>Sweden</option>
    <option value="212" @if(@$user->country == "212") selected @endif>Switzerland</option>
    <option value="351" @if(@$user->country == "351") selected @endif>Syria</option>
    <option value="345" @if(@$user->country == "345") selected @endif>Tanzania</option>
    <option value="346" @if(@$user->country == "346") selected @endif>Togo</option>
    <option value="221" @if(@$user->country == "221") selected @endif>Trinidad &amp; Tobago</option>
    <option value="222" @if(@$user->country == "222") selected @endif>Tunisie</option>
    <option value="223" @if(@$user->country == "223") selected @endif>Turkey</option>
    <option value="225" @if(@$user->country == "225") selected @endif>Turks &amp; Caicos Islands</option>
    <option value="347" @if(@$user->country == "347") selected @endif>Uganda</option>
    <option value="228" @if(@$user->country == "228") selected @endif>Ukraine</option>
    <option value="301" @if(@$user->country == "301") selected @endif>United Arab Emirates</option>
    <option value="230" @if(@$user->country == "230") selected @endif>United Kingdom</option>
    <option value="233" @if(@$user->country == "233") selected @endif>Uruguay</option>
    <option value="231" @if(@$user->country == "231") selected @endif>USA</option>
    <option value="237" @if(@$user->country == "237") selected @endif>Venezuela</option>
    <option value="239" @if(@$user->country == "239") selected @endif>Virgin Islands (UK)</option>
    <option value="348" @if(@$user->country == "348") selected @endif>Yibuti</option>
    <option value="349" @if(@$user->country == "349") selected @endif>Zambia</option>
    <option value="350" @if(@$user->country == "350") selected @endif>Zimbabue</option>
                  </select>
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_provincia')}}*</label>
                      <input type="text" disabled id="state_value" class="form-control">
                  </div>
                </div>
                {{-- <select class="form-control" id="state" name="state">
                      <option value="0"></option>
                    </select> --}}



                {{--  <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_dni')}} </label>
                    <input class="form-control pl-4 pr-4 input_bg border_radius custom_input" value="{{ $user->identity_document }}" name="identity_document" type="text" placeholder="Identity Document " />
                  </div>
                </div>  --}}
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_telefono_home')}} </label>
                    <input class="form-control pl-4 pr-4 input_bg border_radius custom_input" value="{{ $user->home_telephone }}" name="home_telephone" type="text" placeholder="Company Telephone " />
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_telefono_movil')}}* </label>
                    <input class="form-control pl-4 pr-4 input_bg border_radius custom_input" value="{{ $user->mobile_num }}" name="mobile_num" type="text" placeholder="Mobile Telephone " />
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label class="col-form-label input_color fz16 pt-3">{{__('lang.state_referral_code')}} </label>
                    <select class="form-control" name="association">
                        @foreach ($accossiations as $acc)
                          <option value="{{ $acc['nombre'] }}" @if($user->association == $acc['nombre']) selected @endif >{{ $acc['nombre'] }}</option>
                        @endforeach
                    </select>

                  </div>
                </div>


                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_email')}}*</label>
                    <input class="form-control pl-4 pr-4 input_bg border_radius custom_input" value="{{ $user->email }}" name="email" type="text" />
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_contrasena')}}*</label>
                    <input class="form-control pl-4 pr-4 input_bg border_radius custom_input" id="password" name="password" type="password" />
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label class="col-form-label input_color fz16 pt-3">{{__('lang.text_confirmar_contrasena')}}*</label>
                    <input class="form-control pl-4 pr-4 input_bg border_radius custom_input" name="password_confirmation" type="password" />
                  </div>
                </div>
                <div class="col-md-6 col-12" style="display: flex; align-items: center; min-height: 100px">
                  <div class="form-group custom_checkbox" style="margin: 0">
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
                  {{--  <button id="button" name="button" class="btn base_btn fz20 w-100 mt-4 custom_input line_btn" type="submit">{{__('lang.text_register_user')}}</button>  --}}
                  <button id="button" name="button" class="btn base_btn fz20 w-100 mt-4 custom_input line_btn" type="submit">{{__('lang.update')}}</button>
                </div>
                     <div id="singleError" style="color: red; display: none;"></div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </section>
    @section('scripts')
    
    <x-script-component /> <!-- Include the script component here -->
    <script>
            var country = @json($user->country);
            var states = getStatesForCountry(country);
            const stateValue = @json($user->state);
            console.log(states);
            const matchedState = states.find(state => state.code === stateValue);

            if (matchedState) {
                document.getElementById('state_value').value = matchedState.name;
                 
               
            } else {
                console.log('State not found');
            }
               
        
        </script>
    @endsection
@endsection
