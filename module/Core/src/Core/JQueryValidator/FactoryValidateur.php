<?php

namespace Core\JQueryValidator;

/**
 * Fabrique pour les validateur jQuery.
 *
 * @author Antarus
 * @project Murloc avenue
 */
class FactoryValidateur {

    /**
     * Correspondance entre certaines classes Zend et leur equivalence Jquery.
     *
     * @var array
     */
    public static $correspondance = array(
        'Required' => 'Core\JQueryValidator\Validateur\Requis',
        'Zend\Validator\StringLength' => 'Core\JQueryValidator\Validateur\Longueur',
        'Zend\Validator\EmailAddress' => 'Core\Validateur\Validateur\Email',
        'Zend\Validator\Digits' => 'Core\JQueryValidator\Validateur\Numerique',
        'Zend\Validator\GreaterThan' => 'Core\JQueryValidator\Validateur\Min',
        'Zend\Validator\LessThan' => 'Core\JQueryValidator\Validateur\Max',
        'Zend\Validator\Between' => 'Core\JQueryValidator\Validateur\Range',
            // 'Zend\Validator\NotEmpty' => 'Core\JQueryValidator\Validateur\Requis'
    );

    /**
     *
     * Factory Validator
     *
     * @param string $sNom
     * @param mixed $mValidateurOuValeur
     * @return \Core\JQueryValidator\InterfaceValidateur
     * @throws \Exception
     */
    public static function fabrique($sNom, $mValidateurOuValeur = false) {
        if (array_key_exists($sNom, self::$correspondance)) {
            $sNomClasse = self::$correspondance[$sNom];
            return new $sNomClasse($mValidateurOuValeur);
        }/* else {
          throw new \Exception('Le validateur donné n\'existe pas....' . $sNom);
          } */
    }

}
