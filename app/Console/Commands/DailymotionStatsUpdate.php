<?php

namespace App\Console\Commands;

use App\User;
use App\DailymotionChannel;
use Illuminate\Console\Command;

class DailymotionStatsUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dailymotion:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the Dailymotion subs, views, and video count for registered users.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::all();
        
        foreach ($users as $user) {

            if (isset($user->dailymotionChannel->channel_url)) {

                $stats = json_decode(file_get_contents('https://api.dailymotion.com/user/'. $user->dailymotionChannel->channel_id . '?fields=followers_total,videos_total,views_total'));
                $dailymotion = DailymotionChannel::where('user_id', $user->id)->first();
                
                $dailymotion->subscriber_count = $stats->followers_total;
                $dailymotion->view_count = $stats->views_total;
                $dailymotion->video_count = $stats->videos_total;
        
                $dailymotion->save();
                
                //dump($stats, $dailymotion);
                
            }

        }

        $this->info('Dailymotion Stats have been pulled.');
    }
}
