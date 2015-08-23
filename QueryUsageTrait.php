<?php
/**
 * Query Usage Trait
 *
 * @package    CommonApi
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace CommonApi\Query;

use CommonApi\Exception\RuntimeException;
use Exception;
use stdClass;

/**
 * Query Usage Trait
 *
 * Requires: CommonApi\Fieldhandler\FieldhandlerUsageTrait
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @since      1.0.0
 */
trait QueryUsageTrait
{
    /**
     * Resource Instance
     *
     * @var    object
     * @since  1.0
     */
    protected $resource;

    /**
     * Runtime Data
     *
     * @var    object
     * @since  1.0
     */
    protected $runtime_data;

    /**
     * Model Registry
     *
     * @var    array
     * @since  1.0.0
     */
    protected $model_registry;

    /**
     * Query Object
     *
     * @var    object  CommonApi\Query\QueryInterface
     * @since  1.0.0
     */
    protected $query;

    /**
     * Custom Field Groups
     *
     * @var    array
     * @since  1.0.0
     */
    protected $customfieldgroups = array();

    /**
     * Executed SQL
     *
     * @var    string
     * @since  1.0.0
     */
    protected $executed_sql;

    /**
     * Set Query Controller
     *
     * @param   string $namespace
     * @param   string $crud_type
     *
     * @return  $this
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function setQueryController($namespace, $crud_type = 'Read')
    {
        $options = $this->setQueryOptions($crud_type);

        try {
            $this->query = $this->resource->get('query://' . $namespace, $options);

        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage());
        }

        return $this;
    }

    /**
     * Set Query Options
     *
     * @param   string $crud_type
     *
     * @return  array
     * @since   1.0.0
     */
    protected function setQueryOptions($crud_type = 'Read')
    {
        $options   = array();
        $crud_type = ucfirst(strtolower($crud_type));

        if ($crud_type === 'Create'
            || $crud_type === 'Read'
            || $crud_type === 'Update'
            || $crud_type === 'Delete'
        ) {
        } else {
            $crud_type = 'Read';
        }

        $options['crud_type']    = $crud_type;
        $options['runtime_data'] = $this->runtime_data;

        if (isset($this->plugin_data)) {
            $options['plugin_data'] = $this->plugin_data;
        }

        return $options;
    }

    /**
     * Set Query Controller Default Values
     *
     * @param   integer $process_events
     * @param   string  $query_object
     * @param   integer $get_customfields
     * @param   integer $use_special_joins
     * @param   integer $use_pagination
     * @param   integer $check_view_level_access
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function setQueryControllerDefaults(
        $process_events = 0,
        $query_object = 'item',
        $get_customfields = 0,
        $use_special_joins = 0,
        $use_pagination = 0,
        $check_view_level_access = 0,
        $get_item_children = 0
    ) {
        $this->query->setModelRegistry('process_events', $process_events);
        $this->query->setModelRegistry('query_object', $query_object);
        $this->query->setModelRegistry('get_customfields', $get_customfields);
        $this->query->setModelRegistry('use_special_joins', $use_special_joins);
        $this->query->setModelRegistry('use_pagination', $use_pagination);
        $this->query->setModelRegistry('check_view_level_access', $check_view_level_access);
        $this->query->setModelRegistry('get_item_children', $get_item_children);

        return $this;
    }

    /**
     * Set Model Registry
     *
     * @return  object
     * @since   1.0.0
     */
    protected function setModelRegistry()
    {
        $this->model_registry = $this->query->getModelRegistry();

        return $this->model_registry;
    }

