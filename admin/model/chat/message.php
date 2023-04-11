<?php 

class ModelChatMessage extends Model {

    //retrive all chat messages
    public function getAllData($data=array()) {
        // $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "chat_message ORDER BY id ASC LIMIT " . (int)$data['start'] . "," . (int)$data['limit'] );
    
        // return $query->rows;

      //  $query = $this->db->query("SELECT chat_message.*, product_description.name as pname
      //                      FROM " . DB_PREFIX . "chat_message
      //                      LEFT JOIN " . DB_PREFIX . "product_description pd ON cm.product_id = .product_description.product_id
      //                      ORDER BY cm.id ASC LIMIT " . (int)$data['start'] . "," . (int)$data['limit']);

      //Write this query without any error

      $query = $this->db->query("SELECT cm.*, pd.name as pname
                          FROM " . DB_PREFIX . "chat_message cm
                          LEFT JOIN " . DB_PREFIX . "product_description pd ON cm.product_id = pd.product_id
                          ORDER BY cm.id ASC LIMIT " . (int)$data['start'] . "," . (int)$data['limit']);

                          // var_dump($query->rows);
                          // exit();

      return $query->rows;

      
      }

      //get total chat messages
      public function getTotalData() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "chat_message");
    
        return $query->row['total'];
      }
    
      //retrive chat message by id
      public function getData($id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "chat_message WHERE id = '" . (int)$id . "'");
    
        return $query->row;
      }
    
      //add chat message
      public function addData($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "chat_message SET product_id = '" . (int)$data['product_id'] . "', user_message = '" . $this->db->escape($data['user_message']) . "', bot_message = '" . $this->db->escape($data['bot_message']) . "', date_added = NOW()");
    
        return $this->db->getLastId();
      }
    
      //edit chat message
      public function editData($id, $data) {
        $this->db->query("UPDATE " . DB_PREFIX . "chat_message SET product_id = '" . (int)$data['product_id'] . "', user_message = '" . $this->db->escape($data['user_message']) . "', bot_message = '" . $this->db->escape($data['bot_message']) . "', date_added = NOW() WHERE id = '" . (int)$id . "'");
      }
    
      //delete chat message
      public function deleteData($id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "chat_message WHERE id = '" . (int)$id . "'");
      }


}

?>