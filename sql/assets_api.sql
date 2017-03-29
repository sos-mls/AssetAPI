-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema AssetsAPIDB
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `AssetsAPIDB` ;

-- -----------------------------------------------------
-- Schema AssetsAPIDB
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `AssetsAPIDB` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin ;
USE `AssetsAPIDB` ;

-- -----------------------------------------------------
-- Table `AssetsAPIDB`.`tbl_asset_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `AssetsAPIDB`.`tbl_asset_type` ;

CREATE TABLE IF NOT EXISTS `AssetsAPIDB`.`tbl_asset_type` (
  `asset_type_id` INT NOT NULL AUTO_INCREMENT,
  `asset_type` VARCHAR(32) NOT NULL,
  PRIMARY KEY (`asset_type_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `AssetsAPIDB`.`tbl_asset`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `AssetsAPIDB`.`tbl_asset` ;

CREATE TABLE IF NOT EXISTS `AssetsAPIDB`.`tbl_asset` (
  `asset_id` INT NOT NULL AUTO_INCREMENT,
  `asset_type_id` INT NOT NULL,
  `file_name` VARCHAR(256) NOT NULL,
  `file_size` INT NOT NULL,
  `uploaded_name` VARCHAR(64) NOT NULL,
  `created_at` DATETIME NULL,
  PRIMARY KEY (`asset_id`),
  INDEX `fk_tbl_asset_tbl_asset_type_idx` (`asset_type_id` ASC),
  CONSTRAINT `fk_tbl_asset_tbl_asset_type`
    FOREIGN KEY (`asset_type_id`)
    REFERENCES `AssetsAPIDB`.`tbl_asset_type` (`asset_type_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `AssetsAPIDB`.`tbl_image`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `AssetsAPIDB`.`tbl_image` ;

CREATE TABLE IF NOT EXISTS `AssetsAPIDB`.`tbl_image` (
  `image_id` INT NOT NULL AUTO_INCREMENT,
  `asset_id` INT NOT NULL,
  `file_name` VARCHAR(256) NOT NULL,
  `file_size` INT NOT NULL,
  `width` INT NOT NULL,
  `height` INT NOT NULL,
  `created_at` DATETIME NULL,
  PRIMARY KEY (`image_id`),
  INDEX `fk_tbl_image_tbl_asset1_idx` (`asset_id` ASC),
  CONSTRAINT `fk_tbl_image_tbl_asset1`
    FOREIGN KEY (`asset_id`)
    REFERENCES `AssetsAPIDB`.`tbl_asset` (`asset_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `AssetsAPIDB`.`tbl_asset_type`
-- -----------------------------------------------------
START TRANSACTION;
USE `AssetsAPIDB`;
INSERT INTO `AssetsAPIDB`.`tbl_asset_type` (`asset_type_id`, `asset_type`) VALUES (DEFAULT, 'image');
INSERT INTO `AssetsAPIDB`.`tbl_asset_type` (`asset_type_id`, `asset_type`) VALUES (DEFAULT, 'video');
INSERT INTO `AssetsAPIDB`.`tbl_asset_type` (`asset_type_id`, `asset_type`) VALUES (DEFAULT, 'file');

COMMIT;

