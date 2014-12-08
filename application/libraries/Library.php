<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require_once 'LibraryTemplate.php';
/**
 * TODO: short description.
 *
 * TODO: long description.
 *
 */
class Library
{
	public $dbConnected;

    /**
     * TODO: description.
     *
     * @var mixed
     */
    public $tableName;
    /**
     * TODO: description.
     *
     * @var mixed
     */
    protected $ci;

    /**
     * TODO: short description.
     *
     */
    public function __construct()
    {
        $this->ci =& get_instance();

		$this->dbConnected = true;
		        
	    // if connected to DB
        if (!class_exists('CI_DB'))
        {
//            $this->dbConnected = false;
        }
    }

    /**
     * TODO: short description.
     *
     * @param mixed $col 
     *
     * @return TODO
     */
    public function getTableValue($col, $id)
    {
        if (empty($this->tableName)) throw new Exception('table name is empty!');
        if (empty($col)) throw new Exception('column name is empty!');
        if (empty($id)) throw new Exception('row id is empty!');

        $mtag = "table-value-{$this->tableName}-{$col}-{$id}";

        $data = $this->ci->cache->memcached->get($mtag);

        if (empty($data))
        {
            $this->ci->db->select($col);

            $this->ci->db->from($this->tableName);
            $this->ci->db->where('id', $id);

            $query = $this->ci->db->get();

            // error_log('SQL: ' . $this->ci->db->last_query());

            $results = $query->result();

            $data = $results[0]->{$col};

            $this->ci->cache->memcached->save($mtag, $data, $this->ci->config->item('cache_timeout'));
        }

        return $data;
    }

    /**
     * Pulls a row from the DB
     *
     * @param mixed $id - ID of row
     *
     * @return objct
     */
    public function getRow ($id)
    {
        $id = intval($id);

        if (empty($this->tableName)) throw new Exception('table name is empty!');
        if (empty($id)) throw new Exception('row id is empty!');

        $mtag = "tblRowVal-{$this->tableName}-{$id}";

        $data = $this->ci->cache->memcached->get($mtag);

        if (empty($data))
        {
            $this->ci->db->from($this->tableName);
            $this->ci->db->where('id', $id);

            $query = $this->ci->db->get();

            $results = $query->result();

            $data = $results[0];

            $this->ci->cache->memcached->save($mtag, $data, $this->ci->config->item('cache_timeout'));
        }

        return $data;
    }
}
