<?php

namespace Lanci\Tag;

abstract class Tag
{
	var $header_html = "header.html";
	var $body_html = "body.html";

	abstract public function get_data();

	public function render()
	{
		$data = $this->get_data();
		return [
			'header' => $this->render_header($data),
			'body' => $this->render_body($data)
		];
	}

	public function render_header($data)
	{
		return $this->get_template($data, $this->header_html);
	}

	public function render_body($data)
	{
		return $this->get_template($data, $this->body_html);
	}

	private function get_template($data, $part)
	{
		$file = LANCI_PATH."/templates/".$this->template_path."/".$part;	
		if( ! file_exists($file))
			return "";

		return str_replace(array_keys($data), array_values($data), file_get_contents($file));
	}
}