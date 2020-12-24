<?php

namespace Lanci\Tag;
use \Lanci\App;

class Outros extends Tag
{
	public function get_data()
	{
		return;
	}

	public function render_header($data)
	{
		return App::db()["outros_header"];
	}

	public function render_body($data)
	{
		return App::db()["outros_body"];
	}
}