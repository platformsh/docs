---
title: "RabbitMQ (Message Queue service)"
weight: 10
description: "RabbitMQ is an open source message broker software (sometimes called message-oriented middleware) that implements the Advanced Message Queuing Protocol (AMQP).<br><br>See the <a href=\"http://www.rabbitmq.com/documentation.html\">RabbitMQ documentation</a> for more information."
 
sidebarTitle: "RabbitMQ"
---

## Supported versions

* 3.5
* 3.6
* 3.7

## Relationship

The format exposed in the `$PLATFORM_RELATIONSHIPS` [environment variable](/development/variables.md#platformsh-provided-variables):

{{< highlight json >}}
{{< remote url="https://examples.docs.platform.sh/relationships/rabbitmq" >}}
{{< /highlight >}}

## Usage example

In your `.platform/services.yaml`:

{{< highlight yaml >}}
{{< readFile file="content/en/registry/images/examples/full/rabbitmq.services.yaml" >}}
{{< /highlight >}}

In your `.platform.app.yaml`:

{{< highlight yaml >}}
{{< readFile file="content/en/registry/images/examples/full/rabbitmq.app.yaml" >}}
{{< /highlight >}}

You can then use the service in a configuration file of your application with something like:

{{< tabs "Go" "Java" "PHP" "Python" >}}

{{< tab id="Go" active="true" >}}
{{< highlight go >}}
{{< readFile file="static/files/fetch/examples/golang/rabbitmq" >}}
{{< /highlight >}}
{{< /tab >}}

{{< tab id="Java" >}}
{{< highlight java >}}
{{< readFile file="static/files/fetch/examples/java/rabbitmq" >}}
{{< /highlight >}}
{{< /tab >}}

{{< tab id="PHP">}}
{{< highlight php >}}
{{< readFile file="static/files/fetch/examples/php/rabbitmq" >}}{{< /highlight >}}
{{< /tab >}}

{{< tab id="Python" >}}
{{< highlight python >}}
{{< readFile file="static/files/fetch/examples/python/rabbitmq" >}}
{{< /highlight >}}
{{< /tab >}}

{{< /tabs >}}

(The specific way to inject configuration into your application will vary. Consult your application or framework's documentation.)

## Connecting to RabbitMQ

### From your local development environment

For debugging purposes, it's sometimes useful to be able to directly connect to a service instance. You can do this using SSH tunneling. To open a tunnel, log into your application container like usual, but with an extra flag to enable local port forwarding:

```bash
ssh -L 5672:mq.internal:5672 <projectid>-<branch_ID>@ssh.eu.platform.sh
```

Within that SSH session, use the following command to pretty-print your relationships. This lets you see which username and password to use, and you can double check that the remote service's port is 5672.

```bash
php -r 'print_r(json_decode(base64_decode($_ENV["PLATFORM_RELATIONSHIPS"])));'
```

If your service is running on a different port, you can re-open your SSH session with the correct port by modifying your `-L` flag: `-L 5672:mq.internal:<remote port>`.

Finally, while the session is open, you can launch a RabbitMQ client of your choice from your local workstation, configured to connect to `localhost:5672` using the username and password you found in the relationship variable.

### Access the management plugin  (Web UI)
In case you want to access the browser-based UI, you have to use an SSH tunnel. To open a tunnel, log into your application container like usual, but with an extra flag to enable local port forwarding:

```bash
ssh -L 15672:mq.internal:15672 <projectid>-<branch_ID>@ssh.eu.platform.sh
```

After you successfully established a connection, you should be able to open http://localhost:15672 in your browser. You'll find the credentials like mentioned above.

### From the application container

The application container currently doesn't include any useful utilities to connect to RabbitMQ with. However, you can install your own by adding a client as a dependency in your `.platform.app.yaml` file.

For example, you can use [amqp-utils](https://github.com/dougbarth/amqp-utils/) by adding this:

 ```yaml
dependencies:
  ruby:
    amqp-utils: "0.5.1"
```

Then, when you SSH into your container, you can simply type any `amqp-` command available to manage your queues.
