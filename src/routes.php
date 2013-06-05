<?php
Route::get('/login', 'Datatrain\User\AuthController@showLoginform');
Route::post('/login', 'Datatrain\User\AuthController@processLogin');
Route::get('/logout', 'Datatrain\User\AuthController@processLogout');

Route::get('/forgotpassword', 'Datatrain\User\AuthController@showForgotPasswordForm');
Route::post('/forgotpassword', 'Datatrain\User\AuthController@processForgotPasswordForm');
Route::get('/forgotconfirmation/{hash}', 'Datatrain\User\AuthController@showForgotPasswordConfirmationForm');
Route::post('/forgotconfirmation', 'Datatrain\User\AuthController@processForgotPasswordConfirmationForm');

Route::get('/register', 'Datatrain\User\RegistrationController@showRegistrationForm');
Route::post('/register', 'Datatrain\User\RegistrationController@processRegistration');
Route::get('/activate/{hash}', 'Datatrain\User\RegistrationController@processActivation');
?>
