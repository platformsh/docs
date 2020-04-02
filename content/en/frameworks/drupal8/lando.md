---
title: "Using Lando for local Drupal development"
weight: 8
sidebarTitle: "Lando "
 
description: |
  <a href="/gettingstarted/local/lando.md">Lando</a> is a local development platform that works well with Platform.sh.  Once installed locally it is a simple matter to create an approximate equivalent of your Platform.sh environment for development.<br><br>

  If using Drupal 8 there is a <a href="https://docs.devwithlando.io/tutorials/drupal8.html"><code>drupal8</code></a> recipe available that is a good starting point for your site.
---

## Setting up the Lando environment

```bash
# Download your project.
platform get <projectId>
cd <projectId>

# Create a basic Drupal 8 Lando config file.
lando init --recipe drupal8

# Commit the Lando config file to your repository.
git add .lando.yml
git commit -m "Add Lando configuration"
```

You can now customize the configuration file as needed.  In addition to the [general recommendations](/gettingstarted/local/lando.md#lando-yml-configuration) for all Lando-with-Platform.sh sites the following additions are recommended for Drupal 8:

```yaml
# Name the application the same as in your .platform.app.yaml.
name: app
recipe: drupal8

config:
  # Enable XDebug for local development.
  xdebug: true

  # If you are providing a custom php.ini configuration for Platform.sh, specifying
  # the same file here will allow the one file to drive both environments.
  conf:
    php: php.ini
```

Once the configuration file is set, you should start Lando running:

```bash
lando start

# To download dependencies.
lando composer install
```

## Setting up Drupal for Lando

The Platform.sh environment variables are not available in Lando, but Lando provides its own alternates.  To connect Drupal to the database add the following to your `web/sites/default/settings.local.php` file:

```php
$databases['default']['default'] = [
  'driver' => 'mysql',
  'database' => getenv('DB_NAME'),
  'username' => getenv('DB_USER'),
  'password' => getenv('DB_PASSWORD'),
  'host' => getenv('DB_HOST'),
  'port' => getenv('DB_PORT'),
];
```

If you need to add additional services (Redis cache, Solr, Elasticsearch, etc.) see the [Lando documentation](https://docs.lndo.io/config/services.html).  Place any additional configuration necessary for those in the `settings.local.php` file as well.

## Downloading data from Platform.sh to Lando

Assuming you're using a standard Drupal 8 configuration, the following commands will fully synchronize the SQL database and uploaded files to your local system.  First, make sure the git branch you have checked out is the environment you want to synchronize from.  Then run the following from the repository root:

```bash
# Download a database backup and import it into Lando.
platform db:dump --gzip -f database.sql.gz
lando db-import database.sql.gz

# Download all user files locally, skipping those already found locally.
rsync -az `platform ssh --pipe`:/app/web/sites/default/files/ ./web/sites/default/files/
rsync -az `platform ssh --pipe`:/app/private/ ./private/
```

If you have customized the file mounts in your `.platform.app.yaml` file then update the `rsync` commands accordingly.
