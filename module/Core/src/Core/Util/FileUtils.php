<?php

namespace Core\Util;

/**
 * Description of FileUtils
 *
 * @author Cédric
 */
class FileUtils {

    /**
     *
     * @param string $sRep chemin
     * @param int $iNbNivATest
     * @param int $iNvCourrant
     * @return array
     */
    public static function getDirContents($sRep, $iNbNivATest, $iNvCourrant = 0, $bCheminComplet = false) {
        $handle = opendir($sRep);
        if (!$handle)
            return array();
        $aContenu = array();
        if ($iNbNivATest > $iNvCourrant) {
            while ($sEntree = readdir($handle)) {
                if ($sEntree == '.' || $sEntree == '..')
                    continue;

                $sEntreeFull = $sRep . DIRECTORY_SEPARATOR . $sEntree;
                if (is_file($sEntreeFull)) {
                    $aContenu = array_merge($aContenu, array((!$bCheminComplet) ? $sEntree : $sEntreeFull => 'File'));
                } else if (is_dir($sEntreeFull)) {
                    $aContenu = array_merge($aContenu, array((!$bCheminComplet) ? $sEntree : $sEntreeFull => 'rep'));
                    $iNvCourrant++;
                    $aContenu = array_merge($aContenu, \Core\Util\FileUtils::getDirContents($sEntreeFull, $iNbNivATest, $iNvCourrant, $bCheminComplet));
                }
            }
        }
        closedir($handle);
        return $aContenu;
    }

}
