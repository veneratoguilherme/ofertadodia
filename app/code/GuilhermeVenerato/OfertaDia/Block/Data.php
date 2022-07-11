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

namespace GuilhermeVenerato\OfertaDia\Block;

use GuilhermeVenerato\OfertaDia\Model\OfertaDiaFactory;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Pricing\Helper\Data as PriceHelper;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\StoreManagerInterface;

class Data extends Template
{
    /**
     * @var Context
     */
    protected Context $context;

    /**
     * @var OfertaDiaFactory
     */
    protected OfertaDiaFactory $modelOfertaDia;

    /**
     * @var ProductRepository
     */
    protected ProductRepository $productRepository;

    /**
     * @var StoreManagerInterface
     */
    protected StoreManagerInterface $storeManagerInterface;

    /**
     * @var PriceHelper
     */
    protected PriceHelper $priceHelper;

    /**
     * @param Context $context
     * @param OfertaDiaFactory $modelOfertaDia
     * @param ProductRepository $productRepository
     * @param StoreManagerInterface $storeManagerInterface
     * @param PriceHelper $priceHelper
     */
    public function __construct(
        Context $context,
        OfertaDiaFactory $modelOfertaDia,
        ProductRepository $productRepository,
        StoreManagerInterface $storeManagerInterface,
        PriceHelper $priceHelper
    ) {
        parent::__construct($context);
        $this->modelOfertaDia = $modelOfertaDia;
        $this->productRepository = $productRepository;
        $this->storeManagerInterface = $storeManagerInterface;
        $this->priceHelper = $priceHelper;
    }

    public function getOfertaDia () {
        $now = new \DateTime();
        $store = $this->storeManagerInterface->getStore();
        $produtoArray = Array();

        $ofertas = $this->modelOfertaDia->create()->getCollection()
            ->addFieldToFilter('status', 1)
            ->addFieldToFilter('dataInicial', ['lteq' => $now->format('Y-m-d H:i:s')])
            ->addFieldToFilter('dataFinal', ['gteq' => $now->format('Y-m-d H:i:s')]);
        $ofertas->getSelect()->order('id DESC')->limit(1);
        foreach ($ofertas as $oferta) {
            $produto = $this->productRepository->get($oferta['sku']);
            $produtoArray['id'] = $produto->getId();
            $produtoArray['imagem'] = $store->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'catalog/product' . $produto->getImage();
            $produtoArray['nome'] = $produto->getName();
            $produtoArray['sku'] = $produto->getSku();
            $produtoArray['preco'] = $this->priceHelper->currency($produto->getFinalPrice(), true, false);
            $produtoArray['url'] = $produto->getProductUrl();
        }
        return $produtoArray;
    }
}
