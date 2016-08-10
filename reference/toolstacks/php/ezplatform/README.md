# Getting started

## Prerequisites

**Composer**

Composer is a tool for dependency management in PHP. It allows you to
declare the dependent libraries your project needs and it will install
them in your project for you.

> -   [Install Composer](https://getcomposer.org/download/)

## Configure your app

Make sure your `.platform.app.yaml` is specific to eZ Platform.

An eZ Platform specific `.platform.app.yaml` file would look like this:

```bash
type: php
build:
    flavor: symfony

web:
    locations:
        "/":
            root: "web"
            passthru: "/index.php"
mounts:
    "/app/cache": "shared:files/cache"
    "/app/logs": "shared:files/logs"

hooks:
    build: "./app/console cache:warmup"
```
