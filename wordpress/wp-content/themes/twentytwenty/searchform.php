<?php
/**
 * The searchform.php template.
 *
 * Used any time that get_search_form() is called.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

/*
 * Generate a unique ID for each form and a string containing an aria-label
 * if one was passed to get_search_form() in the args array.
 */
$twentytwenty_unique_id = twentytwenty_unique_id( 'search-form-' );

$twentytwenty_aria_label = ! empty( $args['aria_label'] ) ? 'aria-label="' . esc_attr( $args['aria_label'] ) . '"' : '';
// Backward compatibility, in case a child theme template uses a `label` argument.
if ( empty( $twentytwenty_aria_label ) && ! empty( $args['label'] ) ) {
	$twentytwenty_aria_label = 'aria-label="' . esc_attr( $args['label'] ) . '"';
}
?>
<form role="search" <?php echo $twentytwenty_aria_label; ?> method="get" class="search-form card card-sm bootsnipp-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="card-body row no-gutters align-items-center">
		<div class="col-auto">
			<i class="fas fa-search h4 text-body search-icon" aria-hidden="true"></i>
		</div>
		<!--end of col-->
		<div class="col">
			<label for="<?php echo esc_attr( $twentytwenty_unique_id ); ?>" class="screen-reader-text">
				<?php
				/* translators: Hidden accessibility text. */
				_e( 'Search for:', 'twentytwenty' );
				?>
			</label>
			<input class="form-control form-control-lg form-control-borderless search-field" id="<?php echo esc_attr( $twentytwenty_unique_id ); ?>" type="search" placeholder="<?php echo esc_attr_x( 'Search topics or keywords', 'placeholder', 'twentytwenty' ); ?>" value="<?php echo ( is_search() && ! have_posts() ) ? '' : esc_attr( get_search_query() ); ?>" name="s" />
		</div>
		<!--end of col-->
		<div class="col-auto">
			<button class="btn btn-lg btn-success search-submit" type="submit"><?php echo esc_attr_x( 'Search', 'submit button', 'twentytwenty' ); ?></button>
		</div>
		<!--end of col-->
	</div>
</form>
