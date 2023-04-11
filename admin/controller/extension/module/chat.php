<?php
class ControllerExtensionModulefilter extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/filter');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_filter', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/filter', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/module/filter', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		if (isset($this->request->post['module_filter_status'])) {
			$data['module_filter_status'] = $this->request->post['module_filter_status'];
		} else {
			$data['module_filter_status'] = $this->config->get('module_filter_status');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/filter', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/filter')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

    public function install() {
        //create a message table if doesn't exist
        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "filter` (
            `filter_id` int(11) NOT NULL AUTO_INCREMENT,
            `filter_name` varchar(255) NOT NULL,
            `filter_value` varchar(255) NOT NULL,
            `filter_type` varchar(255) NOT NULL,
            `filter_status` tinyint(1) NOT NULL,
            `filter_sort_order` int(11) NOT NULL,
             PRIMARY KEY (`filter_id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");       
    }
}