<?php
class CRM_Genderselfidentify_ContactAPIWrapper implements API_Wrapper {
  /**
   * @inheritdoc
   */
  public function fromApiInput($apiRequest) {
    if ($apiRequest['action'] == 'create') {
      $params =& $apiRequest['params'];
      if (!empty($params['gender_id'])) {
        $customGenderField = 'custom_' . CRM_Genderselfidentify_BAO_Gender::getCustomFieldId();
        if (empty($params['gender_id'])) {
          $params[$customGenderField] = 'null';
        }
        else {
          $params[$customGenderField] = $params['gender_id'];
          $params['gender_id'] = CRM_Genderselfidentify_BAO_Gender::match($params['gender_id']);
          // Set to "Other"
          if ($params['gender_id'] === NULL) {
            $params['gender_id'] = CRM_Genderselfidentify_BAO_Gender::otherOption();
          }
        }
      }
    }
    return $apiRequest;
  }

  /**
   * @inheritdoc
   */
  public function toApiOutput($apiRequest, $result) {
    if ($apiRequest['action'] == 'get' && !empty($result['values'])) {
      foreach ($result['values'] as &$contact) {
        $this->fixContactGender($contact);
      }
    }
    return $result;
  }

  /**
   * Sets the "gender" field on a contact to the option label if it is a standard option,
   * or the contents of the custom field if it is "Other"
   *
   * @param array $contact
   */
  private function fixContactGender(&$contact) {
    $customGenderField = 'custom_' . CRM_Genderselfidentify_BAO_Gender::getCustomFieldId();
    $other = CRM_Genderselfidentify_BAO_Gender::otherOption();
    if (array_key_exists('gender_id', $contact) && array_key_exists($customGenderField, $contact)) {
      $contact['gender'] = !empty($contact['gender']) && ($contact['gender_id'] != $other || !strlen($contact[$customGenderField])) ? $contact['gender'] : $contact[$customGenderField];
    }
    elseif (!empty($contact['gender_id']) && $contact['gender_id'] == $other) {
      $contact['gender'] = CRM_Genderselfidentify_BAO_Gender::get($contact['id']);
    }
  }
}