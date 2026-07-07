<?php
/**
 * Generic page template.
 *
 * @package RejuvetaHeritage
 */

get_header();
?>
<section class="page-hero">
    <div class="container">
        <p class="eyebrow">Rejuveta Heritage & Conservation</p>
        <h1><?php the_title(); ?></h1>
    </div>
</section>
<section class="section">
    <div class="container content-wrap">
        <?php
        while (have_posts()) :
            the_post();
            the_content();
        endwhile;
        ?>
    </div>
</section>
<?php
get_footer();

