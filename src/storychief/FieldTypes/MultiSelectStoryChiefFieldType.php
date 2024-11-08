<?php namespace storychief\storychiefv3\storychief\FieldTypes;

use craft\base\Field;

class MultiSelectStoryChiefFieldType implements StoryChiefFieldTypeInterface
{
    public function supportedStorychiefFieldTypes(): array
    {
        return [
            'select',
        ];
    }

    public function prepFieldData(Field $field, $fieldData): array
    {
        $preppedData = [];

        if (empty($fieldData)) {
            return $preppedData;
        }
        if (! is_array($fieldData)) {
            $fieldData = [$fieldData];
        }

        $options = $field->options;

        foreach ($options as $option) {
            foreach ($fieldData as $dataValue) {
                if ($dataValue == $option['value']) {
                    $preppedData[] = $option['value'];
                }
            }
        }

        return $preppedData;
    }
}
