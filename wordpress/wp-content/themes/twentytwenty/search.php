<?php
/**
 * The template for displaying Search Results pages
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

get_header();
?>

<main id="site-content">

	<?php
	global $wp_query;

	$archive_title = sprintf(
		'%1$s &ldquo;%2$s&rdquo;',
		'<span class="color-accent">' . __( 'Search:', 'twentytwenty' ) . '</span>',
		esc_html( get_search_query( false ) )
	);

	if ( $wp_query->found_posts ) {
		$archive_subtitle = sprintf(
			/* translators: %s: Number of search results. */
			_n(
				'We found %s result for your search.',
				'We found %s results for your search.',
				$wp_query->found_posts,
				'twentytwenty'
			),
			number_format_i18n( $wp_query->found_posts )
		);
	} else {
		$archive_subtitle = __( 'We could not find any results for your search. You can give it another try through the search form below.', 'twentytwenty' );
	}
	?>

	<header class="archive-header has-text-align-center header-footer-group">
		<div class="archive-header-inner section-inner medium">
			<h1 class="archive-title"><?php echo wp_kses_post( $archive_title ); ?></h1>
			<div class="archive-subtitle section-inner thin max-percentage intro-text">
				<?php echo wp_kses_post( wpautop( $archive_subtitle ) ); ?>
			</div>
		</div><!-- .archive-header-inner -->
	</header><!-- .archive-header -->

	<?php if ( have_posts() ) { ?>

		<div class="search-results-wrapper section-inner">
			<div class="search-results-list">
				<?php
				while ( have_posts() ) {
					the_post();
					get_template_part( 'template-parts/content', 'search' );
				}
				?>
			</div><!-- .search-results-list -->
		</div><!-- .search-results-wrapper -->

		<?php get_template_part( 'template-parts/pagination' ); ?>

	<?php } else { ?>

		<div class="no-search-results-form section-inner thin">
			<?php
			get_search_form(
				array(
					'aria_label' => __( 'search again', 'twentytwenty' ),
				)
			);
			?>
		</div><!-- .no-search-results-form -->

	<?php } ?>

</main><!-- #site-content -->

<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php
get_footer();
