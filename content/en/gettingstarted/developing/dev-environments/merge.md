---
title: "Merge into production"
weight: 3
---

# Development Environments

## Merge into production

Now that you've had the chance to verify that your application built and deployed correctly on your development environment, you're ready to merge it into your production site. Platform.sh provides [backup](/administration/backup-and-restore.md) features that protect against any unforeseen consequences of your merges, keeping a historical copy of all of your code and data.

{{< asciinema src="videos/asciinema/snap-merge-restore.cast" >}}

> **Note:** The `--project` flag is not needed if you are running the `platform` command from within your local repository.

1. **Create a backup**

    Before you merge the `dev` feature into `master`, create a [backup](/administration/backup-and-restore.md) of the `master` environment. The backup will preserve both the code and all of its data.

    ```bash
    platform backup --project <project id>
    ```

    Select `master` as the environment you want to back up.

2. **Merge feature into production**

    ```bash
    git checkout master
    git merge dev
    git push
    ```

    When the build process completes, verify that your changes have been merged.

    ```bash
    platform url
    ```

3. **Restore a backup**

    If you would like to restore the code and data to the time of your backup, use the command

    ```bash
    platform backup:restore --project <project id>
    ```

{{< navbuttons next="I have merged the new feature">}}
