@extends('layouts.app')

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
                    <div class="card-header">{{ __('Leads Detail') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        {{-- @dd($responseArray); --}}
                        <table id="myTable1" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">Email</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Country</th>
                                    <th scope="col">State</th>
                                    <th scope="col">City</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($leads as $item)
                                    <tr>
                                        <td>{{ $item['email'] }}</td>
                                        <td>{{ $item['name'] }}</td>
                                        <td>{{ $item['phone'] }}</td>
                                        <td>{{ $item['country'] }}</td>
                                        <td>{{ $item['state'] }}</td>
                                        <td>{{ $item['city'] }}</td>
                                        <td>
                                            {{--  <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal.{{ $item->id }}">Delete</a>  --}}
                                            <a href="#" class="btn btn-danger">Delete</a>
                                        </td>
                                    </tr>

                                    <!-- Reject Confirmation Modal -->
                                    {{--  <div class="modal fade" id="rejectModal.{{ $item->id }}" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <h5 class="modal-title" id="rejectModalLabel">Confirmation</h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body">
                                          Are you sure you want to delete this item?
                                      </div>
                                      <div class="modal-footer">
                                          <!-- No Button -->
                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>

                                          <!-- Yes Button -->
                                          <a href="{{ route('delete_contractor',['id' => $item->id]) }}" class="btn btn-danger">Yes</a>
                                      </div>
                                  </div>
                              </div>
                          </div>  --}}
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
