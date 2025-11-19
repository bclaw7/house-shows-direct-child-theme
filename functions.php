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
        // Store redirect flag for vendors to be redirected to store settings
        update_user_meta($user_id, 'hsd_redirect_to_store_settings', true);
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
 * Redirect artists and hosts to their Dokan store settings page after registration
 * 
 * Uses a two-step approach:
 * 1. Store redirect flag in user meta during registration
 * 2. Check and redirect after user is logged in
 */

/**
 * Hook into template redirect to check if user needs redirecting
 * This runs after WordPress is fully loaded and user is logged in
 */
add_action('template_redirect', 'hsd_check_vendor_redirect', 1);

function hsd_check_vendor_redirect() {
    // Only check if user is logged in
    if (!is_user_logged_in()) {
        return;
    }
    
    $user_id = get_current_user_id();
    
    // Check if this user needs to be redirected to store settings
    $needs_redirect = get_user_meta($user_id, 'hsd_redirect_to_store_settings', true);
    
    if ($needs_redirect) {
        // Remove the redirect flag so it doesn't redirect on every page load
        delete_user_meta($user_id, 'hsd_redirect_to_store_settings');
        
        // Don't redirect if already on the store settings page or in admin
        $current_url = home_url($_SERVER['REQUEST_URI']);
        $store_settings_url = 'https://houseshowsdirect.com/dashboard/settings/store/';
        
        if (strpos($current_url, '/dashboard/settings/store') === false && !is_admin()) {
            hsd_log("Redirecting vendor (User ID: {$user_id}) to store settings");
            wp_safe_redirect($store_settings_url);
            exit;
        }
    }
}

/**
 * Also hook into wp_login to redirect immediately after login
 * This handles the case where user logs in manually after registration
 */
add_action('wp_login', 'hsd_check_vendor_redirect_on_login', 10, 2);

function hsd_check_vendor_redirect_on_login($user_login, $user) {
    $user_id = $user->ID;
    $needs_redirect = get_user_meta($user_id, 'hsd_redirect_to_store_settings', true);
    
    if ($needs_redirect) {
        // Store in transient for template_redirect to pick up
        // This ensures redirect happens after full page load
        set_transient('hsd_redirect_user_' . $user_id, true, 60);
    }
}

/**
 * Ensure user is logged in after registration and redirect vendors
 * This runs after form submission is complete
 */
add_action('gform_post_submission_' . HSD_REGISTRATION_FORM_ID, 'hsd_post_submission_vendor_redirect', 10, 2);

function hsd_post_submission_vendor_redirect($entry, $form) {
    // Get user type from entry
    $user_type = strtolower(trim(rgar($entry, HSD_FIELD_USER_ROLE)));
    
    // Only process artists and hosts
    if (!in_array($user_type, array('artist', 'host'))) {
        return;
    }
    
    // Get user ID from entry (created_by field or lookup by email)
    $user_id = rgar($entry, 'created_by');
    
    if (!$user_id) {
        // Try to get user by email
        $email = rgar($entry, '1'); // Email field
        if ($email) {
            $user = get_user_by('email', $email);
            if ($user) {
                $user_id = $user->ID;
            }
        }
    }
    
    if ($user_id) {
        // Log the user in if not already logged in
        if (!is_user_logged_in() || get_current_user_id() != $user_id) {
            wp_set_current_user($user_id);
            wp_set_auth_cookie($user_id);
            hsd_log("Manually logged in vendor (User ID: {$user_id}) after registration");
        }
        
        // Store redirect flag for template_redirect to pick up
        update_user_meta($user_id, 'hsd_redirect_to_store_settings', true);
    }
}

/**
 * Alternative: Use JavaScript redirect in confirmation message
 * This works even if the user isn't logged in yet
 */
add_filter('gform_confirmation_' . HSD_REGISTRATION_FORM_ID, 'hsd_add_js_redirect_for_vendors', 10, 4);

function hsd_add_js_redirect_for_vendors($confirmation, $form, $entry, $ajax) {
    // Check if this is an artist or host
    $user_type = strtolower(trim(rgar($entry, HSD_FIELD_USER_ROLE)));
    
    if (in_array($user_type, array('artist', 'host'))) {
        $store_settings_url = 'https://houseshowsdirect.com/dashboard/settings/store/';
        
        // If confirmation is already a redirect, modify it
        if (is_array($confirmation) && isset($confirmation['redirect'])) {
            $confirmation['redirect'] = $store_settings_url;
            return $confirmation;
        }
        
        // Otherwise, add JavaScript to redirect after a short delay
        // This gives Gravity Forms time to log the user in
        $js_redirect = "
        <script type='text/javascript'>
        (function() {
            function redirectToStore() {
                window.location.href = '{$store_settings_url}';
            }
            
            // Try redirect immediately if page is already loaded
            if (document.readyState === 'complete' || document.readyState === 'interactive') {
                setTimeout(redirectToStore, 2000);
            } else {
                // Wait for DOM to be ready, then redirect
                if (typeof jQuery !== 'undefined') {
                    jQuery(document).ready(function() {
                        setTimeout(redirectToStore, 2000);
                    });
                } else {
                    // Fallback if jQuery not available
                    document.addEventListener('DOMContentLoaded', function() {
                        setTimeout(redirectToStore, 2000);
                    });
                }
            }
        })();
        </script>";
        
        // If confirmation is a string, append the script
        if (is_string($confirmation)) {
            return $confirmation . $js_redirect;
        }
        
        // If it's an array with a message, add script to message
        if (is_array($confirmation) && isset($confirmation['message'])) {
            $confirmation['message'] .= $js_redirect;
            return $confirmation;
        }
        
        // Fallback: return redirect array
        return array(
            'redirect' => $store_settings_url
        );
    }
    
    return $confirmation;
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
