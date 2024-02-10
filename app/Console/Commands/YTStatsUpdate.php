<?php

namespace App\Console\Commands;

use App\User;
use App\YoutubeChannel;
use Illuminate\Console\Command;
use Alaouy\Youtube\Facades\Youtube;

class YTStatsUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'youtube:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the Youtube subs, views, and video count for registered users.';

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

            if (isset($user->youtubeChannel->channel_url)) {

                $channel = YoutubeChannel::where('user_id', $user->id)->first();
                
                $stats = Youtube::getChannelByID($user->youtubeChannel->channel_url);
                $channel->subscriber_count = $stats->statistics->subscriberCount;
                $channel->view_count = $stats->statistics->viewCount;
                $channel->video_count = $stats->statistics->videoCount;
        
                $channel->save();
                
                //dump($stats, $channel);
                
            }

        }

        $this->info('Youtube Stats have been pulled.');
    }
}
