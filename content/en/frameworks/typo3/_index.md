---
title: "TYPO3 - Getting started"
weight: 8
sidebarTitle: "TYPO3"
 
---

## Prerequisites

**Composer**

Composer is a tool for dependency management in PHP. It allows you to declare the dependent libraries your project needs and it will install them in your project for you.

> - [Install Composer](https://getcomposer.org/download/)

## Configure your app

The ideal `.platform.app.yaml` file will vary from project project, and you are free to customize yours as needed.  A recommended baseline TYPO3 configuration is listed below, and can also be found in our [TYPO3 template project](https://github.com/platformsh/platformsh-example-typo3).


{{< highlight yaml >}}
{{< readFile file="static/files/fetch/appyaml/typo3" >}}
{{< /highlight >}}

## Additional information
