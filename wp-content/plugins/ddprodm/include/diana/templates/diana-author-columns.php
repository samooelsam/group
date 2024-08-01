<?php get_header(); ?>
    <div id="main-content">
    <div class="entry-content">
    <div class="et_pb_section" class="clearfix">
    <div class="et_pb_row">
    <div id="author-info">
        <div id="author-img"><?php echo get_avatar(get_the_author_meta('email'), 270); ?></div>
        <div id="author_info_text">
            <h2 id="author-name"><?php esc_html_e(get_the_author_meta('display_name'));?></h2>
            <p id="author-desc"><?php esc_html_e(get_the_author_meta('user_description')); ?></p>
        </div>

    </div>
        <h2 id="author-name-posts"><?php esc_html_e(get_the_author_meta('display_name'));?>'s Latest Posts</h2>
    <div class='et_pb_posts et_pb_blog_0'>

        <?php
        if ( have_posts() ) :
            while ( have_posts() ) : the_post();
                $post_format = et_pb_post_format(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class( 'et_pb_post' ); ?>>

                    <?php
                    $thumb = '';

                    $width = (int) apply_filters( 'et_pb_index_blog_image_width', 1080 );

                    $height = (int) apply_filters( 'et_pb_index_blog_image_height', 675 );
                    $classtext = 'et_pb_post_main_image';
                    $titletext = get_the_title();
                    $thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Blogimage' );
                    $thumb = $thumbnail["thumb"];

                    et_divi_post_format_content();

                    if ( ! in_array( $post_format, array( 'link', 'audio', 'quote' ) ) ) {
                        if ( 'video' === $post_format && false !== ( $first_video = et_get_first_video() ) ) :
                            printf(
                                '<div class="et_main_video_container">
                  %1$s
                </div>',
                                et_core_esc_previously($first_video)
                            );
                        elseif ( ! in_array( $post_format, array( 'gallery' ) ) && 'on' === et_get_option( 'divi_thumbnails_index', 'on' ) && '' !== $thumb ) : ?>
                            <a class="entry-featured-image-url" href="<?php the_permalink(); ?>">
                                <?php print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height ); ?>
                            </a>
                            <?php
                        elseif ( 'gallery' === $post_format ) :
                            et_pb_gallery_images();
                        endif;
                    } ?>

                    <?php if ( ! in_array( $post_format, array( 'link', 'audio', 'quote' ) ) ) : ?>
                        <?php if ( ! in_array( $post_format, array( 'link', 'audio' ) ) ) : ?>
                            <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <?php endif; ?>

                        <?php
                          et_divi_post_meta();

                          ?><div class="post_content"> <?php

                        if ( 'on' !== et_get_option( 'divi_blog_style', 'false' ) || ( is_search() && ( 'on' === get_post_meta( get_the_ID(), '_et_pb_use_builder', true ) ) ) ) {
                            truncate_post( 270 );
                        } else {
                            the_content();
                        }
                        ?>
                       </div>
                        <a href="<?php the_permalink(); ?>" class="more-link">read more</a>
                    <?php endif; ?>

                </article> <!-- .et_pb_post -->
                <?php
            endwhile;

            if ( function_exists( 'wp_pagenavi' ) )
                wp_pagenavi();
            else
                get_template_part( 'includes/navigation', 'index' );
        else :
            get_template_part( 'includes/no-results', 'index' );
        endif;
        ?>
    </div> <!-- #left-area -->
    </div>
    </div>
    </div>
    </div>

<?php get_footer(); ?>