<?php

namespace GMBlockActu;

/**
 * Plugin Name:       Gm Block Actu
 * Update URI:        goodmotion-block-actu
 * Description:       This plugin allows you to display actuality in a block.
 * Requires at least: 5.7
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Faramaz Patrick <infos@goodmotion.fr>
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       gm-block-actu
 *
 * @package           goodmotion
 */



function block_init()
{
	register_block_type_from_metadata(__DIR__, [
		"render_callback" => __NAMESPACE__ . '\render_callback',
		'attributes' => []
	]);
}
add_action('init', __NAMESPACE__ . '\block_init');


function render_callback($attributes, $content)
{

	$query = array(
		// limit element
		// 'posts_per_page'    => $attributes['total'] ?? 100,
		// post type
		'post_type'            => 'post',
		'order'   => 'ASC',
	);

	// if category selected
	// if (array_key_exists('categories', $attributes)) {
	// 	$query['tax_query'] = array(
	// 		array(
	// 			'taxonomy' => 'menus_categories',
	// 			'field' => 'id',
	// 			'terms' => $attributes['categories'],
	// 			'operator' => 'IN'
	// 		)
	// 	);
	// }
	// query
	$recent_posts = new \Timber\PostQuery($query);
	$context          = \Timber::context();
	$context['posts'] = $recent_posts;

	// render template
	return \Timber::compile('blocks/actu.twig', $context);
}
