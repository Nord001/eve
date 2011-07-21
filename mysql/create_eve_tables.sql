CREATE TABLE IF NOT EXISTS `eve`.`eve_user_table` (
  `user_id` INT NOT NULL ,
  `username` VARCHAR(64) NULL ,
  `email` VARCHAR(64) NULL ,
  `password` VARCHAR(32) NULL ,
  `date_created` DATETIME NULL ,
  `last_visited` DATETIME NULL ,
  `access_level` TINYINT NULL ,
  `login_count` INT NULL ,
  `failed_login_count` INT NULL ,
  `cookie_string` VARCHAR(64) NULL ,
  PRIMARY KEY (`user_id`) )
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `eve`.`eve_item_category_table` (
  `category_id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `category_name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`category_id`) )
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `eve`.`eve_item_type_table` (
  `category_id` INT UNSIGNED NOT NULL ,
  `type_id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `type_name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`type_id`, `category_id`) ,
  INDEX `fk_item_type_item_category` (`category_id` ASC) ,
  CONSTRAINT `fk_item_type_item_category`
    FOREIGN KEY (`category_id` )
    REFERENCES `eve`.`eve_item_category_table` (`category_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `eve`.`eve_item_table` (
  `category_id` INT UNSIGNED NOT NULL ,
  `type_id` INT UNSIGNED NOT NULL ,
  `item_id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `item_name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`item_id`, `type_id`, `category_id`) ,
  INDEX `fk_item_item_type` (`type_id` ASC) ,
  INDEX `fk_item_item_category` (`category_id` ASC) ,
  CONSTRAINT `fk_item_item_type`
    FOREIGN KEY (`type_id` )
    REFERENCES `eve`.`eve_item_type_table` (`type_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_item_item_category`
    FOREIGN KEY (`category_id` )
    REFERENCES `eve`.`eve_item_category_table` (`category_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
