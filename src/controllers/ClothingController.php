<?php

session_start();

require_once 'AppController.php';
require_once __DIR__.'/../models/Clothing.php';
require_once __DIR__.'/../models/Outfit.php';
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

    public function wardrobe() {
        $allClothing = $this->clothingRepository->getAllClothingOfUser();
        $this->render('wardrobe', ['allClothing' => $allClothing]);
    }

    public function outfits() {
        $allOutfits = $this->clothingRepository->getAllOutfitsOfUser();
        $this->render('outfits', ['allOutfits' => $allOutfits]);
    }

    public function favourites() {
        $favouriteOutfits = $this->clothingRepository->getFavouriteOutfitsOfUser();
        $this->render('favourites', ['favouriteOutfits' => $favouriteOutfits]);
    }

    public function addClothing()
    {

        if($this->isPost() && is_uploaded_file($_FILES['file']['tmp_name']) && $this->isValidated($_FILES['file'])) {

//            var_dump($_POST['category']);
            $clothing = new Clothing($_POST['name'], new Category($_POST['category']), $_FILES['file']['name']);
            $updatedFilename = $this->clothingRepository->addClothing($clothing);

            move_uploaded_file(
                $_FILES['file']['tmp_name'],
                dirname(__DIR__).self::UPLOAD_DIRECTORY.$updatedFilename
            );

            $this->messages[] = 'Picture added';
            $this->render('add-clothing', ['messages' => $this->messages, 'clothing' => $clothing]);
        }

        $this->render('add-clothing', ['messages' => $this->messages] );
    }

    public function deleteClothing()
    {
        $allClothing = $this->clothingRepository->getAllClothingOfUser();
        $this->render('delete-clothing', ['allClothing' => $allClothing]);
    }

    public function delete() {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? $_SERVER["CONTENT_TYPE"] : "";

        if($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            $this->clothingRepository->deleteClothing($decoded);

        }
    }

    public function randomizeOutfit() {
        $randomizedOutfit = $this->clothingRepository->getRandomizedOutfit();
        if($randomizedOutfit != null) {
            $this->render('randomizer', ['randomizedOutfit' => $randomizedOutfit]);
        } else {
            $this->messages[] = 'Cannot pick randomized outfit. 
            Make sure you have at least 1 piece of clothing in each category';
            $this->render('randomizer', ['messages' => $this->messages]);
        }

    }

    public function addToFavourites(): void
    {
        $outfit = unserialize($_SESSION['outfit']);
        $this->clothingRepository->addOutfitToFavourites($outfit);
    }

    public function saveToAllOutfits(): void
    {
        $outfit = unserialize($_SESSION['outfit']);
        $this->clothingRepository->saveToAllOutfits($outfit);
    }

    private function isValidated(array $file) : bool
    {
        if($file['size'] > self::MAX_FILE_SIZE) {
            $this->messages[] = 'File is too large.';
            return false;
        }

        if(!isset($file['type']) || !in_array($file['type'], self::SUPPORTED_TYPES)) {
            $this->messages[] = 'Filetype not supported.';
            return false;
        }

        return true;
    }


}