<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Components\FlashMessages;

class AppServiceProvider extends ServiceProvider
{
    use FlashMessages;
    
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local', 'testing')) {
            $this->app->register('App\Providers\DuskServiceProvider');
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('markdown', function ($expression) {
            return "<?php echo \Illuminate\Mail\Markdown::parse($expression); ?>";
        });

        view()->composer('includes.messages', function ($view) {
            $messages = self::messages();
            return $view->with('messages', $messages);
        });

        Validator::extend('iunique', function ($attribute, $value, $parameters, $validator) {
            $query = DB::table($parameters[0]);
            $column = $query->getGrammar()->wrap($parameters[1]);
            return ! $query->whereRaw("lower({$column}) = lower(?)", [$value])->count();
        });
    }
}