    /**
     * Run Query
     *
     * @param   string      $method
     * @param   null|string $sql
     * @param   integer     $standard_criteria
     *
     * @return  mixed
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function runQuery($method = 'getData', $sql = null, $standard_criteria = 1)
    {
        if ($sql === null && (int)$standard_criteria === 1) {
            $this->setModelRegistryCriteria();
        }

        $this->executed_sql = $this->query->setSql($sql);

        try {
            return $this->query->$method();

        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    /**
     * Set Standard Model Registry Criteria
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function setModelRegistryCriteria()
    {
        $prefix = $this->query->getModelRegistry('primary_prefix', 'a');

        $this->setModelRegistryCatalogTypeIdCriteria($prefix);
        $this->setModelRegistryExtensionInstanceIdCriteria($prefix);
        $this->setModelRegistryMenuIdCriteria($prefix);
        $this->setModelRegistryStatusCriteria($prefix);

        return $this;
    }

    /**
     * Set Standard Model Registry Criteria: Catalog Type ID
     *
     * @param   string $prefix
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function setModelRegistryCatalogTypeIdCriteria($prefix)
    {
        $catalog_type_id = $this->query->getModelRegistry('criteria_catalog_type_id', '');

        if ((int)$catalog_type_id === 0) {
        } elseif (isset($this->model_registry['fields']['catalog_type_id'])) {
            $this->query->where('column', $prefix . '.' . 'catalog_type_id', 'IN', 'integer', $catalog_type_id);
        }

        return $this;
    }

    /**
     * Set Standard Model Registry Criteria: Extension Instance ID
     *
     * @param   string $prefix
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function setModelRegistryExtensionInstanceIdCriteria($prefix)
    {
        $e = (int)$this->query->getModelRegistry('criteria_extension_instance_id', 0);

        if ((int)$e === 0) {
        } elseif (isset($this->model_registry['fields']['extension_instance_id'])) {
            $this->query->where('column', $prefix . '.extension_instance_id', '=', 'integer', (int)$e);
        }

        return $this;
    }


    /**
     * Set Standard Model Registry Criteria: Menu ID
     *
     * @param   string $prefix
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function setModelRegistryMenuIdCriteria($prefix)
    {
        $menu_id = (int)$this->query->getModelRegistry('criteria_menu_id', 0);

        if ((int)$menu_id === 0) {
        } elseif (isset($this->model_registry['fields']['menu_id'])) {
            $this->query->where('column', $prefix . '.menu_id', '=', 'integer', (int)$menu_id);
        }

        return $this;
    }

    /**
     * Set Standard Model Registry Criteria: Status
     *
     * @param   string $prefix
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function setModelRegistryStatusCriteria($prefix)
    {
        $criteria_status = $this->query->getModelRegistry('criteria_status', '');

        if (trim($criteria_status) === '' || trim($criteria_status) === '0') {
        } else {
            $this->query->where('column', $prefix . '.status', 'IN', 'string', $criteria_status);
        }

        return $this;
    }

    /**
     * Set Standard Fields
     *
     * @param   object $data
     * @param   array  $model_registry
     *
     * @return  stdClass
     * @since   1.0.0
     */
    protected function setStandardFields($data, array $model_registry = array())
    {
        $fields = $model_registry['fields'];

        $this->customfieldgroups = $model_registry['customfieldgroups'];

        $base = $this->processQueryFields($data, $fields);

        return $this->sortObject($base);
    }

    /**
     * Set Custom Fields
     *
     * @param   object $base
     * @param   object $data
     * @param   array  $model_registry
     *
     * @return  object
     * @since   1.0.0
     */
    protected function setCustomFields($base, $data, array $model_registry = array())
    {
        if (count($this->customfieldgroups) > 0) {
        } else {
            return $base;
        }

        foreach ($this->customfieldgroups as $group) {
            $group_data   = $this->processQueryFields(json_decode($data->$group), $model_registry [$group]);
            $base->$group = $this->sortObject($group_data);
        }

        return $base;
    }

    /**
     * Process Fields
     *
     * @param   object $data
     * @param   array  $fields
     *
     * @return  object
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function processQueryFields($data, array $fields = array())
    {
        $base = new stdClass();

        if (count($fields) === 0) {
            return $base;
        }

        foreach ($fields as $key => $field) {

            $this->verifyFieldDefined($key, $field);

            if (in_array($field['name'], $this->customfieldgroups)
                || $field['type'] === 'customfield'
            ) {
            } else {
                $base->$field['name'] = $this->processQueryField($data, $field);
            }
        }

        return $this->sortObject($base);
    }

    /**
     * Verify Field is Defined
     *
     * @param   string $key
     * @param   array  $fields
     *
     * @return  $this
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function verifyFieldDefined($key, $field)
    {
        if (count($field) === 0) {

            throw new RuntimeException(
                get_class($this)
                . ' Field: ' . $key . ' not defined '
                . ' in QueryUsageTrait::processQueryFields.'
            );
        }

        return $this;
    }

    /**
     * Process Field
     *
     * @param   object $data
     * @param   object $field
     *
     * @return  mixed
     * @since   1.0.0
     */
    protected function processQueryField($data, $field)
    {
        $default        = $this->setFieldDefaultValue($field);
        $field['value'] = $this->setFieldValue($field['name'], $data, $default);
        $field['type']  = $this->setFieldDataType($field);

        return $this->processField('sanitize', $field);
    }

    /**
     * Set default value for field
     *
     * @param   object $field
     *
     * @return  stdClass
     * @since   1.0.0
     */
    protected function setFieldDefaultValue($field)
    {
        $default = null;

        if (isset($field['default'])) {
            $default = $field['default'];
        }

        return $default;
    }

    /**
     * Set Value for Field
     *
     * @param   string     $key
     * @param   object     $data
     * @param   null|mixed $default
     *
     * @return  stdClass
     * @since   1.0.0
     */
    protected function setFieldValue($key, $data, $default = null)
    {
        $value = null;

        if (isset($data->$key)) {
            $value = $data->$key;
        }

        if ($value === null) {
            $value = $default;
        }

        return $value;
    }

    /**
     * Set data type for field
     *
     * @param   object $field
     *
     * @return  string
     * @since   1.0.0
     */
    protected function setFieldDataType($field)
    {
        $data_type = 'string';

        if (isset($field['type'])) {
            $data_type = $field['type'];
        }

        return $data_type;
    }

    /**
     * Sort an object
     *
     * @param   object $object
     *
     * @return  object
     * @since   1.0.0
     */
    protected function sortObject($object)
    {
        $sort_array = get_object_vars($object);
        ksort($sort_array);

        $new_object = new stdClass();
        foreach ($sort_array as $key => $value) {
            if (is_object($value)) {
                $value = $this->sortObject($value);
            }
            $new_object->$key = $value;
        }

        unset($sort_array);
        unset($object);

        return $new_object;
    }
}
