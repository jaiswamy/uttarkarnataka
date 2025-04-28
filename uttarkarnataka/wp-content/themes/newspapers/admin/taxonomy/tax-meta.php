<?php
/**
 * Custom taxonomies custom fields.
 *
 * @package    Newspaper
 * @author     Theme Junkie
 * @copyright  Copyright (c) 2014, Theme Junkie
 * @license    http://www.gnu.org/licenses/gpl-2.0.html
 * @since      1.0.0
 */

if ( is_admin() ) {

	/* 
	 * Configure your meta box.
	 */
	$config = array(
		'id'             => 'newspaper_cat_metabox',
		'title'          => __( 'Newspaper Category Metabox', 'newspaper' ),
		'pages'          => array( 'category' ),
		'context'        => 'normal',
		'fields'         => array(),
		'local_images'   => false,
		'use_with_theme' => get_template_directory_uri() . '/admin/taxonomy'
	);

	/*
	 * Initiate your meta box.
	 */
	$my_meta =  new Tax_Meta_Class( $config );

	// Pull all tags into an array.
	$tags = array();
	$tags_obj = get_tags();
	$tags[''] = __( 'All Tags', 'newspaper' );
	foreach ( $tags_obj as $tag ) {
		$tags[$tag->term_id] = esc_html( $tag->name );
	}
		
	/**
	 * Taxonomy field.
	 */
	$my_meta->addSelect( 'newspaper_cat_layout',
		array( 
			'grid' => __( 'Grid', 'newspaper' ),
			'list'  => __( 'List', 'newspaper' ),
			'blog'   => __( 'Blog', 'newspaper' ),
		),
		array( 'name'=> __( 'Category Layout Style', 'newspaper' ), 'std' => array( 'list' ) )
	);

	$my_meta->addSelect( 'newspaper_featured_tag',
		$tags,
		array( 'name'=> __( 'Featured Posts Tag', 'newspaper' ) )
	);

	$my_meta->addSelect( 'newspaper_featured_layout',
		array( 
			'classic' => __( 'Classic', 'newspaper' ),
			'slider'  => __( 'Slider', 'newspaper' ),
		),
		array( 'name'=> __( 'Featured Posts Style', 'newspaper' ), 'std' => array( 'classic' ) )
	);

	/**
	 * Finish.
	 */
	$my_meta->Finish();

}