<?php

namespace Core\Form\Element;

//use Doctrine\Common\Collections\Collection;
//use Doctrine\Common\Persistence\ObjectManager;
//use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;
use InvalidArgumentException;
use ReflectionMethod;
use RuntimeException;
use Traversable;
use Zend\Stdlib\Guard\GuardUtils;

class Proxy {

    /**
     * @var array|Traversable
     */
    protected $objects;

    /**
     * @var string
     */
    protected $targetClass;

    /**
     * @var array
     */
    protected $valueOptions = array();

    /**
     * @var array
     */
    protected $findMethod = array();

    /**
     * @var
     */
    protected $property;

    /**
     * @var array
     */
    protected $option_attributes = array();

    /**
     * @var callable $labelGenerator A callable used to create a label based on an item in the collection an Entity
     */
    protected $labelGenerator;

    /**
     * @var bool|null
     */
    protected $isMethod;

    /**
     * @var ObjectManager
     */
    protected $serviceManager;

    /**
     * @var \Core\Table\AbstractTable
     */
    protected $tableCible;

    /**
     * @var bool
     */
    protected $displayEmptyItem = false;

    /**
     * @var string
     */
    protected $emptyItemLabel = '';

    /**
     * @var string|null
     */
    protected $optgroupIdentifier;

    /**
     * @var string|null
     */
    protected $optgroupDefault;

    public function setOptions($options) {
        if (!isset($options['service_manager'])) {
            throw new RuntimeException('Aucun service Manager de définit');
        }

        if (!isset($options['target_class'])) {
            throw new RuntimeException('Aucune cible trouvé');
        }

        if (isset($options['service_manager'])) {
            $this->setServiceManager($options['service_manager']);
        }

        if (isset($options['target_class'])) {
            $this->setTargetClass($options['target_class']);
        }

        if (isset($options['property'])) {
            $this->setProperty($options['property']);
        }

        if (isset($options['label_generator'])) {
            $this->setLabelGenerator($options['label_generator']);
        }

        if (isset($options['find_method'])) {
            $this->setFindMethod($options['find_method']);
        }

        if (isset($options['is_method'])) {
            $this->setIsMethod($options['is_method']);
        }

        if (isset($options['display_empty_item'])) {
            $this->setDisplayEmptyItem($options['display_empty_item']);
        }

        if (isset($options['empty_item_label'])) {
            $this->setEmptyItemLabel($options['empty_item_label']);
        }

        if (isset($options['option_attributes'])) {
            $this->setOptionAttributes($options['option_attributes']);
        }

        if (isset($options['optgroup_identifier'])) {
            $this->setOptgroupIdentifier($options['optgroup_identifier']);
        }

        if (isset($options['optgroup_default'])) {
            $this->setOptgroupDefault($options['optgroup_default']);
        }
    }

    public function getValueOptions() {
        if (empty($this->valueOptions)) {
            $this->loadValueOptions();
        }

        return $this->valueOptions;
    }

    /**
     * @return array|Traversable
     */
    public function getObjects() {
        $this->loadObjects();

        return $this->objects;
    }

