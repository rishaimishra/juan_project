@extends('layouts.home')

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
ul{
  list-style-type: none;
}
.opp_list li a{
  color: #0772b1;
}
.opp_list li a:hover{
  color: #0772b1;
}
@media only screen and (max-width:600px){
  .login_section{
      margin-top: 40px !important;
  }

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
          <h3 class="white fz36 mb-0 font_bold">{{__('lang.text_user_area')}}</h3>
        </section>
        <div class="login_form p-5 font_bold c-form">
            <!-- <form action="" method="POST">
              @csrf -->
              <div class="container">
                  <div class="row">
                    <div class="col-md-4">
                        <ul class="opp_list">
                            <li style="margin-bottom: 20px"><a href="{{ route('users-dashboard') }}">{{ __('lang.text_opportunity_list') }}</a></li>
                            <li><a href="{{ route('create-opportunity') }}">{{ __('lang.text_create_opportunity') }}</a></li>
                        </ul>
                    </div>
                    <div class="col-md-8">
                      <!-- Send Message Button -->
<button class="send-message btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">{{ __('lang.send_message') }}</button>

<!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">{{ __('lang.send_message') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('send-message')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <!-- Textarea for message input -->
          <input type="hidden" name="oppId" value="{{ $oppId }}">
          <input type="hidden" name="invoice_id" value="{{ $id }}">
          <div class="input-group">
            <textarea id="emojionearea1" name="messageText" class="form-control" rows="5" placeholder="Type your message here..."></textarea>
            
          </div>
          <input type="file" name="chat_images[]" multiple>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('lang.close') }}</button>
          <!-- Send button -->
          <button type="submit" class="btn btn-primary" id="sendMessageBtn">{{ __('lang.send') }}</button>
        </div>
      </form>
    </div>
  </div>
</div>


                        <h2>{{ __('lang.chat_messages') }}</h2>


       @foreach($getOpp as $message)
    @if($message->sender_id == auth()->user()->id)
        <!-- Sender's Message (Right-aligned) -->
        <div class="chat-message darker">
            <img src="https://i.ibb.co/k8mkCZH/free-user-icon-3296-thumb.png" alt="Avatar" class="right" style="width:100%;">
            <p>{{ $message->message }}</p>
            <span class="time-right">{{ $message->created_at->format('h:i A') }}</span> <!-- Display time -->
            
            <!-- Display images if available -->
            @if($message->image)
                <div class="message-images">
                    @foreach(explode(',', $message->image) as $image)
                        <img src="{{ asset('storage/app/public/' .$image) }}" alt="Chat Image" style="width: 50px;height: 50px; margin: 5px;">
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
            
            <!-- Display images if available -->
            @if($message->image)
                <div class="message-images">
                    @foreach(explode(',', $message->image) as $image)
                        <img src="{{ asset('storage/app/public/' .$image) }}" alt="Chat Image" style="width: 50px;height: 50px; margin: 5px;">
                    @endforeach
                </div>
            @endif
        </div>
    @endif
@endforeach




                         <!--    <div class="chat-message">
                              <img src="https://i.ibb.co/Yt7TT8T/1144760.png" alt="Avatar" style="width:100%;">
                              <p>Hello. How are you today?</p> -->
                              <!-- <span class="time-right">11:00</span> -->
                            <!-- </div> -->

                           <!--  <div class="chat-message darker">
                              <img src="https://i.ibb.co/k8mkCZH/free-user-icon-3296-thumb.png" alt="Avatar" class="right" style="width:100%;">
                              <p>Hey! I'm fine. Thanks for asking!</p> -->
                              <!-- <span class="time-left">11:01</span> -->
                            <!-- </div> -->

                           <!--  <div class="chat-message">
                              <img src="https://i.ibb.co/Yt7TT8T/1144760.png" alt="Avatar" style="width:100%;">
                              <p>Sweet! So, what do you wanna do today?</p>
                      
                            </div>

                            <div class="chat-message darker">
                              <img src="https://i.ibb.co/k8mkCZH/free-user-icon-3296-thumb.png" alt="Avatar" class="right" style="width:100%;">
                              <p>Nah, I dunno. Play soccer.. or learn more coding perhaps?</p>
                           
                            </div> -->

                    </div>
                  </div>
              </div>
            <!-- </form> -->
        </div>
      </div>
</section>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" ></script> -->
<!-- Include Emoji Button Library -->


@endsection
