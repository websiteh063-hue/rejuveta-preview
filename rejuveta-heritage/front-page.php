<?php
/**
 * Homepage template.
 *
 * @package RejuvetaHeritage
 */

get_header();

$images = array(
    'hero' => rejuveta_option('hero_image', 'https://images.unsplash.com/photo-1599661046289-e31897846e41?auto=format&fit=crop&w=1800&q=78'),
    'site1' => 'https://images.unsplash.com/photo-1524492412937-b28074a5d7da?auto=format&fit=crop&w=900&q=72',
    'site2' => 'https://images.unsplash.com/photo-1609947017136-9daf32a5eb16?auto=format&fit=crop&w=900&q=72',
    'site3' => 'https://images.unsplash.com/photo-1598091383021-15ddea10925d?auto=format&fit=crop&w=900&q=72',
    'gallery1' => 'https://images.unsplash.com/photo-1599661046289-e31897846e41?auto=format&fit=crop&w=700&q=70',
    'gallery2' => 'https://images.unsplash.com/photo-1587474260584-136574528ed5?auto=format&fit=crop&w=700&q=70',
    'gallery3' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Charminar%20of%20Hyderabad%20Telangana.jpg?width=700',
    'gallery4' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Konark%20Sun%20temple.jpg?width=700',
);
?>

<section class="hero-section" style="--hero-image: url('<?php echo esc_url($images['hero']); ?>');">
    <div class="container hero-content reveal">
        <p class="eyebrow">Rejuveta Heritage & Conservation</p>
        <h1><?php echo esc_html(rejuveta_option('hero_title', 'Preserving Heritage, Protecting History')); ?></h1>
        <p><?php echo esc_html(rejuveta_option('hero_subtitle', 'Dedicated to documenting, promoting, and safeguarding our cultural and historical heritage for future generations.')); ?></p>
        <div class="button-row">
            <a class="button button-primary" href="<?php echo esc_url(rejuveta_get_page_url('our-work')); ?>"><?php echo esc_html(rejuveta_option('hero_primary', 'Explore Our Work')); ?></a>
            <a class="button button-secondary" href="<?php echo esc_url(rejuveta_get_page_url('get-involved')); ?>"><?php echo esc_html(rejuveta_option('hero_secondary', 'Join Our Mission')); ?></a>
        </div>
    </div>
</section>

<section class="section">
    <div class="container split">
        <div class="reveal">
            <p class="eyebrow">Who We Are</p>
            <h2><?php echo esc_html(rejuveta_option('about_title', 'About Organization')); ?></h2>
            <p><?php echo wp_kses_post(rejuveta_option('about_text', 'Rejuveta Heritage & Conservation is a new heritage care organization committed to preserving cultural identity through documentation, research, awareness, and community participation.')); ?></p>
            <p>We work to make heritage more visible, understandable, and protected so future generations can inherit living knowledge, not just old structures.</p>
            <a class="text-link" href="<?php echo esc_url(rejuveta_get_page_url('about-us')); ?>">Learn More</a>
        </div>
        <div class="stat-panel reveal">
            <div><strong>4</strong><span>Focus areas</span></div>
            <div><strong>12+</strong><span>Starter pages</span></div>
            <div><strong>100%</strong><span>Community centered</span></div>
        </div>
    </div>
</section>

