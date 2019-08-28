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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('dashboard');
// Routes for Assets
Route::resource('/inventory/assets', 'AssetController');
Route::post('/inventory/assets/create', 'AssetController@store');
Route::any('/assets/manage/&id={id}', 'AssetController@manageAsset');
Route::post('/addAsset', 'AssetController@addAsset');
Route::post('/update-asset', 'AssetController@updateAsset');
Route::post('/change-status', 'AssetController@changeStatus');
Route::post('/inventory/assets', 'AssetController@getSearchedAssets');
Route::any('/inventory/assets/export', 'AssetController@exportSearchedAssetss');
Route::resource('/inventory/attributes/asset-categories', 'CategoryController');
Route::any('/reports/import', 'AssetController@importExcel');

// Routes for Issues
Route::resource('/issues/categories', 'IssueController');

Route::get('/issues/categories/sub-categories/{id}', 'IssueController@sub_categories')->name('issues.categories.sub_categories');
Route::any('/issues/categories/storeIssueSub/{issuecategory}', 'IssueController@storeIssueSub');
Route::any('/issues/sub-categories/update/{issuesubcategory}', 'IssueController@updateIssueSub');
Route::any('delete-issue-category/{issue}', 'IssueController@deleteIssueCategory');
Route::any('delete-issue-subcategory/{issue}', 'IssueController@deleteIssueSubcategory');
Route::get('/get-issue-subcategories', 'TicketController@getIssueSubcategories');
Route::any('/issues/manage/&id={id}', 'IssueController@manageIssues');

// Routes for Tickets
Route::resource('/tickets/all', 'TicketController');
Route::any('/tickets/closed', 'TicketController@closedTickets');
Route::any('/tickets/open', 'TicketController@openTickets');
Route::any('/tickets/in-progress', 'TicketController@ticketsInProgress');
Route::any('/tickets/assigned-to-me', 'TicketController@myAssignedTickets');
Route::any('/tickets/escalated', 'TicketController@escalatedTickets');
Route::any('/tickets/manage/&id={id}', 'TicketController@manageTickets');
Route::any('/ticket/assign', 'TicketController@assignTicket');
Route::any('/ticket/worn-on-ticket', 'TicketController@workOnTicket');
Route::any('/ticket/close', 'TicketController@closeTicket');
Route::any('/ticket/reopen', 'TicketController@reopenTicket');
Route::any('/ticket/escalate', 'TicketController@escalateTicket');
Route::post('/ticket/reply', 'TicketController@replyTicket');
Route::any('/ticket/delete/{ticket}', 'TicketController@deleteTicket');

// Routes for Users and Roles
Route::resource('/users/users', 'UserController');
Route::any('update-profile/{user}', 'UserController@updateUserProfile');
Route::any('profile', 'UserController@getUserProfile');

Route::any('/users/staff', 'UserController@staff');
Route::resource('/roles', 'RoleController');


Route::resource('/reports', 'ReportController');
Route::any('/reports/view', 'ReportController@displayReports');
Route::any('/report/excel/generate', 'ReportController@ExportReports');
Route::any('/report/tickets/assigment', 'ReportController@ticketAssignmentReport');

// Routes for System/Settings
Route::resource('/system/settings', 'SystemController');
Route::any('/system/logs', 'SystemController@getLogs');
Route::any('/system/import', 'SystemController@getImport');
// Route::any('/reports/import', 'ReportController@importExcel');