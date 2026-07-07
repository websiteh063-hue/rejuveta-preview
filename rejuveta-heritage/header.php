<?php
/**
 * Site header.
 *
 * @package RejuvetaHeritage
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div class="site-preloader" aria-hidden="true">
    <span></span>
</div>
<a class="skip-link screen-reader-text" href="#main">Skip to content</a>
<header class="site-header">
    <div class="container header-inner">
        <a class="brand" href="<?php echo esc_url(home_url('/')); ?>" aria-label="Rejuveta Heritage home">
            <?php if (has_custom_logo()) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <img class="brand-logo" src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/rejuveta-logo.svg'); ?>" alt="Rejuveta Heritage & Conservation">
            <?php endif; ?>
        </a>
        <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="primary-menu">
            <span></span><span></span><span></span>
            <span class="screen-reader-text">Menu</span>
        </button>
        <nav class="primary-nav" aria-label="Primary navigation">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_id'        => 'primary-menu',
                'container'      => false,
                'fallback_cb'    => 'rejuveta_fallback_menu',
            ));
            ?>
        </nav>
    </div>
</header>
<main id="main" class="site-main">
