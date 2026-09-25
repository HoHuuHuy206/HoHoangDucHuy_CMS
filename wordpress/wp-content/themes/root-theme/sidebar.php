<?php
/**
 * The sidebar template containing Module 9, Module 10, Module 11
 * Theme: Root Theme
 */
?>
<aside id="secondary" class="site-sidebar home-sidebar tdc-sidebar-area" role="complementary">


    <!-- MODULE (9): CATEGORIES PHONG CÁCH KHOA CNTT -->
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

    <!-- WIDGET TEST 4: ĐẶT DƯỚI PHẦN CATEGORIES THEO YÊU CẦU -->
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

    <!-- MODULE (10): 10 BÀI VIẾT MỚI NHẤT PHONG CÁCH FIT TDC -->
    <?php
    if (file_exists(get_template_directory() . '/modules/module-10-recent-posts.php')) {
        include get_template_directory() . '/modules/module-10-recent-posts.php';
    }
    ?>

    <!-- MODULE (11): ARCHIVE / XEM NHIỀU 2 CỘT PHONG CÁCH VNEXPRESS -->
    <?php
    if (file_exists(get_template_directory() . '/modules/module-11-archive.php')) {
        include get_template_directory() . '/modules/module-11-archive.php';
    }
    ?>

    <!-- DYNAMIC SIDEBAR (Nếu có widget được kéo thả thêm trong wp-admin) -->
    <?php if (is_active_sidebar('sidebar-1')) : ?>
        <div class="dynamic-sidebar-widgets">
            <?php dynamic_sidebar('sidebar-1'); ?>
        </div>
    <?php endif; ?>

</aside>
