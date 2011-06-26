CREATE TABLE IF NOT EXISTS `item_category` (
  `category_ID` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_name` VARCHAR(25) NOT NULL,
  PRIMARY KEY (`category_ID`))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `item_type` (
  `category_ID` TINYINT UNSIGNED NOT NULL,
  `type_ID` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `type_Name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`type_ID`, `category_ID`),
  INDEX `fk_item_type_item_category` (`category_ID` ASC),
  CONSTRAINT `fk_item_type_item_category`
    FOREIGN KEY (`category_ID`)
    REFERENCES `item_category` (`category_ID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `item` (
  `category_ID` TINYINT UNSIGNED NOT NULL,
  `type_ID` SMALLINT UNSIGNED NOT NULL,
  `item_ID` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `item_name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`item_ID`, `type_ID`, `category_ID`),
  INDEX `fk_item_item_type` (`type_ID` ASC),
  CONSTRAINT `fk_item_item_type`
    FOREIGN KEY (`type_ID`)
    REFERENCES `item_type` (`type_ID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  INDEX `fk_item_item_category` (`category_ID` ASC),
  CONSTRAINT `fk_item_item_category`
    FOREIGN KEY (`category_ID`)
    REFERENCES `item_category` (`category_ID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;