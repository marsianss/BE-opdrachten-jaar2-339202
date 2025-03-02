<?php

use PHPUnit\Framework\TestCase;

class LeverancierTest extends TestCase
{
    private $leverancierModel;

    protected function setUp(): void
    {
        $this->leverancierModel = new LeverancierModel();
    }

    public function testGetAllLeveranciers()
    {
        $result = $this->leverancierModel->getAllLeveranciers();
        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
    }

    public function testUpdateLeverancier()
    {
        $data = [
            'id' => 1,
            'naam' => 'Updated Naam',
            'contactpersoon' => 'Updated Contactpersoon',
            'leveranciernummer' => 'L1029384719',
            'mobiel' => '06-28493827',
            'aantalProducten' => 10
        ];

        $result = $this->leverancierModel->updateLeverancier($data);
        $this->assertTrue($result);
    }
}
