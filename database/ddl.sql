-- MySQL Script generated by MySQL Workbench
-- 10/19/16 01:05:46
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(45) NULL,
  `last_name` VARCHAR(45) NULL,
  `login` VARCHAR(45) NULL,
  `password` VARCHAR(255) NULL,
  PRIMARY KEY (`id`))
  ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`country`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`country` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
  ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`city`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`city` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `country_id` INT NOT NULL,
  `name` VARCHAR(45) NULL,
  PRIMARY KEY (`id`, `country_id`),
  INDEX `fk_city_country1_idx` (`country_id` ASC),
  CONSTRAINT `fk_city_country1`
  FOREIGN KEY (`country_id`)
  REFERENCES `mydb`.`country` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`adress`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`adress` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `city_id` INT NOT NULL,
  `adress` VARCHAR(45) NULL,
  PRIMARY KEY (`id`, `user_id`, `city_id`),
  INDEX `fk_adress_users_idx` (`user_id` ASC),
  INDEX `fk_adress_city1_idx` (`city_id` ASC),
  CONSTRAINT `fk_adress_users`
  FOREIGN KEY (`user_id`)
  REFERENCES `mydb`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_adress_city1`
  FOREIGN KEY (`city_id`)
  REFERENCES `mydb`.`city` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;