# Getting Started

## Structure your files

Platform.sh is very flexible and allows you to structure your files as
you wish within your Git repository, and will build your project based
on how your files are organized.

Here are the three build modes that can be used:

-   **Profile**: Platform.sh builds your project like Drupal.org does
    for distributions.
-   **Project**: Platform.sh builds your make file using *drush make*.
    You don't need any Drupal core files nor any contributed modules,
    themes or libraries within your Git repository.
-   **Vanilla**: Platform.sh builds your project as it is in your Git
    repository. You can push all Drupal files and contributed modules,
    themes or libraries.

### Profile mode

If your repository contains a `.profile` file, Platform.sh builds your
project in profile mode. This is similar to what Drupal.org does to
build distributions. Everything you have in your repository will be
copied to your `profiles/[name]` folder.

This build mode supports having a `project.make` file for your
contributed modules, themes or libraries.

> **note**
> When building as a profile, you **need a make file for Drupal core** called: `project-core.make`. See
[drush make files](/frameworks/drupal7/drush.md)

```
.git/
project.make
project-core.make
my_profile.info
my_profile.install
my_profile.profile
modules/
  features/
    my_feature_01/
    ...
  custom/
    my_custom_module/
    ...
themes/
  custom/
    my_custom_theme/
    ...
libraries/
  custom/
    my_custom_libraries/
    ...
translations/
  ...
```

### Project mode

If your repository doesn’t contain a `.profile` file, but contains a
make file called: `project.make` (or even `drupal-org.make`),
Platform.sh builds your project using Drush make. Everything you have in
your repository will be copied to your `sites/default` folder.

```
.git/
project.make
modules/
  features/
    my_feature_01/
    ...
  custom/
    my_custom_module/
    ...
themes/
  custom/
    my_custom_theme/
    ...
libraries/
  custom/
    my_custom_libraries/
    ...
translations/
  ...
```

### Vanilla mode

Platform.sh accepts your project's files. You are expected to have an
`index.php` file at the root of your repository.

```
.git/
index.php
... (other Drupal core files)
sites/
  all/
    modules/
    themes/
  default/
```

## Configuring Platform.sh for Drupal

The ideal `.platform.app.yaml` file will vary from project project, and you are free to customize yours as needed.  A recommended baseline Drupal 7 configuration is listed below, and can also be found in our [Drupal 7 template project](https://github.com/platformsh/platformsh-example-drupal7).

{% codesnippet "https://raw.githubusercontent.com/platformsh/platformsh-example-symfony/2.8/.platform.app.yaml", language="yaml" %}{% endcodesnippet %}

