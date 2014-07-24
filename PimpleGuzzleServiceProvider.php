<?php

namespace Guzzle;

use Guzzle\Service\Builder\ServiceBuilder;
use Guzzle\Service\Client;

/**
 * Guzzle service provider for Pimple
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
class PimpleGuzzleServiceProvider
{
    /**
     * Register Guzzle with Pimple
     *
     * @param \Pimple $container Container to register with
     */
    public function register(\Pimple $container)
    {
        $container['guzzle.base_url'] = '/';
        $container['guzzle.plugins'] = array();

        // Register a Guzzle ServiceBuilder
        $container['guzzle'] = $container->share(function () use ($container) {
            if (!isset($container['guzzle.services'])) {
                $builder = new ServiceBuilder(array());
            } else {
                $builder = ServiceBuilder::factory($container['guzzle.services']);
            }

            return $builder;
        });

        // Register a simple Guzzle Client object (requires absolute URLs when guzzle.base_url is unset)
        $container['guzzle.client'] = $container->share(function() use ($container) {
            $client = new Client($container['guzzle.base_url']);

            foreach ($container['guzzle.plugins'] as $plugin) {
                $client->addSubscriber($plugin);
            }

            return $client;
        });
    }
}
