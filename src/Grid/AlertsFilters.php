<?php
declare(strict_types=1);

namespace LkInteractive\Back\LkStockEmailAlerts\Grid;
use LkInteractive\Back\LkStockEmailAlerts\Grid\AlertsGridDefinitionFactory;
use PrestaShop\PrestaShop\Core\Search\Filters;

class AlertsFilters extends Filters
{
    protected $filterId = AlertsGridDefinitionFactory::GRID_ID;

    public static function getDefaults()
    {
        return [
            'limit' => 10,
            'offset' => 0,
            'orderBy' => 'id_product',
            'sortOrder' => 'asc',
            'filters' => [],
        ];
    }
}
