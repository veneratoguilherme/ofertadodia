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
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Result\PageFactory;

class Delete extends Action
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
     * @param UrlInterface $url
     * @param OfertaDiaFactory $extensionFactory
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        UrlInterface $url,
        OfertaDiaFactory $extensionFactory,
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->extensionFactory = $extensionFactory;
        $this->url = $url;
    }

    public function execute()
    {
        if ($id = $this->getRequest()->getParam("id")) {
            $model = $this->extensionFactory->create();
            $model->load($id);
            if ($model->getId()) {
                $model->setStatus(999);
                $model->save();
                if($model->save()){
                    $this->messageManager->addSuccessMessage(__("Exclusão realizada com sucesso!"));
                    $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
                    $resultRedirect->setUrl($this->url->getUrl('ofertadia/grid'));
                    return $resultRedirect;
                }
            } else {
                return false;
            }
        } else {
            return true;
        }
    }
}
