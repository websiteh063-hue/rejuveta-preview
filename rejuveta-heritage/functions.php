<?php
/**
 * Rejuveta Heritage theme setup.
 *
 * @package RejuvetaHeritage
 */

if (!defined('ABSPATH')) {
    exit;
}

define('REJUVETA_VERSION', '1.0.0');

require_once get_template_directory() . '/inc/seed-content.php';
require_once get_template_directory() . '/inc/admin-panel.php';

function rejuveta_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'));
    add_theme_support('custom-logo', array(
        'height'      => 90,
        'width'       => 320,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    add_theme_support('automatic-feed-links');
    add_theme_support('align-wide');

    register_nav_menus(array(
        'primary' => __('Primary Menu', 'rejuveta-heritage'),
        'footer'  => __('Footer Menu', 'rejuveta-heritage'),
    ));
}
add_action('after_setup_theme', 'rejuveta_theme_setup');

function rejuveta_enqueue_assets() {
    wp_enqueue_style('rejuveta-theme', get_template_directory_uri() . '/assets/css/theme.css', array(), REJUVETA_VERSION);
    wp_enqueue_script('rejuveta-theme', get_template_directory_uri() . '/assets/js/theme.js', array(), REJUVETA_VERSION, true);
}
add_action('wp_enqueue_scripts', 'rejuveta_enqueue_assets');

function rejuveta_resource_hints($urls, $relation_type) {
    if ('preconnect' === $relation_type) {
        $urls[] = 'https://images.unsplash.com';
        $urls[] = 'https://images.pexels.com';
    }

    return $urls;
}
add_filter('wp_resource_hints', 'rejuveta_resource_hints', 10, 2);

function rejuveta_excerpt_length() {
    return 22;
}
add_filter('excerpt_length', 'rejuveta_excerpt_length');

function rejuveta_get_page_url($slug) {
    $page = get_page_by_path($slug);

    if ($page) {
        return get_permalink($page);
    }

    return home_url('/' . trim($slug, '/') . '/');
}

function rejuveta_fallback_menu() {
    echo '<ul id="primary-menu" class="menu">';
    echo '<li><a href="' . esc_url(home_url('/')) . '">Home</a></li>';
    echo '<li><a href="' . esc_url(rejuveta_get_page_url('about-us')) . '">About Us</a></li>';
    echo '<li><a href="' . esc_url(rejuveta_get_page_url('our-work')) . '">Our Work</a></li>';
    echo '<li><a href="' . esc_url(rejuveta_get_page_url('heritage-hub')) . '">Heritage Hub</a></li>';
    echo '<li><a href="' . esc_url(rejuveta_get_page_url('projects')) . '">Projects</a></li>';
    echo '<li><a href="' . esc_url(rejuveta_get_page_url('gallery')) . '">Gallery</a></li>';
    echo '<li><a href="' . esc_url(rejuveta_get_page_url('get-involved')) . '">Get Involved</a></li>';
    echo '<li><a href="' . esc_url(rejuveta_get_page_url('news-events')) . '">News & Events</a></li>';
    echo '<li><a href="' . esc_url(rejuveta_get_page_url('contact-us')) . '">Contact Us</a></li>';
    echo '</ul>';
}

function rejuveta_option($key, $default = '') {
    $options = get_option('rejuveta_options', array());
    return isset($options[$key]) && '' !== $options[$key] ? $options[$key] : $default;
}

function rejuveta_get_managed_items($post_type, $fallback = array(), $limit = 6) {
    $posts = get_posts(array(
        'post_type'      => $post_type,
        'post_status'    => 'publish',
        'posts_per_page' => $limit,
        'orderby'        => 'menu_order date',
        'order'          => 'ASC',
    ));

    if (!$posts) {
        return $fallback;
    }

    return array_map(function ($post) {
        $featured_image = get_the_post_thumbnail_url($post, 'large');

        return array(
            'title'    => get_the_title($post),
            'text'     => get_post_meta($post->ID, '_rejuveta_summary', true) ?: wp_strip_all_tags(get_the_excerpt($post)),
            'image'    => get_post_meta($post->ID, '_rejuveta_image', true) ?: $featured_image,
            'category' => get_post_meta($post->ID, '_rejuveta_category', true),
            'link'     => get_post_meta($post->ID, '_rejuveta_link', true) ?: get_permalink($post),
        );
    }, $posts);
}

function rejuveta_allowed_embed_html() {
    return array(
        'iframe' => array(
            'src'             => true,
            'width'           => true,
            'height'          => true,
            'style'           => true,
            'allowfullscreen' => true,
            'loading'         => true,
            'referrerpolicy'  => true,
            'title'           => true,
        ),
    );
}

function rejuveta_meta_description() {
    if (is_front_page()) {
        return 'Rejuveta Heritage & Conservation documents, promotes, and safeguards cultural and historical heritage for future generations.';
    }

    if (is_singular()) {
        $excerpt = get_the_excerpt();
        if (!empty($excerpt)) {
            return wp_strip_all_tags($excerpt);
        }
    }

    return get_bloginfo('description');
}

function rejuveta_head_seo() {
    $description = esc_attr(rejuveta_meta_description());
    $request = isset($GLOBALS['wp']->request) ? $GLOBALS['wp']->request : '';
    $canonical = esc_url(is_singular() ? get_permalink() : home_url(add_query_arg(array(), $request)));
    ?>
    <meta name="description" content="<?php echo $description; ?>">
    <link rel="canonical" href="<?php echo $canonical; ?>">
    <meta property="og:site_name" content="<?php echo esc_attr(get_bloginfo('name')); ?>">
    <meta property="og:title" content="<?php echo esc_attr(wp_get_document_title()); ?>">
    <meta property="og:description" content="<?php echo $description; ?>">
    <meta property="og:type" content="<?php echo is_singular() ? 'article' : 'website'; ?>">
    <meta property="og:url" content="<?php echo $canonical; ?>">
    <meta name="twitter:card" content="summary_large_image">
    <script type="application/ld+json">
    <?php
    echo wp_json_encode(array(
        '@context' => 'https://schema.org',
        '@type'    => 'NGO',
        'name'     => 'Rejuveta Heritage & Conservation',
        'url'      => home_url('/'),
        'slogan'   => 'Reviving Heritage. Preserving Legacy.',
        'description' => 'A heritage care and conservation organization focused on documentation, awareness, research, and community engagement.',
        'sameAs'   => array(),
        'contactPoint' => array(
            '@type'       => 'ContactPoint',
            'contactType' => 'General Enquiry',
            'email'       => get_option('admin_email'),
        ),
    ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    ?>
    </script>
    <?php
}
add_action('wp_head', 'rejuveta_head_seo', 1);

function rejuveta_body_classes($classes) {
    $classes[] = 'rejuveta-site';
    return $classes;
}
add_filter('body_class', 'rejuveta_body_classes');

function rejuveta_contact_shortcode() {
    $message = '';

    if (isset($_POST['rejuveta_contact_nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['rejuveta_contact_nonce'])), 'rejuveta_contact')) {
        $name    = sanitize_text_field(wp_unslash(isset($_POST['rejuveta_name']) ? $_POST['rejuveta_name'] : ''));
        $email   = sanitize_email(wp_unslash(isset($_POST['rejuveta_email']) ? $_POST['rejuveta_email'] : ''));
        $subject = sanitize_text_field(wp_unslash(isset($_POST['rejuveta_subject']) ? $_POST['rejuveta_subject'] : 'Website enquiry'));
        $body    = sanitize_textarea_field(wp_unslash(isset($_POST['rejuveta_message']) ? $_POST['rejuveta_message'] : ''));
        $trap    = sanitize_text_field(wp_unslash(isset($_POST['rejuveta_website']) ? $_POST['rejuveta_website'] : ''));

        if (empty($trap) && $name && is_email($email) && $body) {
            $sent = wp_mail(
                get_option('admin_email'),
                'Rejuveta enquiry: ' . $subject,
                "Name: {$name}\nEmail: {$email}\n\n{$body}",
                array('Reply-To: ' . $name . ' <' . $email . '>')
            );

            $message = $sent
                ? '<p class="form-message success">Thank you. Your message has been sent.</p>'
                : '<p class="form-message error">Sorry, the message could not be sent. Please email us directly.</p>';
        } else {
            $message = '<p class="form-message error">Please complete all required fields.</p>';
        }
    }

    ob_start();
    echo $message; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    ?>
    <form class="contact-form" method="post" action="<?php echo esc_url(get_permalink()); ?>">
        <?php wp_nonce_field('rejuveta_contact', 'rejuveta_contact_nonce'); ?>
        <label>
            <span>Name</span>
            <input type="text" name="rejuveta_name" autocomplete="name" required>
        </label>
        <label>
            <span>Email</span>
            <input type="email" name="rejuveta_email" autocomplete="email" required>
        </label>
        <label>
            <span>Subject</span>
            <input type="text" name="rejuveta_subject" required>
        </label>
        <label class="hidden-field">
            <span>Website</span>
            <input type="text" name="rejuveta_website" tabindex="-1" autocomplete="off">
        </label>
        <label class="full">
            <span>Message</span>
            <textarea name="rejuveta_message" rows="5" required></textarea>
        </label>
        <button class="button button-primary" type="submit">Send Message</button>
    </form>
    <?php
    return ob_get_clean();
}
add_shortcode('rejuveta_contact_form', 'rejuveta_contact_shortcode');

function rejuveta_newsletter_shortcode() {
    ob_start();
    ?>
    <form class="newsletter-form" method="post" action="<?php echo esc_url(home_url('/')); ?>">
        <label class="screen-reader-text" for="rejuveta-newsletter-email">Email address</label>
        <input id="rejuveta-newsletter-email" type="email" name="newsletter_email" placeholder="Email address" required>
        <button class="button button-secondary" type="submit">Subscribe</button>
    </form>
    <?php
    return ob_get_clean();
}
add_shortcode('rejuveta_newsletter', 'rejuveta_newsletter_shortcode');

function rejuveta_gallery_shortcode() {
    $fallback = array(
        array('category' => 'sites', 'title' => 'Historic Monument Precinct', 'text' => 'A landmark that carries architectural memory, civic identity, and shared cultural value.', 'image' => 'https://images.unsplash.com/photo-1599661046289-e31897846e41?auto=format&fit=crop&w=1400&q=78', 'id' => 'heritage-sites'),
        array('category' => 'sites', 'title' => 'Sacred Heritage Landscape', 'text' => 'A cultural landscape where built heritage, rituals, and natural setting work together.', 'image' => 'https://images.unsplash.com/photo-1598091383021-15ddea10925d?auto=format&fit=crop&w=1400&q=78', 'id' => ''),
        array('category' => 'sites', 'title' => 'Traditional Settlement Core', 'text' => 'A living neighborhood shaped by architecture, craft, markets, and community memory.', 'image' => 'https://images.unsplash.com/photo-1609947017136-9daf32a5eb16?auto=format&fit=crop&w=1400&q=78', 'id' => ''),
        array('category' => 'events', 'title' => 'Awareness Event', 'text' => 'Public programs help communities understand why local heritage deserves care.', 'image' => 'https://images.unsplash.com/photo-1587474260584-136574528ed5?auto=format&fit=crop&w=1400&q=78', 'id' => 'events'),
        array('category' => 'events', 'title' => 'Workshop Session', 'text' => 'Workshops can train students and volunteers in documentation and heritage awareness.', 'image' => 'https://images.unsplash.com/photo-1582972236019-ea4af5ffe587?auto=format&fit=crop&w=1400&q=78', 'id' => ''),
        array('category' => 'walks', 'title' => 'Heritage Walk Route', 'text' => 'Guided walks help people experience history through streets, buildings, and stories.', 'image' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Charminar%20of%20Hyderabad%20Telangana.jpg?width=1400', 'id' => 'heritage-walks'),
        array('category' => 'walks', 'title' => 'Field Documentation Walk', 'text' => 'Documentation walks record photographs, notes, local stories, and site condition details.', 'image' => 'https://images.unsplash.com/photo-1524492412937-b28074a5d7da?auto=format&fit=crop&w=1400&q=78', 'id' => ''),
        array('category' => 'community', 'title' => 'Community Participation', 'text' => 'Conservation becomes stronger when citizens, students, and institutions participate together.', 'image' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Konark%20Sun%20temple.jpg?width=1400', 'id' => 'community'),
        array('category' => 'community', 'title' => 'Volunteer Group Activity', 'text' => 'Volunteers can support mapping, awareness campaigns, field visits, and event coordination.', 'image' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Full%20view%20of%20Charminar.jpg?width=1400', 'id' => ''),
    );
    $items = rejuveta_get_managed_items('rejuveta_gallery', $fallback, 24);

    ob_start();
    ?>
    <div class="gallery-filters" aria-label="Gallery filters">
        <button class="filter-button is-active" type="button" data-filter="all">All</button>
        <button class="filter-button" type="button" data-filter="sites">Heritage Sites</button>
        <button class="filter-button" type="button" data-filter="events">Events</button>
        <button class="filter-button" type="button" data-filter="walks">Heritage Walks</button>
        <button class="filter-button" type="button" data-filter="community">Community</button>
    </div>
    <div class="full-gallery" data-gallery>
        <?php foreach ($items as $index => $item) : ?>
            <button <?php echo !empty($item['id']) ? 'id="' . esc_attr($item['id']) . '"' : ''; ?> class="gallery-card reveal is-visible" type="button" data-category="<?php echo esc_attr($item['category'] ?: 'sites'); ?>" data-title="<?php echo esc_attr($item['title']); ?>" data-caption="<?php echo esc_attr($item['text']); ?>" data-src="<?php echo esc_url($item['image']); ?>">
                <img src="<?php echo esc_url($item['image']); ?>" alt="<?php echo esc_attr($item['title']); ?>" loading="lazy" decoding="async">
                <span><?php echo esc_html($item['title']); ?></span>
            </button>
        <?php endforeach; ?>
    </div>
    <div class="gallery-lightbox" aria-hidden="true" role="dialog" aria-label="Gallery image viewer">
        <button class="lightbox-close" type="button" aria-label="Close gallery">&times;</button>
        <button class="lightbox-nav lightbox-prev" type="button" aria-label="Previous image">&lsaquo;</button>
        <figure><img src="" alt=""><figcaption><strong></strong><span></span></figcaption></figure>
        <button class="lightbox-nav lightbox-next" type="button" aria-label="Next image">&rsaquo;</button>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('rejuveta_gallery', 'rejuveta_gallery_shortcode');

function rejuveta_news_events_shortcode() {
    $fallback = array(
        array('title' => 'Rejuveta Heritage Begins Its Phase 1 Work', 'text' => 'The first phase focuses on heritage documentation, awareness, research, community engagement, gallery building, and volunteer participation.', 'category' => 'news', 'link' => rejuveta_get_page_url('about-us')),
        array('title' => 'Local Heritage Mapping Plan', 'text' => 'Local mapping will help identify important sites, streets, landscapes, craft areas, and community stories for future documentation.', 'category' => 'news', 'link' => rejuveta_get_page_url('blog/heritage-documentation-blog')),
        array('title' => 'Introductory Heritage Walk', 'text' => 'A guided walk format to help citizens experience local history through streets, structures, stories, and cultural memory.', 'category' => 'events', 'link' => rejuveta_get_page_url('contact-us')),
        array('title' => 'Heritage Documentation Basics', 'text' => 'Training on photography, site notes, oral history collection, basic mapping, and responsible documentation practices.', 'category' => 'workshops', 'link' => rejuveta_get_page_url('blog/heritage-research-blog')),
        array('title' => 'Know Your Local Heritage', 'text' => 'A public awareness campaign encouraging citizens to identify, photograph, and share important heritage places in their area.', 'category' => 'campaigns', 'link' => rejuveta_get_page_url('gallery')),
    );
    $items = rejuveta_get_managed_items('rejuveta_event', $fallback, 24);

    ob_start();
    ?>
    <div class="gallery-filters" aria-label="News and events filters">
        <button class="filter-button is-active" type="button" data-news-filter="all">All</button>
        <button class="filter-button" type="button" data-news-filter="news">Latest News</button>
        <button class="filter-button" type="button" data-news-filter="events">Events</button>
        <button class="filter-button" type="button" data-news-filter="workshops">Workshops</button>
        <button class="filter-button" type="button" data-news-filter="campaigns">Campaigns</button>
    </div>
    <div class="news-board">
        <?php foreach ($items as $item) : ?>
            <article class="news-card reveal is-visible" data-news-category="<?php echo esc_attr($item['category'] ?: 'news'); ?>">
                <p class="eyebrow"><?php echo esc_html(ucwords(str_replace('-', ' ', $item['category'] ?: 'news'))); ?></p>
                <h2><?php echo esc_html($item['title']); ?></h2>
                <p><?php echo esc_html($item['text']); ?></p>
                <a class="text-link" href="<?php echo esc_url($item['link']); ?>">Read More</a>
            </article>
        <?php endforeach; ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('rejuveta_news_events', 'rejuveta_news_events_shortcode');
