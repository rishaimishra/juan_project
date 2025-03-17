<!-- Meta Pixel Code -->
<script>
    ! function(f, b, e, v, n, t, s) {
        if (f.fbq) return;
        n = f.fbq = function() {
            n.callMethod ?
                n.callMethod.apply(n, arguments) : n.queue.push(arguments)
        };
        if (!f._fbq) f._fbq = n;
        n.push = n;
        n.loaded = !0;
        n.version = '2.0';
        n.queue = [];
        t = b.createElement(e);
        t.async = !0;
        t.src = v;
        s = b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t, s)
    }(window, document, 'script',
        'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '1415142252936579');
    fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id=1415142252936579&ev=PageView&noscript=1" /></noscript>
<!-- End Meta Pixel Code -->

<nav>
    <div class="main_header">
        <header class="font_bold">
            <nav class="navbar navbar-expand-lg navbar-light custom_nav fixed-top p-0 scrollHeader">
                <a class="navbar-brand p-0 ml-2 ml-sm-5 ml-md-4 ml-xl-5" href="https://www.bidinline.com/"><img
                        src="{{ asset('public/assets/img/logo.png') }}" alt="" class="img-fluid" /></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                @if (Auth::user())
                    @if (Auth::user()->user_type == 'user')
                        <a href="{{ route('users-dashboard') }}" class="btn header_btn mr-2 mr-xl-3">
                            {{ __('lang.text_user_area') }}
                        </a>
                        <a href="{{ route('edit-profile', ['id' => Auth::user()->id]) }}"
                            class="btn header_btn mr-2 mr-xl-3">
                            {{ __('lang.edit_profile') }}
                        </a>
                    @elseif(Auth::user()->user_type == 'contractor')
                        <a href="{{ route('users-dashboard') }}" class="btn header_btn mr-2 mr-xl-3">
                            {{ __('lang.text_opportunities') }}
                        </a>
                        <a href="{{ route('edit-contractor-profile', ['id' => Auth::user()->id]) }}"
                            class="btn header_btn mr-2 mr-xl-3">
                            {{ __('lang.edit_profile') }}
                        </a>
                    @else
                        <a href="#" class="btn header_btn mr-2 mr-xl-3">
                        </a>
                    @endif
                @endif
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto d-none d-lg-flex"> <!-- Show only on large screens -->
                        @foreach (config('localisation.locales') as $locales)
                            <li class="nav-item">
                                <a class="nav-link p-2 p-xl-3" href="{{ route('localization', $locales) }}">
                                    <img src="{{ asset('public/assets/img/' . $locales . '.png') }}" title="{{ $locales }}" class="rounded-circle" />
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    
                    <ul class="navbar-nav ml-auto d-flex d-lg-none"> <!-- Show only on mobile -->
                        @foreach (config('localisation.locales') as $locales)
                            <li class="nav-item">
                                <a class="nav-link p-2 p-xl-3" href="{{ route('localization', $locales) }}">
                                    <img src="{{ asset('public/assets/img/' . $locales . '.png') }}" title="{{ $locales }}" class="rounded-circle" />
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    
                    @if (Auth::user())
                        <a class="btn header_btn mr-2 mr-xl-3 text-uppercase" href="{{ route('custom-logout') }}"
                            onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                            {{ __('lang.text_salir') }}
                        </a>

                        <form id="logout-form" action="{{ route('custom-logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @else
                        <form class="form-inline header_form mr-lg-2 mr-xl-5">
                            <a href="{{ route('user-login') }}"
                                class="btn header_btn mr-2 mr-xl-3 text-uppercase">{{ __('lang.text_acceder') }}</a>
                            {{--  <a href="{{ route('contractor-login') }}" class="btn header_btn text-uppercase">{{__('lang.text_registro')}}</a>  --}}
                            <a href="{{ route('contractor-login') }}"
                                class="btn header_btn text-uppercase">{{ __('lang.contractor_login') }}</a>
                        </form>
                    @endif

                    <script>
                        document.querySelector('.header_btn[href="{{ route('custom-logout') }}"]').addEventListener('click', function(event) {
                            event.preventDefault();
                            if (confirm("Are you sure you want to log out?")) {
                                document.getElementById('logout-form').submit();
                            }
                        });

                    </script>

                </div>
            </nav>
        </header>
    </div>
</nav>
