<?php
/**
 * Database Interface
 *
 * @package    Query
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace CommonApi\Query;

/**
 * Database Interface
 *
 * @package    Query
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0
 */
interface DatabaseInterface
{
    /**
     * Query the database and return a single value as the result
     *
     * @param   string $sql
     *
     * @return  object
     * @since   1.0.0
     */
    public function loadResult($sql);

    /**
     * Query the database and return an array of object values returned from query
     *
     * @param   string $sql
     *
     * @return  array
     * @since   1.0.0
     */
    public function loadObjectList($sql);

    /**
     * Execute the Database Query
     *
     * @param   string $sql
     *
     * @return  object
     * @since   1.0.0
     */
    public function execute($sql);

    /**
     * Returns the primary key following insert
     *
     * @return  integer
     * @since   1.0.0
     */
    public function getInsertId();
}
