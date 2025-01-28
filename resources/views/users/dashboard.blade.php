@extends('layouts.home')

@section('content')
    @php
        use Illuminate\Support\Facades\App;

        $current_language = App::currentLocale();

        // Fee descriptions per language
        $fee_descriptions = [
            'en' => [
                1 => 'Less than 5000 USD',
                2 => 'Between 5000 and 15000 USD',
                3 => 'More Than 15000 USD',
            ],
            'es' => [
                1 => 'Menos de 5000 EUR',
                2 => 'Entre 5000 y 15000 EUR',
                3 => 'Más de 15000 EUR',
            ],
            'hi' => [
                1 => 'Less than 5000 INR',
                2 => 'Between 5000 and 15000 INR',
                3 => 'More Than 15000 INR',
            ],
            'it' => [
                1 => 'Meno di 5000 EUR',
                2 => 'Tra 5000 e 15000 EUR',
                3 => 'Più di 15000 EUR',
            ],
            'pt' => [
                1 => 'Menos de 5000 EUR',
                2 => 'Entre 5000 e 15000 EUR',
                3 => 'Mais de 15000 EUR',
            ],
        ];

        // Get fee descriptions for the current language or default to English
        $current_fees = $fee_descriptions[$current_language];
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

        @media only screen and (max-width:600px) {
            .login_section {
                margin-top: 40px !important;
            }

            .mar_top {
                margin-top: 10px;
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

    <section>
        <div>
            <section class="text-center bg_color login_section">
                <h3 class="white fz36 mb-0 font_bold">{{ __('lang.text_user_area') }}</h3>
            </section>
            <div class="login_form p-5 font_bold c-form">
                <form action="" method="POST">
                    @csrf
                    {{-- <div class="container"> --}}
                    <div class="row">
                        <div class="col-md-4">
                            <ul class="opp_list">
                                <li style="margin-bottom: 20px"><a href="#">{{ __('lang.text_opportunity_list') }}</a>
                                </li>
                                <li><a href="{{ route('create-opportunity') }}">{{ __('lang.text_create_opportunity') }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            {{--  <h1>{{__('lang.text_purchase_order_list')}}</h1>  --}}
                            <h1>{{ __('lang.opportunity_list') }}</h1>
                            <table class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ __('lang.text_opportunity_name') }}</th>
                                        {{-- <th scope="col">{{ __('lang.text_email') }}</th> --}}
                                        <th scope="col">{{ __('lang.text_tipo_empresa') }}</th>
                                        <th scope="col">{{ __('lang.text_estimated_amount') }}</th>
                                        <th scope="col">{{ __('lang.estimate_start_project') }}</th>
                                        <th scope="col">{{ __('lang.text_purchase_finalized_by') }}</th>
                                        <th scope="col">{{ __('lang.text_status') }}</th>
                                        <th scope="col">#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($opportunities as $opp)
                                        <tr>
                                            <td>{{ $opp->opportunity_name }}</td>
                                            {{-- <td>{{ Auth::user()->email }}</td> --}}
                                            <td>
                                                @php
                                                    $projectTypes = json_decode($opp->project_type, true); // Decode JSON to an array
                                                @endphp
                                                @if (is_array($projectTypes))
                                                    {{ implode(
                                                        ', ',
                                                        array_map(function ($typeId) use ($company_type, $current_language) {
                                                            // Find the matching item in company_type
                                                            $item = collect($company_type)->firstWhere('id', $typeId);
                                                            if ($item) {
                                                                // Return the appropriate text based on the current language
                                                                if ($current_language == 'es') {
                                                                    return $item->es_text;
                                                                } elseif ($current_language == 'hi') {
                                                                    return $item->hi_text;
                                                                } elseif ($current_language == 'it') {
                                                                    return $item->pur_text;
                                                                } elseif ($current_language == 'pt') {
                                                                    return $item->br_text;
                                                                } else {
                                                                    return $item->name;
                                                                }
                                                            }
                                                            return '';
                                                        }, $projectTypes),
                                                    ) }}
                                                @else
                                                    {{ $opp->project_type }}
                                                @endif
                                            </td>
                                            <td>
                                                {{ $current_fees[$opp->est_amount] ?? 'N/A' }}
                                            </td>
                                            <td>{{ \Illuminate\Support\Carbon::parse($opp->est_time)->format('Y-m-d') }}
                                            </td>
                                            <td>
                                                @if ($opp->purchase_finalize == 1)
                                                    User
                                                @elseif ($opp->purchase_finalize == 2)
                                                    BIDINLINE
                                                @endif
                                            </td>
                                            <td>
                                                @if ($opp->admin_bit == 2)
                                                    {{ __('lang.approved_text') }}
                                                @else
                                                    @if ($opp->save_bit == 0)
                                                        {{ __('lang.draft_text') }}
                                                    @elseif($opp->save_bit == 1)
                                                        {{ __('lang.publish_text') }}
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if ($opp->save_bit == 0)
                                                    <a href="{{ route('see-opportunity', ['id' => $opp->id]) }}"
                                                        class="btn btn-primary mar_top">{{ __('lang.text_see') }}</a>
                                                @elseif ($opp->admin_bit == 2)
                                                    <a href="{{ route('chat-opportunity', ['id' => $opp->id]) }}"
                                                        class="btn btn-primary mar_top">{{ __('lang.chat') }}</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{-- </div> --}}
                </form>
            </div>
        </div>
    </section>
@endsection
