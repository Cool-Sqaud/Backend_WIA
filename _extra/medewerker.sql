DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `idrole_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB, DEFAULT CHARSET=utf16;

DROP TABLE IF EXISTS `employee`;
CREATE TABLE `employee` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`role_id` INT NOT NULL,
	`first_name` VARCHAR(35) NOT NULL,
	`last_name` VARCHAR(35) NOT NULL,
	`email` VARCHAR(254) NOT NULL,
	`password` VARCHAR(128) NOT NULL,
PRIMARY KEY (`id`),
INDEX `employee_role_fk_idx` (`role_id` ASC) VISIBLE,
UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE,
CONSTRAINT `employee_role_fk`
  FOREIGN KEY (`role_id`)
  REFERENCES `role` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION)
ENGINE = InnoDB, DEFAULT CHARSET=utf16;
