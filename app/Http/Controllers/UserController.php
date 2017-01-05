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

    // route for register
    public function register(UserRegisterRequest $request, $object)
    {
        // test if e-mail is in use
        $test_email = User::whereEmail($request->email)->get()->first();
        // if e-mail is not in use add user and send e-mail for "e-mail confirmation"
        if(empty($test_email)){
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
            $mail->Subject = 'Confirm e-mail \ Media';
            $mail->Body    = '<h3>e-mail: ' . $request->email . '</h3><br /><hr /><p>' . 'activate account, ' .
                $for_email_confirmation . '</p>';
            $mail->AltBody = 'url';
            if(!$mail->send()) {
                echo json_encode('Message could not be sent.');
                echo json_encode('Mailer Error: ' . $mail->ErrorInfo);
            } else {
                return json_encode('Confirm e-mail to activate account');
            }
        }else{
            return json_encode('Email in use');
        }
    }

    // function for e-mail confirmation
    public function confirm_email(UserConfirmEmailRequest $request){
        $user = User::whereEmail($request->email)->whereConfirmationCode($request->confirmation_code)->first();
        if(empty($user)){
            return json_encode('Wrong e-mail or code');
        }else{
            $new_code = rand(500, 10000);
            $user->update([
                'active'          => 1,
                'confirmation_code' => $new_code
            ]);
            echo 'Account is now active';
            echo '<br />';
            echo '<a href="http://www.consilium-europa.com/pages/media/">To page</a>';
        }
    }

    // route for login
    public function login(UserLoginRequest $requests, $object)
    {
        if($user = User::whereEmail($requests->email)->whereActive(1)->first())
        {
            if (password_verify($requests->password, $user->password))
            {
                $user_data['id'] = $user->id;
                $user_data['name'] = $user->name;
                $user_data['email'] = $user->email;
                $user_data['admin'] = $user->admin;
                $user_data['visible'] = $user->admin;

                return json_encode($user_data);
            } else
            {
                return json_encode('False password');
            }
        }else
        {
            return json_encode('False e-mail and\or password, or e-mail is not confirmed');
        }
    }

    // route for send contact
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
}
