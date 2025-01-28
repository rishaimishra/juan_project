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
                {{-- <h3 class="white fz36 mb-0 font_bold">{{ __('lang.text_ventas') }}</h3> --}}
                <h3 class="white fz36 mb-0 font_bold">{{ __('lang.contractor_area') }}</h3>
            </section>
            <div class="login_form p-5 font_bold c-form">
                <form action="" method="POST">
                    @csrf
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4">
                                <ul class="opp_list">
                                    <li><a href="{{ route('users-dashboard') }}">{{ __('lang.text_opportunity_list') }}</a>
                                    </li>
                                    <li><a href="{{ route('invoice-list') }}">{{ __('lang.text_facturas') }}</a></li>
                                </ul>
                            </div>
                            <div class="col-md-8">
                                <h1>{{ __('lang.text_opportunity_list') }}</h1>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            {{-- <th scope="col">{{ __('lang.text_branch') }}</th> --}}
                                            <th scope="col">Name</th>
                                            {{-- <th scope="col">{{ __('lang.text_email') }}</th>
                                            <th scope="col">{{ __('lang.text_po_name') }}</th>
                                            <th scope="col">{{ __('lang.text_status') }}</th> --}}
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($opportunities as $opp)
                                            <tr>
                                                <td>{{ $opp->opportunity_name }}</td>
                                                {{-- <td>{{ Auth::user()->email }}</td>
                                                <td>{{ $opp->window_with_name }}</td>
                                                @if ($opp->save_bit == 0)
                                                    <td>Draft</td>
                                                @else
                                                    <td>Draft</td>
                                                @endif --}}
                                                <td>
                                                    <a href="{{ route('see-contractor-opportunity', ['id' => $opp->id]) }}"
                                                        class="btn btn-primary">{{ __('lang.text_see') }}</a>
                                                    {{-- <a href="#" class="btn btn-success"
                                                        onclick="showSimpleModal('approve')">{{ __('lang.text_approve') }}</a>
                                                    <a href="#" class="btn btn-danger"
                                                        onclick="showSimpleModal('reject')">{{ __('lang.text_reject') }}</a> --}}
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
        <div class="modal fade" id="simpleConfirmModal" tabindex="-1" aria-labelledby="simpleConfirmModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="simpleConfirmModalLabel">Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="simpleModalMessage">
                        <!-- Message will be set dynamically -->
                    </div>
                    <div class="modal-footer">
                        <!-- No Button -->
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>

                        <!-- Yes Button -->
                        <a href="#" id="confirmAction" class="btn">Yes</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        function showSimpleModal(action) {
            const modalMessage = document.getElementById('simpleModalMessage');
            const confirmAction = document.getElementById('confirmAction');

            // Set modal message and action URL based on the button clicked
            if (action === 'approve') {
                modalMessage.textContent = "Are you sure you want to approve this item?";
                confirmAction.href = "{{ url('admin/approve') }}"; // Set the URL for approve action
                confirmAction.className = "btn btn-success"; // Set button style for approve
            } else if (action === 'reject') {
                modalMessage.textContent = "Are you sure you want to reject this item?";
                confirmAction.href = "{{ url('admin/reject') }}"; // Set the URL for reject action
                confirmAction.className = "btn btn-danger"; // Set button style for reject
            }

            // Show the modal
            const modal = new bootstrap.Modal(document.getElementById('simpleConfirmModal'));
            modal.show();
        }
    </script>
@endsection
