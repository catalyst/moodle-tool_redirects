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
 * @copyright  2018 Catalyst IT Australia {@link http://www.catalyst-au.net}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Tests
 */
class tool_redirects_redirect_rule_test extends advanced_testcase {
    /**
     * Test config data.
     *
     * @var array
     */
    protected $configdata = [
        'regex' => '#http://example.com/#',
        'redirecturl' => 'http://example.com/',
        'enabled' => true,
        'redirectadmin' => true,
    ];

    /**
     * Initial set up.
     */
    protected function setUp(): void {
        global $CFG;

        parent::setUp();

        $CFG->wwwroot = 'http://example.com';
        $this->resetAfterTest(true);
    }

    /**
     * Test that can check if a rule is enabled based on config.
     */
    public function test_can_check_if_enabled() {
        $config = new \tool_redirects\rule_config($this->configdata);
        $validator = new \tool_redirects\regex_validator($config->regex);
        $rule = new \tool_redirects\redirect_rule($config, $validator);
        $this->assertTrue($rule->is_enabled());

        $this->configdata['enabled'] = false;
        $config = new \tool_redirects\rule_config($this->configdata);
        $validator = new \tool_redirects\regex_validator($config->regex);
        $rule = new \tool_redirects\redirect_rule($config, $validator);
        $this->assertFalse($rule->is_enabled());
    }

    /**
     * Test that can get redirect URL based on config.
     */
    public function test_can_get_redirect_url() {
        $config = new \tool_redirects\rule_config($this->configdata);
        $validator = new \tool_redirects\regex_validator($config->regex);
        $rule = new \tool_redirects\redirect_rule($config, $validator);

        $url = $rule->get_redirect_url();

        $this->assertTrue($url instanceof moodle_url);
        $this->assertEquals('example.com', $url->get_host());
    }

    /**
     * Test that should not redirect from external URLs.
     */
    public function test_should_not_redirect_from_external_urls() {
        $this->setAdminUser();

        $this->configdata['regex'] = '#.*#'; // Any path.

        $config = new \tool_redirects\rule_config($this->configdata);
        $validator = new \tool_redirects\regex_validator($config->regex);
        $rule = new \tool_redirects\redirect_rule($config, $validator);
        $this->assertFalse($rule->should_redirect(new moodle_url('http://external.com/')));
    }

    /**
     * Test that admin users are redirected based on redirectadmin config option.
     */
    public function test_that_admins_are_redirected_based_on_redirectadmin_option() {
        $this->setAdminUser();

        $this->configdata['regex'] = '#.*#'; // Any path.

        $config = new \tool_redirects\rule_config($this->configdata);
        $validator = new \tool_redirects\regex_validator($config->regex);
        $rule = new \tool_redirects\redirect_rule($config, $validator);
        $this->assertTrue($rule->should_redirect(new moodle_url('http://example.com/index.php')));

        $this->configdata['redirectadmin'] = false;
        $config = new \tool_redirects\rule_config($this->configdata);
        $validator = new \tool_redirects\regex_validator($config->regex);
        $rule = new \tool_redirects\redirect_rule($config, $validator);
        $this->assertFalse($rule->should_redirect(new moodle_url('http://example.com/')));
    }

    /**
     * Test that admins can use backdoor option and avoid redirect.
     */
    public function test_that_admins_can_use_backdoor_option() {
        $this->setAdminUser();

        $this->configdata['regex'] = '#.*#'; // Any path.

        $config = new \tool_redirects\rule_config($this->configdata);
        $validator = new \tool_redirects\regex_validator($config->regex);
        $rule = new \tool_redirects\redirect_rule($config, $validator);
        $this->assertTrue($rule->should_redirect(new moodle_url('http://example.com/index.php')));

        $_GET['noredirect'] = 1;
        $this->assertFalse($rule->should_redirect(new moodle_url('http://example.com/index.php')));
    }

    /**
     * Test that not admin users can't use backdoor oprion.
     */
    public function test_that_not_admins_can_not_use_backdoor_option() {
        $this->configdata['regex'] = '#.*#'; // Any path.

        $config = new \tool_redirects\rule_config($this->configdata);
        $validator = new \tool_redirects\regex_validator($config->regex);
        $rule = new \tool_redirects\redirect_rule($config, $validator);
        $this->assertTrue($rule->should_redirect(new moodle_url('http://example.com/index.php')));

        $_GET['noredirect'] = 1;
        $this->assertTrue($rule->should_redirect(new moodle_url('http://example.com/index.php')));
    }

    /**
     * Test that never redirects if broken regex rule provided.
     */
    public function test_should_not_redirect_on_broken_regex() {
        $this->configdata['regex'] = '1'; // Broken regex rule.

        $config = new \tool_redirects\rule_config($this->configdata);
        $validator = new \tool_redirects\regex_validator($config->regex);
        $rule = new \tool_redirects\redirect_rule($config, $validator);
        $this->assertFalse($rule->should_redirect(new moodle_url('http://example.com/index.php')));
    }

}
