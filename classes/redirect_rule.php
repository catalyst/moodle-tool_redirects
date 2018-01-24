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
 * Redirect rule class.
 *
 * @package    tool_redirects
 * @author     Dmitrii Metelkin <dmitriim@catalyst-au.net>
 * @copyright  2017 Catalyst IT Australia {@link http://www.catalyst-au.net}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_redirects;

defined('MOODLE_INTERNAL') || die();

class redirect_rule {
    /**
     * Rule config data.
     *
     * @var rule_config
     */
    protected $config;

    /**
     * Constructor.
     *
     * @param rule_config $config Config object for a rule.
     */
    public function __construct(rule_config $config) {
        $this->config = $config;
    }

    /**
     * Check if the rule is enabled.
     *
     * @return bool
     */
    public function is_enabled() {
        return $this->config->enabled;
    }

    /**
     * Check if we should redirect from provided URL.
     *
     * @param \moodle_url $url URL to check.
     *
     * @return bool
     */
    public function should_redirect(\moodle_url $url) {
        // TODO: Implement should_redirect() method.
        return true;
    }

    /**
     * Return URL to redirect to.
     * @return \moodle_url
     */
    public function get_redirect_url() {
        return new \moodle_url($this->config->redirecturl);
    }
}
