<?php

namespace Lanci\Tag;
use \Lanci\App;

class GoogleTagManager extends Tag
{
	var $template_path = "google_tag_manager";

	public function get_data()
	{
		$option = App::db()["google_tag_manager"];
		if(empty($option))
			throw new \Exception("sem dados");

		return [
			'{id}' => $option
		];
	}
}