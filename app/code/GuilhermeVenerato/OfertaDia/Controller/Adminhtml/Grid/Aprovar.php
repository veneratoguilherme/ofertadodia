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

namespace GuilhermeVenerato\OfertaDia\Controller\Adminhtml\Grid;

use GuilhermeVenerato\OfertaDia\Model\OfertaDiaFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Result\PageFactory;

class Aprovar extends Action
{
    /**
     * @var PageFactory
     */
    protected PageFactory $resultPageFactory;

    /**
     * @var OfertaDiaFactory
     */
    protected OfertaDiaFactory $extensionFactory;

    /**
     * @var UrlInterface
     */
    protected $url;

    /**
     * @var ProductRepositoryInterface
     */
    protected ProductRepositoryInterface $product;

    public function __construct(
        UrlInterface $url,
        OfertaDiaFactory $extensionFactory,
        Context $context,
        PageFactory $resultPageFactory,
        ProductRepositoryInterface $product
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->extensionFactory = $extensionFactory;
        $this->url = $url;
        $this->product = $product;
    }

    public function execute()
    {
        //TODO
    }
}
