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

namespace GuilhermeVenerato\OfertaDia\Model;

use GuilhermeVenerato\OfertaDia\Model\OfertaDiaFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Psr\Log\LoggerInterface;

class OfertaDia extends AbstractModel
{
    /**
     * CMS page cache tag
     */
    const CACHE_TAG = 'guilhermevenerato_ofertadia';

    /**
     * @var string
     */
    protected $cacheTag = 'guilhermevenerato_ofertadia';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $eventPrefix = 'guilhermevenerato_ofertadia';

    /**
     * @var OfertaDiaFactory
     */
    protected OfertaDiaFactory $modelOfertaDia;

    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * @var ProductRepositoryInterface
     */
    protected ProductRepositoryInterface $product;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     * @param OfertaDiaFactory $modelOfertaDia
     * @param LoggerInterface $logger
     * @param ProductRepositoryInterface $product
     */
    function __construct(
        Context $context,
        Registry $registry,
        OfertaDiaFactory $modelOfertaDia,
        LoggerInterface $logger,
        ProductRepositoryInterface $product,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        $this->modelOfertaDia = $modelOfertaDia;
        $this->logger = $logger;
        $this->product = $product;
    }

    /**
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('GuilhermeVenerato\OfertaDia\Model\ResourceModel\OfertaDia');
    }

    public function checkOfertaDia() {
        $now = new \DateTime();
        try {
            $ofertas = $this->modelOfertaDia->create()->getCollection()
                ->addFieldToFilter('status', 1)
                ->addFieldToFilter('dataFinal', ['lteq' => $now->format('Y-m-d H:i:s')]);
            foreach ($ofertas as $oferta) {
                $model = $this->modelOfertaDia->create();
                $model->load($oferta['sku'], 'sku');
                $model->setStatus(999);
                $model->save();

                $produto = $this->product->get($oferta['sku']);
                $produto->setOfertaDia(0);
                $produto->save($produto);
            }
        } catch (\Exception $ex) {
            $this->logger->critical($ex->getMessage());
        }
    }
}
