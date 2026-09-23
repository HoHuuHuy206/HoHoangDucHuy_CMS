<?php
/**
 * Template for Home / Blog Index (Module 2: Latest Posts phong cách FIT TDC)
 * TÍCH HỢP SQL TRỰC TIẾP QUA $wpdb
 */
get_header();

global $wpdb;

// Thiết lập phân trang
$paged = max(1, get_query_var('paged'), get_query_var('page'));
$posts_per_page = get_option('posts_per_page', 5);
$offset = ($paged - 1) * $posts_per_page;

// 1. SQL: Đếm tổng số bài viết đã xuất bản
$total_posts = (int) $wpdb->get_var("
    SELECT COUNT(*) 
    FROM {$wpdb->posts} 
    WHERE post_type = 'post' 
      AND post_status = 'publish'
");

// 2. SQL: Truy vấn danh sách bài viết theo phân trang
$latest_posts = $wpdb->get_results($wpdb->prepare("
    SELECT ID, post_title, post_date, post_content, post_excerpt 
    FROM {$wpdb->posts} 
    WHERE post_type = 'post' 
      AND post_status = 'publish' 
    ORDER BY post_date DESC 
    LIMIT %d OFFSET %d
", $posts_per_page, $offset));

$max_pages = ceil($total_posts / $posts_per_page);
?>

<main class="home-page">

    <div class="home-layout">

        <!-- ================================
             MAIN CONTENT (MODULE 2 FIT TDC - SQL $wpdb)
        ================================= -->

        <section class="home-content">

            <!-- ================================
                 MODULE (12 - TỰ CHỌN 1): TIÊU ĐIỂM THỂ THAO & VIDEO HIGHLIGHTS
            ================================= -->
            <?php
            if ($paged <= 1 && file_exists(get_template_directory() . '/modules/module-12-featured-sports.php')) {
                include get_template_directory() . '/modules/module-12-featured-sports.php';
            }
            ?>

            <div class="section-heading">
                <h1>Latest Posts</h1>
            </div>

            <?php if (!empty($latest_posts)) : ?>

                <div class="news-list">

                    <?php foreach ($latest_posts as $post_item) : 
                        $timestamp  = strtotime($post_item->post_date);
                        $post_day   = date_i18n('d', $timestamp);
                        $post_month = date_i18n('m', $timestamp);
                        $permalink  = esc_url(get_permalink($post_item->ID));
                        $excerpt    = !empty($post_item->post_excerpt) ? $post_item->post_excerpt : $post_item->post_content;
                    ?>

                        <article class="news-item tdc-content-post-card">

                            <!-- DATE (Module 2 FIT TDC) -->
                            <div class="news-date tdc-post-date-col">
                                <span class="date-day"><?php echo esc_html($post_day); ?></span>
                                <span class="date-month">THÁNG <?php echo esc_html($post_month); ?></span>
                            </div>

                            <!-- CONTENT (Module 2 FIT TDC) -->
                            <div class="news-content tdc-post-content-col">
                                <h2 class="tdc-post-card-title">
                                    <a href="<?php echo $permalink; ?>">
                                        <?php echo esc_html($post_item->post_title); ?>
                                    </a>
                                </h2>

                                <p class="tdc-post-card-excerpt">
                                    <?php
                                    echo esc_html(
                                        wp_trim_words(
                                            wp_strip_all_tags($excerpt),
                                            30,
                                            '[...]'
                                        )
                                    );
                                    ?>
                                </p>
                            </div>

                        </article>

                    <?php endforeach; ?>

                </div>


                <!-- ================================
                     PAGINATION
                ================================= -->
                <?php if ($max_pages > 1) : ?>
                    <div class="home-pagination">
                        <?php
                        echo paginate_links(array(
                            'total'     => $max_pages,
                            'current'   => $paged,
                            'mid_size'  => 2,
                            'prev_text' => '« Previous',
                            'next_text' => 'Next »',
                        ));
                        ?>
                    </div>
                <?php endif; ?>


            <?php else : ?>

                <div class="no-posts">

                    <h2>No posts found.</h2>

                    <p>
                        There are currently no posts to display.
                    </p>

                </div>

            <?php endif; ?>

        </section>


        <!-- ================================
             SIDEBAR (Modules 10, 11)
        ================================= -->
        <?php get_sidebar(); ?>

    </div>

</main>

<?php get_footer(); ?>