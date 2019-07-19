# Go

Platform.sh supports building and deploying applications written in Go using Go modules.  They are compiled during the Build hook phase, and support both committed dependencies and download-on-demand.

## Supported versions

* 1.11
* 1.12

To specify a Go container, use the `type` property in your `.platform.app.yaml`.

```yaml
type: 'golang:1.12'
```

## Deprecated versions

The following container versions are also available.  However, due to their lack of [Go module](https://golang.org/cmd/go/#hdr-Modules__module_versions__and_more) support and the difficulties in supporting the GOPATH during the Platform.sh build they are not recommended.

* 1.8
* 1.9
* 1.10

## Go modules

The recommended way to handle Go dependencies on Platform.sh is using Go module support in Go 1.11 and later.  That allows the build process to use `go build` directly without any extra steps, and you can specify an output executable file of your choice.  (See the examples below.)

## Platform.sh variables

Platform.sh exposes relationships and other configuration as [environment variables](/development/variables.md).  To make them easier to access you should use the provided [GoHelper library](https://github.com/platformsh/gohelper).  Most notably, it allows a program to determine at runtime what HTTP port it should listen on and what the credentials are to access [other services](/configuration/services.md).

```go
package main

import (
	_ "github.com/go-sql-driver/mysql"
	psh "github.com/platformsh/gohelper"
	"net/http"
)

func main() {

	p, err := psh.NewPlatformInfo()

	if err != nil {
		panic("Not in a Platform.sh Environment.")
	}

	http.HandleFunc("/bar", func(w http.ResponseWriter, r *http.Request) {
		// ...
	})

	http.ListenAndServe(":"+p.Port, nil)
}
```

## Building and running the application

Assuming your `go.mod` and `go.sum` files are present in your repository, the application may be built with a simple `go build` command that will produce a working executable.  You can then start it from the `web.commands.start` directive.  Note that the start command _must_ run in the foreground. Should the program terminate for any reason it will be automatically restarted.

The following basic `.platform.app.yaml` file is sufficient to run most Go applications.

```yaml
name: app

type: golang:1.12

hooks:
    build: |
        # Modify this line if you want to build differently or use an alternate name for your executable.
        go build -o bin/app

web:
    upstream:
        socket_family: tcp
        protocol: http

    commands:
        # If you change the build output in the build hook above, update this line as well.
        start: ./bin/app

    locations:
        /:
            # Route all requests to the Go app, unconditionally.
            # If you want some files served directly by the web server without hitting Go, see
            # https://docs.platform.sh/configuration/app/web.html
            allow: false
            passthru: true

disk: 1024
```

Note that there will still be an Nginx proxy server sitting in front of your application.  If desired, certain paths may be served directly by Nginx without hitting your application (for static files, primarily) or you may route all requests to the Go application unconditionally, as in the example above.

## Accessing services

To access various [services](/configuration/services.md) with Go, see the following examples. The individual service pages have more information on configuring each service.

{% codetabs name="Memcached", type="go", url="https://examples.docs.platform.sh/golang/memcached" -%}

{% language name="MongoDB", type="go", url="https://examples.docs.platform.sh/golang/mongodb" -%}

{% language name="MySQL", type="go", url="https://examples.docs.platform.sh/golang/mysql" -%}

{% language name="PostgreSQL", type="go", url="https://examples.docs.platform.sh/golang/postgresql" -%}

{% language name="RabbitMQ", type="go", url="https://examples.docs.platform.sh/golang/rabbitmq" -%}

{% language name="Solr", type="go", url="https://examples.docs.platform.sh/golang/solr" -%}

{%- endcodetabs %}

## Project templates

Platform.sh offers a project templates for Go applications using the structure described above.  It can be used as a starting point or reference for building your own website or web application.

[Generic Go application](https://github.com/platformsh/template-golang)
