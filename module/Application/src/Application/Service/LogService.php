<?php
namespace Application\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LogService implements ServiceLocatorAwareInterface {

    /**
     * Constante désignant un niveau de criticité critique (0)
     */
    const EMERG     = \Zend\Log\Logger::EMERG;
    /**
     * Constante désignant un niveau de criticité critique (1)
     */
    const ALERT     = \Zend\Log\Logger::ALERT;
    /**
     * Constante désignant un niveau de criticité critique (2)
     */
    const CRIT      = \Zend\Log\Logger::CRIT;
    /**
     * Constante désignant un haut niveau de criticité (3)
     */
    const ERR       = \Zend\Log\Logger::ERR;
    /**
     * Constante désignant un niveau de criticité moyen (4)
     */
    const WARN      = \Zend\Log\Logger::WARN;
    /**
     * Constante désignant un bas niveau de criticité (5)
     */
    const NOTICE    = \Zend\Log\Logger::NOTICE;
    /**
     * Constante désignant un très bas niveau de criticité (6)
     */
    const INFO      = \Zend\Log\Logger::INFO;
    /**
     * Constante désignant le plus bas niveau de criticité (7)
     */
    const DEBUG     = \Zend\Log\Logger::DEBUG;

    private $_critArray = array(
        self::EMERG,
        self::ALERT,
        self::CRIT,
        self::ERR,
        self::WARN,
        self::NOTICE,
        self::INFO,
        self::DEBUG,
    );


    /**
     * Constante désignant la cible des logs logiciels
     */
    const LOGICIEL = 10;
    /**
     * Constante désignant la cible des logs utilisateur
     */
    const USER = 11;

    private $_logArray = array(
        self::USER,
        self::LOGICIEL,
    );

    /**
     * Le nom donné au logger Logiciel
     * @var string Le nom donné au logger Logiciel
     */
    private $_logLogicielName = '\Log-logiciel';
    /**
     * Le nom donné au logger Utilisateur
     * @var string Le nom donné au logger Logiciel
     */
    private $_logUserName = '\Log';


    /**
     * Le ServiceLocator de ce Service
     * @var \Zend\ServiceManager\ServiceLocatorInterface Le ServiceLocator de ce service
     */
    private $_serviceLocator;
    /**
     * Le service de log utilisateur, pour garder une trace des actions de l'utilisateur.
     * Utilisable à travers le lazy getter.
     * @var service Service de log utilisateur
     */
    private $_userLogService;
    /**
     * Le service de log logiciel, pour garder une trace des actions effectuées.
     * Utilisable à travers le lazy getter.
     * @var service Service de log logiciel.
     */
    private $_logService;
    /**
     * Un Container contenant la session de l'opérateur
     * @var \Zend\Session\Container Informations de la session de l'opérateur
     */
    private $_operatorSession;
    /**
     * Le nom de l'utilisateur sous forme de chaine de caractères
     * @var string Le nom de l'utilisateur
     */
    private $_userName;
    /**
     * L'adresse IP d'où provient la requête
     * @var string IP d'où provient la requête
     */
    private $_remoteAddr;
    /**
     * Le service de configuration de Zend
     * @var service Le service de configuration de Zend
     */
    private $_configService;


    /**
     * Lazy getter pour le service de log utilisateur
     * @return service Service de log utilisateur
     */
    private function _getUserLogService() {
        return $this->_userLogService ?
                    $this->_userLogService :
                    $this->_userLogService = $this->getServiceLocator()->get($this->_logUserName);
    }

    /**
     * Lazy getter pour le service des logs logiciel
     * @return service Service de log logiciel
     */
    private function _getLogService() {
        return $this->_logService ?
                    $this->_logService :
                    $this->_logService = $this->getServiceLocator()->get($this->_logLogicielName);
    }

    /**
     * Lazy getter pour la session Opérateur
     * @return \Zend\Session\Container Informations de la session opérateur
     */
    private function _getOperatorSession() {
        return  $this->_operatorSession ?
                    $this->_operatorSession :
                    $this->_operatorSession = new \Zend\Session\Container('users');
    }

