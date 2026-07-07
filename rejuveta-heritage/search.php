<?php
/**
 * Search template.
 *
 * @package RejuvetaHeritage
 */

get_header();
?>
<section class="page-hero">
    <div class="container">
        <p class="eyebrow">Search</p>
        <h1><?php printf(esc_html__('Search results for: %s', 'rejuveta-heritage'), esc_html(get_search_query())); ?></h1>
    </div>
</section>
<section class="section">
    <div class="container news-grid">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <article class="plain-card">
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <p><?php echo esc_html(get_the_excerpt()); ?></p>
                </article>
            <?php endwhile; ?>
        <?php else : ?>
            <article class="plain-card">
                <h2>No results found</h2>
                <p>Try searching for heritage sites, events, articles, or projects.</p>
            </article>
        <?php endif; ?>
    </div>
</section>
<?php
get_footer();

