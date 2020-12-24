<?php

namespace Lanci;

class App
{
	static $version = "1.2.6";

	static function init()
	{
		// iniciando cache
		Cache::init();

		// iniciando interface
		Dashboard::init();

		// iniciando tags
		Tags::init();
	}

	static function activate()
	{
		if( ! defined("LANCI_SERVER_ALIAS")) {
			wp_die("Esse plugin é feito apenas para servidores Lancí");
		}

		// habilitando cache
		Cache::enable();

		// adicionando opções do plugin clean_image_filenames
		if ( false === get_option( 'clean_image_filenames_mime_types' ) ) {
			add_option( 'clean_image_filenames_mime_types', 'images' );
		}
	}

	static function deactivate($plugin)
	{
		Cache::deactivate($plugin);
	}

	static function db()
	{
		return json_decode(@get_option("lanci"),1);
	}
}