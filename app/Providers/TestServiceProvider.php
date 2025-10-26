<?php

namespace App\Providers;

use Illuminate\Support\Arr;
use Illuminate\Testing\TestResponse;
use Inertia\Testing\AssertableInertia;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TestServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        AssertableInertia::macro('hasResource', function (string $key, JsonResource $resource) {
            expect($this->has($key)->prop($key))
                ->toEqual($resource->response()->getData(true));
            return $this;
        });

        AssertableInertia::macro('hasKey', function (string $key) {
            expect((bool) $this->has($key))->toBeTrue();

            return $this;
        });

        AssertableInertia::macro('getProps', fn() => $this->toArray()['props']);

        AssertableInertia::macro('getProp', fn(string $key) => Arr::get($this->toArray()['props'], $key));

        AssertableInertia::macro('hasPaginatedResource', function (string $key, ResourceCollection $resource) {
            expect($this->has($key)->prop($key))
                ->toHaveKeys(['data', 'links', 'meta'])
                ->data->toEqual($resource->response()->getData(true)['data']);

            return $this;
        });

        TestResponse::macro('assertHasResource', function (string $key, JsonResource $resource) {
            $this->assertInertia(fn(AssertableInertia $page) => $page->hasResource($key, $resource));

            return $this;
        });

        TestResponse::macro('assertHasKey', function (string $key) {
            $this->assertInertia(fn(AssertableInertia $page) => $page->hasKey($key));

            return $this;
        });

        TestResponse::macro('assertHasKeys', function (array $keys) {
            $this->assertInertia(function (AssertableInertia $page) use ($keys) {
                foreach ($keys as $key) {
                    $page->hasKey($key);
                }
            });

            return $this;
        });

        TestResponse::macro('assertHasPaginatedResource', function (string $key, ResourceCollection $resource) {
            $this->assertInertia(fn(AssertableInertia $page) => $page->hasPaginatedResource($key, $resource));

            return $this;
        });

        TestResponse::macro('assertComponentIs', function (string $component) {
            $this->assertInertia(fn(AssertableInertia $page) => $page->component($component, true));

            return $this;
        });

        TestResponse::macro('assertHasProp', function (string $key) {
            $this->assertInertia(fn(AssertableInertia $page) => $page->has($key));

            return $this;
        });
    }
}
