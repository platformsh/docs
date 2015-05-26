Developing with Drupal
======================

Push changes to an environment
------------------------------
Here, we'll see how to make code changes to an :term:`environment`.

.. note::
  You should never be working on the :term:`Master` branch since it's supposed to be your production environment.

Make sure you're on a working :term:`environment`. In this example we're on the *sprint1* branch:

.. code-block:: console

   $ git branch
   * sprint1

Now that you're set up on your working branch, you can start developing on your website by making code changes and pushing those changes to Platform to test them live.

There are three common ways you will be making code changes to Platform:

1. Add contributed modules, themes, distributions, third-party libraries in the :term:`make file`
2. Create custom code (*modules, themes, profiles, libraries*) and commit them to your Platform codebase
3. Modify the services grid configuration



Add contributed projects
^^^^^^^^^^^^^^^^^^^^^^^^
Each time you push a commit, Platform.sh will rebuild your environment and run the :term:`Drush` make command if a proper make file has been found.

.. seealso::
   * `Working with make files <http://drushmake.me/>`_

Add a Drupal module
+++++++++++++++++++
Each Drupal module you want to install on your project should be included in the :term:`make file`. For example, if you want to add Drupal Commerce, you need to add the following lines to your ``project.make``:

.. code-block:: ini

  ; Modules
  projects[addressfield][version] = "1.0-beta4"
  projects[addressfield][subdir] = "contrib"

  projects[ctools][version] = "1.3"
  projects[ctools][subdir] = "contrib"

  projects[commerce][version] = "1.8"
  projects[commerce][subdir] = "contrib"

  projects[entity][version] = "1.2"
  projects[entity][subdir] = "contrib"

  projects[rules][version] = "2.6"
  projects[rules][subdir] = "contrib"

  projects[views][version] = "3.7"
  projects[views][subdir] = "contrib"

Add a Drupal theme
++++++++++++++++++
You'd do the same if you want to add a theme.  Add the following lines to your ``project.make``:

.. code-block:: ini

   ; Zen Theme
   projects[] = zen

Add a third-party library
+++++++++++++++++++++++++
You'd do the same if you want to add a third-party library. For our example here, we're adding the HTML5 Boilerplate library. Add the following lines to your ``project.make``:

.. code-block:: ini

   ; Libraries
   libraries[html5bp][download][type] = "file"
   libraries[html5bp][download][url] = "http://github.com/h5bp/html5-boilerplate/zipball/v3.0.2stripped"

Add custom code
^^^^^^^^^^^^^^^
To commit your custom modules, themes or libraries, you need to commit them under a ``modules``, ``themes`` or ``libraries`` folder at the root of your Git repository.

.. code-block:: console

   $ ls
     libraries/
     modules/
     project.make
     themes/

When you push your code, Platform will build your environment and move your modules, themes, libraries to the correct location on your site (usually ``sites/default/``).

Change the services configuration
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
You can change and define the topology of the services used in an environment, by modifying the configuration files.

This means that you're able to define and configure the services you want to use.

.. seealso::
  * :ref:`service_grid`

Push your changes
^^^^^^^^^^^^^^^^^
When you're done, commit your changes to test them on your online :term:`environment`.

.. code-block:: console

   $ git add .
   $ git commit -m "Made changes to my make file."
   $ git push

You will see that Platform has found a :term:`make file` and is starting to rebuild your :term:`environment`.

When it's completed, you can see your changes on your site by clicking ``View this website`` under the name of **Sprint1** environment on the :term:`Platform UI`.

.. note::
  * The Drush Make processing doesn't create any file in your Git repository. Your Git repository is the *input* of the process and not the *output*. You can see the directory structure that has been created by connecting via SSH to the :term:`environment`. See the information in the ``Access information`` below the title of the :term:`environment`

Merge code changes to Master
----------------------------
Once you've got a branch with some changes, you'll want to be able to push those changes up to your live environment. Platform has a great button called ``Merge`` that you can click on and it will push the appropriate changes to master.

.. image:: images/merge.png
   :alt: Merge your changes.

Just click on the "Merge" button and all of the commits you made on your branch will be merged into the master environment.

.. seealso::
    `Branch an environment <platform/platform-quick-start-guide/001-mastering-the-basics.html#branch-an-environment>`_

Synchronizing data
------------------

The easiest way to do that is to use Drush and the sql-sync command. You'll need to have :ref:`create_drush_aliases` setup for both your Platform.sh site and your local site. If you are using the :ref:`cli`  and you've run ``platform get [platform_id]`` for a project, then your Drush aliases have already been set up.

With the :ref:`create_drush_aliases` (depending on how yours are set up), you could use a command similar to this:

.. code-block:: console

   $ drush sql-sync @platform.master @platform.local

An alternate method that is appropriate for larger databases is to use the pipe `|` to stream the data, instead of making copies.

.. code-block:: console

   $ drush @platform.master sql-dump | drush @platform.local sqlc
