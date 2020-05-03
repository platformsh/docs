---
title: "Using Redis with WordPress"
weight: 1
sidebarTitle: "Redis"
---

There are a number of Redis libraries for WordPress, only some of which are compatible with Platform.sh.  We have tested and recommend [devgeniem/wp-redis-object-cache-dropin](https://packagist.org/packages/devgeniem/wp-redis-object-cache-dropin), which requires extremely little configuration.

## Requirements

### Add a Redis service

First you need to create a Redis service.  In your `.platform/services.yaml` file, add the following:

```yaml
rediscache:
    type: redis:5.0
```

That will create a service named `rediscache`, of type `redis`, specifically version `5.0`.

### Expose the Redis service to your application

In your `.platform.app.yaml` file, we now need to open a connection to the new Redis service.  Under the `relationships` section, add the following:

```yaml
relationships:
    redis: "rediscache:redis"
```

The key (left side) is the name that will be exposed to the application in the `PLATFORM_RELATIONSHIPS` [variable](/development/variables.md).  The right hand side is the name of the service we specified above (`rediscache`) and the endpoint (`redis`).  If you named the service something different above, change `rediscache` to that.

### Add the Redis PHP extension

Because the Redis extension for PHP has been known to have BC breaks at times, we do not bundle a specific verison by default.  Instead, we provide a script to allow you to build your desired version in the build hook.  See the [PHP-Redis page](/languages/php/redis.md) for a simple-to-install script and instructions.

### Add the Redis library

If using Composer to build WordPress, you can install the WP-Redis library with the following Composer command:

```bash
composer require devgeniem/wp-redis-object-cache-dropin
```

Then commit the resulting changes to your `composer.json` and `composer.lock` files.

## Configuration

To enable the WP-Redis cache the `object-cache.php` file needs to be copied from the downloaded package to the `wp-content` directory.  Add the following line to the bottom of your `build` hook:

```bash
cp -r wp-content/wp-redis-object-cache-dropin/object-cache.php web/wp/wp-content/object-cache.php
```

It should now look something like:

```yaml
hooks:
    build: |
        set -e
        bash install-redis.sh 5.1.1
        cp -r wp-content/wp-redis-object-cache-dropin/object-cache.php web/wp/wp-content/object-cache.php
```

Next, place the following code in the `wp-config.php` file, somewhere before the final `require_once(ABSPATH . 'wp-settings.php');` line.

```php
<?php

if (!empty($_ENV['PLATFORM_RELATIONSHIPS']) && extension_loaded('redis')) {
    $relationships = json_decode(base64_decode($_ENV['PLATFORM_RELATIONSHIPS']), true);

    $relationship_name = 'redis';

    if (!empty($relationships[$relationship_name][0])) {
        $redis = $relationships[$relationship_name][0];
        define('WP_REDIS_CLIENT', 'pecl');
        define('WP_REDIS_HOST', $redis['host']);
        define('WP_REDIS_PORT', $redis['port']);
    }
}
```

That will define 3 constants that the WP-Redis extension will look for in order to connect to the Redis server.  If you used a different name for the relationship above, change `$relationship_name` accordingly.  This code will have no impact when run on a local development environment.

That's it.  There is no Plugin to enable through the WordPress administrative interface.  Commit the above changes and push.

### Verifying Redis is running

Run this command in a SSH session in your environment `redis-cli -h redis.internal info`. You should run it before you push all this new code to your repository.

This should give you a baseline of activity on your Redis installation. There should be very little memory allocated to the Redis cache.

After you push this code, you should run the command and notice that allocated memory will start jumping.
