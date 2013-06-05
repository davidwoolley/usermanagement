<?php
/**
 * Description of RegistrationController
 *
 * @author dwoolley
 */
namespace Datatrain\User;

use View;
use Config;
use Log;
use Input;
use Validator;
use Sentry;
use Redirect;
use URL;
use Mail;
use Cartalyst\Sentry\Users\UserNotFoundException;

class RegistrationController extends \BaseController {
    protected $layout = 'user::layout.default';

    protected static $_rules = array(
        'first_name' => 'required',
        'last_name' => 'required',
        'email' => 'required|unique:users',
        'email_confirmation' => 'required|same:email',
        'password' => 'required',
        'password_confirmation' => 'required|same:password',
    );
    
    public function showRegistrationForm() {
        $this->layout->content = View::make(Config::get('user::registrationView'));
    }

    public function processRegistration() {
        $user_data = Input::get();

        $validation = Validator::make($user_data, self::$_rules);
        if ($validation->fails()) {
            return Redirect::to('/register')->withInput()->withErrors($validation);
        }
        try {
            $user = Sentry::register(array(
                'email' => $user_data['email'],
                'password' => $user_data['password']
                )
            );

            if ($user) {
                $user_data['activation_link'] = URL::to('/activate/' . urlencode($user->getActivationCode()));
                
                Mail::send(Config::get('user::activationEmail'), $user_data, function($message) use ($user_data)
                {
                    $message->from('webmaster@example.com', 'Webmaster');
                    $message->to($user_data['email']);
                });
//                $email_content = View::make('email/activation')->with($user)->render();

//                $mailer = IoC::resolve('mailer');

//                $message = Swift_Message::newInstance('Registation')
//                        ->setFrom(array('webmaster@bouncybeds.com' => ''))
//                        ->setTo($user_data['email'])
//                        ->setBody($email_content, 'text/html');

//                $mailer->send($message);

                Log::info(sprintf("processRegistration() - User %s sucessfully registered", $user_data['email']));
                return Redirect::to('/login')->with('message', 'Please check your email and activate your login');
            }
        }
        catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
        {
            $error = 'Login field is required.';
        }
        catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
        {
            $error = 'Password field is required.';
        }
        catch (Cartalyst\Sentry\Users\UserExistsException $e)
        {
            $error = 'User with this login already exists.';
        }
        catch (\Swift_TransportException $e)
        {
            $error = sprintf('Could not send email - %s', $e->getMessage());
        }
        Log::error(sprintf("processRegistration() - Exception: %s", $error));
        return Redirect::to('/register')->withInput()->with('message', $error);
    }
    
    public function processActivation($hash = '') {
        try {
                // Find the user using the user activation code
            $user = Sentry::getUserProvider()->findByActivationCode($hash);
            
 
            // Attempt to activate the user
            if ($user->attemptActivation($hash))
            {
                Log::info(sprintf("User %s activated", $user->email));
                return Redirect::to('/login')->with('message', sprintf("Activation complete for %s", $user->email));
            }
            $message = "Unable to activate";
         } catch (UserNotFoundException $e) {
            $message = "Activation code is not valid";
            Log::error(sprintf("processActivation() - Exception: %s", $e->GetMessage()));
         } catch (Exception $e) {
            $message = "Activation code is not valid";
            Log::error(sprintf("processActivation() - Exception: %s", $e->GetMessage()));
         }
         return Redirect::to('/login')->with('message', $message);
}


}

?>
