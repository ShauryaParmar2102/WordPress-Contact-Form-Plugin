<?php
/*
Plugin Name: Contact Form Plugin
Description: Contact form plugin with admin message management.
Version: 1.0
Author: Shaurya Parmar
*/

/* ---------------------------
   SHORTCODE FORM
----------------------------*/
function example_form_pluggin() {

    $content  = '<h2>Contact Us!</h2>';
    $content .= '<form method="post" action="">';

    $content .= '<label>Name</label>';
    $content .= '<input type="text" name="your_name" class="form-control" required />';

    $content .= '<label>Email</label>';
    $content .= '<input type="email" name="your_email" class="form-control" required />';

    $content .= '<label>Message</label>';
    $content .= '<textarea name="your_comments" class="form-control" required></textarea>';

    $content .= '<br><input type="submit" name="example_form_submit" value="SEND" />';
    $content .= '</form>';

    return $content;
}
add_shortcode('example_form', 'example_form_pluggin');


/* ---------------------------
   CUSTOM POST TYPE
----------------------------*/
function form_messages_post_type() {

    register_post_type('form_message', [
        'public' => false,
        'show_ui' => true,
        'label' => 'Form Messages',
        'supports' => ['title', 'editor'],
        'menu_icon' => 'dashicons-email-alt'
    ]);
}
add_action('init', 'form_messages_post_type');


/* ---------------------------
   CAPTURE FORM
----------------------------*/
function example_form_capture() {

    if (!isset($_POST['example_form_submit'])) {
        return;
    }

    $name     = sanitize_text_field($_POST['your_name']);
    $email    = sanitize_text_field($_POST['your_email']);
    $comments = sanitize_textarea_field($_POST['your_comments']);

    $post_id = wp_insert_post([
        'post_type'    => 'form_message',
        'post_title'   => $name . ' - ' . $email,
        'post_content' => $comments,
        'post_status'  => 'publish'
    ]);

    if ($post_id) {
        update_post_meta($post_id, 'message_status', 'unread');
    }

    wp_redirect(site_url('/thank-you/'));
    exit;
}
add_action('init', 'example_form_capture');


/* ---------------------------
   STATUS META BOX
----------------------------*/
function form_message_status_box() {

    add_meta_box(
        'form_message_status',
        'Message Status',
        'form_message_status_callback',
        'form_message',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'form_message_status_box');


function form_message_status_callback($post) {

    $status = get_post_meta($post->ID, 'message_status', true);
    if (!$status) $status = 'unread';

    ?>
    <label>Status:</label>
    <select name="message_status" style="width:100%; margin-top:10px;">
        <option value="unread" <?php selected($status, 'unread'); ?>>Unread</option>
        <option value="read" <?php selected($status, 'read'); ?>>Read</option>
        <option value="replied" <?php selected($status, 'replied'); ?>>Replied</option>
    </select>
    <?php
}


/* ---------------------------
   SAVE STATUS
----------------------------*/
add_action('save_post_form_message', function($post_id) {

    if (isset($_POST['message_status'])) {
        update_post_meta(
            $post_id,
            'message_status',
            sanitize_text_field($_POST['message_status'])
        );
    }
});


/* ---------------------------
   ADMIN COLUMNS
----------------------------*/
add_filter('manage_form_message_posts_columns', function($columns) {

    $columns['message_status']  = 'Status';
    $columns['message_actions'] = 'Actions';

    return $columns;
});


add_action('manage_form_message_posts_custom_column', function($column, $post_id) {

    $status = get_post_meta($post_id, 'message_status', true);
    $status = $status ? strtolower($status) : 'unread';

    if ($column === 'message_status') {
        echo ucfirst($status);
    }

    if ($column === 'message_actions') {

        if ($status !== 'read') {
            echo '<a href="' . admin_url("admin-post.php?action=mark_read&post_id=$post_id") . '">Mark as Read</a>';
        } else {
            echo '<a href="' . admin_url("admin-post.php?action=mark_unread&post_id=$post_id") . '">Mark as Unread</a>';
        }
    }

}, 10, 2);

/* ---------------------------
   SIMPLE DELETE CONFIRMATION (SAFE JS)
   (DOES NOT BREAK WORDPRESS)
----------------------------*/
add_action('admin_footer', function() {

    $screen = get_current_screen();

    if (!$screen || $screen->post_type !== 'form_message') {
        return;

        
    }

    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function () {

        document.querySelectorAll('.submitdelete').forEach(function (btn) {

            btn.addEventListener('click', function (e) {

                if (!confirm('Are you sure you want to move this message to Trash?')) {
                    e.preventDefault();
                }

            });

        });

    });
    </script>
    <?php
    
});

add_action('admin_notices', function() {

    $screen = get_current_screen();

    if (!$screen || $screen->post_type !== 'form_message') {
        return;
    }

    echo '<div class="notice notice-info" style="padding:10px;">';
    echo '<h3>How to Use This Plugin</h3>';
    echo '<p><strong>Step 1:</strong> Add shortcode [example_form] to any page</p>';
    echo '<p><strong>Step 2:</strong> Users submit messages through the form</p>';
    echo '<p><strong>Step 3:</strong> Messages appear here in Form Messages</p>';
    echo '<p><strong>Step 4:</strong> Use status dropdown (Unread / Read / Replied)</p>';
    echo '</div>';
});


