jQuery(document).ready(function($) {
    // Define globally so it's accessible in window load
    window.updateLauncherIcon = function() {
        const icon = $('#ai-chat-launcher i');
        if ($('#ai-chat-widget').is(':visible')) {
            icon.removeClass('fa-comments').addClass('fa-times');
        } else {
            icon.removeClass('fa-times').addClass('fa-comments');
        }
    };

    // Chat launcher toggle
    $('#ai-chat-launcher').on('click', function() {
        $('#ai-chat-widget').slideToggle(() => {
            updateLauncherIcon();

            // If no messages yet, show the initial greeting message
            if ($('#ai-chat-messages').children().length === 0) {
                $('#ai-chat-messages').append(`
                    <div class="assistant">
                        <img src="https://cdn-icons-png.flaticon.com/512/4712/4712038.png" alt="Bot">
                        <div class="bubble">${aiChatData.start_message}</div>
                    </div>
                `);
            }
        });
    });

    // Close button inside chat
    $('#ai-chat-close').on('click', function() {
        $('#ai-chat-widget').slideUp(updateLauncherIcon);
    });

    // Function to append a loading indicator while waiting for a response
    function showLoadingIndicator() {
        $('#ai-chat-messages').append(`
            <div class="assistant loading">
                <img src="https://cdn-icons-png.flaticon.com/512/4712/4712038.png" alt="Bot">
                <div class="bubble">...</div>
            </div>
        `);
    }

    // Function to append the message (user or assistant)
    function appendMessage(sender, message) {
        $('#ai-chat-messages').append(`
            <div class="${sender}">
                <img src="https://cdn-icons-png.flaticon.com/512/1077/1077012.png" alt="${sender === 'user' ? 'You' : 'Support Executive'}">
                <div class="bubble">${message}</div>
            </div>
        `);
    }

    // Send message
    function sendUserMessage() {
        let message = $('#ai-chat-input').val().trim();
        if (!message) return;

        // Append the user's message to the chat
        appendMessage('user', message);
        $('#ai-chat-input').val('');

        // Show loading indicator for assistant's response
        showLoadingIndicator();

        // Send message to the server (PHP) for processing
        $.post(aiChatData.ajax_url, {
            action: 'ai_assistant_send',
            message: message
        }, function(response) {
            // Remove the loading indicator
            $('.assistant.loading').remove();

            let reply = response.success ? response.data : 'Sorry, something went wrong.';

            // Append the assistant's reply (support executive) to the chat
            appendMessage('assistant', reply);

            // Scroll the chat to the bottom
            $('#ai-chat-messages').scrollTop($('#ai-chat-messages')[0].scrollHeight);
        });
    }

    $('#ai-chat-send').on('click', sendUserMessage);

    // Send on Enter key press
    $('#ai-chat-input').on('keypress', function(e) {
        if (e.which === 13 && !e.shiftKey) {
            e.preventDefault();
            sendUserMessage();
        }
    });
});

// Auto open after page load (delay to ensure UI is ready)
jQuery(window).on('load', function() {
    setTimeout(function() {
        jQuery(function($) {
            $('#ai-chat-widget').slideDown(() => {
                updateLauncherIcon();

                // If no messages yet, show the initial greeting message
                if ($('#ai-chat-messages').children().length === 0) {
                    $('#ai-chat-messages').append(`
                        <div class="assistant">
                            <img src="https://cdn-icons-png.flaticon.com/512/4712/4712038.png" alt="Bot">
                            <div class="bubble">${aiChatData.start_message}</div>
                        </div>
                    `);
                }
            });
        });
    }, 800); // Delay in milliseconds
});
