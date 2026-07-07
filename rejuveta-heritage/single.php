<?php
/**
 * Single post template.
 *
 * @package RejuvetaHeritage
 */

get_header();
?>
<?php while (have_posts()) : the_post(); ?>
<section class="page-hero">
    <div class="container">
        <p class="eyebrow"><?php echo esc_html(get_the_date()); ?></p>
        <h1><?php the_title(); ?></h1>
    </div>
</section>
<article class="section">
    <div class="container content-wrap">
        <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('large', array('class' => 'featured-image')); ?>
        <?php endif; ?>
        <?php the_content(); ?>
    </div>
</article>
<?php endwhile; ?>
<?php
get_footer();

