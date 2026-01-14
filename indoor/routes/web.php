<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\AdminTestimonialController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EditionController;
use App\Http\Controllers\FacebookAuthController;
use App\Http\Controllers\FacebookReviewController;
use App\Http\Controllers\GoogleReviewController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HomePageLogoController;
use App\Http\Controllers\MagazineController;
use App\Http\Controllers\MagazineImageController;
use App\Http\Controllers\MailSettingsController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Provider;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\ProviderDetailController;
use App\Http\Controllers\ReviewSettingController;
use App\Http\Controllers\SearchAutocompleteController;
use App\Http\Controllers\SearchAutocompleteServiceController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\Web;
use Illuminate\Support\Facades\Route;

Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');

Route::get('/search-autocomplete', SearchAutocompleteController::class)->name('search-autocomplete');
Route::get('/search-autocomplete-service', SearchAutocompleteServiceController::class)->name('search-autocomplete-service');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::prefix('admin')->name('admin.')->middleware(['role:admin|super admin'])->group(function () {
        Route::patch('homeowners/{id}/updateIsVerified', [Admin\HomeownerController::class, 'updateIsVerified'])
            ->name('homeowners.updateIsVerified');
        Route::patch('/homeowners/{user}/changeRole', [Admin\HomeownerController::class, 'changeRole'])
            ->name('homeowners.changeRole');

        Route::patch('contractors/{id}/updateIsVerified', [Admin\ContractorController::class, 'updateIsVerified'])
            ->name('contractors.updateIsVerified');
        Route::patch('/contractors/{user}/changeRole', [Admin\ContractorController::class, 'changeRole'])
            ->name('contractors.changeRole');

        Route::patch('admins/{id}/updateIsVerified', [Admin\UserController::class, 'updateIsVerified'])
            ->name('admins.updateIsVerified');
        Route::patch('/admins/{user}/changeRole', [Admin\UserController::class, 'changeRole'])
            ->name('admins.changeRole');

        Route::get('/providerDetail/{user}', [ProviderDetailController::class, 'editById'])->name('details.editById');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/magazineImages/{id}', [MagazineImageController::class, 'index'])->name('magazineImages.index');
        Route::patch('/categories/{id}/updateIsActive', [CategoryController::class, 'updateIsActive'])
            ->name('categories.updateIsActive');
        Route::patch('/categories/{id}/updateShowInHomeTopSlider', [CategoryController::class, 'updateShowInHomeTopSlider'])
            ->name('categories.updateShowInHomeTopSlider');
        Route::patch('/logos/{logo}/updateIsActive', [HomePageLogoController::class, 'updateIsActive'])
            ->name('logos.updateIsActive');
        Route::post('/contactMessages/reply', [ContactMessageController::class, 'reply'])
            ->name('contactMessages.reply');
        Route::get('/edition', [EditionController::class, 'edit'])
            ->name('edition.edit');
        Route::patch('/edition', [EditionController::class, 'update'])
            ->name('edition.update');
        Route::get('/settings/mail', [MailSettingsController::class, 'edit'])
            ->name('settings.mail.edit');
        Route::patch('/settings/mail', [MailSettingsController::class, 'update'])
            ->name('settings.mail.update');
        Route::patch('/requestQuotes/{requestQuote}/toggleProcessed', [Admin\RequestQuoteController::class, 'toggleProcessed'])
            ->name('requestQuotes.toggleProcessed');
        Route::resources([
            'magazineImages' => MagazineImageController::class,
            'requestQuotes' => Admin\RequestQuoteController::class,
            'magazines' => MagazineController::class,
            'homeowners' => Admin\HomeownerController::class,
            'contractors' => Admin\ContractorController::class,
            'admins' => Admin\UserController::class,
            'categories' => CategoryController::class,
            'contactMessages' => ContactMessageController::class,
            'logos' => HomePageLogoController::class,
        ]);
        Route::resource('testimonials', AdminTestimonialController::class)->only(['index', 'show', 'destroy']);
        Route::resource('sms-templates', Admin\SmsTemplateController::class)->only(['index', 'edit', 'update']);
        Route::resource('sms-messages', Admin\SmsMessageController::class)->only(['index', 'show', 'update']);
        Route::resource('licenses', Admin\LicenseController::class)->only(['index', 'edit', 'update']);
        Route::resource('plans', Admin\PlanController::class)->only(['index', 'edit', 'update']);
        Route::resource('invite-codes', Admin\InviteCodeController::class)->only(['index', 'store', 'destroy']);
        Route::delete('certificates/{file}', [Admin\CertificateController::class, 'destroy']);

        Route::get('landings', [Admin\LandingController::class, 'index'])->name('landings.index');
        Route::get('landings/create/{providerDetail}', [Admin\LandingController::class, 'create'])->name('landings.create');
        Route::post('landings', [Admin\LandingController::class, 'store'])->name('landings.store');
        Route::get('landings/{landing}/edit', [Admin\LandingController::class, 'edit'])->name('landings.edit');
        Route::put('landings/{landing}', [Admin\LandingController::class, 'update'])->name('landings.update');
        Route::delete('landings/{landing}', [Admin\LandingController::class, 'destroy'])->name('landings.destroy');
    });

    Route::prefix('provider')->middleware(['role:provider|admin|super admin'])->name('provider.')->group(function () {
        Route::patch('/details/{providerDetail}', [ProviderDetailController::class, 'update'])->name('details.update');
        Route::delete('/details/{providerDetail}/logo', [ProviderDetailController::class, 'removeLogo'])->name('details.logo.delete');
        Route::delete('/details/{providerDetail}/background', [ProviderDetailController::class, 'removeBackground'])->name('details.background.delete');
        Route::patch('/{user}/fileUpload', [ProviderController::class, 'fileUpload'])->name('fileUpload');
        Route::patch('/certificates/{file}/type', [ProviderController::class, 'updateDocumentType'])->name('certificates.updateType');
        Route::get('/explanation', function () {
            return view('provider.explanation');
        })->name('explanation');

        Route::patch('{id}/updateIsSmsEnabled', [ProviderController::class, 'updateIsSmsEnabled'])
            ->name('updateIsSmsEnabled');
    });

    Route::prefix('provider')->middleware(['role:provider'])->name('provider.')->group(function () {
        Route::post('/sync-google-reviews/{providerDetail}', [ProviderController::class, 'syncGoogleReviews'])->name('sync-google-reviews');
        Route::post('/sync-facebook-reviews/{providerDetail}', [ProviderController::class, 'syncFacebookReviews'])->name('sync-facebook-reviews');
        Route::get('/verification', [ProviderController::class, 'verification'])->name('verification');
        Route::get('/details', [ProviderDetailController::class, 'edit'])->name('details.edit');
        Route::get('/preview/{providerDetail}', [ProviderDetailController::class, 'preview'])->name('details.preview');
        Route::get('/{providerDetail}/generate-review-link', [ProviderDetailController::class, 'generateReviewLink'])
            ->name('details.generate-review-link');
        Route::delete('/testimonials/{testimonial}/image', [TestimonialController::class, 'removeImage'])
            ->name('testimonials.image.delete');
        Route::patch('/testimonials/{testimonial}/toggleStatus', [TestimonialController::class, 'toggleStatus'])
            ->name('testimonials.status.toggle');

        Route::prefix('reviews')
            ->as('reviews.')
            ->group(function () {
                Route::get('settings', [ReviewSettingController::class, 'edit'])
                    ->name('settings.edit');
                Route::patch('settings/{providerDetail}', [ReviewSettingController::class, 'update'])
                    ->name('settings.update');
            });

        Route::resource('testimonials', TestimonialController::class)->only(['index', 'show']);
        Route::resource('google-reviews', GoogleReviewController::class)->only(['index', 'show']);
        Route::post('google-reviews/toggle', [GoogleReviewController::class, 'toggle']);
        Route::resource('facebook-reviews', FacebookReviewController::class)->only(['index', 'show']);
        Route::post('facebook-reviews/toggle', [FacebookReviewController::class, 'toggle']);

        Route::resource('provider-messages', MessageController::class)
            ->only(['index', 'show', 'update']);

        Route::resource('request-quotes', Provider\RequestQuoteController::class)
            ->only(['index', 'show', 'update']);
    });
});

