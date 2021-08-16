<?php
use CRM_Kedebug_ExtensionUtil as E;

class CRM_Kedebug_Page_Script extends CRM_Core_Page {

  public function run() {
    // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
    CRM_Utils_System::setTitle(E::ts('Script'));

    // Example: Assign a variable for use in a template
    $this->assign('currentTime', date('Y-m-d H:i:s'));
    $result = civicrm_api3('OptionValue', 'get', [
      'sequential' => 1,
      'option_group_id' => "case_status",
      'value' => ['>=' => 30],
      'options' => ['limit'=>0]
    ]);
    $script = "";
    foreach($result['values'] as $value){
      $label = $value['label'];
      $v     = $value['value'];
      $script .= "drush cvapi OptionValue.create option_group_id=\"case_status\" label=\"$label\" value=\"$v\" grouping=\"Open\"";
      $script .= "\n";
    }
    $this->assign('script',$script);

    parent::run();
  }

}