    /**
     * Set the label for the empty option
     *
     * @param string $emptyItemLabel
     *
     * @return Proxy
     */
    public function setEmptyItemLabel($emptyItemLabel) {
        $this->emptyItemLabel = $emptyItemLabel;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmptyItemLabel() {
        return $this->emptyItemLabel;
    }

    /**
     * @return array
     */
    public function getOptionAttributes() {
        return $this->option_attributes;
    }

    /**
     * @param array $option_attributes
     */
    public function setOptionAttributes(array $option_attributes) {
        $this->option_attributes = $option_attributes;
    }

    /**
     * Set a flag, whether to include the empty option at the beginning or not
     *
     * @param boolean $displayEmptyItem
     *
     * @return Proxy
     */
    public function setDisplayEmptyItem($displayEmptyItem) {
        $this->displayEmptyItem = $displayEmptyItem;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getDisplayEmptyItem() {
        return $this->displayEmptyItem;
    }

    /**
     * Set the object manager
     *
     * @param  ServiceManager $oServiceManager
     *
     * @return Proxy
     */
    public function setServiceManager(ServiceManager $oServiceManager) {
        $this->serviceManager = $oServiceManager;

        return $this;
    }

    /**
     * Get the object manager
     *
     * @return ServiceManager
     */
    public function getServiceManager() {
        return $this->serviceManager;
    }

    /**
     * Set the FQCN of the target object
     *
     * @param  string $targetClass
     *
     * @return Proxy
     */
    public function setTargetClass($targetClass) {
        $this->targetClass = $targetClass;
        $this->setTableCible($this->getServiceManager()->get($targetClass));
        return $this;
    }

    /**
     * Retourne la table cible.
     *
     * @return \Core\Table\AbstractTable $tableCible
     */
    public function getTableCible() {
        return $this->tableCible;
    }

    /**
     * Définit la table cible
     * @param \Core\Table\AbstractTable $tableCible
     * @return \Core\Form\Element\Proxy
     */
    protected function setTableCible(\Core\Table\AbstractTable $tableCible) {
        $this->tableCible = $tableCible;
        return $this;
    }

    /**
     * Get the target class
     *
     * @return string
     */
    public function getTargetClass() {
        return $this->targetClass;
    }

    /**
     * Set the property to use as the label in the options
     *
     * @param  string $property
     *
     * @return Proxy
     */
    public function setProperty($property) {
        $this->property = $property;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getProperty() {
        return $this->property;
    }

    /**
     * Set the label generator callable that is responsible for generating labels for the items in the collection
     *
     * @param callable $callable A callable used to create a label based off of an Entity
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public function setLabelGenerator($callable) {
        if (!is_callable($callable)) {
            throw new InvalidArgumentException(
            'Property "label_generator" needs to be a callable function or a \Closure'
            );
        }

        $this->labelGenerator = $callable;
    }

    /**
     * @return callable|null
     */
    public function getLabelGenerator() {
        return $this->labelGenerator;
    }

    /**
     * @return string|null
     */
    public function getOptgroupIdentifier() {
        return $this->optgroupIdentifier;
    }

    /**
     * @param string $optgroupIdentifier
     */
    public function setOptgroupIdentifier($optgroupIdentifier) {
        $this->optgroupIdentifier = (string) $optgroupIdentifier;
    }

    /**
     * @return string|null
     */
    public function getOptgroupDefault() {
        return $this->optgroupDefault;
    }

    /**
     * @param string $optgroupDefault
     */
    public function setOptgroupDefault($optgroupDefault) {
        $this->optgroupDefault = (string) $optgroupDefault;
    }

    /**
     * Set if the property is a method to use as the label in the options
     *
     * @param  boolean $method
     *
     * @return Proxy
     */
    public function setIsMethod($method) {
        $this->isMethod = (bool) $method;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsMethod() {
        return $this->isMethod;
    }

    /** Set the findMethod property to specify the method to use on repository
     *
     * @param array $findMethod
     *
     * @return Proxy
     */
    public function setFindMethod($findMethod) {
        $this->findMethod = $findMethod;

        return $this;
    }

    /**
     * Get findMethod definition
     *
     * @return array
     */
    public function getFindMethod() {
        return $this->findMethod;
    }

    /**
     * @param $targetEntity
     *
     * @return string|null
     */
    protected function generateLabel($targetEntity) {
        if (null === ($labelGenerator = $this->getLabelGenerator())) {
            return null;
        }

        return call_user_func($labelGenerator, $targetEntity);
    }

    /**
     * @param  $value
     *
     * @return array|mixed|object
     * @throws RuntimeException
     */
    public function getValue($value) {
        $om = $this->getServiceManager();
        $targetClass = $this->getTargetClass();
        $oTable = $this->getServiceManager()->get($targetClass);
        //$metadata = $om->getClassMetadata($targetClass);

        if (is_object($value)) {
            if ($value instanceof Collection) {
                $data = array();

                foreach ($value as $object) {
                    $values = $metadata->getIdentifierValues($object);
                    $data[] = array_shift($values);
                }

                $value = $data;
            } else {
                $metadata = $om->getClassMetadata(get_class($value));
                $identifier = $metadata->getIdentifierFieldNames();

                // TODO: handle composite (multiple) identifiers
                if (count($identifier) > 1) {
                    //$value = $key;
                } else {
                    $value = current($metadata->getIdentifierValues($value));
                }
            }
        }

        return $value;
    }

    /**
     * Load objects
     *
     * @throws RuntimeException
     * @throws Exception\InvalidRepositoryResultException
     * @return void
     */
    protected function loadObjects() {
        if (!empty($this->objects)) {
            return;
        }

        $findMethod = (array) $this->getFindMethod();

        if (!$findMethod) {
            $findMethodName = 'fetchAll';
            $objects = $this->tableCible->fetchAll();
        } else {
            if (!isset($findMethod['name'])) {
                throw new RuntimeException('No method name was set');
            }
            $findMethodName = $findMethod['name'];
            $findMethodParams = isset($findMethod['params']) ? array_change_key_case($findMethod['params']) : array();
            $repository = $this->serviceManager->getRepository($this->targetClass);

            if (!method_exists($repository, $findMethodName)) {
                throw new RuntimeException(
                sprintf(
                        'Method "%s" could not be found in repository "%s"', $findMethodName, get_class($repository)
                )
                );
            }

            $r = new ReflectionMethod($repository, $findMethodName);
            $args = array();

            foreach ($r->getParameters() as $param) {
                if (array_key_exists(strtolower($param->getName()), $findMethodParams)) {
                    $args[] = $findMethodParams[strtolower($param->getName())];
                } elseif ($param->isDefaultValueAvailable()) {
                    $args[] = $param->getDefaultValue();
                } elseif (!$param->isOptional()) {
                    throw new RuntimeException(
                    sprintf(
                            'Required parameter "%s" with no default value for method "%s" in repository "%s"'
                            . ' was not provided', $param->getName(), $findMethodName, get_class($repository)
                    )
                    );
                }
            }
            $objects = $r->invokeArgs($repository, $args);
        }

        GuardUtils::guardForArrayOrTraversable(
                $objects, sprintf('%s::%s() return value', $this->targetClass, $findMethodName), 'DoctrineModule\Form\Element\Exception\InvalidRepositoryResultException'
        );

        $this->objects = $objects;
    }

    /**
     * Load value options
     *
     * @throws RuntimeException
     * @return void
     */
    protected function loadValueOptions() {
        $om = $this->serviceManager;

        $targetClass = $this->targetClass;
        /**
         * @var \Crud\Table\GuildesTable
         */
        $oTable = $this->getServiceManager()->get($targetClass);


        //$identifier = $metadata->getIdentifierFieldNames();
        $identifier = $oTable->getNomCle();
        $objects = $this->getObjects();
        $options = array();
        $optionAttributes = array();

        if ($this->displayEmptyItem) {
            $options[''] = $this->getEmptyItemLabel();
        }

        foreach ($objects as $key => $object) {
            if (null !== ($generatedLabel = $this->generateLabel($object))) {
                $label = $generatedLabel;
            } elseif ($property = $this->property) {
                if ($this->isMethod == false && !property_exists($this->tableCible->getArrayObjectPrototypeClass(), $property)) {
                    throw new RuntimeException(
                    sprintf(
                            'Property "%s" could not be found in object "%s"', $property, $targetClass
                    )
                    );
                }

                $getter = 'get' . ucfirst($property);

                if (!is_callable(array($object, $getter))) {
                    throw new RuntimeException(
                    sprintf('Methode "%s::%s" non appellable', $this->targetClass, $getter)
                    );
                }

                $label = $object->{$getter}();
            } else {
                if (!is_callable(array($object, '__toString'))) {
                    throw new RuntimeException(
                    sprintf(
                            '%s doit avoir une methode "__toString()" defini si vous n\'avez pas définit de propriété'
                            . ' ou utiliser de methode.', $targetClass
                    )
                    );
                }

                $label = (string) $object;
            }

            if (count($identifier) > 1) {
                $value = $key;
            } else {
                $value = $object->__call('get' . ucfirst($identifier)); // current($metadata->getIdentifierValues($object));
            }

            foreach ($this->getOptionAttributes() as $optionKey => $optionValue) {
                if (is_string($optionValue)) {
                    $optionAttributes[$optionKey] = $optionValue;

                    continue;
                }

                if (is_callable($optionValue)) {
                    $callableValue = call_user_func($optionValue, $object);
                    $optionAttributes[$optionKey] = (string) $callableValue;

                    continue;
                }

                throw new RuntimeException(
                sprintf(
                        'Parameter "option_attributes" expects an array of key => value where value is of type'
                        . '"string" or "callable". Value of type "%s" found.', gettype($optionValue)
                )
                );
            }

            // If no optgroup_identifier has been configured, apply default handling and continue
            if (is_null($this->getOptgroupIdentifier())) {
                $options[] = array('label' => $label, 'value' => $value, 'attributes' => $optionAttributes);

                continue;
            }

            // optgroup_identifier found, handle grouping
            $optgroupGetter = 'get' . ucfirst($this->getOptgroupIdentifier());

            if (!is_callable(array($object, $optgroupGetter))) {
                throw new RuntimeException(
                sprintf('Method "%s::%s" is not callable', $this->targetClass, $optgroupGetter)
                );
            }

            $optgroup = $object->{$optgroupGetter}();

            // optgroup_identifier contains a valid group-name. Handle default grouping.
            if (false === is_null($optgroup) && trim($optgroup) !== '') {
                $options[$optgroup]['label'] = $optgroup;
                $options[$optgroup]['options'][] = array(
                    'label' => $label,
                    'value' => $value,
                    'attributes' => $optionAttributes
                );

                continue;
            }

            $optgroupDefault = $this->getOptgroupDefault();

            // No optgroup_default has been provided. Line up without a group
            if (is_null($optgroupDefault)) {
                $options[] = array('label' => $label, 'value' => $value, 'attributes' => $optionAttributes);

                continue;
            }

            // Line up entry with optgroup_default
            $options[$optgroupDefault]['label'] = $optgroupDefault;
            $options[$optgroupDefault]['options'][] = array(
                'label' => $label,
                'value' => $value,
                'attributes' => $optionAttributes
            );
        }

        $this->valueOptions = $options;
    }

}
