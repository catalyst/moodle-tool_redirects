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
 * Tests for helper class.
 *
 * @package    tool_redirects
 * @author     Dmitrii Metelkin <dmitriim@catalyst-au.net>
 * @copyright  2018 Catalyst IT Australia {@link http://www.catalyst-au.net}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class tool_redirects_helper_test extends advanced_testcase {
    /**
     * Initial set up.
     */
    protected function setUp(): void {
        parent::setUp();
        $this->resetAfterTest(true);
        $settings = "regex1=>http://url1.com\nregex2=>http://url2.com=>roles\nregex4=>\n=>http://url3.com=>";
        set_config('rules', $settings, 'tool_redirects');
    }

    /**
     * Test config delimiter value.
     */
    public function test__config_delimiter() {
        $this->assertEquals('=>', \tool_redirects\helper::SETTINGS_DELIMITER);
    }

    /**
     * Test  building rules from empty config.
     */
    public function test_build_rules_from_empty_config() {
        set_config('rules', '', 'tool_redirects');

        $rules = \tool_redirects\helper::build_rules_from_config();

        $this->assertTrue(is_array($rules));
        $this->assertCount(0, $rules);
    }

    /**
     * Test building rules form config correctly.
     */
    public function test_build_rules_from_config() {
        $rules = \tool_redirects\helper::build_rules_from_config();

        $this->assertTrue(is_array($rules));
        $this->assertCount(2, $rules);
        $this->assertTrue($rules[0] instanceof \tool_redirects\redirect_rule);
        $this->assertTrue($rules[1] instanceof \tool_redirects\redirect_rule);

        $this->assertEquals(true, $rules[0]->is_enabled());
        $this->assertEquals('url1.com', $rules[0]->get_redirect_url()->get_host());

        $this->assertEquals(true, $rules[1]->is_enabled());
        $this->assertEquals('url2.com', $rules[1]->get_redirect_url()->get_host());
    }

    /**
     * Test getting all rules correctly.
     */
    public function test_get_all_rules() {
        $rules = \tool_redirects\helper::get_all_rules();

        $this->assertTrue(is_array($rules));
        $this->assertCount(2, $rules);
        $this->assertTrue($rules[0] instanceof \tool_redirects\redirect_rule);
        $this->assertTrue($rules[1] instanceof \tool_redirects\redirect_rule);

        $this->assertEquals(true, $rules[0]->is_enabled());
        $this->assertEquals('url1.com', $rules[0]->get_redirect_url()->get_host());

        $this->assertEquals(true, $rules[1]->is_enabled());
        $this->assertEquals('url2.com', $rules[1]->get_redirect_url()->get_host());
    }

}
