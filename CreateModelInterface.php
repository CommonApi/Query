<?php
/**
 * Create Model Interface
 *
 * @package    Query
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace CommonApi\Query;

/**
 * Create Model Interface
 *
 * @package    Query
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0
 */
interface CreateModelInterface
{
    /**
     * Insert Data
     *
     * @param   string $sql
     *
     * @return  mixed
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function insertData($sql);
}
