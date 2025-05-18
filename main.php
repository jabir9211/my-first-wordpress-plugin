<?php
/*
Plugin Name: AI Assistant for Business
Description: A personalized AI assistant plugin that gathers essential business details to act as a support executive.
Version: 1.0
Author: Your Name
License: GPLv2 or later
*/

// Register the admin menu
add_action('admin_menu', 'ai_assistant_add_admin_menu');

function ai_assistant_add_admin_menu()
{
    add_menu_page(
        'AI Assistant',
        'AI Assistant',
        'manage_options',
        'ai-assistant',
        'ai_assistant_settings_page',
        'dashicons-smiley',
        100
    );

    add_submenu_page(
        'ai-assistant',
        'Business Info',
        'Details',
        'manage_options',
        'ai-assistant-details',
        'ai_assistant_settings_page'
    );

    add_submenu_page(
        'ai-assistant',
        'Integration Settings',
        'Integration',
        'manage_options',
        'ai-assistant-integration',
        'ai_assistant_integration_page'
    );
}

// Register settings
add_action('admin_init', 'ai_assistant_settings_init');

function ai_assistant_settings_init()
{
    register_setting('ai_assistant_options', 'ai_assistant_data');
    register_setting('ai_assistant_api_options', 'ai_assistant_api_key');
}

function ai_assistant_settings_page()
{
    $options = get_option('ai_assistant_data');
?>
    <div class="wrap">
        <h1>AI Assistant Business Details</h1>
        <form method="post" action="options.php">
            <?php settings_fields('ai_assistant_options'); ?>
            <table class="form-table">
                <tr>
                    <th scope="row">Business Name</th>
                    <td><input type="text" name="ai_assistant_data[business_name]" value="<?php echo esc_attr($options['business_name'] ?? ''); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th scope="row">Business Description</th>
                    <td><textarea name="ai_assistant_data[description]" rows="3" class="large-text"><?php echo esc_textarea($options['description'] ?? ''); ?></textarea></td>
                </tr>
                <tr>
                    <th scope="row">Main Products or Services</th>
                    <td><input type="text" name="ai_assistant_data[products_services]" value="<?php echo esc_attr($options['products_services'] ?? ''); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th scope="row">Typical Customers or Clients</th>
                    <td><input type="text" name="ai_assistant_data[customers]" value="<?php echo esc_attr($options['customers'] ?? ''); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th scope="row">Preferred Tone/Personality</th>
                    <td><input type="text" name="ai_assistant_data[tone]" value="<?php echo esc_attr($options['tone'] ?? ''); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th scope="row">Address</th>
                    <td>
                        <textarea name="ai_assistant_data[address]" rows="3" class="large-text" placeholder="123 Main Street, City, Country"><?php echo esc_textarea($options['address'] ?? ''); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Contact Details</th>
                    <td>
                        <input type="text" name="ai_assistant_data[contact_details]" value="<?php echo esc_attr($options['contact_details'] ?? ''); ?>" class="regular-text" placeholder="Phone, Email, Address">
                    </td>
                </tr>
                <tr>
                    <th scope="row">Business Hours / Support Availability</th>
                    <td><input type="text" name="ai_assistant_data[hours]" value="<?php echo esc_attr($options['hours'] ?? ''); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th scope="row">Common Customer Questions</th>
                    <td><textarea name="ai_assistant_data[common_questions]" rows="3" class="large-text"><?php echo esc_textarea($options['common_questions'] ?? ''); ?></textarea></td>
                </tr>
                <tr>
                    <th scope="row">Promotions or Highlights</th>
                    <td><input type="text" name="ai_assistant_data[promotions]" value="<?php echo esc_attr($options['promotions'] ?? ''); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th scope="row">Things to Avoid Saying</th>
                    <td><input type="text" name="ai_assistant_data[avoid]" value="<?php echo esc_attr($options['avoid'] ?? ''); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th scope="row">Link to FAQ or Help Center</th>
                    <td><input type="url" name="ai_assistant_data[faq_link]" value="<?php echo esc_url($options['faq_link'] ?? ''); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th scope="row">Initial Greeting Message</th>
                    <td><input type="text" name="ai_assistant_data[initial_greeting]" value="<?php echo esc_attr($options['initial_greeting'] ?? ''); ?>" class="regular-text" placeholder="Hi there! 👋 I’m your assistant. How can I help you today?"></td>
                </tr>

            </table>
            <?php submit_button('Save Business Info'); ?>
        </form>
    </div>
<?php
}

