<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class wall_model extends CI_Model {

    /**
     * TODO: short description.
     *
     */
    function __construct() {
        parent::__construct();
    }

    public function getPosts($userid, $parentPost = 0, $limit = 10, $maxID = 0, $minID = 0, $order = 'DESC') {
        $userid = intval($userid);
        $parentPost = intval($parentPost);

        if (empty($userid))
            throw new Exception("UserID is empty!");

        $company = $this->config->item('bmsCompanyID');

        $mtag = "posts-{$userid}-{$parentPost}-{$limit}-{$company}-{$maxID}-{$minID}-{$order}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {

            $this->db->select('id, datestamp, userid, postingUser');
            $this->db->from('wallPosts');
            $this->db->where('userid', $userid);
            $this->db->where('parentPost', $parentPost);
            $this->db->where('company', $company);

            if (!empty($maxID))
                $this->db->where('id >', $maxID);
            if (!empty($minID))
                $this->db->where('id <', $minID);

            $this->db->order_by('datestamp', $order);

            if (!empty($limit))
                $this->db->limit($limit);

            $query = $this->db->get();

            $data = $query->result();

            // if ($parentPost == 68) error_log($this->db->last_query());

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        return $data;
    }

    public function getWallPosts($userid, $parentPost = 0, $limit = 10, $maxID = 0, $minID = 0, $order = 'DESC') {
        $userid = intval($userid);
        $parentPost = intval($parentPost);

        if (empty($userid))
            throw new Exception("UserID is empty!");

        $company = $this->config->item('bmsCompanyID');

        $mtag = "wall-posts-{$userid}-{$parentPost}-{$limit}-{$company}-{$maxID}-{$minID}-{$order}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {

            $this->db->select('id, datestamp, userid, postingUser');
            $this->db->from('wallPosts');
            $this->db->where('postingUser', $userid);
            $this->db->where('parentPost', $parentPost);
            $this->db->where('company', $company);

            if (!empty($maxID))
                $this->db->where('id >', $maxID);
            if (!empty($minID))
                $this->db->where('id <', $minID);

            $this->db->order_by('datestamp', $order);

            if (!empty($limit))
                $this->db->limit($limit);

            $query = $this->db->get();

            $data = $query->result();

            // if ($parentPost == 68) error_log($this->db->last_query());

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        return $data;
    }
    
    public function getPostBody($id) {
        $id = intval($id);

        if (empty($id))
            throw new Exception("Post ID is empty!");

        $mtag = "postBody-{$id}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {

            $this->db->select('body');
            $this->db->from('wallPosts');
            $this->db->where('id', $id);

            $query = $this->db->get();

            $results = $query->result();

            $data = $results[0]->body;

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        return $data;
    }

    // gets entire post row
    public function getPostInfo($id) {
        $id = intval($id);

        if (empty($id))
            throw new Exception("Post ID is empty!");

        $mtag = "postInfo-{$id}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {
            $this->db->from('wallPosts');
            $this->db->where('id', $id);

            $query = $this->db->get();

            $results = $query->result();

            $data = $results[0];

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        return $data;
    }

    public function insertPost($p) {
        $data = array
            (
            'datestamp' => DATESTAMP,
            'userid' => $p['userid'],
            'company' => $this->config->item('bmsCompanyID'),
            'postingUser' => $this->session->userdata('userid'),
            'body' => $p['post'],
            'parentPost' => $p['parentPost']
        );

        $this->db->insert('wallPosts', $data);

        return $this->db->insert_id();
    }

    public function likePost($postID) {
        $data = array
            (
            'datestamp' => DATESTAMP,
            'userid' => $this->session->userdata('userid'),
            'post' => $postID
        );

        $this->db->insert('wallPostLikes', $data);

        return $this->db->insert_id();
    }

    public function unlikePost($postID) {
        $this->db->where('userid', $this->session->userdata('userid'));
        $this->db->where('post', $postID);
        $this->db->delete('wallPostLikes');

        return true;
    }

    // checks if a user likes a post or not
    public function checkPostLiked($userid, $postID) {
        $userid = intval($userid);
        $postID = intval($postID);

        if (empty($userid))
            throw new Exception("User ID is empty!");
        if (empty($postID))
            throw new Exception("Post ID is empty!");

        $mtag = "checkLike-{$userid}-{$postID}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {

            $this->db->from('wallPostLikes');
            $this->db->where('userid', $userid);
            $this->db->where('post', $postID);

            $data = $this->db->count_all_results();

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        if ((int) $data > 0)
            return true;

        return false;
    }

    public function getLikeCnt($postID) {
        $postID = intval($postID);

        if (empty($postID))
            throw new Exception("Post ID is empty!");

        $mtag = "likeCnt-{$postID}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {

            $this->db->from('wallPostLikes');
            $this->db->where('post', $postID);

            $data = $this->db->count_all_results();

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        return $data;
    }

    public function setPhotoActive($userid, $img, $postID) {
        $userid = intval($userid);
        $postID = intval($postID);

        if (empty($userid))
            throw new Exception("User ID is empty!");
        if (empty($img))
            throw new Exception("Img filename is empty!");
        if (empty($postID))
            throw new Exception("Post ID is empty!");

        $data = array
            (
            'posted' => 1,
            'postID' => $postID
        );

        $this->db->where('userid', $userid);
        $this->db->where('fileName', $img);
        $this->db->update('albumPhotos', $data);

        return true;
    }

    public function getPostPhotos($postID) {
        $postID = intval($postID);

        if (empty($postID))
            throw new Exception("Post ID is empty!");

        $mtag = "postPhotos-{$postID}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {

            $this->db->select('id, fileName');
            $this->db->from('albumPhotos');
            $this->db->where('postID', $postID);

            $this->db->order_by('imgOrder');
            $this->db->order_by('datestamp');
            $this->db->order_by('fileName');

            $query = $this->db->get();

            $data = $query->result();

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        return $data;
    }

    public function getPhotoInfo($photoID) {
        $photoID = intval($photoID);

        if (empty($photoID))
            throw new Exception("Photo ID is empty!");

        $mtag = "photoInfo-{$photoID}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {
            $this->db->from('albumPhotos');
            $this->db->where('id', $photoID);

            $query = $this->db->get();

            $results = $query->result();

            $data = $results[0];

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        return $data;
    }

    // removes all rows for post likes
    public function deleteWallLikes($postID) {
        $postID = intval($postID);

        if (empty($postID))
            throw new Exception("Post ID is empty!");

        $this->db->where('post', $postID);
        $this->db->delete('wallPostLikes');

        return true;
    }

    public function deletePostByID($postID) {
        $postID = intval($postID);

        if (empty($postID))
            throw new Exception("Post ID is empty!");

        $this->db->where('id', $postID);
        $this->db->delete('wallPosts');

        return true;
    }

    // delets posts by the parent ID (used for removing post comments);
    public function deletePostsByParentPost($postID) {
        $postID = intval($postID);

        if (empty($postID))
            throw new Exception("Post ID is empty!");

        $this->db->where('parentPost', $postID);
        $this->db->delete('wallPosts');

        return true;
    }

}
