-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Сен 29 2023 г., 22:19
-- Версия сервера: 8.0.30
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `zoo`
--

-- --------------------------------------------------------

--
-- Структура таблицы `animal_classes`
--

CREATE TABLE `animal_classes` (
  `id` int NOT NULL,
  `name` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `animal_classes`
--

INSERT INTO `animal_classes` (`id`, `name`) VALUES
(2, 'birds'),
(3, 'Insects'),
(1, 'milk');

-- --------------------------------------------------------

--
-- Структура таблицы `animal_genera`
--

CREATE TABLE `animal_genera` (
  `id` int NOT NULL,
  `name` varchar(256) NOT NULL,
  `orderId` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `animal_genera`
--

INSERT INTO `animal_genera` (`id`, `name`, `orderId`) VALUES
(1, 'enoti', 1),
(2, 'sovki', 2),
(3, 'psovye', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `animal_order`
--

CREATE TABLE `animal_order` (
  `id` int NOT NULL,
  `name` varchar(256) NOT NULL,
  `classId` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `animal_order`
--

INSERT INTO `animal_order` (`id`, `name`, `classId`) VALUES
(1, 'xishn', 1),
(2, 'sovoobr', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `animal_species`
--

CREATE TABLE `animal_species` (
  `id` int NOT NULL,
  `name` varchar(256) NOT NULL,
  `genusId` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `animal_species`
--

INSERT INTO `animal_species` (`id`, `name`, `genusId`) VALUES
(1, 'poloskun', 1),
(2, 'splushka', 2),
(3, 'wolfs', 3);

-- --------------------------------------------------------

--
-- Структура таблицы `cages`
--

CREATE TABLE `cages` (
  `id` int NOT NULL,
  `number` int NOT NULL,
  `area` double NOT NULL,
  `hasPool` tinyint(1) NOT NULL,
  `hasStrongerFence` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `cages`
--

INSERT INTO `cages` (`id`, `number`, `area`, `hasPool`, `hasStrongerFence`) VALUES
(1, 1, 20, 1, 0),
(3, 3, 100, 1, 1),
(4, 2, 50, 0, 0),
(5, 4, 200, 1, 1),
(6, 12, 23, 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `dead_pets`
--

CREATE TABLE `dead_pets` (
  `petId` int NOT NULL,
  `deathDate` date NOT NULL,
  `deathCause` varchar(256) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `dead_pets`
--

INSERT INTO `dead_pets` (`petId`, `deathDate`, `deathCause`) VALUES
(1, '2023-09-26', 'for the sake of science'),
(3, '2024-09-14', 'eat too much');

-- --------------------------------------------------------

--
-- Структура таблицы `food`
--

CREATE TABLE `food` (
  `id` int NOT NULL,
  `name` varchar(256) NOT NULL,
  `typeId` int NOT NULL,
  `proteins` double NOT NULL,
  `fats` double NOT NULL,
  `carbs` double NOT NULL,
  `calories` double NOT NULL,
  `currentPricePerKilo` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `foodtypes`
--

CREATE TABLE `foodtypes` (
  `id` int NOT NULL,
  `name` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `foodtypes`
--

INSERT INTO `foodtypes` (`id`, `name`) VALUES
(2, 'fish'),
(4, 'fruits'),
(1, 'meat'),
(3, 'vegetables');

-- --------------------------------------------------------

--
-- Структура таблицы `food_supplies`
--

CREATE TABLE `food_supplies` (
  `foodId` int NOT NULL,
  `foodAmount` double NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `pets`
--

CREATE TABLE `pets` (
  `id` int NOT NULL,
  `name` varchar(256) NOT NULL,
  `isMale` tinyint(1) NOT NULL,
  `birthDate` date NOT NULL,
  `birthPlace` varchar(256) NOT NULL,
  `isAlive` tinyint(1) NOT NULL DEFAULT '1',
  `cageId` int NOT NULL,
  `comment` tinytext,
  `speciesId` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `pets`
--

INSERT INTO `pets` (`id`, `name`, `isMale`, `birthDate`, `birthPlace`, `isAlive`, `cageId`, `comment`, `speciesId`) VALUES
(1, 'Kuki', 1, '2019-09-10', 'Canada', 0, 4, 'very nice dude', 1),
(2, 'Chelsy', 0, '2020-04-24', 'Canada', 1, 4, 'cute and a little shy', 1),
(3, 'Nini', 0, '2022-02-20', 'Siberia', 0, 3, "she doesn\'t always sleep", 2);

-- --------------------------------------------------------

--
-- Структура таблицы `pet_parameters`
--

CREATE TABLE `pet_parameters` (
  `petId` int NOT NULL,
  `weight` double NOT NULL,
  `height` double DEFAULT NULL,
  `length` double DEFAULT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `quarantine`
--

CREATE TABLE `quarantine` (
  `id` int NOT NULL,
  `petId` int NOT NULL,
  `diagnosis` varchar(256) NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `taking_petmeals`
--

CREATE TABLE `taking_petmeals` (
  `petId` int NOT NULL,
  `foodId` int NOT NULL,
  `foodAmount` double NOT NULL,
  `mealDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `animal_classes`
--
ALTER TABLE `animal_classes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `animal_genera`
--
ALTER TABLE `animal_genera`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `orderId` (`orderId`);

--
-- Индексы таблицы `animal_order`
--
ALTER TABLE `animal_order`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `classId` (`classId`);

--
-- Индексы таблицы `animal_species`
--
ALTER TABLE `animal_species`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `genusId` (`genusId`);

--
-- Индексы таблицы `cages`
--
ALTER TABLE `cages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `number` (`number`);

--
-- Индексы таблицы `dead_pets`
--
ALTER TABLE `dead_pets`
  ADD KEY `petId` (`petId`);

--
-- Индексы таблицы `food`
--
ALTER TABLE `food`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `typeId` (`typeId`);

--
-- Индексы таблицы `foodtypes`
--
ALTER TABLE `foodtypes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `food_supplies`
--
ALTER TABLE `food_supplies`
  ADD KEY `foodId` (`foodId`);

--
-- Индексы таблицы `pets`
--
ALTER TABLE `pets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `speciesId` (`speciesId`),
  ADD KEY `cageId` (`cageId`);

--
-- Индексы таблицы `pet_parameters`
--
ALTER TABLE `pet_parameters`
  ADD KEY `petId` (`petId`);

--
-- Индексы таблицы `quarantine`
--
ALTER TABLE `quarantine`
  ADD PRIMARY KEY (`id`),
  ADD KEY `petId` (`petId`);

--
-- Индексы таблицы `taking_petmeals`
--
ALTER TABLE `taking_petmeals`
  ADD KEY `petId` (`petId`),
  ADD KEY `foodId` (`foodId`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `animal_classes`
--
ALTER TABLE `animal_classes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `animal_genera`
--
ALTER TABLE `animal_genera`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `animal_order`
--
ALTER TABLE `animal_order`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `animal_species`
--
ALTER TABLE `animal_species`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `cages`
--
ALTER TABLE `cages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `food`
--
ALTER TABLE `food`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `foodtypes`
--
ALTER TABLE `foodtypes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `pets`
--
ALTER TABLE `pets`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `quarantine`
--
ALTER TABLE `quarantine`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `animal_genera`
--
ALTER TABLE `animal_genera`
  ADD CONSTRAINT `animal_genera_ibfk_1` FOREIGN KEY (`orderId`) REFERENCES `animal_order` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `animal_order`
--
ALTER TABLE `animal_order`
  ADD CONSTRAINT `animal_order_ibfk_1` FOREIGN KEY (`classId`) REFERENCES `animal_classes` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `animal_species`
--
ALTER TABLE `animal_species`
  ADD CONSTRAINT `animal_species_ibfk_1` FOREIGN KEY (`genusId`) REFERENCES `animal_genera` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `dead_pets`
--
ALTER TABLE `dead_pets`
  ADD CONSTRAINT `dead_pets_ibfk_1` FOREIGN KEY (`petId`) REFERENCES `pets` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `food`
--
ALTER TABLE `food`
  ADD CONSTRAINT `food_ibfk_1` FOREIGN KEY (`typeId`) REFERENCES `foodtypes` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `food_supplies`
--
ALTER TABLE `food_supplies`
  ADD CONSTRAINT `food_supplies_ibfk_1` FOREIGN KEY (`foodId`) REFERENCES `food` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `pets`
--
ALTER TABLE `pets`
  ADD CONSTRAINT `pets_ibfk_1` FOREIGN KEY (`speciesId`) REFERENCES `animal_species` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `pets_ibfk_2` FOREIGN KEY (`cageId`) REFERENCES `cages` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `pet_parameters`
--
ALTER TABLE `pet_parameters`
  ADD CONSTRAINT `pet_parameters_ibfk_1` FOREIGN KEY (`petId`) REFERENCES `pets` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `quarantine`
--
ALTER TABLE `quarantine`
  ADD CONSTRAINT `quarantine_ibfk_1` FOREIGN KEY (`petId`) REFERENCES `pets` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `taking_petmeals`
--
ALTER TABLE `taking_petmeals`
  ADD CONSTRAINT `taking_petmeals_ibfk_1` FOREIGN KEY (`petId`) REFERENCES `pets` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `taking_petmeals_ibfk_2` FOREIGN KEY (`foodId`) REFERENCES `food` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
