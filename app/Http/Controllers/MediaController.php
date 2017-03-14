<?php

namespace App\Http\Controllers;

use App\Audio;
use App\AudioCategory;
use App\Condition;
use App\Image;
use App\User;
use App\Video;
use App\VideoCategory;
use Illuminate\Http\Request;

class MediaController extends Controller
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
        // Insert basic data
            // Collect all data
            $user_id            = $request->user_id;
            $album_name         = $request->albumName;
            $band_director      = $request->bandDirector;
            $barcode_number     = $request->barcodeNumber;
            $cat                = $request->cat;
            $category           = $request->category;
            $change             = $request->change;
            $condition          = $request->condition;
            $description        = $request->description;
            $first_release_year = $request->firstReleaseYear;
            $label              = $request->label;
            $personal_note      = $request->personalNote;
            $type               = $request->type;
            $year               = $request->year;
            $identifiers        = $request->identifiers;

            // Default variable for current media
            $current_media = null;

            if($type == 'Audio')
            {
                Audio::create([
                    'user_id'               => $user_id,
                    'audio_category_id'     => $category,
                    'for_change'            => $change,
                    'condition_id'          => $condition,
                    'band'                  => $band_director,
                    'album'                 => $album_name,
                    'year'                  => $year,
                    'first_release_year'    => $first_release_year,
                    'description'           => $description,
                    'personal_note'         => $personal_note,
                    'cat'                   => $cat,
                    'label'                 => $label,
                    'barcode_numbers'       => $barcode_number
                ]);

                // Catch current setting media for adding identifiers and send response (for add images)
                $current_media = Audio::orderBy('created_at', 'desc')->first();
            }

            if($type == 'Video')
            {
                Video::create([
                    'user_id'               => $user_id,
                    'video_category_id'     => $category,
                    'for_change'            => $change,
                    'condition_id'          => $condition,
                    'director'              => $band_director,
                    'name'                  => $album_name,
                    'year'                  => $year,
                    'first_release_year'    => $first_release_year,
                    'description'           => $description,
                    'personal_note'         => $personal_note,
                    'barcode_numbers'       => $barcode_number
                ]);

                // Catch current setting media for adding identifiers and send response (for add images)
                $current_media = Video::orderBy('created_at', 'desc')->first();
            }

       // Set identifiers
        foreach ($identifiers as $identifier)
        {
            $current_media->identifiers()->create([
                'title' => $identifier['name'],
                'input' => $identifier['identifierValue']
            ]);
        }

       // Setting media images
        // Return media ID / NG2 contained media Type
            return json_encode($current_media->id);
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
        $current_media_type = $request->media_category;
        $id                 = $request->id;
        $category_id        = $request->category_id;
        $condition_id       = $request->condition_id;
        $bandDirector       = $request->bandDirector;
        $albumName          = $request->albumName;
        $year               = $request->year;
        $description        = $request->description;
        $for_change         = $request->for_change;
        $first_release_year = $request->first_release_year;
        $personal_note      = $request->personal_note;
        $cat                = $request->cat;
        $label              = $request->label;
        $barcode_numbers    = $request->barcode_numbers;
        $identifiers        = $request->identifiers;


        if($current_media_type == 'Audio')
        {
            $audio = Audio::findOrFail($id);
            $audio->update([
                'audio_category_id'     => $category_id,
                'for_change'            => $for_change,
                'condition_id'          => $condition_id,
                'band'                  => $bandDirector,
                'album'                 => $albumName,
                'year'                  => $year,
                'first_release_year'    => $first_release_year,
                'description'           => $description,
                'personal_note'         => $personal_note,
                'cat'                   => $cat,
                'label'                 => $label,
                'barcode_numbers'       => $barcode_numbers
            ]);

            // Set identifiers

                // Default update -> for show also when is identifier updated
            $audio->update(['condition_id' => 1]);
            $audio->update(['condition_id' => 2]);
            $audio->update(['condition_id' => $condition_id]);

            $audio->identifiers()->delete();
            foreach ($identifiers as $identifier)
            {
                $audio->identifiers()->create([
                    'title' => $identifier['title'],
                    'input' => $identifier['input']
                ]);
            }
            return json_encode($audio->updated_at);
        }else{
            $video = Video::findOrFail($id);
            $video->update([
                'video_category_id'     => $category_id,
                'for_change'            => $for_change,
                'condition_id'          => $condition_id,
                'director'              => $bandDirector,
                'name'                  => $albumName,
                'year'                  => $year,
                'first_release_year'    => $first_release_year,
                'description'           => $description,
                'personal_note'         => $personal_note,
                'barcode_numbers'       => $barcode_numbers
            ]);

            // Set identifiers

            // Default update -> for show also when is identifier updated
            $video->update(['condition_id' => 1]);
            $video->update(['condition_id' => 2]);
            $video->update(['condition_id' => $condition_id]);

            $video->identifiers()->delete();

            foreach ($identifiers as $identifier)
            {
                $video->identifiers()->create([
                    'title' => $identifier['title'],
                    'input' => $identifier['input']
                ]);
            }
            return json_encode($video->updated_at);
        }
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

    // Function for new media images
    public function new_media_images(Request $request, $media_type, $media_id)
    {
        // Variable for media type
        $type = $media_type;

        // Variable for media;
        $media = null;

        // Retrieve media
        if($type == 'Audio')
        {
            $media = Audio::findOrFail($media_id);
        }elseif ($type == 'Video')
        {
            $media = Video::findOrFail($media_id);
        }

        // Default variables for photo
        $photoFeatured = null;
        $photoNotFeatured1 = null;
        $photoNotFeatured2 = null;

        // Collect all images
        if ($request->hasFile('photoFeatured'))
        {
            // Save image local
            $photoFeatured = $request->file('photoFeatured');
            $photoFeaturedName = time() . $photoFeatured->getClientOriginalName();
            $photoFeatured->move('images/media/' . $type . '/', $photoFeaturedName);

            // Update DB
                $media->images()->create([
                    'url'       => '/images/media/' . $type . '/' . $photoFeaturedName,
                    'featured'  => 1
                ]);
        }
        if ($request->hasFile('photoNotFeatured1'))
        {
            // Save image local
            $photoNotFeatured1 = $request->file('photoNotFeatured1');
            $photoNotFeatured1Name = time() . $photoNotFeatured1->getClientOriginalName();
            $photoNotFeatured1->move('images/media/' . $type . '/', $photoNotFeatured1Name);

//            // Update DB
            $media->images()->create([
                'url'       => '/images/media/' . $type . '/' . $photoNotFeatured1Name
            ]);
        }
        if ($request->hasFile('photoNotFeatured2'))
        {
            // Save image local
            $photoNotFeatured2 = $request->file('photoNotFeatured2');
            $photoNotFeatured2Name = time() . $photoNotFeatured2->getClientOriginalName();
            $photoNotFeatured2->move('images/media/' . $type . '/', $photoNotFeatured2Name);

            // Update DB
            $media->images()->create([
                'url'       => '/images/media/' . $type . '/' . $photoNotFeatured2Name
            ]);
        }

        // Set new photo when update media
        if ($request->hasFile('newPhoto'))
        {
            // Save image local
            $newPhoto = $request->file('newPhoto');
            $newPhotoName = time() . $newPhoto->getClientOriginalName();
            $newPhoto->move('images/media/' . $type . '/', $newPhotoName);

            // Default update -> for show also when is image upload

            $condition_id = $media->condition_id;

            $media->update(['condition_id' => 1]);
            $media->update(['condition_id' => 2]);
            $media->update(['condition_id' => $condition_id]);

            // Update DB
            if($media->images()->first() == null)
            {
                $media->images()->create([
                    'url'       => '/images/media/' . $type . '/' . $newPhotoName,
                    'featured'  => 1
                ]);
            }else
            {
                $media->images()->create([
                    'url'       => '/images/media/' . $type . '/' . $newPhotoName
                ]);
            }
        }

        return json_encode($media);
    }

    public function delete_image(Request $request){

        $media_type = $request->media_type;
        $media_id   = $request->media_id;
        $image_id   = $request->image_id;

        if($media_type == 'Audio')
        {
            $audio = Audio::findOrFail($media_id);
            $image = $audio->images()->where('id', '=', $image_id)->first();

            // If deleted is featured, and audio have other images, first next image become featured
            if($image->featured == 1)
            {
                if($other_image = $audio->images()->where('id', '!=', $image_id)->first())
                {
                    $other_image->update([
                        'featured' => 1
                    ]);
                }
            }

            unlink(public_path() . $image->url);

            $image->delete();

            // Default update -> for show also when is images updated
            $condition_id = $audio->condition_id;

            $audio->update(['condition_id' => 1]);
            $audio->update(['condition_id' => 2]);
            $audio->update(['condition_id' => $condition_id]);

            return json_encode($audio->updated_at);
        }else
        {
            $video = Video::findOrFail($media_id);
            $image = $video->images()->where('id', '=', $image_id)->first();

            // If deleted is featured, and video have other images, first next image become featured
            if($image->featured == 1)
            {
                if($other_image = $video->images()->where('id', '!=', $image_id)->first())
                {
                    $other_image->update([
                        'featured' => 1
                    ]);
                }
            }

            unlink(public_path() . $image->url);

            $image->delete();

            // Default update -> for show also when is images updated
            $condition_id = $video->condition_id;

            $video->update(['condition_id' => 1]);
            $video->update(['condition_id' => 2]);
            $video->update(['condition_id' => $condition_id]);

            return json_encode($video->updated_at);
        }
    }

    public function set_new_featured_image(Request $request)
    {
        $media_type = $request->media_type;
        $media_id = $request->media_id;
        $image_id = $request->image_id;

        if($media_type == 'Audio')
        {
            $audio = Audio::findOrFail($media_id);

            // Set current featured image to non featured image
            $current_featured_image = $audio->images()->where('featured', '=', 1)->first();
            $current_featured_image->update(['featured' => 0]);

            $image = $audio->images()->where('id', '=', $image_id)->first();
            $image->update(['featured' => 1]);

            // Default update -> for show also when is images updated
            $condition_id = $audio->condition_id;

            $audio->update(['condition_id' => 1]);
            $audio->update(['condition_id' => 2]);
            $audio->update(['condition_id' => $condition_id]);

            return json_encode($audio->updated_at);
        }else
        {
            $video = Video::findOrFail($media_id);

            // Set current featured image to non featured image
            $current_featured_image = $video->images()->where('featured', '=', 1)->first();
            $current_featured_image->update(['featured' => 0]);

            $image = $video->images()->where('id', '=', $image_id)->first();
            $image->update(['featured' => 1]);

            // Default update -> for show also when is images updated
            $condition_id = $video->condition_id;

            $video->update(['condition_id' => 1]);
            $video->update(['condition_id' => 2]);
            $video->update(['condition_id' => $condition_id]);

            return json_encode($video->updated_at);
        }
    }

    // Function for collect media category
    public function collect_media_categories()
    {
        $audio_categories = AudioCategory::select('id', 'name')->get();
        $video_categories = VideoCategory::select('id', 'name')->get();

        $media_categories = json_encode(['audio_categories' => $audio_categories, 'video_categories' => $video_categories]);
        return $media_categories;
    }

    // Function for collect media conditions
    public function collect_conditions()
    {
        $media_conditions = Condition::select('id', 'name')->get();

        return json_encode($media_conditions);
    }
}
