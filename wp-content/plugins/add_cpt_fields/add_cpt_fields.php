<?php

/**
 * Plugin Name: Add CPT FIelds
 * Description: My first WordPress plugin - Add CPT FIelds
 * Version: 1.0.0
 * Author: Afaq Ahmad
 */



// Security
if (!defined('ABSPATH')) {
    exit;
}


// 1. ADD MENU PAGE - IMPROVED
function acf_menuPage() {
    add_menu_page(
        'CPT Fields Settings',       // Page title
        'CPT Fields',               // Menu title
        'manage_options',           // Capability
        'add-cpt-fields',           // Menu slug
        'acf_settings_page_content', // Callback - renamed for clarity
        'dashicons-admin-generic',  // Icon (optional but nice)
        30                          // Position (below Comments)
    );
}
add_action('admin_menu', 'acf_menuPage');


function acf_settings_page_content() {
    if(!current_user_can('manage_options')) {
        wp_die('You do not have sufficient permissions to access this page.');
    }

    $saved_cpt  = get_option('acf_selected_cpt' , '');

       // Display admin notice if option was saved
    if (isset($_GET['settings-updated'])) {
        echo '<div class="notice notice-success is-dismissible"><p>Settings saved successfully!</p></div>';
    }

?>

   <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form method="post" action="options.php">

            <?php settings_fields('acf_settings_group'); ?>

              <table class="form-table">

                <tr>
                    <th scope="row">
                        <label for="acf_selected_cpt">Select Post Type</label>
                    </th>
                    <td>
                        <select name="acf_selected_cpt" id="acf_selected_cpt">

                            <option value = ""> Select Post Type </option>

                            <?php $post_types = get_post_types(

                                array (
                                    'public' => true,
                                ), 'objects'
                            );
                            
                            foreach ($post_types as $post_type) {
                                if(in_array($post_type->name , array('attachment' , 'revision', 'nav_menu_item'))) {
                                    continue;
                                }
                                $selected = ($saved_cpt == $post_type->name) ? 'selected="selected"' : '';
                                
                                echo '<option value ="' . esc_attr($post_type->name) . '"' . $selected . '>';

                                echo esc_html($post_type->label);

                                echo ' (' . esc_html($post_type->name) . ')';

                                echo '</option>';

                            }
                            
                            ?>
                        </select>
                        <p class="description">Choose which post type will get the two custom fields in it</p>
                    </td>
                </tr>
            </table>

            <?php submit_button('Save Selection'); ?>
        </form>
        <div style="margin-top: 20px; padding: 15px; background: #f5f5f5;">
            <h3>Next Steps:</h3>
            <?php if (!empty($saved_cpt)): ?>
                <p>✅ <strong>Selected CPT:</strong> <code><?php echo esc_html($saved_cpt); ?></code></p>
                <p>Next: The plugin will add 2 custom fields to posts of type: <strong><?php echo esc_html($saved_cpt); ?></strong></p>
            <?php else: ?>
                <p>⚠️ <strong>No post type selected yet.</strong> Please select one and save.</p>
            <?php endif; ?>
        </div>
    </div>

<?php
}
function acf_register_settings() {
    register_setting(
        'acf_settings_group',
        'acf_selected_cpt',
        array(
            'type' => 'string',
            'sanitize_callback' => 'acf_validate_selected_cpt',
            'default' => ''
        )
    );
}
add_action('admin_init', 'acf_register_settings');

function acf_validate_selected_cpt($input) {
    // If empty, return empty
    if (empty($input)) {
        return '';
    }
    
    // Get all valid public post types
    $valid_post_types = get_post_types(array('public' => true));
    
    // Remove unwanted post types
    $invalid_types = array('attachment', 'revision', 'nav_menu_item');
    $valid_post_types = array_diff($valid_post_types, $invalid_types);

    if(in_array($input , $valid_post_types)) {
        return sanitize_text_field($input);
    }

       add_settings_error(
        'acf_selected_cpt',
        'invalid_cpt',
        'Error: Invalid post type selected.',
        'error'
    );
    
    return '';
}


function acf_add_meta_box(){
    $targetCPT = get_option('acf_selected_cpt' , '');

    if(empty($targetCPT)){
        return;
    }

    add_meta_box(
        'acf_custom_fields',
        'CPT Metabox',
        'acf_meta_box_callback',
        $targetCPT,
        'normal',
        'high'
    );
}

add_action('add_meta_boxes' , 'acf_add_meta_box');


function acf_meta_box_callback($post) {
    wp_nonce_field('acf_save_fields' , 'acf_fields_nonce');
    
    $acf_field_1 = get_post_meta($post->ID , 'acf_field_1' , true);
    $acf_field_2 = get_post_meta($post->ID , 'acf_field_2' , true);
    
    ?>

    <!-- // input Fields  -->
     <label for="acf_field_1">Text Field</label>
    <input type="text" id = "acf_field_1" name="acf_field_1" value="<?php echo esc_attr($acf_field_1); ?>">

    <label for="acf_field_2">Textarea Field</label>
    <input type="text" id = "acf_field_2" name="acf_field_2" value="<?php echo esc_attr($acf_field_2); ?>">

<?php
}

function acf_save_meta_fields($post_id) {
     // Verify nonce
    if ( ! isset( $_POST['acf_fields_nonce'] ) || ! wp_verify_nonce( $_POST['acf_fields_nonce'], 'acf_save_fields' ) ) {
        return;
    }

    if(!current_user_can('edit_post' , $post_id)) {
        return;
    }

      // Check autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    $field1 = sanitize_text_field($_POST['acf_field_1']);
    update_post_meta($post_id , 'acf_field_1' , $field1);

    $field2 = sanitize_textarea_field($_POST['acf_field_2']);
    update_post_meta($post_id, 'acf_field_2', $field2);
}

add_action('save_post' , 'acf_save_meta_fields');

function acf_display_fields_frontend($content) {
    $post_id = get_the_ID();
    $metaField1 = get_post_meta($post_id , 'acf_field_1' , true);
    $metaField2 = get_post_meta($post_id , 'acf_field_2' , true);

    if(empty($metaField1) && empty($metaField2)){
        return $content;
    }

    $content .= '<div class = "cpt_fields">';
    $content .= '<p>' .esc_html($metaField1) . '</p>';
    $content .= '<p>' .esc_html($metaField2) . '</p>';
    $content .= '</div>';

    return $content;
}

add_filter('the_content' , 'acf_display_fields_frontend');
