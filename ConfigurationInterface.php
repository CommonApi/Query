<?php
/**
 * Configuration Interface
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace CommonApi\Query;

/**
 * Configuration Interface
 *
 * @package    Query
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
interface ConfigurationInterface
{
    /**
     * Load model registry requested 
     *
     * @param   string $model_type
     * @param   string $model_name
     * @param   object $xml
     *
     * @return  string
     * @since   1.0.0
     */
    public function getConfiguration($model_type, $model_name, $xml);
}
