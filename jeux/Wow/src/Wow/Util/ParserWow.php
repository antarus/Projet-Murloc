<?php

namespace Jeux\Wow\Util;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ParserWow {

    /**
     * Extrait les membre des donnes de battlnet et les adapte au format murloc.
     * @param type $aDataGuildeBnet
     * @param \Core\Model\Guildes $oGuilde
     * @param array $aOptionFiltre lvlMin|
     * @return array de \Core\Model\Personnages
     * @throws Exception
     */
    public static function extraitMembreDepuisBnetGuilde($aDataGuildeBnet, \Core\Model\Guildes $oGuilde, array $aOptionFiltre) {

        if (!isset($aDataGuildeBnet)) {
            throw new Exception('Les datas issues de bnet ne peuvent être vide.');
        }
        $aPersonnage = array();
        $writer = new \Zend\Config\Writer\Json();
        $oData = new \Zend\Config\Config(array(), true);
        $lvlMin = 0;
        if (isset($aOptionFiltre)) {
            if (isset($aOptionFiltre['lvlMin'])) {
                $lvlMin = $aOptionFiltre['lvlMin'];
            }
        }

        if (isset($aDataGuildeBnet['members'])) {
            foreach ($aDataGuildeBnet['members'] as $aCharacter) {
                if ($aCharacter['character']['level'] >= $lvlMin) {
                    $oMurlocPerson = new \Core\Model\Personnages();
                    $oMurlocPerson->setNom($aCharacter['character']['name']);
                    $oMurlocPerson->setNiveau($aCharacter['character']['level']);
                    $oMurlocPerson->setIdGuildes($oGuilde->getIdGuildes());
                    $oMurlocPerson->setIdJeux($oGuilde->getIdJeux());

                    $oData->wow = array();
                    $oData->wow->classe = $aCharacter['character']['class'];
                    $oData->wow->race = $aCharacter['character']['race'];
                    $oData->wow->genre = $aCharacter['character']['gender'];
                    $oData->wow->ptHf = $aCharacter['character']['achievementPoints'];
                    $oData->wow->miniature = $aCharacter['character']['thumbnail'];
                    $oData->wow->rang = $aCharacter['rank'];
                    $oMurlocPerson->setData($writer->toString($oData));
                    $aPersonnage[] = $oMurlocPerson;
                }
            }
            return $aPersonnage;
        }
    }

    /**
     * Extrait les information de la guilde des donnes de battlnet et les adapte au format murloc.
     * @param type $aDataGuildeBnet
     * @return  \Core\Model\Guilde
     * @throws Exception
     */
    public static function extraitGuildeDepuisBnetGuilde($aDataGuildeBnet, $iIdJeu) {

        if (!isset($aDataGuildeBnet)) {
            throw new Exception('Les datas issues de bnet ne peuvent être vide.');
        }
        $writer = new \Zend\Config\Writer\Json();
        $oData = new \Zend\Config\Config(array(), true);

        $oMurlocGuilde = new \Core\Model\Guildes();
        $oMurlocGuilde->setNom($aDataGuildeBnet['name']);
        $oMurlocGuilde->setIdJeux($iIdJeu);

        $oData->wow = array();
        $oData->wow->royaume = $aDataGuildeBnet['realm'];
        $oData->wow->battlegroup = $aDataGuildeBnet['battlegroup'];
        $oData->wow->niveau = $aDataGuildeBnet['level'];
        $oData->wow->faction = $aDataGuildeBnet['side'];
        $oData->wow->miniature = $aDataGuildeBnet['character']['thumbnail'];
        $oData->wow->hf = $aDataGuildeBnet['achievementPoints'];
        $oMurlocGuilde->setData($writer->toString($oData));


        return $oMurlocGuilde;
    }

}
