<?php
/**
 * Template for Search Page (Module 4: Search Form & Module 5: Search Results)
 * TÍCH HỢP SQL TRỰC TIẾP QUA $wpdb
 */
get_header();

global $wpdb;
$search_query = get_search_query();
$search_like  = '%' . $wpdb->esc_like($search_query) . '%';

// Phân trang kết quả tìm kiếm
$paged = max(1, get_query_var('paged'), get_query_var('page'));
$posts_per_page = get_option('posts_per_page', 5);
$offset = ($paged - 1) * $posts_per_page;

// 1. SQL: Đếm tổng số kết quả tìm kiếm
$total_results = 0;
$search_results = array();

if (!empty($search_query)) {
    $total_results = (int) $wpdb->get_var($wpdb->prepare("
        SELECT COUNT(*) 
        FROM {$wpdb->posts} 
        WHERE post_type = 'post' 
          AND post_status = 'publish' 
          AND (post_title LIKE %s OR post_content LIKE %s)
    ", $search_like, $search_like));

    // 2. SQL: Lấy danh sách kết quả bài viết theo trang
    if ($total_results > 0) {
        $search_results = $wpdb->get_results($wpdb->prepare("
            SELECT ID, post_title, post_date, post_content, post_excerpt 
            FROM {$wpdb->posts} 
            WHERE post_type = 'post' 
              AND post_status = 'publish' 
              AND (post_title LIKE %s OR post_content LIKE %s) 
            ORDER BY post_date DESC 
            LIMIT %d OFFSET %d
        ", $search_like, $search_like, $posts_per_page, $offset));
    }
}
$max_num_pages = ceil($total_results / $posts_per_page);
?>

<main class="search-page tdc-search-container">

    <?php if ($total_results > 0 && !empty($search_results)) : ?>

        <!-- MODULE (5) - SEARCH RESULTS (SQL $wpdb) -->
        <section class="search-result-header tdc-has-results-header">
            <h1 class="tdc-search-title">
                Search: <span>"<?php echo esc_html($search_query); ?>"</span>
                <small style="font-size: 15px; color: #64748b; font-weight: normal; margin-left: 10px;">
                    (Tìm thấy <?php echo esc_html($total_results); ?> kết quả)
                </small>
            </h1>
        </section>

        <section class="search-results tdc-search-results-list">

            <?php foreach ($search_results as $post_obj) : 
                $post_id   = $post_obj->ID;
                $timestamp = strtotime($post_obj->post_date);
                $post_date  = date_i18n('d', $timestamp);
                $post_month = date_i18n('m', $timestamp);
                $excerpt    = !empty($post_obj->post_excerpt) ? $post_obj->post_excerpt : $post_obj->post_content;
                $permalink  = esc_url(get_permalink($post_id));
            ?>
                <article class="search-result-card tdc-search-item-card">

                    <!-- 1. HÌNH ẢNH BÊN TRÁI -->
                    <div class="result-image tdc-search-thumb-box">
                        <?php if (has_post_thumbnail($post_id)) : ?>
                            <a href="<?php echo $permalink; ?>">
                                <?php echo get_the_post_thumbnail($post_id, 'medium', array('class' => 'tdc-search-thumbnail')); ?>
                            </a>
                        <?php else : ?>
                            <a href="<?php echo $permalink; ?>" class="tdc-search-no-thumb">
                                <div class="tdc-search-thumb-placeholder">
                                    <span>TDC FIT</span>
                                </div>
                            </a>
                        <?php endif; ?>
                    </div>

                    <!-- 2. Ô NGÀY THÁNG Ở GIỮA -->
                    <div class="result-date tdc-search-date-box">
                        <div class="result-day tdc-search-day">
                            <?php echo esc_html($post_date); ?>
                        </div>
                        <div class="result-month tdc-search-month">
                            THÁNG <?php echo esc_html($post_month); ?>
                        </div>
                    </div>

                    <!-- 3. TIÊU ĐỀ & NỘI DUNG BÊN PHẢI -->
                    <div class="result-content tdc-search-content-box">
                        <h2 class="tdc-search-item-title">
                            <a href="<?php echo $permalink; ?>">
                                <?php echo esc_html($post_obj->post_title); ?>
                            </a>
                        </h2>

                        <p class="tdc-search-item-excerpt">
                            <?php
                            echo esc_html(wp_trim_words(
                                wp_strip_all_tags($excerpt),
                                25,
                                '[...]'
                            ));
                            ?>
                        </p>
                    </div>

                </article>
            <?php endforeach; ?>

            <!-- Phân trang tìm kiếm -->
            <?php if ($max_num_pages > 1) : ?>
                <div class="home-pagination">
                    <?php
                    echo paginate_links(array(
                        'total'     => $max_num_pages,
                        'current'   => $paged,
                        'mid_size'  => 2,
                        'prev_text' => '« Previous',
                        'next_text' => 'Next »',
                    ));
                    ?>
                </div>
            <?php endif; ?>

        </section>

    <?php else : ?>

        <!-- MODULE (4) - KHÔNG CÓ KẾT QUẢ TÌM KIẾM (BOOTSNIPP 35V6b) -->
        <section class="tdc-search-not-found-wrapper">
            
            <div class="tdc-search-not-found-header">
                <h1 class="tdc-search-keyword-highlight">
                    Search: <span>"<?php echo esc_html($search_query); ?>"</span>
                </h1>
                <p class="tdc-search-not-found-msg">
                    We could not find any results for your search. You can give it another try through the search form below.
                </p>
            </div>

            <div class="tdc-search-form-banner">
                <form class="tdc-large-search-form" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                    <div class="tdc-search-input-wrap">
                        <span class="tdc-search-lens-icon">&#128269;</span>
                        <input
                            type="search"
                            name="s"
                            class="tdc-search-banner-input"
                            placeholder="Search topics or keywords"
                            value="<?php echo esc_attr($search_query); ?>"
                            required
                        >
                    </div>
                    <button type="submit" class="tdc-search-banner-btn">
                        Search
                    </button>
                </form>
            </div>

        </section>

    <?php endif; ?>

</main>

<?php get_footer(); ?>