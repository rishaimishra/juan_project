@extends('layouts.app')

@section('content')
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
                    <div class="card-header">{{ __('Seller Detail') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <table id="myTable" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">Company Email</th>
                                    <th scope="col">Company Name</th>
                                    <th scope="col">Company Mobile</th>
                                    <th scope="col">license number</th>
                                    <th scope="col">Insurance number</th>
                                    <th scope="col">City</th>
                                    <th scope="col">Country</th>
                                    <th scope="col">State</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($responseArray as $item)
                                    <tr>
                                        <td>{{ $item['email'] }}</td>
                                        <td>{{ $item['nombre'] }}</td>
                                        <td>{{ $item['movil'] }}</td>
                                        <td>{{ $item['license_number'] }}</td>
                                        <td>{{ $item['insurance_number'] }}</td>
                                        <td>{{ $item['ciudad'] }}</td>
                                        <td>{{ $item['pais_nombre'] }}</td>
                                        <td>{{ $item['provincia_nombre'] }}</td>
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
