<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserConfirmEmailRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserSendEmailRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PHPMailer;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user_id = $request->id;

        $input = array();
        $input['name'] = $request->name;

        if($request->newPassword != ''){
            $input['password'] = Hash::make($request->newPassword);
        }

        $user = User::findOrFail($user_id);
        $user->update($input);

        return json_encode('Data updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // Route for register
    public function register(UserRegisterRequest $request, $object)
    {
        // Test if e-mail is in use
        $test_email = User::whereEmail($request->email)->get()->first();

        // Test if name is in use -> "e-mail" and "name" have separate test for precise error collecting
        $test_name = User::whereName($request->name)->get()->first();

        // Ff e-mail is not in use add user and send e-mail for "e-mail confirmation"
        if(empty($test_email))
        {
            if(empty($test_name))
            {
                // Compile message for user (for each language different message)
                $user_language = $request->language;
                $message_for_user_subject = '';
                $message_for_user = '';

                if($user_language == 'de'){
                    $message_for_user_subject = 'E-Mail bestätigen \ Media';
                    $message_for_user = 'Konto aktivieren, 
                    (nach erfolgreicher Aktivierung werden Sie auf die Seite "Media" umgeleitet)';
                }elseif($user_language == 'hr'){
                    $message_for_user_subject = 'Confirm e-mail \ Media';
                    $message_for_user = 'Aktivirajte korisnički račun, 
                    (nakon uspješne aktivacije bit ćete preusmjereni na "Media" stranicu)';
                }else{
                    $message_for_user_subject = 'Potvrda e-maila \ Media';
                    $message_for_user == 'activate the account 
                    (after successful activation you will be redirected to "Media" page)';
                }


                $input['name'] = $request->name;
                $input['email'] = $request->email;
                $input['password'] = Hash::make($request->password);
                $input['confirmation_code'] = rand(1, 10000);
                User::create($input);
                $basic_url = 'http://www.consilium-europa.com/pages/';
                $for_email_confirmation = $basic_url . 'media_api/public/api/confirm_email?email='
                    . $request->email . '&confirmation_code=' . $input['confirmation_code'];
                $mail = new PHPMailer(true);
                $mail->setFrom('luketic.damir@gmail.com', 'Media');
                $mail->addAddress($request->email, $request->name);
                $mail->Subject = $message_for_user_subject;
                $mail->Body    = '<h3>e-mail: ' . $request->email . '</h3><br /><hr /><p>' . $message_for_user .
                    '<br />' . $for_email_confirmation . '</p>';
                $mail->AltBody = 'Access HTML data for details';
                if(!$mail->send()) {
                    echo json_encode('Message could not be sent.');
                    echo json_encode('Mailer Error: ' . $mail->ErrorInfo);
                } else {
                    // Success (case 4) -> Confirm e-mail to activate account
                    return json_encode('4');
                }
            }else{
                // Error 1 -> Name in use
                return json_encode('1');
            }
        }else{
            if(empty($test_name)){
                // Error 2 -> E-mail in use
                return json_encode('2');
            }else{
                // Error 3 -> E-mail and name in use
                return json_encode('3');
            }
        }
    }

    // Function for e-mail confirmation
    public function confirm_email(UserConfirmEmailRequest $request){
        $user = User::whereEmail($request->email)->whereConfirmationCode($request->confirmation_code)->first();
        if(empty($user)){
            return json_encode('Error');
        }else{
            $new_code = rand(500, 10000);
            $user->update([
                'active'          => 1,
                'confirmation_code' => $new_code
            ]);
            echo '<meta http-equiv="refresh" content="0; URL=\'http://www.consilium-europa.com/pages/media\'"/> ';
            echo 'Positive';
        }
    }

    // Function for login
    public function login(UserLoginRequest $requests, $object)
    {
     $user_language = $requests->language;

        if($user = User::whereEmail($requests->email)->whereActive(1)->first())
        {
            if (password_verify($requests->password, $user->password))
            {
                $user_data['id'] = $user->id;
                $user_data['name'] = $user->name;
                $user_data['email'] = $user->email;
                $user_data['admin'] = $user->admin;
                $user_data['visible'] = $user->visible;
                $user_data['image_url'] = $user->image_url;

                return json_encode($user_data);
            } else
            {
                $password_error = '';

                if($user_language == 'de')
                {
                    $password_error = 'Falsches Passwort';
                }elseif ($user_language == 'hr')
                {
                    $password_error = 'Netočna zaporka';
                }else
                {
                    $password_error = 'False password';
                }

                return json_encode($password_error);
            }
        }else
        {
            $password_email_error = '';

            if($user_language == 'de')
            {
                $password_email_error = 'Falsche E-Mail und \ oder Passwort, oder E-Mail ist nicht bestätigt';
            }elseif ($user_language == 'hr')
            {
                $password_email_error = 'Netočan e-mail i \ ili lozinka, ili e-mail nije potvrđen';
            }else
            {
                $password_email_error = 'False e-mail and\or password, or e-mail is not confirmed';
            }

            return json_encode($password_email_error);
        }
    }

    // Function for send contact
    public function send_email(UserSendEmailRequest $request, $object)
    {
        $mail = new PHPMailer(true);
        $mail->setFrom('luketic.damir@gmail.com', 'Media');
        $mail->addAddress($request->formEmail, $request->name);
        $mail->Subject = 'Media';
        $mail->Body    = '<h3>Name: ' . $request->name . '</h3><h4>E-mail: ' . $request->formEmail .
                         '</h4><br /><hr /><h4>' . 'Message</h4><p>' . $request->formText . '</p>';
        $mail->AltBody = 'url';
        if(!$mail->send()) {
            echo json_encode('Message could not be sent.');
            echo json_encode('Mailer Error: ' . $mail->ErrorInfo);
        } else {
            return json_encode('Message send');
        }
    }

    // Function for upload user image
    public function user_image(Request $request, $user_id)
    {
        if ($request->hasFile('photo')) {

            $user = User::findOrFail($user_id);
            $basic_path = public_path() . '/images/users/' . $user_id . '/';

            // If exist, remove old image
            if($user->image_url != null)
            {
                unlink($basic_path . $user->image_url);
            }

            // Upload new image
            $image = $request->file('photo');
            $name = time() . $image->getClientOriginalName();
            $image->move('images/users/' . $user_id, $name);

            // Update user image root
            $user->image_url = $name;
            $user->save();

            return json_encode($name);
        }else{
            return json_encode('error');
        }
    }

}
