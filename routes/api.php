<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Api::version('v1', ['namespace' => 'BikeShare\Http\Controllers\Api\v1'], function () {

    Api::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
        Api::post('verify-phone-number', [
            'as' => 'api.auth.verify-phone-number',
            'uses' => 'RegisterController@verifyPhoneNumber',
        ]);

        Api::post('register', [
            'as' => 'api.auth.register',
            'uses' => 'RegisterController@register',
        ]);

        Api::get('agree/{token}', [
            'as' => 'api.auth.agree',
            'uses' => 'RegisterController@agree',
        ]);

        Api::post('authenticate', [
            'as' => 'api.auth.login',
            'uses' => 'LoginController@authenticate',
        ]);

        // Password Reset Routes...
        Api::post('password/email', [
            'as' => 'api.auth.password.email',
            'uses' => 'ForgotPasswordController@sendResetLinkEmail',
        ]);

        Api::post('password/reset', [
            'as' => 'api.auth.password.post.reset',
            'uses' => 'ResetPasswordController@reset',
        ]);


    });

    Api::group(['middleware' => 'jwt.auth'], function () {

        Api::group(['prefix' => 'me', 'namespace' => 'Me'], function () {
            Api::get('', [
                'as' => 'api.me',
                'uses' => 'MeController@getInfo',
            ]);

            Api::get('rents', [
                'as' => 'api.me.rents',
                'uses' => 'MeController@getAllRents',
            ]);

            Api::get('rents/active', [
                'as' => 'api.me.rents.active',
                'uses' => 'MeController@getActiveRents',
            ]);

        });

        Api::group(['prefix' => 'stands', 'namespace' => 'Stands'], function () {
            Api::get('', [
                'as' => 'api.stands',
                'uses' => 'StandsController@index',
            ]);
        });

        Api::group(['prefix' => 'rents', 'namespace' => 'Rents'], function () {
            Api::post('{uuid}/close', [
                'as' => 'api.rents.close',
                'uses' => 'RentsController@close',
            ]);

            Api::post('', [
                'as' => 'api.rents.store',
                'uses' => 'RentsController@store',
            ]);
        });

        Api::group(['middleware' => 'role:admin'], function () {
            Api::group(['prefix' => 'rents', 'namespace' => 'Rents'], function () {
                Api::get('', [
                    'as' => 'api.rents.index',
                    'uses' => 'RentsController@index',
                ]);

                Api::get('/active', [
                    'as' => 'api.rents.active',
                    'uses' => 'RentsController@active',
                ]);

                Api::get('/history', [
                    'as' => 'api.rents.history',
                    'uses' => 'RentsController@history',
                ]);
            });

            Api::group(['prefix' => 'users', 'namespace' => 'Users'], function () {

                Api::group(['prefix' => '{uuid}'], function () {
                    Api::get('/restore', [
                        'as' => 'api.users.restore',
                        'uses' => 'UsersController@restore',
                    ]);
                });

                Api::get('', [
                    'as' => 'api.users.index',
                    'uses' => 'UsersController@index',
                ]);

                Api::post('', [
                    'as' => 'api.users.store',
                    'uses' => 'UsersController@store',
                ]);

                Api::get('{uuid}', [
                    'as' => 'api.users.show',
                    'uses' => 'UsersController@show',
                ]);

                Api::put('{uuid}', [
                    'as' => 'api.users.update',
                    'uses' => 'UsersController@update',
                ]);

                Api::delete('{uuid}', [
                    'as' => 'api.users.destroy',
                    'uses' => 'UsersController@destroy',
                ]);
            });

            Api::group(['prefix' => 'bikes', 'namespace' => 'Bikes'], function () {

                Api::group(['prefix' => '{uuid}'], function () {
                    Api::post('/rent', [
                        'as' => 'api.bikes.rent',
                        'uses' => 'BikesController@rentBike',
                    ]);
                });

                Api::get('', [
                    'as' => 'api.bikes.index',
                    'uses' => 'BikesController@index',
                ]);

                Api::post('', [
                    'as' => 'api.bikes.store',
                    'uses' => 'BikesController@store',
                ]);

                Api::get('{uuid}', [
                    'as' => 'api.bikes.show',
                    'uses' => 'BikesController@show',
                ]);

                Api::delete('{uuid}', [
                    'as' => 'api.bikes.destroy',
                    'uses' => 'BikesController@destroy',
                ]);
            });

            Api::group(['prefix' => 'notes', 'namespace' => 'Notes'], function () {
                Api::delete('{uuid}', [
                    'as' => 'api.notes.destroy',
                    'uses' => 'NotesController@destroy',
                ]);
            });

            Api::group(['prefix' => 'coupons', 'namespace' => 'Coupons'], function () {
                Api::get('', [
                    'as' => 'api.coupons.index',
                    'uses' => 'CouponsController@index',
                ]);

                Api::post('', [
                    'as' => 'api.coupons.store',
                    'uses' => 'CouponsController@store',
                ]);

                Api::get('{uuid}/sell', [
                    'as' => 'api.coupons.sell',
                    'uses' => 'CouponsController@sell',
                ]);

                Api::get('{uuid}/validate', [
                    'as' => 'api.coupons.validate',
                    'uses' => 'CouponsController@validateCoupon',
                ]);

                Api::get('{uuid}', [
                    'as' => 'api.coupons.show',
                    'uses' => 'CouponsController@show',
                ]);
            });

        });
    });
});

Route::group(['middleware' => 'auth:api'], function () {

});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');
