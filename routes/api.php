<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->get('/hrisdata', 'HrisInstructorController@HrisEmployees');
Route::middleware('auth:api')->get('/emp_record/{id}', 'HrisInstructorController@EmployeeRecord');
Route::get('/trainee_store/{id}', 'HrisInstructorController@StoreTrainee');
Route::middleware('auth:api')->get('/trainee_internal', 'HrisInstructorController@InternalList');
Route::middleware('auth:api')->get('/trainee_external', 'HrisInstructorController@ExternalList');
Route::apiResources(['user' => 'API\UserController']);
Route::apiResources(['mmain' => 'MainMenuController']);
Route::apiResources(['smenu' => 'SubMenuController']);
Route::apiResources(['urights' => 'API\UserRightsController']);
Route::apiResources(['uservals' => 'UserRightController']);
Route::apiResources(['updatelist' => 'API\UpdatedController']);
Route::apiResources(['coursetype' => 'API\CourseTypeController']);
Route::apiResources(['coursearea' => 'API\CourseAreaController']);
Route::apiResources(['addcourse' => 'API\AddCourseController']);
Route::apiResources(['library' => 'API\LibraryController']);
Route::apiResources(['slibrary' => 'API\SubCatController']);
Route::apiResources(['libtrans' => 'API\LibTransController']);
Route::apiResources(['category' => 'API\CategoryController']);
Route::apiResources(['instructor' => 'API\InstructorController']);
Route::apiResources(['cinstructor' => 'API\CourseInstructorController']);
Route::apiResources(['letter' => 'API\LetterController']);
Route::apiResources(['schedule' => 'API\ScheduleController']);
Route::apiResources(['trainees' => 'API\TraineesController']);
Route::apiResources(['display_data' => 'API\DisplayController']);
Route::apiResources(['definelib' => 'API\DefineLibController']);
Route::apiResources(['exam' => 'API\ExamController']);
Route::apiResources(['paper' => 'API\PaperController']);
Route::apiResources(['result' => 'API\ResultController']);
Route::apiResources(['submitresult' => 'API\SubmitResultController']);
Route::apiResources(['assignment' => 'API\AssignmentController']);
Route::apiResources(['presentation' => 'API\PresentationController']);
Route::apiResources(['indsch' => 'API\IndvidualSchController']);
Route::apiResources(['addlecture' => 'API\AddLectureController']);
Route::apiResources(['displaylib' => 'API\DisplayLibController']);
Route::apiResources(['feedback' => 'API\FeedBackController']);
Route::apiResources(['lecfeed' => 'API\LecFeedBkController']);
Route::apiResources(['feedsub' => 'API\FeedSubController']);
Route::apiResources(['lecreport' => 'API\LecReportController']);
Route::apiResources(['logdata' => 'API\RecordDataController']);
Route::apiResources(['previousdata' => 'API\PreTableController']);
Route::apiResources(['inttrainees' => 'API\InternalTraineeController']);
Route::apiResources(['extuserdata' => 'API\ExtUserDataController']);
Route::apiResources(['extpresdata' => 'API\ExtPresDataController']);
Route::apiResources(['answersht' => 'API\AnswerSheetController']);
Route::apiResources(['fdtxt' => 'API\feedbackTextController']);
Route::apiResources(['coursedetail' => 'API\getCourseDetailController']);
Route::apiResources(['userdetails' => 'API\getUserDetailsController']);


