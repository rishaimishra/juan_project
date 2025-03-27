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

        .chat-message {
            margin-bottom: 10px;
            padding: 10px;
        }

        .chat-message img {
            float: left;
            max-width: 100px;
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

        ul {
            list-style-type: none;
        }

        .opp_list li a {
            color: #0772b1;
        }

        .opp_list li a:hover {
            color: #0772b1;
        }

        @media only screen and (max-width:600px) {
            .login_section {
                margin-top: 40px !important;
            }

        }

        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            z-index: 9999;
            display: none;
        }

        #image-preview-modal{position:fixed!important;top:50%!important;left:50%!important;transform:translate(-50%,-50%);z-index:999999999999;}div#image-preview-modal span{display:none;}@media only screen and (max-width:600px){.message-attachments{margin-top:100px}}

        #image-preview-modal #preview-img{width:auto;max-width:90%!important;height:auto;margin-top:10px!important;max-height:70%!important;}#image-preview-modal{position:fixed!important;top:50%!important;left:50%!important;transform:translate(-50%,-50%);z-index:999999999999;width:100vw!important;height:100vh!important;}
        @media only screen and (max-width:600px){#image-preview-modal{padding-top:100px}}
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
                <h3 class="white fz36 mb-0 font_bold">{{ __('lang.text_user_area') }}</h3>
            </section>
            <div class="login_form p-5 font_bold c-form">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <ul class="opp_list">
                                <li style="margin-bottom: 20px"><a
                                        href="{{ route('users-dashboard') }}">{{ __('lang.text_opportunity_list') }}</a>
                                </li>
                                <li><a href="{{ route('create-opportunity') }}">{{ __('lang.text_create_opportunity') }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-8">
                            <!-- Send Message Button -->
                            {{-- <button class="send-message btn btn-primary" data-toggle="modal"
                                data-target="#exampleModalLong">{{ __('lang.send_message') }}</button> --}}



                            <!-- Modal -->
                            <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">{{ __('lang.send_message') }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('send-message') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <input type="hidden" name="oppId" value="{{ $oppId }}">
                                                <input type="hidden" name="invoice_id" value="{{ $id }}">
                                                <div class="input-group">
                                                    <textarea id="emojionearea1" name="messageText" class="form-control" rows="5"
                                                        placeholder="Type your message here..."></textarea>
                                                </div>
                                                <input type="file" name="chat_images[]" multiple>
                                                <small>jpg, jpeg, png, gif, pdf allowed &nbsp; max-size: 10mb</small>
                                                {{-- <span class="text-danger">{{ $errors->first('chat_images') }}</span> --}}
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">{{ __('lang.close') }}</button>
                                                <button type="submit" class="btn btn-primary"
                                                    id="sendMessageBtn">{{ __('lang.send') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>


                            <h2>{{ __('lang.chat_messages') }}</h2>
                            <h4>{{ __('lang.text_opportunity_name') }}: {{ $oppname->opportunity_name }}</h4>



                            <div class="chat-box" id="chatBox">
                                <div id="preloader" class="d-flex justify-content-center align-items-center">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>

                            <button class="send-message btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModalLong">{{ __('lang.send_message') }}</button>

                                <div id="image-preview-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); text-align: center;">
                                    <span>X</span>
                                    <img id="preview-img" style="max-width: 90%; margin-top: 50px;">
                                    <br>
                                    <button onclick="document.getElementById('image-preview-modal').style.display='none'" style="margin-top: 10px; padding: 5px 15px; background: white; cursor: pointer;">Close</button>
                                </div>
                                


                        </div>
                    </div>
                </div>
                <!-- </form> -->
            </div>
        </div>
    </section>

    <script>
        function openImagePreview(imageUrl) {
            let previewModal = document.getElementById('image-preview-modal');
            let previewImg = document.getElementById('preview-img');

            if (previewModal && previewImg) {
                previewImg.src = imageUrl;
                previewModal.style.display = 'block';
            } else {
                console.error("Modal or image element not found!");
            }
        }
    </script>

    <script>
        $(document).ready(function() {

            // Handle form submission using AJAX
            $('#exampleModalLong form').submit(function(event) {
                event.preventDefault(); // Prevent default form submission

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('send-message') }}",
                    type: "POST",
                    data: formData,
                    processData: false, // Don't process FormData
                    contentType: false, // Set content type to false
                    success: function(response) {
                        // Reset the form
                        $('#exampleModalLong form')[0].reset();

                        // Clear file input manually
                        $('input[name="chat_images"]').val('');

                        // Clear the emojionearea text field
                        if ($("#emojionearea1").data("emojioneArea")) {
                            $("#emojionearea1").data("emojioneArea").setText('');
                        }

                        // Close modal properly
                        $('#exampleModalLong').modal('hide');

                        // Update chat messages
                        fetchMessages();

                        // Prevent JSON response from breaking page navigation
                        history.pushState({}, '', window.location.href);
                    },
                    error: function(xhr) {
                        console.error("Error sending message:", xhr);
                    }
                });
            });

            let oppId = "{{ $oppId }}";
            let invoiceId = "{{ $id }}";

            // Fetch messages every 5 seconds
            setInterval(fetchMessages, 5000);
            $("#preloader").show();

            function fetchMessages() {
                $.ajax({
                    url: "{{ route('message-opportunity', [$id, $oppId]) }}",
                    type: "GET",
                    success: function(response) {


                        $("#chatBox").html(''); // Clear existing messages
                        response.messages.forEach(function(message) {
                            let isSender = message.sender_id == "{{ auth()->id() }}";
                            let chatHtml =
                                `<div class="chat-message ${isSender ? 'darker' : ''}">
                                    <img src="${isSender ? 'https://i.ibb.co/k8mkCZH/free-user-icon-3296-thumb.png' : 'https://i.ibb.co/Yt7TT8T/1144760.png'}" alt="Avatar" class="${isSender ? 'right' : ''}" style="width:100%;">
                                    <p>${message.message ? message.message : ''}</p>
                                    <span class="${isSender ? 'time-right' : 'time-left'}" style="font-size: 0.8em;">
                                        ${new Date(message.created_at).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })} 
                                        ${new Date(message.created_at).toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true })}
                                        </span>`;


                            if (message.image) {
                                let files = message.image.split(',');
                                let attachmentsHtml = '<div class="message-attachments">';
                                files.forEach(function(file) {
                                    let fileExtension = file.split('.').pop()
                                        .toLowerCase();
                                    let filePath =
                                        `{{ asset('storage/app/public/') }}/${file}`;

                                    if (['jpg', 'jpeg', 'png', 'gif'].includes(
                                            fileExtension)) {
                                        // attachmentsHtml +=
                                        //     `<img src="${filePath}" alt="Chat Image" style="width: 100px; height: 100px; margin: 5px;">`;

                                        attachmentsHtml += `
                                                <div style="display: flex; align-items: center; gap: 10px;">
                                                    <img src="${filePath}" onclick="openImagePreview('${filePath}')" alt="Chat Image" style="width: 100px; height: 100px; margin: 5px;">
                                                </div>
                                            `;

                                    } else if (fileExtension === 'pdf') {
                                        attachmentsHtml +=
                                            `<a href="${filePath}" target="_blank">
                                                <svg style="width:100px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                            </svg>
                                            </a>`;
                                    } else {
                                        attachmentsHtml +=
                                            `<a href="${filePath}" target="_blank">${file}</a>`; //handle other file types
                                    }
                                });
                                attachmentsHtml += '</div>';
                                chatHtml += attachmentsHtml;
                            }

                            chatHtml += '</div>'; // Closing chat-message div
                            $("#chatBox").append(chatHtml);

                        });

                        // Auto-scroll to the latest message
                        $("#chatBox").scrollTop($("#chatBox")[0].scrollHeight);
                    },
                    error: function(xhr, status, error) {
                        $("#preloader").hide();
                        console.error("Error fetching messages:", error);
                    },
                    complete: function(xhr, status) {
                        // Hide the preloader after the AJAX request completes (success or error)
                        $("#preloader").hide();
                    }
                });
            }
        });
    </script>
@endsection
