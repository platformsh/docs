---
title: "Custom sizing"
weight: 3
sidebarTitle: "Size"
---

{{< note >}}
These are advanced settings and should only be used by experienced Platform.sh users.  99.9% of the time our default container sizes are the correct choice for best performance.
{{< /note >}}

By default, Platform.sh will automatically select appropriate resource sizes (CPU and memory) for a container when it's deployed, based on the plan size and the number of other containers in the cluster.  The more containers in a project the fewer resources each one gets, and vice versa, with similar containers getting similar resources.

Usually that's fine, but sometimes it's undesirable.  You may, for instance, want to have a queue worker container that you know has low memory and CPU needs, so it's helpful to give that one fewer resources and another container more.  Or a given service may be very heavily used in your architecture so it needs all the resources it can take.  In those cases you can provide sizing hints to the system on a per-service basis.

Every application container as well as every service in `.platform/services.yaml` supports a `size` key, which instructs the system how many resources to allocate to it.  The exact CPU and memory allocated will depend on the application or service type, and we may adjust these values over time to better optimize resource usage.

Legal values for the `size` key are `AUTO` (the default), `S`, `M`, `L`, `XL`, `2XL`, `4XL`.

Note that in a development environment this value is ignored and always set to `S`.  It will only take effect in a production deployment (a master branch with an associated domain).  If the total resources requested by all apps and services is larger than what the plan size allows then a production deployment will fail with an error.

## How do I make a background processing container smaller to save resources?

Simply set the `size` key to `S` to ensure that the container gets fewer resources, leaving more to be allocated to other containers.

```yaml
name: processing

type: nodejs:6.11
size: S

...
```
