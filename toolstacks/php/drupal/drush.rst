.. _drush:

Work with Drush
===============

Drush is a command-line shell and scripting interface for Drupal, a veritable Swiss Army knife designed to make life easier for those who spend their working hours hacking away at the command prompt. Drush commands can, for example, be used to clear the Drupal cache, run module and database updates, revert features, perform database imports and dumps, and a whole lot more. You can reference the full set of Drush commands at `Drush.org <http://www.drush.org>`_. If you have never used Drush before, you can learn more about it on the `Drush Github Repository <https://github.com/drush-ops/drush#description>`_

Platform.sh uses Drush, so all :term:`environments <environment>` can utilize drush commands in the development process. You can either set up :ref:`Drush aliases <create_drush_aliases>` to easily run drush commands on specific remote Platform :term:`environments <environment>` or you can utilize the :ref:`cli`.

.. note::
  Platform's :ref:`cli` requires **Drush 6 or greater**.

Install Drush
-------------

Install drush with composer:

.. code-block:: console

 $ composer global require 'drush/drush:6.*'

At the end of the installation, you should be able to run:

.. code-block:: console

 $ drush

And see a list of available commands.

.. seealso::
  * `Install Drush <https://github.com/drush-ops/drush>`_

Use drush aliases
-----------------

.. _create_drush_aliases:

Create Drush aliases
^^^^^^^^^^^^^^^^^^^^

Platform utilizes `drush aliases`_ to make it easy to use Drush to manage your development websites. Here's an example of a `drush alias file`_.

.. _drush aliases: https://drupal.org/node/670460
.. _drush alias file: https://github.com/drush-ops/drush/blob/master/examples/example.aliases.drushrc.php

.. note:: The :ref:`cli` generates Drush aliases for you automatically, when you run ``platform get [project_id]``.

If you're not using the :ref:`cli`, navigate to your ``~/.drush`` folder and create a new file called ``platform.aliases.drushrc.php``.

.. code-block:: console

   $ cd ~/.drush
   $ sudo vi platform.aliases.drushrc.php

In your new alias file, you can create aliases for your various Platform.sh projects. For example:

.. code-block:: php

  <?php
  // Platform environment
  $aliases['master'] = array(
    'uri' => 'master-[project-id].eu.platform.sh',
    'root' => '/app/public',
    'remote-host' => 'ssh.eu.platform.sh',
    'remote-user' => '[project-id]-master',
  );
  // Platform branch environment
  $aliases['BRANCHNAME'] = array(
    'uri' => 'BRANCHNAME-[project-id].eu.platform.sh',
    'root' => '/app/public',
    'remote-host' => 'ssh.eu.platform.sh',
    'remote-user' => '[project-id]-BRANCHNAME',
  );
  // Platform local environment
  $aliases['local'] = array(
    'site' => 'platform',
    'env' => 'local',
    'uri' => 'platform',
    'root' => '~/Sites/platform',
  );

Then test your settings to make sure they work.

.. code-block:: console

   $ drush @platform.master status
   Drupal version                  :  7.24
   Site URI                        :  master-[project-id].eu.platform.sh
   Database driver                 :  mysql
   Database username               :
   Database name                   :  main
   Database                        :  Connected
   Drupal bootstrap                :  Successful
   ...

.. _drush_make_files:

Use make files
--------------

Create a make file
^^^^^^^^^^^^^^^^^^

Platform.sh can automatically build your site using make files. This allows you to easily test specific versions, apply patches and keep your site up to date. It also keeps your working directory much cleaner, since it only contains your custom code.

Your make file can be called: ``project.make`` or ``drupal-org.make``.

You can find a nice example make file on `Github <https://github.com/platformsh/platformsh-examples/blob/drupal/7.x/project.make>`_.

When building as a profile, you **need a make file for Drupal core** called: ``project-core.make``:

.. code-block:: console

    api = 2
    core = 7.x

    projects[drupal][type] = core
    
Generate a make file from an existing site
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

If you want to generate a make file from your existing site, you can run:

.. code-block:: console

  $ drush make-generate project.make

This will output a make file containing all your contributed modules, themes and libraries.

.. seealso::
  * `Make generate command <http://www.drushcommands.com/drush-6x/make/make-generate>`_

Apply patches
^^^^^^^^^^^^^

You can apply **contributed patches** to your modules, themes or libraries within your ``project.make``:

.. code-block:: console

   projects[features][version] = "2.2"
   projects[features][patch][] = "https://www.drupal.org/files/issues/alter_overrides-766264-45.patch"

You can also apply **self-hosted patches**. Simply create a ``PATCHES`` folder at the root of your repository and add the patch as follow:

.. code-block:: console
  
   projects[uuid][version] = "1.0-alpha5"
   projects[uuid][patch][] = "PATCHES/fix-non-uuid-entity-load.patch"

Work with DEV version
^^^^^^^^^^^^^^^^^^^^^

When you are using a module that is in a DEV version, the best practice is to always target a specific commit ID so that you're always building the same "version" of the module:

.. code-block:: console
   
   ; CKEditor module: version 7.x-1.15+2-dev
   projects[ckeditor][download][revision] = "b29372fb446b547825dc6c30587eaf240717695c"
   projects[ckeditor][download][type] = "git"
   projects[ckeditor][download][branch] = "7.x-1.x"
   projects[ckeditor][type] = "module"
