<?php

	/*
		Plugin Name: Lanci Server
		Plugin URI:
		Description: Otimizações do seu Servidor Lanci
		Version: 1.0
		Author: Divea Lanci
		Author URI: http://divea.com.br
	*/

	// composer autoload
	require_once "vendor/autoload.php";

	define("LANCI_PATH", dirname(__FILE__));
	define("LANCI_PUBLIC_PATH", plugin_dir_url(__FILE__));

	// inciando plugins-vendor
	if(defined("LANCI_SERVER_ALIAS")) {

		define("WP_REDIS_PREFIX", LANCI_SERVER_ALIAS."_");
		require "vendor/Nginx-FastCGI-Cache/nginx-cache.php";
		require "vendor/redis-cache/redis-cache.php";

	}

	// ativando plugin
	register_activation_hook( __FILE__, 'lanci_server_activate' );
	function lanci_server_activate() {
		\Lanci\App::activate();
	}

	// desativando plugin
	register_deactivation_hook( __FILE__, 'lanci_server_deactivate' );
	function lanci_server_deactivate($plugin) {
		\Lanci\App::deactivate($plugin);
	}

	// iniciando plugin
	add_action( 'init', '\Lanci\App::init');


	// add_filter( 'plugin_action_links', 'disable_plugin_deactivation', 10, 4 );
	// function disable_plugin_deactivation( $actions, $plugin_file, $plugin_data, $context ) 
	// {
	 
	//     if (array_key_exists( 'deactivate', $actions ) && in_array( $plugin_file, ['utilities-plugin/lanci.php'])
	//         unset($actions['deactivate']);
	//     return $actions;
	// }
	// 