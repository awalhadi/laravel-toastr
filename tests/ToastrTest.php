<?php

namespace YourVendor\LaravelToastr\Tests;

use Orchestra\Testbench\TestCase;
use YourVendor\LaravelToastr\ToastrServiceProvider;
use YourVendor\LaravelToastr\Facades\Toastr;

class ToastrTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [ToastrServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Toastr' => Toastr::class,
        ];
    }

    /** @test */
    public function it_can_add_a_notification_to_session()
    {
        Toastr::success('Test Message');

        $this->assertEquals([
            [
                'type' => 'success',
                'message' => 'Test Message',
                'title' => null,
                'options' => [],
            ]
        ], session('toastr'));
    }
}