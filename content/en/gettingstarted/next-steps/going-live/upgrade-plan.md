---
title: "Upgrade plan"
weight: 2
---

# Going live

## Upgrade Plan

"Development" plan projects cannot be assigned a domain name, so you will not be able to go live until you upgrade to at least a Standard plan. This can be done using the management console.

{{< video src="videos/management-console/upgrade-plan.mp4" >}}

Development plans come with four environments: three development and one "future" production environment, which is the `master` branch.

For example, "Small" plan sizes provide a production environment, but restrict your application to the use of a single service (i.e. a database).

On your project, click the "Go live" button in the top right hand corner of your project preview image. This will allow you to edit the project's plan, and it can also be reached from your "Account" page by clicking "Edit" from the vertical dot dropdown for your project.

Select the plan size that is appropriate for the needs of your application. This is also the page where you can increase the number of development environments, and the amount of storage. Make your changes and then click "Update plan" at the bottom of the page. Your application will redeploy.

{{< navbuttons next="I have upgraded my plan size">}}
