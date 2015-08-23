<?php
/**
 * Database Connection Interface
 *
 * @package    Query
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace CommonApi\Query;

/**
 * Database Connection Interface
 *
 * @package    Query
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0
 */
interface ConnectionInterface
{
    /**
     * Connect to the Database, passing in credentials and other data needed
     *
     * @param   array $options
     *
     * @return  $this
     * @since   1.0.0
     */
    public function connect(array $options = array());

    /**
     * Disconnects from Database and removes the database connection, freeing resources
     *
     * @return  $this
     * @since   1.0.0
     */
    public function disconnect();
}
