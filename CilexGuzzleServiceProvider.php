<?php

namespace Guzzle;

use Guzzle\PimpleGuzzleServiceProvider;
use Cilex\Application;
use Cilex\ServiceProviderInterface;

/**
 * Guzzle service provider for Cilex
 *
 * @see PimpleGuzzleServiceProvider
 */
class CilexGuzzleServiceProvider implements ServiceProviderInterface
{
    /**
     * Register Guzzle with Cilex
     *
     * @param Application $app Application to register with
     */
    public function register(Application $app)
    {
        $serviceProvider = new PimpleGuzzleServiceProvider();
        $serviceProvider->register($app);
    }
}
