<?php
/**
 * Plugin Name: My Sports Manager
 * Description: Plugin tùy chỉnh hỗ trợ CRUD Thể thao (POST) kèm Hình ảnh & Video YouTube, và CRUD Danh mục (Tennis, Pic, Football).
 * Version: 2.1
 * Author: Student
 */

if (!defined('ABSPATH')) {
    exit;
}

// =========================================================================
// 1. TỰ ĐỘNG TẠO CÁC CATEGORY BẮT BUỘC: Tennis, Pic, Football
// =========================================================================
function custom_sports_ensure_categories() {
    $categories = array('Tennis', 'Pic', 'Football');
    foreach ($categories as $cat) {
        if (!term_exists($cat, 'category')) {
            wp_insert_term($cat, 'category', array(
                'description' => 'Chuyên mục thể thao: ' . $cat,
                'slug'        => sanitize_title($cat)
            ));
        }
    }
}
register_activation_hook(__FILE__, 'custom_sports_ensure_categories');
add_action('init', 'custom_sports_ensure_categories', 5);

// =========================================================================
// 2. TẠO CUSTOM POST TYPE: Thể thao (Sports)
// =========================================================================
function custom_sports_register_post_type() {
    $labels = array(
        'name'                  => 'Thể thao',
        'singular_name'         => 'Thể thao',
        'menu_name'             => 'Thể thao',
        'name_admin_bar'        => 'Bài thể thao',
        'add_new'               => 'Thêm bài thể thao',
        'add_new_item'          => 'Thêm bài viết thể thao mới',
        'new_item'              => 'Bài viết thể thao mới',
        'edit_item'             => 'Sửa bài viết thể thao',
        'view_item'             => 'Xem bài viết thể thao',
        'all_items'             => 'Tất cả bài thể thao',
        'search_items'          => 'Tìm kiếm thể thao',
        'parent_item_colon'     => 'Bài thể thao cha:',
        'not_found'             => 'Không tìm thấy bài thể thao nào',
        'not_found_in_trash'    => 'Không có bài thể thao nào trong thùng rác',
        'featured_image'        => 'Hình ảnh đại diện',
        'set_featured_image'    => 'Chọn hình ảnh đại diện',
        'remove_featured_image' => 'Xóa hình ảnh đại diện',
        'use_featured_image'    => 'Dùng làm hình ảnh đại diện',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'the-thao'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-awards',
        'show_in_rest'       => true, // Kích hoạt Gutenberg block editor & REST API
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'comments', 'custom-fields'),
        'taxonomies'         => array('category', 'post_tag'),
    );

    register_post_type('the_thao', $args);
    register_taxonomy_for_object_type('category', 'the_thao');
    register_taxonomy_for_object_type('post_tag', 'the_thao');

    // Đăng ký meta field để Gutenberg REST API đồng bộ
    register_post_meta('the_thao', '_sports_youtube_url', array(
        'show_in_rest'  => true,
        'single'        => true,
        'type'          => 'string',
        'auth_callback' => function() {
            return current_user_can('edit_posts');
        }
    ));
    register_post_meta('post', '_sports_youtube_url', array(
        'show_in_rest'  => true,
        'single'        => true,
        'type'          => 'string',
        'auth_callback' => function() {
            return current_user_can('edit_posts');
        }
    ));
}
add_action('init', 'custom_sports_register_post_type');

// Hiển thị bài viết Thể thao trên trang lưu trữ danh mục (Category Archives)
function custom_sports_include_cpt_in_categories($query) {
    if (!is_admin() && $query->is_main_query() && ($query->is_category() || $query->is_tag())) {
        $post_types = $query->get('post_type');
        if (empty($post_types)) {
            $post_types = array('post', 'the_thao');
        } elseif (is_array($post_types)) {
            if (!in_array('the_thao', $post_types)) {
                $post_types[] = 'the_thao';
            }
        } elseif (is_string($post_types)) {
            $post_types = array($post_types, 'the_thao');
        }
        $query->set('post_type', $post_types);
    }
}
add_action('pre_get_posts', 'custom_sports_include_cpt_in_categories');

