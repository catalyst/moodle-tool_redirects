<a href="https://github.com/catalyst/moodle-tool_redirects/actions/workflows/ci.yml?query=branch%3Amaster">
<img src="https://github.com/catalyst/moodle-tool_redirects/workflows/ci/badge.svg?branch=master">
</a>

# Configurable redirects for Moodle

A very simple plugin which allows admin to set redirects based on url. Redirects can
be from existing Moodle pages like from one course to another, or they can be 'vanity'
urls from non existing urls into a page inside Moodle.

## Branches
| Moodle version    | Branch                                                                                        | PHP  |
|-------------------|-----------------------------------------------------------------------------------------------|------|
| Moodle 4.1+       | [MOODLE_401_STABLE](https://github.com/catalyst/moodle-tool_redirects/tree/MOODLE_401_STABLE) | 7.4+ |

## Installation

Using git submodule:

```
git submodule add git@github.com:catalyst/moodle-tool_redirects.git admin/tool/redirects
```

OR you can download as a zip from github

https://github.com/catalyst/moodle-tool_redirects/archive/master.zip

Extract this into /var/www/yourmoodle/admin/tool/redirects

Then run the moodle upgrade as normal.

https://docs.moodle.org/en/Installing_plugins


## Configuration

* Navigate to Site Administration > Plugins > Admin tools > Redirects
* Add rules. Each line should be a redirect rule like [php regex of local moodle URL to redirect from]=>[any URL to redirect to]. E.g. #/my/#=>/course/view.php?id=2 
* Enable or disable redirects for administrators

If you wish to use redirects for urls which do not exist, eg /some-vanity-url then your webserver
needs to be configured to have Moodle handle error pages. Setup details are here:

https://docs.moodle.org/dev/Error_pages

## Backdoor option for Admins
Admins can bypass redirect by adding **noredirect=1** parameter to requested URL. E.g. http://moodle.example.com/my/?noredirect=1

# Contributing and Support

Issues, and pull requests using github are welcome and encouraged!

https://github.com/catalyst/moodle-tool_redirects/issues

If you would like commercial support or would like to sponsor additional improvements
to this plugin please contact us:

https://www.catalyst-au.net/contact-us


# Crafted by Catalyst IT
This plugin was developed by Catalyst IT Australia:

https://www.catalyst-au.net/

<img alt="Catalyst IT" src="https://cdn.rawgit.com/CatalystIT-AU/moodle-auth_saml2/master/pix/catalyst-logo.svg" width="400">

