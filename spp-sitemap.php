<?php
/*
Plugin Name: SPP HTML Sitemap
Plugin URI: http://www.prasannasp.net/how-to-create-an-html-sitemap-in-wordpress/
Description: This plugin creates an HTML sitemap listing all posts and pages. Sitemap can be displayed anywhere with [spp-sitemap] shortcode
Author: Prasanna SP
Version: 1.0
Author URI: http://www.prasannasp.net/
*/
/*
 *  This file is part of SPP HTML Sitemap plugin. (c) Prasanna SP (email: prasanna[AT]prasannasp.net)
 *  
 *  SPP HTML Sitemap is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    SPP HTML Sitemap is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with SPP HTML Sitemap plugin. If not, see <http://www.gnu.org/licenses/>.
*/
function spp_html_sitemap() {
 $spp_sitemap = '';
 $published_posts = wp_count_posts('post');
 $spp_sitemap .= '<h4 id="sitemap-posts-h4">Here is a list of of my '.$published_posts->publish.' published posts</h4>';
 
 $args = array(
  'exclude' => '', //ID of categories to be excluded, separated by comma
  'post_type' => 'post',
  'post_status' => 'publish'
  );
	$cats = get_categories($args);
	foreach ($cats as $cat) :
	$spp_sitemap .= '<div>';
	$spp_sitemap .= '<h3>Category: <a href="'.get_category_link( $cat->term_id ).'">'.$cat->cat_name.'</a></h3>';
	$spp_sitemap .= '<ul>';

  query_posts('posts_per_page=-1&cat='.$cat->cat_ID);
  while(have_posts()) {
    the_post();
    $category = get_the_category();
    // Only display a post link once, even if it's in multiple categories
    if ($category[0]->cat_ID == $cat->cat_ID) {
    	$spp_sitemap .= '<li class="cat-list"><a href="'.get_permalink().'" rel="bookmark">'.get_the_title().'</a></li>';
      
    }
  }
  $spp_sitemap .= '</ul>';
  $spp_sitemap .= '</div>';

  endforeach;
  
  $pages_args = array(
	'exclude' => '', //ID of pages to be excluded, separated by comma
	'post_type' => 'page',
	'post_status' => 'publish'
	); 
  
  $spp_sitemap .= '<h3>Pages</h3>';
  $spp_sitemap .= '<ul>';
  $pages = get_pages($pages_args); 
  foreach ( $pages as $page ) :
  $spp_sitemap .= '<li class="pages-list"><a href="'.get_page_link( $page->ID ).'" rel="bookmark">'.$page->post_title.'</a></li>';
  endforeach;
  $spp_sitemap .= '<ul>';
 
 return $spp_sitemap;
}
add_shortcode( 'spp-sitemap','spp_html_sitemap' );
