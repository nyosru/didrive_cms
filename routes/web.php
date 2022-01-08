<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UloginController;

use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();










Route::post('ckeditor-upload', function(
    \Illuminate\Http\Request $request,
    Illuminate\Contracts\Validation\Factory $validator
) {
    $v = $validator->make($request->all(), [
        'upload' => 'required|image',
    ]);

    $funcNum = $request->input('CKEditorFuncNum');

    if ($v->fails()) {
        return response(
            "<script>
                window.parent.CKEDITOR.tools.callFunction({$funcNum}, '', '{$v->errors()->first()}');
            </script>"
        );
    }

    $image = $request->file('upload');
    $image->store('public/uploads');
    $url = asset('storage/uploads/'.$image->hashName());

    return response(
        "<script>
            window.parent.CKEDITOR.tools.callFunction({$funcNum}, '{$url}', 'Изображение успешно загружено');
        </script>"
    );
});





















// авторизован
Route::group(['middleware' => 'auth'], function () {

    // Route::name('didrive')->group(function () {

    // Route::get('/', [App\Http\Controllers\DidriveController::class, 'showSites'])
    //     ->name('pageIndex')
    //     // ->where('site', '.*')
    //     ;

    Route::get('/sites/{site?}/', [App\Http\Controllers\DidriveController::class, 'showSites'])
        ->name('sites')
        ->where('site', '.*');

    Route::get('/get-api/{action}/{dop}', [App\Http\Controllers\DidriveController::class, 'getApi'])
        // ->name('get_api')
        ->where('action', '.*')
        ->where('dop', '.*');

    Route::get('/get-api/{action?}/{dop?}', [App\Http\Controllers\DidriveController::class, 'getApi'])
        ->name('get_api')
        ->where('action', '.*')
        ->where('dop', '.*');

    Route::post('/set-api/{action?}', [App\Http\Controllers\DidriveController::class, 'setApi'])
        ->name('set_api')
        ->where('action', '.*')
        ->where('dop', '.*');

    Route::prefix('api')->group(function () {
        Route::prefix('page')->group(function () {
            Route::post('save/{module}', [App\Http\Controllers\DidrivePageController::class, 'savePage'])
                // ->name('set_api')
                ->where('module', '.*')
                // ->where('dop', '.*')
            ;
        });
    });








    Route::prefix('modules')->group(function () {
        Route::name('modules.')->group(function () {

            Route::post('/{module_name}/{item_id}/{mod_action}', [App\Http\Controllers\DidriveController::class, 'showModulesSaves'])
                ->where('module_name', '.*')
                ->where('item_id', '.*')
                ->where('mod_action', '.*')
                // ->where('action', '(\'\',edit)')
                ->name('item_action');

            Route::get('/{module_name}/{item_id}/{mod_action}', [App\Http\Controllers\DidriveController::class, 'showModules'])
                ->where('module_name', '.*')
                ->where('item_id', '.*')
                ->where('mod_action', '.*')
                // ->where('action', '(\'\',edit)')
                ->name('item_show_form');

            Route::get('/{module_name}/{item_id}', [App\Http\Controllers\DidriveController::class, 'showModules'])
                ->where('module_name', '.*')
                ->where('item_id', '.*')
                ->name('item_show_form');

            Route::get('{module_name?}/{item_id?}/{mod_action?}/', [App\Http\Controllers\DidriveController::class, 'showModules'])
                ->where('module_name', '.*')
                ->where('item_id', '.*')
                ->where('mod_action', '.*')
                // ->where('action', '(\'\',edit)')
                ->name('index');

            // // Route::get('{module_name?}/a/{item_id?}/{action?}/', [App\Http\Controllers\DidriveController::class, 'action'])
            // Route::get('{module_name?}/a/{item_id?}/{action?}/', [App\Http\Controllers\DidriveController::class, 'action'])

            //     ->where('module_name', '.*')
            //     ->where('item_id', '[1-9]')
            //     ->where('action', '.*')

            //     ->name('action');

            // Route::get('{module_name?}/{item_id?}/{action?}/', [App\Http\Controllers\DidriveController::class, 'showModules'])
            //     ->name('modules')
            //     ->where('module_name', '.*')
            //     ->where('item_id', '[1-9]')
            //     ->where('action', '.*');

        });
    });


    // Route::get('/', function () {
    //     return view('welcome');
    // });
    // });

    Route::get('{any?}', [App\Http\Controllers\DidriveController::class, 'index']);
});


Route::get('/', function () {
    // dd( Auth::user() );
    return view('start');
    // return view('welcome');
});

//Route::get('ulogin', [UloginController::class,'login'] );
Route::post('ulogin', [UloginController::class, 'login']);
// Route::post('ulogin', 'UloginController@login');

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
