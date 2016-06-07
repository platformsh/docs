<?php
# Platform.sh will serve static files. We serve this through a PHP script
# in ordrer to have more complex redirection rules for "old" urls


/**
* This function would first try to match the whole path as a subpath
* Then Fallback to just the last part of the url
* Then fallback to the root.
**/
function matchPath($path, $current_urls){
    $location = "/"; // Fallback to root
    foreach ($current_urls as $url) {
        if (stripos($url, $path) !== FALSE ) {
            $location = $url;
            break;
        }
    }
    if ($location=="/"){ 
        // nothing was matched let's try a shorter match
        $path = basename($path);
        foreach ($current_urls as $url) {
            if (stripos($url, $path) !== FALSE ) {
                $location = $url;
                break;
            }
        }
    };
    if ($location == $path){$location = "/";}; // Prevent redirect loops
    return $location;
}

$path = parse_url($_SERVER['REQUEST_URI']);

$path = ltrim(rtrim($path["path"], '/'), '.'); //trim trailing slash and prefix dots
$index = realpath(getcwd() .$path ."/index.html");
if (substr($index, 0, strlen(realpath(getcwd()))) === realpath(getcwd()) && file_exists($index)){
    header("Cache-Control: public, max-age=300");
    readfile($index);
} else { 
  $current_urls = [
  "/discover",
  "/discover/overview/cli",
  "/discover/overview/getting-help.html",
  "/discover/overview/web-ui",
  "/discover/reference/architecture.html",
  "/drupal",
  "/drupal/guides",
  "/drupal/guides/account/subscribe.html",
  "/drupal/guides/getting-started/activity-stream-first-deployment-success-backup.html",
  "/drupal/guides/getting-started/add-ssh-key.html",
  "/drupal/guides/getting-started/choose-stack.html",
  "/drupal/guides/getting-started/choose-starting-point-new-site.html",
  "/drupal/guides/getting-started/new-project.html",
  "/drupal/guides/local",
  "/drupal/guides/local/create-environment.html",
  "/drupal/guides/local/directory-structure.html",
  "/drupal/guides/local/get-project.html",
  "/drupal/guides/local/merge.html",
  "/drupal/guides/local/webserver-database.html",
  "/drupal/guides/prerequisites/platform-cli.html",
  "/drupal/guides/prerequisites/requirements.html",
  "/drupal/guides/type/php/composer/install.html",
  "/drupal/guides/type/php/composer/linux.html",
  "/drupal/guides/type/php/composer/osx.html",
  "/drupal/guides/type/php/composer/windows.html",
  "/drupal/guides/type/php/drupal/activity-stream-first-deployment-in-progress.html",
  "/drupal/guides/type/php/drupal/activity-stream-first-deployment-success-drupal-finish.html",
  "/drupal/guides/type/php/drupal/activity-stream-first-deployment-success-drupal.html",
  "/drupal/guides/type/php/drupal/activity-stream-first-deployment-success.html",
  "/drupal/guides/type/php/drupal/advanced-use-cases.html",
  "/drupal/guides/type/php/drupal/build-modes",
  "/drupal/guides/type/php/drupal/build-modes/local-build.html",
  "/drupal/guides/type/php/drupal/build-modes/profile.html",
  "/drupal/guides/type/php/drupal/build-modes/project.html",
  "/drupal/guides/type/php/drupal/build-modes/vanilla.html",
  "/drupal/guides/type/php/drupal/change-make-add-theme.html",
  "/drupal/guides/type/php/drupal/change-make-file-activate-theme.html",
  "/drupal/guides/type/php/drupal/change-make-file-checkout.html",
  "/drupal/guides/type/php/drupal/change-make-file-commit-push.html",
  "/drupal/guides/type/php/drupal/change-make-file-envs.html",
  "/user_guide/reference/toolstacks/php/drupal/drush.html",
  "/drupal/guides/type/php/drupal/drush.html",
  "/drupal/guides/type/php/drupal/drush-aliases.html",
  "/drupal/guides/type/php/drupal/local-settings-php.html",
  "/drupal/guides/type/php/drupal/settings-php.html",
  "/drupal/guides/type/php/drupal/setup/choose-stack-drupal-drupal7.html",
  "/drupal/guides/type/php/drupal/setup/choose-stack-drupal.html",
  "/drupal/guides/type/php/drupal/setup/get-started.html",
  "/drupal/guides/type/php/drupal/setup/name-project.html",
  "/drupal/guides/type/php/drupal/setup/start-new-site.html",
  "/drupal/guides/type/php/drupal/sql-sync.html",
  "/drupal_migrate",
  "/drupal_migrate/guides",
  "/drupal_migrate/guides/account/subscribe.html",
  "/drupal_migrate/guides/configuration",
  "/drupal_migrate/guides/configuration/drupal_application.html",
  "/drupal_migrate/guides/configuration/drupal_services.html",
  "/drupal_migrate/guides/getting-started/add-ssh-key.html",
  "/drupal_migrate/guides/getting-started/choose-starting-point-import-site.html",
  "/drupal_migrate/guides/getting-started/import-code-done.html",
  "/drupal_migrate/guides/getting-started/import-code.html",
  "/drupal_migrate/guides/getting-started/new-project.html",
  "/drupal_migrate/guides/local/git-initialize-repository.html",
  "/drupal_migrate/guides/local/git-push-code.html",
  "/drupal_migrate/guides/prerequisites/platform-cli.html",
  "/drupal_migrate/guides/prerequisites/requirements.html",
  "/drupal_migrate/guides/type/php/composer/install.html",
  "/drupal_migrate/guides/type/php/composer/linux.html",
  "/drupal_migrate/guides/type/php/composer/osx.html",
  "/drupal_migrate/guides/type/php/composer/windows.html",
  "/drupal_migrate/guides/type/php/drupal/drush.html",
  "/drupal_migrate/guides/type/php/drupal/migrate/import-database.html",
  "/drupal_migrate/guides/type/php/drupal/migrate/import-files.html",
  "/drupal_migrate/guides/type/php/drupal/migrate/init.html",
  "/drupal_migrate/guides/type/php/drupal/rebuild-site-registry.html",
  "/drupal_migrate/guides/type/php/drupal/setup/name-project.html",
  "/symfony/guides",
  "/symfony/guides/account/subscribe.html",
  "/symfony/guides/getting-started/add-ssh-key.html",
  "/symfony/guides/getting-started/choose-stack.html",
  "/symfony/guides/getting-started/new-project.html",
  "/symfony/guides/prerequisites/platform-cli.html",
  "/symfony/guides/prerequisites/requirements.html",
  "/symfony/guides/type/php/composer/install.html",
  "/symfony/guides/type/php/composer/linux.html",
  "/symfony/guides/type/php/composer/osx.html",
  "/symfony/guides/type/php/composer/windows.html",
  "/symfony/guides/type/php/symfony",
  "/symfony/guides/type/php/symfony/activity-stream-first-deployment-success-symfony.html",
  "/symfony/guides/type/php/symfony/choose-stack-symfony-base-standard.html",
  "/symfony/guides/type/php/symfony/choose-stack-symfony.html",
  "/symfony/guides/type/php/symfony/name-project.html",
  "/user_guide",
  "/user_guide/overview/configuring-project-environments.html",
  "/user_guide/overview/environments.html",
  "/user_guide/overview/technical-requirements.html",
  "/user_guide/overview/web-ui/configure-environment.html",
  "/user_guide/overview/web-ui/configure-project.html",
  "/user_guide/reference/cache.html",
  "/user_guide/reference/configuration-files.html",
  "/user_guide/reference/email.html",
  "/user_guide/reference/environment-variables.html",
  "/user_guide/reference/faq/known-issues.html",
  "/user_guide/reference/overview/web-ui/configure-environment.html",
  "/user_guide/reference/platform-app-yaml-multi-app.html",
  "/user_guide/reference/platform-app-yaml.html",
  "/user_guide/reference/protective-block.html",
  "/user_guide/reference/public-ip-addresses.html",
  "/user_guide/reference/rest-api.html",
  "/user_guide/reference/routes-yaml.html",
  "/user_guide/reference/services-yaml.html",
  "/user_guide/reference/toolstacks/php",
  "/user_guide/reference/toolstacks/php/drupal",
  "/user_guide/reference/toolstacks/php/drupal/customizing-settings-php.html",
  "/user_guide/reference/toolstacks/php/drupal/developing-with-drupal.html",
  "/user_guide/reference/toolstacks/php/drupal/faq.html",
  "/user_guide/reference/toolstacks/php/drupal/migrate-existing-site.html",
  "/user_guide/reference/toolstacks/php/drupal/redis-drupal-6.html",
  "/user_guide/reference/toolstacks/php/drupal/redis-drupal-7.html",
  "/user_guide/reference/toolstacks/php/drupal/redis.html",
  "/user_guide/reference/toolstacks/php/drupal/solr.html",
  "/user_guide/reference/toolstacks/php/symfony",
  "/user_guide/reference/toolstacks/php/symfony/faq.html",
  "/user_guide/reference/toolstacks/php/symfony/migrate-existing-site.html",
  "/user_guide/reference/upgrade",
  "/user_guide/using",
  "/user_guide/using/backup-and-restore.html",
  "/user_guide/using/going-live.html",
  "/user_guide/using/integrations",
  "/user_guide/using/integrations/bitbucket.html",
  "/user_guide/using/integrations/blackfire.html",
  "/user_guide/using/integrations/github.html",
  "/user_guide/using/integrations/hipchat.html",
  "/user_guide/using/integrations/webhooks.html",
  "/user_guide/using/overview/web-ui",
  "/user_guide/using/overview/web-ui/configure-project.html",
  "/user_guide/using/private-repository.html",
  "/user_guide/using/set-up-local-development.html",
  "/user_guide/using/use-SSH.html",
  "/user_guide/using/user-administration.html",
  ];
    header('Location: ' . matchPath($path, $current_urls), TRUE, 301);
}
