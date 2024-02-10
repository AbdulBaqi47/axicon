<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    
    if ($user = Auth::user()) {
        return redirect('/home');
    } 
    else {
        return view('auth.login');
    }
    
})->middleware('verified');

Auth::routes([
    'verify' => true,
]);

Route::post('braintree/webhooks', '\Laravel\Cashier\Http\Controllers\WebhookController@handleWebhook');

Route::get('/braintree/token', 'SubscriptionController@token')->name('token');
Route::get('/subscriptions', 'SubscriptionController@index')->name('user.subscriptions')->middleware('verified');
Route::post('/subscriptions/create', 'SubscriptionController@create')->name('user.subscriptions.create')->middleware('verified');
Route::post('/subscriptions/cancel', 'SubscriptionController@cancel')->middleware('verified');
Route::post('/subscriptions/resume', 'SubscriptionController@resume')->middleware('verified');

Route::get('/brand/influencers', 'UserController@brandView')->name('brand.influencers');

Route::group(['middleware' => 'auth'], function () {
    
    Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');

    Route::get('/settings', 'SettingController@index')->name('user.settings')->middleware('verified');
    Route::get('/avatar/reset', 'SettingController@avatarReset')->name('avatar.reset')->middleware('verified');
    Route::put('/settings/updateSocials', 'SettingController@updateSocials')->name('settings.socials')->middleware('verified');
    Route::resource('Setting', 'SettingController');

    Route::get('/support', 'TicketController@index')->name('support.support')->middleware('verified');
    Route::get('/support/create', 'TicketController@create')->name('admin.support.create')->middleware('verified');
    Route::get('/support/{id}', 'TicketController@show')->name('support.show')->middleware('verified');
    Route::resource('Ticket', 'TicketController');
    Route::resource('Comment', 'CommentController');

    
    Route::group(['middleware' => 'subscribed'], function () {

        Route::get('/apps', 'AppController@index')->name('apps.apps')->middleware('verified');
        Route::resource('App', 'AppController');

        Route::get('/sponsorships', 'SponsorshipController@index')->name('sponsorships.sponsorships')->middleware('verified');
        Route::resource('Sponsorship', 'SponsorshipController');

        Route::get('/education', 'EducationController@index')->name('education.education')->middleware('verified');
        Route::get('/education/{slug}', 'EducationController@show')->name('education.show')->middleware('verified');
        Route::resource('Education', 'EducationController');

        Route::get('/requests', 'ChannelRequestController@index')->name('requests.requests')->middleware('verified');
        Route::get('/requests/{id}', 'ChannelRequestController@show')->name('requests.show')->middleware('verified');
        Route::get('/admin/requests/create', 'ChannelRequestController@create')->name('admin.requests.create')->middleware('verified');
        Route::resource('ChannelRequest', 'ChannelRequestController');

        Route::get('/gear', 'GearController@index')->name('gear.gear')->middleware('verified');
        Route::get('/gear/{slug}', 'GearController@show')->name('gear.show')->middleware('verified');
        Route::resource('GearItem', 'GearController');
        Route::resource('GearItem', 'ItemController');
        Route::resource('GearCategory', 'GearController');

        Route::get('/videos', 'FeaturedVideoController@index')->name('videos.videos')->middleware('verified');
        Route::resource('FeaturedVideo', 'FeaturedVideoController');

        Route::get('/downloads', 'DownloadController@index')->name('downloads.downloads')->middleware('verified');
        Route::get('/downloads/{link}', 'DownloadController@download')->middleware('verified');
        Route::resource('Download', 'DownloadController');

    });

    Route::group(['middleware' => ['role:admin|partner-manager|support']], function () {

        Route::get('/apps', 'AppController@index')->name('apps.apps')->middleware('verified');
        Route::resource('App', 'AppController');

        Route::get('/sponsorships', 'SponsorshipController@index')->name('sponsorships.sponsorships')->middleware('verified');
        Route::resource('Sponsorship', 'SponsorshipController');

        Route::get('/education', 'EducationController@index')->name('education.education')->middleware('verified');
        Route::get('/education/{slug}', 'EducationController@show')->name('education.show')->middleware('verified');
        Route::resource('Education', 'EducationController');

        Route::get('/requests', 'ChannelRequestController@index')->name('requests.requests')->middleware('verified');
        Route::get('/requests/{id}', 'ChannelRequestController@show')->name('requests.show')->middleware('verified');
        Route::get('/admin/requests/create', 'ChannelRequestController@create')->name('admin.requests.create')->middleware('verified');
        Route::resource('ChannelRequest', 'ChannelRequestController');

        Route::get('/gear', 'GearController@index')->name('gear.gear')->middleware('verified');
        Route::get('/gear/{slug}', 'GearController@show')->name('gear.show')->middleware('verified');
        Route::resource('GearItem', 'GearController');
        Route::resource('GearItem', 'ItemController');
        Route::resource('GearCategory', 'GearController');

        Route::get('/videos', 'FeaturedVideoController@index')->name('videos.videos')->middleware('verified');
        Route::resource('FeaturedVideo', 'FeaturedVideoController');

        Route::get('/downloads', 'DownloadController@index')->name('downloads.downloads')->middleware('verified');
        Route::get('/downloads/{link}', 'DownloadController@download')->middleware('verified');
        Route::resource('Download', 'DownloadController');

    });

    Route::group(['middleware' => ['role:admin|partner-manager|support']], function () {

        Route::get('/admin/support', 'TicketController@admin')->name('admin.support.list')->middleware('verified');
        Route::get('/admin/support/edit/{id}', 'TicketController@edit')->name('admin.support.edit')->middleware('verified');
        Route::get('/admin/support/delete/{id}', 'TicketController@destroy')->middleware('verified');

        Route::get('/admin/tasks', 'TaskController@admin')->name('admin.tasks.list')->middleware('verified');
        Route::get('/admin/tasks/create', 'TaskController@create')->name('admin.tasks.create')->middleware('verified');
        Route::get('/admin/tasks/{id}', 'TaskController@show')->name('admin.tasks.show')->middleware('verified');
        Route::get('/admin/tasks/edit/{id}', 'TaskController@edit')->name('admin.tasks.edit')->middleware('verified');
        Route::delete('/admin/tasks/delete/{id}', 'TaskController@destroy')->middleware('verified');
        Route::get('/admin/tasks/{id}/complete', 'TaskController@toggleComplete')->middleware('verified');
        Route::resource('Task', 'TaskController');

    });

    Route::group(['middleware' => ['role:admin|partner-manager']], function () {

        Route::get('/admin/apps', 'AppController@admin')->name('admin.apps.list')->middleware('verified');
        Route::get('/admin/apps/create', 'AppController@create')->name('admin.apps.create')->middleware('verified');
        Route::get('/admin/apps/edit/{id}', 'AppController@edit')->name('admin.apps.edit')->middleware('verified');
        Route::get('/admin/apps/delete/{id}', 'AppController@destroy')->middleware('verified');

        Route::get('/admin/sponsorships', 'SponsorshipController@admin')->name('admin.sponsorships.list')->middleware('verified');
        Route::get('/admin/sponsorships/create', 'SponsorshipController@create')->name('admin.sponsorships.create')->middleware('verified');
        Route::get('/admin/sponsorships/edit/{id}', 'SponsorshipController@edit')->name('admin.sponsorships.edit')->middleware('verified');
        Route::get('/admin/sponsorships/delete/{id}', 'SponsorshipController@destroy')->middleware('verified');

        Route::get('/admin/education', 'EducationController@admin')->name('admin.education.list')->middleware('verified');
        Route::get('/admin/education/create', 'EducationController@create')->name('admin.education.create')->middleware('verified');
        Route::get('/admin/education/edit/{id}', 'EducationController@edit')->name('admin.education.edit')->middleware('verified');
        Route::get('/admin/education/delete/{id}', 'EducationController@destroy')->middleware('verified');

        Route::get('/admin/requests', 'ChannelRequestController@admin')->name('admin.requests.list')->middleware('verified');
        Route::get('/admin/requests/create', 'ChannelRequestController@create')->name('admin.requests.create')->middleware('verified');
        Route::get('/admin/requests/edit/{id}', 'ChannelRequestController@edit')->name('admin.requests.edit')->middleware('verified');
        Route::get('/admin/requests/delete/{id}', 'ChannelRequestController@destroy')->middleware('verified');

        Route::get('/admin/gear', 'GearController@admin')->name('admin.gear.list')->middleware('verified');
        Route::get('/admin/gear/create', 'GearController@create')->name('admin.gear.create')->middleware('verified');
        Route::get('/admin/gear/edit/{id}', 'GearController@edit')->name('admin.gear.edit')->middleware('verified');
        Route::get('/admin/gear/delete/{id}', 'GearController@destroy')->middleware('verified');
        Route::get('/admin/gear/{slug}', 'GearController@adminItem')->name('admin.gear.items.list')->middleware('verified');
        Route::get('/admin/gear/{slug}/create', 'GearController@createItem')->name('admin.gear.items.create')->middleware('verified');
        Route::get('/admin/gear/{slug}/edit/{id}', 'GearController@editItem')->name('admin.gear.items.edit')->middleware('verified');
        Route::delete('/admin/gear/{slug}/delete/{id}', 'GearController@destroyItem')->middleware('verified');

        Route::get('/admin/videos', 'FeaturedVideoController@admin')->name('admin.videos.list')->middleware('verified');
        Route::get('/admin/videos/create', 'FeaturedVideoController@create')->name('admin.videos.create')->middleware('verified');
        Route::get('/admin/videos/edit/{id}', 'FeaturedVideoController@edit')->name('admin.videos.edit')->middleware('verified');
        Route::delete('/admin/videos/delete/{id}', 'FeaturedVideoController@destroy')->middleware('verified');
        Route::resource('FeaturedVideo', 'FeaturedVideoController');

        Route::get('/admin/brands', 'BrandController@admin')->name('admin.brands.list')->middleware('verified');
        Route::get('/admin/brands/create', 'BrandController@create')->name('admin.brands.create')->middleware('verified');
        Route::get('/admin/brands/{id}', 'BrandController@show')->name('admin.brands.show')->middleware('verified');
        Route::get('/admin/brands/edit/{id}', 'BrandController@edit')->name('admin.brands.edit')->middleware('verified');
        Route::get('/admin/brands/delete/{id}', 'BrandController@destroy')->middleware('verified');
        Route::resource('Brand', 'BrandController');

        Route::get('/admin/brands/{id}/create', 'BrandDealController@create')->name('admin.brands.deals.create')->middleware('verified');
        Route::get('/admin/brands/{brand_id}/edit/{id}', 'BrandDealController@edit')->name('admin.brands.deals.edit')->middleware('verified');
        Route::delete('/admin/brands/{brand_id}/delete/{id}', 'BrandDealController@destroy')->middleware('verified');
        Route::get('/admin/brands/{brand_id}/{id}/submissions', 'BrandDealController@viewSubmissions')->name('admin.brands.deals.submissions')->middleware('verified');
        Route::put('/admin/brands/updateSubmissions/{id}', 'BrandDealController@updateSubmissions');
        
        Route::resource('BrandDeal', 'BrandDealController');

        Route::get('/admin/downloads', 'DownloadController@admin')->name('admin.downloads.list')->middleware('verified');
        Route::get('/admin/downloads/create', 'DownloadController@create')->name('admin.downloads.create')->middleware('verified');
        Route::get('/admin/downloads/edit/{id}', 'DownloadController@edit')->name('admin.downloads.edit')->middleware('verified');
        Route::get('/admin/downloads/delete/{id}', 'DownloadController@destroy')->middleware('verified');

        Route::get('/admin/cms', 'CMSController@admin')->name('admin.cms.list')->middleware('verified');
        Route::get('/admin/cms/invite/{id}', 'CMSController@invite')->middleware('verified');
        Route::get('/admin/cms/remove/{id}', 'CMSController@remove')->middleware('verified');

        Route::get('/home/edit/', 'HomeController@edit')->name('edit')->middleware('verified');
        Route::resource('Home', 'HomeController');
        
    });

    Route::group(['middleware' => ['role:admin']], function () {

        Route::get('/admin/users', 'UserController@admin')->name('admin.users.list')->middleware('verified');
        Route::get('/admin/users/edit/{id}', 'UserController@edit')->name('admin.users.edit')->middleware('verified');
        Route::get('/admin/users/edit/{id}/avatar/reset', 'UserController@avatarReset')->name('admin.users.avatar.reset')->middleware('verified');
        Route::put('/admin/users/edit/{id}/updateSocials', 'UserController@updateSocials')->name('admin.users.edit.socials')->middleware('verified');
        Route::get('/admin/users/delete/{id}', 'UserController@destroy')->middleware('verified');
        Route::get('/admin/users/{id}', 'UserController@show')->name('admin.users.show')->middleware('verified');
        Route::resource('User', 'UserController');

    });

    Route::group(['middleware' => ['role:brand']], function () {

        Route::get('/brand/deals', 'BrandDealController@brandIndex')->name('brand.deals.list')->middleware('verified');
        Route::get('/brand/deals/{id}', 'BrandDealController@brandShow')->name('brand.deals.show')->middleware('verified');
        Route::get('/brand/deals/{id}/approve', 'BrandDealController@approve')->middleware('verified');
        Route::resource('BrandDeal', 'BrandDealController');

    });

});

Route::get('/link/youtube', 'SocialAuthController@redirectToYoutube')->middleware('verified');
Route::get('/link/youtube/callback', 'SocialAuthController@handleYoutubeCallback');
Route::delete('/link/youtube/{id}/remove', 'SocialAuthController@handleYoutubeRemoval')->middleware('verified');

Route::get('/link/dailymotion', 'SocialAuthController@redirectToDailymotion')->middleware('verified');
Route::get('/link/dailymotion/callback', 'SocialAuthController@handleDailymotionCallback');
Route::delete('/link/dailymotion/{id}/remove', 'SocialAuthController@handleDailymotionRemoval')->middleware('verified');
//Route::get('/getChannels', 'CMSController@getChannelsInNetwork');