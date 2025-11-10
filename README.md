# House Shows Direct Child Theme

Child theme for Buddy Boss theme used on [houseshowsdirect.com](https://houseshowsdirect.com).

## Overview

This repository contains the **BuddyBoss Child** theme that's currently active on the live WordPress site. The theme has been connected to GitHub to enable version-controlled development and deployment via WP Pusher.

**Important:** This GitHub repo now matches the existing live child theme structure. All existing functionality has been preserved, and WPCode snippets are being migrated here.

## Current Theme Structure

This child theme follows the standard BuddyBoss child theme structure:
- `functions.php` - Theme setup, enqueues, and custom functions
- `style.css` - Theme header (actual styles go in `/assets/css/custom.css`)
- `assets/css/custom.css` - Custom CSS styles
- `assets/js/custom.js` - Custom JavaScript
- `dokan/seller-warning.php` - Dokan plugin template override (customizes vendor approval message)
- `languages/index.php` - Security file for languages directory

## Existing Functionality

The theme currently includes:
- ✅ Admin bar "Vendors" button (links to Dokan vendors page)
- ✅ Email customization (wp_mail_from and wp_mail_from_name filters) - **Migrated from WPCode**
- ⏳ Gravity Forms registration form snippet - **Needs to be migrated from WPCode**

## Migration Status

### Completed
- ✅ Synced GitHub repo with existing live child theme structure
- ✅ Email customization migrated from WPCode to `functions.php`
- ✅ Dokan seller warning template added

### Pending
- ⏳ Gravity Forms registration form snippet (code needed from WPCode)

## Deployment

This theme is deployed to the live WordPress site using **WP Pusher**.

### Setup Instructions

1. Install WP Pusher plugin on WordPress site
2. Connect GitHub repository: `bclaw7/house-shows-direct-child-theme`
3. Enable Push-to-Deploy for automatic updates

### Workflow

1. Make changes locally in this child theme
2. Commit and push to GitHub: `git add . && git commit -m "Description" && git push`
3. Changes auto-deploy via WP Pusher (if Push-to-Deploy enabled)
4. Or manually update via WP Pusher interface in WordPress admin

## File Structure

- `functions.php` - Theme setup, enqueues, and all custom PHP functions
- `style.css` - Theme header (required by WordPress)
- `assets/css/custom.css` - Custom CSS styles (enqueued automatically)
- `assets/js/custom.js` - Custom JavaScript (enqueued automatically)
- `dokan/seller-warning.php` - Dokan plugin template override
- `languages/index.php` - Security file to prevent directory browsing

## Adding the Gravity Forms Snippet

The Gravity Forms registration form snippet needs to be added to `functions.php`. Once you have the code from WPCode, add it in the designated section marked with TODO comments (around line 80).

## WordPress Coding Standards

This theme follows WordPress Coding Standards. All code should be properly documented and follow WordPress best practices.
