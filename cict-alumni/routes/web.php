<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Artisan;

// --------------------
// Controllers
// --------------------
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Admin\AdminSurveyController;
use App\Http\Controllers\Admin\AlumniController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\JobController as AdminJobController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminRewardController;
use App\Http\Controllers\Admin\AdminRaffleController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\FeaturedAlumniController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\AlumniAuthController;
use App\Http\Controllers\AlumniHomeController;
use App\Http\Controllers\DirectoryController;
use App\Http\Controllers\EventController as PublicEventController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\OtpVerificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\JobPostingRequestController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use App\Http\Controllers\Admin\AlumniMasterlistController;

// Landing page
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Public guest routes
Route::get('/public-events', [LandingController::class, 'events'])->name('public.events');
Route::get('/events/{eventID}', [LandingController::class, 'showEvent'])->name('public.events.show');
Route::get('/announcements', [LandingController::class, 'announcements'])->name('public.announcements');
Route::get('/careers', [LandingController::class, 'careers'])->name('public.careers');
Route::get('/about-us', [LandingController::class, 'about'])->name('public.about');
Route::get('/gallery', [LandingController::class, 'gallery'])->name('gallery');
Route::get('/featured-alumni', [LandingController::class, 'featuredAlumni'])->name('featured-alumni');

Route::get('/job-posting-request', [JobPostingRequestController::class, 'create'])->name('job-posting-request.create');
Route::post('/job-posting-request', [JobPostingRequestController::class, 'store'])->name('job-posting-request.store');
// --------------------
// Alumni Authentication
// --------------------
Route::get('/alumni/register', [AlumniAuthController::class, 'showRegistrationForm'])->name('alumni.register');
Route::post('/alumni/register', [AlumniAuthController::class, 'register'])->name('alumni.register.submit');
Route::get('/alumni/login', [AlumniAuthController::class, 'showLoginForm'])->name('alumni.login');
Route::post('/alumni/login', [AlumniAuthController::class, 'login'])->name('alumni.login.submit');
Route::post('/alumni/logout', [AlumniAuthController::class, 'logout'])->name('alumni.logout');
// Masterlist Verification (for registration)
Route::post('/alumni/verify-masterlist', [AlumniAuthController::class, 'verifyMasterlist'])->name('verify.masterlist');


// --------------------
// OTP Verification
// --------------------
Route::get('/otp/verify', [OtpVerificationController::class, 'showOtpForm'])->name('otp.verify.form');
Route::post('/otp/verify', [OtpVerificationController::class, 'verifyOtp'])->name('otp.verify');
Route::post('/otp/resend', [OtpVerificationController::class, 'resendOtp'])->name('otp.resend');
Route::post('/otp/change-email', [OtpVerificationController::class, 'changeEmail'])->name('otp.changeEmail');

// --------------------
// Forgot / Reset Password
// --------------------
Route::get('alumni/forgot-password', [AlumniAuthController::class, 'showForgotPasswordForm'])->name('alumni.forgot-password.form');
Route::post('alumni/forgot-password', [AlumniAuthController::class, 'sendPasswordResetOtp'])->name('alumni.forgot-password.submit');
Route::get('alumni/reset-password-otp', [AlumniAuthController::class, 'showResetPasswordOtpForm'])->name('alumni.reset-password-otp.form');
Route::post('alumni/reset-password-otp', [AlumniAuthController::class, 'verifyResetPasswordOtp'])->name('alumni.reset-password-otp.submit');
Route::post('alumni/reset-password', [AlumniAuthController::class, 'changePassword'])->name('alumni.change-password');
Route::get('alumni/change-password', [AlumniAuthController::class, 'showChangePasswordForm'])->name('alumni.change-password.form');
Route::post('alumni/change-password', [AlumniAuthController::class, 'changePassword'])->name('alumni.change-password.submit');

