<?php

namespace Lanci;

class Dashboard
{
	static $admin_page = "options-general.php?page=lanci";

	static function init()
	{
		add_action( 'admin_menu', '\Lanci\Dashboard::admin_menu', 999);
		add_action( 'admin_bar_menu', '\Lanci\Dashboard::admin_bar_menu' , 999);
		add_action( 'admin_enqueue_scripts', '\Lanci\Dashboard::admin_styles' );
	}

	static function admin_menu()
	{
		global $submenu;
		foreach($submenu["tools.php"] as $key => $menu) {
			if($menu[2] == "nginx-cache") {
				unset($submenu["tools.php"][$key]);
			}
		}

		foreach($submenu["options-general.php"] as $key => $menu) {
			if($menu[2] == "redis-cache") {
				unset($submenu["options-general.php"][$key]);
			}
		}

		add_submenu_page(
            'options-general.php',
            "Meu Wordpress - Lanci",
            "Meu Wordpress",
            'manage_options',
            'lanci',
            "\Lanci\Dashboard::config_page"
        );
	}

	static function admin_bar_menu( $wp_admin_bar )
	{
		$wp_admin_bar->remove_node('nginx-cache');

		$wp_admin_bar->add_node( array(
			'id' 	=> 'lanci',
			'title' => "Meu WP",
			'href' 	=> admin_url( self::$admin_page )
		));

		$wp_admin_bar->add_node( array(
			'parent'=> 'lanci',
			'id' 	=> 'flush',
			'title' => "Limpar cache",
			'href' 	=> admin_url( add_query_arg( 'action', 'flush-cache', "options-general.php?page=lanci" ))
		));

		$wp_admin_bar->add_node( array(
			'parent'=> 'lanci',
			'id' 	=> 'configuracoes',
			'title' => "Configurações",
			'href' 	=> admin_url( self::$admin_page )
		));

	}

	static function admin_styles()
	{
		global $pagenow;
		if( ! ($pagenow == "options-general.php" && isset($_GET['page']) && $_GET['page'] == "lanci"))
			return;

		wp_enqueue_style('lanci_admin_css', LANCI_PUBLIC_PATH . 'pages/assets/style.css', false, filemtime(LANCI_PATH."/pages/assets/style.css"));
		wp_enqueue_script('lanci_admin_js', LANCI_PUBLIC_PATH . 'pages/assets/script.js', ['jquery'], filemtime(LANCI_PATH."/pages/assets/script.js"), true );
	}

	static function config_page()
	{
		if( isset($_GET['action']) && $_GET['action'] == "purge-cache" && wp_verify_nonce( @$_GET[ '_wpnonce' ], 'purge-cache' )) {
			Cache::flush();
			set_transient('temporary_message', "Cache apagado");
		}

		if( ! empty($_POST)) {
			update_option("lanci", json_encode($_POST), "true");
			Cache::flush();
			set_transient('temporary_message', "Informações salvas");
		}

		$lanci = json_decode(get_option("lanci"),1);
		require_once LANCI_PATH . "/pages/config.php";
	}
}