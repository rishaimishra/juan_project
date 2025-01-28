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

        .darker {
            border-color: #ccc;
            background-color: #ddd;
        }

        .chat-message {
            margin-bottom: 10px;
            padding: 10px;
        }

        .chat-message::after {
            content: "";
            clear: both;
            display: table;
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
            margin-right: 0;
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
    <!-- Validation Errors -->
    <section>
        <div>
            <section class="text-center bg_color login_section">
                <h3 class="white fz36 mb-0 font_bold">Contractor´s Area</h3>
            </section>
            <div class="login_form p-5 font_bold c-form">
                {{-- <form action="" method="POST">
                  @csrf --}}
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <ul class="opp_list">
                                <li><a href="{{ route('users-dashboard') }}">{{ __('lang.text_opportunity_list') }}</a></li>
                                <li><a href="{{ route('invoice-list') }}">{{ __('lang.text_facturas') }}</a></li>
                            </ul>
                        </div>
                        <div class="col-md-8">
                            <!-- Send Message Button -->
                            <button class="send-message btn btn-primary" data-toggle="modal"
                                data-target="#exampleModalLong">Send Message</button>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Send Message</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('send-message-contractor') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <!-- Textarea for message input -->
                                                <input type="hidden" name="oppId" value="{{ $oppId }}">
                                                <input type="hidden" name="invoice_id" value="{{ $id }}">
                                                <textarea id="messageText" name="messageText" required class="form-control" rows="5"
                                                    placeholder="Type your message here..."></textarea>
                                                <input type="file" name="chat_images[]" multiple>
                                                <small>jpg, jpeg, png, gif, pdf allowed</small>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <!-- Send button -->
                                                <button type="submit" class="btn btn-primary"
                                                    id="sendMessageBtn">Send</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <h2>Chat Messages</h2>
                            @foreach ($getOpp as $message)
                                @if ($message->sender_id == auth()->user()->id)
                                    <!-- Sender's Message (Right-aligned) -->
                                    <div class="chat-message darker">
                                        <img src="https://i.ibb.co/k8mkCZH/free-user-icon-3296-thumb.png" alt="Avatar"
                                            class="right" style="width:100%;">
                                        <p>{{ $message->message }}</p>
                                        <span class="time-right">{{ $message->created_at->format('h:i A') }}</span>
                                        <!-- Display time -->
                                        @if ($message->image)
                                            <div class="message-attachments">
                                                @foreach (explode(',', $message->image) as $file)
                                                    @php
                                                        $filePath = asset('storage/app/public/' . $file);
                                                        $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
                                                    @endphp
                                                    @if (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif']))
                                                        <!-- Image attachment -->
                                                        <img src="{{ $filePath }}" alt="Chat Image"
                                                            style="width: 50px; height: 50px; margin: 5px; cursor: pointer;"
                                                            onclick="openImagePopup('{{ $filePath }}')">
                                                    @elseif (strtolower($fileExtension) === 'pdf')
                                                        <!-- PDF attachment -->
                                                        <a href="{{ $filePath }}" target="_blank" class="pdf-link">
                                                            <svg style="width:30px;" xmlns="http://www.w3.org/2000/svg"
                                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor" class="size-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                                            </svg>
                                                        </a>
                                                    @else
                                                        <!-- Other file types -->
                                                        <a href="{{ $filePath }}"
                                                            target="_blank">{{ $file }}</a>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <!-- Receiver's Message (Left-aligned) -->
                                    <div class="chat-message">
                                        <img src="https://i.ibb.co/Yt7TT8T/1144760.png" alt="Avatar" style="width:100%;">
                                        <p>{{ $message->message }}</p>
                                        <span class="time-left">{{ $message->created_at->format('h:i A') }}</span>
                                        <!-- Display time -->
                                        @if ($message->image)
                                            <div class="message-images">
                                                @foreach (explode(',', $message->image) as $image)
                                                    <img src="{{ asset('storage/app/public/' . $image) }}" alt="Chat Image"
                                                        style="width: 50px;height: 50px; margin: 5px;">
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                            <!-- Modal for Image Popup -->
                            <div id="imageModal"
                                style="display:none; position:fixed; z-index:1000; left:0; top:100px; width:100%; height:100%; overflow:auto; background-color:rgba(0,0,0,0.8);">
                                <span style="position:absolute; right:117px; color:white; font-size:30px; cursor:pointer;"
                                    onclick="closeImagePopup()">&times;</span>
                                <img id="modalImage" style="margin:auto; display:block; max-width:80%; max-height:80%;">
                            </div>
                        </div>
                    </div>
                </div>
                {{-- </form> --}}
            </div>
        </div>
    </section>
    <script>
        function openImagePopup(src) {
            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById('modalImage');
            modal.style.display = 'block';
            modalImg.src = src;
        }

        function closeImagePopup() {
            const modal = document.getElementById('imageModal');
            modal.style.display = 'none';
        }
    </script>
@endsection
