<?php

namespace App\Http\Controllers;

use App\CMS;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\DailymotionChannel;
use Illuminate\Http\Request;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Exception\GuzzleException;

class CMSController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getChannelsInNetwork()
    {
        $dailymotionParent = DailymotionChannel::where('channel_id', 'x1lvw98')->first();

        $client = new Client([
            'headers' => ['User-Agent' => 'GetChannels', 'Authorization' => 'Bearer '.$dailymotionParent->dailymotion_access]
        ]);
        $firstResult = $client->get('https://api.dailymotion.com/user/x1lvw98/children?fields=id,username,revenues_video_total,revenues_website_total,revenues_claim_total&page=1');

        $firstResponse = json_decode($firstResult->getBody());
        
        //$partners = array($firstResponse->list);

        foreach ($firstResponse->list as $account) {

            DB::table('cms')->insert(
                ['channel_id' => $account->id, 'channel_url' => $account->username, 'revenues_video_total' => $account->revenues_video_total, 'revenues_website_total' => $account->revenues_website_total, 'revenues_claim_total' => $account->revenues_claim_total, 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()]
            );

        };

        $response = $firstResponse;
        
        if ($response->has_more == true) {
            
            $i = 2;

            while ($response->has_more == true) {
                $newResult = $client->get('https://api.dailymotion.com/user/x1lvw98/children?fields=id,username,revenues_video_total,revenues_website_total,revenues_claim_total&page='.$i);
                $newResponse = json_decode($newResult->getBody());

                //array_push($partners, $newResponse->list);

                foreach ($newResponse->list as $account) {

                    DB::table('cms')->insert(
                        ['channel_id' => $account->id, 'channel_url' => $account->username, 'revenues_video_total' => $account->revenues_video_total, 'revenues_website_total' => $account->revenues_website_total, 'revenues_claim_total' => $account->revenues_claim_total, 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()]
                    );
        
                };
                
                $response = $newResponse;

                $i++;
            }
        }

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin()
    {
        $channels = DB::table('cms')->orderBy('id', 'asc')->paginate('25');
        $dmusers = DailymotionChannel::orderBy('id', 'asc')->paginate('25');
        
        return view('admin.cms.list')->with(['channels' => $channels, 'dmusers' => $dmusers]);
    }

    /**
     * Invite the user's dailymotion account to the CMS.
     *
     * @return \Illuminate\Http\Response
     */
    public function invite(Request $request, $id)
    {
        $dailymotionParent = DailymotionChannel::where('channel_id', 'x1lvw98')->first();
        $invitee = DailymotionChannel::where('id', $id)->first();

        $client = new Client([
            'headers' => ['User-Agent' => 'inviteChannel', 'Accept' => 'application/json', 'Content-Type' => 'application/x-www-form-urlencoded', 'Authorization' => 'OAuth '.$invitee->dailymotion_access]
        ]);
        $result = $client->post('https://api.dailymotion.com/me/parents/'.$dailymotionParent->channel_id);

        $response = json_decode($result->getBody());

        return redirect('/admin/cms')->with('success', 'Channel Invited');
    }

    /**
     * Removes the user's dailymotion account from the CMS.
     *
     * @return \Illuminate\Http\Response
     */
    public function remove(Request $request, $id)
    {
        $dailymotionParent = DailymotionChannel::where('channel_id', 'x1lvw98')->first();
        $removal = DailymotionChannel::where('id', $id)->first();

        $client = new Client([
            'headers' => ['User-Agent' => 'removeChannel', 'Accept' => 'application/json', 'Content-Type' => 'application/x-www-form-urlencoded', 'Authorization' => 'OAuth '.$dailymotionParent->dailymotion_access]
        ]);
        $result = $client->post('https://api.dailymotion.com/me/children/'.$removal->channel_id);

        $response = json_decode($result->getBody());

        return redirect('/admin/cms')->with('success', 'Channel Removed');
    }

}
