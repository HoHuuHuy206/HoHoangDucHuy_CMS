<?php get_header(); ?>

<main class="single-page">

    <?php if (have_posts()) : ?>

    <?php while (have_posts()) : the_post(); ?>

    <!-- MODULE 16: READING PROGRESS -->
    <div class="tdc-reading-progress" aria-hidden="true">
        <span class="tdc-reading-progress__bar"></span>
    </div>

    <article class="single-post">

        <!-- =====================================
                     POST HEADER
                ====================================== -->

        <header class="single-post-header">

            <div class="tdc-single-heading-content">
                <h1 class="single-post-title">
                    <?php the_title(); ?>
                </h1>

                <?php $reading_time = root_theme_get_reading_time(get_the_content()); ?>
                <div class="tdc-reading-meta" aria-label="Thời gian đọc dự kiến">
                    <svg class="tdc-reading-meta__icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                        <circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="2"></circle>
                        <path d="M12 7v5l3 2" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                    </svg>
                    <span>Thời gian đọc dự kiến: <?php echo esc_html($reading_time); ?> phút</span>
                </div>
            </div>


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

        <?php root_theme_render_post_reactions(get_the_ID()); ?>

        <!-- =====================================
                    COMMENTS (MODULE 8)
                ====================================== -->

        <?php
                if (comments_open() || get_comments_number()) {
                    comments_template();
                }
                ?>

        <!-- =====================================
                    CATEGORIES (MODULE 9) & WIDGET_TEST_4 - UNDER COMMENTS
                ====================================== -->
        <div class="single-post-categories-bottom" style="margin-top: 40px; max-width: 480px;">
            <?php
            global $wpdb;

            $tdc_categories = $wpdb->get_results("
                SELECT t.term_id, t.name, t.slug
                FROM {$wpdb->terms} t
                INNER JOIN {$wpdb->term_taxonomy} tt ON t.term_id = tt.term_id
                WHERE tt.taxonomy = 'category'
                ORDER BY t.name ASC
            ");
            ?>
            <section class="widget tdc-fit-categories-widget">
                <div class="tdc-fit-categories-box">
                    <h3 class="tdc-fit-categories-title">Categories</h3>
                    <div class="tdc-fit-title-stripe"></div>
                    <ul class="tdc-fit-categories-list">
                        <?php if (!empty($tdc_categories)) : ?>
                            <?php foreach ($tdc_categories as $tdc_category) : ?>
                                <li>
                                    <span class="tdc-fit-bullet">&#8226;</span>
                                    <a href="<?php echo esc_url(get_category_link($tdc_category->term_id)); ?>" class="tdc-fit-cat-link">
                                        <?php echo esc_html($tdc_category->name); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <li>Chưa có chuyên mục nào</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </section>

            <!-- WIDGET TEST 4: ĐẶT DƯỚI PHẦN CATEGORIES -->
            <section class="widget tdc-fit-widget-test-4-sidebar">
                <div class="tdc-fit-widget-test-4-box">
                    <?php
                    if (is_active_sidebar('widget_test_4')) {
                        dynamic_sidebar('widget_test_4');
                    } else {
                        root_theme_render_widget_test_4();
                    }
                    ?>
                </div>
            </section>
        </div>

    </article>

    <?php endwhile; ?>

    <?php endif; ?>

</main>

<?php get_footer(); ?>
