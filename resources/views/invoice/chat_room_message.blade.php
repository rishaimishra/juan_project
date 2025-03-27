@extends('layouts.home')

@section('content')
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
            background: rgba(0,0,0,0.9);
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
            background: rgba(0,0,0,0.5);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .chat-container {
                margin-top: 25px;
            }
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
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
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
                    <button class="btn btn-primary rounded-pill flex-grow-1" data-bs-toggle="modal" data-bs-target="#messageModal">
                        {{ __('lang.send_message') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Message Modal -->
    <div class="modal fade message-modal" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="messageModalLabel">{{ __('lang.send_message') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="sendMessageForm" action="{{ route('send-message') }}" method="POST" enctype="multipart/form-data">
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
                            <input class="form-control" type="file" name="chat_images[]" id="chatImages" multiple>
                            <div class="form-text">jpg, jpeg, png, gif, pdf allowed (max-size: 10mb)</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
        // Global variables to track messages
        let lastMessageId = 0;
        let currentDateSeparator = '';
        let isFirstLoad = true;
        let scrollPosition = 0;
        let isUserScrolledUp = false;

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
                return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
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
                    const filePath = `{{ asset('storage/app/public/') }}/${file}`;
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
                                <i class="fas fa-file-pdf"></i> ${file.split('/').pop()}
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
        function fetchMessages() {
            $.ajax({
                url: "{{ route('message-opportunity', [$id, $oppId]) }}",
                type: "GET",
                data: { last_message_id: lastMessageId },
                success: function(response) {
                    if (response.messages && response.messages.length > 0) {
                        const messageContainer = $("#message-container");
                        
                        // Store scroll position before updates
                        scrollPosition = messageContainer.scrollTop();
                        
                        // Check if user has scrolled up
                        checkScrollPosition(messageContainer);
                        
                        // On first load, add all messages
                        if (isFirstLoad) {
                            messageContainer.empty();
                            response.messages.forEach(function(message) {
                                const messageDate = formatDate(message.created_at);
                                addDateSeparator(messageDate, messageContainer);
                                messageContainer.append(createMessageElement(message));
                                lastMessageId = Math.max(lastMessageId, message.id);
                            });
                            isFirstLoad = false;
                            messageContainer.scrollTop(messageContainer[0].scrollHeight);
                        } 
                        // On subsequent loads, only add new messages
                        else {
                            let newMessages = [];
                            response.messages.forEach(function(message) {
                                if (message.id > lastMessageId) {
                                    const messageDate = formatDate(message.created_at);
                                    addDateSeparator(messageDate, messageContainer);
                                    messageContainer.append(createMessageElement(message));
                                    newMessages.push(message.id);
                                }
                            });
                            
                            // Update last message ID
                            if (newMessages.length > 0) {
                                lastMessageId = Math.max(...newMessages);
                                
                                // Only auto-scroll if user hasn't scrolled up
                                if (!isUserScrolledUp) {
                                    messageContainer.scrollTop(messageContainer[0].scrollHeight);
                                }
                            }
                        }
                    } else if (isFirstLoad) {
                        $('#message-container').html('<div class="text-center py-3 text-muted">No messages yet</div>');
                        isFirstLoad = false;
                    }
                },
                error: function(xhr) {
                    console.error("Error loading messages:", xhr);
                    if (isFirstLoad) {
                        $('#message-container').html('<div class="text-center py-3 text-danger">Error loading messages</div>');
                        isFirstLoad = false;
                    }
                },
                complete: function() {
                    // Hide the preloader after the AJAX request completes
                    $("#preloader").hide();
                }
            });
        }

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
            fetchMessages();
            
            // Set up scroll event listener
            $('#message-container').on('scroll', function() {
                checkScrollPosition($(this));
            });

            // Auto-refresh every 3 seconds
            const refreshInterval = setInterval(fetchMessages, 3000);

            // Form submission
            $('#sendMessageForm').submit(function(e) {
                e.preventDefault();
                
                let formData = new FormData(this);
                
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#messageText').val('');
                        $('input[name="chat_images"]').val('');
                        $('#messageModal').modal('hide');
                        
                        // Force a full reload to ensure proper ordering
                        isFirstLoad = true;
                        lastMessageId = 0;
                        fetchMessages();
                    },
                    error: function(xhr) {
                        console.error("Error:", xhr);
                        alert('Error sending message');
                    }
                });
            });

            // Close preview when clicking outside image
            $('#image-preview-modal').click(function(e) {
                if (e.target === this) {
                    closeImagePreview();
                }
            });

            // Clean up interval when page unloads
            $(window).on('beforeunload', function() {
                clearInterval(refreshInterval);
            });
        });
    </script>
@endsection