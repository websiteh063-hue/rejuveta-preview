<?php
/**
 * Backend controls for Rejuveta Heritage.
 *
 * @package RejuvetaHeritage
 */

if (!defined('ABSPATH')) {
    exit;
}

function rejuveta_default_options() {
    return array(
        'hero_title'       => 'Preserving Heritage, Protecting History',
        'hero_subtitle'    => 'Dedicated to documenting, promoting, and safeguarding our cultural and historical heritage for future generations.',
        'hero_image'       => 'https://images.unsplash.com/photo-1599661046289-e31897846e41?auto=format&fit=crop&w=1800&q=78',
        'hero_primary'     => 'Explore Our Work',
        'hero_secondary'   => 'Join Our Mission',
        'about_title'      => 'About Organization',
        'about_text'       => 'Rejuveta Heritage & Conservation is a new heritage care organization committed to preserving cultural identity through documentation, research, awareness, and community participation.',
        'vision_title'     => 'Heritage Passed Forward',
        'vision_text'      => 'To create a future where cultural heritage is preserved, appreciated, and passed on to generations to come.',
        'mission_title'    => 'Awareness, Research, Action',
        'mission_text'     => 'To promote awareness, documentation, research, and community participation in heritage conservation.',
        'phone'            => '+91 00000 00000',
        'email'            => 'doonvalleyhighschool80@gmail.com',
        'address'          => 'Add your office address here',
        'facebook'         => '#',
        'instagram'        => '#',
        'linkedin'         => '#',
        'map_embed'        => '',
        'footer_text'      => 'Dedicated to documenting, promoting, and safeguarding cultural and historical heritage for future generations.',
    );
}

function rejuveta_sanitize_options($input) {
    $defaults = rejuveta_default_options();
    $output = array();

    foreach ($defaults as $key => $default) {
        $value = isset($input[$key]) ? $input[$key] : $default;
        if ('map_embed' === $key) {
            $output[$key] = wp_kses($value, rejuveta_allowed_embed_html());
        } elseif (in_array($key, array('about_text', 'hero_subtitle', 'vision_text', 'mission_text', 'address', 'footer_text'), true)) {
            $output[$key] = wp_kses_post($value);
        } elseif (false !== strpos($key, 'image') || in_array($key, array('facebook', 'instagram', 'linkedin'), true)) {
            $output[$key] = esc_url_raw($value);
        } elseif ('email' === $key) {
            $output[$key] = sanitize_email($value);
        } else {
            $output[$key] = sanitize_text_field($value);
        }
    }

    return $output;
}

function rejuveta_register_admin_settings() {
    register_setting('rejuveta_options_group', 'rejuveta_options', array(
        'sanitize_callback' => 'rejuveta_sanitize_options',
        'default'           => rejuveta_default_options(),
    ));
}
add_action('admin_init', 'rejuveta_register_admin_settings');

function rejuveta_register_admin_menu() {
    add_menu_page(
        'Rejuveta Panel',
        'Rejuveta Panel',
        'edit_theme_options',
        'rejuveta-panel',
        'rejuveta_render_admin_panel',
        'dashicons-admin-site-alt3',
        3
    );
}
add_action('admin_menu', 'rejuveta_register_admin_menu');

function rejuveta_options_capability() {
    return 'edit_theme_options';
}
add_filter('option_page_capability_rejuveta_options_group', 'rejuveta_options_capability');

function rejuveta_field($key, $label, $type = 'text') {
    $defaults = rejuveta_default_options();
    $value = rejuveta_option($key, isset($defaults[$key]) ? $defaults[$key] : '');
    echo '<tr><th scope="row"><label for="' . esc_attr($key) . '">' . esc_html($label) . '</label></th><td>';
    if ('textarea' === $type) {
        echo '<textarea id="' . esc_attr($key) . '" name="rejuveta_options[' . esc_attr($key) . ']" rows="4" class="large-text">' . esc_textarea($value) . '</textarea>';
    } else {
        echo '<input id="' . esc_attr($key) . '" type="' . esc_attr($type) . '" name="rejuveta_options[' . esc_attr($key) . ']" value="' . esc_attr($value) . '" class="regular-text">';
    }
    echo '</td></tr>';
}

