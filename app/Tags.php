<?php

namespace Lanci;

class Tags
{
	static $tags = ["FacebookPixel", "GoogleAnalytics", "GoogleTagManager", "Outros"];

	static function init()
	{
		if(is_admin())
			return;

		global $tags;
		$tags = [
			"header" => [],
			"body"	 => []
		];

		foreach(self::$tags as $t) {
			try{

				$class = "\Lanci\Tag\\".$t;

				$tag = new $class;
				$render = $tag->render();

				if( ! empty($render['header']))
					$tags["header"][] = $render["header"];

				if( ! empty($render['body']))
					$tags["body"][] = $render["body"];

			} catch(\Exception $e) {
				continue;
			}
		} 

		add_action( 'wp_head', '\Lanci\Tags::header' );
		add_action( 'wp_footer', '\Lanci\Tags::footer' );
	}

	static function header()
	{
		global $tags;
		echo "\n\n<!-- TAGS -->\n\n";
		foreach($tags['header'] as $html) echo $html."\n";
		echo "\n<!-- END TAGS -->\n\n";
	}

	static function footer()
	{
		global $tags;
		echo "\n\n<!-- TAGS -->\n\n";
		foreach($tags['body'] as $html) echo $html."\n";
		echo "\n<!-- END TAGS -->\n\n";
	}
}