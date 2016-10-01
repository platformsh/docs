# Using SSH keys

One of the ways [Platform.sh](https://platform.sh/) keeps things secure
is by using SSH behind the scenes. Users can interact with their environment
through a command shell, or push changes to the environment's git repository,
and both of these features rely on SSH.

When you create a new project, the wizard will propose that you add your ssh
key.

![Setting Up Your Project Add SSH Key Done](/images/03-setting-up-your-project-add-ssh-key-done.png)

You can also manage SSH keys through the CLI (see below), or through the
settings screen on your account page.

## Find your Public-Private Keypair

If you use Linux, you probably already have keys. The private key is usually in a
file named `~/.ssh/id_rsa` and the public key in `~/.ssh/id_rsa.pub`,

Searching for a public key file:
1. Open up a command prompt.
2. run the following commands:
```
$ cd ~/.ssh
$ ls -a
id_rsa
id_rsa.pub
known_hosts
authorized_keys
```

If you find a file named either `id_rsa.pub` or `id_dsa.pub`, you can
use it with Platform.sh. If you don't find an existing key, see the steps to
create a new one in the [next section](#create-a-new-public-private-keypair).

## Create a New Public-Private Keypair

> **note**
> If you already have a SSH keypair, you can skip this step.

Create a public-private keypair:

    $ ssh-keygen -t rsa -C "your_email_address@example.com"

`ssh-keygen` generates the key pair and will ask you where you want to
save the file:

    Generating public/private rsa key pair.
    Enter file in which to save the key (/Users/your_username/.ssh/id_rsa):

The default location is fine in most cases. Now it's time to create a
passphrase. A good, strong passphrase is highly recommended, to make your key
less useful if it falls into the wrong hands.

    Enter passphrase (empty for no passphrase): [Type a passphrase]
    Enter same passphrase again: [Type passphrase again]

That's it. Keys generated! Here are the results:

    Your identification has been saved in /Users/your_username/.ssh/id_rsa.
    Your public key has been saved in /Users/your_username/.ssh/id_rsa.pub.
    The key fingerprint is:
    55:c5:d7:a9:1f:dc:7a:67:31:70:fd:87:5a:a6:d0:69 your_email_address@example.com

> **note**
> Make note of the location of your public key, you're going to need that in the next section.

## Add the SSH key to your Platform account

You have your SSH keys (if not, take a look at the section above), but
you need to make sure Platform has a copy of your public key. It's
pretty easy to add it to your account.

1.  First off, you'll need to copy your public key to the clipboard.
2.  Head over to your user account page on
    [the Platform.sh Accounts page](https://accounts.platform.sh/user) and
    navigate to the `SSH Keys` tab.
3.  Click on the `Add a public key` link.
4.  Paste the key that you copied earlier into the 'Key' text box. You can also
    add a title if you like, otherwise it will be auto-generated.
5.  Click 'Save'.

That's it! You're all set. Now you'll be able to use Git and command shells
with any Platform.sh environment that your user account is authorized to work
with.

![Edit Account Ssh](/images/edit-account-ssh.png)

## SSH to your Web Server

In the Web Interface, just under the environment name, there is a link
you can hover over to copy the SSH URL of that environment:

![Image of an environment's access information in the web interface](/images/ssh-access-information.png "The SSH URL is formatted as follows: `<project-id>-<environment-id>@ssh.<region>.platform.sh`")

1.  Open your Platform.sh Web Interface
2.  Hover over the `Access info` link
3.  Click to copy the SSH URL
4.  Open a terminal
5.  Paste the link into your terminal

You should see something like this:

    $ ssh wk5fqz6qoo123-master@ssh.eu.platform.sh

       ___ _      _    __
      | _ \ |__ _| |_ / _|___ _ _ _ __
      |  _/ / _` |  _|  _/ _ \ '_| '  \
      |_| |_\__,_|\__|_| \___/_| |_|_|_|

     Welcome to Platform.

     This is environment master
     of project wk5fqz6qoo123.

    web@wk5fqz6qoo123-master--php:~$

## Troubleshoot SSH

While trying to log in via SSH, this can happen:

    $ ssh wk5fqz6qoo123-master@ssh.eu.platform.sh
    Permission denied (publickey).

Don't panic! It's an issue which can happen for the following reasons:

-   Your environment is inactive
-   You haven't rebuilt (git push) your environment since adding the new public key
-   You didn't upload your public key to your user profile
-   Your SSH private key has not been added into your ssh-agent

### Check your public key

Make sure your public key has been uploaded to your user account.

### Check your ssh-agent

Check that your key is properly added to your SSH agent. This is an
authentication agent that manages your private key.

1.  Check your SSH agent. Run the command `ssh-add -l` in your terminal:

        $ ssh-add -l
        2048 12:b0:13:83:7f:56:18:9b:78:ca:54:90:a7:ff:12:69 /Users/nick/.ssh/id_rsa (RSA)

2.  Check that file name on the right (`.ssh/id_rsa` in the example
    above). Does it match your private key file?
3.  If you don't see your private key file, add your private key:

        $ ssh-add path-to-your-key

4.  Try again.

### Still having trouble?

If you followed all the steps above, you may also notice an error message similar to below while attempting to ssh to platform.sh:

    Hello Your Name, you successfully connected, but you do not have access to service 'xxxxxxxxxxxxxx-master': check permissions.
    Received disconnect from 54.210.49.244: 14: No more auth methods available

This usually means a deployment has not been committed yet. When a new key is added, it only becomes immediately active for use with git. For use with ssh, it will not be activated until a deployment is made. An easy way to force this is to create and push an empty commit:

    $ git commit --allow-empty -m 'force redeploy'
    $ git push origin master

### If all else fails, generate some SSH debug information

If your private key and public key both look OK but you don't have any
luck logging in, print debugging information. These lines often give
clues about what is going wrong.

1.  Run the SSH command with the `-v` option, like this:

        $ ssh -v wk5fqz6qoo123-master@ssh.eu.platform.sh
        OpenSSH_6.7.8, OpenSSL 1.2.3 1 Sep 2014
        debug1: Connecting to ssh.eu.platform.sh [54.32.10.98] port 22.
        debug1: Connection established.
        debug1: identity file /Users/nick/.ssh/id_rsa type 1
        ...(30 more lines of this light reading)...
        debug1: Offering RSA public key: /Users/nick/.ssh/id_rsa
        debug1: Authentications that can continue: publickey
        debug1: No more authentication methods to try.
        Permission denied (publickey).
        $

You can use this information to make one last check of the private key
file.

If you're still stuck, don't hesitate to submit a support ticket, we'll help
you solve your problem.