// Menu con cho Chuyên mục và Tạo dữ liệu mẫu
function custom_sports_admin_menu_customization() {
    // 1. Chuyên mục Thể thao (Tennis, Pic, Football)
    add_submenu_page(
        'edit.php?post_type=the_thao',
        'Chuyên mục Thể thao',
        'Chuyên mục (Tennis, Pic, Football)',
        'manage_categories',
        'edit-tags.php?taxonomy=category&post_type=the_thao'
    );

    // 2. Trang công cụ Khởi tạo dữ liệu mẫu (1 Click)
    add_submenu_page(
        'edit.php?post_type=the_thao',
        'Tạo dữ liệu mẫu Thể thao',
        'Tạo dữ liệu mẫu (Demo)',
        'manage_options',
        'sports-demo-generator',
        'custom_sports_demo_page_render'
    );
}
add_action('admin_menu', 'custom_sports_admin_menu_customization');

// Trang công cụ Tạo dữ liệu mẫu trong Admin
function custom_sports_demo_page_render() {
    if (isset($_POST['run_sports_generator']) && check_admin_referer('sports_generator_action', 'sports_generator_nonce')) {
        require_once(ABSPATH . 'generate_sports.php');
        echo '<div class="notice notice-success is-dismissible"><p><strong>Thành công!</strong> Đã tạo mới các bài viết Thể thao mẫu kèm Hình ảnh & Video YouTube cho 3 chuyên mục Tennis, Pic, Football.</p></div>';
    }
    ?>
    <div class="wrap">
        <h1>Khởi tạo Dữ liệu mẫu Thể thao (Tennis, Pic, Football)</h1>
        <p>Công cụ này tự động sinh các bài viết chuẩn cho Custom Post Type <strong>Thể thao</strong> kèm <strong>Hình ảnh minh họa</strong> và <strong>Video YouTube</strong> cho các môn:</p>
        <ul style="list-style: disc; padding-left: 20px;">
            <li><strong>Tennis</strong>: Chung kết Wimbledon, Kỹ thuật giao bóng</li>
            <li><strong>Pic (Pickleball)</strong>: Luật chơi & Kỹ thuật Dinking, Top 5 vợt Pickleball</li>
            <li><strong>Football</strong>: Siêu phẩm bàn thắng El Clasico, Phân tích chiến thuật 4-3-3</li>
        </ul>
        <form method="post" action="">
            <?php wp_nonce_field('sports_generator_action', 'sports_generator_nonce'); ?>
            <p>
                <button type="submit" name="run_sports_generator" class="button button-primary button-large">
                    ▶ Tạo ngay dữ liệu mẫu Thể thao
                </button>
                <a href="<?php echo admin_url('edit.php?post_type=the_thao'); ?>" class="button button-secondary button-large" style="margin-left: 10px;">
                    Xem danh sách Thể thao
                </a>
            </p>
        </form>
    </div>
    <?php
}

// =========================================================================
// 3. META BOX: Video (YouTube)
// =========================================================================
function custom_sports_add_video_meta_box() {
    $screens = array('the_thao', 'post');
    foreach ($screens as $screen) {
        add_meta_box(
            'sports_video_meta_box',
            '🎬 Video (YouTube) cho bài thể thao',
            'custom_sports_video_meta_box_html',
            $screen,
            'normal',
            'high'
        );
    }
}
add_action('add_meta_boxes', 'custom_sports_add_video_meta_box');

// Hàm trích xuất YouTube ID từ mọi dạng link YouTube
function custom_sports_extract_youtube_id($url) {
    if (empty($url)) return false;
    $pattern = '/(?:youtube(?:-nocookie)?\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/|youtube\.com\/shorts\/)([a-zA-Z0-9_-]{11})/';
    if (preg_match($pattern, trim($url), $matches)) {
        return $matches[1];
    }
    return false;
}

