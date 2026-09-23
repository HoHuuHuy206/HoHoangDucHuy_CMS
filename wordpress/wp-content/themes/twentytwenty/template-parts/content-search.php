<?php
/**
 * The template part for displaying results in search pages
 * Styled after TDC FIT news card layout (Task 5: Search result)
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

$post       = get_post();
$post_date  = get_the_date( 'd', $post->ID );
$post_month = get_the_date( 'm', $post->ID );
$has_thumb  = has_post_thumbnail( $post->ID );
?>

<article <?php post_class( 'search-result-card' ); ?> id="post-<?php the_ID(); ?>">
	<div class="search-result-card-inner">
		<!-- Thumbnail Column -->
		<div class="search-result-thumbnail">
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
				<?php if ( $has_thumb ) { ?>
					<?php echo get_the_post_thumbnail( $post->ID, 'medium', array( 'class' => 'search-result-img', 'alt' => get_the_title() ) ); ?>
				<?php } else { ?>
					<div class="search-result-placeholder-img">
						<svg width="48" height="48" fill="none" stroke="#adb5bd" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="3" rx="2" ry="2" stroke-width="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21" stroke-width="2"></polyline></svg>
					</div>
				<?php } ?>
			</a>
		</div>

		<!-- Date Box Column -->
		<div class="search-result-date-box">
			<span class="search-result-day"><?php echo esc_html( $post_date ); ?></span>
			<span class="search-result-month"><?php echo esc_html( 'THÁNG ' . $post_month ); ?></span>
		</div>

		<!-- Content Column -->
		<div class="search-result-content">
			<h3 class="search-result-title">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h3>
			<div class="search-result-excerpt">
				<p><?php echo wp_trim_words( get_the_excerpt(), 28, '[...]' ); ?></p>
			</div>
		</div>
	</div>
</article>
