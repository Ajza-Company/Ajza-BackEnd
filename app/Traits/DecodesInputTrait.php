<?php

namespace App\Traits;

trait DecodesInputTrait
{
    /**
     * Decode input value for a given field, handling nested keys and arrays.
     *
     * @param string $field The field name (can be nested using dot notation)
     * @return void
     */
    protected function decodeInput(string $field): void
    {
        /*if (str_contains($field, '.*')) {
            $this->decodeArrayInput($field);
            return;
        }*/

        if (str_contains($field, '.*') && substr_count($field, '.') === 1) {
            $this->decodeSimpleArrayInput($field);
            return;
        }

        if (str_contains($field, '.*.')) {
            $this->decodeArrayInput($field);
            return;
        }

        // For nested keys like 'personal.car_brand_id', use the full path to get value
        $value = $this->input($field);

        if ($value && decodeString($value)) {
            $decoded = decodeString($value);

            // Handle nested keys
            $parts = explode('.', $field);

            if (count($parts) > 1) {
                // Get the base array (e.g., 'personal')
                $baseKey = $parts[0];
                // Get the actual field (e.g., 'car_brand_id')
                $field = $parts[1];

                // Get current values
                $current = $this->input($baseKey, []);

                // Merge the decoded value while preserving other fields
                $current[$field] = $decoded;

                // Update the request
                $this->merge([$baseKey => $current]);
            } else {
                // Non-nested key, use original behavior
                $this->merge([$field => $decoded]);
            }
        }
    }

    /**
     * Decode simple array input values.
     *
     * @param string $field The field name with wildcard (e.g., 'product_ids.*')
     * @return void
     */
    protected function decodeSimpleArrayInput(string $field): void
    {
        // Get the base array name by removing the .*
        $arrayKey = str_replace('.*', '', $field);

        // Get the array from input
        $array = $this->input($arrayKey, []);

        if (!is_array($array)) {
            return;
        }

        // Process each item in the array
        foreach ($array as $index => $value) {
            if ($value && function_exists('decodeString')) {
                $decoded = decodeString($value);
                $array[$index] = $decoded;
            }
        }

        // Update the request with the modified array
        $this->merge([$arrayKey => $array]);
    }

    /**
     * Decode input values for array fields with wildcards.
     *
     * @param string $field The field name with wildcard (e.g., 'sentences.*.voice_id')
     * @return void
     */
    protected function decodeArrayInput(string $field): void
    {
        // Split the field path into parts
        $parts = explode('.*.', $field);
        $arrayKey = $parts[0]; // e.g., 'sentences'
        $fieldKey = $parts[1]; // e.g., 'voice_id'

        // Get the array from input
        $array = $this->input($arrayKey, []);

        // Process each item in the array
        foreach ($array as $index => $item) {
            $value = $item[$fieldKey] ?? null;

            if ($value && decodeString($value)) {
                $decoded = decodeString($value);
                $array[$index][$fieldKey] = $decoded;
            }
        }

        // Update the request with the modified array
        $this->merge([$arrayKey => $array]);
    }
}