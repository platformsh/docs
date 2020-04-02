---
title: "Going Live - Steps"
weight: 2
sidebarTitle: "Go-live steps"
description: "Going live on Platform.sh is a simple two or three step process.<br><br>You can either use the Platform.sh management console or the CLI to configure your project for production. Once you have gone through it once the whole process usually takes a couple of minutes."
 
layout: single
---
> **note**
>
> The order of operations is not really important, but if you are migrating a site from an existing provider, you should first configure the domain on the Platform.sh side, and only then switch DNS over.

## 1. Change your plan to a production plan

If you are on a Development plan, you cannot add a domain. You will need to upgrade your subscription to a production plan.

Go to [your account](https://accounts.platform.sh/user), click on the small wheel next to you project's name and click on edit.

![Edit Plan](/images/management-console/edit-plan.png "0.3")

You can also access information about the project's plan under "Billing", and then by selecting the project from your list of projects. You can make changes to the project by clicking ‘Upgrade Plan’.

![Edit Plan](/images/management-console/billing-plan-upgrade.png "0.6")

You can make changes to the type of plan, the number of environments, amount of storage and number of users here. When you make changes, it will update the monthly price you will be paying. Click `Upgrade plan` to save the new settings.

![Edit Plan Choose](/images/management-console/settings-upgrade-plan.png "0.6")

You can find more information on pricing on the [pricing page](https://platform.sh/pricing).

## 2. (CDN version) Configure your DNS provider

If you are serving the site through a CDN, configure your DNS provider to point at your CDN account.  The address or CNAME to set for that will vary with the CDN provider.  Refer to their documentation or to the [CDN guide](/golive/cdn.md).

## 2. (Non-CDN version) Configure your DNS provider

Configure your DNS provider to point your domain to your Platform.sh Master environment domain name.

The way to do so will vary somewhat depending on your registrar, but nearly all registrars should allow you to set a CNAME.  Some will call it an Alias or similar alternate name, but either way the intent is to say "this domain should always resolve to... this other domain".

You can access the CNAME target by running `platform environment:info edge_hostname`.  That is the host name by which Platform.sh knows your environment.  Add a CNAME record from your desired domain (`www.example.com`) to the value of the `edge_hostname`.

If you have multiple domains you want to be served by the same application you will need to add a CNAME record for each of them.

Note that depending on your registrar and the TTL you set, it could take anywhere from 15 minutes to 72 hours for the DNS change to fully propagate across the Internet.

If you are using an apex domain (`example.com`), see the additional information about [Apex domains and CNAME records](/golive/steps/dns.md).

## 3. (Non-CDN version) Set your domain in Platform.sh

> **note**
>
> If using a CDN, skip this step.  The CDN should already have been configured in advance to point to Platform.sh as its upstream.

This step will tell the Platform.sh edge layer where to route requests for your web site. You can do this through the CLI with `platform domain:add example.com` or  [using the managment console](/administration/web/configure-project.html#domains).

You can add multiple domains to point to your project. Each domain can have its own custom SSL certificate, or use the default one provided.

If you require access to the site before the domain name becomes active you can create a `hosts` file entry on your computer and point it to the IP address that resolves when you access your master project branch.

To get the IP address, first run `platform environment:info edge_hostname`.  That will print the "internal" domain name for your project.  Run `ping <that domain name>` to get its IP address.

In OS X and Linux you can add that IP  to your `/etc/hosts` file.  In Windows the file is named `c:\Windows\System32\Drivers\etc\hosts`. You will need to be a admin user to be able to change that file. So in OS X you will usually run something like `sudo vi /etc/hosts`. After adding the line the file will look something like:

![Hosts File](/images/config-files/hosts-file.png "0.4")

Alternatively there is also an add-on for Firefox and Google Chrome that allow you to dynamically switch DNS IP addresses without modifying your `hosts` file.

* [Firefox LiveHosts add-on](https://addons.mozilla.org/en-US/firefox/addon/livehosts/)
* [Google Chrome LiveHosts add-on](https://chrome.google.com/webstore/detail/livehosts/hdpoplemgeaioijkmoebnnjcilfjnjdi?hl=en)

> **note**
>
> Do not put the IP address you see here, but the one you got from the ping command.
>
> *Also, remember to remove this entry after you have configured DNS!*

Sometimes it can take Let's Encrypt a couple of minutes to provision the certificate the first time. This is normal, and only means the first deploy after enabling a domain may take longer than usual.  Setting the CNAME record with your DNS provider first helps to minimize that disruption.

## 4. Bonus steps (Optional)

### Configure health notifications

While not required, it's strongly recommended that you set up [health notifications](/administration/integrations/notifications.md) to advise you if your site is experiencing issues such as running low on disk space.  Notifications can be sent via email, Slack, or PagerDuty.

### Configure production cron tasks

It's strongly recommended that you [set up automatic backups](/administration/backup-and-restore.md#automated-backups) and [automatic certificate renewal](/configuration/routes/https.md#automatic-certificate-renewal) cron tasks.  You will first need to set up an [API token](/development/cli/api-tokens.md) and install the CLI as part of the build hook.  Then you can easily configure the appropriate cron tasks.  The following snippet is generally sufficient but see the the links above for more details, and please modify the cron schedules listed to match your use case.

```yaml
crons:
    backup:
        # Take a backup automatically every night at 3 am (UTC).
        spec: '0 3 * * *'
        cmd: |
            if [ "$PLATFORM_BRANCH" = master ]; then
                platform backup:create --yes --no-wait
            fi
    renewcert:
        # Force a redeploy at 8 am (UTC) on the 14th and 28th of every month.
        spec: '0 8 14,28 * *'
        cmd: |
            if [ "$PLATFORM_BRANCH" = master ]; then
                platform redeploy --yes --no-wait
            fi
```
