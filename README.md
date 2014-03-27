Guzzle Service Provider
=======================

The GuzzleServiceProvider provides a Guzzle ServiceBuilder and default Client object through Michael Dowling’s Guzzle framework.  Guzzle is a PHP HTTP client and framework for building RESTful web service clients.

You will need to [install a copy of Guzzle](http://guzzlephp.org/tour/installation.html) in order to use this service provider.

Parameters
----------

* guzzle.services: (optional) array|string|SimpleXMLElement Data describing your web service clients.  You can pass the path to a file (.js|.json|.php), an array of data, or an instantiated SimpleXMLElement containing configuration data.  See the [Guzzle docs](http://guzzlephp.org/tour/using_services.html#instantiating-web-service-clients-using-a-servicebuilder) for more info.
* guzzle.base_url: (optional) The base url for the default web service client. When left out, the actual calls made must use absolute URLs.
* guzzle.plugins: (optional) An array of guzzle plugins to register with the client.

Services
--------

* guzzle: An instantiated Guzzle ServiceBuilder.
* guzzle.client: A default Guzzle web service client using the base URL.

Registering
-----------

### Pimple

```php
<?php

use Guzzle\PimpleGuzzleServiceProvider;

$container = new \Pimple();

$container['guzzle.services'] = '/path/to/services.json';
(new PimpleGuzzleServiceProvider())->register($container);
```

### Silex

```php
<?php

use Silex\Application;
use Guzzle\SilexGuzzleServiceProvider;

$app = new Application();

$app->register(new SilexGuzzleServiceProvider(), array(
    'guzzle.services' => '/path/to/services.json',
));
```

### Cilex

```php
<?php

use Cilex\Application;
use Guzzle\CilexGuzzleServiceProvider;

$app = new Application();

$app->register(new CilexGuzzleServiceProvider(), array(
    'guzzle.services' => '/path/to/services.json',
));
```

Example Usage
-------------

Using the instantiated ServiceBuilder:

    // Get a command "foo" from "my_client"
    $result = $app['guzzle']['my_client']->getCommand('foo');
    $result = $foo->execute();

Using the Guzzle client:

    $response = $app['guzzle.client']->head('http://www.guzzlephp.org')->send();

More information
----------------
More information about Guzzle ServiceBuilders can be found at http://docs.guzzlephp.org/en/latest/webservice-client/using-the-service-builder.html
