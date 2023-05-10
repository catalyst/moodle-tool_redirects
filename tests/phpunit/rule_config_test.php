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
 * Tests for rule_config class.
 *
 * @package    tool_redirects
 * @author     Dmitrii Metelkin <dmitriim@catalyst-au.net>
 * @copyright  2018 Catalyst IT Australia {@link http://www.catalyst-au.net}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_redirects;

/**
 * Rules
 */
class rule_config_test extends \advanced_testcase {
    /**
     * Test data.
     *
     * @var array
     */
    protected $data = [
        'regex' => 'test regex',
        'redirecturl' => 'test redirect url',
        'enabled' => false,
        'redirectadmin' => true,
    ];

    /**
     * Test get exception when trying to set and then get random property.
     */
    public function test_that_can_not_set_random_property() {
        $this->expectException(\moodle_exception::class);
        $this->data['random'] = 'random';
        $config = new \tool_redirects\rule_config($this->data);
        $test = $config->random;
    }

    /**
     * Test get exception when getting invalid property.
     */
    public function test_throw_exception_on_invalid_property() {
        $this->expectException(\moodle_exception::class);
        $config = new \tool_redirects\rule_config($this->data);
        $test = $config->invalid;
    }

    /**
     * Test defaults.
     */
    public function test_properties_defaults() {
        $config = new \tool_redirects\rule_config([]);
        $this->assertEquals('', $config->regex);
        $this->assertEquals('', $config->redirecturl);
        $this->assertEquals(true, $config->enabled);
        $this->assertEquals(false, $config->redirectadmin);
    }

    /**
     * Test can set and then get properties.
     */
    public function test_can_set_and_get_properties() {
        $config = new \tool_redirects\rule_config($this->data);
        $this->assertEquals('test regex', $config->regex);
        $this->assertEquals('test redirect url', $config->redirecturl);
        $this->assertEquals(false, $config->enabled);
        $this->assertEquals(true, $config->redirectadmin);
    }

}
