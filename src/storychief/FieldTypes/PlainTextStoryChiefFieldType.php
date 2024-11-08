<?php namespace storychief\storychiefv3\storychief\FieldTypes;

use craft\base\Field;

class PlainTextStoryChiefFieldType implements StoryChiefFieldTypeInterface
{
    public function supportedStorychiefFieldTypes(): array
    {
        return [
            'text',
            'textarea',
            'excerpt',
        ];
    }

    public function prepFieldData(Field $field, $fieldData): ?string
    {
        return $fieldData;
    }
}
