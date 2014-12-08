<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class blog_model extends CI_Model {

    /**
     * TODO: short description.
     *
     */
    function __construct() {
        parent::__construct();
    }

    public function getBlogs($limit = 0, $category = 0) {
        $mtag = "blogs-{$this->config->item('bmsCompanyID')}-{$limit}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {
            $this->db->select('id, title, category');
            $this->db->from('blogs');
            $this->db->where('active', 1);
            $this->db->where('deleted', 0);
            $this->db->where('company', $this->config->item('bmsCompanyID'));

            if (!empty($category))
                $this->db->where('category', $category);

            $this->db->order_by('datestamp', 'DESC');

            if ($limit > 0)
                $this->db->limit($limit);

            $query = $this->db->get();

            $data = $query->result();

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        return $data;
    }

    /**
     * gets column for a blog
     */
    public function getBlogCol($blog, $col) {
        $blog = intval($blog);

        if (empty($blog))
            throw new Exception("Blog ID is empty!");

        if (empty($col))
            throw new Exception("Blog Column is empty!");

        $mtag = "blogsCol-{$blog}-{$col}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {
            $this->db->select($col);
            $this->db->from('blogs');
            $this->db->where('id', $blog);
            $this->db->where('company', $this->config->item('bmsCompanyID'));

            $query = $this->db->get();

            $results = $query->result();

            $data = $results[0]->$col;

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        return $data;
    }

    public function getBlogInfo($blog) {
        $blog = intval($blog);

        if (empty($blog))
            throw new Exception("Blog ID is empty!");

        $mtag = "bloginfo-{$blog}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {
            $this->db->from('blogs');
            $this->db->where('id', $blog);
            $this->db->where('company', $this->config->item('bmsCompanyID'));

            $query = $this->db->get();

            $results = $query->result();

            $data = $results[0];

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        return $data;
    }

    public function saveComment($p) {
        $p['id'] = intval($p['id']);

        if (empty($p['id']))
            throw new Exception("Blog ID is empty!");

        $data = array
            (
            'datestamp' => DATESTAMP,
            'blog' => $p['id'],
            'comment' => $p['reviewDesc'],
            'approved' => 1,
            'IP' => $_SERVER['REMOTE_ADDR']
        );

        if ($this->session->userdata('logged_in') && empty($p['reviewName'])) {
            $data['userid'] = $this->session->userdata('userid');
        } else {
            $data['name'] = $p['reviewName'];
            $data['email'] = $p['reviewEmail'];
        }

        $this->db->insert("blogComments", $data);

        return $this->db->insert_id();
    }

    public function getComments($blog, $countOnly = false) {
        $blog = intval($blog);

        if (empty($blog))
            throw new Exception("Blog ID is empty!");

        $mtag = "blogComments-{$blog}-{$countOnly}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {
            if ($countOnly == false)
                $this->db->select('userid, datestamp, name, email, comment, rating');
            $this->db->from('blogComments');
            $this->db->where('blog', $blog);
            $this->db->order_by('datestamp', 'desc');

            if ($countOnly) {
                $data = $this->db->count_all_results();
            } else {
                $query = $this->db->get();

                $data = $query->result();
            }


            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        return $data;
    }

    public function getCategories() {
        $catCnt = array();

        // first gets all category ID's that are being used.
        $assignedCats = $this->getAssignedCategories();

        if (!empty($assignedCats)) {
            foreach ($assignedCats as $r) {
                $cnt = $this->getCatAssignedBlogs($r->category);
                $catCnt[$r->category] = $cnt;
            }
        }

        arsort($catCnt);

        return $catCnt;
    }

    /**
     * gets the number of blogs assigned to a category
     */
    public function getCatAssignedBlogs($category) {
        $category = intval($category);

        if (empty($category))
            throw new Exception("Category ID is empty!");

        $mtag = "catAssignedBlogs-{$category}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {
            $this->db->from('blogs');
            $this->db->where('category', $category);
            $this->db->where('company', $this->config->item('bmsCompanyID'));

            $data = $this->db->count_all_results();

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        return $data;
    }

    /**
     * gets all categories that are in use
     */
    public function getAssignedCategories() {
        $mtag = "blogAssignCats-{$this->config->item('bmsCompanyID')}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {
            $this->db->select('category');
            $this->db->from('blogs');
            $this->db->where('category <>', '0');
            $this->db->where('active', 1);
            $this->db->where('deleted', 0);
            $this->db->where('company', $this->config->item('bmsCompanyID'));
            $this->db->group_by('category');

            $query = $this->db->get();

            $data = $query->result();

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        return $data;
    }

    public function getCategoryName($category) {
        $category = intval($category);

        if (empty($category))
            throw new Exception("Category ID is empty!");

        $mtag = "catName-{$category}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {
            $this->db->select('name');
            $this->db->from('documentFolders');
            $this->db->where('company', $this->config->item('bmsCompanyID'));
            $this->db->where('id', $category);

            $query = $this->db->get();

            $results = $query->result();

            $data = $results[0]->name;

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        return $data;
    }

}
