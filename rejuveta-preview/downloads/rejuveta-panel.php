<?php
/**
 * Plugin Name: Rejuveta Live Site Demo
 * Description: Temporary WordPress Playground demo for Rejuveta Heritage & Conservation.
 */

if (!defined('ABSPATH')) {
    exit;
}

function rejuveta_demo_defaults() {
    return array(
        'hero_title' => 'Preserving Heritage, Protecting History',
        'hero_subtitle' => 'Dedicated to documenting, promoting, and safeguarding our cultural and historical heritage for future generations.',
        'about_text' => 'Rejuveta Heritage & Conservation documents, promotes, and safeguards cultural and historical heritage through awareness, research, and community participation.',
        'vision_text' => 'To create a future where cultural heritage is preserved, appreciated, and passed on to generations to come.',
        'mission_text' => 'To promote awareness, documentation, research, and community participation in heritage conservation.',
        'phone' => '+91 00000 00000',
        'email' => 'doonvalleyhighschool80@gmail.com',
        'address' => 'Add your office address here',
    );
}

function rejuveta_demo_option($key) {
    $options = get_option('rejuveta_demo_options', array());
    $defaults = rejuveta_demo_defaults();
    return isset($options[$key]) && '' !== $options[$key] ? $options[$key] : $defaults[$key];
}

function rejuveta_demo_admin_menu() {
    add_menu_page('Rejuveta Panel', 'Rejuveta Panel', 'manage_options', 'rejuveta-panel', 'rejuveta_demo_render_panel', 'dashicons-admin-site-alt3', 3);
}
add_action('admin_menu', 'rejuveta_demo_admin_menu');

function rejuveta_demo_render_field($key, $label, $type = 'text') {
    $value = rejuveta_demo_option($key);
    echo '<tr><th scope="row"><label for="' . esc_attr($key) . '">' . esc_html($label) . '</label></th><td>';
    if ('textarea' === $type) {
        echo '<textarea id="' . esc_attr($key) . '" name="rejuveta_demo_options[' . esc_attr($key) . ']" rows="4" class="large-text">' . esc_textarea($value) . '</textarea>';
    } else {
        echo '<input id="' . esc_attr($key) . '" type="' . esc_attr($type) . '" name="rejuveta_demo_options[' . esc_attr($key) . ']" value="' . esc_attr($value) . '" class="regular-text">';
    }
    echo '</td></tr>';
}

