<?php get_header(); ?>

<?php
// Default background image
$banner_image = get_theme_file_uri('images/ocean.jpg');

// Check if there are posts
if (have_posts()) {
    // Get the first post to set the banner image
    the_post();
    // Check if the post has a featured image
    if (has_post_thumbnail()) {
        $banner_image = get_the_post_thumbnail_url(get_the_ID(), 'full');
    }
    // Rewind post data
    rewind_posts();
}
?>

<!-- Page Banner -->
<div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url('<?php echo esc_url($banner_image); ?>');"></div>
    <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php single_term_title(); ?></h1>
        <p class="author-name" style="font-size: 14px; margin-top: 5px; color: white;">
            <?php
            // Display author if applicable
            if (is_author()) {
                echo get_the_author();
            }
            ?>
        </p>
    </div>
</div>

<div class="archive-event container container--narrow">
    <?php if (have_posts()) : ?>

        <header class="page-header">
            <?php
            $description = get_the_archive_description();
            if ($description) : ?>
                <div class="archive-description"><?php echo wp_kses_post(wpautop($description)); ?></div>
            <?php endif; ?>
        </header><!-- .page-header -->

        <?php while (have_posts()) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class('event-item'); ?>>
                <header class="entry-header">
                    <?php the_title(sprintf('<h2 class="entry-title"><a href="%s">', esc_url(get_permalink())), '</a></h2>'); ?>
                    <!-- Removed post thumbnail from here -->
                </header><!-- .entry-header -->

                <div class="entry-content">
                    <ul class="event-details">
                        <li><strong>Date:</strong> <?php echo esc_html(get_post_meta(get_the_ID(), 'event_date', true)); ?></li>
                        <li><strong>Location:</strong> <?php echo esc_html(get_post_meta(get_the_ID(), 'event_location', true)); ?></li>
                        <li><strong>Time:</strong> <?php echo esc_html(get_post_meta(get_the_ID(), 'event_time', true)); ?></li>
                    </ul>
                </div><!-- .entry-content -->

                <footer class="entry-footer">
                    <?php
                    // Pagination or additional meta information
                    the_posts_navigation();
                    ?>
                </footer><!-- .entry-footer -->
            </article><!-- #post-<?php the_ID(); ?> -->

        <?php endwhile; ?>

        <?php
        // Pagination or additional meta information
        the_posts_navigation();
        ?>
        

    <?php else : ?>
        <?php get_template_part('template-parts/content/content-none'); ?>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
