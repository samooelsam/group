<?php get_header(); ?>

    <div id="main-content">
        <div class="entry-content"><?php

            function diana_replace_category_content($content) {

                $category_name = __("You've Searched for ''", 'ddprodm') .get_search_query(). "''" ;
                $category_descr = category_description();
                $content = str_replace('Archive Page Title - PHP Template', $category_name, $content);
                $content = str_replace('Category Name', $category_name, $content);
                $content = str_replace('Archive Page Description for PHP Template', $category_descr, $content);
               // $content = str_replace('<p></p>', '', $content);
                return $content;
            }

            // SIDEBAR

            $args = array(
                'post_type' => 'et_pb_layout',
                'title' => 'Search - Row w Sidebar - PHP Templ - Diana',
                'post_status' => 'publish');

            $my_query = new WP_Query($args);

            if ($my_query->have_posts()) {
                while ($my_query->have_posts()) : $my_query->the_post();
                    add_filter('the_content','diana_replace_category_content');
                    remove_filter('the_content', 'wpautop');
                    the_content();
                endwhile;
            }

            remove_filter('the_content','diana_replace_tag_content');

            wp_reset_query();  // Restore global post data stomped by the_post()

            ?>
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


                                ?><div class="post-content"><?php
                                if ( 'on' !== et_get_option( 'divi_blog_style', 'false' ) || ( is_search() && ( 'on' === get_post_meta( get_the_ID(), '_et_pb_use_builder', true ) ) ) ) {
                                    truncate_post( 270 );
                                } else {
                                    the_content();
                                }
                                ?></div><?php
                                ?>
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
        </div><!-- entry-content -->
    </div> <!-- #main-content -->
    <script type="text/javascript">
        (function($) {
            $('.et_pb_posts').insertAfter('#diana-tag-content .et_pb_promo')
        })(jQuery);
    </script>
<?php get_footer(); ?>