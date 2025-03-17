@extends('layouts.app')

@section('content')
<!-- Success Message -->
@if (session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif
@if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
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
                <div class="card-header">{{ __('Opportunity Detail') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table id="myTable" class="display" style="width:100%">
                        <thead>
                          <tr>
                            <th scope="col">Opportunity Name</th>
                            <th scope="col">User phone</th>
                            <th scope="col">User Name</th>
                            <th scope="col">City</th>
                            {{-- <th scope="col">Estimate Amount</th> --}}
                            {{-- <th scope="col">Estimate Time</th> --}}
                            <th scope="col">Best time to reach</th>
                            <th scope="col">Detail Description</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($opportunities as $item)
                          <tr>
                            <td>{{ $item->opportunity_name }}</td>
                            <td>{{ $item->phone }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->city }}</td>
                            {{-- <td>{{ $item->est_amount }}</td> --}}
                            {{-- <td>{{ $item->est_time }}</td> --}}
                            <td>{{ $item->best_time }}</td>
                            <td>{{ $item->detail_description }}</td>
                            <td>

                                <a href="{{ route('admin_edit_opportunity',['id' => $item->id]) }}">
                                    <svg style="height: 20px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                      </svg>                                      
                                </a>


                                @if ($item->admin_bit == 0)
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmModal.{{ $item->id }}">
                                    validate
                                </button>

                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#novalidateModal.{{ $item->id }}">
                                    no validate
                                </button>

                                @endif
                                @if ($item->admin_bit == 2)
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#novalidateModal.{{ $item->id }}">
                                    no validate
                                </button>
                                @endif

                                <a href="{{ route('show_opportunity_contractors',['id' => $item->id]) }}">
                                    <svg style="height:20px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                      </svg>                                                                          
                                </a>
                            </td>
                          </tr>
                          <div class="modal fade" id="confirmModal.{{ $item->id }}" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmModalLabel">Confirmation</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to accept this item?
                                    </div>
                                    <div class="modal-footer">
                                        <!-- No Button -->
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>

                                        <!-- Yes Button -->
                                        <a href="{{ route('admin_approve_opp',['id' => $item->id]) }}" class="btn btn-primary">Yes</a>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="modal fade" id="novalidateModal.{{ $item->id }}" tabindex="-1" aria-labelledby="novalidateModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="novalidateModalLabel">Confirmation</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to accept this item?
                                    </div>
                                    <div class="modal-footer">
                                        <!-- No Button -->
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>

                                        <!-- Yes Button -->
                                        <a href="{{ route('admin_reject_opp',['id' => $item->id]) }}" class="btn btn-danger">Yes</a>
                                    </div>
                                </div>
                            </div>
                        </div>                      
                          @endforeach
                        </tbody>
                      </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
