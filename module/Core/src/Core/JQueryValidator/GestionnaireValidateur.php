<?php

namespace Core\JQueryValidator;

use Zend\InputFilter\InputFilterAwareInterface;

/**
 * Gestionnaire des validateurs.
 *
 * @author Antarus
 * @project Murloc avenue
 *
 */
class GestionnaireValidateur implements InputFilterAwareInterface {

    /**
     * retien le inputFilter lié au formulaire a valider.
     * @var InputFilter
     */
    protected $inputFilter;

    /**
     * Code de base pour le rendu jquery permettant de valider notre formulaire.
     *
     * @var string
     */
    protected $template = "
            (function(jQuery) {
                $('#%s').validate({
                        rules: {
                            %s
                        },
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function(error, element) {
            if(element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }

                    }
                );
            })(jQuery);";

    /**
     * Classe a ignorer pour la génération des règles JQuery.
     *
     * @var array
     */
    protected $classeAIgnorer = array(
        'Zend\Validator\InArray',
        'Zend\Validator\NotEmpty'
    );

    /**
     * Retourne le script jquery avec la définition des règles issu de l'inputfilter du formulaire.
     *
     * @param
     *            formName
     * @return string
     */
    public function getScript($sNomForm) {
        $regles = '';
        $reglesValidateur = '';

        foreach ($this->getInputFilter()->getInputs() as $oInputFilter) {

            $sNom = $oInputFilter->getName();

            if ($oInputFilter->isRequired()) {
                $reglesValidateur = FactoryValidateur::fabrique('Required', 'true')->getRegle();
            }

            $oValidateurs = $oInputFilter->getValidatorChain()->getValidators();
            if (!empty($oValidateurs)) {
                foreach ($oValidateurs as $oValidateur) {
                    $sClasse = get_class($oValidateur['instance']);
                    if (in_array($sClasse, $this->classeAIgnorer)) {
                        continue;
                    }
                    $reglesValidateur .= FactoryValidateur::fabrique($sClasse, $oValidateur['instance'])->getRegle();
                }
            }
            $regles .= " $sNom: {
                        $reglesValidateur
                    },";

            $reglesValidateur = '';
        }

        return sprintf($this->template, $sNomForm, $regles);
    }

    /**
     * Defnit le InputFilter.
     *
     * @param \Zend\InputFilter\InputFilterInterface $oInputFilter
     */
    public function setInputFilter(\Zend\InputFilter\InputFilterInterface $oInputFilter) {
        $this->inputFilter = $oInputFilter;
    }

    /**
     * Retourne le InputFilter.
     *
     * @return InputFilter
     */
    public function getInputFilter() {
        return $this->inputFilter;
    }

}
