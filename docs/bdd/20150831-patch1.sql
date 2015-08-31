SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

ALTER SCHEMA `db580625521`  DEFAULT CHARACTER SET utf8  DEFAULT COLLATE utf8_general_ci ;

ALTER TABLE `db580625521`.`evenements_personnage` 
DROP FOREIGN KEY `fk_evenement_personnage_personnage1`;

ALTER TABLE `db580625521`.`roster_has_personnage` 
DROP FOREIGN KEY `fk_roster_has_personnage_personnage1`;

ALTER TABLE `db580625521`.`personnage` 
RENAME TO  `db580625521`.`personnages` ;

ALTER TABLE `db580625521`.`classe` 
RENAME TO  `db580625521`.`classes` ;

ALTER TABLE `db580625521`.`race` 
RENAME TO  `db580625521`.`races` ;

ALTER TABLE `db580625521`.`evenements_personnage` 
ADD CONSTRAINT `fk_evenement_personnage_personnage1`
  FOREIGN KEY (`idPersonnage`)
  REFERENCES `db580625521`.`personnages` (`idPersonnage`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `db580625521`.`roster_has_personnage` 
ADD CONSTRAINT `fk_roster_has_personnage_personnage1`
  FOREIGN KEY (`idPersonnage`)
  REFERENCES `db580625521`.`personnages` (`idPersonnage`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `db580625521`.`jeux`
CHANGE COLUMN `idJeux` `idJeux` INT(11) NOT NULL AUTO_INCREMENT ;

ALTER TABLE `db580625521`.`roles`
CHANGE COLUMN `idRoles` `idRoles` INT(11) NOT NULL AUTO_INCREMENT ;

ALTER TABLE `db580625521`.`personnages`
CHANGE COLUMN `idPersonnage` `idPersonnage` INT(11) NOT NULL AUTO_INCREMENT ;

ALTER TABLE `db580625521`.`classes`
CHANGE COLUMN `idClasse` `idClasse` INT(11) NOT NULL AUTO_INCREMENT ;

ALTER TABLE `db580625521`.`donjon`
CHANGE COLUMN `idDonjon` `idDonjon` INT(11) NOT NULL AUTO_INCREMENT ;

ALTER TABLE `db580625521`.`races`
CHANGE COLUMN `idRace` `idRace` INT(11) NOT NULL AUTO_INCREMENT ;

ALTER TABLE `db580625521`.`users`
CHANGE COLUMN `idUsers` `idUsers` INT(11) NOT NULL AUTO_INCREMENT ;

ALTER TABLE `db580625521`.`evenements`
CHANGE COLUMN `idEvenements` `idEvenements` INT(11) NOT NULL AUTO_INCREMENT ;

ALTER TABLE `db580625521`.`evenements_template`
CHANGE COLUMN `idEvenements_template` `idEvenements_template` INT(11) NOT NULL AUTO_INCREMENT ;

ALTER TABLE `db580625521`.`evenements_personnage`
CHANGE COLUMN `idEvenement_personnage` `idEvenement_personnage` INT(11) NOT NULL AUTO_INCREMENT ;

ALTER TABLE `db580625521`.`evenements_roles`
CHANGE COLUMN `idEvenements_roles` `idEvenements_roles` INT(11) NOT NULL AUTO_INCREMENT ;

ALTER TABLE `db580625521`.`evenements_template_roles`
CHANGE COLUMN `idEvenements_template_roles` `idEvenements_template_roles` INT(11) NOT NULL AUTO_INCREMENT ;

ALTER TABLE `db580625521`.`guildes`
CHANGE COLUMN `idGuildes` `idGuildes` INT(11) NOT NULL AUTO_INCREMENT ;

ALTER TABLE `db580625521`.`roster`
CHANGE COLUMN `idRoster` `idRoster` INT(11) NOT NULL AUTO_INCREMENT ;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
