SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

CREATE TABLE IF NOT EXISTS `hospital`.`cabinet` (
  `id` INT(11) NOT NULL,
  `number` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `number_UNIQUE` (`number` ASC) ,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `hospital`.`doctors` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL DEFAULT NULL,
  `last_name` VARCHAR(45) NULL DEFAULT NULL,
  `fathers_name` VARCHAR(45) NULL DEFAULT NULL,
  `phone_numb` VARCHAR(11) NULL DEFAULT NULL,
  `password` VARCHAR(45) NULL DEFAULT NULL,
  `employment_date` DATE NULL DEFAULT NULL,
  `cabinet_id` INT(11) NULL DEFAULT NULL,
  `doc_rang` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
  UNIQUE INDEX `phone_numb_UNIQUE` (`phone_numb` ASC) ,
  INDEX `id_idx` (`cabinet_id` ASC) ,
  CONSTRAINT `cabinet_fk`
    FOREIGN KEY (`cabinet_id`)
    REFERENCES `hospital`.`cabinet` (`id`)
    ON DELETE SET NULL
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `hospital`.`registration_coupon` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `num_coupon` INT(11) NULL DEFAULT NULL,
  `reg_date` DATE NULL DEFAULT NULL,
  `doctors_id` INT(11) NULL DEFAULT NULL,
  `doctors_schedule_id` INT(11) NULL DEFAULT NULL,
  `patients_id` INT(11) NULL DEFAULT NULL,
  `patients_med_card_id` INT(11) NULL DEFAULT NULL,
  `patients_health_insurance_id` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
  INDEX `id_idx` (`doctors_id` ASC) ,
  INDEX `id_idx1` (`patients_id` ASC) ,
  INDEX `id_idx2` (`patients_med_card_id` ASC) ,
  INDEX `id_idx3` (`patients_health_insurance_id` ASC) ,
  CONSTRAINT `doctors_fk`
    FOREIGN KEY (`doctors_id`)
    REFERENCES `hospital`.`doctors` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `patients_fk`
    FOREIGN KEY (`patients_id`)
    REFERENCES `hospital`.`patients` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `med_card_fk`
    FOREIGN KEY (`patients_med_card_id`)
    REFERENCES `hospital`.`med_card` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `health_insurance_fk`
    FOREIGN KEY (`patients_health_insurance_id`)
    REFERENCES `hospital`.`health_insurance` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `hospital`.`patients` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL DEFAULT NULL,
  `last_name` VARCHAR(45) NULL DEFAULT NULL,
  `fathers_name` VARCHAR(45) NULL DEFAULT NULL,
  `phone_numb` VARCHAR(11) NULL DEFAULT NULL,
  `location` VARCHAR(80) NULL DEFAULT NULL,
  `last_visit` DATE NULL DEFAULT NULL,
  `med_card_id` INT(11) NULL DEFAULT NULL,
  `health_insurance_id` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `phone_numb_UNIQUE` (`phone_numb` ASC) ,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
  INDEX `health_insurance_fk_idx` (`health_insurance_id` ASC) ,
  INDEX `med_card_fk_idx` (`med_card_id` ASC)
    )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `hospital`.`management` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `login` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `position` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `login_UNIQUE` (`login` ASC) ,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `hospital`.`med_card` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `illness` VARCHAR(500) NULL DEFAULT NULL,
  `num_visits` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `hospital`.`health_insurance` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `num_insurance` VARCHAR(16) NULL DEFAULT NULL,
  `company` VARCHAR(70) NULL DEFAULT NULL,
  `date of issue` DATE NULL DEFAULT NULL,
  `shelf_life` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
