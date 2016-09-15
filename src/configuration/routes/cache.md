# HTTP Cache

## Rationale

Many hosting solutions are adding an additional layer (Varnish...) to
handle caching. Platform.sh allows you to enable HTTP caching right at
the web server level.

If you disable caching, Platform.sh serves the files that are stored in
the application directly. For example with Drupal, this means that all
HTTP requests will bootstrap Drupal and query the database. When the
cache is enabled, if the page has been stored in the Nginx cache, it
won't access Drupal.

## Reference

Cache can be enabled in your `.platform/routes.yaml` file like below:

```yaml
http://{default}/:
    type: upstream
    upstream: php:http
    cache:
        enabled: true
        headers: [ "Accept", "Accept-Language", "X-Language-Locale" ]
        cookies: ["*"]
        default_ttl: 60
```

## Cache Per Route

If you need fine-grained caching, you can set up caching rules for
several routes separately.

Here is an example:

```yaml
http://{default}/:
  type: upstream
  upstream: php:http
  cache:
    enabled: true

http://{default}/foo/:
  type: upstream
  upstream: php:http
  cache:
    enabled: false

http://{default}/foo/bar/:
  type: upstream
  upstream: php:http
  cache:
    enabled: true
```

With this configuration, the following routes are cached:

-   `http://{default}/`
-   `http://{default}/foo/bar/`
-   `http://{default}/foo/bar/baz/`

And the following routes are **not** cached:

-   `http://{default}/foo/`
-   `http://{default}/foo/baz/`

> **note**
> Regular expressions in routes are **not** supported.

## Cache key

To decide how to cache a response, Platform.sh will build a cache key
depending on several factors and store the response associated with this
key. When a request comes with the same cache key, the cached response will
be reused.

Some parameters let you change this cache key: the `headers` key and the
`cookies` key.

The default value for these keys are the following:

```yaml
cache:
  enabled: true
  headers: []
  cookies: ["*"]
```

The `Vary` header in the response is also respected. Multiple copies under
the same cache key would be created according to the value of this header.
For example, you can rely on the `X-Forwarded-Proto`
[custom request header](reference/faq/known-issues.html#do-you-add-custom-http-headers)
to render content based on the request protocol (i.e. HTTP or HTTPS).
By adding `Vary: X-Forwarded-Proto` to the response header, HTTP and HTTPS
content would be cached under the same cache key separately.

## Cache behavior

Cache is only applied to `GET` and `HEAD` requests.
Responses with the `Cache-Control` header set to `Private`, `No-Cache`,
or `No-Store` are not cached. Responses with the `Set-Cookie` header set are
also not cached.

## Cache duration

The cache duration is decided based on the `Cache-Control` response
header value. If no `Cache-Control` header is in the response, then the
value of `default_ttl` key is used.

## Cache serving

Our web server does not honor the `Pragma` request header.
Conditional requests using `If-Modified-Since` and `If-None-Match`
are both supported.

## Cache revalidation

When the cache is expired, indicated by `Last-Modified` header
in the response, the web server would send a request to your
application with `If-Modified-Since` header. Also, `If-None-Match` header
is sent in the conditional request when `Etag` header is set in the cached
response. Your application can extend the validity of the cache by replying
`HTTP 304 Not Modified`.

## Cache Attributes

### `enabled`

When set to `true`, enable the cache for this route. When set to
`false`, disable the cache for this route.

### `headers`

The `headers` key defines on which values the cache key must depend.

For example, if the `headers` key is the following:

```yaml
cache:
  enabled: true
  headers: ["Accept"]
```

Then Platform.sh will cache a different response for each value of the
`Accept` HTTP request header.

> **note**
> The following request headers cannot be used as cache key:
> `Accept-Encoding`, `Connection`, `Proxy-Authorization`, `TE`, `Upgrade`.

### `cookies`

The `cookies` key define on which values the cache key must depend.

For example:

```yaml
cache:
  enabled: true
  cookies: ["foo"]
```

The cache key will depend on the value of the `foo` cookie in the
request.

A special case exists if the `cookies` key has the `["*"]` value: it
means that any request with a cookie will bypass the cache. This is the
default value.

> **note**
> You can not  use wildcards in the cookie name, either use a precise cookie
> name, or match all cookies with a "*". "SESS*" or "~SESS" are currently
> not valid values.

### `default_ttl`

If the response does not have a `Cache-Control` header, the
`default_ttl` key is used to define the cache duration, in seconds. The
default value is `0`.
