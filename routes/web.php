<?php
use App\Http\Controllers\ProfilePostController;
use App\Http\Controllers\AdminContactController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsCommentController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\FaqCategoryController;

/*
|--------------------------------------------------------------------------
| Home & Dashboard (controller methods)
|--------------------------------------------------------------------------
*/
Route::get('/', [PageController::class, 'home'])->name('home');

Route::get('/dashboard', [PageController::class, 'dashboard'])
    ->middleware('auth')
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Public pages
|--------------------------------------------------------------------------
*/
Route::get('/news', [NewsController::class, 'index'])
    ->name('news.index');

Route::get('/news/{news}', [NewsController::class, 'show'])
    ->whereNumber('news') // ✅ evita conflicto con /news/create
    ->name('news.show');

Route::get('/faq', [FaqController::class, 'index'])
    ->name('faq.index');

Route::get('/contact', [ContactController::class, 'showForm'])
    ->name('contact.form');

Route::post('/contact', [ContactController::class, 'submit'])
    ->name('contact.submit');

Route::get('/profiles/{user}', [ProfileController::class, 'show'])
    ->name('profiles.show');

/*
|--------------------------------------------------------------------------
| Logged-in user (profile edit)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/me/profile/edit', [ProfileController::class, 'edit'])
        ->name('profiles.edit');

    Route::post('/me/profile', [ProfileController::class, 'update'])
        ->name('profiles.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/profiles/{user}/posts', [ProfilePostController::class, 'store'])
        ->name('profiles.posts.store');

    Route::delete('/profile-posts/{post}', [ProfilePostController::class, 'destroy'])
        ->name('profiles.posts.destroy');

    Route::post('/news/{news}/comments', [NewsCommentController::class, 'store'])
        ->whereNumber('news')
        ->name('news.comments.store');

    Route::delete('/news-comments/{comment}', [NewsCommentController::class, 'destroy'])
        ->name('news.comments.destroy');
});


/*
|--------------------------------------------------------------------------
| Admin only
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'can:admin'])->group(function () {

    // Admin users
    Route::get('/admin/contacts', [AdminContactController::class, 'index'])
        ->name('admin.contacts.index');

    Route::get('/admin/contacts/{contact}', [AdminContactController::class, 'show'])
        ->name('admin.contacts.show');

    Route::post('/admin/contacts/{contact}/reply', [AdminContactController::class, 'reply'])
        ->name('admin.contacts.reply');


    Route::get('/admin/users', [AdminController::class, 'index'])
        ->name('admin.users.index');

    Route::get('/admin/users/create', [AdminController::class, 'create'])
        ->name('admin.users.create');

    Route::post('/admin/users', [AdminController::class, 'store'])
        ->name('admin.users.store');

    Route::post('/admin/users/{user}/toggle-admin', [AdminController::class, 'toggleAdmin'])
        ->name('admin.users.toggleAdmin');

    // News CRUD (admin)
    Route::resource('news', NewsController::class)
        ->except(['index', 'show']);

    // FAQ CRUD (admin)
    Route::resource('faq-categories', FaqCategoryController::class);
    Route::resource('faqs', FaqController::class)
        ->except(['index', 'show']);

});

/*
|--------------------------------------------------------------------------
| Auth routes (Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