// --------------------
// Alumni Routes (Authenticated)
// --------------------
Route::middleware(['auth:alumni'])->group(function () {
    Route::get('/home', [AlumniHomeController::class, 'index'])->name('alumni.home');

    // Profile
    Route::get('/profile', [ProfileController::class, 'view'])->name('profile.view');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rewards & Raffles
    Route::get('/rewards', [RewardController::class, 'index'])->name('rewards.index');
    Route::post('/rewards/redeem/{reward}', [RewardController::class, 'redeem'])->name('rewards.redeem');

    // Directory
    Route::get('/directory', [DirectoryController::class, 'index'])->name('directory.index');

    // Events
    Route::get('/events', [PublicEventController::class, 'index'])->name('events.index');
    Route::get('/events/{eventID}', [PublicEventController::class, 'show'])->name('events.show');
    Route::post('/events/{eventID}/register', [PublicEventController::class, 'register'])->name('events.register');

    // Jobs
    Route::prefix('jobs')->group(function () {
        Route::get('/', [JobController::class, 'index'])->name('jobs.index');
        Route::get('/bookmarked', [JobController::class, 'bookmarked'])->name('jobs.bookmarked');
        Route::get('/pending', [JobController::class, 'pending'])->name('jobs.pending');
        Route::get('/{job}', [JobController::class, 'show'])->name('jobs.show');
        Route::post('/{job}/apply', [JobController::class, 'apply'])->name('jobs.apply');
        Route::delete('/{job}/cancel', [JobController::class, 'cancel'])->name('jobs.cancel');
        Route::post('/{job}/bookmark', [JobController::class, 'toggleBookmark'])->name('jobs.bookmark');
        Route::get('/filter/fetch', [JobController::class, 'fetch'])->name('jobs.fetch');
    });

    // Surveys
    Route::prefix('alumni')->group(function () {
        Route::get('surveys', [SurveyController::class, 'index'])->name('alumni.surveys.index');
        Route::get('surveys/{surveyID}', [SurveyController::class, 'show'])->name('alumni.surveys.show');
        Route::post('surveys/{surveyID}/confirm', [SurveyController::class, 'confirmCompletion'])->name('alumni.surveys.confirm');
    });
    
    Route::get('/about', function () {
        return view('alumni.about');
    })->name('alumni.about');

    // Messaging (Alumni Only)
    Route::get('/messages/list', [MessageController::class, 'chatList'])->name('messages.list');
    Route::get('/messages/conversation/{id}', [MessageController::class, 'fetchConversation'])->name('messages.fetchConversation');
    Route::post('/messages/conversation/{id}/send', [MessageController::class, 'sendMessage'])->name('messages.sendMessage');
    Route::get('/messages/search-users', [MessageController::class, 'searchUsers'])->name('messages.searchUsers');
    Route::post('/messages/start-conversation', [MessageController::class, 'startConversation'])->name('messages.startConversation');
});

// Public Alumni Profile
Route::get('/alumni/profile/{alumniID}', [ProfileController::class, 'public'])->name('profile.public');

// --------------------
// Admin Authentication
// --------------------
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

