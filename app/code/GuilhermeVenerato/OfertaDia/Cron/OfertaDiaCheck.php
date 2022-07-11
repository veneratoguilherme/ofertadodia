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

namespace GuilhermeVenerato\OfertaDia\Cron;

use GuilhermeVenerato\OfertaDia\Model\OfertaDia;
use Psr\Log\LoggerInterface;

class OfertaDiaCheck
{
    /**
     * @var OfertaDia
     */
    protected OfertaDia $ofertaDia;

    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * @param OfertaDia $ofertaDia
     * @param LoggerInterface $logger
     */
    public function __construct(
        OfertaDia $ofertaDia,
        LoggerInterface $logger
    ) {
        $this->ofertaDia = $ofertaDia;
        $this->logger = $logger;
    }

    public function execute()
    {
        try {
            $this->ofertaDia->checkOfertaDia();
            $this->logger->info('Cron - oferta do dia check: ' . date('Y-m-d H:i:s'));
        } catch (\Exception $ex) {
            $this->logger->critical($ex->getMessage());
        }
    }
}
