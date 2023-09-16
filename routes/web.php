<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Backend\DasawismaController;
use App\Http\Controllers\Backend\DataRecapFamilyActivityController;
use App\Http\Controllers\Backend\DataRecapFamilyMemberController;
use App\Http\Controllers\Backend\DataRecapFamilyBuildingController;
use App\Http\Controllers\Backend\DataRecapFamilyNumberController;
use App\Http\Controllers\Backend\UserManagementController;
use App\Http\Controllers\Backend\HomeController as AdminHomeController;
use App\Http\Controllers\Backend\MemberController;
use App\Http\Controllers\Frontend\HomeController as FrontHomeController;

Route::get('/', [FrontHomeController::class, 'index'])->name('home');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::prefix('auth')->name('auth.')->controller(AuthController::class)->group(function () {
        Route::middleware(['guest:web'])->group(function () {
            Route::get('/login', 'showLogin')->name('login.get');
            Route::get('/forgot-password', 'showForgetPassword')->name('forgot_password.get');
        });

        Route::middleware(['auth:web'])->group(function () {
            Route::get('/profile', 'showProfile')->name('profile');
        });
    });

    Route::prefix('home')->name('home.')
        ->controller(AdminHomeController::class)->group(function () {
            Route::middleware(['auth:web'])->group(function () {
                Route::get('/index', 'index')->name('index');
            });
        });

    Route::prefix('data-input')->name('data_input.')->group(function () {
        Route::prefix('dasawisma')->name('dasawisma.')
            ->controller(DasawismaController::class)->group(function () {
                Route::middleware(['auth:web'])->group(function () {
                    Route::get('/index', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::get('/edit/{dasawisma:slug}', 'edit')->name('edit');
                });
            });

        Route::prefix('member')->name('member.')
            ->controller(MemberController::class)->group(function () {
                Route::middleware(['auth:web'])->group(function () {
                    Route::get('/index', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::prefix('/family')->name('family.')->group(function () {
                        Route::get('/{family:kkNumber}/edit', 'editFamily')->name('edit');
                    });
                    Route::prefix('/family-building')->name('family_building.')->group(function () {
                        Route::get('/{family:kkNumber}/edit', 'editFamilyBuilding')->name('edit');
                    });
                    Route::prefix('/family-number')->name('family_number.')->group(function () {
                        Route::get('/{family:kkNumber}/edit', 'editFamilyNumber')->name('edit');
                    });
                    Route::prefix('/family-member')->name('family_member.')->group(function () {
                        Route::get('/{family:kkNumber}/edit', 'editFamilyMember')->name('edit');
                    });
                    Route::prefix('/family-activity')->name('family_activity.')->group(function () {
                        Route::get('/{family:kkNumber}/edit', 'editFamilyActivity')->name('edit');
                    });
                });
            });
    });

    Route::prefix('data-recap')->middleware(['auth:web'])->name('data_recap.')->group(function () {
        Route::prefix('family-numbers')->name('family_numbers.')
            ->controller(DataRecapFamilyNumberController::class)->group(function () {
                Route::get('/index', 'index')->name('index');
                Route::get('/area/{code}', 'index')->name('show_area');
                Route::get('/dasawisma/{slug}', 'index')->name('show_dasawisma');
            });

        Route::prefix('family-buildings')->name('family_buildings.')
            ->controller(DataRecapFamilyBuildingController::class)->group(function () {
                Route::get('/index', 'index')->name('index');
                Route::get('/area/{code}', 'index')->name('show_area');
                Route::get('/dasawisma/{slug}', 'index')->name('show_dasawisma');
            });

        Route::prefix('family-members')->name('family_members.')
            ->controller(DataRecapFamilyMemberController::class)->group(function () {
                Route::get('/index', 'index')->name('index');
                Route::get('/area/{code}', 'index')->name('show_area');
                Route::get('/dasawisma/{slug}', 'index')->name('show_dasawisma');
            });

        Route::prefix('family-activities')->name('family_activities.')
            ->controller(DataRecapFamilyActivityController::class)->group(function () {
                Route::get('/index', 'index')->name('index');
                Route::get('/area/{code}', 'index')->name('show_area');
                Route::get('/dasawisma/{slug}', 'index')->name('show_dasawisma');
            });
    });

    Route::prefix('management')->name('management.')->group(function () {
        Route::prefix('user')->name('user.')
            ->controller(UserManagementController::class)->group(function () {
                Route::middleware(['auth:web'])->group(function () {
                    Route::get('/index', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::get('/edit/{user:username}', 'edit')->name('edit');
                });
            });
    });
});
