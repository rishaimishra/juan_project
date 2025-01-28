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
                            <th scope="col">Contractor Name</th>
                            <th scope="col">Contractor Email</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($contractors as $item)
                          <tr>
                            <td>{{ $item['opportunity']->opportunity_name }}</td>
                            <td>{{ $item['user']->name }}</td>
                            <td>{{ $item['user']->email }}</td>
                            <td>{{ $item->status }}</td>
                            @if ($item->status == 'paid')
                            <td>
                                <a href="{{ route('show_contrctor_message_admin',['oppId'=>$item['opportunity']->id,'con_id'=>$item['user']->id]) }}" class="btn btn-primary">See Messages</a>
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
