SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `surveys` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `surveys` ;

-- -----------------------------------------------------
-- Table `surveys`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `surveys`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(45) NULL,
  `last_name` VARCHAR(45) NULL,
  `email` VARCHAR(255) NULL,
  `password` VARCHAR(45) NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `surveys`.`surveys`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `surveys`.`surveys` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `question` TEXT NULL,
  `choice1` TEXT NULL,
  `choice2` TEXT NULL,
  `choice3` TEXT NULL,
  `choice4` TEXT NULL,
  `count1` INT NULL DEFAULT 0,
  `count2` INT NULL DEFAULT 0,
  `count3` INT NULL DEFAULT 0,
  `count4` INT NULL DEFAULT 0,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_surveys_users_idx` (`user_id` ASC),
  CONSTRAINT `fk_surveys_users`
    FOREIGN KEY (`user_id`)
    REFERENCES `surveys`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
