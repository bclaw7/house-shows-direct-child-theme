<?php
/**
 * @package BuddyBoss Child
 * The parent theme functions are located at /buddyboss-theme/inc/theme/functions.php
 * Add your own functions at the bottom of this file.
 */

/****************************** THEME SETUP ******************************/
/**
 * Sets up theme for translation
 *
 * @since BuddyBoss Child 1.0.0
 */
function buddyboss_theme_child_languages()
{
  /**
   * Makes child theme available for translation.
   * Translations can be added into the /languages/ directory.
   */
  // Translate text from the PARENT theme.
  load_theme_textdomain( 'buddyboss-theme', get_stylesheet_directory() . '/languages' );

  // Translate text from the CHILD theme only.
  // Change 'buddyboss-theme' instances in all child theme files to 'buddyboss-theme-child'.
  // load_theme_textdomain( 'buddyboss-theme-child', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'buddyboss_theme_child_languages' );

/**
 * Enqueues scripts and styles for child theme front-end.
 *
 * @since Boss Child Theme  1.0.0
 */
function buddyboss_theme_child_scripts_styles()
{
  /**
   * Scripts and Styles loaded by the parent theme can be unloaded if needed
   * using wp_deregister_script or wp_deregister_style.
   *
   * See the WordPress Codex for more information about those functions:
   * http://codex.wordpress.org/Function_Reference/wp_deregister_script
   * http://codex.wordpress.org/Function_Reference/wp_deregister_style
   **/
  // Styles
  wp_enqueue_style( 'buddyboss-child-css', get_stylesheet_directory_uri().'/assets/css/custom.css' );

  // Javascript
  wp_enqueue_script( 'buddyboss-child-js', get_stylesheet_directory_uri().'/assets/js/custom.js' );
}
add_action( 'wp_enqueue_scripts', 'buddyboss_theme_child_scripts_styles', 9999 );

/****************************** CUSTOM FUNCTIONS ******************************/

/* Add Admin Bar Button */
add_action('admin_bar_menu', 'add_admin_bar_button', 100);
function add_admin_bar_button($admin_bar){
    $admin_bar->add_menu( array(
        'id'    => 'my-button-id',
        'title' => 'Vendors',
        'href'  => 'https://houseshowsdirect.com/wp-admin/admin.php?page=dokan#/vendors',
        'meta'  => array(
            'title' => __('Vendors'),
            'target' => '',
        ),
    ));
}

/**
 * Customize WordPress email From address and name
 * 
 * Migrated from WPCode snippet.
 * Changes the default WordPress email sender to House Shows Direct.
 */
add_filter( 'wp_mail_from', function ( $original_email_address ) {
	return 'bj@houseshowsdirect.com';
} );

add_filter( 'wp_mail_from_name', function ( $original_email_from ) {
	return 'House Shows Direct';
} );

/**
 * Gravity Forms Registration Form Customizations
 * 
 */
/**
 * House Shows Direct - Unified Registration Handler
 * 
 * Integrates Gravity Forms registration with:
 * - Dokan (Artist/Host vendor accounts)
 * - MemberPress (Membership tiers)
 * - BuddyBoss (Profile types and member data)
 * - WooCommerce (Customer accounts)
 * 
 * Instructions for WPCode:
 * 1. Create new snippet as "PHP Snippet"
 * 2. Set to "Run Everywhere"
 * 3. Fill in CONFIGURATION section below with your field IDs
 * 4. Activate snippet
 */

// ============================================================================
// CONFIGURATION - UPDATE THESE VALUES
// ============================================================================

define('HSD_REGISTRATION_FORM_ID', 11);

// Gravity Forms Field IDs (find these in your form editor)
define('HSD_FIELD_USERNAME', '3');               // Username field
define('HSD_FIELD_PASSWORD', '4');               // Password field
define('HSD_FIELD_USER_ROLE', '5');              // Role selection field (Fan/Supporter/Host/Artist)
define('HSD_FIELD_DISPLAY_NAME', '6');           // Display Name (Artist Name/Venue Name/Nickname/Display Name)
define('HSD_FIELD_PHONE', '19');                 // Phone number
define('HSD_FIELD_ADDRESS', '24');               // Address field (contains city, state, country as sub-fields)
define('HSD_FIELD_GENRE_PERFORMANCE', '20');     // Artist genre / performance type (combined field)
define('HSD_FIELD_VENUE_CAPACITY', '23');        // Host venue capacity
define('HSD_FIELD_VENUE_TYPE', '22');            // Host venue type
define('HSD_FIELD_DISPLAY_NAME_SUPPORTER', '29'); // Supporter name field (conditional)
define('HSD_FIELD_DISPLAY_NAME_HOST', '28');      // Host/Venue name field (conditional)
define('HSD_FIELD_DISPLAY_NAME_FAN', '30');       // Fan name field (conditional)

// Membership Product Fields (conditional - one per role)
define('HSD_FIELD_FAN_MEMBERSHIP', '9');         // Fan membership product field
define('HSD_FIELD_ARTIST_MEMBERSHIP', '27');       // Artist membership product field (add field ID)
define('HSD_FIELD_SUPPORTER_MEMBERSHIP', '25');    // Supporter membership product field (add field ID)
define('HSD_FIELD_HOST_MEMBERSHIP', '26');         // Host membership product field (add field ID)

// Payment Method Field
define('HSD_FIELD_PAYMENT_METHOD', '11');         // Payment Method radio buttons field

// MemberPress Membership IDs (find in MemberPress > Memberships)
// Look at the URL when editing: ?page=memberpress-memberships&action=edit&id=XXX
// Map membership level names (as they appear in dropdown) to MemberPress IDs
$HSD_MEMBERSHIP_IDS = array(
    // Fan Memberships
    'fan_free'     => 67,   // Fan
    'fan_bronze'   => 336,  // Fan Club Bronze
    'fan_silver'   => 461,  // Fan Club Silver
    'fan_gold'     => 462,  // Fan Club Gold
    'fan_platinum' => 463,  // Fan Club Platinum
    
    // Artist Memberships
    'artist_free'     => 68,   // Artist
    'artist_bronze'   => 482,  // Artist Bronze
    'artist_silver'   => 483,  // Artist Silver
    'artist_gold'     => 484,  // Artist Gold
    'artist_platinum' => 485,  // Artist Platinum
    
    // Supporter Memberships
    'supporter_free'     => 70,   // Supporter
    'supporter_bronze'   => 337,  // Supporter Bronze
    'supporter_silver'   => 472,  // Supporter Silver
    'supporter_gold'     => 475,  // Supporter Gold
    'supporter_platinum' => 476,  // Supporter Platinum
    
    // Host Memberships
    'host_free'     => 69,   // Host
    'host_bronze'   => 478,  // Host Bronze
    'host_silver'   => 479,  // Host Silver
    'host_gold'     => 480,  // Host Gold
    'host_platinum' => 481,  // Host Platinum
);

// BuddyBoss Member Type Slugs (create these in BuddyBoss > Settings > Profiles > Profile Types)
$HSD_BUDDYBOSS_TYPES = array(
    'fan'       => 'fan',
    'supporter' => 'supporter',
    'artist'    => 'artist',
    'host'      => 'host',
);

// ============================================================================
// MAIN REGISTRATION HANDLER
// ============================================================================

add_filter( 'gform_pre_submission_' . HSD_REGISTRATION_FORM_ID, 'hsd_merge_role_specific_display_names' );

function hsd_merge_role_specific_display_names( $form ) {
	$conditional_fields = array(
		HSD_FIELD_DISPLAY_NAME        => rgpost( 'input_' . HSD_FIELD_DISPLAY_NAME ),
		HSD_FIELD_DISPLAY_NAME_SUPPORTER => rgpost( 'input_' . HSD_FIELD_DISPLAY_NAME_SUPPORTER ),
		HSD_FIELD_DISPLAY_NAME_HOST      => rgpost( 'input_' . HSD_FIELD_DISPLAY_NAME_HOST ),
		HSD_FIELD_DISPLAY_NAME_FAN       => rgpost( 'input_' . HSD_FIELD_DISPLAY_NAME_FAN ),
	);

	foreach ( $conditional_fields as $value ) {
		if ( ! empty( $value ) ) {
			$_POST[ 'input_' . HSD_FIELD_DISPLAY_NAME ] = $value;
			break;
		}
	}

	return $form;
}

add_action('gform_user_registered', 'hsd_unified_user_setup', 10, 4);

function hsd_unified_user_setup($user_id, $feed, $entry, $password) {
    global $HSD_MEMBERSHIP_IDS, $HSD_BUDDYBOSS_TYPES;
    
    // Only run on HSD Registration form
    if ($entry['form_id'] != HSD_REGISTRATION_FORM_ID) {
        return;
    }
    
    // Get the user role selection
    $user_type = strtolower(trim(rgar($entry, HSD_FIELD_USER_ROLE)));
    
    // Log the registration attempt
    hsd_log("Starting registration for User ID: {$user_id}, Type: {$user_type}");
    
    // Validate user type
    if (!in_array($user_type, array('fan', 'supporter', 'artist', 'host'))) {
        hsd_log("ERROR: Invalid user type '{$user_type}' for User ID: {$user_id}");
        return;
    }
    
    // Store user type as meta
    update_user_meta($user_id, 'hsd_user_type', $user_type);
    
    // Create Dokan vendor for Artists and Hosts
    if (in_array($user_type, array('artist', 'host'))) {
        hsd_create_dokan_vendor($user_id, $user_type, $entry);
    }
    
    // Assign MemberPress membership
    hsd_assign_membership($user_id, $user_type, $entry, $HSD_MEMBERSHIP_IDS);
    
    // Set BuddyBoss profile type
    if (function_exists('bp_set_member_type') && isset($HSD_BUDDYBOSS_TYPES[$user_type])) {
        hsd_set_buddyboss_profile($user_id, $user_type, $HSD_BUDDYBOSS_TYPES);
    }
    
    // Store role-specific metadata
    hsd_store_user_metadata($user_id, $user_type, $entry);
    
    // Ensure WooCommerce customer data is set (only for non-vendor users)
    if (class_exists('WC_Customer') && !in_array($user_type, array('artist', 'host'))) {
        hsd_setup_woocommerce_customer($user_id, $entry, false);
    }
    
    // Store password temporarily for auto-login (will be used by login page script)
    // Get user object first
    $user = get_userdata($user_id);
    if (!$user) {
        hsd_log("ERROR: Could not get user data for User ID: {$user_id}");
        return;
    }
    
    // Get username from form field (ID 3) first, fallback to WordPress username
    $form_username = rgar($entry, HSD_FIELD_USERNAME);
    $login_username = !empty($form_username) ? $form_username : $user->user_login;
    
    // Get password from form field (ID 4) first, fallback to hook parameter
    $form_password = rgar($entry, HSD_FIELD_PASSWORD);
    $user_password = !empty($form_password) ? $form_password : $password;
    
    // Only store if we have a password (for artists and hosts who need redirect)
    if (!empty($user_password) && in_array($user_type, array('artist', 'host'))) {
        $login_token = wp_generate_password(32, false);
        set_transient('hsd_auto_login_' . $login_token, array(
            'user_id' => $user_id,
            'username' => $login_username, // Use username from form field
            'email' => $user->user_email,
            'password' => $user_password // Store temporarily for auto-login
        ), 300); // 5 minutes, auto-deletes
        
        // Store token in entry meta for redirect function to retrieve (safely)
        if (function_exists('gform_update_meta') && isset($entry['id'])) {
            gform_update_meta($entry['id'], 'hsd_auto_login_token', $login_token);
        }
        hsd_log("Auto-login token created for User ID: {$user_id} (username: {$login_username}, password from " . (!empty($form_password) ? 'form field' : 'hook parameter') . ")");
    }
    
    hsd_log("Registration complete for User ID: {$user_id}");
}

// ============================================================================
// DOKAN VENDOR CREATION
// ============================================================================

function hsd_create_dokan_vendor($user_id, $user_type, $entry) {
    hsd_log("Creating Dokan vendor for User ID: {$user_id}");
    
    // Check if Dokan is active
    if (!function_exists('dokan')) {
        hsd_log("ERROR: Dokan is not active");
        return;
    }
    
    // Enable selling capability
    update_user_meta($user_id, 'dokan_enable_selling', 'yes');
    update_user_meta($user_id, 'dokan_publishing', 'yes');
    
    // Get display name from form (used as store/venue name)
    $display_name = HSD_FIELD_DISPLAY_NAME ? rgar($entry, HSD_FIELD_DISPLAY_NAME) : '';
    if (empty($display_name)) {
        $user = get_userdata($user_id);
        $display_name = $user->display_name;
    }
    
    // Also update WordPress display_name
    wp_update_user(array(
        'ID' => $user_id,
        'display_name' => sanitize_text_field($display_name)
    ));
    
    // Build vendor profile data
    $store_data = array(
        'store_name' => sanitize_text_field($display_name),
        'social'     => array(),
        'payment'    => array(),
        'phone'      => HSD_FIELD_PHONE ? sanitize_text_field(rgar($entry, HSD_FIELD_PHONE)) : '',
        'show_email' => 'no',
        'address'    => array(
            'street_1' => '', // Will be added later in Dokan or event creation
            'city'     => HSD_FIELD_ADDRESS ? sanitize_text_field(rgar($entry, HSD_FIELD_ADDRESS . '.5')) : '',
            'state'    => HSD_FIELD_ADDRESS ? sanitize_text_field(rgar($entry, HSD_FIELD_ADDRESS . '.6')) : '',
            'zip'      => '',
            'country'  => HSD_FIELD_ADDRESS ? sanitize_text_field(rgar($entry, HSD_FIELD_ADDRESS . '.8')) : 'US',
        ),
    );
    
    // Save vendor profile settings
    update_user_meta($user_id, 'dokan_profile_settings', $store_data);
    update_user_meta($user_id, 'dokan_store_name', sanitize_text_field($display_name));
    
    // Add seller role
    $user = new WP_User($user_id);
    $user->add_role('seller');
    
    // If customer role exists, keep it for purchasing capability
    if (!in_array('customer', $user->roles)) {
        $user->add_role('customer');
    }
    
    // Set WooCommerce billing address for Artists/Hosts
    hsd_setup_woocommerce_customer($user_id, $entry, true);
    
    hsd_log("Dokan vendor created successfully for User ID: {$user_id}");
}

// ============================================================================
// MEMBERPRESS MEMBERSHIP ASSIGNMENT
// ============================================================================

function hsd_assign_membership($user_id, $user_type, $entry, $membership_ids) {
    hsd_log("Assigning MemberPress membership for User ID: {$user_id}, Type: {$user_type}");
    
    // Check if MemberPress is active
    if (!class_exists('MeprTransaction')) {
        hsd_log("ERROR: MemberPress is not active");
        return;
    }
    
    // Get membership level from form
    $membership_level = '';
    if (HSD_FIELD_MEMBERSHIP_LEVEL) {
        $membership_level = strtolower(trim(rgar($entry, HSD_FIELD_MEMBERSHIP_LEVEL)));
        hsd_log("Membership level selected: {$membership_level}");
    }
    
    // Validate membership level
    if (empty($membership_level)) {
        hsd_log("ERROR: No membership level selected");
        return;
    }
    
    // Build the membership key (e.g., fan_bronze, artist_gold, supporter_silver, host_platinum)
    $membership_key = $user_type . '_' . $membership_level;
    
    hsd_log("Looking up membership key: {$membership_key}");
    
    // Get the MemberPress membership ID
    if (!isset($membership_ids[$membership_key])) {
        hsd_log("ERROR: No membership ID configured for key: {$membership_key}");
        return;
    }
    
    $membership_id = $membership_ids[$membership_key];
    
    if ($membership_id <= 0) {
        hsd_log("ERROR: Invalid membership ID ({$membership_id}) for key: {$membership_key}");
        return;
    }
    
    // Determine if this is a paid membership (everything except 'free')
    $is_paid = ($membership_level !== 'free');
    
    // Get payment info from Gravity Forms (Stripe/PayPal add-on data)
    $payment_gateway = '';
    $transaction_id = '';
    
    if ($is_paid) {
        // Check for Stripe payment
        if (!empty($entry['payment_method']) && $entry['payment_method'] === 'Stripe') {
            $payment_gateway = 'stripe';
            $transaction_id = !empty($entry['transaction_id']) ? $entry['transaction_id'] : '';
        }
        // Check for PayPal payment
        elseif (!empty($entry['payment_method']) && strpos(strtolower($entry['payment_method']), 'paypal') !== false) {
            $payment_gateway = 'paypal';
            $transaction_id = !empty($entry['transaction_id']) ? $entry['transaction_id'] : '';
        }
        
        // If no payment gateway detected but it's a paid membership, log warning
        if (empty($payment_gateway)) {
            hsd_log("WARNING: Paid membership selected but no payment gateway detected. Entry payment status: " . (isset($entry['payment_status']) ? $entry['payment_status'] : 'unknown'));
        }
    }
    
    // Create MemberPress transaction
    $txn = new MeprTransaction();
    $txn->user_id = $user_id;
    $txn->product_id = $membership_id;
    $txn->trans_num = !empty($transaction_id) ? $transaction_id : 'hsd-reg-' . uniqid();
    $txn->gateway = $is_paid && !empty($payment_gateway) ? $payment_gateway : 'free';
    $txn->created_at = current_time('mysql');
    
    // Set transaction status based on payment
    if ($is_paid) {
        // Check Gravity Forms payment status
        $payment_status = isset($entry['payment_status']) ? strtolower($entry['payment_status']) : '';
        
        if ($payment_status === 'paid' || $payment_status === 'approved') {
            $txn->status = MeprTransaction::$complete_str;
            $txn->txn_type = MeprTransaction::$payment_str;
        } else {
            // Payment pending or failed - mark as pending
            $txn->status = MeprTransaction::$pending_str;
            $txn->txn_type = MeprTransaction::$payment_str;
            hsd_log("WARNING: Payment status is '{$payment_status}' - setting transaction to pending");
        }
    } else {
        // Free membership - mark as complete immediately
        $txn->status = MeprTransaction::$complete_str;
        $txn->txn_type = MeprTransaction::$payment_str;
    }
    
    // Store the transaction
    $txn->store();
    
    hsd_log("MemberPress membership {$membership_id} (key: {$membership_key}, gateway: {$txn->gateway}, status: {$txn->status}) assigned to User ID: {$user_id}");
}

// ============================================================================
// BUDDYBOSS PROFILE TYPE
// ============================================================================

function hsd_set_buddyboss_profile($user_id, $user_type, $buddyboss_types) {
    hsd_log("Setting BuddyBoss profile for User ID: {$user_id}");
    
    // Check if BuddyBoss/BuddyPress is active
    if (!function_exists('bp_set_member_type')) {
        hsd_log("ERROR: BuddyBoss/BuddyPress is not active");
        return;
    }
    
    $member_type_slug = $buddyboss_types[$user_type];
    
    // Set the member type
    $result = bp_set_member_type($user_id, $member_type_slug);
    
    if (is_wp_error($result)) {
        hsd_log("ERROR: Failed to set BuddyBoss member type: " . $result->get_error_message());
    } else {
        hsd_log("BuddyBoss member type '{$member_type_slug}' set for User ID: {$user_id}");
    }
    
    // Optional: Set xProfile fields if needed
    // if (function_exists('xprofile_set_field_data')) {
    //     xprofile_set_field_data('Field Name', $user_id, 'value');
    // }
}

// ============================================================================
// STORE ROLE-SPECIFIC METADATA
// ============================================================================

function hsd_store_user_metadata($user_id, $user_type, $entry) {
    hsd_log("Storing metadata for User ID: {$user_id}");
    
    // Update WordPress display_name for all user types
    if (HSD_FIELD_DISPLAY_NAME) {
        $display_name = sanitize_text_field(rgar($entry, HSD_FIELD_DISPLAY_NAME));
        if (!empty($display_name)) {
            wp_update_user(array(
                'ID' => $user_id,
                'display_name' => $display_name
            ));
        }
    }
    
    // Store role-specific data based on user type
    if ($user_type === 'artist') {
        if (HSD_FIELD_GENRE_PERFORMANCE) {
            $genre_performance = sanitize_text_field(rgar($entry, HSD_FIELD_GENRE_PERFORMANCE));
            update_user_meta($user_id, 'hsd_genre_performance', $genre_performance);
            // Also store separately for backward compatibility or search filtering
            update_user_meta($user_id, 'hsd_genre', $genre_performance);
        }
    } elseif ($user_type === 'host') {
        if (HSD_FIELD_VENUE_CAPACITY) {
            update_user_meta($user_id, 'hsd_venue_capacity', absint(rgar($entry, HSD_FIELD_VENUE_CAPACITY)));
        }
        if (HSD_FIELD_VENUE_TYPE) {
            update_user_meta($user_id, 'hsd_venue_type', sanitize_text_field(rgar($entry, HSD_FIELD_VENUE_TYPE)));
        }
    }
    
    // Store common contact information
    if (HSD_FIELD_PHONE) {
        update_user_meta($user_id, 'billing_phone', sanitize_text_field(rgar($entry, HSD_FIELD_PHONE)));
    }
}

// ============================================================================
// WOOCOMMERCE CUSTOMER SETUP
// ============================================================================

function hsd_setup_woocommerce_customer($user_id, $entry, $include_address = false) {
    hsd_log("Setting up WooCommerce customer for User ID: {$user_id}");
    
    // Ensure customer role
    $user = new WP_User($user_id);
    if (!in_array('customer', $user->roles)) {
        $user->add_role('customer');
    }
    
    // Only set billing address for Artists/Hosts (vendors)
    if ($include_address && HSD_FIELD_ADDRESS) {
        $city = sanitize_text_field(rgar($entry, HSD_FIELD_ADDRESS . '.5'));
        $state = sanitize_text_field(rgar($entry, HSD_FIELD_ADDRESS . '.6'));
        $country = sanitize_text_field(rgar($entry, HSD_FIELD_ADDRESS . '.8'));
        
        if (!empty($city)) {
            update_user_meta($user_id, 'billing_city', $city);
        }
        if (!empty($state)) {
            update_user_meta($user_id, 'billing_state', $state);
        }
        if (!empty($country)) {
            update_user_meta($user_id, 'billing_country', $country);
        } else {
            update_user_meta($user_id, 'billing_country', 'US');
        }
        
        hsd_log("WooCommerce billing address set for vendor User ID: {$user_id}");
    }
}

// ============================================================================
// PAYMENT METHOD FIELD VALIDATION
// ============================================================================

/**
 * Skip required validation for Payment Method field when all memberships are free
 * 
 * This fixes the issue where free memberships hide the payment field via conditional logic,
 * but Gravity Forms still tries to validate it as required.
 */
add_filter('gform_field_validation_' . HSD_REGISTRATION_FORM_ID . '_' . HSD_FIELD_PAYMENT_METHOD, 'hsd_validate_payment_method_conditional', 10, 4);

function hsd_validate_payment_method_conditional($result, $value, $form, $field) {
    // First, check if the payment method field itself is hidden by conditional logic
    // If it's hidden, it shouldn't be validated as required
    if (class_exists('GFCommon') && method_exists('GFCommon', 'is_field_hidden')) {
        $entry = array();
        foreach ($form['fields'] as $form_field) {
            $entry[$form_field->id] = rgpost('input_' . $form_field->id);
        }
        
        if (GFCommon::is_field_hidden($form, $field, $entry)) {
            $result['is_valid'] = true;
            $result['message'] = '';
            hsd_log("Payment Method validation skipped - field is hidden by conditional logic");
            return $result;
        }
    }
    
    // Get the user role selection (field ID 5)
    $user_role = strtolower(trim(rgpost('input_' . HSD_FIELD_USER_ROLE)));
    
    if (empty($user_role)) {
        // No role selected yet, let default validation handle it
        return $result;
    }
    
    // Map role to corresponding membership field ID
    $role_to_membership_field = array(
        'fan'       => HSD_FIELD_FAN_MEMBERSHIP,
        'supporter' => HSD_FIELD_SUPPORTER_MEMBERSHIP,
        'host'      => HSD_FIELD_HOST_MEMBERSHIP,
        'artist'    => HSD_FIELD_ARTIST_MEMBERSHIP,
    );
    
    // Get the membership field ID for the selected role
    if (!isset($role_to_membership_field[$user_role])) {
        hsd_log("Unknown user role: {$user_role}");
        return $result;
    }
    
    $membership_field_id = $role_to_membership_field[$user_role];
    
    // Get the membership level value for this role
    $membership_value = trim(rgpost('input_' . $membership_field_id));
    
    if (empty($membership_value)) {
        // No membership value yet, let default validation handle it
        return $result;
    }
    
    // Normalize the value for comparison (lowercase, trim)
    $membership_value_normalized = strtolower($membership_value);
    
    // Define the exact free membership values for each role
    $free_membership_values = array(
        'fan'       => array('free-fan-membership', 'free fan membership'),
        'supporter' => array('free-supporter-membership', 'free supporter membership'),
        'host'      => array('free-host-membership', 'free host membership'),
        'artist'    => array('free-artist-membership', 'free artist membership'),
    );
    
    // Check if the membership value matches any of the free options for this role
    $is_free = false;
    if (isset($free_membership_values[$user_role])) {
        foreach ($free_membership_values[$user_role] as $free_value) {
            if ($membership_value_normalized === strtolower($free_value)) {
                $is_free = true;
                break;
            }
        }
    }
    
    // Also check if value contains "free" as a fallback (case-insensitive)
    if (!$is_free && stripos($membership_value, 'free') !== false) {
        $is_free = true;
    }
    
    // If membership is free, skip payment validation
    if ($is_free) {
        $result['is_valid'] = true;
        $result['message'] = '';
        hsd_log("Payment Method validation skipped - {$user_role} membership is free (value: {$membership_value})");
    }
    
    return $result;
}

// ============================================================================
// REDIRECT VENDORS (ARTISTS & HOSTS) TO DOKAN STORE SETTINGS
// ============================================================================

/**
 * AJAX endpoint to check if user is logged in
 * Used by JavaScript to verify login status before redirecting
 */
add_action('wp_ajax_hsd_check_login', 'hsd_ajax_check_login');
add_action('wp_ajax_nopriv_hsd_check_login', 'hsd_ajax_check_login');

function hsd_ajax_check_login() {
    if (is_user_logged_in()) {
        wp_send_json_success(array('logged_in' => true, 'user_id' => get_current_user_id()));
    } else {
        wp_send_json_error(array('logged_in' => false));
    }
}

/**
 * Ensure user is logged in after form submission
 * This hook runs after the form is submitted and entry is saved
 */
add_action('gform_post_submission_' . HSD_REGISTRATION_FORM_ID, 'hsd_ensure_user_login_after_registration', 10, 2);

/**
 * Add auto-login script to login page when hsd_auto_login parameter is present
 * This will auto-fill the form, solve the math captcha, and submit
 * 
 * TEMPORARILY DISABLED - Re-enable after testing
 */
// add_action('wp_footer', 'hsd_add_auto_login_script_to_login_page', 999);

function hsd_add_auto_login_script_to_login_page() {
    // Exit immediately if auto-login parameter is not present (most common case)
    if (!isset($_GET['hsd_auto_login']) || empty($_GET['hsd_auto_login'])) {
        return;
    }
    
    // Wrap in try-catch to prevent fatal errors
    try {
        
        // Only run on login page (check URL or page slug)
        $current_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
        $is_login_page = false;
        
        // Check if URL contains /login
        if (!empty($current_url) && strpos($current_url, '/login') !== false) {
            $is_login_page = true;
        }
        
        // Check if it's the login page via WordPress function
        if (!$is_login_page && function_exists('is_page') && is_page('login')) {
            $is_login_page = true;
        }
        
        // Check if it's BuddyPress register page
        if (!$is_login_page && function_exists('bp_is_register_page') && bp_is_register_page()) {
            $is_login_page = true;
        }
        
        // Only proceed if we're on a login page
        if (!$is_login_page) {
            return;
        }
        
        // Don't run if user is already logged in
        if (is_user_logged_in()) {
            return;
        }
        
        // Sanitize token
        $token = isset($_GET['hsd_auto_login']) ? sanitize_text_field($_GET['hsd_auto_login']) : '';
        if (empty($token)) {
            return;
        }
        
        $redirect_to = isset($_GET['redirect_to']) ? esc_url_raw($_GET['redirect_to']) : '';
        $store_settings_url = 'https://houseshowsdirect.com/dashboard/settings/store/';
        
        // Get login credentials from transient
        $login_data = get_transient('hsd_auto_login_' . $token);
        
        // Exit if no valid login data
        if (!$login_data || !is_array($login_data) || !isset($login_data['username']) || !isset($login_data['password'])) {
            return; // Token expired or invalid
        }
        
        // Validate we have required data
        if (empty($login_data['username']) || empty($login_data['password'])) {
            return;
        }
        
        $username = esc_js($login_data['username']);
        $password = esc_js($login_data['password']);
        $math_answer = '17'; // 12 + 5 = 17
        
        // Delete the transient immediately for security
        delete_transient('hsd_auto_login_' . $token);
        
        // JavaScript to auto-fill and submit login form
        ?>
        <script type="text/javascript">
    (function() {
        function autoLogin() {
            // Find username/email field (could be 'log' or 'user_login' or email input)
            var usernameField = document.querySelector('input[name="log"]') || 
                               document.querySelector('input[name="user_login"]') ||
                               document.querySelector('input[type="email"]') ||
                               document.querySelector('input[name="username"]');
            
            // Find password field
            var passwordField = document.querySelector('input[name="pwd"]') || 
                               document.querySelector('input[name="user_pass"]') ||
                               document.querySelector('input[type="password"]');
            
            // Find math captcha field (MemberPress math captcha)
            // The span ID is mepr_math_captcha-691d39257ddc1, input should be nearby
            var captchaField = document.querySelector('input[name="mepr_math_captcha"]') ||
                              document.querySelector('input[id*="mepr_math_captcha"]') ||
                              document.querySelector('input[type="text"][placeholder*="answer"]');
            
            // Try to find via span if not found yet
            if (!captchaField) {
                var captchaSpan = document.querySelector('span[id*="mepr_math_captcha"]');
                if (captchaSpan) {
                    captchaField = captchaSpan.parentElement ? captchaSpan.parentElement.querySelector('input[type="text"]') : null;
                    if (!captchaField) {
                        captchaField = document.querySelector('span[id*="mepr_math_captcha"] + input');
                    }
                }
            }
            
            // Find login form
            var loginForm = document.querySelector('form#loginform') ||
                           document.querySelector('form[name="loginform"]') ||
                           document.querySelector('form[action*="login"]');
            
            if (usernameField && passwordField && loginForm) {
                // Fill in username
                usernameField.value = '<?php echo $username; ?>';
                usernameField.dispatchEvent(new Event('input', { bubbles: true }));
                usernameField.dispatchEvent(new Event('change', { bubbles: true }));
                
                // Fill in password
                passwordField.value = '<?php echo $password; ?>';
                passwordField.dispatchEvent(new Event('input', { bubbles: true }));
                passwordField.dispatchEvent(new Event('change', { bubbles: true }));
                
                // Fill in math captcha answer (12 + 5 = 17)
                if (captchaField) {
                    captchaField.value = '<?php echo $math_answer; ?>';
                    captchaField.dispatchEvent(new Event('input', { bubbles: true }));
                    captchaField.dispatchEvent(new Event('change', { bubbles: true }));
                }
                
                // Check "Remember Me" if present
                var rememberMe = document.querySelector('input[name="rememberme"]');
                if (rememberMe) {
                    rememberMe.checked = true;
                }
                
                // Set redirect_to in form if not already set
                var redirectInput = document.querySelector('input[name="redirect_to"]');
                var redirectTo = '<?php echo esc_js($redirect_to ? $redirect_to : $store_settings_url); ?>';
                if (redirectInput) {
                    redirectInput.value = redirectTo;
                } else {
                    // Create hidden input for redirect
                    var hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'redirect_to';
                    hiddenInput.value = redirectTo;
                    loginForm.appendChild(hiddenInput);
                }
                
                // Wait a moment for fields to be recognized, then submit
                setTimeout(function() {
                    loginForm.submit();
                }, 500);
            } else {
                // Retry if form not found yet
                setTimeout(autoLogin, 500);
            }
        }
        
        // Start auto-login after page loads
        if (document.readyState === 'complete') {
            setTimeout(autoLogin, 1000);
        } else {
            window.addEventListener('load', function() {
                setTimeout(autoLogin, 1000);
            });
        }
    })();
    </script>
    <?php
    } catch (Exception $e) {
        // Log error but don't break the site
        if (function_exists('hsd_log')) {
            hsd_log("Error in auto-login script: " . $e->getMessage());
        }
        // Silently fail - don't output anything
        return;
    }
}

/**
 * Redirect artists and hosts to their Dokan store settings page after registration
 * 
 * Industry Standard: Auto-login after registration
 * This adds a JavaScript redirect in the confirmation message for vendors.
 * 
 * Safe approach: Only modifies confirmation output, doesn't hook into critical WordPress functions
 */
add_filter('gform_confirmation_' . HSD_REGISTRATION_FORM_ID, 'hsd_redirect_vendors_to_store_settings', 10, 4);

function hsd_redirect_vendors_to_store_settings($confirmation, $form, $entry, $ajax) {
    // Validate entry data
    if (!is_array($entry) || !isset($entry['id'])) {
        return $confirmation; // Return unchanged if entry is invalid
    }
    
    // Only redirect artists and hosts (both get Dokan vendor accounts)
    $user_type = strtolower(trim(rgar($entry, HSD_FIELD_USER_ROLE)));
    
    if (!in_array($user_type, array('artist', 'host'))) {
        return $confirmation; // Return unchanged for fans and supporters
    }
    
    $store_settings_url = 'https://houseshowsdirect.com/dashboard/settings/store/';
    
    // If confirmation is already a redirect array, modify it
    if (is_array($confirmation) && isset($confirmation['redirect'])) {
        $confirmation['redirect'] = $store_settings_url;
        return $confirmation;
    }
    
    // Get auto-login token from entry meta (safely)
    $login_token = '';
    if (isset($entry['id']) && function_exists('gform_get_meta')) {
        $login_token = gform_get_meta($entry['id'], 'hsd_auto_login_token');
    }
    
    $email = rgar($entry, '1'); // Email field
    
    // If no token, just redirect to store settings (user will need to log in manually)
    if (empty($login_token)) {
        // Fallback: simple redirect without auto-login
        $js_redirect = '<script type="text/javascript">
            setTimeout(function() {
                window.location.href = "' . esc_js($store_settings_url) . '";
            }, 2000);
        </script>';
    } else {
        // Redirect to login page with auto-login script
        // This will auto-fill the form, solve the captcha, and submit
        $login_url = 'https://houseshowsdirect.com/login/';
        
        // JavaScript to auto-login through MemberPress login form
        $js_redirect = '<script type="text/javascript">
            (function() {
                var loginUrl = "' . esc_js($login_url) . '";
                var redirectUrl = "' . esc_js($store_settings_url) . '";
                var token = "' . esc_js($login_token) . '";
                
                // Redirect to login page first
                window.location.href = loginUrl + (loginUrl.indexOf("?") > -1 ? "&" : "?") + "hsd_auto_login=" + token + "&redirect_to=" + encodeURIComponent(redirectUrl);
            })();
        </script>';
    }
    
    // Also add a script that will run on the login page to auto-submit
    // This will be handled by a separate function that hooks into the login page
    
    // Handle different confirmation formats
    if (is_string($confirmation)) {
        // String confirmation - append JavaScript
        return $confirmation . $js_redirect;
    } elseif (is_array($confirmation)) {
        // Array confirmation - add to message if exists, otherwise create redirect
        if (isset($confirmation['message'])) {
            $confirmation['message'] .= $js_redirect;
        } else {
            $confirmation['redirect'] = $store_settings_url;
        }
        return $confirmation;
    }
    
    // Fallback: return redirect array
    return array('redirect' => $store_settings_url);
}

// ============================================================================
// LOGGING FUNCTION
// ============================================================================

function hsd_log($message) {
    // Only log if WP_DEBUG is enabled
    if (defined('WP_DEBUG') && WP_DEBUG === true) {
        error_log('[HSD Registration] ' . $message);
    }
}

// ============================================================================
// HELPER: Display Field IDs in Form (FOR TESTING ONLY - REMOVE AFTER MAPPING)
// ============================================================================

// Uncomment this to see field IDs when viewing your form on the frontend
// add_filter('gform_pre_render_11', 'hsd_display_field_ids');

function hsd_display_field_ids($form) {
    if (is_admin()) return $form;
    
    echo '<div style="background: #f0f0f0; padding: 15px; margin: 20px 0; border: 2px solid #333;">';
    echo '<h3>Field IDs for Form #' . $form['id'] . '</h3>';
    echo '<p style="color: red;"><strong>Remove this after mapping field IDs!</strong></p>';
    echo '<ul>';
    foreach ($form['fields'] as $field) {
        echo '<li><strong>ID ' . $field->id . ':</strong> ' . $field->label . ' (' . $field->type . ')</li>';
    }
    echo '</ul>';
    echo '</div>';
    
    return $form;
}

/**
 * Custom CSS for Eventin plugin sidebar
 * 
 * Note: Currently commented out. Uncomment if needed.
 * 
add_action('admin_head', 'my_custom_css_do');
function my_custom_css_do() {
echo '<style>
aside.eventin-event-details-sidebar .css-0:nth-child(1) .eventin-sidebar-list li:nth-child(2) {
    display: none;
}
aside.eventin-event-details-sidebar .css-0:nth-child(1) .eventin-sidebar-list li:nth-child(3) {
    display: none;
}
aside.eventin-event-details-sidebar .css-0:nth-child(1) .eventin-sidebar-list li:nth-child(5) {
    display: none;
}
aside.eventin-event-details-sidebar .css-0:nth-child(2) .eventin-sidebar-list li:nth-child(4) {
    display: none;
}
aside.eventin-event-details-sidebar .css-0:nth-child(3) .eventin-sidebar-list li:nth-child(1) {
    display: none;
}
aside.eventin-event-details-sidebar .css-0:nth-child(3) .eventin-sidebar-list li:nth-child(2) {
    display: none;
}
</style>';
}
**/
