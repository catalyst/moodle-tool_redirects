<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Settings.
 *
 * @package    tool_redirects
 * @author     Dmitrii Metelkin <dmitriim@catalyst-au.net>
 * @copyright  2017 Catalyst IT Australia {@link http://www.catalyst-au.net}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if (is_siteadmin()) {

    $settings = new admin_settingpage('tool_redirects', get_string('pluginname', 'tool_redirects'));
    $ADMIN->add('tools', $settings);

    $name = 'tool_redirects/rules';
    $title = get_string('rules', 'tool_redirects');
    $description = get_string('rules_desc', 'tool_redirects');
    $default = null;
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $settings->add($setting);

    $name = 'tool_redirects/redirectadmin';
    $title = get_string('redirectadmin', 'tool_redirects');
    $description = get_string('redirectadmin_desc', 'tool_redirects');
    $default = 0;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $settings->add($setting);
}
