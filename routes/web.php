<?php

use App\Http\Controllers\StudentAuthController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [StudentAuthController::class, 'index'])->name('login');

/* start av studentpanelen */

Route::get('login', [StudentAuthController::class, 'index'])->name('login');
Route::post('post-login', [StudentAuthController::class, 'postLogin'])->name('login.post');
Route::get('registration', [StudentAuthController::class, 'registration'])->name('register');
Route::post('post-registration', [StudentAuthController::class, 'postRegistration'])->name('register.post');
Route::get('dashboard', [StudentAuthController::class, 'dashboard'])->name('dashboard');
Route::get('logout', [StudentAuthController::class, 'logout'])->name('logout');
Route::get('show-courses/{id}', [StudentController::class, 'showCourses']);
Route::get('user-detail', [StudentController::class, 'showUserCourseStatus']);

/* end */


Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(function () {
        Route::prefix('admin-users')->name('admin-users/')->group(static function () {
            Route::get('/', 'AdminUsersController@index')->name('index');
            Route::get('/create', 'AdminUsersController@create')->name('create');
            Route::post('/', 'AdminUsersController@store')->name('store');
            Route::get('/{adminUser}/impersonal-login', 'AdminUsersController@impersonalLogin')->name('impersonal-login');
            Route::get('/{adminUser}/edit', 'AdminUsersController@edit')->name('edit');
            Route::post('/{adminUser}', 'AdminUsersController@update')->name('update');
            Route::delete('/{adminUser}', 'AdminUsersController@destroy')->name('destroy');
            Route::get('/{adminUser}/resend-activation', 'AdminUsersController@resendActivationEmail')->name('resendActivationEmail');
        });
    });
});


Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::get('/profile', 'ProfileController@editProfile')->name('edit-profile');
        Route::post('/profile', 'ProfileController@updateProfile')->name('update-profile');
        Route::get('/password', 'ProfileController@editPassword')->name('edit-password');
        Route::post('/password', 'ProfileController@updatePassword')->name('update-password');
    });
});


Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::prefix('classes')->name('classes/')->group(static function () {
            Route::get('/', 'ClassesController@index')->name('index');
            Route::get('/create', 'ClassesController@create')->name('create');
            Route::post('/', 'ClassesController@store')->name('store');
            Route::get('/{class}/edit', 'ClassesController@edit')->name('edit');
            Route::post('/bulk-destroy', 'ClassesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{class}', 'ClassesController@update')->name('update');
            Route::delete('/{class}', 'ClassesController@destroy')->name('destroy');
        });
    });
});


Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::prefix('courses')->name('courses/')->group(static function () {
            Route::get('/', 'CoursesController@index')->name('index');
            Route::get('/create', 'CoursesController@create')->name('create');
            Route::post('/', 'CoursesController@store')->name('store');
            Route::get('/{course}/edit', 'CoursesController@edit')->name('edit');
            Route::post('/bulk-destroy', 'CoursesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{course}', 'CoursesController@update')->name('update');
            Route::delete('/{course}', 'CoursesController@destroy')->name('destroy');
        });
    });
});


Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::prefix('grades')->name('grades/')->group(static function () {
            Route::get('/', 'GradesController@index')->name('index');
            Route::get('/create', 'GradesController@create')->name('create');
            Route::post('/', 'GradesController@store')->name('store');
            Route::get('/{grade}/edit', 'GradesController@edit')->name('edit');
            Route::post('/bulk-destroy', 'GradesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{grade}', 'GradesController@update')->name('update');
            Route::delete('/{grade}', 'GradesController@destroy')->name('destroy');
        });
    });
});


Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::prefix('users')->name('users/')->group(static function () {
            Route::get('/', 'UsersController@index')->name('index');
            Route::get('/create', 'UsersController@create')->name('create');
            Route::post('/', 'UsersController@store')->name('store');
            Route::get('/{user}/edit', 'UsersController@edit')->name('edit');
            Route::post('/bulk-destroy', 'UsersController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{user}', 'UsersController@update')->name('update');
            Route::delete('/{user}', 'UsersController@destroy')->name('destroy');
            Route::get('/{id}/user-detail', 'UsersController@returnUserDetail');
            Route::get('/status-change', 'UsersController@statusChange')->name('change.status');
            Route::get('/{id}/user-enroll', 'UsersController@returnUserEnroll');
            Route::get('/{id}/show-courses', 'UsersController@returnShowCourses');
            Route::get('/store-user-course', 'UsersController@storeUserCourse')->name('user.course');
            Route::get('/delete-user-course', 'UsersController@deleteUserCourse')->name('delete.course');
            Route::get('/{id}/delete-user', 'UsersController@deleteUser')->name('delete.user');

            // store-user-course
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('admin-users')->name('admin-users/')->group(static function() {
            Route::get('/',                                             'AdminUsersController@index')->name('index');
            Route::get('/create',                                       'AdminUsersController@create')->name('create');
            Route::post('/',                                            'AdminUsersController@store')->name('store');
            Route::get('/{adminUser}/impersonal-login',                 'AdminUsersController@impersonalLogin')->name('impersonal-login');
            Route::get('/{adminUser}/edit',                             'AdminUsersController@edit')->name('edit');
            Route::post('/{adminUser}',                                 'AdminUsersController@update')->name('update');
            Route::delete('/{adminUser}',                               'AdminUsersController@destroy')->name('destroy');
            Route::get('/{adminUser}/resend-activation',                'AdminUsersController@resendActivationEmail')->name('resendActivationEmail');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::get('/profile',                                      'ProfileController@editProfile')->name('edit-profile');
        Route::post('/profile',                                     'ProfileController@updateProfile')->name('update-profile');
        Route::get('/password',                                     'ProfileController@editPassword')->name('edit-password');
        Route::post('/password',                                    'ProfileController@updatePassword')->name('update-password');
    });
});