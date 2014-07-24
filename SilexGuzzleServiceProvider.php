<?php

namespace Guzzle;

use Guzzle\PimpleGuzzleServiceProvider;
use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * Guzzle service provider for Silex
 *
 * @see PimpleGuzzleServiceProvider
 */
class SilexGuzzleServiceProvider implements ServiceProviderInterface
{
    /**
     * Register Guzzle with Silex
     *
     * @param Application $app Application to register with
     */
    public function register(Application $app)
    {
        $serviceProvider = new PimpleGuzzleServiceProvider();
        $serviceProvider->register($app);
    }

    public function boot(Application $app)
    {
    }
}
