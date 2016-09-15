# Server Side Includes
Server side includes is a powerful mechanism by which you can at the same time
leverage caching.. and serve dynamic content.

You can activate or deactivate SSI on a per-route basis in your
`.platform/routes.yaml` for example:

```yaml
"http://{default}/":
    type: upstream
    upstream: "myapp:http"
    cache:
      enabled: false
    ssi:
        enabled: true
"http://{default}/time.php":
    type: upstream
    upstream: "myapp:http"
    cache:
      enabled: true
```

It allows you to include in your HTML response directives that will make the
server "fill-in" parts of the HTML respecting the caching you setup.

For example you could in a dynamic non-cached page include a block that would
have been cached for example in the /index.php page we would have:

```php
<?php
echo date(DATE_RFC2822);
?>
<!--#include virtual="time.php" -->
```

and in `time.php` we had

```php
<?php
header("Cache-Control: max-age=600");
echo date(DATE_RFC2822);
```

And you visit the home page... you will see, as you refresh the page, the time
on the top will continue to change, while the one on the bottom will only change
every 600 seconds.

You can learn more on the directives on the nginx documentation page:
http://nginx.org/en/docs/http/ngx_http_ssi_module.html
