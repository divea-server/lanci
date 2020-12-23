<?php

namespace Lanci;

class App
{
	static $version = "1.0";

	static function init()
	{
		// iniciando atualizações
		self::update();

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
			die("Esse plugin é feito apenas para servidores Lancí");
		}

		// habilitando cache
		Cache::enable();
	}

	static function deactivate($plugin)
	{
		Cache::deactivate($plugin);
	}

	static function update()
	{
		
	}
}