// Render giao diện Meta Box trong trang soạn thảo
function custom_sports_video_meta_box_html($post) {
    wp_nonce_field('sports_video_nonce_action', 'sports_video_nonce_field');
    $video_url = get_post_meta($post->ID, '_sports_youtube_url', true);
    $youtube_id = custom_sports_extract_youtube_id($video_url);
    ?>
    <div style="padding: 10px 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
        <label for="sports_youtube_url" style="display:block; font-weight: 600; margin-bottom: 6px; font-size: 14px;">
            Đường dẫn Video YouTube:
        </label>
        <input type="url" 
               id="sports_youtube_url" 
               name="sports_youtube_url" 
               value="<?php echo esc_attr($video_url); ?>" 
               placeholder="https://www.youtube.com/watch?v=..." 
               style="width: 100%; max-width: 650px; padding: 8px 12px; font-size: 14px; border: 1px solid #8c8f94; border-radius: 4px;" />
        <p style="color: #646970; font-size: 12px; margin-top: 5px;">
            Hỗ trợ link YouTube dạng: <code>https://www.youtube.com/watch?v=...</code>, <code>https://youtu.be/...</code> hoặc <code>https://youtube.com/shorts/...</code>.
        </p>

        <!-- Khung xem trước Video trực tiếp trong Admin -->
        <div id="sports_youtube_preview_wrapper" style="margin-top: 15px; max-width: 560px; <?php echo empty($youtube_id) ? 'display:none;' : ''; ?>">
            <span style="font-weight: 600; font-size: 13px; color: #1d2327; display: block; margin-bottom: 6px;">
                Xem trước Video:
            </span>
            <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.15); background: #000;">
                <iframe id="sports_youtube_preview_iframe" 
                        src="<?php echo !empty($youtube_id) ? 'https://www.youtube.com/embed/' . esc_attr($youtube_id) : ''; ?>" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen 
                        style="position: absolute; top:0; left:0; width:100%; height:100%;">
                </iframe>
            </div>
        </div>

        <script>
        (function() {
            var input = document.getElementById('sports_youtube_url');
            var wrapper = document.getElementById('sports_youtube_preview_wrapper');
            var iframe = document.getElementById('sports_youtube_preview_iframe');

            function getYouTubeId(url) {
                var regExp = /(?:youtube(?:-nocookie)?\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/|youtube\.com\/shorts\/)([a-zA-Z0-9_-]{11})/;
                var match = url.match(regExp);
                return (match && match[1]) ? match[1] : false;
            }

            if (input && wrapper && iframe) {
                input.addEventListener('input', function() {
                    var val = this.value.trim();
                    var ytId = getYouTubeId(val);
                    if (ytId) {
                        iframe.src = 'https://www.youtube.com/embed/' + ytId;
                        wrapper.style.display = 'block';
                    } else {
                        iframe.src = '';
                        wrapper.style.display = 'none';
                    }
                });
            }
        })();
        </script>
    </div>
    <?php
}

// Lưu dữ liệu Meta Box khi lưu bài viết
function custom_sports_save_video_meta($post_id) {
    if (!isset($_POST['sports_video_nonce_field']) || !wp_verify_nonce($_POST['sports_video_nonce_field'], 'sports_video_nonce_action')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['sports_youtube_url'])) {
        $clean_url = esc_url_raw(trim($_POST['sports_youtube_url']));
        if (!empty($clean_url)) {
            update_post_meta($post_id, '_sports_youtube_url', $clean_url);
        } else {
            delete_post_meta($post_id, '_sports_youtube_url');
        }
    }
}
add_action('save_post', 'custom_sports_save_video_meta');

// =========================================================================
// 4. HIỂN THỊ CỘT TRỰC QUAN TRONG DANH SÁCH BÀI VIẾT ADMIN (CRUD)
// =========================================================================
function custom_sports_columns($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['sports_thumb'] = 'Hình ảnh';
    $new_columns['title'] = 'Tiêu đề';
    $new_columns['sports_categories'] = 'Chuyên mục';
    $new_columns['sports_video'] = 'Video (YouTube)';
    $new_columns['date'] = $columns['date'];
    return $new_columns;
}
add_filter('manage_the_thao_posts_columns', 'custom_sports_columns');
add_filter('manage_posts_columns', 'custom_sports_columns');

