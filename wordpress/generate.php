<?php
require_once('wp-load.php');
require_once(ABSPATH . 'wp-admin/includes/image.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/media.php');

function create_real_png_image($filename, $text, $bg_hex) {
    $upload_dir = wp_upload_dir();
    $file_path = $upload_dir['path'] . '/' . $filename;
    
    $im = imagecreatetruecolor(800, 600);
    hex2rgb($bg_hex, $r, $g, $b);
    $bg_color = imagecolorallocate($im, $r, $g, $b);
    $text_color = imagecolorallocate($im, 255, 255, 255);
    
    imagefill($im, 0, 0, $bg_color);
    $font_size = 5;
    $text_x = (800 - (imagefontwidth($font_size) * strlen($text))) / 2;
    $text_y = (600 - imagefontheight($font_size)) / 2;
    imagestring($im, $font_size, $text_x, $text_y, $text, $text_color);
    
    imagepng($im, $file_path);
    imagedestroy($im);
    
    $filetype = wp_check_filetype($filename, null);
    $attachment = array(
        'post_mime_type' => $filetype['type'],
        'post_title'     => sanitize_file_name($filename),
        'post_content'   => '',
        'post_status'    => 'inherit'
    );
    
    $attach_id = wp_insert_attachment($attachment, $file_path);
    $attach_data = wp_generate_attachment_metadata($attach_id, $file_path);
    wp_update_attachment_metadata($attach_id, $attach_data);
    
    return $attach_id;
}

function hex2rgb($hex, &$r, &$g, &$b) {
    $hex = ltrim($hex, '#');
    if(strlen($hex) == 3) {
        $r = hexdec(substr($hex,0,1).substr($hex,0,1));
        $g = hexdec(substr($hex,1,1).substr($hex,1,1));
        $b = hexdec(substr($hex,2,1).substr($hex,2,1));
    } else {
        $r = hexdec(substr($hex,0,2));
        $g = hexdec(substr($hex,2,2));
        $b = hexdec(substr($hex,4,2));
    }
}

// 1. Chuẩn bị danh mục
$categories = [
    'Điện Thoại & Máy Tính Bảng',
    'Laptop & Máy Tính Bàn',
    'Phụ Kiện Công Nghệ',
    'Thiết Bị Gia Dụng',
    'Thời Trang & Phụ Kiện'
];

$cat_ids = [];
foreach ($categories as $cat_name) {
    $term = wp_insert_term($cat_name, 'category');
    $cat_ids[$cat_name] = is_wp_error($term) ? $term->get_error_data('term_exists') : $term['term_id'];
}

// 2. Danh sách bài viết
$posts_data = [
    ['title' => 'Đánh giá chi tiết smartphone hot nhất năm', 'cat' => 'Điện Thoại & Máy Tính Bảng'],
    ['title' => 'Top 5 máy tính bảng hỗ trợ học tập tốt nhất', 'cat' => 'Điện Thoại & Máy Tính Bảng'],
    ['title' => 'Kinh nghiệm chọn mua laptop văn phòng mỏng nhẹ', 'cat' => 'Laptop & Máy Tính Bàn'],
    ['title' => 'Hướng dẫn tự build cấu hình máy tính bàn chơi game', 'cat' => 'Laptop & Máy Tính Bàn'],
    ['title' => 'Trải nghiệm tai nghe chống ồn không dây thế hệ mới', 'cat' => 'Phụ Kiện Công Nghệ'],
    ['title' => 'Mẹo chọn sạc dự phòng dung lượng cao, an toàn', 'cat' => 'Phụ Kiện Công Nghệ'],
    ['title' => 'Đánh giá nồi chiên không dầu dung tích lớn', 'cat' => 'Thiết Bị Gia Dụng'],
    ['title' => 'Có nên mua robot hút bụi lau nhà tự động?', 'cat' => 'Thiết Bị Gia Dụng'],
    ['title' => 'Gợi ý phối đồ phong cách năng động mùa hè', 'cat' => 'Thời Trang & Phụ Kiện'],
    ['title' => 'Top 3 mẫu đồng hồ đeo tay thanh lịch cho công sở', 'cat' => 'Thời Trang & Phụ Kiện'],
];

$tags_sample = ['công nghệ', 'đánh giá', 'xu hướng 2026'];

foreach ($posts_data as $index => $data) {
    $img1_id  = create_real_png_image("img1_{$index}.png", "Hinh minh hoa 1", "#4A90E2");
    $img2_id  = create_real_png_image("img2_{$index}.png", "Hinh minh hoa 2", "#50E3C2");
    $thumb_id = create_real_png_image("thumb_{$index}.png", "Anh dai dien", "#F5A623");

    $img1_html = wp_get_attachment_image($img1_id, 'full');
    $img2_html = wp_get_attachment_image($img2_id, 'full');

    $content  = "<p>Nội dung chi tiết cho bài viết: <strong>" . esc_html($data['title']) . "</strong>.</p>";
    $content .= "<p>" . $img1_html . "</p>";
    $content .= "<p>Đánh giá tổng quan về tính năng, thiết kế và trải nghiệm sử dụng thực tế của sản phẩm.</p>";
    $content .= "<p>" . $img2_html . "</p>";

    $excerpt = "Bài viết cung cấp thông tin chi tiết và đánh giá toàn diện về " . mb_strtolower($data['title']) . " mới nhất 2026.";
    if (mb_strlen($excerpt) > 100) {
        $excerpt = mb_substr($excerpt, 0, 97) . '...';
    }

    $post_id = wp_insert_post([
        'post_title'    => $data['title'],
        'post_content'  => $content,
        'post_excerpt'  => $excerpt,
        'post_status'   => 'publish',
        'post_category' => [$cat_ids[$data['cat']]]
    ]);

    set_post_thumbnail($post_id, $thumb_id);
    wp_set_post_tags($post_id, $tags_sample, true);
}

echo "Thành công! Đã tạo lại toàn bộ dữ liệu chuẩn.";
