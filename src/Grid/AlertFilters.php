<?php
declare(strict_types=1);

namespace LkInteractive\Back\LkStockEmailAlerts\Grid;
use LkInteractive\Back\LkStockEmailAlerts\Grid\AlertGridDefinitionFactory;
use PrestaShop\PrestaShop\Core\Search\Filters;

class AlertFilters extends Filters
{
    protected $filterId = AlertGridDefinitionFactory::GRID_ID;

    public static function getDefaults()
    {
        return [
            'limit' => 10,
            'offset' => 0,
            'orderBy' => 'id_customer',
            'sortOrder' => 'asc',
            'filters' => []
        ];
    }
}
