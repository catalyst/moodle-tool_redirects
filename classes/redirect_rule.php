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
 * @copyright  2018 Catalyst IT Australia {@link http://www.catalyst-au.net}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_redirects;

defined('MOODLE_INTERNAL') || die();

class redirect_rule {
    /**
     * Backdoor URL parameter for admins.
     */
    const NO_REDIRECT_PARAM = 'noredirect';

    /**
     * Rule config data.
     *
     * @var rule_config
     */
    protected $config;

    /**
     * Rule validator.
     *
     * @var rule_validator_interface
     */
    protected $validator;

    /**
     * Constructor.
     *
     * @param rule_config $config Config object for a rule.
     * @param rule_validator_interface $validator Rule validator.
     */
    public function __construct(rule_config $config, rule_validator_interface $validator) {
        $this->config = $config;
        $this->validator = $validator;
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
        global $CFG;

        // Check if it's local moodle URL.
        $wwwroot = new \moodle_url($CFG->wwwroot);
        if ($url->get_host() !== $wwwroot->get_host()) {
            return false;
        }

        // Check for admin option.
        if (is_siteadmin() && !$this->config->redirectadmin) {
            return false;
        }

        // Check of backdoor for admins in case of a horrible mistake happened.
        if (is_siteadmin() && $this->check_for_backdoor()) {
            return false;
        }

        // Check valid rule.
        if (!$this->validator->is_valid()) {
            return false;
        }

        return (preg_match($this->config->regex, $url->out_as_local_url()) == 1);
    }

    /**
     * Return URL to redirect to.
     * @return \moodle_url
     */
    public function get_redirect_url() {
        return new \moodle_url($this->config->redirecturl);
    }

    /**
     * Check for the backdoor option.
     *
     * @return mixed
     * @throws \coding_exception
     */
    protected function check_for_backdoor() {
        return optional_param(self::NO_REDIRECT_PARAM, false, PARAM_INT);
    }
}
