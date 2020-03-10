<?php

namespace Thebikramlama\Hbl;

use Illuminate\Support\ServiceProvider;

class HblServiceProvider extends ServiceProvider
{
	public function boot()
	{
		// Merge Config File
		$this->mergeConfigFrom( __DIR__.'/config/hbl.php', 'hbl' );

		// Load Views
		$this->loadViewsFrom( __DIR__.'/views', 'hbl' );

		// Load Routes
		$this->loadRoutesFrom( __DIR__.'/routes/web.php' );
	}

	public function register()
	{
		$this->publishes([ __DIR__.'/config/hbl.php' => config_path('hbl.php') ]);
	}
}
