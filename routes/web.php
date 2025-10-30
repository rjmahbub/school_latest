<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AcademyController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DesignController;
use App\Http\Controllers\GeneratePaperController;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\JsonController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ReferController;
use App\Http\Controllers\DeepRelationController;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Controllers\ExcelController;

// require __DIR__.'/auth.php';

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });


Route::get('/login', [ProfileController::class, 'LoginForm'])->name('login');
Route::post('/login', [ProfileController::class, 'Login']);
Route::get('/logout', [ProfileController::class, 'Logout'])->name('logout');
Route::get('/documentation',[PublicController::class,'documentation'])->name('documentation');
Route::get('/domain-search',[PublicController::class,'domainSearch'])->name('domainSearch');
Route::get('/subdomain-register',[PublicController::class,'DomainRegisterForm'])->name('DomainRegisterForm');
Route::post('/subdomain-register', [PublicController::class, 'DomainRegister'])->name('DomainRegister');
Route::get('/packages', [PublicController::class, 'package'])->name('package');
Route::get('/affiliate', [PublicController::class, 'AffiliateRegisterForm'])->name('AffiliateRegisterForm');
Route::post('/affiliate', [PublicController::class, 'AffiliateRegister'])->name('AffiliateRegister');
Route::get('/profile/forget-pwd',[ProfileController::class, 'forgetPasswordForm'])->name('forgetPasswordForm');
Route::post('/profile/forget-pwd',[ProfileController::class, 'forgetPassword'])->name('forgetPassword');
Route::get('/profile/reset-pwd',[ProfileController::class, 'resetPasswordForm'])->name('resetPasswordForm');
Route::post('/profile/reset-pwd',[ProfileController::class, 'resetPassword'])->name('resetPassword');
Route::post('/opinion',[PublicController::class, 'opinion'])->name('opinion');
Route::get('/check-domain', [PublicController::class, 'InactiveDomain'])->name('InactiveDomain');
Route::get('/online-admission', [PublicController::class, 'onlineAdmissionForm'])->name('onlineAdmissionForm');
Route::post('/online-admission', [PublicController::class, 'onlineAdmission'])->name('onlineAdmission');

//result
Route::get('/result/public-iframe',[ResultController::class, 'PublicResultIframe'])->name('PublicResultIframe');
Route::get('/result/show',[ResultController::class, 'ResultShowForm'])->name('ResultShowForm');
Route::post('/result/show',[ResultController::class, 'ResultShow'])->name('ResultShow');
//json
Route::get('/json/result-sheet',[JsonController::class,'ResultSheetJson'])->name('ResultSheetJson');
Route::get('/json/notice',[JsonController::class,'NoticesJson'])->name('NoticesJson');
//academy
Route::get('/academy/academic-calendar',[AcademyController::class,'AcademyCalendar'])->name('AcademyCalendar');
//Ajax url
Route::post('/check_subdomain',[AjaxController::class, 'subdomain'])->name('checkSubdomain');
Route::get('/group_load',[AjaxController::class, 'group']);
Route::get('/subject_load',[AjaxController::class, 'subject']);
Route::get('/session_load',[AjaxController::class, 'session']);
Route::post('/search-student-or-teacher',[AjaxController::class, 'searchTos'])->name('searchTos');
Route::post('/update-one-column',[AjaxController::class, 'oneColUpdate'])->name('oneColUpdate');
Route::post('/upload-student-photo',[PermissionController::class, 'UploadStudentPic'])->name('UploadStudentPic');

