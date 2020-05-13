---
title: "Compliance guidance"
weight: 9

description: |
  Platform.sh has many PCI and SOC 2 certified customers using our services. Some requirements are the responsibility of the host and others are the responsibility of the application developer.
---

{{< description >}}

Basic compliance questions can be handled by our support team via a ticket. For more advanced questions or walk-through of a full audit please contact your Platform.sh Account Manager.

## Overview

Platform.sh provides a Platform as a Service (PaaS) solution which our customers may use for applications requiring PCI compliance.

{{< note >}}
Cardholder processing activity is discouraged. Please use a third party processor.
{{< /note >}}

## Security & Compensating Controls

* For a list of security measures, please see our [Security page](https://platform.sh/security).

* Please take note that customer environments are deployed in a read-only instance, segregated with GRE and IPSEC tunnels, which often permits compensating controls to be claimed for several PCI requirements.

* Because customers can use our PaaS in a variety of ways, the best approach with auditors is to focus is on “What do I, the customer, control/configure and how is it managed in a compliant manner?”

## Responsibility

Platform.sh and customers have shared responsibility for ensuring an up to date and secure system.  Compliance is ultimately the responsibility of the customer, however.

Platform.sh is responsible for:

* **Physical and Environmental controls** - We use third party hosting and thus these requirements are passed through to those providers (e.g. AWS).
* **Patch Management** - Platform.sh is responsible for patching and fixing underlying system software, management software, and environment images.
* **Configuration Management** - Platform.sh maintains the configuration of its infrastructure and devices.
* **Awareness and Training** - Platform.sh trains its own employees in secure software development and management.
* **Capacity Management** - Platform.sh is responsible for capacity management of the infrastructure, such as server allocation and bandwidth management.
* **Access Control** - Platform.sh is responsible for providing access control mechanisms to customers and for vetting all Platform.sh personnel access.
* **Backups** - Platform.sh is responsible for backing up the infrastructure and management components of the system.  On Platform.sh Dedicated Enterprise (only), Platform.sh will also backup application code and databases on behalf of customers.

Customers are responsible for:

* **Patch Management** - Customers are responsible for maintaining and patching application code uploaded to Platform.sh, either written by them or by a third party.
* **Configuration Management** - Customers are responsible for the secure configuration of their application, including Platform.sh configuration and routes managed through YAML files.
* **Awareness and Training** - Customers are responsible for training their own employees and users in secure software practices.
* **Capacity Management** - Customers are responsible for ensuring their application containers have sufficient resources for their selected tasks.
* **Access Control** - Customers are responsible for effectively leveraging available access control mechanisms, including proper access control settings, secrets management, ssh keys management, and the use of two-factor authentication.
* **Backups** - On Platform.sh Professional customers are responsible for all application and database backups.


The [Platform.sh PCI Responsibility Matrix](https://docs.google.com/spreadsheets/d/e/2PACX-1vQ6iXmdeFoT2OycEEd1rOpxV7t5fdPqthommxk-wtp7mZTy0FDHIh7gXQdl1c-qtkl9Pqsduhbza3i3/pub?output=xlsx) (Excel) provides guidance on shared responsibilities to achieve PCI DSS compliance using PCI DSS 3.2 as a reference. This document was prepared by Platform.sh for informational purposes only. It is provided as a courtesy to facilitate customers’ consideration and review of the Platform.sh PCI Responsibility Summary, but the spreadsheet does not replace and is separate from the Platform.sh PCI AOC (available upon request). Customers may use the spreadsheet in conjunction with the Platform.sh PCI AOC solely to facilitate understanding elements of the report. The spreadsheet does not create any warranties, representations, contractual commitments, conditions, or assurances from Platform.sh, its affiliates, vendors, or licensors.
 
By opening the linked document you accept and agree to these Terms of Use. If you do not wish to adhere to these Terms of Use, do not open, download, save, or otherwise access the linked document.
