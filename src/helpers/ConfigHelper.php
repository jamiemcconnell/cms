<?php
/**
 * @link      https://craftcms.com/
 * @copyright Copyright (c) Pixel & Tonic, Inc.
 * @license   https://craftcms.com/license
 */

namespace craft\helpers;

use yii\base\InvalidConfigException;

/**
 * Config helper
 *
 * @author Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @since  3.0
 */
class ConfigHelper
{
    /**
     * Normalizes a time duration value as a DateInterval object.
     *
     * Accepted formats:
     *
     * - integer (the duration in seconds)
     * - string (a [duration interval](https://en.wikipedia.org/wiki/ISO_8601#Durations))
     * - DateInterval object
     * - an empty value (represents 0 seconds)
     *
     * @param mixed $value
     *
     * @return \DateInterval
     * @throws InvalidConfigException if the duration can't be determined
     */
    public static function durationAsInterval($value): \DateInterval
    {
        if ($value instanceof \DateInterval) {
            return $value;
        }

        if (!$value) {
            $value = 0;
        }

        if (is_int($value)) {
            $value = 'PT'.$value.'S';
        }

        if (!is_string($value)) {
            throw new InvalidConfigException("Unable to convert {$value} to seconds.");
        }

        return new \DateInterval($value);
    }

    /**
     * Normalizes a time duration value into the number of seconds it represents.
     *
     * Accepted formats:
     *
     * - integer (the duration in seconds)
     * - string (a [duration interval](https://en.wikipedia.org/wiki/ISO_8601#Durations))
     * - DateInterval object
     * - an empty value (represents 0 seconds)
     *
     * @param mixed $value
     *
     * @return int The time duration in seconds
     * @throws InvalidConfigException if the duration can't be determined
     */
    public static function durationInSeconds($value): int
    {
        if (!$value) {
            return 0;
        }

        if (is_int($value)) {
            return $value;
        }

        if (is_string($value)) {
            $value = new \DateInterval($value);
        }

        if (!$value instanceof \DateInterval) {
            throw new InvalidConfigException("Unable to convert {$value} to seconds.");
        }

        return DateTimeHelper::dateIntervalToSeconds($value);
    }
}
