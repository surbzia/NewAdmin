<?php

namespace App\Providers;

use App\Policies\{BannerPolicy, BrandPolicy, CategoryPolicy, CityPolicy, CountryPolicy, UserPolicy, PermissionPolicy, RolePolicy, CouponPolicy, OrderPolicy, ProductPolicy, ProductQuotePolicy, StatePolicy, UserExemptionPolicy};
use App\Models\{Banner, Brand, Category, City, Country, User, Permission, Role, Product, Coupon, ProductQuote, State, UserExemption};
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        User::class => UserPolicy::class,
        Permission::class => PermissionPolicy::class,
        Role::class => RolePolicy::class,
        Product::class=> ProductPolicy::class,
        Coupon::class=>CouponPolicy::class,
        Category::class=>CategoryPolicy::class,
        Brand::class => BrandPolicy::class,
        ProductQuote::class=>ProductQuotePolicy::class,
        Banner::class=>BannerPolicy::class,
        Order::class=>OrderPolicy::class,
        Country::class=>CountryPolicy::class,
        State::class=>StatePolicy::class,
        City::class=>CityPolicy::class,
        UserExemption::class=>UserExemptionPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        if (! $this->app->routesAreCached()) {
            // Passport::routes();
            Passport::tokensExpireIn(now()->addDays(15));
            Passport::refreshTokensExpireIn(now()->addDays(30));
            Passport::personalAccessTokensExpireIn(now()->addMonths(6));
        }
        // Gate::guessPolicyNamesUsing(function ($modelClass) {
        //     // Return the name of the policy class for the given model...
        // });
    }
}
