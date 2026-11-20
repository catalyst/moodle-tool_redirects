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

namespace tool_redirects;

/**
 * Tests
 */
final class redirect_rule_test extends \advanced_testcase {
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
    public function test_can_check_if_enabled(): void {
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
    public function test_can_get_redirect_url(): void {
        $config = new \tool_redirects\rule_config($this->configdata);
        $validator = new \tool_redirects\regex_validator($config->regex);
        $rule = new \tool_redirects\redirect_rule($config, $validator);

        $url = $rule->get_redirect_url();

        $this->assertTrue($url instanceof \moodle_url);
        $this->assertEquals('example.com', $url->get_host());
    }

    /**
     * Test that should not redirect from external URLs.
     */
    public function test_should_not_redirect_from_external_urls(): void {
        $this->setAdminUser();

        $this->configdata['regex'] = '#.*#'; // Any path.

        $config = new \tool_redirects\rule_config($this->configdata);
        $validator = new \tool_redirects\regex_validator($config->regex);
        $rule = new \tool_redirects\redirect_rule($config, $validator);
        $this->assertFalse($rule->should_redirect(new \moodle_url('http://external.com/')));
    }

    /**
     * Test that admin users are redirected based on redirectadmin config option.
     */
    public function test_that_admins_are_redirected_based_on_redirectadmin_option(): void {
        $this->setAdminUser();

        $this->configdata['regex'] = '#.*#'; // Any path.
        $this->configdata['redirectadmin'] = false;

        $config = new \tool_redirects\rule_config($this->configdata);
        $validator = new \tool_redirects\regex_validator($config->regex);
        $rule = new \tool_redirects\redirect_rule($config, $validator);
        $this->assertTrue($rule->should_warn_instead_of_redirect());

        $this->configdata['redirectadmin'] = true;
        $config = new \tool_redirects\rule_config($this->configdata);
        $validator = new \tool_redirects\regex_validator($config->regex);
        $rule = new \tool_redirects\redirect_rule($config, $validator);
        $this->assertFalse($rule->should_warn_instead_of_redirect());
    }

    /**
     * Test that admins can use backdoor option and avoid redirect.
     */
    public function test_that_admins_can_use_backdoor_option(): void {
        $this->setAdminUser();

        $this->configdata['regex'] = '#.*#'; // Any path.

        $config = new \tool_redirects\rule_config($this->configdata);
        $validator = new \tool_redirects\regex_validator($config->regex);
        $rule = new \tool_redirects\redirect_rule($config, $validator);
        $this->assertFalse($rule->should_warn_instead_of_redirect());

        $_GET['noredirect'] = 1;
        $this->assertTrue($rule->should_warn_instead_of_redirect());
    }

    /**
     * Test that not admin users can't use backdoor oprion.
     */
    public function test_that_not_admins_can_not_use_backdoor_option(): void {
        $this->configdata['regex'] = '#.*#'; // Any path.

        $config = new \tool_redirects\rule_config($this->configdata);
        $validator = new \tool_redirects\regex_validator($config->regex);
        $rule = new \tool_redirects\redirect_rule($config, $validator);
        $this->assertFalse($rule->should_warn_instead_of_redirect());

        $_GET['noredirect'] = 1;
        $this->assertFalse($rule->should_warn_instead_of_redirect());
    }

    /**
     * Test that never redirects if broken regex rule provided.
     */
    public function test_should_not_redirect_on_broken_regex(): void {
        $this->configdata['regex'] = '1'; // Broken regex rule.

        $config = new \tool_redirects\rule_config($this->configdata);
        $validator = new \tool_redirects\regex_validator($config->regex);
        $rule = new \tool_redirects\redirect_rule($config, $validator);
        $this->assertFalse($rule->should_redirect(new \moodle_url('http://example.com/index.php')));
    }

    /**
     * Test that URLs which cannot be encoded do not fatal rule matching.
     */
    public function test_should_not_redirect_when_url_cannot_be_encoded(): void {
        $this->configdata['regex'] = '#.*#'; // Matches anything, so a match would normally fire.

        $config = new \tool_redirects\rule_config($this->configdata);
        $validator = new \tool_redirects\regex_validator($config->regex);
        $rule = new \tool_redirects\redirect_rule($config, $validator);

        $url = new class ('http://example.com/index.php') extends \moodle_url {
            /**
             * Force the rule's defensive handling of unencodable URLs.
             *
             * @param bool $escaped
             * @param array|null $overrideparams
             * @return string
             */
            public function out_as_local_url($escaped = true, ?array $overrideparams = null) {
                throw new \TypeError('Could not encode URL');
            }
        };

        $this->assertFalse($rule->should_redirect($url));
        $this->assertDebuggingCalled();
    }

    /**
     * Test that an empty loginstate redirects everyone (logged-in and logged-out).
     */
    public function test_loginstate_empty_redirects_everyone(): void {
        $this->configdata['regex'] = '#\/index\.php#';
        $this->configdata['loginstate'] = '';

        $config = new \tool_redirects\rule_config($this->configdata);
        $validator = new \tool_redirects\regex_validator($config->regex);
        $rule = new \tool_redirects\redirect_rule($config, $validator);
        $url = new \moodle_url('http://example.com/index.php');

        // Guest (not logged in) — should redirect.
        $this->setGuestUser();
        $this->assertTrue($rule->should_redirect($url));

        // Authenticated user — should also redirect.
        $user = $this->getDataGenerator()->create_user();
        $this->setUser($user);
        $this->assertTrue($rule->should_redirect($url));
    }

    /**
     * Test that loginstate 'loggedout' redirects only guests/not-logged-in users.
     */
    public function test_loginstate_loggedout_redirects_only_guests(): void {
        $this->configdata['regex'] = '#\/index\.php#';
        $this->configdata['loginstate'] = 'loggedout';

        $config = new \tool_redirects\rule_config($this->configdata);
        $validator = new \tool_redirects\regex_validator($config->regex);
        $rule = new \tool_redirects\redirect_rule($config, $validator);
        $url = new \moodle_url('http://example.com/index.php');

        // Guest (not logged in) — should redirect.
        $this->setGuestUser();
        $this->assertTrue($rule->should_redirect($url));

        // Authenticated user — should NOT redirect.
        $user = $this->getDataGenerator()->create_user();
        $this->setUser($user);
        $this->assertFalse($rule->should_redirect($url));
    }

    /**
     * Test that loginstate 'loggedin' redirects only authenticated users.
     */
    public function test_loginstate_loggedin_redirects_only_authenticated(): void {
        $this->configdata['regex'] = '#\/index\.php#';
        $this->configdata['loginstate'] = 'loggedin';

        $config = new \tool_redirects\rule_config($this->configdata);
        $validator = new \tool_redirects\regex_validator($config->regex);
        $rule = new \tool_redirects\redirect_rule($config, $validator);
        $url = new \moodle_url('http://example.com/index.php');

        // Guest (not logged in) — should NOT redirect.
        $this->setGuestUser();
        $this->assertFalse($rule->should_redirect($url));

        // Authenticated user — should redirect.
        $user = $this->getDataGenerator()->create_user();
        $this->setUser($user);
        $this->assertTrue($rule->should_redirect($url));
    }

    /**
     * Test that get_loginstate returns the configured value.
     */
    public function test_get_loginstate_returns_configured_value(): void {
        foreach (['', 'loggedout', 'loggedin'] as $state) {
            $this->configdata['loginstate'] = $state;
            $config = new \tool_redirects\rule_config($this->configdata);
            $validator = new \tool_redirects\regex_validator($config->regex);
            $rule = new \tool_redirects\redirect_rule($config, $validator);
            $this->assertEquals($state, $rule->get_loginstate());
        }
    }
}
