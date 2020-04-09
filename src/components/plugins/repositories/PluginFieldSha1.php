<?php
namespace extas\components\plugins\repositories;

use extas\components\repositories\FieldAdaptor;
use extas\components\repositories\FieldAdaptorPlugin;
use extas\interfaces\repositories\IFieldAdaptor;

/**
 * Class PluginUuidField
 *
 * @package extas\components\plugins\repositories
 * @author jeyroik <jeyroik@gmail.com>
 */
class PluginFieldSha1 extends FieldAdaptorPlugin
{
    /**
     * @return array
     */
    protected function getMarkers()
    {
        return [
            /**
             * Example: @sha1(sourceValue)
             */
            new class () extends FieldAdaptor implements IFieldAdaptor {

                public function apply(string $value)
                {
                    preg_match('/@sha1\((.*)\)/', $value, $match);

                    return $match[1] ?? $value;
                }

                public function isApplicable($value): bool
                {
                    preg_match('/@sha1\((.*)\)/', $value, $match);

                    return isset($match[1]);
                }
            }
        ];
    }
}
