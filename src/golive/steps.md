# Going Live - Steps

Going live on Platform.sh is a simple two or three step process.

<!--toc-->

You can either use the Platform.sh UI or the CLI to configure your project for production. Once you have gone through it once the whole process usually takes a couple of minutes.

> The order of operations is not really important, but if you are migrating a site from an existing provider, you should first configure the domain on the Platform.sh side, and only then switch DNS over.

## 1. Change your plan to a production plan

If you are on a Development plan, you cannot add a domain. You will need to upgrade your subscription to a production plan.

Go to [your account](https://accounts.platform.sh/user), click on the small wheel next to you project's name and click on edit.

![Edit Plan](/images/edit-plan.png)

Choose the plan you want, it will show you the monthly price you will be paying.

![Edit Plan Choose](/images/edit-plan-choose.png)

You can find more information on pricing on the [pricing page](https://platform.sh/pricing/).

## 2. Set your domain in Platform.sh

This is a required step, it will tell the Platform.sh edge layer where to route requests for your web site. You can do this through the CLI with `platform domain:add example.com` or  [using the UI](/administration/web/configure-project.html#domains).

You can add multiple domains to point to your project. Each domain can have its own custom SSL certificate, or use the default one provided.

> **note**
> After you have added your domain, your Master environment will no longer be accessible at `<environment>-<project>.<region>.platform.sh`.  That's why you should write it down first.

If you require access to the site before the domain name becomes active you can create a `hosts` file entry on your computer and point it to the IP address that resolves when you access your master project branch.

To get the IP you can run `ping <environment>-<project>.<region>.platform.sh` (with the DNS name you noted in step 2 of the pre-launch check list). In OS X and Linux this will usually be the hosts file in `/etc/hosts` in Windows `c:\Windows\System32\Drivers\etc\hosts`. You will need to be a admin user to be able to change that file. So in OS X you will usually run something like `sudo vi /etc/hosts`. After adding the line the file will look something like:

 
![Hosts File](/images/hosts-file.png)

> **note**
> Do not put the IP address you see here, but the one you got from the ping command.
> *Also, remember to remove this entry after you have configured DNS!*

Sometimes it can take Let's Encrypt a couple of minutes to provision the certificate the first time. This is normal, and only means the first deploy after enabling a domain may take longer than usual.

## 3. Configure your DNS provider

Configure your DNS provider to point your domain to your Platform.sh Master environment domain name.

The way to do so will vary somewhat depending on your registrar, but nearly all registrars should allow you to set a CNAME.  Some will call it an Alias or similar alternate name, but either way the intent is to say "this domain should always resolve to... this other domain".  Add a CNAME record from your desired domain (`www.example.com`) to the master environment hostname you wrote down earlier.

If you have multiple domains you want to be served by the same application you will need to add a CNAME record for each of them. 

Note that depending on your registrar and the TTL you set, it could take anywhere from 15 minutes to 72 hours for the DNS change to fully propagate across the Internet.

### Configuring Zone Apex / Naked Domain / Root Domain (the one without the www.)

The DNS RFC (RFC1033) requires the "zone apex" (sometimes called the "root domain" or "naked domain") to be an "A Record," not a CNAME. But many DNS providers have found a way around this limitation. If you want your site to be accessible with **https://example.com** and not only **https://www.example.com**  you *must* use a DNS provider that knows how to do that. Examples of such workaround records include:
 
 * ACNAME at [CloudFlare](https://www.cloudflare.com/)
 * ANAME at [easyDNS](https://www.easydns.com/)
 * ANAME at [DNS Made Easy](http://www.dnsmadeeasy.com/)
 * ALIAS at [DNSimple](https://dnsimple.com/)
 * @ records at [PairNIC.com](https://www.pairnic.com/)
 * ALIAS at [PointDNS](https://pointhq.com/)
 
These ALIAS/CNAME/ANAME records resolves on request the IP address of the destination record and serves it as if it would be the IP address for the apex domain requested. If the IP address for the destination changes, the IP address for the mapped domain changes automatically as well.
 
Platform.sh recommends ensuring that your DNS Provider supports dynamic apex domains before registering your domain name with them.  If you are using a DNS Provider that does not support dynamic apex domains then you will be unable to use `example.com` with Platform.sh, and will need to use only `www.example.com` (or similar) instead.
 
Although as a stop-gap measure configuring an `A` Record to one of the public IPs of the region you are hosted in would work, it is highly unrecommended. The IP address of the server may change from time to time, especially with frequent redeployments as in Platform.sh's case which will break your site.

## 4. Bonus steps (Optional)

### Configure health notifications

While not required, it's strongly recommended that you set up [health notifications](/administration/integrations/notifications.md) to advise you if your site is experiencing issues such as running low on disk space.  Notifications can be sent via email, Slack, or PagerDuty.

### Configure production cron tasks

It's strongly recommend that you [set up automatic snapshots](/administration/snapshot-and-restore.md#automated-snapshots) and [automatic certificate renewal](/configuration/routes/https.md#automatic-certificate-renewal) cron tasks.  You will first need to set up an [API token](/gettingstarted/cli/api-tokens.md) and install the CLI as part of the build hook.  Then you can easily configure the appropriate cron tasks.  The following snippet is generally sufficient but see the the links above for more details, and please modify the cron schedules listed to match your use case.

```yaml
crons:
    snapshot:
        # Take a snapshot automatically every night at 3 am (UTC).
        spec: '0 3 * * *'
        cmd: |
            if [ "$PLATFORM_BRANCH" = master ]; then
                platform snapshot:create --yes --no-wait
            fi
    renewcert:
        # Force a redeploy at 9 am (UTC) on the 14th of every month.
        spec: '0 9 14 * *'
        cmd: |
            if [ "$PLATFORM_BRANCH" = master ]; then
                platform variable:set _redeploy "$(date)" --yes --no-wait
            fi
```
