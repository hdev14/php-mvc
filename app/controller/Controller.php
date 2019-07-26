<?php

namespace App\Controller;

use function Helpers\Response\render;

class Controller
{
	public function home() {
		// $home = "home";
		return render('home', [
			'home' => 'Home Controller',
		]);
	}
}