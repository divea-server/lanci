<?php

	/*
		Plugin Name: Lanci Server
		Plugin URI:
		Description: Otimizações do seu Servidor Lanci
		Version: 1.2.10
		Author: Divea Lanci
		Author URI: http://divea.com.br
	*/

	// composer autoload
	require_once "vendor/autoload.php";
	
	define("LANCI_PATH", dirname(__FILE__));
	define("LANCI_PUBLIC_PATH", plugin_dir_url(__FILE__));
	
	// define("WP_REDIS_SELECTIVE_FLUSH", true);

	// recomendando outros plugins
	require_once "required.php";

	// inciando plugins-vendor
	if(defined("LANCI_SERVER_ALIAS")) {

		// define("WP_REDIS_PREFIX", LANCI_SERVER_ALIAS."_");

		if( ! class_exists("\NginxCache"))
		require "vendor/Nginx-FastCGI-Cache/nginx-cache.php";

		if( ! class_exists("\Rhubarb\RedisCache\Plugin"))
		require "vendor/redis-cache/redis-cache.php";

		if( ! class_exists("\CleanImageFilenames"))
		require "vendor/clean-image-filenames/clean-image-filenames.php";

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


	// verificando atualizações
	$lanci_update = \Puc_v4_Factory::buildUpdateChecker(
		'https://raw.githubusercontent.com/divea-server/lanci/master/release.json?flush_cache=true',
		__FILE__,
		"lanci"
	);


	if( ! function_exists("rrmdir")) {
		function rrmdir($src) {
		    $dir = opendir($src);
		    while(false !== ( $file = readdir($dir)) ) {
		        if (( $file != '.' ) && ( $file != '..' )) {
		            $full = $src . '/' . $file;
		            if ( is_dir($full) ) {
		                rrmdir($full);
		            }
		            else {
		                unlink($full);
		            }
		        }
		    }
		    closedir($dir);
		    rmdir($src);
		}
	}


	// removendo a opção de desativar alguns plugins
	// add_filter('plugin_action_links', 'disable_plugin_deactivation', 10, 4);
	// function disable_plugin_deactivation( $actions, $plugin_file, $plugin_data, $context ) {
	//  	if(array_key_exists("deactivate", $actions) && in_array($plugin_file, [
	//  		'lanci/lanci.php'
	//  	]))
	//  	unset($actions['deactivate']);
	// 	return $actions;
	// }


	// iniciando plugin
	add_action('init', '\Lanci\App::init', 0);
	

	// criando release
	// alterar versão na release, no doc e no Lanci\App::$version
	
	if( is_admin() && ! is_file(LANCI_PATH . "/release.json")) file_put_contents( LANCI_PATH . "/release.json", json_encode([
	 	"name" 			=> "Lanci",
	 	"version" 		=> "1.2.10",
	 	"download_url" 	=> "https://github.com/divea-server/lanci/archive/master.zip",
		"sections" 		=> [
			"description" => "
				O plugin Lancí é um apanhado de diversas funcionalidades para otimizar seu Wordpress nos servidores da Dívea.
				<h3>Gestão automática de Cache</h3>
				Ele faz a gestão dos caches Regis e do Proxy do Nginx de forma automática, limpando-os automaticamente ao alterar, criar ou deletar um post ou fazer qualquer outro tipo de alteração.
				<h3>Inserção de tags</h3>
				Um lugar só para administrar as principais tags de acompanhamento no dia a dia. Facebook Pixel, Google Analyitcs, Google Tag Manager e ainda um campo para colocar outras tags que precisar.
				<h3>Limpa nome de arquivos</h3>
				Caso você suba um arquivo com caracteres latinos no nome, eles são automaticamente removidos.
				<br><br>
				<h4>Dependências</h4>
				<ul>
					<li>Redis 2.0.15</li>
				  	<li>Nginx Cache 1.0.5</li>
				  	<li>Clean Image Filenames 1.3</li>
				</ul>"
			]
		]
	));
