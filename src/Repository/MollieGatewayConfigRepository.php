<?php


declare(strict_types=1);

namespace SyliusMolliePlugin\Repository;

use SyliusMolliePlugin\Entity\GatewayConfigInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class MollieGatewayConfigRepository extends EntityRepository implements MollieGatewayConfigRepositoryInterface
{
    public function findAllEnabledByGateway(GatewayConfigInterface $gateway): array
    {
        return $this->createQueryBuilder('m')
            ->innerJoin('m.amountLimits', 'al')
            ->addSelect('al.minimumAmount')
            ->addSelect('al.maximumAmount')
            ->where('m.enabled = true')
            ->andWhere('m.gateway = :gateway')
            ->setParameter('gateway', $gateway)
            ->orderBy('m.position', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function getExistingAmountLimitsById(int $id): array
    {
        return $this->createQueryBuilder('m')
            ->select('m.minimumAmount')
            ->addSelect('m.maximumAmount')
            ->where('m.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }
}
