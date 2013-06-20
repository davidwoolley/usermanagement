<?php

namespace Datatrain\User;

use Illuminate\Support\Facades\View;
use Sentry;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use Config;
use Cartalyst\Sentry\Users\UserNotFoundException;
use URL;
use Mail;

class AuthController extends \BaseController {

    public function showLoginform() {
        return View::make(Config::get('user::loginView'));
    }

    public function processLogin() {
        // Log the user out
        Sentry::logout();

        $email = Input::get('email');
        $password = Input::get('password');
        try {
            // Log the user in
            $credentials = array('email' => $email, 'password' => $password);

            if (Sentry::authenticate($credentials, Input::get('remember'))) {
                Log::info(sprintf("User %s sucessfully authenticated", $email));
                return Redirect::to('/');
            }
            Log::info(sprintf("User %s failed to authenticate", $email));

            return Redirect::to('/login')->with('message', 'Incorrect username or password');
        } catch (\Cartalyst\Sentry\Users\LoginRequiredException $e) {
            $error = 'Login field is required.';
        } catch (\Cartalyst\Sentry\Users\PasswordRequiredException $e) {
            $error = 'Password field is required.';
        } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
            $error = 'User was not found.';
        } catch (\Cartalyst\Sentry\Users\WrongPasswordException $e) {
            $error = 'Wrong password, try again.';
        } catch (\Cartalyst\Sentry\Users\UserNotActivatedException $e) {
            $error = 'User is not activated.';
        }
        // The following is only required if throttle is enabled
        catch (\Cartalyst\Sentry\Throttling\UserSuspendedException $e) {
            $error = 'User is suspended.';
        } catch (\Cartalyst\Sentry\Throttling\UserBannedException $e) {
            $error = 'User is banned.';
        }
        Log::error($error);
        return Redirect::to('/login')->with('message', $error);
    }

    public function processLogout() {
        Sentry::logout();
        Session::flush();
        return Redirect::to('/');
    }

    public function showForgotPasswordForm() {
        return View::make(Config::get('user::forgotView'));
    }

    public function processForgotPasswordForm() {
        $email = Input::get("email");
        
        try {
            $user = Sentry::getUserProvider()->findByLogin($email);
            
            if ($user) {
                $user_data = array();
                $user_data['email'] = $email;
                $user_data['link_url'] = URL::to('/forgotconfirmation/' . urlencode($user->getResetPasswordCode()));
                
                Mail::send(Config::get('user::forgotEmail'), $user_data, function($message) use ($user_data)
                {
                    $message->from(Config::get('user::emailSenderAddress'), Config::get('user::emailSenderName'));
//                    $message->from('fred@example.com', Config::get('user::emailSenderName'));
                    $message->to($user_data['email']);
                    $message->subject(Config::get('user::emailPasswordSubject'));
});
            }      
            $message = "Please check your email and confirm your password reset request";
        } catch (UserNotFoundException $e) {
            $message = 'User was not found.';
            Log::error(sprintf("processForgotPasswordForm() - Exception: %s", $e->getMessage()));            
        }
        return Redirect::to('/forgotpassword')->with('message', $message);
    }
    
    public function showForgotPasswordConfirmationForm($hash) {
        try {
            $user = Sentry::getUserProvider()->findByResetPasswordCode($hash);
            return View::make(Config::get('user::forgotConfirmationView'))->with('hash', $hash);
        } catch (UserNotFoundException $e) {
            $message = 'User was not found.';
            Log::error(sprintf("processForgotPasswordConfirmationForm() - Exception: %s", $e->getMessage()));
            return Redirect::to('/forgotpassword')->with('message', $message);
        }        
    }

    public function processForgotPasswordConfirmationForm() {
        $hash     = Input::get('hash');
        $password = Input::get('password');
        
        try {
            $user = Sentry::getUserProvider()->findByResetPasswordCode($hash);
            
        if ($user->attemptResetPassword($hash, $password))
        {
            // Password reset passed
            $message = "Password sucessfully reset";
        }
        else
        {
            $message = "Password filed to be reset";
            // Password reset failed
        }
        } catch (UserNotFoundException $e) {
            $message = 'User was not found.';
            Log::error(sprintf("processForgotPasswordConfirmation() - Exception: %s", $e->getMessage));
        }
        return Redirect::to('/login')->with('message', $message);
    }

    public function get_reset_password_confirm($email = '', $hash = '') {
        try {
            $reset_user = Sentry::reset_password_confirm($email, $hash, true);
            if ($reset_user) {
                Log::write('info', sprintf("User %s activated", $reset_user['email']));
                return Redirect::to('/auth/login')->with('message', sprintf("Password reset conformation complete for %s", $reset_user['email']));
            } else {
                Log::write('info', sprintf("User %s failed to conform password reset", $email));
                return Redirect::to('/auth/login')->with('message', sprintf("Password reset conformation failed"));
            }
        } catch (Exception $e) {
            Log::write('error', $e->GetMessage());
            return Redirect::to('/auth/login')->with('message', $e->GetMessage());
        }
    }

}

?>
