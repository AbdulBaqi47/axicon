<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\GuzzleException;
use Carbon\Carbon;
use App\DailymotionChannel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DailymotionCMSUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dmcms:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks if users are still in the Dailymotion CMS and adds new users.';

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
        $dailymotionParent = DailymotionChannel::where('channel_id', 'x1lvw98')->first();

        $client = new Client([
            'headers' => ['User-Agent' => 'GetChannels', 'Authorization' => 'Bearer '.$dailymotionParent->dailymotion_access]
        ]);
        $firstResult = $client->get('https://api.dailymotion.com/user/x1lvw98/children?fields=id,username,revenues_video_total,revenues_website_total,revenues_claim_total&page=1');

        $firstResponse = json_decode($firstResult->getBody());

        foreach ($firstResponse->list as $account) {

            if (DB::table('cms')->where('channel_id', $account->id)->exists()) {

                // Channel from CMS is already in our db 
                DB::table('cms')->where('channel_id', $account->id)->update(['revenues_video_total' => $account->revenues_video_total, 'revenues_website_total' => $account->revenues_website_total, 'revenues_claim_total' => $account->revenues_claim_total, 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()]);
            
            } else {
                
                // Channel from CMS isn't in our db
                DB::table('cms')->insert(
                    ['channel_id' => $account->id, 'channel_url' => $account->username, 'revenues_video_total' => $account->revenues_video_total, 'revenues_website_total' => $account->revenues_website_total, 'revenues_claim_total' => $account->revenues_claim_total, 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()]
                );
                
            }

        };

        $response = $firstResponse;
        
        if ($response->has_more == true) {
            
            $i = 2;

            while ($response->has_more == true) {
                $newResult = $client->get('https://api.dailymotion.com/user/x1lvw98/children?fields=id,username,revenues_video_total,revenues_website_total,revenues_claim_total&page='.$i);
                $newResponse = json_decode($newResult->getBody());

                foreach ($newResponse->list as $account) {

                    if (DB::table('cms')->where('channel_id', $account->id)->exists()) {
        
                        // Channel from CMS is already in our db 
                        DB::table('cms')->where('channel_id', $account->id)->update(['revenues_video_total' => $account->revenues_video_total, 'revenues_website_total' => $account->revenues_website_total, 'revenues_claim_total' => $account->revenues_claim_total, 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()]);
                    
                    } else {
                        
                        // Channel from CMS isn't in our db
                        DB::table('cms')->insert(
                            ['channel_id' => $account->id, 'channel_url' => $account->username, 'revenues_video_total' => $account->revenues_video_total, 'revenues_website_total' => $account->revenues_website_total, 'revenues_claim_total' => $account->revenues_claim_total, 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()]
                        );
                        
                    }
        
                };
                
                $response = $newResponse;

                $i++;
            }
        }

        $this->info('Dailymotion CMS has been updated.');
    }
}
