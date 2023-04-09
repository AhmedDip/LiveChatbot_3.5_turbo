<?php

use Orhanerday\OpenAi\OpenAi;
use League\CommonMark\CommonMarkConverter;

class ControllerChatMessage extends Controller
{
    public function index()
    {
        require_once(__DIR__ . "/vendor/autoload.php");

        //load model for product
        $this->load->model('catalog/product');

        //load model for chat
        $this->load->model('catalog/chat');

        //get product id
        $product_id = $this->request->get['product_id'];

        if(isset($product_id) && !empty($product_id)) {
            $product_id = $product_id;
        } else {
            $product_id = 0;
        }
        //get product info
        $product_info = $this->model_catalog_product->getProduct($product_id);

        //get product all details to string
        //Get list of related products and merge with product name, model, price
        $related_products = $this->model_catalog_product->getProductRelated($product_id);
        $related_products_data = "";
        foreach ($related_products as $related_product) {
            $related_products_data .= $related_product['name'] . " " . $related_product['model'] . " " . $related_product['price'] . " " . "Product Link: " . $this->url->link('product/product', 'product_id=' . $related_product['product_id']) . " ";
        }



        $product_data = "Product Name: ". $product_info['name'] . " " . "Product Code: " . $product_info['model'] .  " " . "Availability: " . $product_info['stock_status'] . " " . "Price: " . $product_info['price'] . " " . "Description: " . $product_info['description'] . " " . "Product Tags: " . $product_info['tag'] . " " . "Product Manufacturer: " . $product_info['manufacturer'] . " " . "Quantity: " . $product_info['quantity'] . " " . "Product Reviews: " . $product_info['reviews'] . " " . "Product Image: " . $product_info['image'] ." "  . "Product Special: " . $product_info['special'] . " " . "Product Minimum: " . $product_info['minimum'] . "Related Products: " .  $related_products_data . " Only suggest those related products! Don't suggest other websites and products. Don't give others information except this data";
;

        $api_key = "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";

        $system_message = $product_data;
        header("Content-Type: application/json");

        $context = json_decode($_POST['context'] ?? "[]") ?: [];

        // initialize OpenAI api
        $openai = new OpenAi($api_key);

        $messages = [];

        if (!empty($system_message)) {
            $messages[] = [
                "role" => "system",
                "content" => $system_message,
            ];
        }

        // foreach ($context as $msg) {
        //     $messages[] = [
        //         "role" => "user",
        //         "content" => $msg[0],
        //     ];
        //     $messages[] = [
        //         "role" => "assistant",
        //         "content" => $msg[1],
        //     ]; 
        // }

        $messages[] = [
            "role" => "user",
            "content" => $_POST['message'] . ". Don't justify your answers. Don't give information not mentioned in the CONTEXT INFORMATION.",
        ];

       


        $complete = json_decode($openai->chat([
            'model' => 'gpt-3.5-turbo',
            'messages' => $messages,
            'temperature' => 1.0,
            'max_tokens' => 500,
            'frequency_penalty' => 0,
            'presence_penalty' => 0,
        ]));


        if (isset($complete->choices[0]->message->content)) {
            $text = str_replace("\\n", "\n", $complete->choices[0]->message->content);
        } elseif (isset($complete->error->message)) {
            $text = $complete->error->message;
        } else {
            $text = "Sorry, but I don't know how to answer that.";
        }


        // convert markdown to HTML
        $converter = new CommonMarkConverter();
        $styled = $converter->convert($text);

        // return response
        echo json_encode([
            "message" => (string)$styled,
            "raw_message" => $text,
            "status" => "success",
        ]);

        $message_data = array(
            'product_id' => $product_id,
            'user_message' => $_POST['message'],
            'bot_message' => $text,
            'date_added' => date('Y-m-d H:i:s')
        );

        // Save the message to the database using the chat model
        $this->model_catalog_chat->addMessage($message_data);

        
    }
}

