<?php

namespace storychief\storychiefv3\variables;

use storychief\storychiefv3\storychief\FieldTypes\StoryChiefFieldTypeInterface;
use storychief\storychiefv3\storychief\Helpers\StoryChiefHelper;
use craft;

class StoryChiefVariable
{
    public function getStoryChiefSections(): array
    {
        $sections = [];
        foreach ((new craft\services\Entries())->getAllSections() as $section) {
            if ($section->type === 'channel') {
                $sections[] = [
                    'label' => $section->name,
                    'value' => $section->id,
                ];
            }
        }

        return $sections;
    }

    public function getAllStoryChiefFields(): array
    {
        $default_fields = [
            [
                'label' => 'Content',
                'name' => 'content',
                'type' => 'textarea',
            ],
            [
                'label' => 'Excerpt',
                'name' => 'excerpt',
                'type' => 'textarea',
            ],
            [
                'label' => 'Featured image',
                'name' => 'featured_image',
                'type' => 'image',
            ],
            [
                'label' => 'Tags',
                'name' => 'tags',
                'type' => 'tags',
            ],
            [
                'label' => 'Categories',
                'name' => 'categories',
                'type' => 'categories',
            ],
            [
                'label' => 'SEO Title',
                'name' => 'seo_title',
                'type' => 'text',
            ],
            [
                'label' => 'SEO Description',
                'name' => 'seo_description',
                'type' => 'textarea',
            ],
        ];

        $settings = Craft::$app->plugins->getPlugin('storychief-v3')->getSettings();
        $custom_fields = $settings['custom_field_definitions'];

        return array_merge($default_fields, $custom_fields);
    }

    public function getStoryChiefFieldOptions($fieldHandle)
    {
        $field = \Craft::$app->fields->getFieldByHandle($fieldHandle);
        $class = StoryChiefHelper::getStoryChiefFieldClass($field);

        if (! $class || ! class_exists($class)) {
            return null;
        }

        $scField = new $class();
        if (! $scField instanceof StoryChiefFieldTypeInterface) {
            return null;
        }

        $allFields = $this->getAllStoryChiefFields();
        $supportedTypes = $scField->supportedStorychiefFieldTypes();
        $options = [];

        foreach ($allFields as $item) {
            if (in_array($item['type'], $supportedTypes, true)) {
                $options[] = [
                    'label' => $item['label'],
                    'value' => $item['name'],
                ];
            }
        }

        return empty($options) ? null : $options;
    }

    public function getStoryChiefAuthorOptions(): array
    {
        return [
            [
                'label' => 'Don\'t import',
                'value' => '',
            ],
            [
                'label' => 'Import',
                'value' => 'import',
            ],
            [
                'label' => 'Import or create new',
                'value' => 'create',
            ],
        ];
    }

    public function getStoryChiefEntryTypes($sectionID): array
    {
        $entryTypes = [];
        foreach (\Craft::$app->entries->getEntryTypesBySectionId($sectionID) as $entryType) {
            $entryTypes[] = [
                'label' => $entryType->name,
                'value' => $entryType->id,
            ];
        }

        return $entryTypes;
    }

    public function getStoryChiefContentFields($entryTypeID): array
    {
        $fieldDefinitions = [];

        $entryType = \Craft::$app->entries->getEntryTypeById($entryTypeID);

        $fields = $entryType->getFieldLayout()->getCustomFields();

        foreach ($fields as $field) {
            $fieldDefinition = $field->getAttributes(['id', 'name', 'handle']);
            $fieldDefinition['required'] = $field->required === '1';
            $fieldDefinitions[] = $fieldDefinition;
        }

        return $fieldDefinitions;
    }
}
