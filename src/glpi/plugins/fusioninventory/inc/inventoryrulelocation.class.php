<?php

/**
 * FusionInventory
 *
 * Copyright (C) 2010-2016 by the FusionInventory Development Team.
 *
 * http://www.fusioninventory.org/
 * https://github.com/fusioninventory/fusioninventory-for-glpi
 * http://forge.fusioninventory.org/
 *
 * ------------------------------------------------------------------------
 *
 * LICENSE
 *
 * This file is part of FusionInventory project.
 *
 * FusionInventory is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * FusionInventory is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with FusionInventory. If not, see <http://www.gnu.org/licenses/>.
 *
 * ------------------------------------------------------------------------
 *
 * This file is used to manage the location rules for computer.
 *
 * ------------------------------------------------------------------------
 *
 * @package   FusionInventory
 * @author    Walid Nouh
 * @author    David Durieux
 * @copyright Copyright (c) 2010-2016 FusionInventory team
 * @license   AGPL License 3.0 or (at your option) any later version
 *            http://www.gnu.org/licenses/agpl-3.0-standalone.html
 * @link      http://www.fusioninventory.org/
 * @link      https://github.com/fusioninventory/fusioninventory-for-glpi
 *
 */

if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access directly to this file");
}

/**
 * Manage the location rules for computer.
 */
class PluginFusioninventoryInventoryRuleLocation extends Rule {

   /**
    * The right name for this class
    *
    * @var string
    */
   static $rightname = "plugin_fusioninventory_rulelocation";

   /**
    * Set these rules can be sorted
    *
    * @var boolean
    */
   public $can_sort=TRUE;

   /**
    * Set these rules don't have specific parameters
    *
    * @var boolean
    */
   public $specific_parameters = FALSE;

   const PATTERN_CIDR     = 333;
   const PATTERN_NOT_CIDR = 334;


   /**
    * Get name of this type by language of the user connected
    *
    * @return string name of this type
    */
   function getTitle() {
      return __('Location rules', 'fusioninventory');
   }



   /**
    * Make some changes before process review result
    *
    * @param array $output
    * @return array
    */
   function preProcessPreviewResults($output) {
      return $output;
   }



   /**
    * Define maximum number of actions possible in a rule
    *
    * @return integer
    */
   function maxActionsCount() {
      return 2;
   }



   /**
    * Code execution of actions of the rule
    *
    * @param array $output
    * @param array $params
    * @return array
    */
   function executeActions($output, $params) {

      PluginFusioninventoryToolbox::logIfExtradebug(
         "pluginFusioninventory-locationrules",
         "execute action\n"
      );

      if (count($this->actions)) {
         foreach ($this->actions as $action) {
            switch ($action->fields["action_type"]) {
               case "assign" :
                  PluginFusioninventoryToolbox::logIfExtradebug(
                     "pluginFusioninventory-locationrules",
                     "value ".$action->fields["value"]."\n"
                  );
                  $output[$action->fields["field"]] = $action->fields["value"];
                  break;

               case "regex_result" :
                  $res = '';
                  if (isset($this->regex_results[0])) {
                     $res .= RuleAction::getRegexResultById($action->fields["value"],
                                                            $this->regex_results[0]);
                  } else {
                     $res .= $action->fields["value"];
                  }
                  if ($res != '') {
                     $entities_id = 0;
                     if (isset($_SESSION["plugin_fusioninventory_entity"])
                             && $_SESSION["plugin_fusioninventory_entity"] > 0) {
                        $entities_id = $_SESSION["plugin_fusioninventory_entity"];
                     }
                     $res = Dropdown::importExternal(
                             getItemTypeForTable(
                                     getTableNameForForeignKeyField(
                                             $action->fields['field'])),
                             $res,
                             $entities_id);
                  }
                  $output[$action->fields["field"]] = $res;
                  break;
            }
         }
      }
      return $output;
   }



   /**
    * Get the criteria available for the rule
    *
    * @return array
    */
   function getCriterias() {

      $criterias = array();

      $criterias['itemtype']['name'] = __('Assets', 'fusioninventory').' : '.
                                          __('Item type');
      $criterias['itemtype']['type']            = 'dropdown_itemtype';
      $criterias['itemtype']['is_global']       = false;
      $criterias['itemtype']['allow_condition'] = [Rule::PATTERN_IS,
                                                   Rule::PATTERN_IS_NOT,
                                                   Rule::REGEX_MATCH,
                                                   Rule::REGEX_NOT_MATCH
                                                  ];

      $criterias['tag']['field']     = 'name';
      $criterias['tag']['name']      = __('FusionInventory tag', 'fusioninventory');


      $criterias['domain']['field']     = 'name';
      $criterias['domain']['name']      = __('Domain');


      $criterias['subnet']['field']     = 'name';
      $criterias['subnet']['name']      = __('Subnet');

      $criterias['ip']['field']     = 'name';
      $criterias['ip']['name']      = __('Address')." ".__('IP');


      $criterias['name']['field']     = 'name';
      $criterias['name']['name']      = __('Name');


      $criterias['serial']['field']     = 'name';
      $criterias['serial']['name']      = __('Serial number');

      $criterias['oscomment']['field']     = 'name';
      $criterias['oscomment']['name']      = __('Operating system').'/'.__('Comments');

      return $criterias;
   }



