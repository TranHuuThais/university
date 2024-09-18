<?php get_header(); ?>

<div class="single-event">
    <?php while (have_posts()) : the_post(); ?>
        <div class="page-banner">
            <?php
            // Get the featured image URL or fallback to a default image
            $banner_image_url = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'full') : esc_url(get_theme_file_uri('images/ocean.jpg'));
            ?>
            <div class="page-banner__bg-image" style="background-image: url('<?php echo esc_url($banner_image_url); ?>');"></div>
            <div class="page-banner__content container container--narrow">
                <h1 class="page-banner__title"><?php the_title(); ?></h1>
                <p class="author-name" style="font-size: 14px; margin-top: 5px; color: white;">
                    <?php the_author(); ?>
                </p>
            </div>
        </div>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                <!-- Removed the_post_thumbnail() from here -->
            </header><!-- .entry-header -->

            <div class="entry-content">
                <?php the_content(); ?>

                <ul class="event-details">
                    <li><strong>Date:</strong> <?php echo esc_html(get_post_meta(get_the_ID(), 'event_date', true)); ?></li>
                    <li><strong>Location:</strong> <?php echo esc_html(get_post_meta(get_the_ID(), 'event_location', true)); ?></li>
                    <li><strong>Time:</strong> <?php echo esc_html(get_post_meta(get_the_ID(), 'event_time', true)); ?></li>
                </ul>

                <?php wp_link_pages(); ?>
            </div><!-- .entry-content -->

            <footer class="entry-footer">
                <p><?php echo sprintf(__('Posted on %s', 'themeUniversity'), get_the_date()); ?></p>
            </footer><!-- .entry-footer -->
        </article><!-- #post-<?php the_ID(); ?> -->

    <?php endwhile; ?>
</div>

<?php get_footer(); ?>