function ai_assistant_integration_page()
{
    $api_key = get_option('ai_assistant_api_key');
?>
    <div class="wrap">
        <h1>API Integration</h1>
        <form method="post" action="options.php" style="max-width: 600px; margin-top: 20px;">
            <?php
            settings_fields('ai_assistant_api_options');
            do_settings_sections('ai_assistant_api_options');
            ?>
            <table class="form-table">
                <tr>
                    <th scope="row">Gemini API Key</th>
                    <td>
                        <input type="text" name="ai_assistant_api_key" value="<?php echo esc_attr($api_key); ?>" class="regular-text" placeholder="Enter your Gemini API Key">
                        <p class="description">Your API key is securely stored in the WordPress database.</p>
                    </td>
                </tr>
            </table>
            <?php submit_button('Save API Key'); ?>
        </form>

        <div style="margin-top: 40px; background: #fff; padding: 20px; border-left: 4px solid #0073aa;">
            <h2>🔑 How to Get Your Gemini API Key</h2>
            <ol style="line-height: 1.7;">
                <li>Go to the official <a href="https://aistudio.google.com/app/apikey" target="_blank">Gemini API Console</a>.</li>
                <li>Sign in with your Google account.</li>
                <li>Click <strong>“Create API Key”</strong>.</li>
                <li>Copy the generated API key.</li>
                <li>Paste it into the field above and click <strong>Save API Key</strong>.</li>
            </ol>
            <p style="color: #555;">Never share your API key publicly. Keep it confidential.</p>
        </div>
    </div>
<?php
}

function ai_assistant_generate_prompt()
{
    $options = get_option('ai_assistant_data');

    if (!$options) return '';

    return "You are an AI support assistant for {$options['business_name']}.\n\n" .
        "Business Description: {$options['description']}\n" .
        "Products/Services: {$options['products_services']}\n" .
        "Target Customers: {$options['customers']}\n" .
        "Tone: {$options['tone']}\n" .
        "Business Hours: {$options['hours']}\n" .
        "Common Questions: {$options['common_questions']}\n" .
        "Promotions/Highlights: {$options['promotions']}\n" .
        "Avoid Saying: {$options['avoid']}\n" .
        "Help Center Link: {$options['faq_link']}\n\n" .
        "Address: {$options['address']}\n" .
        "Contact Details: {$options['contact_details']}\n\n" .
        "Answer user questions about this business in a polite, engaging, and helpful manner.";
}
function ai_assistant_query_gemini($user_input)
{
    $prompt = ai_assistant_generate_prompt();

    $full_prompt = $prompt . "\n\nUser Question: " . $user_input;

    $api_key = get_option('ai_assistant_api_key');
    if (!$api_key) {
        return "API key is not set. Please go to the Integration page to add your Gemini API key.";
    }

    $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash-preview-04-17:generateContent?key=' . $api_key;

    $data = [
        "contents" => [
            [
                "role" => "user",
                "parts" => [
                    ["text" => $full_prompt]
                ]
            ]
        ]
    ];

    $args = [
        'headers' => ['Content-Type' => 'application/json'],
        'body'    => json_encode($data),
        'method'  => 'POST',
        'timeout' => 20,
    ];

    $response = wp_remote_post($url, $args);

    if (is_wp_error($response)) {
        return "Error: " . $response->get_error_message();
    }

    $body = json_decode(wp_remote_retrieve_body($response), true);
    return $body['candidates'][0]['content']['parts'][0]['text'] ?? 'No response from AI.';
}
add_shortcode('ai_assistant_chat', 'ai_assistant_chatbox');

