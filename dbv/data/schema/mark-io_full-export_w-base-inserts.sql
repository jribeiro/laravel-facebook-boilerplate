SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `mark_db` ;
CREATE SCHEMA IF NOT EXISTS `mark_db` DEFAULT CHARACTER SET utf8 ;
USE `mark_db` ;

-- -----------------------------------------------------
-- Table `mark_db`.`providers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mark_db`.`providers` ;

CREATE  TABLE IF NOT EXISTS `mark_db`.`providers` (
  `int` INT(11) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(64) NULL DEFAULT NULL ,
  `is_active` TINYINT(1) NULL DEFAULT NULL ,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ,
  PRIMARY KEY (`int`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `mark_db`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mark_db`.`users` ;

CREATE  TABLE IF NOT EXISTS `mark_db`.`users` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT ,
  `email` VARCHAR(128) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL ,
  `nickname` VARCHAR(45) NOT NULL ,
  `password` VARCHAR(64) NOT NULL ,
  `gender` VARCHAR(8) NULL DEFAULT NULL ,
  `fullname` VARCHAR(128) NOT NULL ,
  `firstname` VARCHAR(64) NOT NULL ,
  `lastname` VARCHAR(64) NOT NULL ,
  `img_url` VARCHAR(256) NULL DEFAULT NULL ,
  `access_token` VARCHAR(256) NULL DEFAULT NULL ,
  `mantra` VARCHAR(512) NULL DEFAULT NULL ,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ,
  `provider_id` INT(11) NULL DEFAULT NULL ,
  `is_confirmed` TINYINT(1) NOT NULL DEFAULT '0' ,
  `is_active` TINYINT(1) NOT NULL DEFAULT '1' ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) ,
  INDEX `provider_fk_idx` (`provider_id` ASC) ,
  CONSTRAINT `provider_fk`
    FOREIGN KEY (`provider_id` )
    REFERENCES `mark_db`.`providers` (`int` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `mark_db`.`followers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mark_db`.`followers` ;

CREATE  TABLE IF NOT EXISTS `mark_db`.`followers` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT ,
  `user_id` BIGINT(20) NOT NULL ,
  `friend_id` BIGINT(20) NOT NULL ,
  `fullname` VARCHAR(128) NULL DEFAULT NULL ,
  `is_markio_friend` TINYINT(1) NOT NULL DEFAULT '0' ,
  `confirmed_on` TIMESTAMP NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `unique_pair` (`user_id` ASC, `friend_id` ASC) ,
  INDEX `user_fk_idx` (`user_id` ASC) ,
  CONSTRAINT `follower_user_fk`
    FOREIGN KEY (`user_id` )
    REFERENCES `mark_db`.`users` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `mark_db`.`hashs`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mark_db`.`hashs` ;

CREATE  TABLE IF NOT EXISTS `mark_db`.`hashs` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT ,
  `user_id` BIGINT(20) NOT NULL ,
  `hash` VARCHAR(64) NOT NULL ,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `expires_on` TIMESTAMP NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `user_fk_idx` (`user_id` ASC) ,
  CONSTRAINT `hash_user_fk`
    FOREIGN KEY (`user_id` )
    REFERENCES `mark_db`.`users` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `mark_db`.`logins`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mark_db`.`logins` ;

CREATE  TABLE IF NOT EXISTS `mark_db`.`logins` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT ,
  `user_id` BIGINT(20) NOT NULL ,
  `logged_in_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `logged_out_at` TIMESTAMP NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `user_logins_fk_idx` (`user_id` ASC) ,
  CONSTRAINT `user_logins_fk`
    FOREIGN KEY (`user_id` )
    REFERENCES `mark_db`.`users` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `mark_db`.`beta_allowed_ids`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mark_db`.`beta_allowed_ids` ;

CREATE  TABLE IF NOT EXISTS `mark_db`.`beta_allowed_ids` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `fbId` BIGINT NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
