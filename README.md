<a href="https://travis-ci.org/catalyst/moodle-tool_redirects">
<img src="https://travis-ci.org/catalyst/moodle-tool_redirects.svg?branch=master">
</a>

# Configurable redirects for Moodle

A very simple plugin which allows admin to set redirects based on url. 

## Installation

Step 1: Install the local module
--------------------------------

Using git submodule:

```
git submodule add git@github.com:catalyst/moodle-tool_redirects.git admin/tool/redirects
```

OR you can download as a zip from github

https://github.com/catalyst/moodle-tool_redirects/archive/master.zip

Extract this into /var/www/yourmoodle/admin/tool/redirects

Then run the moodle upgrade as normal.

https://docs.moodle.org/en/Installing_plugins


Step 2: Apply core patches
-------------------------------

This plugin requires [MDL-66340](https://tracker.moodle.org/browse/MDL-66340), which was added in 3.8.

You can easily backport these patches in one line for 3.5, 3.6 and 3.7:

For Moodle 3.5:

```
git apply --whitespace=nowarn admin/tool/redirects/patch/core35.diff
```

For Moodle 3.6:

```
git apply --whitespace=nowarn admin/tool/redirects/patch/core36.diff
```

For Moodle 3.7:

```
git apply --whitespace=nowarn admin/tool/redirects/patch/core37.diff
```

### Manual cherry-pick
In case the patches do not work due to an update to older Moodle branches (such as security updates), you can manually perform the cherry-picks.

For [MDL-66340](https://tracker.moodle.org/browse/MDL-66340):

```
git cherry-pick 4ed105a9fd4c37e063d384ff155bd10c3bfbb303
```
If there are merge conflicts, ensure the lines that you are adding are consistent with the lines being added inside the patch files. Everything else can safely be ignored.

Once this has been performed, you can generate your own patch files using `git format-patch`. An example for Moodle 3.5 is below:
```
git format-patch MOODLE_35_STABLE --stdout > admin/tool/redirects/patch/new_core35.diff
```

## Configuration

* Navigate to Site Administration > Plugins > Admin tools > Redirects
* Add rules. Each line should be a redirect rule like [php regex of local moodle URL to redirect from]=>[any URL to redirect to]. E.g. #/my/#=>/course/view.php?id=2 
* Enable or disable redirects for administrators

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

