<?php

namespace Guzzle;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Guzzle\Service\Builder\ServiceBuilder;
use Guzzle\Service\Client;

/**
 * Guzzle service provider for Silex
 *
 * = Parameters:
 *  guzzle.services: (optional) array|string|SimpleXMLElement Data describing
 *      your web service clients.  You can pass the path to a file
 *      (.xml|.js|.json), an array of data, or an instantiated SimpleXMLElement
 *      containing configuration data.  See the Guzzle docs for more info.
 *  guzzle.plugins: (optional) An array of guzzle plugins to register with the
 *      client.
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
        $app['guzzle.base_url'] = '/';
        $app['guzzle.plugins'] = array();

        // Register a Guzzle ServiceBuilder
        $app['guzzle'] = $app->share(function () use ($app) {
            if (!isset($app['guzzle.services'])) {
                $builder = new ServiceBuilder(array());
            } else {
                $builder = ServiceBuilder::factory($app['guzzle.services']);
            }

            return $builder;
        });

        // Register a simple Guzzle Client object (requires absolute URLs when guzzle.base_url is unset)
        $app['guzzle.client'] = $app->share(function() use ($app) {
            $client = new Client($app['guzzle.base_url']);

            foreach ($app['guzzle.plugins'] as $plugin) {
                $client->addSubscriber($plugin);
            }

            return $client;
        });

        $app['guzzle.base_url'] = '/';
    }

    public function boot(Application $app)
    {
    }
}