// --------------------
// Admin Routes
// --------------------
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/online-count', [AdminDashboardController::class, 'getOnlineCount'])->name('online.count');

    // Announcements
    Route::resource('announcements', AnnouncementController::class);

    // Admin Accounts
    Route::prefix('admins')->name('admins.')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('index');
        Route::get('/create', [AdminUserController::class, 'create'])->name('create');
        Route::post('/', [AdminUserController::class, 'store'])->name('store');
        Route::get('/{adminID}/edit', [AdminUserController::class, 'edit'])->name('edit');
        Route::put('/{adminID}', [AdminUserController::class, 'update'])->name('update');
        Route::delete('/{adminID}', [AdminUserController::class, 'destroy'])->name('destroy');
    });

    // Alumni Management Dropdown
    Route::prefix('alumni')->name('alumni.')->group(function () {
        // Main Alumni
        Route::get('/', [AlumniController::class, 'index'])->name('index');
        Route::get('/{id}', [AlumniController::class, 'show'])->name('show');
        Route::delete('/{id}', [AlumniController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/adjust-points', [AlumniController::class, 'adjustPoints'])->name('adjustPoints');
    });
    
    // Featured Alumni
    Route::resource('featured-alumni', FeaturedAlumniController::class)->names([
        'index' => 'featured-alumni.index',
        'create' => 'featured-alumni.create',
        'store' => 'featured-alumni.store',
        'edit' => 'featured-alumni.edit',
        'update' => 'featured-alumni.update',
        'destroy' => 'featured-alumni.destroy',
    ]);
    
    // Gallery
    Route::resource('gallery', GalleryController::class)->names([
        'index' => 'gallery.index',
        'create' => 'gallery.create',
        'store' => 'gallery.store',
        'edit' => 'gallery.edit',
        'update' => 'gallery.update',
        'destroy' => 'gallery.destroy',
    ]);

    // Events
    Route::resource('events', AdminEventController::class);

    // Jobs
    Route::resource('jobs', AdminJobController::class);
    Route::get('jobs/{job}/applications', [AdminJobController::class, 'applications'])->name('jobs.applications');

    // Surveys
    Route::resource('surveys', AdminSurveyController::class);
    Route::get('surveys/{survey}/responses', [AdminSurveyController::class, 'responses'])->name('surveys.responses');
    Route::put('surveys/{survey}/update-sheet', [AdminSurveyController::class, 'updateSheet'])->name('surveys.updateSheet');

    // Rewards & Raffles
    Route::resource('rewards', AdminRewardController::class);
    Route::resource('raffles', AdminRaffleController::class);
    Route::get('raffles/{raffle}/entries', [AdminRaffleController::class, 'entries'])->name('raffles.entries');
    Route::post('raffles/{raffle}/pick-winner', [AdminRaffleController::class, 'pickWinner'])->name('raffles.pickWinner');

    // Reports
    Route::get('reports/dashboard', [AdminReportController::class, 'dashboardReport'])->name('reports.dashboard');
    Route::get('reports/alumni-participation', [AdminReportController::class, 'alumniParticipation'])->name('reports.alumniParticipation');
    Route::get('reports/points-redemptions', [AdminReportController::class, 'pointsRedemptions'])->name('reports.pointsRedemptions');
    Route::get('reports/events', [AdminReportController::class, 'eventsReport'])->name('reports.events');
    Route::get('reports/surveys', [AdminReportController::class, 'surveysReport'])->name('reports.surveys');
    Route::get('reports/jobs', [AdminReportController::class, 'jobsReport'])->name('reports.jobs');
    
    // Reports export routes (CSV-based)
    Route::prefix('reports')->name('reports.')->group(function() {
        Route::get('/alumni/export', [AdminReportController::class, 'exportAlumniParticipationCSV'])->name('alumni.export');
        Route::get('/points/export', [AdminReportController::class, 'exportPointsRedemptionsCSV'])->name('points.export');
        Route::get('/events/export', [AdminReportController::class, 'exportEventsCSV'])->name('events.export');
        Route::get('/surveys/export', [AdminReportController::class, 'exportSurveysCSV'])->name('surveys.export');
        Route::get('/jobs/export', [AdminReportController::class, 'exportJobsCSV'])->name('jobs.export');
    });



    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    
    // Alumni Masterlist
    Route::prefix('masterlist')->name('masterlist.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\AlumniMasterlistController::class, 'index'])->name('index');
        Route::get('/import', [\App\Http\Controllers\Admin\AlumniMasterlistController::class, 'showImportForm'])->name('import.form');
        Route::post('/import', [\App\Http\Controllers\Admin\AlumniMasterlistController::class, 'import'])->name('import');
        Route::get('/export', [\App\Http\Controllers\Admin\AlumniMasterlistController::class, 'export'])->name('export');
    });
});

// --------------------
// Image & Storage Handling
// --------------------
Route::get('/storage/{folder}/{filename}', function ($folder, $filename) {
    $path = storage_path('app/public/' . $folder . '/' . $filename);
    if (!File::exists($path)) abort(404);
    return Response::make(File::get($path), 200)->header("Content-Type", File::mimeType($path));
});

Route::get('/images/{folder}/{filename}', [ImageController::class, 'show'])
    ->where(['folder' => '.*', 'filename' => '.*']);

// --------------------
// Cache Clearing
// --------------------
Route::get('/clear-all', function () {
    Artisan::call('optimize:clear');
    return '✅ All caches cleared.';
});

Route::get('/autoload', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('optimize:clear');
    return '✅ Laravel caches cleared and autoload refreshed';
});

Route::get('/test-excel', function () {
    $spreadsheet = new Spreadsheet();
    return 'PhpSpreadsheet is working!';
});
