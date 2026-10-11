<?php

namespace App\Modules\Products\Support;

class ProductSpecsSchema
{
    /**
     * Define the allowed spec keys with their labels and default units.
     * This is the single source of truth for product specifications structure.
     *
     * Structure:
     * [
     *   'key' => [
     *     'label' => 'Translation key for the label',
     *     'unit' => 'Default unit (nullable)',
     *   ]
     * ]
     */
    public const SCHEMA = [
        'flow_rate' => [
            'label' => 'products.specs.flow_rate',
            'unit' => 'm³/h',
        ],
        'inlet_temp' => [
            'label' => 'products.specs.inlet_temp',
            'unit' => '°C',
        ],
        'outlet_temp' => [
            'label' => 'products.specs.outlet_temp',
            'unit' => '°C',
        ],
        'wet_bulb' => [
            'label' => 'products.specs.wet_bulb',
            'unit' => '°C',
        ],
        'fan_power' => [
            'label' => 'products.specs.fan_power',
            'unit' => 'kW',
        ],
        'motor_power' => [
            'label' => 'products.specs.motor_power',
            'unit' => 'kW',
        ],
        'material' => [
            'label' => 'products.specs.material',
            'unit' => null,
        ],
        'weight' => [
            'label' => 'products.specs.weight',
            'unit' => 'kg',
        ],
        'dimensions' => [
            'label' => 'products.specs.dimensions',
            'unit' => 'mm',
        ],
        'noise_level' => [
            'label' => 'products.specs.noise_level',
            'unit' => 'dB',
        ],
    ];

    /**
     * Get all allowed spec keys.
     *
     * @return array<int, string>
     */
    public static function getAllowedKeys(): array
    {
        return array_keys(self::SCHEMA);
    }

    /**
     * Check if a spec key is valid.
     */
    public static function isValidKey(string $key): bool
    {
        return array_key_exists($key, self::SCHEMA);
    }

    /**
     * Get the label translation key for a spec.
     */
    public static function getLabelKey(string $key): ?string
    {
        return self::SCHEMA[$key]['label'] ?? null;
    }

    /**
     * Get the default unit for a spec.
     */
    public static function getUnit(string $key): ?string
    {
        return self::SCHEMA[$key]['unit'] ?? null;
    }

    /**
     * Validate the specs array structure (strict mode).
     *
     * Each spec must have exactly 3 fields: key, value, unit
     * - key: string, must be in allowed schema
     * - value: string
     * - unit: string or null (but must exist)
     *
     * @param array $specs
     * @return bool
     */
    public static function validate(array $specs): bool
    {
        foreach ($specs as $spec) {
            // Each spec must be an array
            if (!is_array($spec)) {
                return false;
            }

            // Must have exactly 3 keys: key, value, unit (no more, no less)
            $allowedKeys = ['key', 'value', 'unit'];
            $specKeys = array_keys($spec);
            sort($specKeys);
            sort($allowedKeys);
            if ($specKeys !== $allowedKeys) {
                return false;
            }

            // Key must be string and valid
            if (!is_string($spec['key']) || !self::isValidKey($spec['key'])) {
                return false;
            }

            // Value must be string
            if (!is_string($spec['value'])) {
                return false;
            }

            // Unit must be string or null (but must exist)
            if ($spec['unit'] !== null && !is_string($spec['unit'])) {
                return false;
            }
        }

        return true;
    }
}