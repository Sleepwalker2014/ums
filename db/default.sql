
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- animals
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `animals`;

CREATE TABLE `animals`
(
    `animal` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(45) NOT NULL,
    `birthDay` DATE,
    `sexId` INTEGER NOT NULL,
    `furColourId` int(11) unsigned NOT NULL,
    `eyeColourId` int(11) unsigned NOT NULL,
    `speciesId` int(11) unsigned NOT NULL,
    `size` int(10) unsigned NOT NULL,
    `specification` VARCHAR(255) NOT NULL,
    `raceId` int(11) unsigned,
    `userId` int(10) unsigned NOT NULL,
    `image` VARCHAR(256),
    PRIMARY KEY (`animal`),
    INDEX `fk_sex` (`sexId`),
    INDEX `fk_furColour` (`furColourId`),
    INDEX `fk_eyeColour` (`eyeColourId`),
    INDEX `fk_race` (`raceId`),
    INDEX `fk_species` (`speciesId`),
    INDEX `userId` (`userId`),
    CONSTRAINT `animals_ibfk_10`
        FOREIGN KEY (`raceId`)
        REFERENCES `races` (`race`)
        ON UPDATE CASCADE,
    CONSTRAINT `animals_ibfk_11`
        FOREIGN KEY (`userId`)
        REFERENCES `users` (`user`)
        ON UPDATE CASCADE,
    CONSTRAINT `animals_ibfk_6`
        FOREIGN KEY (`speciesId`)
        REFERENCES `species` (`species`)
        ON UPDATE CASCADE,
    CONSTRAINT `animals_ibfk_7`
        FOREIGN KEY (`sexId`)
        REFERENCES `sexes` (`sex`)
        ON UPDATE CASCADE,
    CONSTRAINT `animals_ibfk_8`
        FOREIGN KEY (`furColourId`)
        REFERENCES `colours` (`colour`)
        ON UPDATE CASCADE,
    CONSTRAINT `animals_ibfk_9`
        FOREIGN KEY (`eyeColourId`)
        REFERENCES `colours` (`colour`)
        ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- colours
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `colours`;

CREATE TABLE `colours`
(
    `colour` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `code` VARCHAR(45) NOT NULL,
    `name` VARCHAR(45) NOT NULL,
    PRIMARY KEY (`colour`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- notificationType
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `notificationType`;

CREATE TABLE `notificationType`
(
    `notificationType` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `code` VARCHAR(25) NOT NULL,
    `description` VARCHAR(256) NOT NULL,
    PRIMARY KEY (`notificationType`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- notifications
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `notifications`;

CREATE TABLE `notifications`
(
    `notification` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `latitude` DOUBLE NOT NULL,
    `notificationTypeId` int(10) unsigned NOT NULL,
    `creationDate` DATE NOT NULL,
    `description` VARCHAR(2048) NOT NULL,
    `animalId` INTEGER NOT NULL,
    `longitude` DOUBLE NOT NULL,
    PRIMARY KEY (`notification`),
    INDEX `fk_animal` (`animalId`),
    INDEX `fk_notificationType` (`notificationTypeId`),
    CONSTRAINT `notifications_ibfk_1`
        FOREIGN KEY (`notificationTypeId`)
        REFERENCES `notificationType` (`notificationType`)
        ON UPDATE CASCADE,
    CONSTRAINT `notifications_ibfk_2`
        FOREIGN KEY (`animalId`)
        REFERENCES `animals` (`animal`)
        ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- races
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `races`;

CREATE TABLE `races`
(
    `race` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `code` VARCHAR(15) NOT NULL,
    `name` VARCHAR(25) NOT NULL,
    PRIMARY KEY (`race`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- searchNotifications
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `searchNotifications`;

CREATE TABLE `searchNotifications`
(
    `searchNotification` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `notification` int(10) unsigned NOT NULL,
    `missingDate` DATE NOT NULL,
    `additionalInformation` VARCHAR(1024) NOT NULL,
    `reward` int(10) unsigned NOT NULL,
    PRIMARY KEY (`searchNotification`),
    UNIQUE INDEX `notification` (`notification`),
    CONSTRAINT `searchNotifications_ibfk_1`
        FOREIGN KEY (`notification`)
        REFERENCES `notifications` (`notification`)
        ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- sessions
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `sessions`;

CREATE TABLE `sessions`
(
    `session` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `user` int(10) unsigned NOT NULL,
    `sessionID` VARCHAR(45) NOT NULL,
    PRIMARY KEY (`session`),
    UNIQUE INDEX `user` (`user`, `sessionID`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- sexes
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `sexes`;

CREATE TABLE `sexes`
(
    `sex` INTEGER NOT NULL AUTO_INCREMENT,
    `code` VARCHAR(10) NOT NULL,
    `description` VARCHAR(25) NOT NULL,
    PRIMARY KEY (`sex`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- sizes
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `sizes`;

CREATE TABLE `sizes`
(
    `size` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `description` VARCHAR(25) NOT NULL,
    PRIMARY KEY (`size`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- species
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `species`;

CREATE TABLE `species`
(
    `species` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `code` VARCHAR(25) NOT NULL,
    `description` VARCHAR(45) NOT NULL,
    PRIMARY KEY (`species`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- users
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users`
(
    `user` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(64) NOT NULL,
    `password` VARCHAR(128) NOT NULL,
    PRIMARY KEY (`user`),
    INDEX `name` (`name`, `password`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
