<?php
/**
 * Posts index.
 *
 * @package RejuvetaHeritage
 */

get_header();
?>
<section class="page-hero">
    <div class="container">
        <p class="eyebrow">News & Events</p>
        <h1><?php echo esc_html(get_the_archive_title() ?: 'Articles & Updates'); ?></h1>
    </div>
</section>
<section class="section">
    <div class="container news-grid">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <article class="plain-card">
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <p><?php echo esc_html(get_the_excerpt()); ?></p>
                    <a class="text-link" href="<?php the_permalink(); ?>">Read More</a>
                </article>
            <?php endwhile; ?>
        <?php else : ?>
            <article class="plain-card">
                <h2>No updates yet</h2>
                <p>News, articles, events, and campaigns will appear here.</p>
            </article>
        <?php endif; ?>
    </div>
</section>
<?php
get_footer();