function custom_sports_column_content($column, $post_id) {
    if ($column === 'sports_thumb') {
        if (has_post_thumbnail($post_id)) {
            echo get_the_post_thumbnail($post_id, array(60, 60), array(
                'style' => 'width: 55px; height: 55px; object-fit: cover; border-radius: 6px; border: 1px solid #dcdcde;'
            ));
        } else {
            echo '<span style="display:inline-block; width:55px; height:55px; line-height:55px; text-align:center; background:#f0f0f1; color:#8c8f94; border-radius:6px; font-size:11px;">Không ảnh</span>';
        }
    } elseif ($column === 'sports_categories') {
        $terms = get_the_terms($post_id, 'category');
        if (!empty($terms) && !is_wp_error($terms)) {
            $cat_links = array();
            foreach ($terms as $t) {
                $cat_links[] = '<a href="' . esc_url(admin_url('edit.php?category_name=' . $t->slug)) . '"><span style="display:inline-block; background:#e7f3ff; color:#0b5cab; padding:2px 8px; border-radius:12px; font-size:12px; margin:2px 0;">' . esc_html($t->name) . '</span></a>';
            }
            echo implode(' ', $cat_links);
        } else {
            echo '<span style="color:#8c8f94;">—</span>';
        }
    } elseif ($column === 'sports_video') {
        $video_url = get_post_meta($post_id, '_sports_youtube_url', true);
        $yt_id = custom_sports_extract_youtube_id($video_url);
        if (!empty($yt_id)) {
            echo '<a href="' . esc_url('https://www.youtube.com/watch?v=' . $yt_id) . '" target="_blank" style="display:inline-flex; align-items:center; gap:5px; text-decoration:none; color:#dc2626; font-weight:600; background:#fef2f2; padding:4px 10px; border-radius:6px; border:1px solid #fecaca; font-size:12px;">';
            echo '<span class="dashicons dashicons-video-alt3" style="font-size:16px; width:16px; height:16px;"></span> Xem video';
            echo '</a>';
        } else {
            echo '<span style="color:#8c8f94; font-size:12px;">Chưa gắn video</span>';
        }
    }
}
add_action('manage_the_thao_posts_custom_column', 'custom_sports_column_content', 10, 2);
add_action('manage_posts_custom_column', 'custom_sports_column_content', 10, 2);

// =========================================================================
// 5. TỰ ĐỘNG HIỂN THỊ VIDEO YOUTUBE & HÌNH ẢNH RA GIAO DIỆN BÀI VIẾT
// =========================================================================
function custom_sports_render_video_box($post_id = 0) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    if (!$post_id) return '';

    $video_url = get_post_meta($post_id, '_sports_youtube_url', true);
    $yt_id = custom_sports_extract_youtube_id($video_url);

    if (empty($yt_id)) return '';

    return '
    <div class="sports-single-video-wrapper" style="margin: 25px 0; background: #f8fafc; border-radius: 12px; padding: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px; font-weight: 600; color: #0f172a; font-size: 16px;">
            <span style="color: #ef4444; font-size: 20px;">▶</span> Video Thể Thao Nổi Bật (YouTube)
        </div>
        <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); background: #000;">
            <iframe src="https://www.youtube.com/embed/' . esc_attr($yt_id) . '" 
                    title="Video YouTube Thể Thao" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                    allowfullscreen 
                    style="position: absolute; top:0; left:0; width:100%; height:100%;">
            </iframe>
        </div>
    </div>';
}

function custom_sports_embed_video_in_content($content) {
    $post_id = get_the_ID();
    if (!$post_id) {
        global $post;
        $post_id = isset($post->ID) ? $post->ID : 0;
    }
    if (!$post_id) {
        return $content;
    }

    // Nếu bài viết đã có khối Gutenberg embed hoặc iframe thì không chèn lặp lại
    if (strpos($content, 'wp-block-embed-youtube') !== false || strpos($content, 'sports-single-video-wrapper') !== false || strpos($content, 'youtube.com/embed') !== false) {
        return $content;
    }

    // Khi xem chi tiết bài viết
    if (is_singular() || is_single()) {
        $video_box = custom_sports_render_video_box($post_id);
        if (!empty($video_box)) {
            $content = $video_box . $content;
        }
    }
    return $content;
}
add_filter('the_content', 'custom_sports_embed_video_in_content');

// Shortcode [sports_video] để có thể chèn video ở bất kỳ vị trí nào
add_shortcode('sports_video', function($atts) {
    $a = shortcode_atts(array('id' => 0), $atts);
    $post_id = $a['id'] ? intval($a['id']) : get_the_ID();
    return custom_sports_render_video_box($post_id);
});