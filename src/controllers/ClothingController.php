<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/Clothing.php';

class ClothingController extends AppController
{

    const MAX_FILE_SIZE = 5 * 1024 * 1024; //5 MB
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    const UPLOAD_DIRECTORY = '/../public/uploads/';

    private $messages = [];

    public function addClothing()
    {

        if($this->isPost() && is_uploaded_file($_FILES['file']['tmp_name'])  && $this->isValidated($_FILES['file'])) {

            move_uploaded_file(
                $_FILES['file']['tmp_name'],
                dirname(__DIR__).self::UPLOAD_DIRECTORY.$_FILES['file']['name']
            );
            $clothing = new Clothing($_POST['name'], $_POST['category'], $_FILES['file']['name']);

            $this->messages[] = 'Picture added';
            $this->render('add-clothing', ['messages' => $this->messages, 'clothing' => $clothing]);
        }

        $this->render('add-clothing', ['messages' => $this->messages]);
    }

    private function isValidated(array $file) : bool
    {
        if($file['size'] > self::MAX_FILE_SIZE) {
            $this->messages[] = 'File is too large.';
            return false;
        }

        if(!isset($file['type']) && !in_array($file['type'], self::SUPPORTED_TYPES)) {
            $this->messages[] = 'Filetype not supported.';
            return false;
        }

        return true;
    }


}