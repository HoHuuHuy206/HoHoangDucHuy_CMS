<?php
/**
 * MODULE (8) - FORM BÌNH LUẬN "MAKE A POST" (BOOTSNIPP) & DANH SÁCH BÌNH LUẬN
 * Vị trí: Hiển thị ở cuối trang chi tiết bài viết (single.php)
 * TÍCH HỢP SQL TRỰC TIẾP QUA $wpdb
 */
global $wpdb;

if (post_password_required()) {
    return;
}

$current_post_id = get_the_ID();

// Truy vấn SQL trực tiếp lấy danh sách các bình luận đã duyệt của bài viết
$comments_list = $wpdb->get_results($wpdb->prepare("
    SELECT comment_ID, comment_author, comment_author_email, comment_date, comment_content
    FROM {$wpdb->comments}
    WHERE comment_post_ID = %d
      AND comment_approved = '1'
    ORDER BY comment_date ASC
", $current_post_id));

$comments_count = count($comments_list);
?>

<section id="comments" class="comments-area tdc-module-8-container">

    <!-- FORM MAKE A POST (BOOTSNIPP) -->
    <div class="tdc-make-post-card-wrapper">
        <div class="tdc-make-a-post-card">
            <div class="tdc-make-a-post-tab">Make a Post</div>

            <?php if (comments_open()) : ?>
            <form action="<?php echo esc_url(site_url('/wp-comments-post.php')); ?>" method="post" id="commentform" class="tdc-make-post-form">

                <?php comment_id_fields(); ?>
                <input type="hidden" name="redirect_to" value="<?php echo esc_url(get_permalink()); ?>">

                <div class="tdc-make-a-post-body">
                    <textarea
                        id="comment"
                        name="comment"
                        class="tdc-make-a-post-textarea"
                        placeholder="What are you thinking..."
                        required="required"
                        rows="4"
                    ></textarea>
                </div>

                <?php if (!is_user_logged_in()) : ?>
                    <div class="tdc-comment-guest-fields">
                        <input type="text" name="author" id="author" placeholder="Họ và tên *" required="required" class="tdc-guest-input">
                        <input type="email" name="email" id="email" placeholder="Email *" required="required" class="tdc-guest-input">
                        <input type="url" name="url" id="url" placeholder="Website (tùy chọn)" class="tdc-guest-input">
                    </div>
                <?php else : ?>
                    <div class="tdc-logged-in-info">
                        <?php
                        $current_user = wp_get_current_user();
                        echo '<p>Đăng nhập với tư cách <strong>' . esc_html($current_user->display_name) . '</strong>. ';
                        echo '<a href="' . esc_url(wp_logout_url(get_permalink())) . '">Đăng xuất?</a></p>';
                        ?>
                    </div>
                <?php endif; ?>

                <div class="tdc-make-a-post-footer">
                    <button name="submit" type="submit" id="submit" class="tdc-make-post-share-btn">share</button>
                </div>

            </form>
            <?php else : ?>
                <p class="tdc-comments-closed">Bình luận đã được đóng cho bài viết này.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- DANH SÁCH BÌNH LUẬN TRUY VẤN TỪ SQL ($wpdb) -->
    <?php if ($comments_count > 0) : ?>
        <div class="existing-comments tdc-existing-comments">
            <h3 class="comments-title">
                <?php echo esc_html($comments_count) . ' Bình luận'; ?>
            </h3>

            <ol class="comment-list">
                <?php foreach ($comments_list as $cmt) : ?>
                    <li class="comment" id="comment-<?php echo esc_attr($cmt->comment_ID); ?>">
                        <article class="comment-body">
                            <footer class="comment-meta">
                                <div class="comment-author vcard">
                                    <?php echo get_avatar($cmt->comment_author_email, 48); ?>
                                    <b class="fn"><?php echo esc_html($cmt->comment_author); ?></b>
                                    <span class="says">viết:</span>
                                </div>
                                <div class="comment-metadata">
                                    <a href="<?php echo esc_url(get_comment_link($cmt->comment_ID)); ?>">
                                        <time datetime="<?php echo esc_attr($cmt->comment_date); ?>">
                                            <?php echo esc_html(date_i18n(get_option('date_format') . ' \l\ú\c ' . get_option('time_format'), strtotime($cmt->comment_date))); ?>
                                        </time>
                                    </a>
                                </div>
                            </footer>
                            <div class="comment-content">
                                <?php echo wpautop(esc_html($cmt->comment_content)); ?>
                            </div>
                        </article>
                    </li>
                <?php endforeach; ?>
            </ol>
        </div>
    <?php endif; ?>

</section>
