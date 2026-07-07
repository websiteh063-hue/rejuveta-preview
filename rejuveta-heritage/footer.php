<?php
/**
 * Site footer.
 *
 * @package RejuvetaHeritage
 */
?>
</main>
<footer class="site-footer">
    <div class="container footer-grid">
        <div>
            <h2>Rejuveta Heritage & Conservation</h2>
            <p>Reviving Heritage. Preserving Legacy.</p>
            <p><?php echo wp_kses_post(rejuveta_option('footer_text', 'Dedicated to documenting, promoting, and safeguarding cultural and historical heritage for future generations.')); ?></p>
        </div>
        <div>
            <h3>Quick Links</h3>
            <a href="<?php echo esc_url(rejuveta_get_page_url('about-us')); ?>">About Us</a>
            <a href="<?php echo esc_url(rejuveta_get_page_url('our-work')); ?>">Our Work</a>
            <a href="<?php echo esc_url(rejuveta_get_page_url('projects')); ?>">Projects</a>
            <a href="<?php echo esc_url(rejuveta_get_page_url('gallery')); ?>">Gallery</a>
            <a href="<?php echo esc_url(rejuveta_get_page_url('news-events')); ?>">News & Events</a>
            <a href="<?php echo esc_url(rejuveta_get_page_url('contact-us')); ?>">Contact Us</a>
        </div>
        <div>
            <h3>Get Involved</h3>
            <a href="<?php echo esc_url(rejuveta_get_page_url('get-involved/volunteer')); ?>">Volunteer</a>
            <a href="<?php echo esc_url(rejuveta_get_page_url('get-involved/become-a-member')); ?>">Membership</a>
            <a href="<?php echo esc_url(rejuveta_get_page_url('get-involved/partner-with-us')); ?>">Partnerships</a>
            <h3>Resources</h3>
            <a href="<?php echo esc_url(rejuveta_get_page_url('heritage-hub/articles')); ?>">Articles</a>
            <a href="<?php echo esc_url(rejuveta_get_page_url('heritage-hub/heritage-sites')); ?>">Heritage Sites</a>
            <a href="<?php echo esc_url(rejuveta_get_page_url('heritage-hub/resources')); ?>">Downloads</a>
        </div>
        <div>
            <h3>Contact Information</h3>
            <p>Phone: <?php echo esc_html(rejuveta_option('phone', '+91 00000 00000')); ?></p>
            <p>Email: <?php echo esc_html(rejuveta_option('email', 'doonvalleyhighschool80@gmail.com')); ?></p>
            <p>Address: <?php echo wp_kses_post(rejuveta_option('address', 'Add your office address here')); ?></p>
            <h3>Newsletter Signup</h3>
            <?php echo do_shortcode('[rejuveta_newsletter]'); ?>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <p>Copyright &copy; <?php echo esc_html(date('Y')); ?> Rejuveta Heritage & Conservation. All Rights Reserved.</p>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
