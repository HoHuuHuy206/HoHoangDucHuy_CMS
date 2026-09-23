<?php
/**
 * Module 13: Live Match Fixtures & Scores (Lịch Thi Đấu & Kết Quả Thể Thao Trực Tiếp)
 * Tự chọn Module 2 - Hiển thị widget bảng kết quả và lịch thi đấu Football, Tennis, Pickleball
 */
if (!defined('ABSPATH')) {
    exit;
}

$active_tab = isset($_GET['fixture_tab']) ? sanitize_text_field($_GET['fixture_tab']) : 'football';

$fixtures = array(
    'football' => array(
        array(
            'tournament' => 'UEFA Champions League 2026',
            'team_a'     => 'Real Madrid',
            'score_a'    => '3',
            'logo_a'     => '⚽',
            'team_b'     => 'Man City',
            'score_b'    => '2',
            'logo_b'     => '⚽',
            'status'     => 'FT (Kết thúc)',
            'is_live'    => false,
            'time'       => 'Hôm qua'
        ),
        array(
            'tournament' => 'Premier League',
            'team_a'     => 'Arsenal',
            'score_a'    => '1',
            'logo_a'     => '⚽',
            'team_b'     => 'Liverpool',
            'score_b'    => '1',
            'logo_b'     => '⚽',
            'status'     => 'LIVE 74\'',
            'is_live'    => true,
            'time'       => 'Trực tiếp'
        ),
        array(
            'tournament' => 'V-League 1',
            'team_a'     => 'Hà Nội FC',
            'score_a'    => '-',
            'logo_a'     => '⚽',
            'team_b'     => 'HAGL',
            'score_b'    => '-',
            'logo_b'     => '⚽',
            'status'     => '19:15',
            'is_live'    => false,
            'time'       => 'Hôm nay'
        )
    ),
    'tennis' => array(
        array(
            'tournament' => 'Wimbledon Championship 2026',
            'team_a'     => 'Carlos Alcaraz',
            'score_a'    => '3',
            'logo_a'     => '🎾',
            'team_b'     => 'Jannik Sinner',
            'score_b'    => '1',
            'logo_b'     => '🎾',
            'status'     => 'FT (Kết thúc)',
            'is_live'    => false,
            'time'       => 'Set 4: 6-4'
        ),
        array(
            'tournament' => 'Roland Garros Grand Slam',
            'team_a'     => 'Novak Djokovic',
            'score_a'    => '2',
            'logo_a'     => '🎾',
            'team_b'     => 'Alexander Zverev',
            'score_b'    => '2',
            'logo_b'     => '🎾',
            'status'     => 'LIVE Set 5',
            'is_live'    => true,
            'time'       => 'Tie-break'
        )
    ),
    'pic' => array(
        array(
            'tournament' => 'PPA Pickleball Tour 2026',
            'team_a'     => 'Ben Johns / Waters',
            'score_a'    => '11',
            'logo_a'     => '🏓',
            'team_b'     => 'Tardio / Wright',
            'score_b'    => '9',
            'logo_b'     => '🏓',
            'status'     => 'Chung kết',
            'is_live'    => false,
            'time'       => 'Game 3: 11-9'
        ),
        array(
            'tournament' => 'Vietnam Open Pickleball Cup',
            'team_a'     => 'Đội Tuyển SG',
            'score_a'    => '10',
            'logo_a'     => '🏓',
            'team_b'     => 'Đội Tuyển HN',
            'score_b'    => '8',
            'logo_b'     => '🏓',
            'status'     => 'LIVE Đang đấu',
            'is_live'    => true,
            'time'       => 'Vòng Bán kết'
        )
    )
);
?>

<div class="custom-module-13-fixtures-widget">
    <div class="module-13-header">
        <div class="module-13-title-wrap">
            <span class="module-13-icon"><i class="fa fa-calendar-check-o"></i></span>
            <h3 class="module-13-title">Lịch Thi Đấu & Kết Quả</h3>
        </div>
        <span class="module-13-live-indicator"><span class="pulse-dot"></span> LIVE 24/7</span>
    </div>

    <!-- Tab navigation -->
    <div class="module-13-tabs">
        <button type="button" class="module-13-tab-btn active" data-target="m13-football">
            ⚽ Bóng đá
        </button>
        <button type="button" class="module-13-tab-btn" data-target="m13-tennis">
            🎾 Tennis
        </button>
        <button type="button" class="module-13-tab-btn" data-target="m13-pic">
            🏓 Pickleball
        </button>
    </div>

    <!-- Match list panels -->
    <div class="module-13-panels">
        <?php foreach ($fixtures as $sport_key => $matches) : ?>
            <div class="module-13-panel <?php echo $sport_key === 'football' ? 'active' : ''; ?>" id="m13-<?php echo esc_attr($sport_key); ?>">
                <?php foreach ($matches as $match) : ?>
                    <div class="module-13-match-row <?php echo $match['is_live'] ? 'is-live-match' : ''; ?>">
                        <div class="module-13-tournament-tag">
                            <?php echo esc_html($match['tournament']); ?>
                            <span class="match-time-tag"><?php echo esc_html($match['time']); ?></span>
                        </div>

                        <div class="module-13-match-teams">
                            <div class="module-13-team team-home">
                                <span class="team-icon"><?php echo $match['logo_a']; ?></span>
                                <span class="team-name"><?php echo esc_html($match['team_a']); ?></span>
                                <span class="team-score"><?php echo esc_html($match['score_a']); ?></span>
                            </div>
                            
                            <div class="module-13-status-center">
                                <?php if ($match['is_live']) : ?>
                                    <span class="badge-live"><?php echo esc_html($match['status']); ?></span>
                                <?php else : ?>
                                    <span class="badge-status"><?php echo esc_html($match['status']); ?></span>
                                <?php endif; ?>
                            </div>

                            <div class="module-13-team team-away">
                                <span class="team-score"><?php echo esc_html($match['score_b']); ?></span>
                                <span class="team-name"><?php echo esc_html($match['team_b']); ?></span>
                                <span class="team-icon"><?php echo $match['logo_b']; ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="module-13-footer">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="module-13-all-link">
            Xem toàn bộ bảng xếp hạng & kết quả <i class="fa fa-angle-right"></i>
        </a>
    </div>
</div>

<script>
(function() {
    document.addEventListener('DOMContentLoaded', function() {
        var buttons = document.querySelectorAll('.module-13-tab-btn');
        buttons.forEach(function(btn) {
            btn.addEventListener('click', function() {
                var targetId = this.getAttribute('data-target');
                var container = this.closest('.custom-module-13-fixtures-widget');
                if (!container) return;

                container.querySelectorAll('.module-13-tab-btn').forEach(function(b) {
                    b.classList.remove('active');
                });
                container.querySelectorAll('.module-13-panel').forEach(function(p) {
                    p.classList.remove('active');
                });

                this.classList.add('active');
                var targetPanel = container.querySelector('#' + targetId);
                if (targetPanel) {
                    targetPanel.classList.add('active');
                }
            });
        });
    });
})();
</script>
