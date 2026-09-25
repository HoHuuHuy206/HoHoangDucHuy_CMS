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
    SELECT comment_ID, comment_parent, comment_author, comment_author_email, comment_date, comment_content
    FROM {$wpdb->comments}
    WHERE comment_post_ID = %d
      AND comment_approved = '1'
      AND comment_type IN ('', 'comment')
    ORDER BY comment_date_gmt ASC, comment_ID ASC
", $current_post_id));

$comments_count = count($comments_list);

// Module 14: gom bình luận theo comment_parent để hiển thị đúng cấu trúc phản hồi.
$approved_comment_ids = array();
$comments_by_parent = array();

foreach ($comments_list as $comment_item) {
    $approved_comment_ids[(int) $comment_item->comment_ID] = true;
}

foreach ($comments_list as $comment_item) {
    $parent_id = (int) $comment_item->comment_parent;

    // Nếu bình luận cha không còn tồn tại hoặc chưa được duyệt, đưa phản hồi về cấp đầu.
    if ($parent_id !== 0 && !isset($approved_comment_ids[$parent_id])) {
        $parent_id = 0;
    }

    if (!isset($comments_by_parent[$parent_id])) {
        $comments_by_parent[$parent_id] = array();
    }

    $comments_by_parent[$parent_id][] = $comment_item;
}

$render_module_14_comments = function($parent_id = 0) use (&$render_module_14_comments, $comments_by_parent) {
    if (empty($comments_by_parent[$parent_id])) {
        return;
    }

    $list_class = $parent_id === 0
        ? 'tdc-module-14-list'
        : 'tdc-module-14-list children';
    ?>
    <ol class="<?php echo esc_attr($list_class); ?>">
        <?php foreach ($comments_by_parent[$parent_id] as $comment_item) : ?>
            <?php $comment_id = (int) $comment_item->comment_ID; ?>
            <li class="tdc-module-14-comment" id="comment-<?php echo esc_attr($comment_id); ?>">
                <article class="tdc-module-14-comment__row">
                    <div class="tdc-module-14-comment__avatar">
                        <?php echo get_avatar($comment_item->comment_author_email, 36, '', esc_attr($comment_item->comment_author)); ?>
                    </div>

                    <div class="tdc-module-14-comment__card">
                        <header class="tdc-module-14-comment__header">
                            <strong class="tdc-module-14-comment__author">
                                <?php echo esc_html($comment_item->comment_author); ?>
                            </strong>
                            <a class="tdc-module-14-comment__date" href="<?php echo esc_url(get_comment_link($comment_id)); ?>">
                                <time datetime="<?php echo esc_attr(mysql2date('c', $comment_item->comment_date)); ?>">
                                    <?php
                                    echo esc_html(
                                        date_i18n(
                                            get_option('date_format') . ' ' . get_option('time_format'),
                                            strtotime($comment_item->comment_date)
                                        )
                                    );
                                    ?>
                                </time>
                            </a>
                        </header>

                        <div class="tdc-module-14-comment__content">
                            <?php echo wpautop(esc_html($comment_item->comment_content)); ?>
                        </div>
                    </div>
                </article>

                <?php $render_module_14_comments($comment_id); ?>
            </li>
        <?php endforeach; ?>
    </ol>
    <?php
};
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

    <!-- MODULE 14: DANH SÁCH BÌNH LUẬN PHÂN CẤP -->
    <div class="existing-comments tdc-existing-comments tdc-module-14">
        <h3 class="comments-title tdc-module-14__title">
            <?php echo esc_html(sprintf(_n('%s Bình luận', '%s Bình luận', $comments_count, 'root-theme'), number_format_i18n($comments_count))); ?>
        </h3>

        <?php if ($comments_count > 0) : ?>
            <?php $render_module_14_comments(0); ?>
        <?php else : ?>
            <p class="tdc-module-14__empty">Chưa có bình luận nào. Hãy là người đầu tiên tham gia thảo luận.</p>
        <?php endif; ?>
    </div>

</section>
