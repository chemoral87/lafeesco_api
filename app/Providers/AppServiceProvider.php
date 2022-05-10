<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register() {
    Schema::defaultStringLength(191);
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot() {
    // https://stackoverflow.com/questions/42196453/laravel-morphto-how-to-use-custom-columns/58119631
    // https: //stackoverflow.com/questions/44975227/laravel-morph-belongs-to
    Relation::morphMap([
      'investment' => 'App\Models\Investment',
    ]);
    // https://stackoverflow.com/questions/60830105/laravel-eloquent-api-resource-remove-data-key-no-collection
    // InvestorProfileResource::withoutWrapping();

    // https: //stackoverflow.com/questions/21641606/laravel-running-migrations-on-app-database-migrations-folder-recursively
    $mainPath = database_path('migrations');
    $directories =  glob($mainPath . '/*', GLOB_ONLYDIR);
    $paths = array_merge([$mainPath], $directories);
    // $paths = array_merge([$mainPath], ["C:\\Users\\chemo\\source\\laravel\\rc_desarrolladora_backend\\database\\migrations\\credits"]);

    $this->loadMigrationsFrom($paths);
  }
}
