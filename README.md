# WordPress Contact Form Plugin

A custom WordPress contact form plugin developed using PHP as part of my Web Development studies at TAFE Queensland.

The plugin allows website visitors to submit contact messages through a form and enables administrators to view and manage those messages directly from the WordPress dashboard.

## Features

- **Contact Form:** Visitors can submit their name, email address and message.
- **WordPress Shortcode:** Uses `[example_form]` to display the contact form on any WordPress page.
- **Custom Post Type:** Stores submitted messages using the `form_message` custom post type.
- **Message Status Tracking:** Supports Unread, Read and Replied statuses.
- **Admin Dashboard:** Provides a dedicated Form Messages section in WordPress.
- **Input Sanitisation:** Uses WordPress sanitisation functions to process submitted form data.
- **Delete Confirmation:** Displays a JavaScript confirmation when moving messages to the trash.
- **Submission Redirect:** Redirects users to a thank-you page after submitting a message.

## Technologies Used

- **PHP** – Used to develop the plugin, handle form submissions, manage message data, and implement custom WordPress functionality.
  
- **WordPress Hooks and Shortcodes API** – Used to integrate custom functionality into WordPress and display the contact form using a shortcode.
  
- **WordPress Custom Post Types API** – Used to register a custom post type for storing and managing contact form submissions through the WordPress dashboard.

## Installation

1. Download the `my-contact-plugin.php` file.
2. Create a folder named `my-contact-plugin` inside the WordPress `wp-content/plugins/` directory.
3. Place the PHP file inside the folder.
4. Open the WordPress admin dashboard.
5. Navigate to **Plugins → Installed Plugins**.
6. Find **Contact Form Plugin** and click **Activate**.

## How to Use

1. Create a new page in WordPress.
2. Add the shortcode `[example_form]` to the page.
3. Publish the page to display the contact form.
4. Visitors can enter their name, email address and message.
5. Submitted messages are stored in the **Form Messages** section of the WordPress dashboard.
6. Administrators can view messages and update their status using the message editor.

**Note:** Create a WordPress page at `/thank-you/` for the submission redirect.

## Project Purpose

This project was developed to practise PHP programming and WordPress plugin development.

It helped me gain experience with:

- Creating custom WordPress functionality.
- Handling HTML form submissions using PHP.
- Using WordPress actions and filters.
- Storing data using custom post types.
- Building administrative interfaces.
- Implementing basic input sanitisation.
- Integrating JavaScript with WordPress.

## Known Limitations

This is an educational portfolio project and has not been security-hardened for production use.

- Form submissions and message status updates require additional nonce and permission checks.
- The custom admin-column Mark as Read / Unread links do not currently have action handlers implemented.
- The plugin does not include spam protection or email notifications.

## Author

Made by Shaurya Parmar