function rejuveta_demo_render_panel() {
    if (isset($_POST['rejuveta_demo_nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['rejuveta_demo_nonce'])), 'rejuveta_demo_save')) {
        $raw = isset($_POST['rejuveta_demo_options']) ? (array) $_POST['rejuveta_demo_options'] : array();
        $saved = array();
        foreach (rejuveta_demo_defaults() as $key => $default) {
            $value = isset($raw[$key]) ? wp_unslash($raw[$key]) : $default;
            $saved[$key] = 'email' === $key ? sanitize_email($value) : sanitize_textarea_field($value);
        }
        update_option('rejuveta_demo_options', $saved);
        echo '<div class="notice notice-success is-dismissible"><p>Rejuveta settings saved successfully. Open the site front page to see the change.</p></div>';
    }
    ?>
    <div class="wrap">
        <h1>Rejuveta Backend Panel</h1>
        <p>Edit the main website content here. This is the live Playground test. The full WordPress theme ZIP gives you the complete version for real hosting.</p>
        <p><a class="button button-primary" href="<?php echo esc_url(home_url('/')); ?>">View Site</a></p>
        <form method="post">
            <?php wp_nonce_field('rejuveta_demo_save', 'rejuveta_demo_nonce'); ?>
            <h2>Homepage Content</h2>
            <table class="form-table">
                <?php rejuveta_demo_render_field('hero_title', 'Hero Title'); ?>
                <?php rejuveta_demo_render_field('hero_subtitle', 'Hero Subtitle', 'textarea'); ?>
                <?php rejuveta_demo_render_field('about_text', 'About Text', 'textarea'); ?>
                <?php rejuveta_demo_render_field('vision_text', 'Vision Text', 'textarea'); ?>
                <?php rejuveta_demo_render_field('mission_text', 'Mission Text', 'textarea'); ?>
            </table>
            <h2>Contact Details</h2>
            <table class="form-table">
                <?php rejuveta_demo_render_field('phone', 'Phone'); ?>
                <?php rejuveta_demo_render_field('email', 'Email', 'email'); ?>
                <?php rejuveta_demo_render_field('address', 'Address', 'textarea'); ?>
            </table>
            <?php submit_button('Save Rejuveta Settings'); ?>
        </form>
    </div>
    <?php
}

function rejuveta_demo_frontend() {
    if (is_admin() || wp_doing_ajax()) {
        return;
    }

    status_header(200);
    nocache_headers();
    $logo = 'https://rejuveta-preview.vercel.app/assets/images/rejuveta-logo.svg';
    $hero = 'https://images.unsplash.com/photo-1599661046289-e31897846e41?auto=format&fit=crop&w=1800&q=78';
    ?>
    <!doctype html>
    <html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Rejuveta Heritage & Conservation</title>
        <?php wp_head(); ?>
        <style>
            :root{--green:#173f31;--ink:#12201a;--cream:#f6f5ef;--gold:#b8792d}
            body{margin:0;font-family:Arial,Helvetica,sans-serif;color:var(--ink);background:var(--cream);line-height:1.65}
            a{color:inherit}.top{position:sticky;top:32px;z-index:10;background:#fff;border-bottom:1px solid #d7ded5}.wrap{width:min(1160px,92vw);margin:auto}
            .nav{display:flex;align-items:center;justify-content:space-between;gap:24px;padding:18px 0}.brand{display:flex;align-items:center;gap:14px;text-decoration:none;font-weight:800}.brand img{width:48px;height:48px}.brand small{display:block;font-weight:400;color:#59665f}
            .menu{display:flex;gap:18px;flex-wrap:wrap;font-weight:700;font-size:14px}.menu a{text-decoration:none}.hero{min-height:620px;display:grid;align-items:center;background:linear-gradient(90deg,rgba(18,32,26,.82),rgba(18,32,26,.35)),url('<?php echo esc_url($hero); ?>') center/cover;color:#fff}
            h1{font-size:clamp(42px,7vw,86px);line-height:.98;margin:10px 0 18px;max-width:850px}h2{font-size:clamp(32px,5vw,58px);line-height:1.05;margin:0 0 18px}.eyebrow{text-transform:uppercase;letter-spacing:.04em;font-size:13px;font-weight:900;color:var(--gold)}
            .hero p{max-width:720px;font-size:20px}.buttons{display:flex;gap:14px;flex-wrap:wrap;margin-top:26px}.btn{padding:14px 22px;border-radius:6px;text-decoration:none;font-weight:800;background:var(--gold);color:#fff}.btn.alt{background:#fff;color:var(--green)}
            section{padding:84px 0}.grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(230px,1fr));gap:22px}.card{background:#fff;border:1px solid #d7ded5;border-radius:8px;padding:28px;box-shadow:0 16px 40px rgba(20,35,28,.08)}.card img{width:100%;height:190px;object-fit:cover;border-radius:6px;margin:-28px -28px 22px;width:calc(100% + 56px)}
            .dark{background:var(--green);color:#fff}.dark .card{background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.18);box-shadow:none}.two{display:grid;grid-template-columns:1fr 1fr;gap:24px}.footer{background:#0f241c;color:#fff;padding:40px 0}
            @media(max-width:760px){.nav,.two{display:block}.menu{margin-top:16px}.hero{min-height:560px}}
        </style>
    </head>
    <body>
    <?php wp_body_open(); ?>
    <header class="top"><div class="wrap nav"><a class="brand" href="<?php echo esc_url(home_url('/')); ?>"><img src="<?php echo esc_url($logo); ?>" alt=""><span>Rejuveta Heritage & Conservation<small>Reviving Heritage. Preserving Legacy.</small></span></a><nav class="menu"><a href="#about">About</a><a href="#work">Our Work</a><a href="#sites">Sites</a><a href="#gallery">Gallery</a><a href="#contact">Contact</a><a href="<?php echo esc_url(admin_url('admin.php?page=rejuveta-panel')); ?>">Backend Panel</a></nav></div></header>
    <main>
        <section class="hero"><div class="wrap"><p class="eyebrow">Rejuveta Heritage & Conservation</p><h1><?php echo esc_html(rejuveta_demo_option('hero_title')); ?></h1><p><?php echo esc_html(rejuveta_demo_option('hero_subtitle')); ?></p><div class="buttons"><a class="btn" href="#work">Explore Our Work</a><a class="btn alt" href="<?php echo esc_url(admin_url('admin.php?page=rejuveta-panel')); ?>">Edit From Backend</a></div></div></section>
        <section id="about"><div class="wrap two"><div><p class="eyebrow">Who We Are</p><h2>About Organization</h2><p><?php echo esc_html(rejuveta_demo_option('about_text')); ?></p></div><div class="grid"><article class="card"><h3>Vision</h3><p><?php echo esc_html(rejuveta_demo_option('vision_text')); ?></p></article><article class="card"><h3>Mission</h3><p><?php echo esc_html(rejuveta_demo_option('mission_text')); ?></p></article></div></div></section>
        <section id="work" class="dark"><div class="wrap"><p class="eyebrow">Our Focus Areas</p><h2>Practical Work for Lasting Conservation</h2><div class="grid"><article class="card"><h3>Heritage Documentation</h3><p>Recording sites, oral histories, architecture, maps, and historical evidence.</p></article><article class="card"><h3>Heritage Research</h3><p>Encouraging field studies, local history projects, and knowledge sharing.</p></article><article class="card"><h3>Heritage Awareness</h3><p>Public programs, campaigns, and learning activities for wider participation.</p></article><article class="card"><h3>Community Engagement</h3><p>Involving citizens, youth, and institutions in preservation efforts.</p></article></div></div></section>
        <section id="sites"><div class="wrap"><p class="eyebrow">Featured Heritage Sites</p><h2>Indian Places That Carry Memory</h2><div class="grid"><article class="card"><img src="https://images.unsplash.com/photo-1524492412937-b28074a5d7da?auto=format&fit=crop&w=900&q=72" alt=""><h3>Historic Monument Precinct</h3><p>A landmark representing layered architecture, memory, and civic identity.</p></article><article class="card"><img src="https://images.unsplash.com/photo-1609947017136-9daf32a5eb16?auto=format&fit=crop&w=900&q=72" alt=""><h3>Traditional Settlement Core</h3><p>A living neighborhood where built form, craft, and community life meet.</p></article><article class="card"><img src="https://commons.wikimedia.org/wiki/Special:FilePath/Charminar%20of%20Hyderabad%20Telangana.jpg?width=900" alt=""><h3>Sacred Heritage Landscape</h3><p>A culturally significant site connected with rituals, stories, and local continuity.</p></article></div></div></section>
        <section id="gallery" class="dark"><div class="wrap"><p class="eyebrow">Gallery Preview</p><h2>Heritage Sites, Events, Walks, and Community Activities</h2><div class="grid"><article class="card"><img src="https://images.unsplash.com/photo-1599661046289-e31897846e41?auto=format&fit=crop&w=700&q=70" alt=""><h3>Heritage Sites</h3></article><article class="card"><img src="https://images.unsplash.com/photo-1587474260584-136574528ed5?auto=format&fit=crop&w=700&q=70" alt=""><h3>Indian Heritage Events</h3></article><article class="card"><img src="https://commons.wikimedia.org/wiki/Special:FilePath/Konark%20Sun%20temple.jpg?width=700" alt=""><h3>Community Activities</h3></article></div></div></section>
        <section id="contact"><div class="wrap"><p class="eyebrow">Contact Us</p><h2>Start a Conversation About Heritage Care</h2><p>Phone: <?php echo esc_html(rejuveta_demo_option('phone')); ?></p><p>Email: <?php echo esc_html(rejuveta_demo_option('email')); ?></p><p>Office Address: <?php echo esc_html(rejuveta_demo_option('address')); ?></p></div></section>
    </main>
    <footer class="footer"><div class="wrap"><strong>Rejuveta Heritage & Conservation</strong><p>Reviving Heritage. Preserving Legacy.</p></div></footer>
    <?php wp_footer(); ?>
    </body></html>
    <?php
    exit;
}
add_action('template_redirect', 'rejuveta_demo_frontend', 0);
