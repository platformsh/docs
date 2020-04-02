---
title: "Vulnerability Scanning and Penetration Testing"
weight: 10
sidebarTitle: "Security scans"
description: |
  Platform.sh understands the need for application owners to ensure the integrity, and standards compliance, of their applications. Because there could be adverse impacts to other clients which would violate our terms of service, we only permit certain types of tests.
---

## Approved Activities

* Vulnerability scanning of your web application. You are free to perform this as often as required without approval from Platform.sh.
* Web application penetration tests that do not result in high network load.  You are free to perform this as often as required without approval from Platform.sh.

## Approved Activities by Prior Arrangement

* For Platform.sh Enterprise-Dedicated customers we do permit infrastructure penetration testing (but not load testing) by prior arrangement.  This requires special advanced preparation. You must submit a support ticket request a minimum of **three (3) weeks** in advance for us to coordinate this on your behalf.

## Prohibited Activities

* Vulnerability scanning of web applications which you do not own.
* Denial of Service tests and any other type of testing which results in heavy network load.
* Social engineering tests of Platform.sh services including falsely representing yourself as a Platform.sh employee.
* Infrastructure penetration tests for non-Dedicated-Enterprise customers. This includes SSH and database testing.

## Rate Limits

* Please limit scans to a maximum of 20 Mbps and 50 requests per second in order to prevent triggering denial of service bans.

## Troubleshooting

If your vulnerability scanning suggests there may be an issue with Platform.sh's service, please ensure your container is [updated](/security/updates.md) and retest. If the problem remains, please [contact support](/overview/getting-help.md).
