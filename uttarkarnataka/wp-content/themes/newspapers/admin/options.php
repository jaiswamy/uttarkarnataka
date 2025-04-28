<?php
/**
 * Theme Options.
 *
 * @package    Newspaper
 * @author     Theme Junkie
 * @copyright  Copyright (c) 2015, Theme Junkie
 * @license    http://www.gnu.org/licenses/gpl-2.0.html
 * @since      1.0.0
 */

/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 *
 * @since  1.0.0
 */
function optionsframework_option_name() {
	return 'newspaper'; // Theme slug
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * @since  1.0.0
 */
function optionsframework_options() {

	// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	$options_categories[''] = __( 'All Categories', 'newspaper' );
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}

	// Pull all tags into an array
	$options_tags = array();
	$options_tags_obj = get_tags();
	$options_tags[''] = __( 'All Tags', 'newspaper' );
	foreach ( $options_tags_obj as $tag ) {
		$options_tags[$tag->term_id] = $tag->name;
	}

	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages( 'sort_column=post_parent,menu_order' );
	$options_pages[''] = __( 'Select a page:', 'newspaper' );
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}

	$header_array = array(
		'quotes' => __( 'Logo - center', 'newspaper' ),
		'advertisement' => __( 'Logo + ad', 'newspaper' )
	);

	$featured_array = array(
		'slider' => __( 'slider', 'newspaper' ),
		'classic' => __( 'classic', 'newspaper' ),
		'disable' => __( 'disable', 'newspaper' )
	);

	// Image path
	$imagepath =  get_template_directory_uri() . '/assets/img/';

	// Set empty $options.
	$options = array();

	/**
	 * Defines array of options.
	 */
	
	// ============================ //
	// ===== General Settings ===== //
	// ============================ //
	$options[] = array(
		'name' => __( 'General', 'newspaper' ),
		'type' => 'heading'
	);

		$options['newspaper_colors'] = array(
			'name' => __( 'Accent Colors', 'newspaper' ),
			'desc' => __( 'Please choose the preset color for your website.', 'newspaper' ),
			'id'   => 'newspaper_colors',
			'type' => 'radio',
			'std'  => 'blue',
			'options' => array(
				'blue'        => __( 'Blue', 'newspaper' ),
				'green'       => __( 'Green', 'newspaper' ),
				'red'  		  => __( 'Red', 'newspaper' ),
			)
		);

		$options['newspaper_color_pallete'] = array(
			'name' => '',
			'desc' => __( 'If you don\' like the preset colors, you can choose the color you like from the pallete.', 'newspaper' ),
			'id'   => 'newspaper_color_pallete',
			'std'  => '#369',
			'type' => 'color'
		);

		$options['newspaper_favicon'] = array(
			'name' => __( 'Favicon', 'newspaper' ),
			'desc' => __( 'Your custom favicon. 32x32px recommended.', 'newspaper' ),
			'id'   => 'newspaper_favicon',
			'type' => 'upload'
		);

		$options['newspaper_mobile_icon'] = array(
			'name' => __( 'Mobile Icon', 'newspaper' ),
			'desc' => __( '144x144 recommended in PNG format. This icon will be used when users add your website as a shortcut on mobile devices like iPhone, iPad, Android etc.', 'newspaper' ),
			'id'   => 'newspaper_mobile_icon',
			'type' => 'upload'
		);

		$options[] = array(
			'name'  => __( 'FeedBurner URL', 'newspaper' ),
			'desc'  => __( 'Enter your full FeedBurner URL. If you wish to use FeedBurner over the standard WordPress feed.', 'newspaper' ),
			'id'    => 'newspaper_feedburner_url',
			'placeholder' => 'http://feeds.feedburner.com/ThemeJunkie',
			'type'  => 'text'
		);

		$options['newspaper_tracking_code'] = array(
			'name' => __( 'Tracking Code', 'newspaper' ),
			'desc' => __( 'Paste your Google Analytics (or other) tracking code here. It will be inserted before the closing body tag of your theme.', 'newspaper' ),
			'id'   => 'newspaper_tracking_code',
			'type' => 'textarea'
		);

	// ============================ //
	// ===== Header Settings ===== //
	// ============================ //
	$options[] = array(
		'name' => __( 'Header', 'newspaper' ),
		'type' => 'heading'
	);

		$options['newspaper_logo'] = array(
			'name' => __( 'Logo', 'newspaper' ),
			'desc' => __( 'Upload your custom logo, it will automatically replace the Site Title', 'newspaper' ),
			'id'   => 'newspaper_logo',
			'type' => 'upload'
		);

		$options['newspaper_logo_retina'] = array(
			'name' => __( 'Retina Logo', 'newspaper' ),
			'desc' => __( 'Upload your retina version of your logo. eg: logo@2x.png', 'newspaper' ),
			'id'   => 'newspaper_logo_retina',
			'type' => 'upload'
		);

		$options[] = array(
			'name' => __( 'Site Description', 'newspaper' ),
			'desc' => __( 'Display the site description.', 'newspaper' ),
			'id'   => 'newspaper_site_desc',
			'std'  => 'on',
			'type' => 'onoff'
		);

		$options['newspaper_header_style'] = array(
				'name' => __( 'Header Style', 'newspaper' ),
				'desc' => __( 'header style', 'newspaper' ),
				'id' => 'newspaper_header_style',
				'std' => 'quotes',
				'type' => 'select',
				'class' => 'mini', //mini, tiny, small
				'options' => $header_array
			);

		$options[] = array(
				'name'    => __( 'Breaking Posts Tag', 'newspaper' ),
				'desc'    => __( 'Select a tag to be used as Breaking Posts.', 'newspaper' ),
				'id'      => 'newspaper_breaking_tag',
				'type'    => 'select',
				'options' => $options_tags
			);

		$options[] = array(
			'name' => __( 'Social Settings', 'newspaper' ),
			'id'   => '',
			'type' => 'seperator'
		);

			$options[] = array(
				'name' => __( 'Enable', 'newspaper' ),
				'desc' => __( 'Enable social icons in header.', 'newspaper' ),
				'id'   => 'newspaper_enable_social_header',
				'std'  => 'on',
				'type' => 'onoff'
			);

			$options[] = array(
				'name'        => __( 'Twitter URL', 'newspaper' ),
				'desc'        => __( 'Enter your twitter profile URL.', 'newspaper' ),
				'id'          => 'newspaper_twitter_url',
				'placeholder' => 'http://twitter.com/',
				'type'        => 'text'
			);

			$options[] = array(
				'name'        => __( 'Facebook URL', 'newspaper' ),
				'desc'        => __( 'Enter your facebook profile  URL.', 'newspaper' ),
				'id'          => 'newspaper_fb_url',
				'placeholder' => 'http://www.facebook.com/',
				'type'        => 'text'
			);

			$options[] = array(
				'name'        => __( 'Google Plus URL', 'newspaper' ),
				'desc'        => __( 'Enter your google plus profile  URL.', 'newspaper' ),
				'id'          => 'newspaper_gplus_url',
				'placeholder' => 'http://plus.google.com/',
				'type'        => 'text'
			);

			$options[] = array(
				'name'  => __( 'Feed URL', 'newspaper' ),
				'desc'  => __( 'Enter your website feed URL.', 'newspaper' ),
				'id'    => 'newspaper_feed_url',
				'std'   => esc_url( get_feed_link() ),
				'type'  => 'text'
			);

	// ======================================== //
	// ===== Index and Archive Settings ======= //
	// ======================================== //
	$options[] = array(
		'name' => __( 'Index and Archive', 'newspaper' ),
		'type' => 'heading'
	);

		$options[] = array(
			'name' => __( 'Home Featured Posts Settings', 'newspaper' ),
			'id'   => '',
			'type' => 'seperator'
		);

			$options['newspaper_featured_content'] = array(
				'name' => __( 'Home featured', 'newspaper' ),
				'desc' => __( 'home featured layout', 'newspaper' ),
				'id' => 'newspaper_featured_content',
				'std' => 'slider',
				'type' => 'select',
				'class' => 'mini', //mini, tiny, small
				'options' => $featured_array
			);


			$options[] = array(
				'name'    => __( 'Featured Posts Tag', 'newspaper' ),
				'desc'    => __( 'Select a tag to be used as Featured Posts.', 'newspaper' ),
				'id'      => 'newspaper_featured_tag',
				'type'    => 'select',
				'options' => $options_tags
			);

			$options[] = array(
				'name'  => __( 'Limit (slider)', 'newspaper' ),
				'desc'  => __( 'Number of posts to show.', 'newspaper' ),
				'id'    => 'newspaper_featured_num',
				'std'   => 3,
				'type'  => 'text'
			);

		$options[] = array(
			'name' => __( 'Posts Listing Settings', 'newspaper' ),
			'id'   => '',
			'type' => 'seperator'
		);

			$options[] = array(
				'name'  => __( 'All Stories', 'newspaper' ),
				'desc'  => __( 'Customize the All Stories text.', 'newspaper' ),
				'id'    => 'newspaper_wn_text',
				'std'   => __( 'All Stories', 'newspaper' ),
				'type'  => 'text'
			);

			$options['newspaper_index_layout'] = array(
				'name'   => __( 'Index Posts Layout', 'newspaper' ),
				'desc'   => __( 'Choose the index posts layout.', 'newspaper' ),
				'id'     => 'newspaper_index_layout',
				'std'    => 'list',
				'type'   => 'select',
				'options' => array(
					'grid'   => __( 'Grid', 'newspaper' ),
					'list'   => __( 'List', 'newspaper' ),
					'blog'   => __( 'Blog', 'newspaper' ),
				)
			);

			$options['newspaper_tag_layout'] = array(
				'name'   => __( 'Tag Posts Layout', 'newspaper' ),
				'desc'   => __( 'Choose the tag archive page posts layout.', 'newspaper' ),
				'id'     => 'newspaper_tag_layout',
				'std'    => 'list',
				'type'   => 'select',
				'options' => array(
					'grid'   => __( 'Grid', 'newspaper' ),
					'list'   => __( 'List', 'newspaper' ),
					'blog'   => __( 'Blog', 'newspaper' ),
				)
			);

			$options['newspaper_author_layout'] = array(
				'name'   => __( 'Author Posts Layout', 'newspaper' ),
				'desc'   => __( 'Choose the author archive page posts layout.', 'newspaper' ),
				'id'     => 'newspaper_author_layout',
				'std'    => 'list',
				'type'   => 'select',
				'options' => array(
					'grid'   => __( 'Grid', 'newspaper' ),
					'list'   => __( 'List', 'newspaper' ),
					'blog'   => __( 'Blog', 'newspaper' ),
				)
			);

			$options['newspaper_search_layout'] = array(
				'name'   => __( 'Search Posts Layout', 'newspaper' ),
				'desc'   => __( 'Choose the search page posts layout.', 'newspaper' ),
				'id'     => 'newspaper_search_layout',
				'std'    => 'list',
				'type'   => 'select',
				'options' => array(
					'grid'   => __( 'Grid', 'newspaper' ),
					'list'   => __( 'List', 'newspaper' ),
					'blog'   => __( 'Blog', 'newspaper' ),
				)
			);

			$options['newspaper_archive_layout'] = array(
				'name'   => __( 'Archive Posts Layout', 'newspaper' ),
				'desc'   => __( 'Choose the archive page(date, month, year) posts layout.', 'newspaper' ),
				'id'     => 'newspaper_archive_layout',
				'std'    => 'list',
				'type'   => 'select',
				'options' => array(
					'grid'   => __( 'Grid', 'newspaper' ),
					'list'   => __( 'List', 'newspaper' ),
					'blog'   => __( 'Blog', 'newspaper' ),
				)
			);

	// ================================ //
	// ===== Single Post Settings ===== //
	// ================================ //
	$options[] = array(
		'name' => __( 'Single Post', 'newspaper' ),
		'type' => 'heading'
	);

		$options[] = array(
			'name' => __( 'Facebook Comment Settings', 'newspaper' ),
			'id'   => '',
			'type' => 'seperator'
		);

			$options[] = array(
				'name' => __( 'Facebook Comment', 'newspaper' ),
				'desc' => __( 'Use facebook comment.', 'newspaper' ),
				'id'   => 'newspaper_fb_comment',
				'std'  => 'off',
				'type' => 'onoff'
			);

			$options[] = array(
				'name'        => __( 'App ID', 'newspaper' ),
				'desc'        => __( 'Enter your facebook App ID to enable facebook comment.', 'newspaper' ),
				'id'          => 'newspaper_fb_appid',
				'type'        => 'text'
			);

		$options[] = array(
			'name' => __( 'Disqus Comment Settings', 'newspaper' ),
			'id'   => '',
			'type' => 'seperator'
		);

			$options[] = array(
				'name' => __( 'Disqus Comment', 'newspaper' ),
				'desc' => __( 'Use disqus comment.', 'newspaper' ),
				'id'   => 'newspaper_disqus_comment',
				'std'  => 'off',
				'type' => 'onoff'
			);

			$options[] = array(
				'name' => __( 'Disqus Shortname', 'newspaper' ),
				'desc' => __( 'Enter your disqus shortname.', 'newspaper' ),
				'id'   => 'newspaper_disqus_shortname',
				'type' => 'text'
			);

		$options[] = array(
			'name' => __( 'Post Misc Settings', 'newspaper' ),
			'id'   => '',
			'type' => 'seperator'
		);

			$options['newspaper_featured_image'] = array(
				'name' => __( 'Featured Image', 'newspaper' ),
				'desc' => __( 'Display featured image.', 'newspaper' ),
				'id'   => 'newspaper_featured_image',
				'std'  => 'on',
				'type' => 'onoff'
			);

			$options['newspaper_post_author'] = array(
				'name' => __( 'Author Bio', 'newspaper' ),
				'desc' => __( 'Display author bio.', 'newspaper' ),
				'id'   => 'newspaper_post_author',
				'std'  => 'on',
				'type' => 'onoff'
			);

			$options['newspaper_share_buttons'] = array(
				'name' => __( 'Share Buttons', 'newspaper' ),
				'desc' => __( 'Display the social share buttons info.', 'newspaper' ),
				'id'   => 'newspaper_share_buttons',
				'std'  => 'on',
				'type' => 'onoff'
			);

		$options[] = array(
			'name' => __( 'Related Posts Settings', 'newspaper' ),
			'id'   => '',
			'type' => 'seperator'
		);

			$options['newspaper_related_posts'] = array(
				'name' => __( 'Related Posts', 'newspaper' ),
				'desc' => __( 'Display the related posts.', 'newspaper' ),
				'id'   => 'newspaper_related_posts',
				'std'  => 'on',
				'type' => 'onoff'
			);

		$options[] = array(
			'name' => __( 'Advertisement Settings', 'newspaper' ),
			'id'   => '',
			'type' => 'seperator'
		);

			$options['newspaper_ad_single_before'] = array(
				'name' => __( 'Before Content Advertisement', 'newspaper' ),
				'desc' => __( 'Your ad will appear on single post before content.', 'newspaper' ),
				'id'   => 'newspaper_ad_single_before',
				'type' => 'textarea'
			);

			$options['newspaper_ad_single_after'] = array(
				'name' => __( 'After Content Advertisement', 'newspaper' ),
				'desc' => __( 'Your ad will appear on single post after content.', 'newspaper' ),
				'id'   => 'newspaper_ad_single_after',
				'type' => 'textarea'
			);

	// =========================== //
	// ===== Footer Settings ===== //
	// =========================== //
	$options[] = array(
		'name' => __( 'Footer', 'newspaper' ),
		'type' => 'heading'
	);

		$options['newspaper_footer_text'] = array(
			'name' => __( 'Footer Text', 'newspaper' ),
			'desc' => __( 'You can customize the footer text here.', 'newspaper' ),
			'id'   => 'newspaper_footer_text',
			'std'  => 'Powered by <a href="http://wordpress.org">WordPress</a> · Designed by <a href="http://www.theme-junkie.com" title="Premium WordPress Themes">Theme Junkie</a>',
			'type' => 'editor'
		);

	// ================================== //
	// ===== Advertisement Settings ===== //
	// ================================== //
	$options[] = array(
		'name' => __( 'Advertisement', 'newspaper' ),
		'type' => 'heading'
	);

		$options['newspaper_header_ad'] = array(
			'name' => __( 'Header Advertisement', 'newspaper' ),
			'desc' => __( 'The ad will appear at the top of your site. Recommended size 728x90', 'newspaper' ),
			'id'   => 'newspaper_header_ad',
			'type' => 'textarea'
		);

		$options['newspaper_archive_ad'] = array(
			'name' => __( 'Archive Advertisement', 'newspaper' ),
			'desc' => __( 'The ad will appear between featured section and all stories. Recommended size 468x60', 'newspaper' ),
			'id'   => 'newspaper_archive_ad',
			'type' => 'textarea'
		);

	// ================================== //
	// ===== Custom Code Settings ======= //
	// ================================== //
	$options[] = array(
		'name' => __( 'Custom Code', 'newspaper' ),
		'type' => 'heading'
	);

		$options['newspaper_script_head'] = array(
			'name' => __( 'Header code', 'newspaper' ),
			'desc' => __( 'If you need to add custom scripts to your header (meta tag verification, google fonts url), you should enter them in the box. They will be added before &lt;/head&gt; tag', 'newspaper' ),
			'id'   => 'newspaper_script_head',
			'type' => 'textarea'
		);

		$options['newspaper_script_footer'] = array(
			'name' => __( 'Footer code', 'newspaper' ),
			'desc' => __( 'If you need to add custom scripts to your footer, you should enter them in the box. They will be added before &lt;/body&gt; tag', 'newspaper' ),
			'id'   => 'newspaper_script_footer',
			'type' => 'textarea'
		);
	
	// Allow dev to filter the theme options.
	return apply_filters( 'newspaper_theme_options', $options );
}