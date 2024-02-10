<?php

namespace App\Http\Controllers;

use App\User;
use Socialite;
use App\YoutubeChannel;
use App\DailymotionChannel;
use Illuminate\Http\Request;
use Alaouy\Youtube\Facades\Youtube;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class SocialAuthController extends Controller
{
    /**
     * Redirect the user to the YouTube authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToYoutube(Request $request)
    {
        $request->session()->put('user_id', Auth::user()->id);

        return Socialite::with('youtube')
        ->with(['access_type' => 'offline', 'prompt' => 'consent'])
        ->scopes(['email', 'profile', 'openid', 'https://www.googleapis.com/auth/youtube', 'https://www.googleapis.com/auth/youtube.readonly', 'https://www.googleapis.com/auth/yt-analytics.readonly', 'https://www.googleapis.com/auth/yt-analytics-monetary.readonly'])
        ->redirect();
    }

    /**
     * Obtain the user information from YouTube.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleYoutubeCallback(Request $request)
    {
        $data = Socialite::driver('youtube')->user();
        $channel = Youtube::getChannelByID($data->id);
        $user_id = session('user_id');
        
        $user = User::where('id', $user_id)->first();

        /*if ($user->avatar == "no_avatar.jpg") {
            
            $img = Image::make($data->avatar);
            $imgname = time() . '-' . $data->id . '.png';
            $img->save(storage_path('app/public/photos/avatars/'.$imgname));

            $user->avatar = $imgname;
        }*/

        $user->save();

        $youtube = new YoutubeChannel();

        $youtube->channel_url = $data->id;
        $youtube->youtube_access = $data->token;
        $youtube->youtube_refresh = $data->refreshToken;
        $youtube->youtube_expires = $data->expiresIn;
        $youtube->subscriber_count = $channel->statistics->subscriberCount;
        $youtube->view_count = $channel->statistics->viewCount;
        $youtube->video_count = $channel->statistics->videoCount;
        $youtube->user_id = $user_id;

        $youtube->save();

        /*
        $videoListTest = Youtube::getActivitiesByChannelId('UCoLUji8TYrgDy74_iiazvYA');
        
        $videoIds = [];
        $x = 0;
        $countX = count($videoListTest);
        while ($x < $countX) {
            if (isset($videoListTest[$x]->contentDetails->upload->videoId)) {
                array_push($videoIds, $videoListTest[$x]->contentDetails->upload->videoId);
                $x++;
            } else {
                $x++;
            }
        }
        
        $videos = [];
        foreach ($videoIds as $videoId) {
            array_push($videos, Youtube::getVideoInfo($videoId));
        }
        */

        // Redirect
        return redirect("/settings")->with('success', 'YouTube Account Added Successfully');

    }

    /**
     * Remove YouTube channel from the platform.
     * 
     * @return \Illuminate\Http\Response
     */
    public function handleYoutubeRemoval(Request $request, $id) 
    {
        $user = User::where('id', $id)->first();
        $channel = YoutubeChannel::where('user_id', $user->id)->first();
        
        $channel->delete();

        return redirect('/settings')->with('success', 'YouTube Channel Removed Successfully');

    }

    /**
     * Redirect the user to the YouTube authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToDailymotion(Request $request)
    {
        $request->session()->put('user_id', Auth::user()->id);

        return Socialite::with('dailymotion')->scopes(['email', 'userinfo', 'delegate_account_management', 'read_insights'])->redirect();
    }

    /**
     * Obtain the user information from YouTube.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleDailymotionCallback(Request $request)
    {
        $data = Socialite::driver('dailymotion')->user();
        $user_id = session('user_id');
        $channel = json_decode(file_get_contents('https://api.dailymotion.com/user/'. $data->id . '?fields=followers_total,videos_total,views_total'));

        $user = User::where('id', $user_id)->first();

        /*if ($user->avatar == "no_avatar.jpg") {
            
            $img = Image::make($data->avatar);
            $imgname = time() . '-' . $data->id . '.png';
            $img->save(storage_path('app/public/photos/avatars/'.$imgname));

            $user->avatar = $imgname;
        }*/

        $user->save();

        $dailymotion = new DailymotionChannel();

        $dailymotion->channel_id = $data->id;
        $dailymotion->channel_url = $data->nickname;
        $dailymotion->dailymotion_access = $data->token;
        $dailymotion->dailymotion_refresh = $data->refreshToken;
        $dailymotion->dailymotion_expires = $data->expiresIn;
        $dailymotion->subscriber_count = $channel->followers_total;
        $dailymotion->view_count = $channel->views_total;
        $dailymotion->video_count = $channel->videos_total;
        $dailymotion->user_id = $user_id;

        $dailymotion->save();

        //dd($data, $channel, $channel->followers_total);

        // Redirect
        return redirect("/settings")->with('success', 'Dailymotion Account Added Successfully');

    }

    /**
     * Remove Dailymotion channel from the platform.
     * 
     * @return \Illuminate\Http\Response
     */
    public function handleDailymotionRemoval(Request $request, $id) 
    {
        $user = User::where('id', $id)->first();
        $channel = DailymotionChannel::where('user_id', $user->id)->first();
        
        $channel->delete();

        return redirect('/settings')->with('success', 'Dailymotion Channel Removed Successfully');

    }
    
}
