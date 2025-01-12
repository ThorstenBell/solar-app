<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {
    Route::get('installation', 'App\Http\Controllers\Api\V1\InstallationController@index');
    Route::post('installation', 'App\Http\Controllers\Api\V1\InstallationController@store');
    Route::get('installation/{installation}', 'App\Http\Controllers\Api\V1\InstallationController@show');
    Route::put('installation/{installation}', 'App\Http\Controllers\Api\V1\InstallationController@update');
    Route::delete('installation/{installation}', 'App\Http\Controllers\Api\V1\InstallationController@destroy');

    Route::get('energy-usage', 'App\Http\Controllers\Api\V1\EnergyUsageController@index');
    Route::post('energy-usage', 'App\Http\Controllers\Api\V1\EnergyUsageController@store');
    Route::get('energy-usage/{energyUsage}', 'App\Http\Controllers\Api\V1\EnergyUsageController@show');
    Route::put('energy-usage/{energyUsage}', 'App\Http\Controllers\Api\V1\EnergyUsageController@update');
    Route::delete('energy-usage/{energyUsage}', 'App\Http\Controllers\Api\V1\EnergyUsageController@destroy');
});
