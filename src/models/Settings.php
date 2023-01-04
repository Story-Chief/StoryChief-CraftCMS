<?php

namespace storychief\storychief\models;

use craft\base\Model;

class Settings extends Model
{
    public $key;
    public $section;
    public $entry_type;
    public $mapping = null;
    public $custom_field_definitions = [];

    public function rules()
    {
        return [
            [['key', 'section', 'entry_type'], 'string'],
            [['key', 'section', 'entry_type'], 'required'],
        ];
    }
}
