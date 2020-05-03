---
title: "Node.js"
weight: 5
description: |
  Node.js is a popular JavaScript runtime built on Chrome's V8 JavaScript engine.  Platform.sh supports deploying Node.js applications quickly and easily. Using our Multi-App support you can build a micro-service oriented system mixing both Javascript and PHP applications.
layout: single
---

{{< description >}}

## Supported versions

{{< image-versions image="nodejs" status="supported" >}}

If you need other versions, take a look at our [options for installing them with NVM](/languages/nodejs/nvm.html).

## Deprecated versions

Some versions with a minor (such as 8.9) are available but are not receiving security updates from upstream, so their use is not recommended. They will be removed at some point in the future.

{{< image-versions image="nodejs" status="deprecated" >}}

## Support libraries

While it is possible to read the environment directly from your application, it is generally easier and more robust to use the [`platformsh-config`](https://github.com/platformsh/config-reader-nodejs) NPM library which handles decoding of service credential information for you.

## Configuration

To use Platform.sh and Node.js together, configure the `.platform.app.yaml` file with a few key settings, as described here (a complete example is included at the end).

1. Specify the language of your application (available versions are listed above):

    {{< readFile file="src/registry/images/examples/full/nodejs.app.yaml" highlight="yaml" >}}

2. Specify your dependencies under the `nodejs` key, like this:

   ```yaml
   dependencies:
     nodejs:
       pm2: "^2.5.0"
   ```

   These are the global dependencies of your project (the ones you would have installed with `npm install -g`). Here we specify the `pm2` process manager that will allow us to run the node process.

3. Configure the command you use to start serving your application (this must be a foreground-running process) under the `web` section, e.g.:

   ```yaml
   web:
     commands:
       start: "PM2_HOME=/app/run pm2 start index.js --no-daemon"
   ```

   If there is a package.json file present at the root of your repository, Platform.sh will automatically install the dependencies. We suggest including the `platformsh-config` helper npm module, which makes it trivial to access the running environment.

   ```json
   {
     "dependencies": {
       "platformsh-config": "^2.0.0"
     }
   }
   ```

   {{< note >}}
  If using the `pm2` process manager to start your application, it is recommended that you do so directly in `web.commands.start` as described above, rather than by calling a separate script the contains that command. Calling `pm2 start` at `web.commands.start` from within a script, even with the `--no-daemon` flag, has been found to daemonize itself and block other processes (such as backups) with continuous respawns.
   {{< /note >}}

4. Create any Read/Write mounts. The root file system is read only. You must explicitly describe writable mounts. In (3) we set the home of the process manager to `/app/run` so this needs to be writable.

   ```yaml
   mounts:
       run:
           source: local
           source_path: run
   ```

5. Include any relevant commands needed to build and setup your application in the `hooks` section, e.g.:

   ```yaml
   hooks:
     build: |
       npm install
       npm run build
       bower install
   ```

6. Setup the routes to your Node.js application in `.platform/routes.yaml`.

   ```yaml
   "https://{default}/":
     type: upstream
     upstream: "app:http"
   ```

7. (Optional) If Platform.sh detects a `package.json` file in your repository, it will automatically include a `default` [`build` flavor](/configuration/app/build/#build), that will run `npm prune --userconfig .npmrc && npm install --userconfig .npmrc`. You can modify that process to use an alternative package manager by including the following in your `.platform.app.yaml` file:

   ```yaml
   build:
     flavor: none
   ```

   Consult the documentation specific to [Node.js builds](https://docs.platform.sh/configuration/app/build.html#nodejs-default-by-default) for more information.


Here's a complete example that also serves static assets (.png from the `/public` directory):

```yaml
name: node
type: nodejs:12

web:
  commands:
    start: "PM2_HOME=/app/run pm2 start index.js --no-daemon"
    #in this setup you will find your application stdout and stderr in /app/run/logs
  locations:
    "/public":
      passthru: false
      root: "public"
      # Whether to allow files not matching a rule or not.
      allow: true
      rules:
        '\.png$':
          allow: true
          expires: -1
dependencies:
  nodejs:
    pm2: "^2.5.0"
mounts:
   run:
       source: local
       source_path: run
disk: 512
```

## In your application...

Finally, make sure your Node.js application is configured to listen over the port given by the environment (here we use the platformsh helper and get it from `config.port`) that is available in the environment variable ``PORT``.  Here's an example:

```js
// Load the http module to create an http server.
const http = require('http');

// Load the Platform.sh configuration
const config = require('platformsh-config').config();

const server = http.createServer(function (request, response) {
  response.writeHead(200, {"Content-Type": "text/html"});
  response.end("<html><head><title>Hello Node.js</title></head><body><h1><img src='public/js.png'>Hello Node.js</h1><h3>Platform configuration:</h3><pre>"+JSON.stringify(config, null, 4) + "</pre></body></html>");
});

server.listen(config.port);
```

## Accessing services

To access various [services](/configuration/services/) with Node.js, see the following examples.  The individual service pages have more information on configuring each service.

{{< codetabs >}}

---
title=Elasticsearch
file=static/files/fetch/examples/nodejs/elasticsearch
highlight=js
---

<--->

---
title=Memcached
file=static/files/fetch/examples/nodejs/memcached
highlight=js
---

<--->

---
title=MongoDB
file=static/files/fetch/examples/nodejs/mongodb
highlight=js
---

<--->

---
title=MySQL
file=static/files/fetch/examples/nodejs/mysql
highlight=js
---

<--->

---
title=PostgreSQL
file=static/files/fetch/examples/nodejs/postgresql
highlight=js
---

<--->

---
title=Redis
file=static/files/fetch/examples/nodejs/redis
highlight=js
---

<--->

---
title=Solr
file=static/files/fetch/examples/nodejs/solr
highlight=js
---

{{< /codetabs >}}

## Project templates

A number of project templates for Node.js applications and typical configurations are available on GitHub. Not all of them are proactively maintained but all can be used as a starting point or reference for building your own website or web application.

{{< repolist lang="nodejs" >}}
