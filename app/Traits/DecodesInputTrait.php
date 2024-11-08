<?php

namespace App\Traits;

use Illuminate\Support\Arr;

trait DecodesInputTrait
{
    /**
     * Decode input value for a given field, handling nested keys.
     *
     * @param string $field The field name (can be nested using dot notation)
     * @return void
     */
    protected function decodeInput(string $field): void
    {
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
}
