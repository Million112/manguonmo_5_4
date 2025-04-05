<?php
/**
 * Plugin Name: Quick Chat Button
 * Description: Thêm nút chat nhanh với Messenger và Zalo trên website WordPress.
 * Version: 1.0
 * Author: Your Name
 */

// Thêm menu cài đặt vào WordPress Admin
function quick_chat_button_menu() {
    add_options_page(
        'Quick Chat Button',
        'Quick Chat Button',
        'manage_options',
        'quick-chat-button',
        'quick_chat_button_settings_page'
    );
}
add_action('admin_menu', 'quick_chat_button_menu');

// Trang cài đặt
function quick_chat_button_settings_page() {
    ?>
    <div class="wrap">
        <h2>Quick Chat Button Settings</h2>
        <form method="post" action="options.php">
            <?php
            settings_fields('quick_chat_button_settings');
            do_settings_sections('quick-chat-button');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Đăng ký các cài đặt
function quick_chat_button_settings() {
    register_setting('quick_chat_button_settings', 'quick_chat_messenger');
    register_setting('quick_chat_button_settings', 'quick_chat_zalo');
    register_setting('quick_chat_button_settings', 'quick_chat_text');
    register_setting('quick_chat_button_settings', 'quick_chat_color');

    add_settings_section('quick_chat_button_section', 'Chat Button Settings', null, 'quick-chat-button');

    add_settings_field('quick_chat_messenger', 'Messenger URL', 'quick_chat_messenger_callback', 'quick-chat-button', 'quick_chat_button_section');
    add_settings_field('quick_chat_zalo', 'Zalo Phone Number', 'quick_chat_zalo_callback', 'quick-chat-button', 'quick_chat_button_section');
    add_settings_field('quick_chat_text', 'Button Text', 'quick_chat_text_callback', 'quick-chat-button', 'quick_chat_button_section');
    add_settings_field('quick_chat_color', 'Button Color', 'quick_chat_color_callback', 'quick-chat-button', 'quick_chat_button_section');
}
add_action('admin_init', 'quick_chat_button_settings');

// Callbacks
function quick_chat_messenger_callback() {
    echo '<input type="text" name="quick_chat_messenger" value="' . get_option('quick_chat_messenger') . '" class="regular-text">';
}

function quick_chat_zalo_callback() {
    echo '<input type="text" name="quick_chat_zalo" value="' . get_option('quick_chat_zalo') . '" class="regular-text">';
}

function quick_chat_text_callback() {
    echo '<input type="text" name="quick_chat_text" value="' . get_option('quick_chat_text', 'Chat ngay') . '" class="regular-text">';
}

function quick_chat_color_callback() {
    echo '<input type="color" name="quick_chat_color" value="' . get_option('quick_chat_color', '#007bff') . '">';
}

// Hiển thị nút chat trên giao diện
function quick_chat_button_display() {
    $messenger = get_option('quick_chat_messenger');
    $zalo = get_option('quick_chat_zalo');
    $text = get_option('quick_chat_text', 'Chat ngay');
    $color = get_option('quick_chat_color', '#007bff');

    echo '<div class="quick-chat-button">';
    if (!empty($messenger)) {
        echo '<a href="' . esc_url($messenger) . '" target="_blank" class="quick-chat-link messenger" style="background-color:' . esc_attr($color) . '"><i class="fab fa-facebook-messenger"></i> ' . esc_html($text) . '</a>';
    }
    if (!empty($zalo)) {
        echo '<a href="https://zalo.me/' . esc_attr($zalo) . '" target="_blank" class="quick-chat-link zalo" style="background-color:' . esc_attr($color) . '"><i class="fab fa-zalo"></i> ' . esc_html($text) . '</a>';
    }
    echo '</div>';
}
add_action('wp_footer', 'quick_chat_button_display');

// Thêm CSS
function quick_chat_button_styles() {
    echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">';
    echo '<style>
        .quick-chat-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            z-index: 1000;
        }
        .quick-chat-link {
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 50px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
        }
        .quick-chat-link i {
            margin-right: 10px;
        }
    </style>';
}
add_action('wp_head', 'quick_chat_button_styles');
