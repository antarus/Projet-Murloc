# Projet-Murloc


## divers question.
impactant le dev...

site multi jeux. mais est que le site est configuré pour un seul jeu, ou chaque event, guilde,personnage peut être céée sur différent jeux.
si on fait qu'un jeu actif  le systeme de plugin pour les jeux devra etre bascule en module.

## remarque divers

Les tests de lien vers le plugin jeux WoW sont effectués sur le backend/guildescontroller.

Le modules Guildes est obsolete mais garder car il ya des truc a garder.


## TODO

sortir les construction d'objet ds les fishier de config qui empeche d'utiliser la fonction de cache de la config... utiliser les factorie.

voir a fusionner le module jeux et core. jeux dependant de core aucun interet a separer au vu de la logique zf2.

Passer le module bnet en vendor externe.



## Configuration minimale

Tout d'abord pour faire fonctionner les thèmes et le système de jeu, configurez votre virtualhost comme suit :

    <VirtualHost *:80>
         ServerName localhost
         DocumentRoot chemin_vers_le_repertoire_murloc/public
         SetEnv APPLICATION_ENV "development"


         <Directory chemin_vers_le_repertoire_murloc/public>
             DirectoryIndex index.php
             AllowOverride All
             Order allow,deny
             Allow from all
         </Directory>

        AliasMatch /([a-zA-Z0-9\.\-]+)/(css|js|img|images|fonts)/([a-zA-Z0-9\.\-]+)/(.*) chemin_vers_le_repertoire_murloc/themes/$1/$2/$3/$4
         <Directory chemin_vers_le_repertoire_murloc/themes>
             AllowOverride All
             Order allow,deny
             Allow from all
         </Directory>

        AliasMatch /jeux/([a-zA-Z0-9\.\-]+)/(css|js|img|images|fonts)/(.*) chemin_vers_le_repertoire_murloc/jeux/$1/public/$2/$3
         <Directory chemin_vers_le_repertoire_murloc/jeux>
             AllowOverride All
             Order allow,deny
             Allow from all
         </Directory>


     </VirtualHost>

## Pour les dev

### Gestion des jeux

Un jeux est répertoire situé dans le dossier jeux.
il doit respecter quelque contraintes.
Ce dossier doit contenir un fichier portant le même nom que le répertoire a la racine.
Ce fichier doit étendre ``\Core\Plugin\AbstractPlugin`` et implementé ``\Core\Plugin\PluginJeuxInterface``.
Exemple du fichier Wow

    namespace Jeux;

    use Zend\EventManager\EventInterface;

    class Wow extends \Core\Plugin\AbstractPlugin implements \Core\Plugin\PluginJeuxInterface {
    ...
    }


Toujours a la racine, il doit contenir un fichier ``autoload_classmap.php`` recensant les classes utilisées par votre plugin de jeu.

il doit contenir un dossier ``config`` contenant un fichier ``config.php``.
le contenu de ce fichier doit au minimum référencé en tant que ``invokables`` la classe située a la racine:


    return array(
        'manager_jeux' => array(
            'invokables' => array(
                'Jeux\Wow' => 'Jeux\Wow',
            ),
        ),
    );

une fois votre dossier respectant le minimum requis vous êtes libre de réaliser l'arborescence qu'il vous plait.

Pour finaliser l'ajout d'un jeu, éditer le fichier ``jeux.config.php``, ajouter votre jeu (le nom doit respecter strictement le nom du dossier créé plus haut. casse identique)

Afin d'eviter les chargement inutile, vous pouvez desactiver un jeu en mettant la valeur 0(1 pour l'activer).


### Gestion des thèmes

un theme est ni plus ni moins qu'un dossier regroupant les différentes page de l'application, et les ressources nécessaires.
ce dossier contient un dossier view qui recense les pages par module.Il respecte le format de Zf2 donc copier le contenu du dossier view dans celui-ci fonctionnera.
IL peut contenir un dossier css, img, et js.

il doit contenir un fichier config.php avec le contenu suivant :

    return array('template_path_stack' => array(
            'default' => __DIR__ . '/view',
        ),
        'template_map' => include 'template_map.php',
        // spécifique layout pour certain modules
        'module_layouts' => array('Application' => 'layout/layout', 'Backend' => 'layout/backend',),
    );

Il est identique a la configuration des vue en Zf2, avec la particularité de l'option module/layout, qui permet de spécifier un layout différent selon les modules.
