<?php
/**
 * Root Theme Functions and definitions
 */

// 1. Nạp Stylesheet của Theme & Font Awesome cho Bootsnipp
function group_c_enqueue_styles() {
    wp_enqueue_style(
        'font-awesome-4',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css',
        array(),
        '4.7.0'
    );
    wp_enqueue_style(
        'group-c-style',
        get_stylesheet_uri(),
        array('font-awesome-4'),
        time() // Cache buster để nhận CSS mới nhất ngay lập tức
    );
}
add_action('wp_enqueue_scripts', 'group_c_enqueue_styles');

// Module 14: giao diện danh sách bình luận và phản hồi phân cấp.
function root_theme_enqueue_module_14_styles() {
    if (!is_single()) {
        return;
    }

    $module_14_css = <<<'CSS'
.tdc-module-14 {
    margin-top: 34px;
}
.tdc-module-14__title {
    margin: 0 0 18px;
    color: #27364a;
    font-size: 22px;
    font-weight: 700;
}
.tdc-module-14-list {
    margin: 0;
    padding: 0;
    list-style: none;
}
.tdc-module-14-comment {
    margin: 0 0 12px;
}
.tdc-module-14-comment__row {
    display: grid;
    grid-template-columns: 36px minmax(0, 1fr);
    gap: 10px;
    align-items: start;
}
.tdc-module-14-comment__avatar img {
    display: block;
    width: 36px;
    height: 36px;
    border: 1px solid #e2e5e9;
    background: #f1f3f5;
    object-fit: cover;
}
.tdc-module-14-comment__card {
    min-width: 0;
    overflow: hidden;
    border: 1px solid #dfe3e7;
    background: #fff;
}
.tdc-module-14-comment__header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 7px 10px;
    background: #f3f4f5;
    border-bottom: 1px solid #e3e6e9;
}
.tdc-module-14-comment__author {
    color: #3d5369;
    font-size: 14px;
    font-weight: 600;
}
.tdc-module-14-comment__date {
    color: #8290a0;
    font-size: 11px;
    text-decoration: none;
    white-space: nowrap;
}
.tdc-module-14-comment__date:hover {
    color: #1681c4;
    text-decoration: underline;
}
.tdc-module-14-comment__date:focus-visible {
    color: #1681c4;
    outline: 2px solid #1681c4;
    outline-offset: 2px;
}
.tdc-module-14-comment__content {
    padding: 9px 10px 10px;
    color: #56616d;
    font-size: 13px;
    line-height: 1.55;
    overflow-wrap: anywhere;
}
.tdc-module-14-comment__content p {
    margin: 0 0 8px;
}
.tdc-module-14-comment__content p:last-child {
    margin-bottom: 0;
}
.tdc-module-14-list.children {
    margin: 10px 0 0 32px;
}
.tdc-module-14__empty {
    margin: 0;
    padding: 14px 16px;
    border: 1px solid #dfe3e7;
    background: #f8f9fa;
    color: #647180;
    font-size: 13px;
    line-height: 1.55;
}
@media (max-width: 600px) {
    .tdc-module-14-comment__row {
        grid-template-columns: 30px minmax(0, 1fr);
        gap: 8px;
    }
    .tdc-module-14-comment__avatar img {
        width: 30px;
        height: 30px;
    }
    .tdc-module-14-comment__header {
        align-items: flex-start;
        flex-direction: column;
        gap: 2px;
    }
    .tdc-module-14-list.children {
        margin-left: 16px;
    }
}
CSS;

    wp_add_inline_style('group-c-style', $module_14_css);
}
add_action('wp_enqueue_scripts', 'root_theme_enqueue_module_14_styles', 15);

// Module 13: CSS được khai báo trong PHP theo yêu cầu không sửa style.css.
function root_theme_enqueue_module_13_styles() {
    $module_13_css = <<<'CSS'
.tdc-module-13 {
    width: min(100% - 40px, 1200px);
    margin: 0 auto 42px;
}
.tdc-module-13__heading {
    margin: 0 0 20px;
    color: #1f2937;
    font-size: 24px;
    font-weight: 700;
}
.tdc-module-13__grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 22px;
}
.tdc-module-13__card {
    min-width: 0;
    overflow: hidden;
    background: #fff;
    border: 1px solid #e5e7eb;
    box-shadow: 0 4px 14px rgba(15, 23, 42, .06);
}
.tdc-module-13__image-link,
.tdc-module-13__placeholder {
    display: block;
    width: 100%;
    aspect-ratio: 16 / 9;
    overflow: hidden;
    background: #dcebf5;
}
.tdc-module-13__image {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .25s ease;
}
.tdc-module-13__image-link:hover .tdc-module-13__image {
    transform: scale(1.035);
}
.tdc-module-13__placeholder {
    background: linear-gradient(135deg, #dbeafe, #e2e8f0);
}
.tdc-module-13__body {
    padding: 16px 18px 18px;
}
.tdc-module-13__title {
    margin: 0 0 10px;
    font-size: 17px;
    line-height: 1.4;
}
.tdc-module-13__title a {
    color: #4b6f88;
    text-decoration: none;
}
.tdc-module-13__title a:hover {
    color: #1681c4;
    text-decoration: underline;
}
.tdc-module-13__excerpt {
    margin: 0;
    color: #64748b;
    font-size: 14px;
    line-height: 1.6;
}
@media (max-width: 768px) {
    .tdc-module-13 {
        width: min(100% - 28px, 1200px);
    }
    .tdc-module-13__grid {
        grid-template-columns: 1fr;
    }
}
CSS;

    wp_add_inline_style('group-c-style', $module_13_css);
}
add_action('wp_enqueue_scripts', 'root_theme_enqueue_module_13_styles', 20);

