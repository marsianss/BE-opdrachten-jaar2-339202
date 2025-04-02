<?php

class Magazijn extends BaseController
{
    private $magazijnModel;

    public function __construct()
    {
        // Laad het model voor magazijn
        $this->magazijnModel = $this->model('MagazijnModel');
    }

    public function index()
    {
        // Initialiseer data array voor de view
        $data = [
            'title' => 'Overzicht Magazijn Jamin',
            'message' => NULL,
            'messageColor' => NULL,
            'messageVisibility' => 'none',
            'dataRows' => NULL
        ];

        try {
            // Haal alle magazijnproducten op
            $result = $this->magazijnModel->getAllMagazijnProducts();

            if (empty($result)) {
                throw new Exception("Geen resultaten gevonden");
            }

            // Zet de opgehaalde data in de data array
            $data['dataRows'] = $result;
        } catch (Exception $e) {
            // Log de fout en zet de foutmelding in de data array
            error_log($e->getMessage());
            $data['message'] = "Er is een fout opgetreden in de database: " . $e->getMessage();
            $data['messageColor'] = "danger";
            $data['messageVisibility'] = "flex";
        }

        // Laad de view met de data
        $this->view('magazijn/index', $data);
    }

    public function leveringInfo($productId)
    {
        $data = [
            'title' => 'Levering Informatie',
            'leveringen' => NULL,
            'leverancier' => NULL,
            'message' => NULL
        ];

        try {
            $result = $this->magazijnModel->getLeveringInfoByProductId($productId);

            if (empty($result)) {
                throw new Exception("Geen leveringsinformatie gevonden");
            }

            $data['leveringen'] = $result;
            $data['leverancier'] = [
                'Naam' => $result[0]->LeverancierNaam,
                'ContactPersoon' => $result[0]->ContactPersoon,
                'LeverancierNummer' => $result[0]->LeverancierNummer,
                'Mobiel' => $result[0]->Mobiel
            ];
        } catch (Exception $e) {
            error_log($e->getMessage());
            $data['message'] = "Er is een fout opgetreden in de database: " . $e->getMessage();
        }

        $this->view('magazijn/leveringinfo', $data);
    }

    public function allergenenInfo($productId)
    {
        $data = [
            'title' => 'Overzicht Allergenen',
            'allergenen' => NULL,
            'product' => NULL,
            'message' => NULL
        ];

        try {
            $productDetails = $this->magazijnModel->getProductDetails($productId);
            if (!$productDetails) {
                throw new Exception("Geen productinformatie gevonden");
            }

            $result = $this->magazijnModel->getAllergenenInfoByProductId($productId);

            if (empty($result)) {
                $data['message'] = "In dit product zitten geen stoffen die een allergische reactie kunnen veroorzaken";
            } else {
                $data['allergenen'] = $result;
            }

            $data['product'] = $productDetails;
        } catch (Exception $e) {
            error_log($e->getMessage());
            $data['message'] = "Er is een fout opgetreden in de database: " . $e->getMessage();
        }

        $this->view('magazijn/allergeneninfo', $data);
    }

    public function allergenenOverzicht()
    {
        $data = [
            'title' => 'Overzicht Allergenen',
            'allergenen' => NULL,
            'selectedAllergeen' => '',
            'products' => NULL,
            'message' => NULL
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $selectedAllergeen = trim($_POST['allergeen']);
            $data['selectedAllergeen'] = $selectedAllergeen;

            try {
                $products = $this->magazijnModel->getProductsByAllergeen($selectedAllergeen);
                if (empty($products)) {
                    $data['message'] = "Geen producten gevonden met het allergeen $selectedAllergeen.";
                } else {
                    $data['products'] = $products;
                }
            } catch (Exception $e) {
                error_log($e->getMessage());
                $data['message'] = "Er is een fout opgetreden in de database: " . $e->getMessage();
            }
        }

        try {
            $allergenen = $this->magazijnModel->getAllAllergenen();
            $data['allergenen'] = $allergenen;
        } catch (Exception $e) {
            error_log($e->getMessage());
            $data['message'] = "Er is een fout opgetreden in de database: " . $e->getMessage();
        }

        $this->view('magazijn/allergenenOverzicht', $data);
    }

    public function leverancierInfo($productId)
    {
        $data = [
            'title' => 'Overzicht Leverancier Gegevens',
            'leverancier' => NULL,
            'message' => NULL
        ];

        try {
            $leverancier = $this->magazijnModel->getSupplierInfoByProductId($productId);
            if (!$leverancier) {
                $data['message'] = "Er zijn geen adresgegevens bekend.";
            } else {
                $data['leverancier'] = $leverancier;
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            $data['message'] = "Er is een fout opgetreden in de database: " . $e->getMessage();
        }

        $this->view('magazijn/leverancierInfo', $data);
    }
}