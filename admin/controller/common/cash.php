<?php
defined('_PATH') or die('Restricted!');

class ControllerCommonCash extends Controller {
    public function index() {
        $this->data = $this->load->language('common/cash');

       
        $this->data['header'] = $this->load->controller('common/header');
        $this->data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->render('common/cash'));
    }
}