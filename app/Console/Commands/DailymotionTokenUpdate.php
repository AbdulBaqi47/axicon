<?php

namespace App\Console\Commands;

use App\User;
use App\DailymotionChannel;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Console\Command;

class DailymotionTokenUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dmtoken:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the Dailymotion access tokens for registered users.';

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

                $client = new Client([
                    'headers' => ['User-Agent' => 'UpdateDailymotionToken', 'Content-Type' => 'application/x-www-form-urlencoded']
                ]);
                
                $result = $client->post('https://api.dailymotion.com/oauth/token', [
                    'form_params' => [
                        'grant_type' => 'refresh_token',
                        'client_id' => env('DAILYMOTION_KEY'),
                        'client_secret' => env('DAILYMOTION_SECRET'),
                        'refresh_token' => $user->dailymotionChannel->dailymotion_refresh
                    ]
                ]);
        
                $response = json_decode($result->getBody());

                // Update DB
                $user->dailymotionChannel->dailymotion_access = $response->access_token;
                
                $user->dailymotionChannel->save();
                
            }

        }

        $this->info('Dailymotion Access Tokens have been updated.');
    }
}
