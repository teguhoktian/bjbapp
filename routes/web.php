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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('profile', 'HomeController@profile')->name('profile');
Route::get('edit/profile', 'HomeController@edit_profile')->name('profile.edit');
Route::patch('profile', 'HomeController@update_profile')->name('profile.update');

Route::group(['middleware' => ['auth']], function(){

	Route::get('users/data', 'UserController@anyData')->name('user.data');
	Route::resource('user', 'UserController');

	Route::get('permission/data', 'PermissionController@anyData')->name('permission.data');
	Route::resource('permission', 'PermissionController');
	
	Route::get('office/data', 'OfficeController@anyData')->name('office.data');
	Route::get('office/corporate', 'OfficeController@getOffice')->name('office.corporate');
	Route::resource('office', 'OfficeController');

	Route::get('corporate/data', 'CorporateController@anyData')->name('corporate.data');
	Route::resource('corporate', 'CorporateController');

	Route::get('role/data', 'RoleController@anyData')->name('role.data');
	Route::resource('role', 'RoleController');

	Route::get('post/data', 'PostController@anyData')->name('post.data');
	Route::resource('post', 'PostController');	

	Route::get('quarter/data', 'QuarterController@anyData')->name('quarter.data');
	Route::resource('quarter', 'QuarterController');	

	Route::get('goal/data', 'GoalController@anyData')->name('goal.data');
	Route::resource('goal', 'GoalController');

	Route::get('goalDetail/data', 'GoalDetailController@anyData')->name('goalDetail.data');
	Route::resource('goalDetail', 'GoalDetailController');

	Route::get('quarterGoal/data', 'QuarterGoalController@anyData')->name('quarterGoal.data');
	Route::get('quarterGoal/goal', 'QuarterGoalController@getGoal')->name('quarterGoal.goalDetail');
	Route::resource('quarterGoal', 'QuarterGoalController');

	Route::get('userGoal/goal', 'UserGoalController@getGoal')->name('userGoal.goal');
	Route::get('userGoal/data', 'UserGoalController@anyData')->name('userGoal.data');
	Route::resource('userGoal', 'UserGoalController');

	Route::get('settingGoalUser/show', 'AppGoalSettingsController@userSetting')->name('user4dxSetting');
	Route::post('settingGoalUser/save', 'AppGoalSettingsController@saveUserSetting')->name('user4dxSetting.save');

	Route::get('bookingKredit/getGoal', 'BookingKreditGoalController@getGoal')->name('bookingKredit.getGoal');
	Route::get('bookingKredit/getQuarter', 'BookingKreditGoalController@getQuarter')->name('bookingKredit.getQuarter');
	Route::get('bookingKredit/data', 'BookingKreditGoalController@anyData')->name('bookingKredit.data');
	Route::resource('bookingKredit', 'BookingKreditGoalController');

	Route::get('userDashboard', 'UserDashboardGoalController@index')->name('dashboard.user');

	Route::get('pukDashboard', 'PukDashboardGoalController@index')->name('dashboard.puk');
	
	Route::get('bookingKreditApp', 'AppGoalController@bookingKreditApproval')->name('approval.bookingKredit');
	Route::get('bookingKreditApp/data', 'AppGoalController@bookingKreditApprovalData')->name('approval.bookingKreditData');
	Route::put('bookingKreditAction/{id}', 'AppGoalController@bookingKreditApprovalAction')->name('approval.bookingKreditDataAction');

	Route::get('about', function() {
	    return view('about')->with([
                'menu' => 'about', 
                'submenu' => '',
                'page' => __('About')
            ]);
	})->name('about');

});

Route::get('setLocale/{locale}', function($locale){
	Session::put('locale', $locale);
	return redirect()->back();
});
