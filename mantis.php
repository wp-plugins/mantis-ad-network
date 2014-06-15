<?php
/*
Plugin Name: Mantis Ad Network
Plugin URI: http://wordpress.org/extend/plugins/mantis-ad-network/
Description: Easily serve advertisements from the Mantis Ad Network on your website.
Version: 1.1.6
Author: Mantis Ad Network
Author URI: http://www.mantisadnetwork.com
Author Email: contact@mantisadnetwork.com
License:

	The MIT License (MIT)

	Copyright (c) 2014 Mantis Ad Network <contact@mantisadnetwork.com>

	Permission is hereby granted, free of charge, to any person obtaining a copy
	of this software and associated documentation files (the "Software"), to deal
	in the Software without restriction, including without limitation the rights
	to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
	copies of the Software, and to permit persons to whom the Software is
	furnished to do so, subject to the following conditions:

	The above copyright notice and this permission notice shall be included in
	all copies or substantial portions of the Software.

	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
	IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
	FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
	AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
	LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
	OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
	THE SOFTWARE.
*/

define('MANTIS_ROOT', dirname(__FILE__));

require_once(MANTIS_ROOT . '/admin.php');
require_once(MANTIS_ROOT . '/widget.php');

function mantis_always_footer()
{
	if (get_option('mantis_always')) {
		if (!has_action('wp_footer', 'mantis_ad_footer')) {
			add_action('wp_footer', 'mantis_ad_footer', 20);
		}
	}
}

add_action('init', 'mantis_always_footer');

/**
 * Action is registered as wp_footer if at least one advertisement is on the page
 */
function mantis_ad_footer()
{	
	$site = get_option('mantis_site_id');

	if (!$site) {
		return;
	}

	require(dirname(__FILE__) . '/html/config.php');

	require(dirname(__FILE__) . '/html/styling.php');

	if (get_option('mantis_async')) {
		require(dirname(__FILE__) . '/html/async.html');
	} else {
		require(dirname(__FILE__) . '/html/sync.html');
	}
}
