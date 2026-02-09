<?php
use CRM_Genderselfidentify_ExtensionUtil as E;

return [
  [
    'name' => 'CustomGroup_Genderselfidentify',
    'entity' => 'CustomGroup',
    'cleanup' => 'unused',
    'update' => 'unmodified',
    'params' => [
      'version' => 4,
      'values' => [
        'name' => 'Genderselfidentify',
        'title' => E::ts('User-Entered Gender'),
        'extends' => 'Individual',
        'collapse_display' => TRUE,
        'weight' => 110,
        'collapse_adv_display' => TRUE,
        'is_reserved' => TRUE,
      ],
      'match' => ['name'],
    ],
  ],
  [
    'name' => 'CustomGroup_Genderselfidentify_CustomField_Gender_Other',
    'entity' => 'CustomField',
    'cleanup' => 'unused',
    'update' => 'unmodified',
    'params' => [
      'version' => 4,
      'values' => [
        'custom_group_id.name' => 'Genderselfidentify',
        'name' => 'Gender_Other',
        'label' => E::ts('Gender - Other'),
        'html_type' => 'Text',
        'is_searchable' => TRUE,
        'text_length' => 255,
        'column_name' => 'gender_other',
      ],
      'match' => [
        'name',
        'custom_group_id',
      ],
    ],
  ],
];