<section class="section soft-section">
    <div class="container two-cards">
        <a class="info-card clickable-card reveal" href="<?php echo esc_url(rejuveta_get_page_url('blog/vision-blog')); ?>">
            <p class="eyebrow">Vision</p>
            <h2><?php echo esc_html(rejuveta_option('vision_title', 'Heritage Passed Forward')); ?></h2>
            <p><?php echo wp_kses_post(rejuveta_option('vision_text', 'To create a future where cultural heritage is preserved, appreciated, and passed on to generations to come.')); ?></p>
            <span class="card-action">Read heritage insights</span>
        </a>
        <a class="info-card clickable-card reveal" href="<?php echo esc_url(rejuveta_get_page_url('blog/mission-blog')); ?>">
            <p class="eyebrow">Mission</p>
            <h2><?php echo esc_html(rejuveta_option('mission_title', 'Awareness, Research, Action')); ?></h2>
            <p><?php echo wp_kses_post(rejuveta_option('mission_text', 'To promote awareness, documentation, research, and community participation in heritage conservation.')); ?></p>
            <span class="card-action">Visit the blog</span>
        </a>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-heading reveal">
            <p class="eyebrow">Our Focus Areas</p>
            <h2 class="typing-text" data-type-text="Practical Work for Lasting Conservation">Practical Work for Lasting Conservation</h2>
        </div>
        <div class="feature-grid">
            <?php
            $focus = rejuveta_get_managed_items('rejuveta_focus', array(
                array('title' => 'Heritage Documentation', 'text' => 'Recording sites, oral histories, architecture, maps, and historical evidence.', 'link' => rejuveta_get_page_url('blog/heritage-documentation-blog'), 'image' => 'https://images.unsplash.com/photo-1582972236019-ea4af5ffe587?auto=format&fit=crop&w=900&q=72'),
                array('title' => 'Heritage Research', 'text' => 'Encouraging field studies, local history projects, and knowledge sharing.', 'link' => rejuveta_get_page_url('blog/heritage-research-blog'), 'image' => 'https://images.unsplash.com/photo-1590077428593-a55bb07c4665?auto=format&fit=crop&w=900&q=72'),
                array('title' => 'Heritage Awareness', 'text' => 'Public programs, campaigns, and learning activities for wider participation.', 'link' => rejuveta_get_page_url('blog/heritage-awareness-blog'), 'image' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Charminar%20of%20Hyderabad%20Telangana.jpg?width=900'),
                array('title' => 'Community Engagement', 'text' => 'Involving citizens, youth, and institutions in preservation efforts.', 'link' => rejuveta_get_page_url('blog/community-engagement-blog'), 'image' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Konark%20Sun%20temple.jpg?width=900'),
            ), 4);
            foreach ($focus as $index => $item) :
                $icons = array(
                    '<svg viewBox="0 0 24 24"><path d="M6 3h9l3 3v15H6z"/><path d="M14 3v4h4"/><path d="M8.5 12h7"/><path d="M8.5 16h5"/></svg>',
                    '<svg viewBox="0 0 24 24"><circle cx="10.5" cy="10.5" r="5.5"/><path d="m15 15 4.5 4.5"/><path d="M8.2 10.5h4.6"/></svg>',
                    '<svg viewBox="0 0 24 24"><path d="M4 11v2a2 2 0 0 0 2 2h2l5 4V5l-5 4H6a2 2 0 0 0-2 2z"/><path d="M16.5 9.5a4 4 0 0 1 0 5"/><path d="M18.8 7.2a7.5 7.5 0 0 1 0 9.6"/></svg>',
                    '<svg viewBox="0 0 24 24"><circle cx="8" cy="8" r="3"/><circle cx="16" cy="8" r="3"/><path d="M3.5 19c.7-3 2.4-5 4.5-5s3.8 2 4.5 5"/><path d="M11.5 19c.7-3 2.4-5 4.5-5s3.8 2 4.5 5"/></svg>',
                );
                ?>
                <a class="feature-card reveal" href="<?php echo esc_url($item['link']); ?>">
                    <img src="<?php echo esc_url($item['image']); ?>" alt="<?php echo esc_attr($item['title']); ?>" loading="lazy" decoding="async">
                    <span class="feature-icon" aria-hidden="true"><?php echo $icons[$index % count($icons)]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
                    <h3><?php echo esc_html($item['title']); ?></h3>
                    <p><?php echo esc_html($item['text']); ?></p>
                    <strong class="card-action">Read full blog</strong>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section heritage-matters">
    <div class="container">
        <div class="section-heading reveal">
            <p class="eyebrow">Why Heritage Matters</p>
            <h2 class="typing-text" data-type-text="Culture Becomes Stronger When People Can See Their Own History">Culture Becomes Stronger When People Can See Their Own History</h2>
        </div>
        <div class="matter-list">
            <?php
            $matters = array(
                array('Cultural Identity', 'blog/cultural-identity-blog'),
                array('Historical Significance', 'blog/historical-significance-blog'),
                array('Education & Learning', 'blog/education-learning-blog'),
                array('Sustainable Tourism', 'blog/sustainable-tourism-blog'),
                array('Community Pride', 'blog/community-pride-blog'),
            );
            foreach ($matters as $matter) :
                ?>
                <a class="matter-item reveal" href="<?php echo esc_url(rejuveta_get_page_url($matter[1])); ?>"><?php echo esc_html($matter[0]); ?></a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section soft-section">
    <div class="container">
        <div class="section-heading reveal">
            <p class="eyebrow">Current Initiatives</p>
            <h2>Starting With Field-Based, Community-Led Action</h2>
        </div>
        <div class="card-grid">
            <?php
            $initiatives = rejuveta_get_managed_items('rejuveta_initiative', array(
                array('title' => 'Heritage Documentation Project', 'text' => 'Surveying and recording places, stories, and architectural details.', 'link' => rejuveta_get_page_url('projects/current-initiatives')),
                array('title' => 'Local Heritage Mapping', 'text' => 'Creating accessible maps of important local heritage assets.', 'link' => rejuveta_get_page_url('projects/current-initiatives')),
                array('title' => 'Heritage Awareness Campaign', 'text' => 'Building public understanding through outreach and events.', 'link' => rejuveta_get_page_url('projects/current-initiatives')),
                array('title' => 'Heritage Walk Program', 'text' => 'Helping people experience history through guided local walks.', 'link' => rejuveta_get_page_url('projects/heritage-walks')),
            ), 4);
            foreach ($initiatives as $initiative) :
                ?>
                <a class="plain-card reveal" href="<?php echo esc_url($initiative['link']); ?>">
                    <h3><?php echo esc_html($initiative['title']); ?></h3>
                    <p><?php echo esc_html($initiative['text']); ?></p>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-heading reveal">
            <p class="eyebrow">Featured Heritage Sites</p>
            <h2 class="typing-text" data-type-text="Places That Carry Memory, Craft, and Identity">Places That Carry Memory, Craft, and Identity</h2>
        </div>
        <div class="site-grid">
            <?php
            $sites = rejuveta_get_managed_items('rejuveta_site', array(
                array('image' => $images['site1'], 'title' => 'Historic Monument Precinct', 'text' => 'A landmark representing layered architecture, memory, and civic identity.', 'link' => rejuveta_get_page_url('blog/historic-monument-precinct-blog')),
                array('image' => $images['site2'], 'title' => 'Traditional Settlement Core', 'text' => 'A living neighborhood where built form, craft, and community life meet.', 'link' => rejuveta_get_page_url('blog/traditional-settlement-core-blog')),
                array('image' => $images['site3'], 'title' => 'Sacred Heritage Landscape', 'text' => 'A culturally significant site connected with rituals, stories, and local continuity.', 'link' => rejuveta_get_page_url('blog/sacred-heritage-landscape-blog')),
                array('image' => 'https://images.unsplash.com/photo-1582972236019-ea4af5ffe587?auto=format&fit=crop&w=900&q=72', 'title' => 'Historic Water System', 'text' => 'Traditional water structures reveal climate wisdom, engineering, and community life.', 'link' => rejuveta_get_page_url('blog/historic-water-system-blog')),
                array('image' => 'https://images.unsplash.com/photo-1590077428593-a55bb07c4665?auto=format&fit=crop&w=900&q=72', 'title' => 'Colonial Civic Building', 'text' => 'Public architecture that reflects administrative history and urban transformation.', 'link' => rejuveta_get_page_url('blog/colonial-civic-building-blog')),
                array('image' => 'https://images.unsplash.com/photo-1609947017136-9daf32a5eb16?auto=format&fit=crop&w=900&q=72', 'title' => 'Indian Craft & Market Street', 'text' => 'A living cultural corridor shaped by trade, craftsmanship, food, and daily rituals.', 'link' => rejuveta_get_page_url('blog/craft-market-street-blog')),
            ), 6);
            foreach ($sites as $site) :
                ?>
                <a class="site-card clickable-card reveal" href="<?php echo esc_url($site['link']); ?>">
                    <img src="<?php echo esc_url($site['image']); ?>" alt="<?php echo esc_attr($site['title']); ?>" loading="lazy" decoding="async">
                    <div>
                        <h3><?php echo esc_html($site['title']); ?></h3>
                        <p><?php echo esc_html($site['text']); ?></p>
                        <span class="card-action">Read site story</span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section soft-section">
    <div class="container">
        <div class="section-heading reveal">
            <p class="eyebrow">Gallery Preview</p>
            <h2>Heritage Sites, Events, Heritage Walks, and Community Activities</h2>
        </div>
        <div class="gallery-grid">
            <?php
            $gallery = array(
                array($images['gallery1'], 'Heritage Sites'),
                array($images['gallery2'], 'Indian Heritage Events'),
                array($images['gallery3'], 'Indian Heritage Walks'),
                array($images['gallery4'], 'Indian Community Activities'),
            );
            foreach ($gallery as $image) :
                ?>
                <a class="gallery-item reveal" href="<?php echo esc_url(rejuveta_get_page_url('gallery')); ?>">
                    <img src="<?php echo esc_url($image[0]); ?>" alt="<?php echo esc_attr($image[1]); ?>" loading="lazy" decoding="async">
                    <span><?php echo esc_html($image[1]); ?></span>
                </a>
            <?php endforeach; ?>
        </div>
        <a class="button button-primary centered-button" href="<?php echo esc_url(rejuveta_get_page_url('gallery')); ?>">View Full Gallery</a>
    </div>
</section>

<section class="section cta-section">
    <div class="container cta-inner reveal">
        <p class="eyebrow">Get Involved</p>
        <h2>Become a Heritage Guardian</h2>
        <p>Volunteer, become a member, or partner with us to preserve our shared cultural legacy.</p>
        <div class="button-row">
            <a class="button button-primary" href="<?php echo esc_url(rejuveta_get_page_url('get-involved')); ?>">Join Us Today</a>
            <a class="button button-secondary" href="<?php echo esc_url(rejuveta_get_page_url('get-involved/partner-with-us')); ?>">Partner With Us</a>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-heading reveal">
            <p class="eyebrow">News & Events</p>
            <h2>Latest News, Events, Workshops, and Campaigns</h2>
        </div>
        <div class="news-grid">
            <?php
            $news = rejuveta_get_managed_items('rejuveta_event', array(
                array('title' => 'Latest News', 'text' => 'Publish updates and announcements here as your programs begin.', 'link' => rejuveta_get_page_url('news-events')),
                array('title' => 'Upcoming Events', 'text' => 'Share heritage walks, talks, and community events.', 'link' => rejuveta_get_page_url('news-events')),
                array('title' => 'Workshops', 'text' => 'Add training sessions, documentation workshops, and school programs.', 'link' => rejuveta_get_page_url('news-events')),
                array('title' => 'Awareness Campaigns', 'text' => 'Promote public campaigns for heritage care and protection.', 'link' => rejuveta_get_page_url('news-events')),
            ), 4);
            foreach ($news as $item) :
                ?>
                <a class="plain-card reveal" href="<?php echo esc_url($item['link']); ?>">
                    <h3><?php echo esc_html($item['title']); ?></h3>
                    <p><?php echo esc_html($item['text']); ?></p>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section contact-band">
    <div class="container contact-layout">
        <div class="reveal">
            <p class="eyebrow">Contact Us</p>
            <h2>Start a Conversation About Heritage Care</h2>
            <p>Phone: <?php echo esc_html(rejuveta_option('phone', '+91 00000 00000')); ?></p>
            <p>Email: <?php echo esc_html(rejuveta_option('email', 'doonvalleyhighschool80@gmail.com')); ?></p>
            <p>Office Address: <?php echo wp_kses_post(rejuveta_option('address', 'Add your office address here')); ?></p>
            <div class="social-links">
                <a href="<?php echo esc_url(rejuveta_option('facebook', '#')); ?>" aria-label="Facebook">Facebook</a>
                <a href="<?php echo esc_url(rejuveta_option('instagram', '#')); ?>" aria-label="Instagram">Instagram</a>
                <a href="<?php echo esc_url(rejuveta_option('linkedin', '#')); ?>" aria-label="LinkedIn">LinkedIn</a>
            </div>
            <div class="map-box" aria-label="Google map placeholder"><?php echo rejuveta_option('map_embed') ? wp_kses_post(rejuveta_option('map_embed')) : 'Google Map Embed Area'; ?></div>
        </div>
        <div class="form-shell reveal">
            <?php echo do_shortcode('[rejuveta_contact_form]'); ?>
        </div>
    </div>
</section>

<?php
get_footer();
