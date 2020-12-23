<?php

namespace Lanci\Tag;

class FacebookPixel extends Tag
{
	var $template_path = "facebook_pixel";

	public function get_data()
	{
		$option = @get_option("lanci")["facebook_pixel"];
		if(empty($option))
			throw new \Exception("sem dados");

		$pixels = explode(";", $option);
		return [
			'{init}' => $this->init($pixels),
			'{noscript}' => $this->noscript($pixels)
		];
	}

	public function init($pixels)
	{
		if(count($pixels) == 1)
			return sprintf("fbq('init', '%s' ); fbq('track', 'PageView');", $pixels[0]);

		$init = "";
		foreach($pixels as $p) 
			$init .= sprintf("fbq('trackSingle', '%s', 'PageView';\n)", $p);
		
		return $pixels;
	}

	public function noscript($pixels)
	{
		$noscript = "";
		foreach($pixels as $p)
			$noscript .= sprintf("<noscript><img height=\"1\" width=\"1\" style=\"display:none\" src=\"https://www.facebook.com/tr?id=%s&ev=PageView&noscript=1\"/></noscript>", $p);
		
		return $noscript;
	}
}