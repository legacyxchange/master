<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Blog extends CI_Controller {

    /**
     * TODO: short description.
     *
     * @return TODO
     */
    function Blog() {
        parent::__construct();
        $this->load->driver('cache');
        $this->load->model('blog_model', 'blog', true);

        //$this->functions->checkLoggedIn();
    }

    public function index() {
        $header['headscript'] = $this->functions->jsScript('blog.js');

        $header['onload'] = "blog.indexInit();";

        $body['category'] = $category = $_GET['category'];

        try {
            $body['blogs'] = $this->blog->getBlogs(0, $category);

            if (!empty($category))
                $body['catName'] = $this->blog->getCategoryName($category);
        } catch (Exception $e) {
            $this->functions->sendStackTrace($e);
        }

        $this->load->view('template/header', $header);
        $this->load->view('blog/index', $body);
        $this->load->view('template/footer');
    }

    public function view($id) {
        $header['headscript'] = $this->functions->jsScript('blog.js');

        $header['onload'] = "blog.viewInit();";


        $body['id'] = $id;

        try {
            $body['info'] = $info = $this->blog->getBlogInfo($id);

            $body['date'] = $this->functions->convertTimezone($this->session->userdata('user_id'), $info->publishDate, "m/d/Y");

            $body['comments'] = $this->blog->getComments($id);
        } catch (Exception $e) {
            $this->functions->sendStackTrace($e);
        }

        $this->load->view('template/header', $header);
        $this->load->view('blog/view', $body);
        $this->load->view('template/footer');
    }

    public function savecomment() {
        if ($_POST) {
            try {
                $this->blog->saveComment($_POST);

                $this->functions->jsonReturn('SUCCESS', 'Comment has been submitted!');
            } catch (Exception $e) {
                $this->functions->sendStackTrace($e);

                $this->functions->jsonReturn('ERROR', $e->getMessage());
            }
        }
    }

}
