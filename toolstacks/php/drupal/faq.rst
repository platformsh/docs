.. _drupal_faq:

Frequently Asked Questions (FAQ)
================================

How should I name my make files?
--------------------------------

In order for Platform to automatically detect your make file, you need to call it **\`project.make\`**.

You can also have a **specific make file for Drupal core** called **\`project-core.make\`**

When I push changes to a make file, does Platform.sh run the update?
--------------------------------------------------------------------

After a push, Platform.sh will rebuild your environment and download all the modules that are in your make file.

If an update function (hook_update) needs to run, you'll have to manually trigger it by going to ``/update.php`` or use the :ref:`deployment hooks <deployment_hooks>` to automatically run the updates.

How can I override the default robots.txt?
------------------------------------------

If your project is using a make file, you will end up with the default ``robots.txt`` provided by Drupal.

On your Development environments, Platform.sh automatically overrides your ``robots.txt`` file with:

.. code-block:: console

    User-agent: *
    Disallow: /

You can customize the ``robots.txt`` by placing your own version at the root of your repository.

I'm getting a PDO Exception 'MySQL server has gone away'
--------------------------------------------------------

Normally, this means there is a problem with the MySQL server container and you may need to increase the storage available to MySQL to resolve the issue. Ballooning MySQL storage can be caused by a number of items:

#) A large number of watchdog entries being captured. Fix the errors being generated or disable database logging.
#) Ensure :ref:`cron runs at regular intervals <crons>` to ensure cache tables get cleared out.
#) If you're using Drupal Commerce Core < 1.10, you may have an `extremely large cache_form table`_. Upgrade to Commerce Core 1.10 to resolve.

.. _`extremely large cache_form table`: https://www.drupal.org/node/2057073

MySQL cannot connect to the database server
-------------------------------------------

If you are having a problem connecting to the database server, you will need force a re-deployment of the database container. To do so, you can edit the :ref:`service definition <services_configuration>` to add or remove a small amount of storage and then push.
