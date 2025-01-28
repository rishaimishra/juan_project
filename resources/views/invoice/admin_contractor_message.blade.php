@extends('layouts.app')

@section('content')
<style>
 

    .darker {
      border-color: #ccc;
      background-color: #ddd;
    }
    
    .chat-message::after {
      content: "";
      clear: both;
      display: table;
    }
    .chat-message{
  margin-bottom: 10px;
  padding: 10px;
}
    .chat-message img {
      float: left;
      max-width: 60px;
      width: 100%;
      margin-right: 20px;
      border-radius: 50%;
    }
    
    .chat-message img.right {
      float: right;
      margin-left: 20px;
      margin-right:0;
    }
    
    .time-right {
      float: right;
      color: #aaa;
    }
    
    .time-left {
      float: left;
      color: #999;
    }
    .send-message {
      float: right;
    
    }
    </style>
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
                    @if (count($getOpp)>0)
                    @foreach($getOpp as $message)
                    @if($message->sender_id == $contractor_id)
                        <!-- Sender's Message (Right-aligned) -->
                        <div class="chat-message darker">
                            <img src="https://i.ibb.co/k8mkCZH/free-user-icon-3296-thumb.png" alt="Avatar" class="right" style="width:100%;">
                            <p>{{ $message->message }}</p>
                            <span class="time-right">{{ $message->created_at->format('h:i A') }}</span> <!-- Display time -->
                             @if($message->image)
                <div class="message-images">
                    @foreach(explode(',', $message->image) as $image)
                        @php
                            $new_url = '';
                            $url_pre = asset('storage/app/public/' .$image);
                           $new_url =  str_replace("public/storage","storage",$url_pre);
                        @endphp
                        <img src="{{ $new_url }}" alt="Chat Image" style="width: 50px;height: 50px; margin: 5px;">
                    @endforeach
                </div>
            @endif
                        </div>
                    @else
                        <!-- Receiver's Message (Left-aligned) -->
                        <div class="chat-message">
                            <img src="https://i.ibb.co/Yt7TT8T/1144760.png" alt="Avatar" style="width:100%;">
                            <p>{{ $message->message }}</p>
                            <span class="time-left">{{ $message->created_at->format('h:i A') }}</span> <!-- Display time -->
                             @if($message->image)
                <div class="message-images">
                    @foreach(explode(',', $message->image) as $image)
                     @php
                            $new_url_new = '';
                            $url_pre_pre = asset('storage/app/public/' .$image);
                           $new_url_new =  str_replace("public/storage","storage",$url_pre_pre);
                        @endphp
                        <img src="{{ $new_url_new }}" alt="Chat Image" style="width: 50px;height: 50px; margin: 5px;">
                    @endforeach
                </div>
            @endif
                        </div>             
                    @endif

                @endforeach
                @else
                <p>No Message Found</p>
                    @endif
                   
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