    /**
     * Lazy getter pour le nom de l'utilisateur
     * Si il est connecté via l'interface web, c'est son nom d'opérateur
     * Si il est connecté via SSH sur le serveur, c'est USER@IP
     * Sinon, c'est inconnu
     * @return string Le nom de l'utilisateur
     */
    private function _getUserName() {
        return  $this->_userName ?
                    $this->userName :
                    $this->userName = (
                        $this->_getOperatorSession()->offsetGet('users') ?
                            $this->_getOperatorSession()->offsetGet('users')['login'] : (
                                isset($_SERVER) && !empty($_SERVER['USER']) && !empty($_SERVER['SSH_CLIENT']) ?
                                    $_SERVER['USER'] . '@' . split(' ', $_SERVER['SSH_CLIENT'])[0] :
                                    'Utilisateur non loggé'
                                )
                    );
    }

    /**
     * Lazy getter pour la provenance de la requête
     * Si il est connecté via l'interface web, c'est $_SERVER['REMOTE_ADDR']
     * Si il est connecté via SSH c'est $_SERVER['SSH_CLIENT']
     * Sinon, c'est inconnu
     * @return string La provenance de la requête
     */
    private function _getRemoteAddr() {
        return  $this->_remoteAddr ?
                    $this->_remoteAddr :
                    $this->_remoteAddr = (
                        isset($_SERVER) && !empty($_SERVER['REMOTE_ADDR']) ?
                            $_SERVER['REMOTE_ADDR'] : (
                                isset($_SERVER) && !empty($_SERVER['SSH_CLIENT']) ?
                                    split(' ', $_SERVER['SSH_CLIENT'])[0] :
                                    'Adresse inconnue'
                            )
                    );
    }

    /**
     * Lazy getter pour le service de configuration Zend
     * @return service Service de configuration
     */
    private function _getConfigService() {
        return  $this->_configService ?
                    $this->_configService :
                    $this->_configService = $this->getServiceLocator()->get('config');
    }


    /**
     * Méthode de l'interface ServiceLocatorAwareInteface permettant de récupérer
     * le ServiceLocator de ce Service
     * @return \Zend\ServiceManager\ServiceLocatorInterface Le ServiceLocator
     */
    public function getServiceLocator() {
        return $this->_serviceLocator;
    }

    /**
     * Méthode de l'interface ServiceLocatorAwareInteface permettant de modifier
     * le ServiceLocator de ce Service
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
        $this->_serviceLocator = $serviceLocator;
    }


    /**
     * Méthode permettant de logger des informations dans le logger cible
     * @param int $crit La criticité du log, de 0 à 7. Définie par les constantes
     * EMERG, ALERT, CRIT, ERR, WARN, NOTICE, INFO, DEBUG
     * @param string $message Le message à logger
     * @param int $target Le logger cible, de valeur 10 ou 11. Défini par les
     * constantes LOGICIEL et USER
     * @throws \Exception
     */
    public function log($crit, $message, $target) {
        if (!in_array($crit, $this->_critArray)) {
            throw new \Exception('Criticité non gérée : ' . $crit);
        }
        if (!in_array($target, $this->_logArray)) {
            throw new \Exception('Cible non gérée : ' . $target);
        }

        if (strstr($message, '|') || strstr($message, '\n')) {
            $this->log(self::WARN, 'Tentative de log d\'un message contenant des caractères interdits.', self::LOGICIEL);
        }
        $filteredMessage = str_replace(array('|', PHP_EOL), array(':', ';'), $message);

        switch ($target) {
            case self::LOGICIEL :
                $this->_logLogiciel($crit, $filteredMessage);
                break;
            case self::USER :
                $this->_logUser($crit, $filteredMessage);
                break;
            default :
                throw new \Exception('Cible non gérée : ' . $target);
        }
    }

