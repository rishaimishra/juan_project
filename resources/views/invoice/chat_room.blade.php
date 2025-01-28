@extends('layouts.home')

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
          <h3 class="white fz36 mb-0 font_bold">{{__('lang.text_user_area')}}</h3>
        </section>
        <div class="login_form p-5 font_bold c-form">
            <form action="" method="POST">
              @csrf
              <div class="container">
                  <div class="row">
                    <div class="col-md-4">
                        <ul class="opp_list">
                            <li style="margin-bottom: 20px"><a href="{{ route('users-dashboard') }}">{{ __('lang.text_opportunity_list') }}</a></li>
                            <li><a href="{{ route('create-opportunity') }}">{{ __('lang.text_create_opportunity') }}</a></li>
                        </ul>
                    </div>
                    <div class="col-md-8">
                        {{--  <h1>{{__('lang.text_purchase_order_list')}}</h1>  --}}
                        <h1>{{ __('lang.chat_room') }}</h1>
                        <table class="table">
                            <thead>
                                <tr>
                                {{--  <th scope="col">{{ __('lang.text_opportunity_name') }}</th>  --}}
                                <th scope="col">{{ __('lang.contractor_name') }}</th>
                                <th scope="col">{{ __('lang.contractor_email') }}</th>
                                {{--  <th scope="col">{{ __('lang.text_email') }}</th>  --}}
                                {{--  <th scope="col">{{ __('lang.text_po_name') }}</th>  --}}
                                {{--  <th scope="col">{{ __('lang.text_status') }}</th>  --}}
                                <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($getOpp as $opp)
                                   <tr>
                                <td>{{ $opp['user']['name'] ?? '' }}</td>
                                <td>{{ $opp['user']['email'] ?? '' }}</td>
                                {{--  <td>{{ $opp->window_with_name }}</td>  --}}
                               
                                <td>
                                    <a href="{{ route('message-opportunity', ['id' => $opp->id, 'oppId' => $opp->opportunity_id]) }}" class="btn btn-primary">{{ __('lang.text_mensaje') }}</a>
                                </td>
                                </tr>
                                @endforeach


                            </tbody>
                            </table>
                    </div>
                  </div>
              </div>
            </form>
        </div>
      </div>
</section>
@endsection
