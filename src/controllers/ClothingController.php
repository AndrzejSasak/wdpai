<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/Clothing.php';
require_once __DIR__.'/../repository/ClothingRepository.php';

class ClothingController extends AppController
{

    const MAX_FILE_SIZE = 5 * 1024 * 1024; //5 MB
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    const UPLOAD_DIRECTORY = '/../public/uploads/';

    private $messages = [];
    private $clothingRepository;

    public function __construct()
    {
        parent::__construct();
        $this->clothingRepository = new ClothingRepository();
    }


    public function addClothing()
    {

        if($this->isPost() && is_uploaded_file($_FILES['file']['tmp_name']) && $this->isValidated($_FILES['file'])) {

            move_uploaded_file(
                $_FILES['file']['tmp_name'],
                dirname(__DIR__).self::UPLOAD_DIRECTORY.$_FILES['file']['name']
            );

            var_dump($_POST['category']);

            $clothing = new Clothing($_POST['name'], $_POST['category'], $_FILES['file']['name']);
            $this->clothingRepository->addClothing($clothing);

            $this->messages[] = 'Picture added';
            $this->render('add-clothing', ['messages' => $this->messages, 'clothing' => $clothing]);
        }

        $this->render('add-clothing', ['messages' => $this->messages] );
    }

    public function addClothingPage() {
        $allClothing = $this->clothingRepository->getAllClothingOfUser();
        $this->render('add-clothing', ['allClothing' => $allClothing]);
    }

    public function wardrobe() {
        $allClothing = $this->clothingRepository->getAllClothingOfUser();
        $this->render('wardrobe', ['allClothing' => $allClothing]);
    }

//    public function addClothing() {
//        $allClothing = $this->clothingRepository->getAllClothingOfUser();
//        $this->render('add-clothing', ['allClothing' => $allClothing]);
//    }

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