/**
 * Lấy ảnh cho thẻ bài viết Module 13.
 * Ưu tiên Featured Image, sau đó dùng ảnh đầu tiên trong nội dung bài viết.
 */
function root_theme_get_module_13_image_url($post_id, $post_content = '') {
    $featured_image_url = get_the_post_thumbnail_url($post_id, 'medium_large');

    if ($featured_image_url) {
        return $featured_image_url;
    }

    if (!preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', $post_content, $matches)) {
        return '';
    }

    $content_image_url = html_entity_decode($matches[1], ENT_QUOTES, 'UTF-8');
    $uploads_marker = '/wp-content/uploads/';
    $uploads_position = strpos($content_image_url, $uploads_marker);

    // Chuẩn hóa các URL cũ như /TranCaoTrong_CMS/wp-content/uploads/...
    if ($uploads_position !== false) {
        $uploads_path = substr($content_image_url, $uploads_position + strlen('/wp-content'));
        return content_url($uploads_path);
    }

    if (strpos($content_image_url, '//') === 0) {
        return (is_ssl() ? 'https:' : 'http:') . $content_image_url;
    }

    if (strpos($content_image_url, '/') === 0) {
        return home_url($content_image_url);
    }

    return $content_image_url;
}

/**
 * Module 16: Tính thời gian đọc dự kiến theo tốc độ trung bình 200 từ/phút.
 */
function root_theme_get_reading_time($content) {
    $plain_text = trim(wp_strip_all_tags(strip_shortcodes($content)));

    if ($plain_text === '') {
        return 1;
    }

    $words = preg_split('/\s+/u', $plain_text, -1, PREG_SPLIT_NO_EMPTY);
    return max(1, (int) ceil(count($words) / 200));
}

/**
 * Module 16: Giao diện thanh tiến trình và thông tin thời gian đọc.
 */
