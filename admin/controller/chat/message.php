<?php 

class ControllerChatMessage extends Controller
{

    public function index()
    {
        $this->load->language('chat/message');

        $this->document->setTitle($this->language->get('heading_title'));

  
        $this->load->model('chat/message');

        $this->getList();
    }


    public function getAllData() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "chat_message");
    
        return $query->rows;
      }
    
      public function getData($id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "chat_message WHERE id = '" . (int)$id . "'");
    
        return $query->row;
      }
    
      public function addData($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "chat_message SET product_id = '" . (int)$data['product_id'] . "', user_message = '" . $this->db->escape($data['user_message']) . "', bot_message = '" . $this->db->escape($data['bot_message']) . "', date_added = NOW()");
    
        return $this->db->getLastId();
      }
    
      public function editData($id, $data) {
        $this->db->query("UPDATE " . DB_PREFIX . "chat_message SET product_id = '" . (int)$data['product_id'] . "', user_message = '" . $this->db->escape($data['user_message']) . "', bot_message = '" . $this->db->escape($data['bot_message']) . "', date_added = NOW() WHERE id = '" . (int)$id . "'");
      }



      public function deleteData($id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "chat_message WHERE id = '" . (int)$id . "'");
      }


      public function getList()
      {
            $data['heading_title'] = $this->language->get('heading_title');

            $data['text_list'] = $this->language->get('text_list');
            $data['text_no_results'] = $this->language->get('text_no_results');
            $data['text_confirm'] = $this->language->get('text_confirm');

            $data['column_name'] = $this->language->get('column_name');
            $data['column_description'] = $this->language->get('column_description');
            $data['column_action'] = $this->language->get('column_action');

            $data['button_add'] = $this->language->get('button_add');
            $data['button_edit'] = $this->language->get('button_edit');
            $data['button_delete'] = $this->language->get('button_delete');

            $data['user_token'] = $this->session->data['user_token'];

            // $data['add'] = $this->url->link('chat/message/add', 'token=' . $this->session->data['token'], true);
            // $data['delete'] = $this->url->link('chat/message/delete', 'token=' . $this->session->data['token'], true);

            $page = isset($this->request->get['page']) ? $this->request->get['page'] : 1;
            $limit = 10;

            $filter_data = array(
                'start' => ($page - 1) * $limit,
                'limit' => $limit
            );

            $data['messages'] = array();

            $results = $this->model_chat_message->getAllData($filter_data);

  
            //get product id
            


            if (isset($this->request->get['product_id'])) {
              $page .= '&page=' . $this->request->get['product_id'];
          }
        
            $data['header'] = $this->load->controller('common/header');
            $data['column_left'] = $this->load->controller('common/column_left');
            $data['footer'] = $this->load->controller('common/footer');
        


            foreach ($results as $result) {
                $data['messages'][] = array(
                    'id' => $result['id'],
                    'product_id' => $result['product_id'],
                    'pname' => $result['pname'],
                    'user_message' => $result['user_message'],
                    'bot_message' => $result['bot_message'],
                    'date_added' => $result['date_added'],
                    // 'edit' => $this->url->link('chat/message/edit', 'token=' . $this->session->data['token'] . '&id=' . $result['id'], true),
                    // 'delete' => $this->url->link('chat/message/delete', 'token=' . $this->session->data['token'] . '&id=' . $result['id'], true)
                );
            }

            //Adding Pagination
            $pagination = new Pagination();
            $pagination->total = $this->model_chat_message->getTotalData();
            $pagination->page = $page;
            $pagination->limit = $limit;
            $pagination->url = $this->url->link('chat/message', 'user_token=' . $this->session->data['user_token'] . '&page={page}', true);

            $data['pagination'] = $pagination->render();

            $data['results'] = sprintf($this->language->get('text_pagination'), ($pagination->total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($pagination->total - $limit)) ? $pagination->total : ((($page - 1) * $limit) + $limit), $pagination->total, ceil($pagination->total / $limit));
            
            



            $data['header'] = $this->load->controller('common/header');
            $data['column_left'] = $this->load->controller('common/column_left');
            $data['footer'] = $this->load->controller('common/footer');

            $this->response->setOutput($this->load->view('chat/message_list', $data));
      }
      

}











?>