<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<!-- MODULE (1) - MAIN HEADER (TÍCH HỢP SQL $wpdb) -->
<header class="main-header" id="site-main-header">

    <!-- 1. Nút Logo: Về trang chủ -->
    <div class="header-logo">
        <a href="<?php echo esc_url(home_url('/')); ?>" title="Trang chủ Group D">
            Group D
        </a>
    </div>

    <!-- 2. Nút Home: Về trang chủ -->
    <div class="header-home">
        <a href="<?php echo esc_url(home_url('/')); ?>" title="Trang chủ">
            Home
        </a>
    </div>

    <!-- 3. Form Search: Nhập từ khóa tìm kiếm ra trang kết quả search -->
    <form class="header-search" method="get" action="<?php echo esc_url(home_url('/')); ?>" id="headerSearchForm">
        <input
            type="search"
            name="s"
            id="header-search-input"
            placeholder="Search"
            value="<?php echo esc_attr(get_search_query()); ?>"
            required
        >
        <button type="submit" id="header-search-submit" title="Tìm kiếm">
            Submit
        </button>
    </form>

    <!-- Spacer giãn khoảng cách -->
    <div class="header-spacer"></div>

    <!-- 4. Navigation Menu: Truy vấn SQL $wpdb lấy danh mục thực tế -->
    <nav class="header-nav">
        <?php
        global $wpdb;

        // SQL: Lấy các chuyên mục hiển thị trên Menu chính
        $menu_cats_raw = $wpdb->get_results("
            SELECT t.term_id, t.name, t.slug 
            FROM {$wpdb->terms} t 
            INNER JOIN {$wpdb->term_taxonomy} tt ON t.term_id = tt.term_id 
            WHERE tt.taxonomy = 'category' 
              AND t.slug IN ('the-thao', 'cong-nghe', 'doi-song', 'football')
        ");

        $menu_cats = array();
        if (!empty($menu_cats_raw)) {
            foreach ($menu_cats_raw as $c_row) {
                $menu_cats[$c_row->slug] = $c_row;
            }
        }

        $thethao_id   = isset($menu_cats['the-thao']) ? $menu_cats['the-thao']->term_id : 3;
        $thethao_url  = get_category_link($thethao_id);

        $congnghe_id  = isset($menu_cats['cong-nghe']) ? $menu_cats['cong-nghe']->term_id : 2;
        $congnghe_url = get_category_link($congnghe_id);

        $doisong_id   = isset($menu_cats['doi-song']) ? $menu_cats['doi-song']->term_id : 5;
        $doisong_url  = get_category_link($doisong_id);
        ?>
        <a href="<?php echo esc_url($thethao_url); ?>" title="Chuyên mục Thể thao">
            Thể thao
        </a>

        <a href="<?php echo esc_url($congnghe_url); ?>" title="Chuyên mục Khoa học & Công nghệ">
            Khoa học
        </a>

        <a href="<?php echo esc_url($doisong_url); ?>" title="Chuyên mục Tin tức">
            Tin tức
        </a>
    </nav>

    <!-- 5. Nút Menu: 3 chấm tròn ngang đúng mẫu đề bài kèm tính năng mở menu chuyên mục -->
    <div class="header-icon-item header-menu-trigger" id="headerMenuBtn" title="Danh mục Menu mở rộng">
        <div class="header-icon menu-icon dots-menu-icon">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <span>Menu</span>

        <!-- Dropdown Danh mục Menu khi click Menu 3 chấm -->
        <div class="header-menu-dropdown" id="headerMenuDropdown">
            <div class="menu-dropdown-title">Danh mục liên kết</div>
            <ul class="menu-dropdown-list">
                <li><a href="<?php echo esc_url(home_url('/')); ?>">🏠 Trang chủ</a></li>
                <li><a href="<?php echo esc_url($thethao_url); ?>">⚽ Thể thao</a></li>
                <li><a href="<?php echo esc_url($congnghe_url); ?>">🔬 Khoa học - Công nghệ</a></li>
                <li><a href="<?php echo esc_url($doisong_url); ?>">📰 Tin tức đời sống</a></li>
                <?php if (isset($menu_cats['football'])) : ?>
                    <li><a href="<?php echo esc_url(get_category_link($menu_cats['football']->term_id)); ?>">🏆 Football</a></li>
                <?php endif; ?>
                <li><a href="<?php echo esc_url(home_url('/demo_4_modules.php')); ?>">📋 Demo 4 Modules</a></li>
            </ul>
        </div>
    </div>

    <!-- 6. Nút Search Icon: Nhấn search ra trang tìm kiếm hoặc submit form -->
    <div class="header-icon-item header-search-trigger" id="headerSearchIconBtn" title="Nhấn để tìm kiếm">
        <div class="header-icon search-icon"></div>
        <span>Search</span>
    </div>

    <!-- 7. Nút Account: Icon người dùng + Dropdown Menu phong cách Bootstrap -->
    <div class="header-account dropdown" id="headerAccountDropdown">
        <button type="button" class="account-btn dropdown-toggle" id="accountDropdownBtn" aria-expanded="false" title="Tài khoản">
            <div class="account-icon">
                <div class="account-head"></div>
                <div class="account-body"></div>
            </div>
            <div class="account-text">
                Account
                <span class="account-arrow"></span>
            </div>
        </button>

        <!-- Dropdown Menu Account -->
        <ul class="dropdown-menu account-dropdown-menu" id="accountDropdownMenu">
            <?php if (is_user_logged_in()) : ?>
                <?php 
                $user_id = get_current_user_id();
                // SQL: Lấy thông tin người dùng từ bảng wp_users
                $user_info = $wpdb->get_row($wpdb->prepare("
                    SELECT user_login, display_name 
                    FROM {$wpdb->users} 
                    WHERE ID = %d
                ", $user_id));

                $display_name = !empty($user_info->display_name) ? $user_info->display_name : ($user_info->user_login ?? 'User');
                ?>
                <li class="dropdown-header">
                    Xin chào, <strong><?php echo esc_html($display_name); ?></strong>
                </li>
                <li class="dropdown-divider"></li>
                <li>
                    <a href="<?php echo esc_url(admin_url()); ?>" class="dropdown-item">
                        <span class="dropdown-icon">&#9881;</span> Trang quản trị
                    </a>
                </li>
                <li>
                    <a href="<?php echo esc_url(admin_url('profile.php')); ?>" class="dropdown-item">
                        <span class="dropdown-icon">&#128100;</span> Hồ sơ cá nhân
                    </a>
                </li>
                <li class="dropdown-divider"></li>
                <li>
                    <a href="<?php echo esc_url(wp_logout_url(home_url('/'))); ?>" class="dropdown-item text-danger">
                        <span class="dropdown-icon">&#128682;</span> Đăng xuất
                    </a>
                </li>
            <?php else : ?>
                <li>
                    <a href="<?php echo esc_url(wp_login_url()); ?>" class="dropdown-item">
                        <span class="dropdown-icon">&#128272;</span> Đăng nhập
                    </a>
                </li>
                <li>
                    <a href="<?php echo esc_url(site_url('wp-login.php?action=register')); ?>" class="dropdown-item">
                        <span class="dropdown-icon">&#128221;</span> Đăng ký tài khoản
                    </a>
                </li>
                <li class="dropdown-divider"></li>
                <li>
                    <a href="<?php echo esc_url(wp_lostpassword_url()); ?>" class="dropdown-item text-muted">
                        Quên mật khẩu?
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>

</header>

<!-- JavaScript xử lý toàn bộ tính năng tương tác của Module 1 -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Xử lý Nút Search Icon bên phải
    var searchIconBtn = document.getElementById('headerSearchIconBtn');
    var searchInput = document.getElementById('header-search-input');
    var searchForm = document.getElementById('headerSearchForm');

    if (searchIconBtn && searchForm) {
        searchIconBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (searchInput && searchInput.value.trim() !== '') {
                searchForm.submit();
            } else if (searchInput) {
                searchInput.focus();
                searchInput.classList.add('highlight-search');
                setTimeout(function() {
                    searchInput.classList.remove('highlight-search');
                }, 1500);
            }
        });
    }

    // 2. Xử lý Nút Menu 3 chấm (Bật/tắt menu liên kết mở rộng)
    var menuBtn = document.getElementById('headerMenuBtn');
    var menuDropdown = document.getElementById('headerMenuDropdown');

    if (menuBtn && menuDropdown) {
        menuBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            menuDropdown.classList.toggle('show');
            // Đóng dropdown account nếu đang mở
            var accountDropdown = document.getElementById('headerAccountDropdown');
            if (accountDropdown) accountDropdown.classList.remove('show');
        });
    }

    // 3. Xử lý Nút Account (Bật/tắt dropdown tài khoản khi click)
    var accountDropdown = document.getElementById('headerAccountDropdown');
    var dropdownBtn = document.getElementById('accountDropdownBtn');

    if (accountDropdown && dropdownBtn) {
        dropdownBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            accountDropdown.classList.toggle('show');
            // Đóng menu 3 chấm nếu đang mở
            if (menuDropdown) menuDropdown.classList.remove('show');
        });
    }

    // Đóng tất cả dropdown khi click ra ngoài màn hình
    document.addEventListener('click', function(e) {
        if (menuDropdown && !menuBtn.contains(e.target)) {
            menuDropdown.classList.remove('show');
        }
        if (accountDropdown && !accountDropdown.contains(e.target)) {
            accountDropdown.classList.remove('show');
        }
    });
});
</script>