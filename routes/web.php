<?php

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Crm Status
    Route::delete('crm-statuses/destroy', 'CrmStatusController@massDestroy')->name('crm-statuses.massDestroy');
    Route::resource('crm-statuses', 'CrmStatusController');

    // Crm Customer
    Route::delete('crm-customers/destroy', 'CrmCustomerController@massDestroy')->name('crm-customers.massDestroy');
    Route::post('crm-customers/parse-csv-import', 'CrmCustomerController@parseCsvImport')->name('crm-customers.parseCsvImport');
    Route::post('crm-customers/process-csv-import', 'CrmCustomerController@processCsvImport')->name('crm-customers.processCsvImport');
    Route::resource('crm-customers', 'CrmCustomerController');

    // Crm Note
    Route::delete('crm-notes/destroy', 'CrmNoteController@massDestroy')->name('crm-notes.massDestroy');
    Route::resource('crm-notes', 'CrmNoteController');

    // Crm Document
    Route::delete('crm-documents/destroy', 'CrmDocumentController@massDestroy')->name('crm-documents.massDestroy');
    Route::post('crm-documents/media', 'CrmDocumentController@storeMedia')->name('crm-documents.storeMedia');
    Route::post('crm-documents/ckmedia', 'CrmDocumentController@storeCKEditorImages')->name('crm-documents.storeCKEditorImages');
    Route::resource('crm-documents', 'CrmDocumentController');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // City
    Route::delete('cities/destroy', 'CityController@massDestroy')->name('cities.massDestroy');
    Route::post('cities/parse-csv-import', 'CityController@parseCsvImport')->name('cities.parseCsvImport');
    Route::post('cities/process-csv-import', 'CityController@processCsvImport')->name('cities.processCsvImport');
    Route::resource('cities', 'CityController');

    // Governorate
    Route::delete('governorates/destroy', 'GovernorateController@massDestroy')->name('governorates.massDestroy');
    Route::post('governorates/parse-csv-import', 'GovernorateController@parseCsvImport')->name('governorates.parseCsvImport');
    Route::post('governorates/process-csv-import', 'GovernorateController@processCsvImport')->name('governorates.processCsvImport');
    Route::resource('governorates', 'GovernorateController');

    // Post
    
    Route::get('post/changeCity/{id?}', 'PostController@changeCity')->name('post.changeCity');
    Route::get('post/deliveryPrice/{id?}', 'PostController@deliveryPrice')->name('post.deliveryPrice');
    Route::get('post/editStatus/{id?}/{status?}', 'PostController@editStatus')->name('post.editStatus');
    Route::delete('posts/destroy', 'PostController@massDestroy')->name('posts.massDestroy');
    Route::resource('posts', 'PostController');

    // Invoice
    Route::get('invoices/newCreate/{invoice}', 'InvoiceController@newCreate')->name('invoices.newCreate');
    Route::post('invoices/getBalance', 'InvoiceController@getBalance')->name('invoices.getBalance');
    Route::delete('invoices/destroy', 'InvoiceController@massDestroy')->name('invoices.massDestroy');
    Route::resource('invoices', 'InvoiceController');

    // Representative
    Route::delete('representatives/destroy', 'RepresentativeController@massDestroy')->name('representatives.massDestroy');
    Route::post('representatives/parse-csv-import', 'RepresentativeController@parseCsvImport')->name('representatives.parseCsvImport');
    Route::post('representatives/process-csv-import', 'RepresentativeController@processCsvImport')->name('representatives.processCsvImport');
    Route::resource('representatives', 'RepresentativeController');

    // Post Status
    Route::delete('post-statuses/destroy', 'PostStatusController@massDestroy')->name('post-statuses.massDestroy');
    Route::resource('post-statuses', 'PostStatusController');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