function rejuveta_render_admin_panel() {
    ?>
    <div class="wrap">
        <h1>Rejuveta Backend Panel</h1>
            <p>Update the homepage, contact information, and global website content here. For cards, initiatives, gallery, sites, and events, use the editable content menus created below.</p>
        <form method="post" action="options.php">
            <?php settings_fields('rejuveta_options_group'); ?>
            <h2>Homepage Hero</h2>
            <table class="form-table">
                <?php rejuveta_field('hero_title', 'Hero Title'); ?>
                <?php rejuveta_field('hero_subtitle', 'Hero Subtitle', 'textarea'); ?>
                <?php rejuveta_field('hero_image', 'Hero Image URL', 'url'); ?>
                <?php rejuveta_field('hero_primary', 'Primary Button Text'); ?>
                <?php rejuveta_field('hero_secondary', 'Secondary Button Text'); ?>
            </table>
            <h2>About, Vision & Mission</h2>
            <table class="form-table">
                <?php rejuveta_field('about_title', 'About Title'); ?>
                <?php rejuveta_field('about_text', 'About Text', 'textarea'); ?>
                <?php rejuveta_field('vision_title', 'Vision Title'); ?>
                <?php rejuveta_field('vision_text', 'Vision Text', 'textarea'); ?>
                <?php rejuveta_field('mission_title', 'Mission Title'); ?>
                <?php rejuveta_field('mission_text', 'Mission Text', 'textarea'); ?>
            </table>
            <h2>Contact & Footer</h2>
            <table class="form-table">
                <?php rejuveta_field('phone', 'Phone'); ?>
                <?php rejuveta_field('email', 'Email', 'email'); ?>
                <?php rejuveta_field('address', 'Address', 'textarea'); ?>
                <?php rejuveta_field('facebook', 'Facebook URL', 'url'); ?>
                <?php rejuveta_field('instagram', 'Instagram URL', 'url'); ?>
                <?php rejuveta_field('linkedin', 'LinkedIn URL', 'url'); ?>
                <?php rejuveta_field('map_embed', 'Google Map Embed Code', 'textarea'); ?>
                <?php rejuveta_field('footer_text', 'Footer Description', 'textarea'); ?>
            </table>
            <?php submit_button('Save Rejuveta Settings'); ?>
        </form>
        <hr>
        <h2>Editable Website Sections</h2>
        <p>Use these admin menus to add, remove, reorder, and update cards without code:</p>
        <ul style="list-style:disc;margin-left:24px;">
            <li><a href="<?php echo esc_url(admin_url('edit.php?post_type=rejuveta_focus')); ?>">Focus Areas</a></li>
            <li><a href="<?php echo esc_url(admin_url('edit.php?post_type=rejuveta_initiative')); ?>">Current Initiatives</a></li>
            <li><a href="<?php echo esc_url(admin_url('edit.php?post_type=rejuveta_site')); ?>">Heritage Sites</a></li>
            <li><a href="<?php echo esc_url(admin_url('edit.php?post_type=rejuveta_gallery')); ?>">Gallery Items</a></li>
            <li><a href="<?php echo esc_url(admin_url('edit.php?post_type=rejuveta_event')); ?>">News & Events</a></li>
        </ul>
    </div>
    <?php
}

function rejuveta_register_content_types() {
    $types = array(
        'rejuveta_focus'   => array('Focus Areas', 'Focus Area', 'dashicons-screenoptions'),
        'rejuveta_initiative' => array('Current Initiatives', 'Current Initiative', 'dashicons-clipboard'),
        'rejuveta_site'    => array('Heritage Sites', 'Heritage Site', 'dashicons-building'),
        'rejuveta_gallery' => array('Gallery Items', 'Gallery Item', 'dashicons-format-gallery'),
        'rejuveta_event'   => array('News & Events', 'News/Event', 'dashicons-calendar-alt'),
    );

    foreach ($types as $type => $data) {
        register_post_type($type, array(
            'labels' => array(
                'name'          => $data[0],
                'singular_name' => $data[1],
                'add_new_item'  => 'Add New ' . $data[1],
                'edit_item'     => 'Edit ' . $data[1],
            ),
            'public'       => true,
            'show_ui'      => true,
            'show_in_menu' => 'rejuveta-panel',
            'menu_icon'    => $data[2],
            'supports'     => array('title', 'editor', 'thumbnail', 'page-attributes'),
            'has_archive'  => false,
            'rewrite'      => array('slug' => str_replace('rejuveta_', '', $type)),
        ));
    }
}
add_action('init', 'rejuveta_register_content_types');

function rejuveta_add_meta_boxes() {
    foreach (array('rejuveta_focus', 'rejuveta_initiative', 'rejuveta_site', 'rejuveta_gallery', 'rejuveta_event') as $type) {
        add_meta_box('rejuveta_item_details', 'Display Details', 'rejuveta_render_item_meta_box', $type, 'normal', 'high');
    }
}
add_action('add_meta_boxes', 'rejuveta_add_meta_boxes');

function rejuveta_render_item_meta_box($post) {
    wp_nonce_field('rejuveta_save_item_meta', 'rejuveta_item_nonce');
    $summary = get_post_meta($post->ID, '_rejuveta_summary', true);
    $image = get_post_meta($post->ID, '_rejuveta_image', true);
    $category = get_post_meta($post->ID, '_rejuveta_category', true);
    $link = get_post_meta($post->ID, '_rejuveta_link', true);
    ?>
    <p><label><strong>Short Summary</strong></label></p>
    <textarea name="rejuveta_summary" rows="3" class="widefat"><?php echo esc_textarea($summary); ?></textarea>
    <p><label><strong>Image URL</strong></label></p>
    <input type="url" name="rejuveta_image" value="<?php echo esc_attr($image); ?>" class="widefat">
    <p><label><strong>Category</strong> <em>(gallery: sites, events, walks, community / news: news, events, workshops, campaigns)</em></label></p>
    <input type="text" name="rejuveta_category" value="<?php echo esc_attr($category); ?>" class="widefat">
    <p><label><strong>Custom Link URL</strong></label></p>
    <input type="url" name="rejuveta_link" value="<?php echo esc_attr($link); ?>" class="widefat">
    <?php
}

function rejuveta_save_item_meta($post_id) {
    if (!isset($_POST['rejuveta_item_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['rejuveta_item_nonce'])), 'rejuveta_save_item_meta')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    update_post_meta($post_id, '_rejuveta_summary', sanitize_textarea_field(wp_unslash(isset($_POST['rejuveta_summary']) ? $_POST['rejuveta_summary'] : '')));
    update_post_meta($post_id, '_rejuveta_image', esc_url_raw(wp_unslash(isset($_POST['rejuveta_image']) ? $_POST['rejuveta_image'] : '')));
    update_post_meta($post_id, '_rejuveta_category', sanitize_key(wp_unslash(isset($_POST['rejuveta_category']) ? $_POST['rejuveta_category'] : '')));
    update_post_meta($post_id, '_rejuveta_link', esc_url_raw(wp_unslash(isset($_POST['rejuveta_link']) ? $_POST['rejuveta_link'] : '')));
}
add_action('save_post', 'rejuveta_save_item_meta');
