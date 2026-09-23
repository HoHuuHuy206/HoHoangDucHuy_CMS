<?php get_header(); ?>

<main class="single-page">

    <?php if (have_posts()) : ?>

        <?php while (have_posts()) : the_post(); ?>

            <article class="single-post">

                <!-- =====================================
                     POST HEADER
                ====================================== -->

                <header class="single-post-header">

                    <h1 class="single-post-title">
                        <?php the_title(); ?>
                    </h1>


                    <!-- DATE -->
                    <div class="single-post-date">

                        <div class="single-date-day">
                            <?php echo get_the_date('d'); ?>
                        </div>

                        <div class="single-date-month">
                            <?php echo get_the_date('m'); ?>
                        </div>

                        <div class="single-date-year">
                            '<?php echo get_the_date('y'); ?>
                        </div>

                    </div>

                </header>


                <!-- =====================================
                     DIVIDER
                ====================================== -->

                <div class="single-divider">

                    <span></span>

                </div>


                <!-- =====================================
                     POST CONTENT
                ====================================== -->

                <div class="single-post-content">

                    <?php the_content(); ?>

                </div>


                <!-- =====================================
                     SOURCE
                ====================================== -->

                <div class="single-post-source">
                    (Theo Người Lao Động)
                </div>



                <!-- =====================================
                     MODULE (7) - PREVIOUS / NEXT (TÍCH HỢP SQL $wpdb)
                ====================================== -->
                <?php
                global $wpdb;
                $current_post_date = get_the_date('Y-m-d H:i:s');

                // 1. SQL: Lấy bài viết trước (cũ hơn bài hiện tại)
                $previous_post = $wpdb->get_row($wpdb->prepare("
                    SELECT ID, post_title, post_date 
                    FROM {$wpdb->posts} 
                    WHERE post_date < %s 
                      AND post_type = 'post' 
                      AND post_status = 'publish' 
                    ORDER BY post_date DESC 
                    LIMIT 1
                ", $current_post_date));

                // 2. SQL: Lấy bài viết tiếp theo (mới hơn bài hiện tại)
                $next_post = $wpdb->get_row($wpdb->prepare("
                    SELECT ID, post_title, post_date 
                    FROM {$wpdb->posts} 
                    WHERE post_date > %s 
                      AND post_type = 'post' 
                      AND post_status = 'publish' 
                    ORDER BY post_date ASC 
                    LIMIT 1
                ", $current_post_date));
                ?>

                <?php if ($previous_post || $next_post) : ?>

                    <nav class="post-navigation" aria-label="Post navigation">

                        <!-- =================================
                             PREVIOUS POST (SQL $wpdb)
                        ================================== -->
                        <?php if ($previous_post) : 
                            $prev_time = strtotime($previous_post->post_date);
                        ?>

                            <div class="post-nav-item">

                                <div class="post-nav-date">

                                    <div class="post-nav-day">
                                        <?php echo esc_html(date_i18n('d', $prev_time)); ?>
                                    </div>

                                    <div class="post-nav-month">
                                        <?php echo esc_html(date_i18n('m', $prev_time)); ?>
                                    </div>

                                    <div class="post-nav-year">
                                        '<?php echo esc_html(date_i18n('y', $prev_time)); ?>
                                    </div>

                                </div>


                                <div class="post-nav-title">

                                    <a href="<?php echo esc_url(get_permalink($previous_post->ID)); ?>">
                                        <?php echo esc_html($previous_post->post_title); ?>
                                    </a>

                                </div>

                            </div>

                        <?php endif; ?>


                        <!-- =================================
                             NEXT POST (SQL $wpdb)
                        ================================== -->
                        <?php if ($next_post) : 
                            $next_time = strtotime($next_post->post_date);
                        ?>

                            <div class="post-nav-item">

                                <div class="post-nav-date">

                                    <div class="post-nav-day">
                                        <?php echo esc_html(date_i18n('d', $next_time)); ?>
                                    </div>

                                    <div class="post-nav-month">
                                        <?php echo esc_html(date_i18n('m', $next_time)); ?>
                                    </div>

                                    <div class="post-nav-year">
                                        '<?php echo esc_html(date_i18n('y', $next_time)); ?>
                                    </div>

                                </div>


                                <div class="post-nav-title">

                                    <a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>">
                                        <?php echo esc_html($next_post->post_title); ?>
                                    </a>

                                </div>

                            </div>

                        <?php endif; ?>

                    </nav>

                <?php endif; ?>
                
                <!-- =====================================
                    COMMENTS (MODULE 8)
                ====================================== -->

                <?php
                if (comments_open() || get_comments_number()) {
                    comments_template();
                }
                ?>

                <!-- =====================================
                    CATEGORIES (MODULE 9) - UNDER COMMENTS
                ====================================== -->
                <div class="single-post-categories-bottom" style="margin-top: 40px;">
                    <?php
                    if (file_exists(get_template_directory() . '/modules/module-9-categories.php')) {
                        include get_template_directory() . '/modules/module-9-categories.php';
                    }
                    ?>
                </div>

            </article>

        <?php endwhile; ?>

    <?php endif; ?>

</main>

<?php get_footer(); ?>