<?php

/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header(); ?>

<div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo esc_url(get_theme_file_uri('images/ocean.jpg')); ?>)"></div>
    <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title">
            <?php
            if (is_category()) {
                echo get_the_archive_title();
                echo get_the_archive_description();
            }
            ?>
        </h1>

        <div class="page-banner__intro">
            <p><?php echo esc_html(get_the_archive_description()); ?></p>
        </div>
    </div>
</div>

<?php if (have_posts()) : ?>

    <header class="page-header alignwide">
        <?php the_archive_title('<h1 class="page-title">', '</h1>'); ?>
        <?php
        $description = get_the_archive_description();
        if ($description) : ?>
            <div class="archive-description"><?php echo wp_kses_post(wpautop($description)); ?></div>
        <?php endif; ?>
    </header><!-- .page-header -->

    <?php while (have_posts()) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <?php if (is_singular()) : ?>
                    <?php the_title('<h1 class="entry-title default-max-width">', '</h1>'); ?>
                <?php else : ?>
                    <?php the_title(sprintf('<h2 class="entry-title default-max-width"><a href="%s">', esc_url(get_permalink())), '</a></h2>'); ?>
                <?php endif; ?>

                <?php if (has_post_thumbnail()) : ?>
                    <div class="post-thumbnail">
                        <?php the_post_thumbnail('full'); // 'full' có thể thay bằng kích thước ảnh bạn muốn 
                        ?>
                    </div>
                <?php endif; ?>
            </header><!-- .entry-header -->

            <div class="entry-content">
                <?php the_excerpt(); ?>
                <?php wp_link_pages(array(
                    'before'   => '<nav class="page-links" aria-label="' . esc_attr__('Page', 'twentytwentyone') . '">',
                    'after'    => '</nav>',
                    'pagelink' => esc_html__('Page %', 'twentytwentyone'),
                )); ?>
            </div><!-- .entry-content -->

            <footer class="entry-footer default-max-width">
                <div class="entry-meta">
                    <?php
                    if ('post' === get_post_type()) :
                        // Display the post date and author.
                        echo '<span class="posted-on">' . esc_html(get_the_date()) . '</span>';
                        echo '<span class="byline"> by ' . esc_html(get_the_author()) . '</span>';
                    endif;

                    // Display categories and tags.
                    echo '<div class="cat-links">' . get_the_category_list(', ') . '</div>';
                    echo '<div class="tag-links">' . get_the_tag_list('', ', ') . '</div>';
                    ?>
                </div><!-- .entry-meta -->
            </footer><!-- .entry-footer -->
        </article><!-- #post-<?php the_ID(); ?> -->


    <?php endwhile; ?>

    <?php the_posts_navigation(); ?>

<?php else : ?>
    <?php get_template_part('template-parts/content/content-none'); ?>
<?php endif; ?>

<?php
get_footer();
