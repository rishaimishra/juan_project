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
              <h3 class="white fz36 mb-0 font_bold">User Dashboard</h3>
            </section>

        </div>
    </section>
    @section('scripts')
    <x-script-component /> <!-- Include the script component here -->
    @endsection
@endsection
