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

        .blur-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(5px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1050;
            display: none;
            /* Hidden by default */
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
                <h3 class="white fz36 mb-0 font_bold">{{ __('lang.contractor_area') }}</h3>
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

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">{{ __('lang.send_message') }}
                                            </h5>
                                            <button type="button" class="close" onclick="closeModal()"
                                                data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>

                                            <!-- Manual Close Script -->
                                            <script>
                                                function closeModal() {
                                                    $('#exampleModalLong').modal('hide');
                                                }
                                            </script>

                                        </div>
                                        <form id="sendMessageForm" action="{{ route('send-message-contractor') }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <!-- Textarea for message input -->
                                                <input type="hidden" name="oppId" value="{{ $oppId }}">
                                                <input type="hidden" name="invoice_id" value="{{ $id }}">
                                                <textarea id="messageText" name="messageText" class="form-control" rows="5"
                                                    placeholder="Type your message here..."></textarea>
                                                <input type="file" name="chat_images[]" multiple><br>
                                                <small>jpg, jpeg, png, gif, pdf allowed &nbsp; max-size: 10mb</small>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                                    onclick="closeModal()">Close</button>
                                                <!-- Send button -->
                                                <button type="submit" class="btn btn-primary"
                                                    id="sendMessageBtn">Send</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>


                            <h2>{{ __('lang.chat_messages') }}</h2>
                            <h4>{{ __('lang.text_opportunity_name') }}: {{ $oppname->opportunity_name }}</h4>
                            {{-- chat ajax --}}

                            <!-- Loader -->
                            <div id="blurLoader" class="blur-loader">
                                <div class="text-center">
                                    <div class="spinner-border text-primary" role="status"
                                        style="width: 3rem; height: 3rem;"></div>
                                    <p class="mt-2 fw-bold">Loading...</p>
                                </div>
                            </div>

                            <div id="message-container">

                            </div>
                            {{-- chat ajax --}}
                            <button class="send-message btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModalLong">{{ __('lang.send_message') }}</button>

                            <!-- Modal for Image Popup -->
                            <div id="imageModal"
                                style="display:none; position:fixed; z-index:1000; left:0; top:100px; width:100%; height:100%; overflow:auto; background-color:rgba(0,0,0,0.8);">
                                <span style="position:absolute; right:117px; color:white; font-size:30px; cursor:pointer;"
                                    onclick="closeImagePopup()">&times;</span>
                                <img id="modalImage" style="margin:auto; display:block; max-width:80%; max-height:80%;">
                            </div>

                            {{-- <div id="image-preview-modal" class="modal"
                                style="display:none;top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.8); justify-content:center; align-items:center;">
                                <img id="preview-img" style="max-width:90%; max-height:90%; border-radius:8px;">
                            </div> --}}

                            <div id="image-preview-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); text-align: center;">
                                <span>X</span>
                                <img id="preview-img" style="max-width: 90%; margin-top: 50px;">
                                <br>
                                <button onclick="document.getElementById('image-preview-modal').style.display='none'" style="margin-top: 10px; padding: 5px 15px; background: white; cursor: pointer;">Close</button>
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

        function openImagePreview(imageUrl) {
                let previewModal = document.getElementById('image-preview-modal');
                let previewImg = document.getElementById('preview-img');

                previewImg.src = imageUrl;
                previewModal.style.display = 'block';
            }

            // Close the modal when clicking outside the image
            window.onclick = function(event) {
                let previewModal = document.getElementById('image-preview-modal');
                if (event.target === previewModal) {
                    previewModal.style.display = 'none';
                }
            };
    </script>

    <script>
        $(document).ready(function() {

            $('#exampleModalLong form').submit(function(event) {
                event.preventDefault(); // Prevent default form submission

                let formData = new FormData(this);
                document.getElementById('blurLoader').style.display = 'flex';
                $.ajax({
                    url: "{{ route('send-message-contractor') }}",
                    type: "POST",
                    data: formData,
                    processData: false, // Required for FormData
                    contentType: false, // Required for FormData
                    success: function(response) {
                        // Reset the form
                        $('#sendMessageForm')[0].reset();

                        // Clear file input manually
                        $('input[name="chat_images"]').val('');

                        // Clear the emojionearea text field properly
                        if ($("#messageText").data("emojioneArea")) {
                            $("#messageText").data("emojioneArea").setText('');
                        } else {
                            $("#messageText").val(''); // Fallback for regular textarea
                        }

                        // Close modal properly
                        $('#exampleModalLong').modal('hide');

                        // Remove modal backdrop if necessary
                        // $('.modal-backdrop').remove();
                        $('body').removeClass('modal-open');


                        // Optionally update chat messages or reload content
                        // Ensure loader hides after messages are fetched
                        fetchMessages().then(() => {
                            document.getElementById('blurLoader').style.display =
                                'none';
                        }).catch(err => {
                            console.error("Error fetching messages:", err);
                            document.getElementById('blurLoader').style.display =
                                'none'; // Hide loader even if error occurs
                        });



                        // Prevent JSON response from affecting navigation
                        history.pushState({}, '', window.location.href);
                    },
                    error: function(xhr) {
                        console.error("Error sending message:", xhr);
                        document.getElementById('blurLoader').style.display = 'none';
                    }
                });

                setTimeout(function() {
                    document.getElementById('blurLoader').style.display =
                        'none';
                }, 4000); // Hides the loader after 2 seconds
            });


            let isLoading = false; // Prevent multiple requests

            function formatTime(datetime) {
                let date = new Date(datetime);
                return date.toLocaleTimeString('es-ES', {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                });
            }

            function loadMessages() {
                if (isLoading) return; // Prevent overlapping requests
                isLoading = true;


                $.ajax({
                    url: "{{ route('contractor-message-opportunity', ['id' => ':id', 'oppId' => ':oppId']) }}"
                        .replace(':id', {{ $id }}).replace(':oppId', {{ $oppId }}),
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        if (response.messages) {
                            let messageContainer = $("#message-container");

                            response.messages.forEach(function(message) {
                                let isSender = (message.sender_id == {{ Auth::id() }});
                                let formattedTime = formatTime(message.created_at);

                                let messageClass = isSender ? 'chat-message darker' :
                                    'chat-message';
                                let avatar = isSender ?
                                    'https://i.ibb.co/k8mkCZH/free-user-icon-3296-thumb.png' :
                                    'https://i.ibb.co/Yt7TT8T/1144760.png';

                                // Check if message already exists
                                if (messageContainer.find(`[data-message-id="${message.id}"]`)
                                    .length > 0) {
                                    return; // Skip duplicates
                                }

                                let messageHtml = `
                            <div class="${messageClass}" data-message-id="${message.id}">
                                <img src="${avatar}" alt="Avatar" class="${isSender ? 'right' : ''}" style="width:100%;">
                                <p>${message.message ? message.message : ''}</p>
                                <span class="${isSender ? 'time-right' : 'time-left'}" style="font-size: 0.8em;">
                                        ${new Date(message.created_at).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })} 
                                        ${new Date(message.created_at).toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true })}
                                        </span>
                        `;

                                if (message.image) {
                                    let images = message.image.split(',');
                                    messageHtml += '<div class="message-attachments">';
                                    images.forEach(function(file) {
                                        let fileExtension = file.split('.').pop()
                                            .toLowerCase();
                                        let filePath =
                                            `{{ url('storage/app/public/') }}/${file}`;

                                        if (['jpg', 'jpeg', 'png', 'gif'].includes(
                                                fileExtension)) {
                                            // messageHtml +=
                                            //     `<img src="${filePath}" alt="Chat Image" style="width: 100px; height: 100px; margin: 5px;">`;

                                            messageHtml += `
                                                    <div style="display: flex; align-items: center; gap: 10px;">
                                                        <img src="${filePath}" onclick="openImagePreview('${filePath}')" alt="Chat Image" style="width: 100px; height: 100px; margin: 5px;">
                                                    </div>
                                                `;

                                        } else if (fileExtension === 'pdf') {
                                            messageHtml += `
                                        <a href="${filePath}" target="_blank" class="pdf-link">
                                            <svg style="width:100px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                            </svg>
                                        </a>`;
                                        } else {
                                            messageHtml +=
                                                `<a href="${filePath}" target="_blank">${file}</a>`;
                                        }
                                    });
                                    messageHtml += '</div>';
                                }

                                messageHtml += `</div>`; // Closing chat-message div

                                messageContainer.append(messageHtml);
                            });

                            // Scroll to the bottom after adding new messages
                            messageContainer.scrollTop(messageContainer.prop("scrollHeight"));


                        }

                    },
                    error: function(xhr) {
                        console.error("Error fetching messages:", xhr);
                    },
                    complete: function() {
                        isLoading = false; // Reset flag when request completes
                    }
                });
            }

            // Load messages every 5 seconds
            setInterval(loadMessages, 5000);

            // Function to open a preview modal
            

            // Initial load

            loadMessages();
        });
    </script>
@endsection
