# Work with Drush

Drush is a command-line shell and scripting interface for Drupal, a
veritable Swiss Army knife designed to make life easier for those who
spend their working hours hacking away at the command prompt. Drush
commands can, for example, be used to clear the Drupal cache, run module
and database updates, revert features, perform database imports and
dumps, and a whole lot more. You can reference the full set of Drush
commands at [Drush.org](http://www.drush.org). If you have never used
Drush before, you can learn more about it on the [Drush GitHub
Repository](https://github.com/drush-ops/drush#description)

Platform.sh has Drush installed by default, so all environments can utilize Drush commands in the development process. You can use the CLI to set up Drush aliases, to easily run Drush commands on
specific remote Platform.sh environments.

> **note**
> Platform's CLI requires **Drush 6 or greater**.

## Install Drush locally

Install drush with Composer:

```bash
$ composer global require drush/drush
```

At the end of the installation, you should be able to run:

```bash
$ drush
```

And see a list of available commands.

You can also install Drush as part of your application, by running the following command in your application root:

```bash
$ composer require drupal/drush
```

drush will then be available at vendor/bin/drush, in the exact same version on your local system and on Platform.sh.

> -   [Install Drush](https://github.com/drush-ops/drush)

## Use drush aliases

### Create Drush aliases

[Drush aliases](http://drush.readthedocs.org/en/master/usage/index.html#site-aliases) make it easy to manage your development websites. Here's an
example of a [Drush alias
file](https://github.com/drush-ops/drush/blob/master/examples/example.aliases.drushrc.php).

The CLI generates Drush aliases for you automatically, when you run `platform get [project_id]`. To see the aliases that are created, run `platform drush-aliases` and you should get output similar to that below:

```bash
$ platform drush-aliases
Aliases for My Site (tqmd2kvitnoly):
    @my-site._local
    @my-site.master
    @my-site.staging
    @my-site.sprint1
```
