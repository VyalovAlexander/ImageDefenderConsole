<?php

use VyalovAlexander\ImageDefender\SignImageDefenderInterface;
use VyalovAlexander\ImageDefender\StampImageDefenderInterface;
use VyalovAlexander\ImageDefender\GD\GDConfig;
use Psr\Container\ContainerInterface;
use VyalovAlexander\ImageDefender\GD\GDSignImageDefender;
use VyalovAlexander\ImageDefender\GD\GDStampImageDefender;
use VyalovAlexander\ImageDefender\GD\GDImageStorage;
use VyalovAlexander\ImageDefender\ImageStorageInterface;

return [
    'sign' => GDConfig::sign(),
    'stamp' => GDConfig::stamp(),

    // Bind an interface to an implementation
    ImageStorageInterface::class => function() {
        return new GDImageStorage();
    },
    SignImageDefenderInterface::class => function(ContainerInterface $c, ImageStorageInterface $storage) {
        $sign =  new GDSignImageDefender($storage);
        return $sign->setFont($c->get('sign')['font'])
            ->setSign($c->get('sign')['text'])
            ->setSignAngle($c->get('sign')['angle'])
            ->setSignColor($c->get('sign')['color']['red'], $c->get('sign')['color']['green'], $c->get('sign')['color']['blue'])
            ->setSignFontSize($c->get('sign')['fontSize'])
            ->setSignMarginBottom($c->get('sign')['marginRight'])
            ->setSignMarginRight($c->get('sign')['marginRight'])
            ->setSignTransparency($c->get('sign')['transparency']);
    },
    StampImageDefenderInterface::class => function(ContainerInterface $c, ImageStorageInterface $storage) {
        $stamp = new GDStampImageDefender($storage);
        return $stamp->setStamp($c->get('stamp')['image'])
            ->setStampHeight($c->get('stamp')['height'])
            ->setStampWidth($c->get('stamp')['width'])
            ->setStampMarginRight($c->get('stamp')['marginRight'])
            ->setStampMarginBottom($c->get('stamp')['marginBottom'])
            ->setStampTransparency($c->get('stamp')['transparency']);
    }
    
    
];