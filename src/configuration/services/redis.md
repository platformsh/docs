# Redis (Object cache)

Redis is a high-performance in-memory object store, well-suited for application level caching.

See the [Redis documentation](https://redis.io/documentation) for more information.

Platform.sh supports two different Redis configurations: One persistent (useful for key-value application data) and one ephemeral (in-memory only, useful for application caching).  Aside from that distinction they are identical.

## Supported versions

* 3.2
* 4.0
* 5.0

### Deprecated versions

The following versions are available but are not receiving security updates from upstream, so their use is not recommended. They will be removed at some point in the future.

* 2.8
* 3.0

> **note**
> Versions 3.0 and higher support up to 64 different databases per instance of the service, but Redis 2.8 is configured to support only a single database

### Ephemeral Redis

The `redis` service type is configured to serve as a LRU cache with the eviction policy `allkeys-lru` - its storage is not persistent.  It is not suitable for use except as a disposable cache.

To add an Ephemeral Redis service, specify it in your `.platform/services.yaml` file like so:

```yaml
rediscache:
    type: redis:3.2
```

Data in an Ephemeral Redis instance is stored only in memory, and thus requires no disk space.  When the service hits its memory limit it will automatically evict old cache items to make room for new ones.

### Persistent Redis

The `redis-persistent` service type is configured for persistent storage. That makes it a good choice for fast application-level key-value storage.

To add a Persistent Redis service, specify it in your `.platform/services.yaml` file like so:

```yaml
redisdata:
    type: redis-persistent:3.2
    disk: 1024
```

The `disk` key is required for redis-persistent to tell Platform.sh how much disk space to reserve for Redis' persistent data.

## Relationship

The format exposed in the ``$PLATFORM_RELATIONSHIPS`` [environment variable](/development/variables.md#platformsh-provided-variables):

```json
{
    "redis": [
        {
            "host": "248.0.65.198",
            "scheme": "redis",
            "port": 6379
        }
    ]
}
```

The format is identical regardless of whether it's a persistent or ephemeral service.

## Usage example

In your ``.platform/services.yaml``:

```yaml
rediscache:
    type: redis:3.2
```

If you are using PHP, configure a relationship and enable the [PHP redis extension](/languages/php.md#php-extensions) in your `.platform.app.yaml`.

```yaml
runtime:
    extensions:
        - redis

relationships:
    applicationcache: "rediscache:redis"
```

You can then use the service in a configuration file of your application with something like:

```php
<?php
// This assumes a fictional application with an array named $settings.
if (getenv('PLATFORM_RELATIONSHIPS')) {
	$relationships = json_decode(base64_decode($relationships), TRUE);

	// For a relationship named 'applicationcache' referring to one endpoint.
	if (!empty($relationships['applicationcache'])) {
		foreach ($relationships['applicationcache'] as $endpoint) {
			$settings['redis_host'] = $endpoint['host'];
			$settings['redis_port'] = $endpoint['port'];
			break;
		}
	}
}
```

## Using redis-cli to access your Redis service

With a Redis relationship named `applicationcache`.

```yaml
# .platform/services.yaml
rediscache:
    type: redis:3.2
```

```yaml
# .platform.app.yaml
relationships:
    applicationcache: "rediscache:redis"
```

The host name and port number obtained from `PLATFORM_RELATIONSHIPS` would be `applicationcache.internal` and `6379`. Open an [SSH session](/development/ssh.md) and access the Redis server using the `redis-cli` tool as follows:

```bash
redis-cli -h applicationcache.internal -p 6379
```

### Using Redis as handler for native PHP sessions

Using the same configuration but with your Redis relationship named `sessionstorage`:

```yaml
# .platform/services.yaml
rediscache:
    type: redis:3.2
```

```yaml
# .platform.app.yaml
relationships:
    sessionstorage: "rediscache:redis"
```

```yaml
# .platform.app.yaml
variables:
    php:
        session.save_handler: redis
        session.save_path: "tcp://sessionstorage.internal:6379"
```
