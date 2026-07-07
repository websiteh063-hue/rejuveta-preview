<?php
/**
 * 404 template.
 *
 * @package RejuvetaHeritage
 */

get_header();
?>
<section class="page-hero">
    <div class="container">
        <p class="eyebrow">Page Not Found</p>
        <h1>This heritage trail seems to end here.</h1>
        <a class="button button-primary" href="<?php echo esc_url(home_url('/')); ?>">Return Home</a>
    </div>
</section>
<?php
get_footer();

