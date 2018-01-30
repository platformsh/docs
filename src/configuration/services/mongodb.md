# MongoDB (Database service)

MongoDB is a cross-platform, document-oriented database.

For more information on using MongoDB, see [MongoDB's own documentation](https://docs.mongodb.com/manual/).

## Supported versions

* 3.0

## Relationship

The format exposed in the ``$PLATFORM_RELATIONSHIPS`` [environment variable](/development/variables.md#platformsh-provided-variables):

```json
{
   "database" : [
      {
         "scheme" : "mongodb",
         "path" : "main",
         "port" : 27017,
         "query" : {
            "is_master" : true
         },
         "rel" : "mongodb",
         "password" : "main",
         "username" : "main",
         "ip" : "123.123.123.123",
         "host" : "database.internal"
      }
   ]
}
```

## Usage example

In your `.platform/services.yaml`:

```yaml
mydatabase:
    type: mongodb:3.0
    disk: 1024
```

In your `.platform.app.yaml`:

```yaml
relationships:
    database: "mydatabase:mongodb"
```

You can then use the service in a configuration file of your application with something like:

{% codetabs name="PHP", type="php" -%}
<?php
$relationships = getenv('PLATFORM_RELATIONSHIPS');
if (!$relationships) {
  return;
}

$relationships = json_decode(base64_decode($relationships), TRUE);

foreach ($relationships['database'] as $endpoint) {
  if (empty($endpoint['query']['is_master'])) {
    continue;
  }
  $container->setParameter('mongodb_server', $endpoint['scheme'] . '://' . $endpoint['ip'] . ':' . $endpoint['port']);
  $container->setParameter('database_name', $endpoint['path']);
  $container->setParameter('database_user', $endpoint['username']);
  $container->setParameter('database_password', $endpoint['password']);
}
{%- language name="JavaScript", type="js" -%}
var config= require("platformsh").config();
var db = config.relationships.database[0];
var url = db["scheme"] + '://' + db["username"] + ':' + db['password']+ "@" + db['ip']+ ":" + db['port']+ '/' + db['path'];

var MongoClient = require('mongodb').MongoClient
  , assert = require('assert');

// Use connect method to connect to the server
MongoClient.connect(url, function(err, db) {
  assert.equal(null, err);
  console.log("Connected successfully to server");

  db.close();
});
{%- endcodetabs %}

## Exporting data

The most straightforward way to export data from a MongoDB database is to open an SSH tunnel to it and simply export the data directly using MongoDB's tools.  

First, open an SSH tunnel with the Platform.sh CLI:

```bash
platform tunnel:open
```

That will open an SSH tunnel to all services on your current environment, and produce output something like the following:

```text
SSH tunnel opened on port 30000 to relationship: mongodb
SSH tunnel opened on port 30001 to relationship: redis
```

The port may vary in your case.  Then, simply connect to that port locally using `mongodump` (or your favorite MongoDB tools) to export all data in that server:

```bash
mongodump --port 30000
```
