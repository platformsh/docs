---
title: "Migrating to Platform.sh"
weight: 3
 
description: |
  Moving an already-built site to Platform.sh is generally straightforward.  For the most part, the only part that will vary from one framework to another is the details of the Platform.sh configuration files.<br><br>

  See the <a href="/frameworks.html"><b>Featured Frameworks</b></a> section or our <a href="/development/templates.html"><b>Project Templates</b></a> for more project-specific documentation.
---

## Preparation

First, assemble your Git repository as appropriate, on your master branch.  Be sure to include the Platform.sh configuration files, as you will not be able to push the repository to Platform.sh otherwise!

For some applications, such as Drupal you will need to dump configuration to files before proceeding.  You will also need to provide appropriate configuration to read the credentials for your services at runtime and integrate them into your application's configuration.  The details of that integration will vary between systems.  Be sure to see the appropriate project templates for our recommended configuration.

* [Go Templates](/languages/go.md#project-templates)
* [Java Templates](/languages/java.md#project-templates)
* [Node.js Templates](/languages/nodejs.md#project-templates)
* [PHP Templates](/languages/php.md#project-templates)
* [Python Templates](/languages/python.md#project-templates)


In the management console, click `+ Add project` to create a new Platform.sh project. When asked to select a template pick "Create a blank project".

## Push your code

When creating a new project, the management console will provide two commands to copy and paste similar to the following:

```bash
git remote add platform nodzrdripcyh6@git.us.platform.sh:nodzrdripcyh6.git
git push -u platform master
```

The first will add a Git remote for the Platform.sh repository named `platform`.  The name is significant as the Platform.sh CLI will look for either `platform` or `origin` to be the Platform.sh repository, and some commands may not function correctly otherwise.  The second will push your repository's master branch to the Platform.sh master branch.  Note that a project must always start with a master branch, or deploys to any other environment will fail.

When you push, a new environment will be created using your code and the provided configuration files.  The system will flag any errors with the configuration if it can.  If so, correct the error and try again.

## Import your database

You will need to have a dump or backup of the database you wish to start from.  The process is essentially the same for each type of persistent data service.  See the [MySQL](/configuration/services/mysql.md), [PostgreSQL](/configuration/services/postgresql.md), or [MongoDB](/configuration/services/mongodb.md) documentation as appropriate.

## Import your files

Content files (that is, files that are not intended as part of your code base so are not in Git) can be uploaded to your mounts using the Platform.sh CLI or by using `rsync`. You will need to upload each directory's files separately.  Suppose for instance you have the following file mounts defined:

```yaml
mounts:
    'web/uploads':
        source: local
        source_path: uploads
    'private':
        source: local
        source_path: private
```

While using the CLI and rsync are the most common solutions for uploading files to mounts, you can also use [SCP](/development/access-site.md#scp).

### Platform.sh CLI

The easiest way to import files to your project mounts is by using the Platform.sh CLI `mount:upload` command. To upload to each of directories above, we can use the following commands.

```bash
platform mount:upload --mount web/uploads --source ./uploads
platform mount:upload --mount private --source ./private
```

### rsync

You can also use `rsync` to upload each directory.  The `platform ssh --pipe` command will return the SSH URL for the current environment as an inline string that `rsync` can recognize. To use a non-default environment, use the `-e` switch after `--pipe`.  Note that the trailing slash on the remote path means `rsync` will copy just the files inside the specified directory, not the directory itself.

```bash
rsync -az ./private `platform ssh --pipe`:/app/private/
rsync -az ./web/uploads `platform ssh --pipe`:/app/web/uploads
```

> **note**
>
> If you're running `rsync` on MacOS, you should add `--iconv=utf-8-mac,utf-8` to your `rsync` call.

See the [`rsync` documentation](https://download.samba.org/pub/rsync/rsync.html) for more details on how to adjust the upload process.
