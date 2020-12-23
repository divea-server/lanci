<?php

namespace Lanci\Tag;

class GoogleTagManager extends Tag
{
	var $template_path = "google_tag_manager";

	public function get_data()
	{
		$option = @get_option("lanci")["google_tag_manager"];
		if(empty($option))
			throw new \Exception("sem dados");

		return [
			'{id}' => $option
		];
	}
}