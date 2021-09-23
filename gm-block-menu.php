<?php

namespace GMBlockMenu;

/**
 * Plugin Name:       Gm Block Menu
 * Description:       This plugin allows you to display menu in a block.
 * Requires at least: 5.7
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Faramaz Patrick <infos@goodmotion.fr>
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       gm-block-menu
 *
 * @package           goodmotion
 */



function block_init()
{
	register_block_type_from_metadata(__DIR__, [
		"render_callback" => __NAMESPACE__ . '\render_callback',
		'attributes' => [
			'categories' => [
				'type' => "array",
				'items' => [
					'type' => 'number',
				],
				'default' => []
			],
			'blocTitle' => [
				'type' => "string",
				'default' => "La carte"
			],
			'textColor' => [
				'type' => "string",
			],
			'backgroundColor' => [
				'type' => "string",
			],
			'isAdmin' => [
				'type' => "boolean",
				'default' => false
			]
		]
	]);
}
add_action('init', __NAMESPACE__ . '\block_init');


function render_callback($attributes, $content)
{

	$query = array(
		// limit element
		'posts_per_page'    => $attributes['total'] ?? 100,
		// post type
		'post_type'            => 'menus',
		'meta_key'       => 'menu_order',
		'orderby'        => 'meta_value_num',
		'order'   => 'ASC',
	);

	// if category selected
	if (array_key_exists('categories', $attributes) && count($attributes['categories']) > 0) {
		$query['tax_query'] = array(
			array(
				'taxonomy' => 'menus_categories',
				'field' => 'id',
				'terms' => $attributes['categories'],
				'operator' => 'IN'
			)
		);
	}
	// query
	$recent_posts = new \Timber\PostQuery($query);
	$context          = \Timber::context();
	$context['title_list_menus'] = $attributes['blocTitle'] ?? '';
	$context['text_color'] = $attributes['textColor'] ?? '';
	$context['background_color'] = $attributes['backgroundColor'] ?? '';
	$context['posts'] = $recent_posts;
	$context['isAdmin'] = $attributes['isAdmin'] ?? false;

	// render template
	return \Timber::compile('blocks/menu.twig', $context);
}
