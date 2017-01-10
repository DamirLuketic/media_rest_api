<?php

namespace App\Http\Controllers;

use App\Audio;
use App\User;
use Illuminate\Http\Request;

class AudioController extends Controller
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
        //
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

    // Access audio "for change"
    public function audio_for_change(){

        $users = User::whereActive(1)->whereItemsVisible(1)->get();
        $items = [];

        foreach ($users as $user)
        {
            foreach ($user->audio as $audio)
            {
                if($audio->for_change === 1 && $audio->allowed === 1)
                {
                    $items[] = array(
                                     'owner_name'        => $user->name,
                                     'id'                => $audio->id,
                                     'user_id'           => $audio->id,
                                     'audio_category_id' => $audio->audio_category_id,
                                     'condition_id'      => $audio->condition_id,
                                     'band'              => $audio->band,
                                     'album'             => $audio->album,
                                     'year'              => $audio->year,
                                     'description'       => $audio->description
                    );
                }
            }
        }
        return json_encode($items);
    }

    // Access audio "allowed"
    public function audio_allowed(Request $request, $user_id){

        // Collect id's of user whose complete items list (also "not for change") is allowed to see
        $current_user_allowed = User::findOrFail($user_id)->can_view;
        $allowed_list = [];

        foreach ($current_user_allowed as $allowed_user)
        {
            $allowed_list[] = $allowed_user->can_view_id;
        }

        // Collect data for showing

        $users = User::whereActive(1)->whereItemsVisible(1)->get();
        $items = [];

        foreach ($users as $user)
        {
            if(in_array($user->id, $allowed_list))
            {
                foreach ($user->audio as $audio)
                {
                    if($audio->for_change === 1 && $audio->allowed === 1)
                    {
                        $items[] = array(
                            'owner_name'        => $user->name,
                            'id'                => $audio->id,
                            'user_id'           => $audio->id,
                            'audio_category_id' => $audio->audio_category_id,
                            'condition_id'      => $audio->condition_id,
                            'band'              => $audio->band,
                            'album'             => $audio->album,
                            'year'              => $audio->year,
                            'description'       => $audio->description,
                            'for_change'        => $audio->for_change
                        );
                    }
                }
            }
        }
        return json_encode($items);
    }

    // Access audio "personal"
    public function audio_personal(Request $request, $user_id)
    {
        $user_audio = User::findOrFail($user_id)->audio;

        return json_encode($user_audio);
    }
}
