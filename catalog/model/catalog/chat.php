<?php
class ModelCatalogChat extends Model {
    public function addMessage($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "chat_message SET product_id = '" . (int)$data['product_id'] . "', user_message = '" . $this->db->escape($data['user_message']) . "', bot_message = '" . $this->db->escape($data['bot_message']) . "', date_added = NOW()");
    }
}
