<?php

namespace App\Providers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Writer;
use JavaScript;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Excel::extend(WithCustomProperties::class, function(WithCustomProperties $exportable, Writer $writer) {
            $writer->getDelegate()->getProperties()->setDescription($exportable->description());
        });
        Writer::macro('setCreator', function (Writer $writer, string $creator) {
            $writer->getDelegate()->getProperties()->setCreator($creator);
        });
        Sheet::macro('setOrientation', function (Sheet $sheet, $orientation) {
            $sheet->getDelegate()->getPageSetup()->setOrientation($orientation);
        });
        Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
            $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $is_production = config('app.env') === 'production' ? true : false;
        $is_development = config('app.env') === 'development' ? true : false;
        $is_test = config('app.env') === 'test' ? true : false;

        $https = $is_production || $is_development || $is_test;
        if ($https) {
//            URL::forceScheme('https');
        }

//        View::share('is_secure',$https);
        View::share('is_production',$is_production);
    }
}
