<?php
Route::get('/', function () { return redirect('/admin/home'); });


// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('auth.login');
$this->post('login', 'Auth\LoginController@login')->name('auth.login');
$this->post('logout', 'Auth\LoginController@logout')->name('auth.logout');

// Change Password Routes...
$this->get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');

$this->get('books', 'Auth\ChangePasswordController@showChangePasswordForm2')->name('auth.books');

$this->get('books/index', 'BookController@index')->name('books.index');

$this->get('books/create', 'BookController@create')->name('books.create');
$this->post('books/store', 'BookController@store')->name('books.store');


$this->get('books/index', 'BookController@index')->name('books.index');
$this->get('books/show/{id}', 'BookController@show')->name('books.show');

$this->get('books/edit/{id}', 'BookController@edit')->name('books.edit');
$this->post('books/edit/{id}', 'BookController@update')->name('books.update');
$this->delete('books/delete/{id}', 'BookController@destroy')->name('books.destroy');
/////////////////////////////////

$this->get('categories/index', 'CategoryController@index')->name('categories.index');
$this->get('categories/create', 'CategoryController@create')->name('categories.create');




$this->post('categories/store', 'CategoryController@store')->name('categories.store');
$this->get('categories/index', 'CategoryController@index')->name('categories.index');
$this->get('categories/edit/{id}', 'CategoryController@edit')->name('categories.edit');
$this->post('categories/edit/{id}', 'CategoryController@update')->name('categories.update');
$this->get('categories/show/{id}', 'CategoryController@show')->name('categories.show');
$this->delete('categories/delete/{id}', 'CategoryController@destroy')->name('categories.destroy');





$this->patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('auth.change_password');


// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.password.reset');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('auth.password.reset');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset')->name('auth.password.reset');

Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
	
    Route::get('/home', 'HomeController@index');
    Route::resource('permissions', 'Admin\PermissionsController');
	
	
	//Route::resource('books','BookController');
	//Route::resource('books','BookController');
	
	
	
    Route::post('permissions_mass_destroy', ['uses' => 'Admin\PermissionsController@massDestroy', 'as' => 'permissions.mass_destroy']);
    Route::resource('roles', 'Admin\RolesController');
	
    Route::post('roles_mass_destroy', ['uses' => 'Admin\RolesController@massDestroy', 'as' => 'roles.mass_destroy']);
    Route::resource('users', 'Admin\UsersController');
	
    Route::post('users_mass_destroy', ['uses' => 'Admin\UsersController@massDestroy', 'as' => 'users.mass_destroy']);

});
