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
 * Helper class.
 *
 * @package    tool_redirects
 * @author     Dmitrii Metelkin <dmitriim@catalyst-au.net>
 * @copyright  2018 Catalyst IT Australia {@link http://www.catalyst-au.net}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_redirects;

defined('MOODLE_INTERNAL') || die();

abstract class helper {
    /**
     * Rules delimited in the settings.
     */
    const SETTINGS_DELIMITER = '=>';

    /**
     * A list of configured rules.
     *
     * @var array
     */
    protected static $rules;

    /**
     * Return a list of all rules.
     *
     * @return \tool_redirects\redirect_rule[]
     * @throws \dml_exception
     */
    public static function get_all_rules() {
        if (!isset(self::$rules) || PHPUNIT_TEST == true) {
            self::$rules = self::build_rules_from_config();
        }

        return self::$rules;
    }

    /**
     * Build a list of configured rules from config.
     *
     * @return \tool_redirects\redirect_rule[]
     * @throws \dml_exception
     */
    public static function build_rules_from_config() {
        $rules = [];
        $config = get_config('tool_redirects');

        if (!empty($config->rules)) {
            $items = explode("\n", $config->rules);

            foreach ($items as $item) {
                $data = explode(self::SETTINGS_DELIMITER, $item);

                if (!empty($data[0] && !empty($data[1]))) {
                    $ruleconfig = new rule_config([
                        'regex' => $data[0],
                        'redirecturl' => $data[1],
                        'enabled' => true,
                        'redirectadmin' => isset($config->redirectadmin) ? $config->redirectadmin : false,
                    ]);

                    $rules[] = new redirect_rule($ruleconfig, new regex_validator($ruleconfig->regex));
                }
            }
        }

        return $rules;
    }

    /**
     * Build rules from DB.
     *
     * @throws \coding_exception
     */
    public static function build_rules_from_db() {
        throw new \coding_exception('Not implemented yet! Please use helper::build_rules_from_config');
    }

    /**
     * Redirects based on rules
     */
    public static function redirect_from_rules() {
        global $PAGE;

        $rules = self::get_all_rules();

        foreach ($rules as $rule) {
            if ($rule->is_enabled() && $rule->should_redirect($PAGE->url)) {
                redirect($rule->get_redirect_url());
            }
        }
    }
}
