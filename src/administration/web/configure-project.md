# Project configuration

You can access the configuration page of your project by clicking the
gear icon next to the project name.

![configure project](/images/ui-conf-project.png)

## Settings

The `Settings` screen provides the SSH key that Platform.sh will use
when trying to access external private Git repository during the build
process.

This is useful if you want to reuse some code components accross
multiple projects and manage those components as dependencies of your
project.

![Get the Platform.sh project public SSH key](/images/ui-conf-project-ssh-key.png)

## Users

The `Users` screen allows you to manage users access on your project.

You can invite new users to your project by clicking the `Add user` link
and entering their email address, or modify permissions of existing
users by clicking the `Edit` link when hovering over the user.

![Project configure icon](/images/ui-conf-project-users.png)

> **note**
> Currently, permissions changes that grant or revoke SSH access to an
> environment take effect only after the next time that environment is
> deployed.

Selecting a user will allow you to either edit that user's permissions
or delete the user's access to the project entirely.

![Manage users of your Platform.sh project](/images/ui-conf-project-users-access.png)

If you check the `Super user` box, this user will be an administrator of
the project and will have fulll access on all environments. If you
uncheck the box, you'll have the option of adjusting the user's
permissions on each environment.

> **note**
> The `Account owner` is locked and you can't change its permissions.

## Domains

The `Domains` screen allows you to manage your domains that your project
will be accessible at.

![Manage domains of your Platform.sh project.](/images/ui-conf-project-domains.png)

More information on how to [setup your domain](https://docs.platform.sh/user_guide/using/going-live.html).

> **note**
> Platform.sh expects an ASCII representation of the domain here. In case you want to use an internationalized domain name you can use the [conversion tool provided by Verisign](http://mct.verisign-grs.com/) to convert your IDN domain to ASCII.


