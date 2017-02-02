<?php

namespace App\Http\Controllers;

use App\User;
use App\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
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
    public function video_for_change(){

        $users = User::whereActive(1)->whereItemsVisible(1)->get();
        $items = [];

        foreach ($users as $user)
        {
            foreach ($user->videos as $video)
            {
                $images = [];

                foreach ($video->images as $image)
                {
                    // We can't use here "select" (it will retrieve data for all polymorphic tables)
                    $image_obj = [];
                    $image_obj['id']        = $image->id;
                    $image_obj['url']       = $image->url;
                    $image_obj['featured']  = $image->featured;

                    $images[] = $image_obj;
                }

                // Create identifiers array
                $identifiers = [];
                foreach ($video->identifiers as $identifier) {
                    // We can't use here "select" (it will retrieve data for all polymorphic tables)
                    $identifiers_obj = [];
                    $identifiers_obj['id']     = $identifier->id;
                    $identifiers_obj['title']  = $identifier->title;
                    $identifiers_obj['input']  = $identifier->input;

                    $identifiers[] = $identifiers_obj;
                }

                if($video->for_change == 1 && $video->allowed == 1)
                {
                    $items[] = array(
                        'owner_name'         => $user->name,
                        'id'                 => $video->id,
                        'user_id'            => $video->user_id,
                        'video_category_id'  => $video->video_category_id,
                        'condition_id'       => $video->condition_id,
                        'name'               => $video->name,
                        'director'           => $video->director,
                        'year'               => $video->year,
                        'description'        => $video->description,
                        'first_release_year' => $video->first_release_year,
                        'barcode_numbers'    => $video->barcode_numbers,
                        'images'             => $images,
                        'identifiers'        => $identifiers
                    );
                }
            }
        }
        return json_encode($items);
    }

    // Access video "allowed"
    public function video_allowed(Request $request, $user_id){

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
                foreach ($user->videos as $video)
                {
                    $images = [];

                    foreach ($video->images as $image)
                    {
                        // We can't use here "select" (it will retrieve data for all polymorphic tables)
                        $image_obj = [];
                        $image_obj['id']        = $image->id;
                        $image_obj['url']       = $image->url;
                        $image_obj['featured']  = $image->featured;

                        $images[] = $image_obj;
                    }

                    // Create identifiers array
                    $identifiers = [];
                    foreach ($video->identifiers as $identifier) {
                        // We can't use here "select" (it will retrieve data for all polymorphic tables)
                        $identifiers_obj = [];
                        $identifiers_obj['id']     = $identifier->id;
                        $identifiers_obj['title']  = $identifier->title;
                        $identifiers_obj['input']  = $identifier->input;

                        $identifiers[] = $identifiers_obj;
                    }

                    if($video->for_change == 1 && $video->allowed == 1)
                    {
                        $items[] = array(
                            'owner_name'         => $user->name,
                            'id'                 => $video->id,
                            'user_id'            => $video->user_id,
                            'video_category_id'  => $video->video_category_id,
                            'condition_id'       => $video->condition_id,
                            'name'               => $video->name,
                            'director'           => $video->director,
                            'year'               => $video->year,
                            'description'        => $video->description,
                            'for_change'         => $video->for_change,
                            'first_release_year' => $video->first_release_year,
                            'barcode_numbers'    => $video->barcode_numbers,
                            'images'             => $images,
                            'identifiers'        => $identifiers
                        );
                    }
                }
            }
        }
        return json_encode($items);
    }

    // Access video "personal"
    public function video_personal(Request $request, $user_id)
    {
        $user = User::findOrFail($user_id);
        $items = [];

        foreach ($user->videos as $video) {
            // Create image array
            $images = [];

            foreach ($video->images as $image) {
                // We can't use here "select" (it will retrieve data for all polymorphic tables)
                $image_obj = [];
                $image_obj['id']        = $image->id;
                $image_obj['url']       = $image->url;
                $image_obj['featured']  = $image->featured;

                $images[] = $image_obj;
            }

            // Create identifiers array
            $identifiers = [];
            foreach ($video->identifiers as $identifier) {
                // We can't use here "select" (it will retrieve data for all polymorphic tables)
                $identifiers_obj = [];
                $identifiers_obj['id']     = $identifier->id;
                $identifiers_obj['title']  = $identifier->title;
                $identifiers_obj['input']  = $identifier->input;

                $identifiers[] = $identifiers_obj;
            }

            $items[] = array(
                'id'                 => $video->id,
                'user_id'            => $video->user_id,
                'video_category_id'  => $video->video_category_id,
                'condition_id'       => $video->condition_id,
                'name'               => $video->name,
                'director'           => $video->director,
                'year'               => $video->year,
                'description'        => $video->description,
                'for_change'         => $video->for_change,
                'allowed'            => $video->allowed,
                'created_at'         => $video->created_at,
                'updated_at'         => $video->updated_at,
                'first_release_year' => $video->first_release_year,
                'personal_note'      => $video->personal_note,
                'barcode_numbers'    => $video->barcode_numbers,
                'images'             => $images,
                'identifiers'        => $identifiers
            );
        }
        return json_encode($items);
    }
}
