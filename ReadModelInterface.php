<?php
/**
 * Read Model Interface
 *
 * @package    Query
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace CommonApi\Query;

/**
 * Read Model Interface
 *
 * @package    Query
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0
 */
interface ReadModelInterface
{
    /**
     * Execute query and return data
     *
     * @param   string $query_object
     * @param   string $sql
     *
     * @return  mixed
     * @since   1.0.0
     */
    public function getData($query_object, $sql);
}