function root_theme_enqueue_module_16_styles() {
    if (!is_single()) {
        return;
    }

    $module_16_css = <<<'CSS'
.tdc-reading-progress {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 99999;
    width: 100%;
    height: 4px;
    background: rgba(226, 232, 240, .9);
    pointer-events: none;
}
.tdc-reading-progress__bar {
    display: block;
    width: 0;
    height: 100%;
    background: linear-gradient(90deg, #06b6d4, #2563eb);
    box-shadow: 0 1px 5px rgba(37, 99, 235, .35);
    transition: width .08s linear;
}
.admin-bar .tdc-reading-progress {
    top: 32px;
}
.tdc-single-heading-content {
    flex: 1 1 auto;
    min-width: 0;
    padding-right: 32px;
}
.tdc-single-heading-content .single-post-title {
    padding-right: 0;
}
.tdc-reading-meta {
    display: flex;
    align-items: center;
    gap: 7px;
    width: max-content;
    max-width: 100%;
    margin-top: 12px;
    color: #64748b;
    font-size: 14px;
    line-height: 1.4;
    white-space: nowrap;
}
.tdc-reading-meta__icon {
    flex: 0 0 18px;
    width: 18px;
    height: 18px;
    color: #1681c4;
}
.tdc-reading-meta span {
    white-space: nowrap;
}
@media screen and (max-width: 782px) {
    .admin-bar .tdc-reading-progress {
        top: 46px;
    }
}
@media (max-width: 600px) {
    .tdc-single-heading-content {
        padding-right: 18px;
    }
    .tdc-reading-meta {
        max-width: 100%;
        font-size: 13px;
    }
}
CSS;

    wp_add_inline_style('group-c-style', $module_16_css);
}
add_action('wp_enqueue_scripts', 'root_theme_enqueue_module_16_styles', 30);

/**
 * Module 16: Cập nhật thanh tiến trình theo vị trí đọc bài.
 */
function root_theme_render_module_16_script() {
    if (!is_single()) {
        return;
    }
    ?>
    <script>
    (function () {
        'use strict';

        var content = document.querySelector('.single-post-content');
        var progressBar = document.querySelector('.tdc-reading-progress__bar');
        var ticking = false;

        if (!content || !progressBar) {
            return;
        }

        function updateReadingProgress() {
            var viewportHeight = window.innerHeight || document.documentElement.clientHeight;
            var contentTop = content.getBoundingClientRect().top + window.pageYOffset;
            var contentHeight = content.offsetHeight;
            var readableDistance = Math.max(contentHeight - viewportHeight, 1);
            var currentDistance = window.pageYOffset - contentTop;
            var percentage = Math.min(100, Math.max(0, (currentDistance / readableDistance) * 100));

            progressBar.style.width = percentage.toFixed(2) + '%';
            ticking = false;
        }

        function requestProgressUpdate() {
            if (!ticking) {
                window.requestAnimationFrame(updateReadingProgress);
                ticking = true;
            }
        }

        window.addEventListener('scroll', requestProgressUpdate, { passive: true });
        window.addEventListener('resize', requestProgressUpdate);
        updateReadingProgress();
    }());
    </script>
    <?php
}
add_action('wp_footer', 'root_theme_render_module_16_script', 30);


// 2. Đăng ký khu vực Sidebar & Footer Widgets
// Module tự chọn: bình chọn cảm xúc cho bài viết.
function root_theme_get_reaction_options() {
    return array(
        'helpful'     => array('emoji' => '💡', 'label' => 'Hữu ích'),
        'interesting' => array('emoji' => '✨', 'label' => 'Thú vị'),
        'surprising'  => array('emoji' => '😮', 'label' => 'Bất ngờ'),
        'confusing'   => array('emoji' => '🤔', 'label' => 'Khó hiểu'),
        'needs_more'  => array('emoji' => '📝', 'label' => 'Cần bổ sung'),
    );
}

function root_theme_get_reaction_counts($post_id) {
    $counts = get_post_meta($post_id, '_tdc_reaction_counts', true);
    $counts = is_array($counts) ? $counts : array();
    foreach (root_theme_get_reaction_options() as $key => $option) {
        $counts[$key] = isset($counts[$key]) ? max(0, (int) $counts[$key]) : 0;
    }
    return $counts;
}

function root_theme_reaction_cookie_name($post_id) {
    return 'tdc_post_reaction_' . absint($post_id);
}

function root_theme_encode_reaction_cookie($post_id, $reaction) {
    return $reaction . '.' . wp_hash($post_id . '|' . $reaction, 'nonce');
}

function root_theme_get_selected_reaction($post_id) {
    $name = root_theme_reaction_cookie_name($post_id);
    if (empty($_COOKIE[$name])) {
        return '';
    }

    $parts = explode('.', sanitize_text_field(wp_unslash($_COOKIE[$name])), 2);
    $options = root_theme_get_reaction_options();
    if (count($parts) !== 2 || !isset($options[$parts[0]])) {
        return '';
    }

    $expected = wp_hash($post_id . '|' . $parts[0], 'nonce');
    return hash_equals($expected, $parts[1]) ? $parts[0] : '';
}

function root_theme_set_reaction_cookie($post_id, $reaction) {
    $name   = root_theme_reaction_cookie_name($post_id);
    $value  = root_theme_encode_reaction_cookie($post_id, $reaction);
    $path   = defined('COOKIEPATH') && COOKIEPATH ? COOKIEPATH : '/';
    $domain = defined('COOKIE_DOMAIN') ? COOKIE_DOMAIN : '';

    setcookie($name, $value, array(
        'expires' => time() + YEAR_IN_SECONDS,
        'path' => $path,
        'domain' => $domain,
        'secure' => is_ssl(),
        'httponly' => true,
        'samesite' => 'Lax',
    ));
    $_COOKIE[$name] = $value;
}

function root_theme_handle_post_reaction() {
    check_ajax_referer('tdc_post_reaction', 'nonce');
    $post_id  = isset($_POST['post_id']) ? absint($_POST['post_id']) : 0;
    $reaction = isset($_POST['reaction']) ? sanitize_key(wp_unslash($_POST['reaction'])) : '';
    $options  = root_theme_get_reaction_options();

    if (!$post_id || get_post_status($post_id) !== 'publish' || !isset($options[$reaction])) {
        wp_send_json_error(array('message' => 'Không thể ghi nhận lựa chọn này.'), 400);
    }

    $selected = root_theme_get_selected_reaction($post_id);
    $counts = root_theme_get_reaction_counts($post_id);
    if ($selected === $reaction) {
        wp_send_json_success(array('counts' => $counts, 'selected' => $selected, 'message' => 'Bạn đã chọn cảm xúc này rồi.'));
    }
    if ($selected && isset($counts[$selected])) {
        $counts[$selected] = max(0, $counts[$selected] - 1);
    }
    $counts[$reaction]++;
    update_post_meta($post_id, '_tdc_reaction_counts', $counts);
    root_theme_set_reaction_cookie($post_id, $reaction);

    wp_send_json_success(array(
        'counts' => $counts,
        'selected' => $reaction,
        'message' => $selected ? 'Đã cập nhật cảm xúc của bạn.' : 'Cảm ơn bạn đã chia sẻ cảm xúc!',
    ));
}
add_action('wp_ajax_tdc_post_reaction', 'root_theme_handle_post_reaction');
add_action('wp_ajax_nopriv_tdc_post_reaction', 'root_theme_handle_post_reaction');

function root_theme_render_post_reactions($post_id) {
    $post_id = absint($post_id);
    $options = root_theme_get_reaction_options();
    $counts = root_theme_get_reaction_counts($post_id);
    $selected = root_theme_get_selected_reaction($post_id);
    ?>
    <section class="tdc-reactions" data-post-id="<?php echo esc_attr($post_id); ?>" aria-labelledby="tdc-reactions-title-<?php echo esc_attr($post_id); ?>">
        <div class="tdc-reactions__intro">
            <span class="tdc-reactions__eyebrow">PHẢN HỒI NHANH</span>
            <h2 id="tdc-reactions-title-<?php echo esc_attr($post_id); ?>">Bài viết này mang lại cảm xúc gì cho bạn?</h2>
            <p>Chọn một cảm xúc phù hợp nhất. Bạn có thể đổi lựa chọn bất cứ lúc nào.</p>
        </div>
        <div class="tdc-reactions__grid" role="group" aria-label="Chọn cảm xúc">
            <?php foreach ($options as $key => $option) : $active = $selected === $key; ?>
                <button class="tdc-reaction<?php echo $active ? ' is-selected' : ''; ?>" type="button"
                        data-reaction="<?php echo esc_attr($key); ?>" aria-pressed="<?php echo $active ? 'true' : 'false'; ?>">
                    <span class="tdc-reaction__emoji" aria-hidden="true"><?php echo esc_html($option['emoji']); ?></span>
                    <span class="tdc-reaction__label"><?php echo esc_html($option['label']); ?></span>
                    <span class="tdc-reaction__count" aria-label="<?php echo esc_attr($counts[$key] . ' lượt chọn'); ?>"><?php echo esc_html($counts[$key]); ?></span>
                </button>
            <?php endforeach; ?>
        </div>
        <p class="tdc-reactions__status" role="status" aria-live="polite"></p>
    </section>
    <?php
}

function root_theme_enqueue_reaction_styles() {
    if (!is_single()) return;
    $css = <<<'CSS'
.tdc-reactions{position:relative;clear:both;margin:38px 0 34px;padding:28px;overflow:hidden;color:#334155;background:#f1f7fb;border:1px solid #d9e8f2;border-left:4px solid #1681c4;box-shadow:0 12px 28px rgba(15,53,77,.08)}
.tdc-reactions:after{content:"";position:absolute;right:-42px;top:-52px;width:140px;height:140px;border:24px solid rgba(22,129,196,.06);border-radius:50%;pointer-events:none}
.tdc-reactions__intro{position:relative;z-index:1;max-width:720px}.tdc-reactions__eyebrow{display:block;margin-bottom:7px;color:#1681c4;font-size:11px;font-weight:800;letter-spacing:.14em}
.tdc-reactions h2{margin:0 0 7px;color:#172b3a;font-size:clamp(20px,2.4vw,27px);line-height:1.25}.tdc-reactions__intro p{margin:0;color:#5d7080;font-size:14px;line-height:1.55}
.tdc-reactions__grid{position:relative;z-index:1;display:grid;grid-template-columns:repeat(5,minmax(0,1fr));gap:10px;margin-top:22px}
.tdc-reaction{display:grid;grid-template-columns:auto 1fr auto;align-items:center;gap:8px;min-width:0;min-height:58px;padding:10px 11px;color:#334155;font:inherit;text-align:left;cursor:pointer;background:#fff;border:1px solid #d5e1e9;border-radius:8px;box-shadow:0 2px 6px rgba(15,53,77,.04);transition:transform .18s ease,border-color .18s ease,box-shadow .18s ease,color .18s ease}
.tdc-reaction:hover{color:#096aa6;border-color:#58a8d8;transform:translateY(-2px)}.tdc-reaction:focus-visible{outline:3px solid rgba(14,165,233,.3);outline-offset:2px}
.tdc-reaction.is-selected{color:#075f98;border-color:#1681c4;box-shadow:0 0 0 2px #1681c4,0 9px 18px rgba(22,129,196,.15);transform:translateY(-3px)}.tdc-reaction:disabled{cursor:wait;opacity:.65}
.tdc-reaction__emoji{font-size:20px;line-height:1}.tdc-reaction__label{overflow:hidden;font-size:13px;font-weight:700;line-height:1.2;text-overflow:ellipsis}.tdc-reaction__count{display:inline-grid;place-items:center;min-width:25px;height:25px;padding:0 6px;color:#496273;font-size:12px;font-weight:800;background:#edf3f7;border-radius:5px}.tdc-reaction.is-selected .tdc-reaction__count{color:#fff;background:#1681c4}
.tdc-reactions__status{min-height:20px;margin:13px 0 -5px;color:#1373ad;font-size:13px;font-weight:600}.tdc-reactions__status.is-error{color:#b42318}
@media(max-width:900px){.tdc-reactions__grid{grid-template-columns:repeat(2,minmax(0,1fr))}}@media(max-width:480px){.tdc-reactions{margin:30px 0;padding:22px 18px}.tdc-reactions__grid{gap:8px}.tdc-reaction{min-height:56px}.tdc-reaction:last-child:nth-child(odd){grid-column:1/-1}}@media(max-width:340px){.tdc-reactions__grid{grid-template-columns:1fr}.tdc-reaction:last-child:nth-child(odd){grid-column:auto}}@media(prefers-reduced-motion:reduce){.tdc-reaction{transition:none}}
CSS;
    wp_add_inline_style('group-c-style', $css);
}
add_action('wp_enqueue_scripts', 'root_theme_enqueue_reaction_styles', 40);

function root_theme_render_reaction_script() {
    if (!is_single()) return;
    ?>
    <script>
    (function(){'use strict';
      var config=<?php echo wp_json_encode(array('ajaxUrl' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce('tdc_post_reaction'))); ?>;
      document.querySelectorAll('.tdc-reactions').forEach(function(module){
        var buttons=[].slice.call(module.querySelectorAll('.tdc-reaction')),status=module.querySelector('.tdc-reactions__status');
        buttons.forEach(function(button){button.addEventListener('click',function(){
          var previous=module.querySelector('.tdc-reaction.is-selected'),reaction=button.dataset.reaction,data=new FormData(),original={};
          if(button.getAttribute('aria-pressed')==='true'){status.textContent='Bạn đã chọn cảm xúc này rồi.';return;}
          buttons.forEach(function(item){item.disabled=true;original[item.dataset.reaction]=parseInt(item.querySelector('.tdc-reaction__count').textContent,10)||0;});
          module.setAttribute('aria-busy','true');status.classList.remove('is-error');status.textContent='Đang ghi nhận lựa chọn…';
          if(previous){var old=previous.querySelector('.tdc-reaction__count');old.textContent=Math.max(0,parseInt(old.textContent,10)-1);previous.classList.remove('is-selected');previous.setAttribute('aria-pressed','false');}
          var current=button.querySelector('.tdc-reaction__count');current.textContent=parseInt(current.textContent,10)+1;button.classList.add('is-selected');button.setAttribute('aria-pressed','true');
          data.append('action','tdc_post_reaction');data.append('nonce',config.nonce);data.append('post_id',module.dataset.postId);data.append('reaction',reaction);
          fetch(config.ajaxUrl,{method:'POST',credentials:'same-origin',body:data}).then(function(response){if(!response.ok)throw new Error('request_failed');return response.json();}).then(function(response){
            if(!response.success)throw new Error(response.data&&response.data.message?response.data.message:'request_failed');
            buttons.forEach(function(item){var key=item.dataset.reaction,count=response.data.counts[key]||0,node=item.querySelector('.tdc-reaction__count'),active=key===response.data.selected;node.textContent=count;node.setAttribute('aria-label',count+' lượt chọn');item.classList.toggle('is-selected',active);item.setAttribute('aria-pressed',active?'true':'false');});status.textContent=response.data.message;
          }).catch(function(error){buttons.forEach(function(item){var key=item.dataset.reaction,node=item.querySelector('.tdc-reaction__count'),active=item===previous;node.textContent=original[key];node.setAttribute('aria-label',original[key]+' lượt chọn');item.classList.toggle('is-selected',active);item.setAttribute('aria-pressed',active?'true':'false');});status.classList.add('is-error');status.textContent=error.message!=='request_failed'?error.message:'Chưa thể ghi nhận. Vui lòng thử lại.';
          }).then(function(){buttons.forEach(function(item){item.disabled=false;});module.removeAttribute('aria-busy');});
        });});
      });
    }());
    </script>
    <?php
}
add_action('wp_footer', 'root_theme_render_reaction_script', 40);

/**
 * ============================================================================
 * WIDGET_TEST_4: Danh sách bài viết ngẫu nhiên theo giao diện mẫu (Đề thi CMS)
 * Hiển thị tại: Trang chủ, Trang danh sách, Trang chi tiết (Khu vực phía trên Footer)
 * ============================================================================
 */

function root_theme_widget_test_4_current_date() {
    $day_number = (int) wp_date('N'); // 1: Thứ 2 ... 6: Thứ 7, 7: Chủ nhật
    $day_name   = ($day_number === 7) ? 'Chủ nhật' : ('Thứ ' . ($day_number + 1));
    return $day_name . ', ngày ' . wp_date('d-m-Y');
}

function root_theme_widget_test_4_is_visible() {
    // Hiển thị tại Trang chủ, Trang danh sách, Trang chi tiết
    return is_front_page() || is_home() || is_archive() || is_category() || is_tag() || is_tax() || is_search() || is_single() || is_singular();
}

function root_theme_widget_test_4_random_posts($count = 6) {
    return get_posts(array(
        'post_type'           => 'post',
        'post_status'         => 'publish',
        'posts_per_page'      => $count,
        'orderby'             => 'rand', // Random, không sinh viên nào giống nhau
        'ignore_sticky_posts' => true,
        'no_found_rows'       => true,
    ));
}

function root_theme_widget_test_4_excerpt($post_item, $words = 16) {
    $excerpt = trim((string) $post_item->post_excerpt);
    if ($excerpt === '') {
        $excerpt = wp_strip_all_tags(strip_shortcodes($post_item->post_content));
    }
    return wp_trim_words($excerpt, $words, '...');
}

function root_theme_render_widget_test_4($instance = array()) {
    $instance = is_array($instance) ? $instance : array();
    $title    = !empty($instance['title']) ? $instance['title'] : root_theme_widget_test_4_current_date();
    $posts    = root_theme_widget_test_4_random_posts(6);

    if (empty($posts)) {
        return;
    }

    $first_post   = $posts[0];
    $theme_avatar = get_template_directory_uri() . '/assets/images/widget-author.jpg';
    $author_avatar = !empty($instance['author_avatar']) ? esc_url($instance['author_avatar']) : $theme_avatar;

    $author_name = !empty($instance['author_name']) ? $instance['author_name'] : '';
    if ($author_name === '') {
        $p_author = get_the_author_meta('display_name', $first_post->post_author);
        if (!empty($p_author) && strtolower($p_author) !== 'admin') {
            $author_name = mb_strtoupper($p_author, 'UTF-8');
        } else {
            $author_name = 'LÊ ĐỨC DỤC';
        }
    }
    ?>
    <section class="tdc-widget-test-4" aria-label="<?php echo esc_attr($title); ?>">
        <!-- Header: Ngày tháng phong cách báo chí -->
        <h3 class="tdc-w4-header"><?php echo esc_html($title); ?></h3>

        <div class="tdc-w4-divider" aria-hidden="true"></div>

        <!-- Bài viết 1: Nổi bật kèm Tác giả & Ảnh đại diện tròn -->
        <article class="tdc-w4-featured">
            <div class="tdc-w4-featured__content">
                <h4 class="tdc-w4-featured__title">
                    <a href="<?php echo esc_url(get_permalink($first_post->ID)); ?>">
                        <?php echo esc_html($first_post->post_title); ?>
                    </a>
                </h4>
                <p class="tdc-w4-featured__excerpt">
                    <?php echo esc_html(root_theme_widget_test_4_excerpt($first_post, 16)); ?>
                </p>
            </div>
            <div class="tdc-w4-featured__author">
                <div class="tdc-w4-author-avatar-wrap">
                    <img src="<?php echo esc_url($author_avatar); ?>" alt="<?php echo esc_attr($author_name); ?>" class="tdc-w4-author-avatar" loading="lazy">
                </div>
                <span class="tdc-w4-author-name"><?php echo esc_html($author_name); ?></span>
            </div>
        </article>

        <!-- Bài viết 2 đến 6: Danh sách tiêu đề ngăn cách bởi đường nét đứt -->
        <?php for ($i = 1, $len = count($posts); $i < $len; $i++) : $p = $posts[$i]; ?>
            <div class="tdc-w4-divider" aria-hidden="true"></div>
            <article class="tdc-w4-item">
                <h4 class="tdc-w4-item__title">
                    <a href="<?php echo esc_url(get_permalink($p->ID)); ?>">
                        <?php echo esc_html($p->post_title); ?>
                    </a>
                </h4>
            </article>
        <?php endfor; ?>
    </section>
    <?php
}

class widget_test_4 extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'widget_test_4',
            'widget_test_4',
            array(
                'description' => 'Widget Test 4 - Hiển thị bài viết ngẫu nhiên theo giao diện mẫu đề thi CMS.',
                'classname'   => 'widget_test_4',
            )
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        root_theme_render_widget_test_4($instance);
        echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }

    public function form($instance) {
        $title         = isset($instance['title']) ? $instance['title'] : '';
        $author_name   = isset($instance['author_name']) ? $instance['author_name'] : '';
        $author_avatar = isset($instance['author_avatar']) ? $instance['author_avatar'] : '';
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">Tiêu đề (Để trống sẽ lấy ngày hiện tại: <?php echo esc_html(root_theme_widget_test_4_current_date()); ?>)</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" placeholder="<?php echo esc_attr(root_theme_widget_test_4_current_date()); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('author_name')); ?>">Tên tác giả bài nổi bật (Để trống sẽ tự động lấy tên tác giả hoặc LÊ ĐỨC DỤC)</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('author_name')); ?>" name="<?php echo esc_attr($this->get_field_name('author_name')); ?>" type="text" value="<?php echo esc_attr($author_name); ?>" placeholder="LÊ ĐỨC DỤC">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('author_avatar')); ?>">URL ảnh đại diện tác giả (Tùy chọn)</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('author_avatar')); ?>" name="<?php echo esc_attr($this->get_field_name('author_avatar')); ?>" type="text" value="<?php echo esc_attr($author_avatar); ?>" placeholder="Mặc định ảnh tác giả mẫu">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        return array(
            'title'         => isset($new_instance['title']) ? sanitize_text_field($new_instance['title']) : '',
            'author_name'   => isset($new_instance['author_name']) ? sanitize_text_field($new_instance['author_name']) : '',
            'author_avatar' => isset($new_instance['author_avatar']) ? esc_url_raw($new_instance['author_avatar']) : '',
        );
    }
}
class_alias('widget_test_4', 'Root_Theme_Widget_Test_4');

function root_theme_enqueue_widget_test_4_styles() {
    if (!root_theme_widget_test_4_is_visible()) {
        return;
    }

    $widget_test_4_css = <<<'CSS'
.tdc-fit-widget-test-4-sidebar {
    background: #f8f9fa;
    background-image: url("data:image/svg+xml,%3Csvg width='10' height='10' viewBox='0 0 10 10' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 0L10 9V10H9L0 1V0H1ZM10 0V1L1 10H0V9L9 0H10Z' fill='%23ededed' fill-opacity='1' fill-rule='evenodd'/%3E%3C/svg%3E");
    padding: 25px;
    margin-bottom: 35px;
    box-sizing: border-box;
}
.tdc-fit-widget-test-4-box {
    background: #ffffff;
    padding: 24px 22px 22px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    box-sizing: border-box;
}
.tdc-fit-widget-test-4-box .tdc-widget-test-4 {
    width: 100%;
    max-width: 100%;
    padding-right: 0;
    border-right: none;
}
.tdc-widget-test-4-area {
    clear: both;
    width: 100%;
    background: #ffffff;
    border-top: 1px solid #e9ecef;
    padding: 32px 20px 36px;
    box-sizing: border-box;
}
.tdc-widget-test-4-container {
    width: min(100% - 40px, 1180px);
    margin: 0 auto;
    display: flex;
    justify-content: flex-start;
}
.tdc-widget-test-4-container > .widget {
    margin: 0;
    padding: 0;
    background: transparent;
    border: 0;
}
.tdc-widget-test-4 {
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
    color: #333333;
    background: transparent;
}
.tdc-w4-header {
    margin: 0 0 12px 0;
    padding: 0;
    font-size: 17px;
    font-weight: 700;
    color: #486581;
    line-height: 1.3;
    letter-spacing: -0.01em;
}
.tdc-w4-divider {
    border-bottom: 1px dashed #d5dbe1;
    margin: 12px 0;
    height: 0;
    clear: both;
}
.tdc-w4-featured {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    padding: 2px 0 2px;
}
.tdc-w4-featured__content {
    flex: 1 1 0%;
    min-width: 0;
}
.tdc-w4-featured__title {
    margin: 0 0 6px 0;
    font-size: 15px;
    font-weight: 700;
    line-height: 1.35;
}
.tdc-w4-featured__title a {
    color: #222222 !important;
    text-decoration: none !important;
    transition: color 0.15s ease;
}
.tdc-w4-featured__title a:hover {
    color: #0b6da8 !important;
}
.tdc-w4-featured__excerpt {
    margin: 0;
    font-size: 13px;
    line-height: 1.45;
    color: #68717a;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.tdc-w4-featured__author {
    flex: 0 0 72px;
    width: 72px;
    text-align: center;
}
.tdc-w4-author-avatar-wrap {
    width: 56px;
    height: 56px;
    margin: 0 auto;
    border-radius: 50%;
    overflow: hidden;
    background: #e2e8f0;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
}
.tdc-w4-author-avatar {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
}
.tdc-w4-author-name {
    display: block;
    margin-top: 6px;
    font-size: 11px;
    font-weight: 600;
    color: #718096;
    text-transform: uppercase;
    line-height: 1.25;
    letter-spacing: 0.02em;
    word-break: break-word;
}
.tdc-w4-item {
    padding: 2px 0;
}
.tdc-w4-item__title {
    margin: 0;
    font-size: 15px;
    font-weight: 700;
    line-height: 1.38;
}
.tdc-w4-item__title a {
    color: #2b2b2b !important;
    text-decoration: none !important;
    transition: color 0.15s ease;
}
.tdc-w4-item__title a:hover {
    color: #0b6da8 !important;
}
@media (max-width: 600px) {
    .tdc-fit-widget-test-4-sidebar {
        padding: 16px;
        margin-bottom: 24px;
    }
    .tdc-fit-widget-test-4-box {
        padding: 18px 14px;
    }
}
CSS;

    wp_add_inline_style('group-c-style', $widget_test_4_css);
}
add_action('wp_enqueue_scripts', 'root_theme_enqueue_widget_test_4_styles', 50);

/**
 * Module 3: footer động hiển thị dữ liệu CMS.
 */
function root_theme_enqueue_module_3_styles() {
    $module_3_css = <<<'CSS'
.tdc-module-3 {
    --tdc-footer-bg: #078466;
    --tdc-footer-deep: #046f57;
    --tdc-footer-text: #f8f5e9;
    --tdc-footer-muted: #c8eddf;
    --tdc-footer-accent: #8de3c4;
    position: relative;
    clear: both;
    width: 100%;
    overflow: hidden;
    color: var(--tdc-footer-text);
    background: var(--tdc-footer-bg);
}
.tdc-module-3__top-band {
    height: 7px;
    background: var(--tdc-footer-deep);
    border-bottom: 1px solid rgba(255, 255, 255, .12);
}
.tdc-module-3__inner {
    width: min(100% - 40px, 1180px);
    margin: 0 auto;
    padding: 46px 0 22px;
}
.tdc-module-3__columns {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: clamp(36px, 6vw, 88px);
}
.tdc-module-3__column {
    min-width: 0;
}
.tdc-module-3__column h2 {
    position: relative;
    margin: 0 0 22px;
    padding-bottom: 12px;
    color: #fff;
    font-size: 14px;
    font-weight: 800;
    line-height: 1.25;
    letter-spacing: .095em;
    text-transform: uppercase;
}
.tdc-module-3__column h2::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 34px;
    height: 2px;
    background: var(--tdc-footer-accent);
}
.tdc-module-3__links {
    margin: 0;
    padding: 0;
    list-style: none;
}
.tdc-module-3__links li + li {
    margin-top: 4px;
}
.tdc-module-3__links a {
    position: relative;
    display: grid;
    grid-template-columns: 16px minmax(0, 1fr);
    gap: 7px;
    align-items: start;
    min-height: 34px;
    padding: 7px 8px 7px 0;
    color: var(--tdc-footer-muted) !important;
    font-size: 13px;
    font-weight: 500;
    line-height: 1.45;
    text-decoration: none !important;
    overflow-wrap: anywhere;
    transition: color .2s ease, transform .2s ease, background-color .2s ease;
}
.tdc-module-3__links a::before {
    content: "";
    position: absolute;
    inset: 3px auto 3px 0;
    width: 2px;
    background: rgba(141, 227, 196, .18);
    transform: scaleY(.35);
    transform-origin: center;
    transition: background-color .2s ease, transform .2s ease;
}
.tdc-module-3__chevron {
    position: relative;
    width: 16px;
    height: 20px;
}
.tdc-module-3__chevron::before,
.tdc-module-3__chevron::after {
    content: "";
    position: absolute;
    left: 5px;
    width: 6px;
    height: 1px;
    background: var(--tdc-footer-accent);
    transition: left .2s ease;
}
.tdc-module-3__chevron::before {
    top: 8px;
    transform: rotate(45deg);
}
.tdc-module-3__chevron::after {
    top: 12px;
    transform: rotate(-45deg);
}
.tdc-module-3__links a:hover {
    color: #fff !important;
    background: rgba(2, 80, 62, .28);
    transform: translateX(4px);
}
.tdc-module-3__links a:hover::before {
    background: var(--tdc-footer-accent);
    transform: scaleY(1);
}
.tdc-module-3__links a:hover .tdc-module-3__chevron::before,
.tdc-module-3__links a:hover .tdc-module-3__chevron::after {
    left: 7px;
}
.tdc-module-3__links a:focus-visible {
    color: #fff !important;
    background: var(--tdc-footer-deep);
    outline: 2px solid #fff;
    outline-offset: 3px;
}
.tdc-module-3__links--comments strong,
.tdc-module-3__links--comments small {
    display: block;
}
.tdc-module-3__links--comments strong {
    color: #fff;
    font-size: 13px;
    font-weight: 700;
}
.tdc-module-3__links--comments small {
    margin-top: 1px;
    color: var(--tdc-footer-muted);
    font-size: 11px;
    line-height: 1.45;
}
.tdc-module-3__empty {
    margin: 0;
    color: var(--tdc-footer-muted);
    font-size: 13px;
    line-height: 1.6;
}
.tdc-module-3__social {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    margin: 35px auto 27px;
}
.tdc-module-3__social a {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    color: var(--tdc-footer-text) !important;
    font-size: 15px;
    text-decoration: none !important;
    border: 1px solid rgba(255, 255, 255, .35);
    border-radius: 50%;
    transition: color .2s ease, background-color .2s ease, border-color .2s ease, transform .2s ease;
}
.tdc-module-3__social a:hover {
    color: #035c49 !important;
    background: var(--tdc-footer-accent);
    border-color: var(--tdc-footer-accent);
    transform: translateY(-3px);
}
.tdc-module-3__social a:focus-visible {
    color: #035c49 !important;
    background: #fff;
    outline: 3px solid var(--tdc-footer-accent);
    outline-offset: 3px;
}
.tdc-module-3__legal {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
    padding-top: 20px;
    border-top: 1px solid rgba(255, 255, 255, .32);
}
.tdc-module-3__legal p {
    margin: 0;
    color: var(--tdc-footer-muted);
    font-size: 11px;
    line-height: 1.55;
}
.tdc-module-3__legal strong {
    color: #fff;
    font-size: 12px;
    font-weight: 800;
    letter-spacing: .06em;
    text-transform: uppercase;
}
@media (max-width: 860px) {
    .tdc-module-3__columns {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 38px 54px;
    }
    .tdc-module-3__column:last-child {
        grid-column: 1 / -1;
        width: min(100%, 560px);
    }
}
@media (max-width: 600px) {
    .tdc-module-3__inner {
        width: min(100% - 32px, 1180px);
        padding: 38px 0 20px;
    }
    .tdc-module-3__columns {
        grid-template-columns: 1fr;
        gap: 34px;
    }
    .tdc-module-3__column:last-child {
        grid-column: auto;
        width: 100%;
    }
    .tdc-module-3__links a {
        min-height: 42px;
        padding-top: 10px;
        padding-bottom: 10px;
    }
    .tdc-module-3__chevron {
        height: 22px;
    }
    .tdc-module-3__chevron::before {
        top: 9px;
    }
    .tdc-module-3__chevron::after {
        top: 13px;
    }
    .tdc-module-3__social {
        margin-top: 32px;
    }
    .tdc-module-3__social a {
        width: 42px;
        height: 42px;
    }
    .tdc-module-3__legal {
        align-items: center;
        flex-direction: column;
        gap: 6px;
        text-align: center;
    }
}
@media (prefers-reduced-motion: reduce) {
    .tdc-module-3__links a,
    .tdc-module-3__links a::before,
    .tdc-module-3__chevron::before,
    .tdc-module-3__chevron::after,
    .tdc-module-3__social a {
        transition: none;
    }
}
CSS;

    wp_add_inline_style('group-c-style', $module_3_css);
}
add_action('wp_enqueue_scripts', 'root_theme_enqueue_module_3_styles', 55);

function root_theme_widgets_init() {
    register_sidebar(array(
        'name'          => 'Main Sidebar',
        'id'            => 'sidebar-1',
        'description'   => 'Khu vực Sidebar chính (hiển thị cùng Modules 9, 10, 11)',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));

    register_sidebar(array(
        'name'          => 'widget_test_4',
        'id'            => 'widget_test_4',
        'description'   => 'Khu vực hiển thị widget_test_4 phía trên Footer.',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '',
        'after_title'   => '',
    ));

    register_widget('widget_test_4');
}
add_action('widgets_init', 'root_theme_widgets_init');


// 3. Đăng ký các Shortcodes cho 4 Modules
if (!shortcode_exists('tdc_categories')) {
    add_shortcode('tdc_categories', function($atts) {
        ob_start();
        if (file_exists(get_template_directory() . '/modules/module-9-categories.php')) {
            include get_template_directory() . '/modules/module-9-categories.php';
        }
        return ob_get_clean();
    });
}

if (!shortcode_exists('tdc_recent_posts')) {
    add_shortcode('tdc_recent_posts', function($atts) {
        $args = shortcode_atts(array(
            'count'     => 10,
            'title'     => 'Bài viết mới nhất',
            'more_link' => home_url('/'),
        ), $atts);
        ob_start();
        if (file_exists(get_template_directory() . '/modules/module-10-recent-posts.php')) {
            include get_template_directory() . '/modules/module-10-recent-posts.php';
        }
        return ob_get_clean();
    });
}

if (!shortcode_exists('tdc_vnexpress_archive')) {
    add_shortcode('tdc_vnexpress_archive', function($atts) {
        $args = shortcode_atts(array(
            'count' => 8,
            'title' => 'Xem nhiều',
        ), $atts);
        ob_start();
        if (file_exists(get_template_directory() . '/modules/module-11-archive.php')) {
            include get_template_directory() . '/modules/module-11-archive.php';
        }
        return ob_get_clean();
    });
}
