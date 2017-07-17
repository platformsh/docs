# Platform.sh pricing

All Platform.sh plans include the following:

* Four Environments (3 for staging/development 1 for the live site).
* One Developer License
* 5GB of Storage per environment
* Multiple Backend services (MySQL, PostgreSQL, Elasticsearch, Redis, Solr..)
* Support

You can switch between plans (downgrade or upgrade) freely but note that
reducing storage is currently not supported for technical reasons. If you need
to reduce storage please create a support ticket. You will always be billed the
prorated rate of your plan over the period it was used.

You may cancel your plan at any time and you will only be billed for the actual
period used.

For Enterprise and Agency Plans you can pay by Purchase Order, for all other
plans you need to add a Credit Card to your account.

We offer a free trial period so you can test the service and see how great it
is. If ever you need more time to evaluate Platform.sh please contact our sales
representatives. They can issue you an extra voucher to prolong your test.

> In this section we describe the billing in US Dollars, you will be billed in
> Dollars, Euros or British Pounds depending on where your billing address is.

> Euro Prices are presented excluding VAT, in your bill, as appropriate we will
> include the correct VAT rate.

## Extras

All extra consumption is prorated to the time it was actually used.

> So if for example you added an extra developer for 10 days you would be billed around  extra $3 at the end of the month.

### Extra developers

Adding a developer to your project will add $10 per month.

### Extra environments

You can add extra staging/development environments to any plan by multiples of 3
for $21 / month.

> So if for example you want to have 12 staging environments you would pay additional $63 per month on top of your basic plan price.

### Extra storage

You can add additional storage at $2.50 per 5GB  per staging/development
environment.

>So if you have the default plan (with 3 staging environments) and you add 10GB (so total 15GB per environment) you would pay an extra $15 a month.

>If you added 3 extra environments (for a total of 6 staging environments) and you added 10GB (so total 15GB) you would pay an extra $30 a month.

## Development

The basic Plan (development) starts at $10 per month (including 4 environments : 3 staging/development and 1 future production).

> You can not map a custom domain name to a development plan

Development environments have less resources than production environments.

## Production - Standard / Medium / Large

The live environment (master) of a production plan has more resources
than the development environments of the project.

You can map domain names to your master environment. SSL support is always
included.

Production plans come in three flavors:

* Standard: with 2GB of dedicated memory
* Medium: with 4GB of dedicated memory
* Large: with 7GB of dedicated memory

### Multiple Applications in a single project

All Platform.sh plans support multiple applications in a single cluster but
they all share the global resource of the cluster.

The resources of a **Standard plan are not sufficient to run more then one
application** in the same cluster if there is also a MySQL database as a service. So useful multi-apps start at Medium.

A Medium plan for example can support 3 Apps with a MySQL Instance and a Redis
instance.

If you wonder if a specific setup would fit in a plan, don't hesitate to
contact our support.

## Enterprise

Enterprise plans start at around $1000 a month.

For a price lower than traditional managed hosting, you get included
development and staging environments, triple redundancy on every element of
the stack with:

>  99.99% Uptime Guaranteed
> And 24/7 White Glove On-boarding and Support

Please [contact our sales department](https://platform.sh/contact/) to discuss how we can help you.

## Agencies

We propose three tiers for agencies with many perks. Free user licenses, a free site for your own agency,  up to 10% customer lifetime referral fees and 15% discounts, access to an agency speciﬁc "Small" price plan, free Medium or Large plan website for your own agency site and free Small plan for every Enterprise project sold ... and more !   [Learn more and join today...](https://platform.sh/solutions/agency)  

## Sovereign German Cloud and Australian Region

In our current checkout flow the region selection happens after the plan selection. When you go through the checkout process (https://accounts.platform.sh/platform/buy-now) the prices shown in the estimation page are for our default cloud regions (EU and US). Plans on the Sovereign German Cloud region and the Australian region have different prices. 

The prices for Germany and Australia are currently set at 30% above the EU and US plan prices. So a "Production Standard" environment on the Sovereign German Cloud will be $65 instead of $50.

Our estimation page (which you can reach by clicking on your account dashboard on the edit link for a project) will soon be updated to reflect these new options.

If you have any questions don't hesitate to [contact our sales department](https://platform.sh/contact/).
