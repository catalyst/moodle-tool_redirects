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
 * Tests for redirect_rule class.
 *
 * @package    tool_redirects
 * @author     Dmitrii Metelkin <dmitriim@catalyst-au.net>
 * @copyright  2017 Catalyst IT Australia {@link http://www.catalyst-au.net}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class tool_redirects_redirect_rule_test extends advanced_testcase {
    /**
     * Test config data.
     *
     * @var array
     */
    protected $configdata = [
        'regex' => 'test regex',
        'redirecturl' => 'http://example.com',
        'enabled' => true,
        'redirectadmin' => true,
    ];

    /**
     * Test that can check if a rule is enabled based on config.
     */
    public function test_can_check_if_enabled() {
        $config = new \tool_redirects\rule_config($this->configdata);
        $rule = new \tool_redirects\redirect_rule($config);
        $this->assertTrue($rule->is_enabled());

        $this->configdata['enabled'] = false;
        $config = new \tool_redirects\rule_config($this->configdata);
        $rule = new \tool_redirects\redirect_rule($config);
        $this->assertFalse($rule->is_enabled());
    }

    /**
     * Test that can get redirect URL based on config.
     */
    public function test_can_get_redirect_url() {
        $config = new \tool_redirects\rule_config($this->configdata);
        $rule = new \tool_redirects\redirect_rule($config);

        $url = $rule->get_redirect_url();

        $this->assertTrue($url instanceof moodle_url);
        $this->assertEquals('example.com', $url->get_host());
    }
}
