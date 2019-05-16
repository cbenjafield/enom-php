<?php

namespace Benjafield\Enom\Providers;

use Benjafield\Enom\Enom;
use Benjafield\Enom\Domain;

class EnomServiceProvider extends \Illuminate\Support\ServiceProvider {

	public function boot()
	{
		$path = realpath(__DIR__.'/../../config/enom.php');

		$this->publishes([
			$path => config_path('enom.php')
		], 'config');

		$this->mergeConfigFrom($path, 'enom');
	}

	public function register()
	{
		$enom = new Enom(config('enom.username'), config('enom.password'));

		$this->app->bind('domain', function() use($enom) {
			return new Domain($enom);
		});
	}

}