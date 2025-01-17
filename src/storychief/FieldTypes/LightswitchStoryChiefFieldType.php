<?php namespace storychief\storychiefv3\storychief\FieldTypes;

use craft\base\Field;
use storychief\storychiefv3\storychief\Helpers\StoryChiefHelper;

class LightswitchStoryChiefFieldType implements StoryChiefFieldTypeInterface
{
    public function supportedStorychiefFieldTypes(): array
    {
        return [
            'select',
            'radio',
            'checkbox',
        ];
    }

    public function prepFieldData(Field $field, $fieldData): bool
    {
        return StoryChiefHelper::parseBoolean($fieldData);
    }
}
