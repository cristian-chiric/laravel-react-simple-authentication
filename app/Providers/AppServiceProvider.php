<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        /**
         *
         * Some Request macros to add extended functionality to base request
         *
         */

        if (!Request::hasMacro('processStoreFile')) {
            /**
             * Store the attach file if one is present.
             *
             * @param string $fileName The field name of the image
             * @param string $location The location to store the image
             * @return null|string
             */
            Request::macro('processStoreFile', function ($fileName, $location) {

                if (!$this->hasFile($fileName)) {
                    return null;
                }
                $file = $this->file($fileName);

                $hash = $file->hashName();
                $file->storeAs('public/' . $location, $hash);
                return $hash;
            });
        }


        if (!Request::hasMacro('storeFile')) {

            /**
             * Store the attach file if one is present.
             *
             * @param string $fileName The field name of the image
             * @param string $location The location to store the image
             * @return void
             */
            Request::macro('storeFile', function ($fileName, $location) {

                $hash = $this->processStoreFile($fileName, $location);

                if (!is_null($hash)) {
                    $this->merge([$fileName => $hash]);
                }

                return $hash;
            });
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