    /**
     * Méthode permettant d'exporter les logs du jour dans un fichier CSV présent
     * dans /public/csv/
     * @param int $logs Le type de logs à exporter, de valeur 10 ou 11. Défini par
     * les constantes LOGICIEL et USER
     * @param string $destination Le nom du fichier de destination
     * @throws \Exception
     * @return string Le chemin vers le fichier CSV généré
     */
    public function exportCsv($logs, $destinationName = '') {
        // Si le fichier de destination n'est pas renseigné, on prend la date du jour
        if ($destinationName == '') {
            $destinationName = 'log.' . date('y_m_d');
        }
        // On vérifie que la destination ne change pas de dossier
        if (basename($destinationName) !== $destinationName) {
            throw new \Exception('Le dossier de destination ne doit pas changer.');
        }
        if (!in_array($logs, $this->_logArray)) {
            throw new \Exception('Type de log non géré : ' . $logs);
        }

        $csvPath = $this->_getPathToRoot() . '/public/csv/' . $destinationName . '.csv';
        $csvHandle = fopen($csvPath, 'w');
        if ($csvHandle === FALSE) {
            throw new \Exception("Impossible de créer le fichier $csvPath.");
        }
        $logPath = '';
        $headerArray = array();
        switch ($logs) {
            case self::USER:
                $headerArray = array('INFORMATIONS', 'MODULE', 'UTILISATEUR', 'PROVENANCE', 'MESSAGE');
                $logPath = $this->_getPathToLogUser();
                break;
            case self::LOGICIEL:
                $headerArray = array('INFORMATIONS', 'MODULE', 'FICHIER', 'LIGNE', 'UTILISATEUR', 'PROVENANCE', 'MESSAGE');
                $logPath = $this->_getPathToLogLogiciel();
                break;
            default :
                throw new \Exception('Type de log non géré : ' . $logs);
        }
        $logHandle = fopen($logPath, 'r');
        if ($logHandle === FALSE) {
            throw new \Exception("Impossible de lire le fichier de logs $logPath");
        }

        fputcsv($csvHandle, $headerArray);
        while (($line = fgets($logHandle)) !== FALSE) {
            fputcsv($csvHandle, explode(' | ', str_replace(PHP_EOL, '', $line)));
        }

        fclose($logHandle);
        fclose($csvHandle);
        return $csvPath;
    }


    /**
     * Méthode permettant de logger des informations dans le service de log logiciel
     * @param int $crit La criticité du log (Logger::crit)
     * @param string $msg Le message d'erreur
     */
    private function _logLogiciel($crit, $msg) {
        $trace = debug_backtrace();
        $module = explode('\\', $trace[2]['class'])[0];
        $file = str_replace($this->_getPathToRoot(), '', $trace[1]['file']);
        $line = $trace[1]['line'];

        $this->_getLogService()->log(
            $crit,
            '| ' . $module . ' | ' . $file . ' | ' . $line . ' | ' . $this->_getUserName() . ' | ' . $this->_getRemoteAddr() . ' | ' . $msg
        );
    }

    /**
     * Méthode permettant de logger des informations dans le service de log utilisateur
     * @param int $crit La criticité du log (Logger::crit)
     * @param string $msg Le message d'erreur
     */
    private function _logUser($crit, $msg) {
        $trace = debug_backtrace();
        $module = explode('\\', $trace[2]['class'])[0];
        $this->_getUserLogService()->log(
            $crit,
            '| ' . $module . ' | ' . $this->_getUserName() . ' | ' . $this->_getRemoteAddr() . ' | ' . $msg
        );
    }

    /**
     * Méthode retournant le chemin vers la racine de WebKiosk
     * @return string Le chemin vers la racine de WebKiosk
     */
    private function _getPathToRoot() {
        return realPath(__DIR__ . '/../../../../..');
    }

    /**
     * Méthode retournant le chemin vers le fichier de logs Logiciel
     * @return string Chemin vers le fichier de logs Logiciel
     */
    private function _getPathToLogLogiciel() {
        return $this->_getPathToRoot() . '/' . $this->_getConfigService()['log'][$this->_logLogicielName]['writers'][0]['options']['stream'];
    }

    /**
     * Méthode retournant le chemin vers le fichier de logs Utilisateur
     * @return string Chemin vers le fichier de logs Utilisateur
     */
    private function _getPathToLogUser() {
        return $this->_getPathToRoot() . '/' . $this->_getConfigService()['log'][$this->_logUserName]['writers'][0]['options']['stream'];
    }
}