   /**
    * Get the actions available for the rule
    *
    * @return array
    */
   function getActions() {

      $actions = array();

      $actions['locations_id']['name']  = __('Location');

      $actions['locations_id']['type']  = 'dropdown';
      $actions['locations_id']['table'] = 'glpi_locations';
      $actions['locations_id']['force_actions'] = array('assign', 'regex_result');

      $actions['_ignore_import']['name'] =
                     __('Ignore in FusionInventory import', 'fusioninventory');

      $actions['_ignore_import']['type'] = 'yesonly';

      return $actions;
   }



   /**
    * Display more conditions
    *
    * @param integer $condition
    * @param object $criteria
    * @param string $name
    * @param string $value
    * @param boolean $test
    * @return boolean
    */
   function displayAdditionalRuleCondition($condition, $criteria, $name, $value, $test=FALSE) {
      if ($test) {
         return FALSE;
      }
      switch ($condition) {
         case Rule::PATTERN_FIND:
            return FALSE;

         case PluginFusioninventoryInventoryRuleImport::PATTERN_IS_EMPTY :
            Dropdown::showYesNo($name, 0, 0);
            return TRUE;

         case Rule::PATTERN_EXISTS:
            echo Dropdown::showYesNo($name, 1, 0);
            return TRUE;

         case Rule::PATTERN_DOES_NOT_EXISTS:
            echo Dropdown::showYesNo($name, 1, 0);
            return TRUE;

         case Rule::PATTERN_IS:
         case Rule::PATTERN_IS_NOT:
            if (!empty($criteria)
               && isset($criteria['type'])
                  && $criteria['type'] == 'dropdown_itemtype') {
               $types = $this->getItemTypesForRules();
               Dropdown::showItemTypes($name, array_keys($types),
                                       ['value' => $value]);
               return true;
            }

      }

      return FALSE;
   }



   /**
    * Add more criteria
    *
    * @param string $criterion
    * @return array
    */
   static function addMoreCriteria($criterion='') {
      if ($criterion == 'ip'
              || $criterion == 'subnet') {
         return array(self::PATTERN_CIDR => __('is CIDR', 'fusioninventory'),
                      self::PATTERN_NOT_CIDR => __('is not CIDR', 'fusioninventory'));
      }
      return array();
   }



   /**
    * Check criteria
    *
    * @param object $criteria
    * @param array $input
    * @return boolean
    */
   function checkCriteria(&$criteria, &$input) {

      $res = parent::checkCriteria($criteria, $input);

      if (in_array($criteria->fields["condition"], array(self::PATTERN_CIDR))) {
         $pattern   = $criteria->fields['pattern'];
         $value = $this->getCriteriaValue($criteria->fields["criteria"],
                                          $criteria->fields["condition"],
                                          $input[$criteria->fields["criteria"]]);

         list ($subnet, $bits) = explode('/', $pattern);
         $subnet = ip2long($subnet);
         $mask = -1 << (32 - $bits);
         $subnet &= $mask; # nb: in case the supplied subnet wasn't correctly aligned

         if (is_array($value)) {
            foreach ($value as $ip) {
               if (isset($ip) && $ip != '') {
                  $ip = ip2long($ip);
                  if (($ip & $mask) == $subnet) {
                     $res = TRUE;
                     break 1;
                  }
               }
            }
         } else {
            if (isset($value) && $value != '') {
               $ip = ip2long($value);
               if (($ip & $mask) == $subnet) {
                  $res = TRUE;
               }
            }
         }
      } else if (in_array($criteria->fields["condition"], array(self::PATTERN_NOT_CIDR))) {
         $pattern   = $criteria->fields['pattern'];
         $value = $this->getCriteriaValue($criteria->fields["criteria"],
                                          $criteria->fields["condition"],
                                          $input[$criteria->fields["criteria"]]);

         list ($subnet, $bits) = explode('/', $pattern);
         $subnet = ip2long($subnet);
         $mask = -1 << (32 - $bits);
         $subnet &= $mask; # nb: in case the supplied subnet wasn't correctly aligned

         if (is_array($value)) {
            $resarray = TRUE;
            foreach ($value as $ip) {
               if (isset($ip) && $ip != '') {
                  $ip = ip2long($ip);
                  if (($ip & $mask) == $subnet) {
                     $resarray = FALSE;
                  }
               }
            }
            $res = $resarray;
         } else {
            if (isset($value) && $value != '') {
               $ip = ip2long($value);
               if (($ip & $mask) != $subnet) {
                  $res = TRUE;
               }
            }
         }
      }
      return $res;
   }

   /**
    * Get itemtypes have state_type and unmanaged devices
    *
    * @global array $CFG_GLPI
    * @return array
    */
   function getItemTypesForRules() {
      global $CFG_GLPI;

      $types = [];
      foreach ($CFG_GLPI["networkport_types"] as $itemtype) {
         if (class_exists($itemtype)) {
            $item = new $itemtype();
            $types[$itemtype] = $item->getTypeName();
         }
      }
      $types[""] = __('No itemtype defined', 'fusioninventory');
      ksort($types);
      return $types;
   }

}
