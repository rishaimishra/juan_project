@extends('layouts.app')

@section('content')
    <!-- Success Message -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <a href="{{ route('getAllsellersData') }}" class="btn btn-primary mb-3">Sellers</a>
                <a href="{{ route('home') }}" class="btn btn-primary mb-3">Contractors</a>
                <a href="{{ route('get_users') }}" class="btn btn-primary mb-3">Users</a>
                <a href="{{ route('getadminopp') }}" class="btn btn-primary mb-3">Opportunities</a>
                <a href="{{ route('get_leads') }}" class="btn btn-primary mb-3">Leads</a>
                <a href="{{ route('get_invoice') }}" class="btn btn-primary mb-3">Invoice</a>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Invoices</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Opportunity Name</th>
                                    <th scope="col">User</th>
                                    <th scope="col">{{ __('lang.text_status') }}</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Created at</th>
                                    <th scope="col">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoices as $opp)
                                    <tr>
                                        <td>{{ $opp->opportunity->opportunity_name ?? '' }}</td>
                                        <td>{{ $opp->user->name ?? '' }}</td>
                                        <td>{{ $opp->status }}</td>
                                        <td>{{ $opp->amount }}</td>
                                        <td>{{ $opp->created_at }}</td>
                                        @if ($opp->status == "paid")
                                        <td>
                                            <a href="{{ asset($opp->invoice_path) }}" download>
                                                <svg style="width:30px;" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                                </svg>
                                            </a>
                                        </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