Route::get('/', [IndexController::class, 'index']);
Route::group(['middleware' => ['CheckDomainActive']],function(){
    
    Route::get('/ip', [IndexController::class, 'geoip']);
    Route::get('/register/step1', [ProfileController::class, 'reg_step1'])->name('register');
    Route::post('/register/step2', [ProfileController::class, 'reg_step2'])->name('reg2');
    Route::post('/register/final-step', [ProfileController::class, 'reg_save'])->name('regMsg');
    Route::get('/register', function(){ return redirect('/register/step1'); });
    Route::get('/register/step2', function(){ return redirect('/register/step1'); });
    Route::get('/register/final-step', function(){ return redirect('/register/step2'); });
    Route::get('/notice/view',[NoticeController::class, 'ViewNotice'])->name('ViewNotice');
    Route::get('/result/public',[ResultController::class, 'PublicResultForm'])->name('PublicResultForm');
});
Route::group(['middleware' => ['auth']],function(){
    Route::get('/affiliate-generation', [PublicController::class, 'AffiliateGeneration'])->name('AffiliateGeneration');
    Route::post('/change-photo',[PermissionController::class, 'ChangePhoto'])->name('ChangePhoto');
    Route::get('/salary-check-form',[AccountController::class, 'CheckSalaryForm'])->name('CheckSalaryForm');
    Route::post('/salary-check',[AccountController::class, 'CheckSalary'])->name('CheckSalary');

    Route::get('/request-CGSE',[PermissionController::class, 'RequestFormCGSE'])->name('RequestFormCGSE');
    Route::post('/request-CGSE',[PermissionController::class, 'RequestCGSE'])->name('RequestCGSE');
    Route::get('/dashboard', [IndexController::class, 'DashboardView'])->name('dashboard');
    Route::get('/include-dashboard', [IndexController::class, 'includeDashboard'])->name('includeDashboard');
    //json
    Route::get('/json/student',[JsonController::class,'StudentsJson'])->name('StudentsJson');
    Route::get('/json/teacher',[JsonController::class,'TeachersJson'])->name('TeachersJson');
    Route::get('/json/attendance',[JsonController::class,'MonthlyAttendanceJson'])->name('MonthlyAttendanceJson');
    Route::get('/json/statement',[JsonController::class,'StatementJson'])->name('StatementJson');
    Route::get('/json/cashout-history',[JsonController::class,'CashoutHistoryJson'])->name('CashoutHistoryJson');
    Route::get('/json/cgse',[JsonController::class,'cgseJson'])->name('cgseJson');
    Route::get('/json/admissions',[JsonController::class,'onlineAdmissionJson'])->name('onlineAdmissionJson');
    Route::get('/json/users',[JsonController::class,'UsersJson'])->name('UsersJson');
    
    /* Route::get('/json/institute-refer-activation',[JsonController::class,'RefersInstJson'])->name('RefersInstJson'); */
    //Route::get('/json/payment-history',[JsonController::class,'PaymentHistoryJson'])->name('PaymentHistoryJson');
    Route::get('/json/institute-list',[JsonController::class,'InstitutesJson'])->name('InstitutesJson')->middleware('Roles:SuperAdmin,AffiliateUser');
    //profile
    Route::get('/profile/view',[ProfileController::class, 'ShowProfile'])->name('profile');
    Route::get('/profile/update',[ProfileController::class, 'ProfileUpdateForm']);
    Route::post('/profile/update',[ProfileController::class, 'UpdateProfile'])->name('UpdateProfile');
    Route::view('/profile/change-pwd','profile.change_password')->name('ChangePwdForm');
    Route::post('/profile/change-pwd',[ProfileController::class, 'UserPasswordUpdate'])->name('UserPasswordUpdate');
    Route::get('/user/list',[ProfileController::class, 'userList'])->name('userList');
    Route::get('/cashout',[ProfileController::class, 'cashoutForm'])->name('cashoutForm');
    Route::post('/cashout',[ProfileController::class, 'cashout'])->name('cashout');
    Route::get('/statement',[ProfileController::class, 'statement'])->name('statement');
    Route::get('/payment', [PublicController::class, 'paymentPage'])->name('payment');
    //Route::get('/payment-history', [PublicController::class, 'PaymentHistory'])->name('PaymentHistory');
    //delete
    Route::post('/delete-by-ids',[AjaxController::class, 'DeleteByIds'])->name('DeleteByIds');
    Route::post('/update-by-id',[AjaxController::class, 'UpdateById'])->name('UpdateById');
    //account
    Route::post('/token-recharge',[AccountController::class, 'TokenRecharge'])->name('TokenRecharge');
    Route::get('/institute-renew',[SuperAdminController::class,'InstituteRenewForm'])->name('InstituteRenewForm')->middleware('Roles:SuperAdmin,InstituteAdmin');
    Route::post('/institute-renew',[SuperAdminController::class,'InstituteRenew'])->name('InstituteRenew')->middleware('Roles:SuperAdmin,InstituteAdmin');
    Route::get('/institute-list',[SuperAdminController::class,'InstituteList'])->name('InstituteList')->middleware('Roles:SuperAdmin,AffiliateUser');

    //bill
    Route::get('/bill',[AccountController::class, 'bill'])->name('bill')->middleware('Student');
    Route::get('/cashout-history',[ProfileController::class, 'cashoutHistory'])->name('cashoutHistory');

    Route::group(['middleware' => ['SuperAdmin']],function(){
        //account
        Route::get('/balance/send-money',[AccountController::class, 'SendMoneyForm'])->name('SendMoneyForm');
        Route::post('/balance/send-money',[AccountController::class, 'SendMoney'])->name('SendMoney');
        //package
        Route::get('/package-list', [IndexController::class, 'packageList'])->name('packageList');
        Route::get('/html-pages', [IndexController::class, 'htmlPages'])->name('htmlPages');
        Route::get('/package-edit', [IndexController::class, 'editPackage'])->name('editPackage');
        Route::post('/package-edit', [IndexController::class, 'PackageEditionSave'])->name('PackageEditionSave');
        Route::get('/payment/add-info', [PublicController::class, 'AddPaymentInfoForm'])->name('AddPaymentInfoForm');
        Route::post('/payment/add-info', [PublicController::class, 'sendPayment'])->name('sendPayment');
        Route::get('/payment/list', [PublicController::class, 'PaymentList'])->name('PaymentList');
        Route::post('/institute/active-inactive',[SuperAdminController::class,'InstActiveOrInactive'])->name('InstActiveOrInactive');
        /* Route::get('/institute-refer-activation',[SuperAdminController::class,'InstReferActiveForm'])->name('InstReferActiveForm');
        Route::post('/institute-refer-activation',[SuperAdminController::class,'InstReferActive'])->name('InstReferActive'); */
        Route::get('/institute/renew',[SuperAdminController::class,'RenewInstSuperAdminForm'])->name('RenewInstSuperAdminForm');
        Route::post('/institute/renew',[SuperAdminController::class,'RenewInstSuperAdmin'])->name('RenewInstSuperAdmin');
        Route::get('/cashin-super-admin',[ProfileController::class, 'cashInFormSuperAdmin'])->name('cashInFormSuperAdmin');
        Route::post('/cashin-super-admin',[ProfileController::class, 'cashInSuperAdmin'])->name('cashInSuperAdmin');
        Route::post('/cashout/paid-unpaid',[AccountController::class, 'PaidStatusChange'])->name('PaidStatusChange');
        Route::post('/payment/approve',[AccountController::class, 'PaymentApprove'])->name('PaymentApprove');
        Route::get('/delete/institute',[SuperAdminController::class,'DeleteInstitutePrepareForm'])->name('DeleteInstitutePrepareForm');
        Route::post('/delete/institute',[SuperAdminController::class,'DeleteInstitute'])->name('DeleteInstitute');
        Route::get('/cgse-list',[SuperAdminController::class, 'cgseList'])->name('cgseList');
        Route::post('/approve-cgse',[SuperAdminController::class, 'approveCGSE'])->name('approveCGSE');
        Route::get('/json/payment-list',[JsonController::class,'paymentJson'])->name('paymentJson');
        Route::post('/ajax/send-sms',[AjaxController::class, 'ajaxSmsSend'])->name('ajaxSmsSend');
    });
    Route::group(['middleware' => ['iAdminAndTcrByPermission']],function(){
        //teacher
        Route::get('/teacher/add',[TeacherController::class,'AddTeacherForm'])->name('AddTeacherForm')->middleware('Permission:1');
        Route::post('/teacher/add',[TeacherController::class,'SaveTeacher'])->name('SaveTeacher')->middleware('Permission:1');
        Route::get('/teachers',[TeacherController::class,'teachers'])->name('teachers')->middleware('Permission:1');
        Route::post('/teacher/update',[TeacherController::class,'UpdateTeacher'])->name('UpdateTeacher')->middleware('Permission:1');
        //student 
        Route::get('/student/add',[StudentController::class,'NewStudentForm'])->name('NewStudentForm')->middleware('Permission:2');
        Route::post('/student/add',[StudentController::class,'SaveStudent'])->name('SaveStudent')->middleware('Permission:2');
        Route::get('/class-list',[StudentController::class,'ClassList'])->name('ClassList')->middleware('Permission:2');
        Route::get('/students',[StudentController::class,'students'])->name('students')->middleware('Permission:2');
        Route::post('/student/update',[StudentController::class,'UpdateStudent'])->name('UpdateStudent')->middleware('Permission:2');
        //users & permission
        Route::get('/users',[PermissionController::class, 'users'])->name('users');
        Route::get('/user-permission',[PermissionController::class, 'UserPermission'])->name('UserPermission');
        Route::post('/users',[PermissionController::class, 'SaveUserPermission'])->name('SaveUserPermission');
        //result
        Route::get('/result/publish/step1',[ResultController::class, 'result_step1'])->name('rp')->middleware('Permission:7');
        Route::get('/result/publish/step2',[ResultController::class, 'result_step2'])->name('rp_step2')->middleware('Permission:7');
        Route::post('/result/publish/final',[ResultController::class, 'save_result'])->name('rp_final')->middleware('Permission:7');
        Route::get('/result/published',[ResultController::class, 'PublishedResult'])->name('PublishedResult')->middleware('Permission:7');
        Route::post('/result/update',[ResultController::class, 'ResultUpdate'])->name('ResultUpdate')->middleware('Permission:7');
        Route::post('/result/delete',[ResultController::class, 'DeleteResults'])->name('DeleteResults')->middleware('Permission:7');
        Route::get('/merit-prepare-form',[ResultController::class, 'MeritPrepareForm'])->name('MeritPrepareForm');
        Route::get('/merit-position',[ResultController::class, 'MeritPositionReview'])->name('MeritPositionReview');
        Route::post('/merit-position',[ResultController::class, 'MeritPosition'])->name('MeritPosition');
        //attendance
        Route::get('/attendance/student',[AttendanceController::class, 'AttendanceStudentForm'])->name('AttendanceStudentForm')->middleware('Permission:6');
        Route::post('/attendance/student',[AttendanceController::class, 'AttendanceStudent'])->name('AttendanceStudent')->middleware('Permission:6');
        Route::get('/attendance/teacher',[AttendanceController::class, 'AttendanceTeacherForm'])->name('AttendanceTeacherForm')->middleware('Permission:6');
        Route::post('/attendance/teacher',[AttendanceController::class, 'AttendanceTeacher'])->name('AttendanceTeacher')->middleware('Permission:6');
        Route::post('/attendance/student-holiday',[AttendanceController::class, 'MakeAttendanceHoliday'])->name('MakeAttendanceHoliday')->middleware('Permission:6');
        Route::post('/attendance/teacher-holiday',[AttendanceController::class, 'MakeTeacherHoliday'])->name('MakeTeacherHoliday')->middleware('Permission:6');
        Route::get('/attendance/update',[AttendanceController::class, 'UpdateAttendanceForm'])->name('UpdateAttendanceForm')->middleware('Permission:6');
        Route::get('/attendance/monthly',[AttendanceController::class, 'MonthlyAttendance'])->name('MonthlyAttendance')->middleware('Permission:6');
        Route::post('/attendance',[AttendanceController::class, 'getAttendance'])->name('getAttendance')->middleware('Permission:6');
        Route::get('/attendance/calendar-view',[AttendanceController::class, 'CalendarViewAttendance'])->name('CalendarViewAttendance')->middleware('Permission:6');
        Route::post('/get-attendance',[AttendanceController::class, 'getAttendance'])->name('getAttendance')->middleware('Permission:6');
        Route::get('/attendance/input',[AttendanceController::class, 'AttendanceInputForm'])->name('AttendanceInputForm')->middleware('Permission:6');
        Route::post('/attendance/input',[AttendanceController::class, 'AttendanceInput'])->name('AttendanceInput')->middleware('Permission:6');
        
        //generate paper
        Route::get('/generate/id-card',[GeneratePaperController::class, 'IdCard'])->name('IdCard');
        Route::post('/generate/admin-card',[GeneratePaperController::class, 'AdmitCard'])->name('AdmitCard');
        Route::get('/generate/add-question',[GeneratePaperController::class, 'AddMcqForm'])->name('AddMcqForm');
        Route::post('/generate/add-question',[GeneratePaperController::class, 'AddMcq'])->name('AddMcq');
        Route::get('/generate/mcq',[GeneratePaperController::class, 'mcqGenForm'])->name('mcqGenForm')->middleware('Permission:5');
        Route::post('/generate/mcq-question',[GeneratePaperController::class, 'mcqGen'])->name('mcqGen')->middleware('Permission:5');
        //notice
        Route::get('/notice/publish',[NoticeController::class, 'AddNoticeForm'])->name('AddNoticeForm')->middleware('Permission:8');
        Route::post('/notice/publish',[NoticeController::class, 'AddNotice'])->name('AddNotice')->middleware('Permission:8');
        Route::get('/notice/all',[NoticeController::class, 'AllNoticeView'])->name('AllNoticeView')->middleware('Permission:8');
        Route::post('/notice/exam-headline/on-off',[NoticeController::class, 'ExamHeadlineNoticeOnOff'])->name('ExamHeadlineNoticeOnOff')->middleware('Permission:8');
        Route::get('/notice/delete-file',[NoticeController::class, 'DeleteNoticeFile'])->name('DeleteNoticeFile')->middleware('Permission:8');
        //account
        Route::get('/balance-sheet',[AccountController::class, 'balanceSheet'])->name('balanceSheet')->middleware('Permission:3');
        Route::post('/balance-sheet-entry',[AccountController::class, 'balanceSheetEntry'])->name('balanceSheetEntry')->middleware('Permission:3');
        Route::post('/balance-sheet-edit',[AccountController::class, 'balanceSheetEdit'])->name('balanceSheetEdit')->middleware('Permission:3');
        
        
        Route::get('/salary-pay-form',[AccountController::class, 'PaySalaryForm'])->name('PaySalaryForm')->middleware('Permission:4');
        Route::get('/salary-pay-review',[AccountController::class, 'PaySalaryReview'])->name('PaySalaryReview')->middleware('Permission:4');
        Route::post('/salary-pay-form',[AccountController::class, 'PaySalary'])->name('PaySalary')->middleware('Permission:4');
        Route::get('/salary-pay-invoice',[AccountController::class, 'PaySalaryInvoice'])->name('PaySalaryInvoice')->middleware('Permission:4');
        Route::get('/make-bill',[AccountController::class, 'makeBillForm'])->name('makeBillForm')->middleware('Permission:4');
        Route::post('/make-bill',[AccountController::class, 'makeBill'])->name('makeBill')->middleware('Permission:4');
        Route::get('/bill-report',[AccountController::class, 'billReport'])->name('billReport')->middleware('Permission:4');
        
        Route::get('/online-admitted-list', [PublicController::class, 'onlineAdmittedList'])->name('onlineAdmittedList');
        Route::post('/admission-approve', [PublicController::class, 'AdmissionApprove'])->name('AdmissionApprove');
    });
    Route::group(['middleware' => ['InstituteAdmin']],function(){
        Route::get('/design/slideshow',[DesignController::class, 'SlideshowForm'])->name('SlideshowForm')->middleware('Permission:9');
        Route::post('/design/add-slideshow-item',[DesignController::class, 'AddSlideItem'])->name('AddSlideItem')->middleware('Permission:9');
        Route::post('/design/update-slideshow-items',[DesignController::class, 'UpdateSlideItem'])->name('UpdateSlideItem')->middleware('Permission:9');
        Route::post('/design/delete-slideshow-item',[DesignController::class, 'DeleteSlideItem'])->name('DeleteSlideItem')->middleware('Permission:9');
        Route::get('/design/change-info',[DesignController::class, 'ChangeInfoForm'])->name('ChangeInfoForm')->middleware('Permission:9');
        Route::post('/design/change-webheader',[DesignController::class, 'WebHeader'])->name('WebHeader')->middleware('Permission:9');
        Route::post('/design/change-info',[DesignController::class, 'ChangeInfo'])->name('ChangeInfo')->middleware('Permission:9');
        Route::get('/design/photo-gallery',[DesignController::class, 'PhotoGalleryView'])->name('PhotoGalleryView')->middleware('Permission:9');
        Route::post('/design/photo-gallery',[DesignController::class, 'PhotoGallery'])->name('PhotoGallery')->middleware('Permission:9');
        Route::post('/design/photo-delete',[DesignController::class, 'DeleteGalleryPhoto'])->name('DeleteGalleryPhoto')->middleware('Permission:9');
        Route::get('/design/video-gallery',[DesignController::class, 'VideoGalleryView'])->name('VideoGalleryView')->middleware('Permission:9');
        Route::post('/design/video-gallery',[DesignController::class, 'VideoGallery'])->name('VideoGallery')->middleware('Permission:9');
        Route::post('/design/video-delete',[DesignController::class, 'DeleteGalleryVideo'])->name('DeleteGalleryVideo')->middleware('Permission:9');

        //settings
        Route::get('/setting/others',[PermissionController::class, 'SettingOthers'])->name('SettingOthers');
        Route::get('/setting/class',[PermissionController::class, 'SettingClass'])->name('SettingClass');
        Route::post('/setting/add-class',[PermissionController::class, 'InstAddClass'])->name('InstAddClass');
        Route::get('/setting/group',[PermissionController::class, 'SettingGroup'])->name('SettingGroup');
        Route::post('/class/groupAdd',[PermissionController::class, 'InstAddGroup'])->name('InstAddGroup');
        Route::get('/setting/subject',[PermissionController::class, 'SettingSubject'])->name('SettingSubject');
        Route::post('/class/add-subject',[PermissionController::class, 'InstAddSubject'])->name('InstAddSubject');
        Route::get('/setting/exam',[PermissionController::class, 'SettingExam'])->name('SettingExam');
        Route::post('/class/add-exam',[PermissionController::class, 'InstAddExam'])->name('InstAddExam');
        Route::post('/upload-signature',[PermissionController::class, 'UploadSignature'])->name('UploadSignature');
        Route::post('/current-session',[PermissionController::class, 'currentSession'])->name('currentSession');
    });
    Route::get('/result/my-recent-result',[ResultController::class, 'myRecentResult'])->name('myRecentResult')->middleware('Roles:Student,Guardian');
});

Route::get('qr-code-with-image', function () {
    $image = QrCode::format('png')->merge('http://w3adda.com/wp-content/uploads/2019/07/laravel.png', 0.3, true)
                   ->size(200)->errorCorrection('H')
                   ->generate('W3Adda Laravel Tutorial');
   return response($image)->header('Content-type','image/png');
});

Route::get('color-qr-code', function () {
    return QrCode::size(200)->generate('W3Adda Laravel Tutorial');
});

Route::get('/phpinfo', function () { return phpinfo(); });

Route::get('/deep-relation',[DeepRelationController::class, 'deepRelated'])->name('deepRelated');
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});

//excel
Route::get('/upload', [ExcelController::class, 'showForm']);
Route::post('/upload', [ExcelController::class, 'upload'])->name('excel.upload');







Route::view('/loading','loading_animation');


