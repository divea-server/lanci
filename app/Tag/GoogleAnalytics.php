<?php

namespace Lanci\Tag;
use \Lanci\App;

class GoogleAnalytics extends Tag
{
	var $template_path = "google_analytics";

	public function get_data()
	{
		$option = App::db()["google_analytics"];
		if(empty($option))
			throw new \Exception("sem dados");
			
		$ids = explode(";", $option);
		return [
			'{id}' => $ids[0],
			'{multiple}' => strpos($ids[0], "UA-") !== false ? $this->multiple_v3($ids) : $this->multiple_v4($ids)
		];
	}	

	private function multiple_v3($ids)
	{
		$this->header_html = "header_v3.html";
		
		$multiple = "";
		foreach($ids as $i) 
			$multiple.="ga('create', '$i', 'auto');";
		
		return $multiple;
	}

	private function multiple_v4($ids)
	{
		$this->header_html = "header_v4.html";
		
		$multiple = "";
		foreach($ids as $i) 
			$multiple.="gtag('config', '$i');";
		
		return $multiple;
	}
}
