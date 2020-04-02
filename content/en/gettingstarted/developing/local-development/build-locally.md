---
title: "Build site locally"
weight: 3
---

# Local development

## Build site locally

Now that you've opened tunnels into your services, you'll have access to all of your data in your environment. All that's left now is to actually build the site.

{{< asciinema src="videos/asciinema/build.cast" >}}

1. **Build the site**

    From the repository root, run the command

    ```bash
    platform build
    ```

    The Platform CLI will first ask you for the source directory and the build destination, then it will use your `.platform.app.yaml` file to execute the [build process locally](https://docs.platform.sh/gettingstarted/local.html#building-the-site-locally). This will create a `_www` directory in the project root that is a symlink to the currently active build, which is now located in `.platform/local/builds`.

2. **Verify**

    Move to the build destination (i.e. `cd _www`) and then run a local web server to verify the build.

    {{< tabs "PHP" "Python" "Ruby" >}}

    {{< tab id="PHP" active="true" >}}
    {{< highlight bash >}}
php -d variables_order=EGPCS -S localhost:8001
    {{< /highlight >}}
    {{< /tab >}}

    {{< tab id="Python" >}}
    {{< highlight bash >}}
python3 -m http.server 8000
    {{< /highlight >}}
    {{< /tab >}}

    {{< tab id="Ruby" >}}
    {{< highlight bash >}}
ruby -run -e httpd . -p 8000
    {{< /highlight >}}
    {{< /tab >}}

    {{< /tabs >}}

    Applications written in Node.js, Go and Java can be configured to listen on a port locally, so it will only be necessary to execute the program directly.

3. **Cleanup**

    That's it! Now you can easily spin up a local build of your application and test new features with full access to all of the data in your services. When you are finished, shut down the web server and then close the tunnel to your services:

    ```bash
    platform tunnel:close
    ```

Now you know how to connect to your services on Platform.sh and perform a local build during development.

{{< navbuttons next="I have built my application locally">}}
