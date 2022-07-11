<?php

/**
 * Oferta do dia
 *
 * Extensão para cadastro de ofertas do dia
 *
 * @package GuilhermeVenerato\OfertaDia
 * @author Guilherme Venerato <guilhermevenerato@hotmail.com>
 * Copyright © 2022 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace GuilhermeVenerato\OfertaDia\Model\ResourceModel\OfertaDia;

use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Data\Collection\EntityFactory;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Psr\Log\LoggerInterface;

class Collection extends AbstractCollection
{
    /**
     * @param EntityFactory $entityFactory
     * @param LoggerInterface $logger
     * @param FetchStrategyInterface $fetchStrategy
     * @param ManagerInterface $eventManager
     * @param mixed $connection
     * @param AbstractDb $resource
     */
    public function __construct(
        EntityFactory $entityFactory,
        LoggerInterface $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface $eventManager,
        AdapterInterface $connection = null,
        AbstractDb $resource = null
    ) {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
    }

    /**
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('GuilhermeVenerato\OfertaDia\Model\OfertaDia','GuilhermeVenerato\OfertaDia\Model\ResourceModel\OfertaDia');
        $this->_idFieldName = 'id';
    }
}
