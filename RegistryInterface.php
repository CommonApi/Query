<?php
/**
 * Registry Interface
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace CommonApi\Query;

/**
 * Registry Interface
 *
 * @package    Query
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
interface RegistryInterface
{
    /**
     * Verifies if registry, or registry key, exists
     *
     * @param   string      $name
     * @param   null|string $key
     *
     * @return  boolean
     * @since   1.0.0
     */
    public function exists($name, $key = null);

    /**
     * Create a registry
     *
     * @param   string $name
     *
     * @return  array
     * @since   1.0.0
     */
    public function createRegistry($name);

    /**
     * Get Registry Data
     *
     * @param   string $name
     * @param   string $key
     *
     * @return  mixed
     * @since   1.0.0
     */
    public function get($name, $key = null);

    /**
     * Sets the value for a specific registry $key $value pair
     *
     * @param   string $name
     * @param   string $key
     * @param   mixed  $value
     *
     * @return  $this
     * @since   1.0.0
     */
    public function set($name, $key, $value = null);

    /**
     * Sort Registry
     *
     * @param   string $name
     *
     * @return  $this
     * @since   1.0.0
     */
    public function sort($name);
}
