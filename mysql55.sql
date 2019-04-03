-- Хост: localhost:3306
-- Время создания: Апр 01 2019 г., 13:37
-- Версия сервера: 5.5.62-0ubuntu0.14.04.1
-- Версия PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `korus`
--

DELIMITER $$
--
-- Процедуры
--
DROP PROCEDURE IF EXISTS `userlvl`$$
CREATE DEFINER=`korus`@`localhost` PROCEDURE `userlvl` (IN `user_id` INT, OUT `path` TEXT)  BEGIN
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

--
-- Функции
--
DROP FUNCTION IF EXISTS `userlvl`$$
CREATE DEFINER=`korus`@`localhost` FUNCTION `userlvl` (`cat_id` INT) RETURNS TEXT CHARSET utf8 BEGIN
    DECLARE res TEXT;
    CALL userlvl(cat_id, res);
    RETURN res;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `timesheet`
--

DROP TABLE IF EXISTS `timesheet`;
CREATE TABLE IF NOT EXISTS `timesheet` (
  `EployeeId` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'users.id',
  `Time` time DEFAULT NULL COMMENT 'time',
  `Date` date DEFAULT NULL COMMENT 'date',
  KEY `FK_timesheet_users` (`EployeeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `timesheet`
--

INSERT INTO `timesheet` (`EployeeId`, `Time`, `Date`) VALUES
(3, '02:00:00', '2017-02-10'),
(1, '05:00:00', '2017-02-15'),
(2, '01:00:00', '2017-02-12'),
(3, '04:30:00', '2017-02-12'),
(4, '03:00:00', '2018-02-15');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `Id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL DEFAULT '0' COMMENT 'user''s name',
  `Email` varchar(150) NOT NULL DEFAULT '0' COMMENT 'user''s email',
  `EmployerId` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'users.id ',
  `Info` text,
  PRIMARY KEY (`Id`),
  KEY `EmployerId` (`EmployerId`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='table of users';

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`Id`, `Name`, `Email`, `EmployerId`, `Info`) VALUES
(1, 'Иван', 'ivan@mail.ru', NULL, 'Произвольный текст'),
(2, 'Петр', 'peter@mail.', 1, 'текст'),
(3, 'Константин', 'contantine@mail.ru', NULL, 'текст'),
(4, 'Алевтина', 'alevtina@русскоязычныйдомен.рф', 2, 'текст'),
(5, 'Инокентий', 'kesha@yandex.ru', 3, 'текст'),
(6, 'Яна', 'yana@gmail.com', 1, 'текст');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
