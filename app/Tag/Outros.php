<?php

namespace Lanci\Tag;

class Outros extends Tag
{
	public function get_data()
	{
		return;
	}

	public function render_header($data)
	{
		return @get_option("lanci")["outros_header"];
	}

	public function render_body($data)
	{
		return @get_option("lanci")["outros_body"];
	}
}