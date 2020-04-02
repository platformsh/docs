---
title: "Cron timezone"
weight: 4
sidebarTitle: "Timezone"
---

All Platform.sh containers default to running in UTC time.  Applications and application runtimes may elect to use a different timezone but the container itself runs in UTC.  That includes the `spec` parameter for cron tasks that are defined by the application.

That is generally fine but sometimes it's necessary to run cron tasks in a different timezone.

## Setting the system timezone for cron tasks

The `timezone` property sets the timezone for which the `spec` property of any [cron tasks](/configuration/app/cron.md) defined by the application will be interpreted.  Its value is one of the [tz database region codes](https://en.wikipedia.org/wiki/List_of_tz_database_time_zones) such as `Europe/Paris` or `America/New_York`.  This key will apply to all cron tasks defined in that file.

This entry is only meaningful on cron specs that specify a particular time of day, rather than a "time past each hour".  For example, `25 1 * * *` would run every day at 1:25 am in the timezone specified.

## Setting an application runtime timezone

The application runtime timezone can also be set, although the mechanism varies a bit by the runtime.

* PHP runtime - You can change the timezone by providing a [custom php.ini](/languages/php/ini.md).
* Node.js runtime - You can change the timezone by starting the server with `env TZ='<timezone>' node server.js`.
* Python runtime - You can change the timezone by starting the server with `env TZ='<timezone>' python server.py`.

Setting the application timezone will only affect the application itself, not system operations such as log files.

> **note**
>
> In the vast majority of cases it's best to leave all timezones in UTC and store user data with an associated timezone instead.
