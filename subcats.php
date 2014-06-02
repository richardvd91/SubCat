<?php
/*
Plugin Name: Display subcategories
Plugin URI:
Description: Display's subcategories of selected categrie used with current post
Author: Richard van Denderen
Version: 0.1
Author URI: http://vandenderenmedia.com/
*/

// Add Shortcode
function vdm_childCatsListing( $atts ) {
	global $wp_query;
	$postid = $wp_query->post->ID;

	// Attributes
	extract( shortcode_atts(
		array(
			'parent' => '',
		), $atts )
		//print_r($atss)
	);


	$taxonomy = 'category';
	$vdm_catid = get_category_by_slug($parent);

	if ( !empty($vdm_catid)){
		$vdm_cat = $vdm_catid->term_id;

		// get the term IDs assigned to post.
		$post_terms = wp_get_object_terms( $postid, $taxonomy, array( 'fields' => 'ids' ) );
		// separator between links
		$separator = ', ';

		if ( !empty( $post_terms ) && !is_wp_error( $post_terms ) ) {

			$term_ids = implode( ',' , $post_terms );
			$terms = wp_list_categories( 'title_li=&style=none&echo=0&show_option_none=&taxonomy=' . $taxonomy . '&include=' . $term_ids .'&child_of='.$vdm_cat);
			$terms = rtrim( trim( str_replace( '<br />',  $separator, $terms ) ), $separator );

			// display post categories
			return($terms);
			$parent = '';
		}
	}


}
add_shortcode( 'childcats', 'vdm_childCatsListing' );

?>
