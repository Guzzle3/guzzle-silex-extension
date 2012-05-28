<?php

namespace Guzzle;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Guzzle\Service\ServiceBuilder;
use Guzzle\Service\Client;

/**
 * Guzzle service provider for Silex
 *
 * = Parameters:
 *  guzzle.class_path: (optional) Path to where the Guzzle library is located.
 *  guzzle.services: (optional) array|string|SimpleXMLElement Data describing
 *      your web service clients.  You can pass the path to a file
 *      (.xml|.js|.json), an array of data, or an instantiated SimpleXMLElement
 *      containing configuration data.  See the Guzzle docs for more info.
 *  guzzle.builder_format: (optional) Pass the file extension (xml, js) when
 *      using a file that does not use the standard file extension
 *
 * = Services:
 *   guzzle: An instantiated Guzzle ServiceBuilder.
 *   guzzle.client: A default Guzzle web service client using a dumb base URL.
 *
 * @author Michael Dowling <michael@guzzlephp.org>
 */
class GuzzleServiceProvider implements ServiceProviderInterface
{
    /**
     * Register Guzzle with Silex
     *
     * @param Application $app Application to register with
     */
    public function register(Application $app)
    {
        // Register a Guzzle ServiceBuilder
        $app['guzzle'] = $app->share(function () use ($app) {

            if (!isset($app['guzzle.services'])) {
                $builder = new ServiceBuilder(array());
            } else {
                $app['guzzle.builder_format'] = isset($app['guzzle.builder_format']) ?: false;
                $builder = ServiceBuilder::factory($app['guzzle.services'], $app['guzzle.builder_format']);
            }

            return $builder;
        });

        // Register a simple Guzzle Client object (requires absolute URLs)
        $app['guzzle.client'] = $app->share(function() use ($app) {
            return new Client('/');
        });

        // Register the Guzzle namespace if guzzle.class_path is set
        if (isset($app['guzzle.class_path'])) {
            $app['autoloader']->registerNamespace('Guzzle', $app['guzzle.class_path']);
        }
    }
    
    public function boot(Application $app)
    {
    }
}