<?php
/**
 * Template for Archive / Category Pages (Trang danh sách)
 * Theme: Root Theme
 */
get_header();
?>

<main class="home-page archive-page">
    <div class="home-layout">
        <section class="home-content">
            <div class="section-heading">
                <h1><?php the_archive_title(); ?></h1>
            </div>

            <?php if (have_posts()) : ?>
                <div class="news-list">
                    <?php while (have_posts()) : the_post(); 
                        $post_day   = get_the_date('d');
                        $post_month = get_the_date('m');
                        $permalink  = esc_url(get_permalink());
                        $excerpt    = has_excerpt() ? get_the_excerpt() : get_the_content();
                    ?>
                        <article class="news-item tdc-content-post-card">
                            <div class="news-date tdc-post-date-col">
                                <span class="date-day"><?php echo esc_html($post_day); ?></span>
                                <span class="date-month">THÁNG <?php echo esc_html($post_month); ?></span>
                            </div>

                            <div class="news-content tdc-post-content-col">
                                <h2 class="tdc-post-card-title">
                                    <a href="<?php echo $permalink; ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </h2>
                                <p class="tdc-post-card-excerpt">
                                    <?php echo esc_html(wp_trim_words(wp_strip_all_tags($excerpt), 30, '[...]')); ?>
                                </p>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>

                <div class="home-pagination">
                    <?php
                    echo paginate_links(array(
                        'mid_size'  => 2,
                        'prev_text' => '« Previous',
                        'next_text' => 'Next »',
                    ));
                    ?>
                </div>

            <?php else : ?>
                <div class="no-posts">
                    <h2>Chưa có bài viết.</h2>
                    <p>Hiện chưa có bài viết nào trong danh mục này.</p>
                </div>
            <?php endif; ?>
        </section>

        <?php get_sidebar(); ?>
    </div>
</main>

<?php get_footer(); ?>
