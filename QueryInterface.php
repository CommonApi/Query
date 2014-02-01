<?php
/**
 * Query Interface
 *
 * @package    Database
 * @copyright  2013 Common Api. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace CommonApi\Query;

/**
 * Query Interface
 *
 * @package    Database
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2013 Common Api. All rights reserved.
 * @since      0.1
 */
interface QueryInterface
{
    /**
     * Retrieves a new Query Object from the database, clearing the contents of the object, if necessary
     *
     *  $query = $adapter->getQueryObject();
     *
     *  $query->select('*');
     *  $query->from('#__actions');
     *  $query->where('status = 1');
     *  $query->order('id');
     *
     * @return  object
     * @since   0.1
     */
    public function getQueryObject();

    /**
     * Returns a string containing the query, resolved from the query object
     *
     * @return  string
     * @since   0.1
     */
    public function getQueryString();
}
