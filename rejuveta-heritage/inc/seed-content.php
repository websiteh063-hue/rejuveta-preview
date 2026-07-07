<?php
/**
 * Creates starter pages and menus for first activation.
 *
 * @package RejuvetaHeritage
 */

if (!defined('ABSPATH')) {
    exit;
}

function rejuveta_create_page($title, $slug, $content = '', $parent_id = 0, $template = '') {
    $existing = get_page_by_path($slug);
    if ($existing) {
        return (int) $existing->ID;
    }

    $page_id = wp_insert_post(array(
        'post_title'   => $title,
        'post_name'    => basename($slug),
        'post_content' => $content,
        'post_status'  => 'publish',
        'post_type'    => 'page',
        'post_parent'  => $parent_id,
    ));

    if (!is_wp_error($page_id) && $template) {
        update_post_meta($page_id, '_wp_page_template', $template);
    }

    return (int) $page_id;
}

function rejuveta_seed_content() {
    if (defined('REJUVETA_SKIP_SEED') && REJUVETA_SKIP_SEED) {
        return;
    }

    $pages = array();

    $pages['home'] = rejuveta_create_page('Home', 'home', '', 0, 'front-page.php');

    $pages['about-us'] = rejuveta_create_page('About Us', 'about-us', '<h2>Who We Are</h2><p>Rejuveta Heritage & Conservation is dedicated to documenting, promoting, and safeguarding cultural and historical heritage for future generations.</p><p>We exist to help communities identify, record, understand, and protect the heritage around them. Our first phase focuses on documentation, awareness, research, education, and community participation.</p><h2>Why We Exist</h2><p>Many historic places, cultural practices, local stories, traditional buildings, and community memories remain outside formal records. Our organization bridges that gap through field documentation, public awareness, research, and citizen participation.</p><h2>Our Approach</h2><p>We identify and document heritage, study and interpret its meaning, educate the public, engage communities, and build partnerships for long-term care.</p><h2>Who We Serve</h2><p>Our work supports students, educators, researchers, local communities, civic groups, cultural organizations, tourism stakeholders, and institutions interested in preserving history with public participation.</p><h2>What We Stand For</h2><p>Authenticity, community partnership, education, responsibility, and long-term care guide our work.</p>');
    rejuveta_create_page('Our Story', 'about-us/our-story', '<h2>Our Story</h2><p>We began with a simple belief: heritage survives when communities understand, document, and care for it.</p><p>Many historic places, cultural practices, local stories, traditional buildings, and community memories remain outside formal records. Rejuveta Heritage & Conservation aims to bridge that gap through field documentation, awareness, research, and citizen participation.</p>', $pages['about-us']);
    rejuveta_create_page('Vision & Mission', 'about-us/vision-mission', '<h2>Vision</h2><p>To create a future where cultural heritage is preserved, appreciated, and passed on to generations to come.</p><h2>Mission</h2><p>To promote awareness, documentation, research, and community participation in heritage conservation.</p>', $pages['about-us']);
    rejuveta_create_page('Our Team', 'about-us/our-team', '<h2>Our Team</h2><p>Add founder, volunteer, researcher, and advisor profiles here as the organization grows.</p>', $pages['about-us']);

    $pages['our-work'] = rejuveta_create_page('Our Work', 'our-work', '<h2>Our Work</h2><p>Our work focuses on documentation, awareness, research, and community participation.</p>');
    rejuveta_create_page('Heritage Documentation', 'our-work/heritage-documentation', '<h2>Heritage Documentation</h2><p>Recording sites, stories, architecture, oral histories, maps, and local knowledge.</p>', $pages['our-work']);
    rejuveta_create_page('Awareness & Education', 'our-work/awareness-education', '<h2>Awareness & Education</h2><p>Workshops, campaigns, school programs, and public learning activities.</p>', $pages['our-work']);
    rejuveta_create_page('Research', 'our-work/research', '<h2>Research</h2><p>Studies, reports, field notes, and knowledge resources for heritage conservation.</p>', $pages['our-work']);
    rejuveta_create_page('Community Engagement', 'our-work/community-engagement', '<h2>Community Engagement</h2><p>Working with residents, youth, institutions, and local leaders to protect heritage.</p>', $pages['our-work']);

    $pages['heritage-hub'] = rejuveta_create_page('Heritage Hub', 'heritage-hub', '<h2>Heritage Hub</h2><p>Explore heritage sites, articles, and conservation resources.</p>');
    rejuveta_create_page('Heritage Sites', 'heritage-hub/heritage-sites', '<h2>Heritage Sites</h2><p>Build a growing directory of heritage places with images, histories, and importance.</p>', $pages['heritage-hub']);
    rejuveta_create_page('Articles', 'heritage-hub/articles', '<h2>Articles</h2><p>Publish heritage stories, research updates, and conservation insights here.</p>', $pages['heritage-hub']);
    rejuveta_create_page('Resources', 'heritage-hub/resources', '<h2>Resources</h2><p>Add downloadable guides, checklists, reports, and FAQs.</p>', $pages['heritage-hub']);

    $pages['blog'] = rejuveta_create_page('Blog', 'blog', '<h2>Blog</h2><p>Read separate articles about our vision, mission, heritage documentation, awareness, research, community engagement, initiatives, sites, events, and campaigns.</p>');
    rejuveta_create_page('Vision Blog', 'blog/vision-blog', '<h2>Heritage Passed Forward</h2><p>Our vision is to create a future where cultural heritage is preserved, appreciated, and passed on to generations to come. Heritage should remain a living responsibility shared by communities, institutions, and future generations.</p><p>Rejuveta Heritage & Conservation believes monuments, traditional settlements, oral histories, rituals, crafts, archives, and cultural landscapes form the identity of a place.</p>', $pages['blog']);
    rejuveta_create_page('Mission Blog', 'blog/mission-blog', '<h2>Awareness, Research, Action</h2><p>Our mission is to promote awareness, documentation, research, and community participation in heritage conservation.</p><p>We aim to document heritage sites, encourage historical research, organize awareness programs, support educational activities, and involve volunteers in field-based conservation work.</p>', $pages['blog']);
    rejuveta_create_page('Heritage Documentation Blog', 'blog/heritage-documentation-blog', '<h2>Recording Heritage Before It Disappears</h2><p>Documentation is the first step in conservation. It creates records of places, stories, architecture, maps, traditions, and community memories before they are lost.</p><p><a href="' . esc_url(home_url('/#work')) . '">Back to Our Focus Areas</a></p>', $pages['blog']);
    rejuveta_create_page('Heritage Awareness Blog', 'blog/heritage-awareness-blog', '<h2>Helping People Understand Heritage Value</h2><p>Heritage survives when people understand its value. Awareness programs help students, residents, local groups, and visitors see heritage as a shared asset.</p><p><a href="' . esc_url(home_url('/#work')) . '">Back to Our Focus Areas</a></p>', $pages['blog']);
    rejuveta_create_page('Heritage Research Blog', 'blog/heritage-research-blog', '<h2>Research That Connects Evidence and Community Memory</h2><p>Research gives depth to conservation work through archives, field observation, oral histories, maps, literature review, and local knowledge.</p><p><a href="' . esc_url(home_url('/#work')) . '">Back to Our Focus Areas</a></p>', $pages['blog']);
    rejuveta_create_page('Community Engagement Blog', 'blog/community-engagement-blog', '<h2>Conservation Works Better With People</h2><p>Communities are the first guardians of heritage. Their memories, daily practices, and emotional connection to place are essential for meaningful conservation.</p><p><a href="' . esc_url(home_url('/#work')) . '">Back to Our Focus Areas</a></p>', $pages['blog']);
    rejuveta_create_page('Cultural Identity Blog', 'blog/cultural-identity-blog', '<h2>Cultural Identity</h2><p>Cultural heritage gives people a sense of belonging. Languages, rituals, buildings, food traditions, festivals, crafts, and local stories help communities understand their roots and recognize what makes their place unique.</p><p>When cultural identity is documented and respected, younger generations can connect with their history in a confident and meaningful way.</p>', $pages['blog']);
    rejuveta_create_page('Historical Significance Blog', 'blog/historical-significance-blog', '<h2>Historical Significance</h2><p>Heritage sites are evidence of how societies lived, built, traded, worshipped, learned, and adapted over time. They help us read history through real places instead of only through books.</p><p>Protecting historically significant places allows communities to preserve facts, memories, and lessons that can guide future decisions.</p>', $pages['blog']);
    rejuveta_create_page('Education & Learning Blog', 'blog/education-learning-blog', '<h2>Education & Learning</h2><p>Heritage is a powerful classroom. Students can learn history, geography, art, architecture, environment, language, and social values through direct engagement with heritage places and stories.</p><p>Educational programs, walks, and documentation activities make learning active, local, and memorable.</p>', $pages['blog']);
    rejuveta_create_page('Sustainable Tourism Blog', 'blog/sustainable-tourism-blog', '<h2>Sustainable Tourism</h2><p>Well-managed heritage tourism can support local livelihoods, encourage restoration, and bring wider attention to historic places without damaging their cultural value.</p><p>Sustainable tourism should respect residents, protect the site, communicate accurate history, and create benefits for the local community.</p>', $pages['blog']);
    rejuveta_create_page('Community Pride Blog', 'blog/community-pride-blog', '<h2>Community Pride</h2><p>When people know the value of their local heritage, they feel proud of their surroundings and become more willing to care for them.</p><p>Community pride can inspire volunteer action, local storytelling, cleanliness drives, school participation, and stronger support for conservation work.</p>', $pages['blog']);
    rejuveta_create_page('Current Initiatives Blog', 'blog/current-initiatives-blog', '<h2>Starting With Practical Field Work</h2><p>Current initiatives can include documentation projects, local heritage mapping, awareness campaigns, heritage walks, and community programs.</p>', $pages['blog']);
    rejuveta_create_page('Featured Heritage Sites Blog', 'blog/featured-heritage-sites-blog', '<h2>Places That Carry Memory</h2><p>Featured heritage sites can include monuments, historic neighborhoods, sacred landscapes, public buildings, cultural routes, and places connected with local stories.</p>', $pages['blog']);
    rejuveta_create_page('Historic Monument Precinct Blog', 'blog/historic-monument-precinct-blog', '<h2>Historic Monument Precinct</h2><p>A historic monument precinct often represents multiple layers of architecture, patronage, public memory, and civic identity. Such places hold evidence of craftsmanship, planning, materials, rituals, and changing social life.</p>', $pages['blog']);
    rejuveta_create_page('Traditional Settlement Core Blog', 'blog/traditional-settlement-core-blog', '<h2>Traditional Settlement Core</h2><p>Traditional settlement cores are living heritage areas where streets, houses, courtyards, religious spaces, markets, and community practices continue to shape everyday life.</p>', $pages['blog']);
    rejuveta_create_page('Sacred Heritage Landscape Blog', 'blog/sacred-heritage-landscape-blog', '<h2>Sacred Heritage Landscape</h2><p>Sacred heritage landscapes connect natural features, built spaces, rituals, oral traditions, pilgrimage routes, and community belief systems.</p>', $pages['blog']);
    rejuveta_create_page('Historic Water System Blog', 'blog/historic-water-system-blog', '<h2>Historic Water System</h2><p>Stepwells, tanks, canals, ponds, wells, and traditional drainage systems show how earlier communities responded to climate, geography, and public needs through thoughtful engineering.</p>', $pages['blog']);
    rejuveta_create_page('Colonial Civic Building Blog', 'blog/colonial-civic-building-blog', '<h2>Colonial Civic Building</h2><p>Colonial civic buildings can reveal how cities changed through administration, education, transport, law, communication, and public institutions.</p>', $pages['blog']);
    rejuveta_create_page('Craft & Market Street Blog', 'blog/craft-market-street-blog', '<h2>Craft & Market Street</h2><p>Historic craft and market streets are living cultural corridors. They hold stories of trade, food, skill, migration, social exchange, and local identity.</p>', $pages['blog']);
    rejuveta_create_page('Gallery Blog', 'blog/gallery-blog', '<h2>Visual Documentation as Public Memory</h2><p>The gallery helps visitors see heritage sites, events, walks, and community activities. Strong visuals make conservation more relatable and shareable.</p>', $pages['blog']);
    rejuveta_create_page('Get Involved Blog', 'blog/get-involved-blog', '<h2>Become a Heritage Guardian</h2><p>People can support the mission by volunteering, becoming members, joining heritage walks, contributing research, helping with documentation, or partnering with the organization.</p>', $pages['blog']);
    rejuveta_create_page('News & Events Blog', 'blog/news-events-blog', '<h2>Updates, Events, Workshops, and Campaigns</h2><p>Use this page for announcements, project milestones, upcoming events, workshops, awareness campaigns, and organization updates.</p>', $pages['blog']);

    $pages['projects'] = rejuveta_create_page('Projects', 'projects', '<h2>Projects</h2><p>Current initiatives, heritage walks, and community programs.</p>');
    rejuveta_create_page('Current Initiatives', 'projects/current-initiatives', '<h2>Current Initiatives</h2><p>Share active surveys, mapping work, documentation projects, and awareness campaigns.</p>', $pages['projects']);
    rejuveta_create_page('Heritage Walks', 'projects/heritage-walks', '<h2>Heritage Walks</h2><p>Promote guided heritage walks and local learning routes.</p>', $pages['projects']);
    rejuveta_create_page('Community Programs', 'projects/community-programs', '<h2>Community Programs</h2><p>Highlight citizen participation, student programs, and local partnerships.</p>', $pages['projects']);

    $pages['gallery'] = rejuveta_create_page('Gallery', 'gallery', '<h2>Gallery</h2><p>Showcase heritage sites, events, heritage walks, and community activities. Filter by category and click any image to open a larger view.</p>[rejuveta_gallery]');

    $pages['get-involved'] = rejuveta_create_page('Get Involved', 'get-involved', '<h2>Become a Heritage Guardian</h2><p>Volunteer, become a member, or partner with us to preserve our shared cultural legacy.</p>');
    rejuveta_create_page('Volunteer', 'get-involved/volunteer', '<h2>Volunteer</h2><p>Join documentation drives, events, awareness campaigns, and community programs.</p>', $pages['get-involved']);
    rejuveta_create_page('Become a Member', 'get-involved/become-a-member', '<h2>Become a Member</h2><p>Support heritage care through active membership and participation.</p>', $pages['get-involved']);
    rejuveta_create_page('Partner With Us', 'get-involved/partner-with-us', '<h2>Partner With Us</h2><p>We welcome collaborations with institutions, NGOs, cultural organizations, and community groups.</p>', $pages['get-involved']);

    $pages['news-events'] = rejuveta_create_page('News & Events', 'news-events', '<h2>News & Events</h2><p>Latest news, upcoming events, workshops, and awareness campaigns.</p>[rejuveta_news_events]');
    $pages['contact-us'] = rejuveta_create_page('Contact Us', 'contact-us', '<h2>Contact Us</h2><p>Use the form below to reach Rejuveta Heritage & Conservation.</p>[rejuveta_contact_form]');

    update_option('show_on_front', 'page');
    update_option('page_on_front', $pages['home']);
    update_option('blogname', 'Rejuveta Heritage & Conservation');
    update_option('blogdescription', 'Reviving Heritage. Preserving Legacy.');

    $menu_name = 'Rejuveta Primary Menu';
    $menu_id = wp_get_nav_menu_object($menu_name);
    if (!$menu_id) {
        $menu_id = wp_create_nav_menu($menu_name);
    } else {
        $menu_id = $menu_id->term_id;
    }

    if (empty(wp_get_nav_menu_items($menu_id))) {
        $menu_items = array(
            'home' => array('Home', $pages['home'], 0),
            'about-us' => array('About Us', $pages['about-us'], 0),
            'our-story' => array('Our Story', get_page_by_path('about-us/our-story')->ID, 'about-us'),
            'vision-mission' => array('Vision & Mission', get_page_by_path('about-us/vision-mission')->ID, 'about-us'),
            'our-team' => array('Our Team', get_page_by_path('about-us/our-team')->ID, 'about-us'),
            'our-work' => array('Our Work', $pages['our-work'], 0),
            'heritage-documentation' => array('Heritage Documentation', get_page_by_path('our-work/heritage-documentation')->ID, 'our-work'),
            'awareness-education' => array('Awareness & Education', get_page_by_path('our-work/awareness-education')->ID, 'our-work'),
            'research' => array('Research', get_page_by_path('our-work/research')->ID, 'our-work'),
            'community-engagement' => array('Community Engagement', get_page_by_path('our-work/community-engagement')->ID, 'our-work'),
        'heritage-hub' => array('Heritage Hub', $pages['heritage-hub'], 0),
        'heritage-sites' => array('Heritage Sites', get_page_by_path('heritage-hub/heritage-sites')->ID, 'heritage-hub'),
        'articles' => array('Articles', get_page_by_path('heritage-hub/articles')->ID, 'heritage-hub'),
        'resources' => array('Resources', get_page_by_path('heritage-hub/resources')->ID, 'heritage-hub'),
        'blog' => array('Blog', $pages['blog'], 0),
        'vision-blog' => array('Vision Blog', get_page_by_path('blog/vision-blog')->ID, 'blog'),
        'mission-blog' => array('Mission Blog', get_page_by_path('blog/mission-blog')->ID, 'blog'),
        'documentation-blog' => array('Documentation Blog', get_page_by_path('blog/heritage-documentation-blog')->ID, 'blog'),
        'awareness-blog' => array('Awareness Blog', get_page_by_path('blog/heritage-awareness-blog')->ID, 'blog'),
        'research-blog' => array('Research Blog', get_page_by_path('blog/heritage-research-blog')->ID, 'blog'),
        'community-blog' => array('Community Blog', get_page_by_path('blog/community-engagement-blog')->ID, 'blog'),
        'cultural-identity-blog' => array('Cultural Identity', get_page_by_path('blog/cultural-identity-blog')->ID, 'blog'),
        'historical-significance-blog' => array('Historical Significance', get_page_by_path('blog/historical-significance-blog')->ID, 'blog'),
        'education-learning-blog' => array('Education & Learning', get_page_by_path('blog/education-learning-blog')->ID, 'blog'),
        'sustainable-tourism-blog' => array('Sustainable Tourism', get_page_by_path('blog/sustainable-tourism-blog')->ID, 'blog'),
        'community-pride-blog' => array('Community Pride', get_page_by_path('blog/community-pride-blog')->ID, 'blog'),
        'projects' => array('Projects', $pages['projects'], 0),
            'current-initiatives' => array('Current Initiatives', get_page_by_path('projects/current-initiatives')->ID, 'projects'),
            'heritage-walks' => array('Heritage Walks', get_page_by_path('projects/heritage-walks')->ID, 'projects'),
            'community-programs' => array('Community Programs', get_page_by_path('projects/community-programs')->ID, 'projects'),
            'gallery' => array('Gallery', $pages['gallery'], 0),
            'get-involved' => array('Get Involved', $pages['get-involved'], 0),
            'volunteer' => array('Volunteer', get_page_by_path('get-involved/volunteer')->ID, 'get-involved'),
            'become-a-member' => array('Become a Member', get_page_by_path('get-involved/become-a-member')->ID, 'get-involved'),
            'partner-with-us' => array('Partner With Us', get_page_by_path('get-involved/partner-with-us')->ID, 'get-involved'),
            'news-events' => array('News & Events', $pages['news-events'], 0),
            'contact-us' => array('Contact Us', $pages['contact-us'], 0),
        );

        $created = array();
        foreach ($menu_items as $key => $item) {
            $parent_menu_id = $item[2] && isset($created[$item[2]]) ? $created[$item[2]] : 0;
            $created[$key] = wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title'     => $item[0],
                'menu-item-object-id' => $item[1],
                'menu-item-object'    => 'page',
                'menu-item-type'      => 'post_type',
                'menu-item-status'    => 'publish',
                'menu-item-parent-id' => $parent_menu_id,
            ));
        }
    }

    $locations = get_theme_mod('nav_menu_locations');
    $locations['primary'] = $menu_id;
    $locations['footer'] = $menu_id;
    set_theme_mod('nav_menu_locations', $locations);
}
add_action('after_switch_theme', 'rejuveta_seed_content');
