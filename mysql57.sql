-- --------------------------------------------------------
-- Host:                         homestead
-- Server version:               5.7.19-0ubuntu0.16.04.1 - (Ubuntu)
-- Server OS:                    Linux
-- HeidiSQL Version:             10.1.0.5464
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS = 0 */;
/*!40101 SET @OLD_SQL_MODE = @@SQL_MODE, SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for korus
/*DROP DATABASE IF EXISTS `korus`;*/
CREATE DATABASE IF NOT EXISTS `korus` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `korus`;

-- Dumping structure for table korus.timesheet
DROP TABLE IF EXISTS `timesheet`;
CREATE TABLE IF NOT EXISTS `timesheet`
(
    `EployeeId` bigint(20) unsigned DEFAULT NULL COMMENT 'users.id',
    `Time`      time                DEFAULT NULL COMMENT 'time',
    `Date`      date                DEFAULT NULL COMMENT 'date',
    KEY `FK_timesheet_users` (`EployeeId`),
    CONSTRAINT `FK_timesheet_users` FOREIGN KEY (`EployeeId`) REFERENCES `users` (`Id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

-- Dumping data for table korus.timesheet: ~4 rows (approximately)
DELETE
FROM `timesheet`;
/*!40000 ALTER TABLE `timesheet`
    DISABLE KEYS */;
INSERT INTO `timesheet` (`EployeeId`, `Time`, `Date`)
VALUES (3, '02:00:00', '2017-02-10'),
       (1, '05:00:00', '2017-02-15'),
       (2, '01:00:00', '2017-02-12'),
       (3, '04:30:00', '2017-02-12'),
       (4, '03:00:00', '2018-02-15');
/*!40000 ALTER TABLE `timesheet`
    ENABLE KEYS */;

-- Data exporting was unselected.
-- Dumping structure for table korus.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users`
(
    `Id`         bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `Name`       varchar(50)         NOT NULL DEFAULT '0' COMMENT 'user''s name',
    `Email`      varchar(150)        NOT NULL DEFAULT '0' COMMENT 'user''s email',
    `EmployerId` bigint(20) unsigned          DEFAULT NULL COMMENT 'users.id ',
    `Info`       text,
    PRIMARY KEY (`Id`),
    KEY `EmployerId` (`EmployerId`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 7
  DEFAULT CHARSET = utf8 COMMENT ='table of users';

-- Dumping data for table korus.users: ~6 rows (approximately)
DELETE
FROM `users`;
/*!40000 ALTER TABLE `users`
    DISABLE KEYS */;
INSERT INTO `users` (`Id`, `Name`, `Email`, `EmployerId`, `Info`)
VALUES (1, 'Иван', 'ivan@mail.ru', NULL, 'Произвольный текст'),
       (2, 'Петр', 'peter@mail.', 1, 'текст'),
       (3, 'Константин', 'contantine@mail.ru', NULL, 'текст'),
       (4, 'Алевтина', 'alevtina@русскоязычныйдомен.рф', 2, 'текст'),
       (5, 'Инокентий', 'kesha@yandex.ru', 3, 'текст'),
       (6, 'Яна', 'yana@gmail.com', 1, 'текст');
/*!40000 ALTER TABLE `users`
    ENABLE KEYS */;

-- Data exporting was unselected.
/*!40101 SET SQL_MODE = IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS = IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;

DROP PROCEDURE IF EXISTS userlvl;
DELIMITER $$
CREATE PROCEDURE userlvl(IN user_id INT, OUT path TEXT)
BEGIN
    DECLARE lvlname VARCHAR(20);
    DECLARE temppath TEXT;
    DECLARE tempparent INT;
    SET max_sp_recursion_depth = 255;
    SELECT id, EmployerId FROM users WHERE id = user_id INTO lvlname, tempparent;
    IF tempparent IS NULL
    THEN
        SET path = lvlname;
    ELSE
        CALL userlvl(tempparent, temppath);
        SET path = CONCAT(temppath, '/', lvlname);
    END IF;
END$$
DELIMITER ;

DROP FUNCTION IF EXISTS userlvl;
DELIMITER $$
CREATE FUNCTION userlvl(cat_id INT) RETURNS TEXT DETERMINISTIC
BEGIN
    DECLARE res TEXT;
    CALL userlvl(cat_id, res);
    RETURN res;
END$$
DELIMITER ;