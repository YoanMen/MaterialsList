<?php

namespace App\Service;

use App\Entity\Material;
use App\Event\ContactRequestEvent;
use App\Repository\MaterialRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class MaterialService
{
    public function __construct(private MaterialRepository $repository, private EntityManagerInterface $entityManager, private EventDispatcherInterface $dispatcher)
    {
    }

    public function saveMaterial(Material $material): void
    {
        try {
            $this->entityManager->persist($material);
            $this->entityManager->flush();

            // send mail when quantity is empty
            if (0 === $material->getQuantity()) {
                try {
                    $this->dispatcher->dispatch(new ContactRequestEvent($material->getName()));
                } catch (\Throwable $th) {
                    throw new \Exception('Cant send mail : '.$th);
                }
            }
        } catch (\Throwable $th) {
            throw new \Exception('Cant save material: '.$th);
        }
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
                $material->getPriceHT().'€',
                $material->getPriceTTC().'€',
                (string) $material->getTVA(),
                '<button class="button" decrement-action data-material="'.$material->getId().'" >décrémenter</button>',
                '<button class="button button--secondary" show-action data-material="'.$material->getId().'">voir</button>',
            ];
        }

        return ['data' => $data, 'maxResult' => $this->repository->getCountMaterial($search)];
    }

    public function decrementMaterial(int $id): void
    {
        $material = $this->repository->find($id);
        $quantity = $material->getQuantity();

        if ($quantity < 1) {
            return;
        }

        $material->setQuantity($quantity - 1);
        $this->saveMaterial($material);
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
                return 'name';
        }
    }
}
