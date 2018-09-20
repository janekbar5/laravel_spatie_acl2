<?php
Route::get('/', function () { return redirect('/admin/home'); });


// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('auth.login');
$this->post('login', 'Auth\LoginController@login')->name('auth.login');
$this->post('logout', 'Auth\LoginController@logout')->name('auth.logout');

// Change Password Routes...
$this->get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
/////////////////////////////////
$this->get('books', 'Auth\ChangePasswordController@showChangePasswordForm2')->name('auth.books');
$this->get('books/index', 'BooksController@index')->name('books.index');
$this->get('books/create', 'BooksController@create')->name('books.create');
$this->post('books/store', 'BooksController@store')->name('books.store');
$this->get('books/index', 'BooksController@index')->name('books.index');
$this->get('books/show/{id}', 'BooksController@show')->name('books.show');
$this->get('books/edit/{id}', 'BooksController@edit')->name('books.edit');
$this->post('books/edit/{id}', 'BooksController@update')->name('books.update');
$this->delete('books/delete/{id}', 'BooksController@destroy')->name('books.destroy');
$this->post('/books/do-upload', 'ImagesController@postImageUpload')->name('images.upload');
/////////////////////////////////
$this->get('categories/index', 'CategoriesController@index')->name('categories.index');
$this->get('categories/create', 'CategoriesController@create')->name('categories.create');
$this->post('categories/store', 'CategoriesController@store')->name('categories.store');
$this->get('categories/index', 'CategoriesController@index')->name('categories.index');
$this->get('categories/edit/{id}', 'CategoriesController@edit')->name('categories.edit');
$this->post('categories/edit/{id}', 'CategoriesController@update')->name('categories.update');
$this->get('categories/show/{id}', 'CategoriesController@show')->name('categories.show');
$this->delete('categories/delete/{id}', 'CategoriesController@destroy')->name('categories.destroy');
//////////////////////////////////	
$this->post('images/changeImageOrder', 'ImagesController@changeImageOrder')->name('images.store');	
$this->get('images/deleteimgwithvehicle/{id}', 'ImagesController@deleteImageswithVehicle')->name('images.store');
$this->get('images/deleteimg/{id}', 'ImagesController@getImageDelete')->name('images.delete');
//////////////////////////////////	
$this->get('vehicles/index', 'VehiclesController@index')->name('vehicles.index');
$this->get('vehicles/index', 'VehiclesController@index')->name('vehicles.index');
$this->get('vehicles/create', 'VehiclesController@create')->name('vehicles.create');
$this->post('vehicles/store', 'VehiclesController@store')->name('vehicles.store');
$this->get('vehicles/index', 'VehiclesController@index')->name('vehicles.index');
$this->get('vehicles/show/{id}', 'VehiclesController@show')->name('vehicles.show');
$this->get('vehicles/edit/{id}', 'VehiclesController@edit')->name('vehicles.edit');
$this->post('vehicles/edit/{id}', 'VehiclesController@update')->name('vehicles.update');
$this->delete('vehicles/delete/{id}', 'VehiclesController@destroy')->name('vehicles.destroy');
$this->post('vehicles/do-upload', 'ImagesController@postImageUpload')->name('images.upload');
////////////////////////////////////////
$this->post('model/getmodel/{id}', 'ModelsController@getModels')->name('models.index');





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
