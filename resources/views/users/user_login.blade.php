@extends('layouts.home')

@section('content')

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
                <h3 class="white fz36 mb-0 font_bold">{{ __('lang.text_login') }}</h3>
            </section>
            <div class="login_form p-5 font_bold c-form">
                <form action="{{ route('login-user') }}" method="POST">
                    @csrf
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="col-form-label input_color fz16 pt-3">{{ __('lang.text_email') }}</label>
                                    <input class="form-control pl-4 pr-4 input_bg border_radius custom_input" name="email"
                                        type="text" required placeholder="Enter email" />
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label
                                        class="col-form-label input_color fz16 pt-3">{{ __('lang.text_contrasena') }}</label>
                                    <input class="form-control pl-4 pr-4 input_bg border_radius custom_input"
                                        name="password" type="password" required placeholder="Enter password" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-primary">{{ __('lang.text_login') }}</button>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('forget-password') }}">{{ __('lang.forget_password') }} ?</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
