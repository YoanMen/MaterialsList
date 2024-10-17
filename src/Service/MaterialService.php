<?php

namespace App\Service;

use App\Repository\MaterialRepository;

class MaterialService
{
    public function __construct(private MaterialRepository $repository)
    {
    }

    /**
     * @param array<mixed> $order
     *
     * @return array<mixed>
     */
    public function getMaterials(int $start, int $length, string $search, array $order): array
    {
        $orderBy = $order['0']['dir'] ?? 'asc';
        $materials = $this->repository->findMaterials($start, $length, $search, $this->getOrderColumn($order), $orderBy);
        $data = [];

        foreach ($materials as $material) {
            $data[] = [
                $material->getName(),
                $material->getQuantity(),
                $material->getCreatedAt(),
                $material->getPriceHT().' €',
                $material->getPriceTTC().' €',
                (string) $material->getTVA(),
                '<button>décrement</button>',
                '<button>voir</button>',
            ];
        }

        return ['data' => $data, 'maxResult' => $this->repository->count(), 'test' => $orderBy];
    }

    public static function calculateTTC(string $priceHT, string $tva): float
    {
        return round(floatval($priceHT) * (1 + floatval($tva)), 2);
    }

    /**
     * findMaterials.
     *
     * @param array<mixed> $order
     */
    private function getOrderColumn(array $order): string
    {
        $order = $order['0']['column'] ?? '';

        switch ($order) {
            case '0':
                return 'name';
            case '1':
                return 'quantity';
            case '2':
                return 'createdAt';
            case '3':
                return 'priceHT';
            case '4':
                return 'priceTTC';
            case '5':
                return 'tva';
            default:
                return 'id';
        }
    }
}
