<?php
/**
 * Plugin Name: Gallery Just Better
 * Plugin URI: http://www.stefaniamarchisio.com/gallery-just-better-plugin/
 * Description: A gallery of images displayed as native gallery does with a few extra features.
 * Version: 0.2
 * Author: Stefania Marchisio
 * Author URI: http://stefaniamarchisio.com/about/
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/* 
This is a wordpress plugin compatible with wordpress 2.5+.

Copyright (C) 2011  Stefania Marchisio (email: mywizardwebs@gmail.com)

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

add_shortcode('galleryjb', 'galleryjb_handler');

// [galleryjb]
function galleryjb_handler($attr) {
	global $post, $wp_locale;

	static $instance = 0;
	$instance++;

	// Allow plugins/themes to override the default gallery template.
	$output = apply_filters('post_gallery', '', $attr);
	if ( $output != '' )
		return $output;

	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $atts['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}

	extract(shortcode_atts(array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'itemtag'    => 'dl',
		'icontag'    => 'dt',
		'captiontag' => 'dd',
		'columns'    => 3,
		'size'       => 'thumbnail',
		'include'    => '',
		'exclude'    => '',
		'link'       => '',
		'target'     => false,
		'author'     => true
	), $attr));

	$id = intval($id);
	if ( 'RAND' == $order )
		$orderby = 'none';

	if ( !empty($include) ) {
		$include = preg_replace( '/[^0-9,]+/', '', $include );
		$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( !empty($exclude) ) {
		$exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
		$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	} else {
		$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	}

	if ( empty($attachments) )
		return '';

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment )
			$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
		return $output;
	}

	$itemtag = tag_escape($itemtag);
	$captiontag = tag_escape($captiontag);
	$columns = intval($columns);
	
	$itemwidth = ($columns > 0) ? floor(100/$columns) : '100';

	$float = is_rtl() ? 'right' : 'left';

	$selector = "gallery-{$instance}";

	$gallery_style = $gallery_div = '';
	if ( apply_filters( 'use_default_gallery_style', true ) )
		$gallery_style = "
		<style type='text/css'>
			#{$selector} {
				margin: auto;
			}
			#{$selector} .gallery-item {
				float: {$float};
				margin-top: 10px;
				text-align: center;
				width: {$itemwidth}%;
			}
			#{$selector} img {
				border: 2px solid #cfcfcf;
			}
			#{$selector} .gallery-caption {
				margin-left: 0;
			}
		</style>
		<!-- see gallery_shortcode() in wp-includes/media.php -->";
	$size_class = sanitize_html_class( $size );
	$gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";
	$output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );

	$i = 0;
	foreach ( $attachments as $id => $attachment ) {
		$link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, true, false);

		switch ($atts['link']) {
			case 'null': // images are not linked
				$link = wp_get_attachment_image($id, $size);
				break;
			case 'url': // images are linked to external URLs defined in Description textboxes
				$url = $attachment->post_content;
				$link = wp_get_attachment_linkedimg($id, $size, $url, $target);
				break;
			case 'file': // link images to their filenames (from native wp gallery)
				$url = wp_get_attachment_url($_post->ID);
				$link = wp_get_attachment_linkedimg($id, $size, $url, $target);
				break;
			default: // link images to their permalink (from native wp gallery)
				$url = get_attachment_link($_post->ID);
				$link = wp_get_attachment_linkedimg($id, $size, $url, $target);
		}
		$output .= "<{$itemtag} class='gallery-item'>";
		$output .= "
			<{$icontag} class='gallery-icon'>
				$link
			</{$icontag}>";
		
		if ( $captiontag && trim($attachment->post_excerpt) ) {
			$output .= "
				<{$captiontag} class='wp-caption-text gallery-caption'>
				" . wptexturize($attachment->post_excerpt) . "
				</{$captiontag}>";
		}
		$output .= "</{$itemtag}>";
		if ( $columns > 0 && ++$i % $columns == 0 )
			$output .= '<br style="clear: both" />';
		}

		$output .= "
			<br style='clear: both;' />
		</div>\n";

 	// if author has been selected
	if ($author !== false && $author !== "false") {
		$output .= '<p style="text-align:center; font-size: 0.8em">powered by <a target="_blank" href="http://www.stefaniamarchisio.com/gallery-just-better-plugin/">Gallery Just Better plugin</a></p>';

		$output .= '';
	}
	return $output;
}

/**
 * Retrieve an attachment page link using an image or icon, if possible.
 *
 * @since 2.5.0
 * @uses apply_filters() Calls 'wp_get_attachment_link' filter on HTML content with same parameters as function.
 *
 * @param int $id Optional. Post ID.
 * @param string $size Optional, default is 'thumbnail'. Size of image, either array or string.
 * @param bool $link Optional, default is false. Whether to add permalink to image.
 * @param string $target Optional, default is false. If true, then target link will be in new window.
 * @return string HTML content.
 */
function wp_get_attachment_linkedimg($id = 0, $size = 'thumbnail', $link = false, $target = false) {
	$id = intval($id);
	
	$_post = & get_post( $id );

	// if $size is proper then return the image tag <img src...> oth. return the image title only
	$visible_part =  ( ( is_int($size) && $size != 0 ) or ( is_string($size) && $size != 'none' ) or $size != false ) ? 
		wp_get_attachment_image($id, $size) : esc_attr($_post->post_title);

	// if link is not there then return the non-linkable image tag <img src...> or title only
	if ( !$link ) {
		return $visible_part ;
	}

	// manage linked object target window
	if ( $target ) 
		$target_window = "target='_blank'";
	
	return apply_filters( 'wp_get_attachment_linkedimg', "<a $target_window href='$link' title='$post_title'>$visible_part</a>", $id, $size, $link, $target );
}

?>