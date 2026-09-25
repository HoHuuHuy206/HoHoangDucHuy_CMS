
<?php
// Module 3: footer động lấy dữ liệu trực tiếp từ cơ sở dữ liệu WordPress.
global $wpdb;

$module_3_posts = $wpdb->get_results(
    $wpdb->prepare(
        "SELECT ID, post_title
        FROM {$wpdb->posts}
        WHERE post_type = %s AND post_status = %s
        ORDER BY post_date DESC
        LIMIT %d",
        'post',
        'publish',
        5
    )
);

$module_3_categories = $wpdb->get_results(
    $wpdb->prepare(
        "SELECT t.term_id, t.name
        FROM {$wpdb->terms} AS t
        INNER JOIN {$wpdb->term_taxonomy} AS tt ON t.term_id = tt.term_id
        WHERE tt.taxonomy = %s AND tt.count > %d
        ORDER BY t.name ASC
        LIMIT %d",
        'category',
        0,
        5
    )
);

$module_3_comments = $wpdb->get_results(
    $wpdb->prepare(
        "SELECT c.comment_ID, c.comment_author, p.post_title
        FROM {$wpdb->comments} AS c
        INNER JOIN {$wpdb->posts} AS p ON c.comment_post_ID = p.ID
        WHERE c.comment_approved = %s
          AND c.comment_type IN (%s, %s)
          AND p.post_status = %s
        ORDER BY c.comment_date_gmt DESC
        LIMIT %d",
        '1',
        '',
        'comment',
        'publish',
        5
    )
);

$module_3_site_name = get_bloginfo('name');
$module_3_site_name = $module_3_site_name !== '' ? $module_3_site_name : 'Root Theme';
$module_3_admin_email = sanitize_email(get_option('admin_email'));
?>

<footer id="tdc-module-3-footer" class="tdc-module-3" aria-label="Chân trang">
    <div class="tdc-module-3__top-band" aria-hidden="true"></div>
    <div class="tdc-module-3__inner">
        <div class="tdc-module-3__columns">
            <section class="tdc-module-3__column" aria-labelledby="tdc-module-3-posts-title">
                <h2 id="tdc-module-3-posts-title">Bài viết mới</h2>
                <?php if (!empty($module_3_posts)) : ?>
                    <ul class="tdc-module-3__links">
                        <?php foreach ($module_3_posts as $module_3_post) : ?>
                            <li>
                                <a href="<?php echo esc_url(get_permalink((int) $module_3_post->ID)); ?>">
                                    <span class="tdc-module-3__chevron" aria-hidden="true"></span>
                                    <span><?php echo esc_html($module_3_post->post_title !== '' ? $module_3_post->post_title : 'Bài viết không có tiêu đề'); ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else : ?>
                    <p class="tdc-module-3__empty">Chưa có bài viết nào được xuất bản.</p>
                <?php endif; ?>
            </section>

            <section class="tdc-module-3__column" aria-labelledby="tdc-module-3-categories-title">
                <h2 id="tdc-module-3-categories-title">Chuyên mục</h2>
                <?php if (!empty($module_3_categories)) : ?>
                    <ul class="tdc-module-3__links">
                        <?php foreach ($module_3_categories as $module_3_category) : ?>
                            <li>
                                <a href="<?php echo esc_url(get_category_link((int) $module_3_category->term_id)); ?>">
                                    <span class="tdc-module-3__chevron" aria-hidden="true"></span>
                                    <span><?php echo esc_html($module_3_category->name); ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else : ?>
                    <p class="tdc-module-3__empty">Chưa có chuyên mục nào có bài viết.</p>
                <?php endif; ?>
            </section>

            <section class="tdc-module-3__column" aria-labelledby="tdc-module-3-comments-title">
                <h2 id="tdc-module-3-comments-title">Bình luận mới</h2>
                <?php if (!empty($module_3_comments)) : ?>
                    <ul class="tdc-module-3__links tdc-module-3__links--comments">
                        <?php foreach ($module_3_comments as $module_3_comment) : ?>
                            <li>
                                <a href="<?php echo esc_url(get_comment_link((int) $module_3_comment->comment_ID)); ?>">
                                    <span class="tdc-module-3__chevron" aria-hidden="true"></span>
                                    <span>
                                        <strong><?php echo esc_html($module_3_comment->comment_author !== '' ? $module_3_comment->comment_author : 'Khách'); ?></strong>
                                        <small>về <?php echo esc_html($module_3_comment->post_title !== '' ? $module_3_comment->post_title : 'bài viết'); ?></small>
                                    </span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else : ?>
                    <p class="tdc-module-3__empty">Chưa có bình luận nào được duyệt.</p>
                <?php endif; ?>
            </section>
        </div>

        <nav class="tdc-module-3__social" aria-label="Liên kết mạng xã hội">
            <a href="https://www.facebook.com/" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
            <a href="https://twitter.com/" target="_blank" rel="noopener noreferrer" aria-label="X / Twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
            <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a>
            <a href="<?php echo esc_url(home_url('/')); ?>" aria-label="Trang chủ website"><i class="fa fa-globe" aria-hidden="true"></i></a>
            <?php if ($module_3_admin_email !== '') : ?>
                <a href="<?php echo esc_url('mailto:' . $module_3_admin_email); ?>" aria-label="Gửi email"><i class="fa fa-envelope" aria-hidden="true"></i></a>
            <?php endif; ?>
        </nav>

        <div class="tdc-module-3__legal">
            <p><strong><?php echo esc_html($module_3_site_name); ?></strong></p>
            <p>&copy; <?php echo esc_html(wp_date('Y')); ?> <?php echo esc_html($module_3_site_name); ?>. Mọi quyền được bảo lưu.</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>

</body>
</html>
