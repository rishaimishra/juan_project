<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Register form</title>
    <meta charset="UTF-8">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Gothic+A1:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('public/assets/css/jquery-ui.css') }}" />
    <link href="{{ asset('public/assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/css/media.css') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.2/emojionearea.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script type="text/javascript" src="{{ asset('public/assets/js/jquery.min.js') }}"></script>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-PL6B14B177"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Include Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Include Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- Pusher JS -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

    <style>
        section+div.p-5 {
            padding: 20px 10px !important;
        }
    </style>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-PL6B14B177');
    </script>
</head>

<body>
    <style>
        /* WhatsApp-inspired styling */
        .chat-container {
            height: 100vh;
            background-color: #f0f2f5;
        }

        .sidebar {
            background-color: #ffffff;
            border-right: 1px solid #e9edef;
            height: 100vh;
            padding: 0;
        }

        .chat-header {
            background-color: #f0f2f5;
            padding: 15px;
            border-bottom: 1px solid #e9edef;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .chat-area {
            display: flex;
            flex-direction: column;
            height: 100vh;
            padding: 0;
        }

        .messages-container {
            will-change: transform;
            backface-visibility: hidden;
            transform: translateZ(0);
            flex: 1;
            overflow-y: auto;
            padding: 15px;
            background-color: #e5ddd5;
            background-image: url('https://web.whatsapp.com/img/bg-chat-tile-light_a4be512e7195b6b733d9110b408f075d.png');
            background-repeat: repeat;
            scroll-behavior: smooth;
        }

        .message-input {
            background-color: #f0f2f5;
            padding: 10px 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            position: sticky;
            bottom: 0;
            border-top: 1px solid #e9edef;
        }

        .chat-message {
            transition: all 0.15s ease-out;
            max-width: 70%;
            margin-bottom: 10px;
            padding: 8px 12px;
            border-radius: 7.5px;
            position: relative;
            word-wrap: break-word;
            clear: both;
            opacity: 1;
            transform: translateY(0);
        }

        .chat-message.sent {
            background-color: #d9fdd3;
            float: right;
            border-top-right-radius: 0;
        }

        .chat-message.received {
            background-color: #ffffff;
            float: left;
            border-top-left-radius: 0;
        }

        .message-time {
            font-size: 0.7em;
            color: #667781;
            margin-top: 5px;
            display: block;
            text-align: right;
        }

        .chat-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }

        .message-attachments {
            margin-top: 10px;
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }

        .message-attachments img {
            max-width: 200px;
            max-height: 200px;
            border-radius: 5px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .message-attachments img:hover {
            transform: scale(1.05);
        }

        .pdf-attachment {
            display: inline-flex;
            align-items: center;
            padding: 8px 12px;
            background: #f0f2f5;
            border-radius: 5px;
            color: #333;
            text-decoration: none;
        }

        .pdf-attachment i {
            margin-right: 5px;
            color: #e74c3c;
        }

        .date-separator {
            text-align: center;
            margin: 15px 0;
            position: relative;
        }

        .date-separator span {
            background-color: #e5ddd5;
            padding: 3px 10px;
            border-radius: 15px;
            font-size: 0.8em;
            color: #667781;
        }

        /* Modal styling */
        .message-modal .modal-content {
            border-radius: 10px;
        }

        .message-modal .modal-header {
            border-bottom: none;
            padding-bottom: 0;
        }

        .message-modal .modal-footer {
            border-top: none;
        }

        /* Loading spinner */
        .blur-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(5px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1050;
            display: none;
        }

        /* Image preview modal */
        #image-preview-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            display: none;
        }

        #preview-img {
            max-width: 90%;
            max-height: 90%;
            border-radius: 5px;
        }

        .close-preview {
            position: absolute;
            top: 20px;
            right: 20px;
            color: white;
            font-size: 30px;
            cursor: pointer;
            background: rgba(0, 0, 0, 0.5);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Add this to your styles */
        .messages-container {
            -webkit-overflow-scrolling: touch;
            /* Enable smooth scrolling on iOS */
            overflow-anchor: none;
            /* Prevent iOS from trying to be "smart" */
            padding-bottom: env(safe-area-inset-bottom);
            /* Account for iPhone bottom bar */
        }

        /* iOS-specific fixes */
        @supports (-webkit-touch-callout: none) {
            .chat-container {
                height: calc(100vh - env(safe-area-inset-bottom));
            }

            .message-input {
                padding-bottom: calc(15px + env(safe-area-inset-bottom));
            }
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            /* .chat-container {
                margin-top: 25px;
            } */

            .sidebar {
                display: none;
            }

            .chat-message {
                max-width: 85%;
            }

            .message-attachments img {
                max-width: 150px;
            }

            .chat-header {
                padding: 10px;
            }
        }

        /* Animation for new messages */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .new-message {
            animation: fadeIn 0.3s ease-out;
        }
    </style>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="container-fluid chat-container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 d-none d-md-block sidebar">
                <div class="chat-header">
                    <h5 class="mb-0">{{ __('lang.text_user_area') }}</h5>
                </div>
                <div class="p-3">
                    <ul class="nav flex-column opp_list">
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center" href="{{ route('users-dashboard') }}">
                                <i class="fas fa-list me-2"></i>
                                {{ __('lang.text_opportunity_list') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center" href="{{ route('create-opportunity') }}">
                                <i class="fas fa-plus me-2"></i>
                                {{ __('lang.text_create_opportunity') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main chat area -->
            <div class="col-md-9 col-12 chat-area">
                <div class="chat-header d-flex align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="https://i.ibb.co/Yt7TT8T/1144760.png" class="chat-avatar" alt="Opportunity">
                        <div>
                            <h5 class="mb-0">{{ $oppname->opportunity_name }}</h5>
                            <small class="text-muted">{{ __('lang.text_opportunity_name') }}</small>
                        </div>
                    </div>
                </div>

                <!-- Messages container -->
                <div id="message-container" class="messages-container">
                    <div id="preloader" class="d-flex justify-content-center align-items-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>

                <!-- Message input -->
                <div class="message-input">
                    <button class="btn btn-light rounded-circle" data-bs-toggle="modal" data-bs-target="#messageModal">
                        <i class="fas fa-paperclip"></i>
                    </button>
                    <button class="btn btn-primary rounded-pill flex-grow-1" data-bs-toggle="modal"
                        data-bs-target="#messageModal">
                        {{ __('lang.send_message') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Message Modal -->

    <div class="modal fade message-modal" id="messageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('lang.send_message') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Add ID to the form and change button type -->
                <form id="sendMessageForm" action="{{ route('send-message') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="oppId" value="{{ $oppId }}">
                        <input type="hidden" name="invoice_id" value="{{ $id }}">
                        <div class="mb-3">
                            <textarea id="messageText" name="messageText" class="form-control" rows="5"
                                placeholder="Type your message here..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="chatImages" class="form-label">Attachments</label>
                            <input class="form-control" type="file" name="chat_images[]" id="chatImages"
                                multiple>
                            <div class="form-text">jpg, jpeg, png, gif, pdf allowed (max-size: 10mb)</div>
                            <div id="file-preview" class="mt-2"></div> <!-- File preview container -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <!-- Change to button type="submit" -->
                        <button type="submit" class="btn btn-primary" id="sendMessageBtn">
                            <i class="fas fa-paper-plane me-1"></i> Send
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Image Preview Modal -->
    <div id="image-preview-modal">
        <span class="close-preview" onclick="closeImagePreview()">&times;</span>
        <img id="preview-img">
    </div>

    <script>
        // Initialize Pusher
        const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
            cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
            encrypted: true
        });

        // Subscribe to the channel
        const channel = pusher.subscribe('chat-channel-{{ $oppId }}');

        // Global variables to track messages
        let lastMessageId = 0;
        let currentDateSeparator = '';
        let isFirstLoad = true;
        let scrollPosition = 0;
        let isUserScrolledUp = false;

        // Add at the top of your script
        const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent);
        if (isIOS) {
            $('html').addClass('ios-device');
        }

        // Modified scrollToBottom function
        function scrollToBottom(force = false) {
            const container = $("#message-container");
            if (force || !isUserScrolledUp) {
                if (isIOS) {
                    setTimeout(() => {
                        container.scrollTop(container[0].scrollHeight);
                        setTimeout(() => {
                            container.scrollTop(container[0].scrollHeight);
                        }, 100);
                    }, 100);
                } else {
                    container.stop().animate({
                        scrollTop: container[0].scrollHeight
                    }, 200);
                }
            }
        }

        // Format date as "Today", "Yesterday", or date
        function formatDate(datetime) {
            const date = new Date(datetime);
            const today = new Date();
            const yesterday = new Date(today);
            yesterday.setDate(yesterday.getDate() - 1);

            if (date.toDateString() === today.toDateString()) {
                return 'Today';
            } else if (date.toDateString() === yesterday.toDateString()) {
                return 'Yesterday';
            } else {
                return date.toLocaleDateString('en-US', {
                    month: 'short',
                    day: 'numeric'
                });
            }
        }

        // Format time as HH:MM
        function formatTime(datetime) {
            return new Date(datetime).toLocaleTimeString('en-US', {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            });
        }

        // Create a message element
        function createMessageElement(message) {
            const isSender = (message.sender_id == {{ Auth::id() }});
            const messageClass = isSender ? 'chat-message sent' : 'chat-message received';
            const avatar = isSender ?
                'https://i.ibb.co/k8mkCZH/free-user-icon-3296-thumb.png' :
                'https://i.ibb.co/Yt7TT8T/1144760.png';

            let messageHtml = `
                <div class="${messageClass} new-message" data-message-id="${message.id}">
                    <p>${message.message || ''}</p>
                    <span class="message-time">${formatTime(message.created_at)}</span>
            `;

            // Handle attachments
            if (message.image) {
                messageHtml += '<div class="message-attachments">';
                message.image.split(',').forEach(function(file) {
                    const filePath = `{{ url('storage/app/public/') }}/${file}`;
                    const extension = file.split('.').pop().toLowerCase();

                    if (['jpg', 'jpeg', 'png', 'gif'].includes(extension)) {
                        messageHtml += `
                            <img src="${filePath}" 
                                 onclick="openImagePreview('${filePath}')" 
                                 alt="Attachment">
                        `;
                    } else if (extension === 'pdf') {
                        messageHtml += `
                            <a href="${filePath}" target="_blank" class="pdf-attachment">
                                <i class="fas fa-file-pdf fa-2x" style="width: 24px; height: 24px;"></i> 
                            </a>
                        `;
                    }
                });
                messageHtml += '</div>';
            }

            messageHtml += '</div>';
            return messageHtml;
        }

        // Add date separator if needed
        function addDateSeparator(dateStr, container) {
            if (dateStr !== currentDateSeparator) {
                container.append(`
                    <div class="date-separator">
                        <span>${dateStr}</span>
                    </div>
                `);
                currentDateSeparator = dateStr;
            }
        }

        // Check if user has scrolled up
        function checkScrollPosition(container) {
            const threshold = 100; // pixels from bottom
            const position = container.scrollTop() + container.innerHeight();
            const height = container[0].scrollHeight;
            isUserScrolledUp = position < height - threshold;
        }

        // Load messages efficiently
        function loadMessages() {
            return new Promise((resolve) => {
                $.ajax({
                    url: "{{ route('message-opportunity', ['id' => $id, 'oppId' => $oppId]) }}",
                    type: "GET",
                    data: {
                        last_message_id: lastMessageId
                    },
                    success: function(response) {
                        console.log('Messages loaded:', response.messages);
                        if (response.messages && response.messages.length > 0) {
                            const messageContainer = $("#message-container");
                            checkScrollPosition(messageContainer);

                            if (isFirstLoad) {
                                messageContainer.empty();
                                response.messages.forEach(function(message) {
                                    const messageDate = formatDate(message.created_at);
                                    addDateSeparator(messageDate, messageContainer);
                                    messageContainer.append(createMessageElement(message));
                                    lastMessageId = Math.max(lastMessageId, message.id);
                                });
                                isFirstLoad = false;
                                scrollToBottom(true);
                            } else {
                                let newMessages = [];
                                response.messages.forEach(function(message) {
                                    if (message.id > lastMessageId) {
                                        const messageDate = formatDate(message.created_at);
                                        addDateSeparator(messageDate, messageContainer);
                                        messageContainer.append(createMessageElement(message));
                                        newMessages.push(message.id);
                                    }
                                });

                                if (newMessages.length > 0) {
                                    lastMessageId = Math.max(...newMessages);
                                    scrollToBottom();
                                }
                            }
                        } else if (isFirstLoad) {
                            $('#message-container').html(
                                '<div class="text-center py-3 text-muted">No messages yet</div>');
                            isFirstLoad = false;
                        }
                        resolve();
                    },
                    error: function(xhr) {
                        console.error("Error loading messages:", xhr);
                        resolve();
                    }
                });
            });
        }

        // Listen for new messages
        channel.bind('new-message', function(data) {
            console.log('New message received:', data);
            if (data.message) {
                const messageContainer = $("#message-container");
                const messageDate = formatDate(data.message.created_at);
                addDateSeparator(messageDate, messageContainer);
                messageContainer.append(createMessageElement(data.message));
                lastMessageId = Math.max(lastMessageId, data.message.id);
                scrollToBottom();
            }
        });

        // Image preview functions
        function openImagePreview(src) {
            const previewModal = document.getElementById('image-preview-modal');
            const previewImg = document.getElementById('preview-img');
            previewImg.src = src;
            previewModal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeImagePreview() {
            document.getElementById('image-preview-modal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Form submission
        $(document).ready(function() {
            // Initial load
            loadMessages().then(() => {
                scrollToBottom(true);
            });

            // Set up scroll event listener
            $('#message-container').on('scroll', function() {
                checkScrollPosition($(this));
            });

            // Form submission
            $('#sendMessageForm').on('submit', function(e) {
                e.preventDefault();
                $('#blurLoader').show();

                let formData = new FormData(this);
                let $form = $(this);

                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log('Message sent successfully:', response);
                        
                        // Reset form
                        $form[0].reset();
                        $('#messageText').val('').trigger('change');
                        $('#file-preview').empty();
                        new FormData($form[0]);
                        $('#messageModal').modal('hide');
                        
                        // If we have the message data in the response, add it directly
                        if (response.data) {
                            const messageContainer = $("#message-container");
                            const messageDate = formatDate(response.data.created_at);
                            addDateSeparator(messageDate, messageContainer);
                            messageContainer.append(createMessageElement(response.data));
                            lastMessageId = Math.max(lastMessageId, response.data.id);
                            scrollToBottom(true);
                        } else {
                            // Fallback to reloading messages
                            isFirstLoad = false;
                            loadMessages().then(() => {
                                scrollToBottom(true);
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error("Error sending message:", xhr);
                        alert('Error sending message');
                    },
                    complete: function() {
                        $('#blurLoader').hide();
                    }
                });
            });

            // Add this modal hidden event handler
            $('#messageModal').on('hidden.bs.modal', function() {
                $('#sendMessageForm')[0].reset();
                $('#messageText').val('').trigger('change');
            });

            // Close preview when clicking outside image
            $('#image-preview-modal').click(function(e) {
                if (e.target === this) {
                    closeImagePreview();
                }
            });
        });
    </script>
    {{-- @endsection --}}
</body>

</html>