Route::post('request-quote', [Admin\RequestQuoteController::class, 'store'])->name('request-quote.store');
Route::post('provider/provider-messages', [MessageController::class, 'store'])->name('provider.provider-messages.store');
Route::get('/categories/subcategories', [CategoryController::class, 'getSubCategories'])
    ->name('categories.subCategories');
Route::get('/provider-details/{providerDetail:slug}', [ProviderDetailController::class, 'show'])
    ->middleware('user.verified')
    ->name('provider.details.show');
Route::get('provider-details/{providerDetail:slug}/{landing}', Web\LandingController::class)
    ->middleware('user.verified')
    ->name('landings.show');
Route::post('contactMessages', [ContactMessageController::class, 'store'])->name('contactMessages.store');

Route::get('/category/subcategories', [CategoryController::class, 'getSubCategoriesByCategoriesArr'])
    ->name('category.subCategories');

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/e-dition', [EditionController::class, 'show'])->name('edition.show');

Route::get('/about-us', function () {
    return view('about-us');
})->name('about-us');

Route::get('/{providerDetail}/review/{token}', [TestimonialController::class, 'create'])
    ->name('testimonials.create');
Route::post('/reviews/{token}', [TestimonialController::class, 'store'])
    ->name('testimonials.store');

Route::get('/contact-us', function () {
    return view('contact-us');
})->name('contact-us');

Route::middleware('guest')->group(function () {
    Route::get('/signup', function () {
        return view('auth.choose-signup');
    })->name('signup');

    Route::get('/customer-registration', function () {
        return view('auth.register', ['is_provider' => false]);
    })->name('register.customer');

    Route::get('/provider-registration', function () {
        return view('auth.register', ['is_provider' => true]);
    })->name('register.provider');
});

Route::get('/data-deletion', function () {
    return view('data-deletion');
})->name('data-deletion');

Route::get('/privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy-policy');

Route::get('/home-pro', function () {
    return view('home-pro');
})->name('home-pro');

Route::get('/terms-condition', function () {
    return view('terms-condition');
})->name('terms-condition');

Route::prefix('auth/facebook')
    ->as('facebook.')
    ->group(function () {
        Route::get('/', [FacebookAuthController::class, 'redirect'])->name('redirect');
        Route::get('callback', [FacebookAuthController::class, 'callback'])->name('callback');
        Route::post('disconnect/{providerDetail}', [FacebookAuthController::class, 'disconnect'])->name('disconnect');
    });

require __DIR__.'/auth.php';