function ai_assistant_chatbox()
{
    // Enqueue scripts only when shortcode is used
    $options = get_option('ai_assistant_data');

    wp_enqueue_script('ai-chat-js', plugin_dir_url(__FILE__) . 'js/chat.js', ['jquery'], time(), true);
    wp_localize_script('ai-chat-js', 'aiChatData', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'start_message' => $options['initial_greeting'] ?? 'Hi there! 👋 I’m your assistant. How can I help you today?'
    ]);

    ob_start(); ?>
    <div id="ai-chat-box" style="max-width:600px; margin:auto; font-family: Arial, sans-serif;">
        <div id="ai-messages" style="background:#f9f9f9; padding:15px; min-height:150px; border:1px solid #ccc; border-radius:6px; overflow-y:auto; max-height:300px;"></div>
        <div style="margin-top: 10px; display: flex; gap: 10px;">
            <input type="text" id="ai-user-input" placeholder="Type your question..." style="flex:1; padding:10px; border:1px solid #ccc; border-radius:4px;">
            <button id="ai-send-btn" style="padding:10px 15px; background:#0073aa; color:#fff; border:none; border-radius:4px;">Send</button>
        </div>
    </div>
<?php return ob_get_clean();
}


add_action('wp_enqueue_scripts', 'ai_assistant_enqueue_script');
function ai_assistant_enqueue_script()
{
    wp_enqueue_script('jquery');
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');
    wp_enqueue_style('ai-chat-style', plugin_dir_url(__FILE__) . 'css/ai-chat.css');
}

add_action('wp_ajax_nopriv_ai_assistant_send', 'ai_assistant_ajax_handler');
add_action('wp_ajax_ai_assistant_send', 'ai_assistant_ajax_handler');

function ai_assistant_ajax_handler()
{
    if (!isset($_POST['message'])) {
        wp_send_json_error('Missing message');
    }
    $user_input = sanitize_text_field($_POST['message']);
    $response = "This is a test response from assistant."; // Dummy response
    wp_send_json_success($response);
}

add_action('wp_footer', 'ai_assistant_chat_ui');
function ai_assistant_chat_ui()
{
?>
    <div id="ai-chat-launcher" class="ai-launcher">
        <i class="fa fa-comments"></i>
    </div>

    <div id="ai-chat-widget" class="ai-widget">
        <div class="ai-header">
            <span>AI Support Assistant</span>
            <span id="ai-chat-close">&times;</span>
        </div>
        <div id="ai-chat-messages" class="ai-messages"></div>
        <div class="ai-input-area">
            <input type="text" id="ai-chat-input" placeholder="Type your message..." />
            <button id="ai-chat-send"><i class="fa fa-paper-plane"></i></button>
        </div>
    </div>

    <script>
        var aiChatData = {
            ajax_url: '<?php echo admin_url("admin-ajax.php"); ?>',
            start_message: 'Hi there! 👋 How can I help you today?'
        };

        jQuery(document).ready(function($) {
            function updateLauncherIcon() {
                let launcherIcon = $('#ai-chat-launcher i');
                if ($('#ai-chat-widget').is(':visible')) {
                    launcherIcon.removeClass('fa-comments').addClass('fa-times');
                } else {
                    launcherIcon.removeClass('fa-times').addClass('fa-comments');
                }
            }

            // Initial icon setup in case chat is pre-opened
            updateLauncherIcon();

            $('#ai-chat-launcher').on('click', function() {
                $('#ai-chat-widget').slideToggle(() => {
                    updateLauncherIcon();

                    // Show welcome message only once
                    if ($('#ai-chat-messages').children().length === 0) {
                        $('#ai-chat-messages').append('<div class="assistant">' + aiChatData.start_message + '</div>');
                    }
                });
            });

            $('#ai-chat-close').on('click', function() {
                $('#ai-chat-widget').slideUp(updateLauncherIcon);
            });

            $('#ai-chat-send').on('click', function() {
                let message = $('#ai-chat-input').val().trim();
                if (message) {
                    $('#ai-chat-messages').append('<div class="user">' + message + '</div>');
                    $('#ai-chat-input').val('');

                    $.post(aiChatData.ajax_url, {
                        action: 'ai_assistant_send',
                        message: message
                    }, function(response) {
                        if (response.success) {
                            $('#ai-chat-messages').append('<div class="assistant">' + response.data + '</div>');
                        } else {
                            $('#ai-chat-messages').append('<div class="assistant">Sorry, something went wrong.</div>');
                        }
                        $('#ai-chat-messages').scrollTop($('#ai-chat-messages')[0].scrollHeight);
                    });
                }
            });
        });
    </script>
<?php
}
