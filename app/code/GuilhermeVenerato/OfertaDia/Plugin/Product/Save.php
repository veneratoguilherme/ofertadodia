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

namespace GuilhermeVenerato\OfertaDia\Plugin\Product;

use GuilhermeVenerato\OfertaDia\Model\OfertaDiaFactory;
use Magento\Catalog\Controller\Adminhtml\Product\Save as ProductSave;
use Psr\Log\LoggerInterface;

class Save
{
    /**
     * @var OfertaDiaFactory
     */
    protected OfertaDiaFactory $modelOfertaDia;

    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * @param OfertaDiaFactory $modelOfertaDia
     * @param LoggerInterface $logger
     */
    public function __construct(
        OfertaDiaFactory $modelOfertaDia,
        LoggerInterface $logger
    ) {
        $this->modelOfertaDia = $modelOfertaDia;
        $this->logger = $logger;
    }

   public function afterExecute(ProductSave $subject, $result)
    {
        $data = $subject->getRequest()->getPostValue();
        try {
            if (isset($data['product']['oferta_dia']) && $data['product']['oferta_dia'] == 1) {
                $dataInicial = date('Y-m-d H:i:s');
                $dataFinal = date('Y-m-d H:i:s', strtotime($dataInicial . ' +1 day'));
                $model = $this->modelOfertaDia->create();
                $model->addData([
                    "sku" => $data['product']['sku'],
                    "dataInicial" => $dataInicial,
                    "dataFinal" => $dataFinal,
                    "status" => 1
                ]);
                $model->save();
                $this->logger->info('Oferta do dia: Sku ' . $data['product']['sku'] . ' - Início: ' . $dataInicial . ' - Término: ' . $dataFinal);
            } elseif (isset($data['product']['oferta_dia']) && $data['product']['oferta_dia'] == 0) {
                $model = $this->modelOfertaDia->create();
                $model->load($data['product']['sku'], 'sku');
                $model->setStatus(999);
                $model->save();
            }
        } catch (\Exception $ex) {
            $this->logger->critical($ex->getMessage());
        }

        return $result;
    }
}
