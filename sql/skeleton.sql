-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema SkeletonDB
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `SkeletonDB` ;

-- -----------------------------------------------------
-- Schema SkeletonDB
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `SkeletonDB` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin ;
USE `SkeletonDB` ;

-- -----------------------------------------------------
-- Table `SkeletonDB`.`tbl_user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SkeletonDB`.`tbl_user` ;

CREATE TABLE IF NOT EXISTS `SkeletonDB`.`tbl_user` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `user_hash_id` VARCHAR(255) NOT NULL,
  `username` VARCHAR(64) NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`user_id`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `SkeletonDB`.`tbl_user`
-- -----------------------------------------------------
START TRANSACTION;
USE `SkeletonDB`;
INSERT INTO `SkeletonDB`.`tbl_user` (`user_id`, `user_hash_id`, `username`, `created_at`, `updated_at`) VALUES (1, 'default_hash_id', 'admin@salecents.com', NULL, NULL);

COMMIT;

