<?php

namespace App\Providers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\ServiceProvider;

class BannerServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        RedirectResponse::macro('banner', function (string $message): RedirectResponse {
            $this->with('flash', [
                'banner' => $message,
                'styleBanner' => 'success'
            ]);

            return $this;
        });

        RedirectResponse::macro('bannerDanger', function (string $message): RedirectResponse {
            $this->with('flash', [
                'banner' => $message,
                'styleBanner' => 'danger'
            ]);
            return $this;
        });
    }
}
