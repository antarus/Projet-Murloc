<?php

namespace Core\Hydrator;

use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Stdlib\Hydrator\Filter\FilterProviderInterface;
use Zend\Stdlib\Hydrator\Filter\FilterComposite;
use Zend\Stdlib\Hydrator\Filter\MethodMatchFilter;

/**
 * Hydrator basé sur les méthodes de classe.
 * Hérite ClassMethods mais ne concerne que les méthodes public.
 *
 * @author Antarus
 * @project Murloc avenue
 *
 */
class ClassMethodsPublic extends ClassMethods {

    /**
     * Extrait les valeurs de l'objet donnée  avec les methodes getter/setter  de la classe.
     *
     * @param object $oObjet
     * @return array
     * @throws Exception\BadMethodCallException for a non-object $object
     */
    public function extract($oObjet) {
        if (!is_object($oObjet)) {
            throw new \BadMethodCallException(sprintf('%s attend un objet PHP.)', __METHOD__));
        }

        $filtre = null;
        if ($oObjet instanceof FilterProviderInterface) {
            $filtre = new FilterComposite(array(
                $oObjet->getFilter()
                    ), array(
                new MethodMatchFilter("getFilter")
            ));
        } else {
            $filtre = $this->filterComposite;
        }

        $aAttributs = array();
        $methodes = get_class_methods($oObjet);

        $paramPublique = call_user_func('get_object_vars', $oObjet);

        foreach ($methodes as $methode) {

            if (!$filtre->filter(get_class($oObjet) . '::' . $methode)) {
                continue;
            }
            $attribute = $methode;
            if (preg_match('/^get/', $methode)) {
                $attribute = substr($methode, 3);
                if (!property_exists($oObjet, $attribute)) {
                    $attribute = lcfirst($attribute);
                }
            }
            if (!array_key_exists($attribute, $paramPublique)) {
                continue;
            }
            $attribute = $this->extractName($attribute, $oObjet);
            $aAttributs[$attribute] = $this->extractValue($attribute, $oObjet->$methode(), $oObjet);
        }

        return $aAttributs;
    }

}
