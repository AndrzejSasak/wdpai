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

    public function addClothing()
    {

        if($this->isPost() && is_uploaded_file($_FILES['file']['tmp_name']) && $this->isValidated($_FILES['file'])) {

            move_uploaded_file(
                $_FILES['file']['tmp_name'],
                dirname(__DIR__).self::UPLOAD_DIRECTORY.$_FILES['file']['name']
            );

            $clothing = new Clothing($_POST['name'], new Category($_POST['category']), $_FILES['file']['name']);
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

    public function favourites() {
        $favouriteOutfits = $this->clothingRepository->getFavouriteOutfitsOfUser();
        $this->render('favourites', ['favouriteOutfits' => $favouriteOutfits]);
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