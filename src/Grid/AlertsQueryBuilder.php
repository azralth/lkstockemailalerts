<?php
declare(strict_types=1);

namespace LkInteractive\Back\LkStockEmailAlerts\Grid;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use PrestaShop\PrestaShop\Core\Grid\Query\AbstractDoctrineQueryBuilder;
use PrestaShop\PrestaShop\Core\Grid\Query\DoctrineSearchCriteriaApplicatorInterface;
use PrestaShop\PrestaShop\Core\Grid\Search\SearchCriteriaInterface;

class AlertsQueryBuilder extends AbstractDoctrineQueryBuilder
{
    /**
     * @var DoctrineSearchCriteriaApplicatorInterface
     */
    private $searchCriteriaApplicator;
    /**
     * @var int
     */
    private $languageId;

    /**
     * @param Connection $connection
     * @param string $dbPrefix
     * @param DoctrineSearchCriteriaApplicatorInterface $searchCriteriaApplicator
     * @param int $languageId
     */
    public function __construct(
        Connection                                $connection,
                                                  $dbPrefix,
        DoctrineSearchCriteriaApplicatorInterface $searchCriteriaApplicator,
                                                  $languageId
    )
    {
        parent::__construct($connection, $dbPrefix);
        $this->searchCriteriaApplicator = $searchCriteriaApplicator;
        $this->languageId = $languageId;
    }

    /**
     * {@inheritdoc}
     */
    public function getSearchQueryBuilder(SearchCriteriaInterface $searchCriteria)
    {
        $qb = $this->getQueryBuilder($searchCriteria->getFilters());
        $qb
            ->select('m.id_product, pl.name, COUNT(m.id_product) as nb_alerts')
            ->groupBy('m.id_product');
        $this->searchCriteriaApplicator
            ->applySorting($searchCriteria, $qb)
            ->applyPagination($searchCriteria, $qb);
        return $qb;
    }

    /**
     * {@inheritdoc}
     */
    public function getCountQueryBuilder(SearchCriteriaInterface $searchCriteria)
    {
        $qb = $this->getQueryBuilder($searchCriteria->getFilters())
            ->select('COUNT(DISTINCT m.id_product)');
        return $qb;
    }

    /**
     * Get generic query builder.
     *
     * @param array $filters
     * @return QueryBuilder
     */
    private function getQueryBuilder(array $filters)
    {
        $allowedFilters = [
            'id_product',
            'name',
            'nb_alerts'
        ];
        $qb = $this->connection
            ->createQueryBuilder()
            ->from($this->dbPrefix . 'mailalert_customer_oos', 'm')
            ->innerJoin(
                'm',
                $this->dbPrefix . 'product_lang',
                'pl',
                'm.id_product = pl.id_product'
            )
            ->andWhere('pl.`id_lang`= 1');
        foreach ($filters as $name => $value) {
            if (!in_array($name, $allowedFilters, true)) {
                continue;
            }
            if ('id_product' === $name) {
                $qb->andWhere('m.`id_product` = :' . $name);
                $qb->setParameter($name, $value);
                continue;
            }
            $qb->andWhere('pl.`name` LIKE :' . $name);
            $qb->setParameter($name, '%' . $value . '%');
        }
        return $qb;
    }
}
