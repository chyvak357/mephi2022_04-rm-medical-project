-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Ноя 03 2022 г., 17:20
-- Версия сервера: 10.4.24-MariaDB
-- Версия PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `hospital`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cabinet`
--

CREATE TABLE `cabinet` (
  `id` int(11) NOT NULL,
  `number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cabinet`
--

INSERT INTO `cabinet` (`id`, `number`) VALUES
(5, 11),
(1, 102),
(2, 103),
(3, 111),
(4, 1111),
(6, 312312);

-- --------------------------------------------------------

--
-- Структура таблицы `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `fathers_name` varchar(45) DEFAULT NULL,
  `phone_numb` varchar(11) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `active` int(1) NOT NULL DEFAULT 1,
  `employment_date` date DEFAULT NULL,
  `cabinet_id` int(11) DEFAULT NULL,
  `doc_rang` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `doctors`
--

INSERT INTO `doctors` (`id`, `name`, `last_name`, `fathers_name`, `phone_numb`, `password`, `active`, `employment_date`, `cabinet_id`, `doc_rang`) VALUES
(2, 'Вячеслав', 'Зубарев', 'Иванович', '88005553535', '21232f297a57a5a743894a0e4a801fc3', 1, '2022-10-15', 6, 'Участковый');

-- --------------------------------------------------------

--
-- Структура таблицы `health_insurance`
--

CREATE TABLE `health_insurance` (
  `id` int(11) NOT NULL,
  `num_insurance` varchar(16) DEFAULT NULL,
  `company` varchar(70) DEFAULT NULL,
  `date of issue` date DEFAULT NULL,
  `shelf_life` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `health_insurance`
--

INSERT INTO `health_insurance` (`id`, `num_insurance`, `company`, `date of issue`, `shelf_life`) VALUES
(1, '1233211233211231', 'Газпром страхование', '2022-10-06', 4),
(3, '3214325436547658', 'Согаз Мед', '2022-10-02', 1),
(4, '0', 'Нет сведений', '2022-10-16', 0),
(5, '123321123321', 'ываыв', '4333-04-23', 123),
(6, '1232131232132132', 'выывмывсы', '1231-03-12', 3);

-- --------------------------------------------------------

--
-- Структура таблицы `management`
--

CREATE TABLE `management` (
  `id` int(11) NOT NULL,
  `login` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `position` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `management`
--

INSERT INTO `management` (`id`, `login`, `password`, `position`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'главный тут');

-- --------------------------------------------------------

--
-- Структура таблицы `med_card`
--

CREATE TABLE `med_card` (
  `id` int(11) NOT NULL,
  `illness` varchar(500) DEFAULT NULL,
  `num_visits` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `med_card`
--

INSERT INTO `med_card` (`id`, `illness`, `num_visits`) VALUES
(1, '', 0),
(2, '', 0),
(3, '', 0),
(4, '', 0),
(5, '', 1221),
(6, 'нет ываыв аыва ыва ыва ыав ыва выа ', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `fathers_name` varchar(45) DEFAULT NULL,
  `phone_numb` varchar(11) DEFAULT NULL,
  `location` varchar(80) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `last_visit` date DEFAULT NULL,
  `med_card_id` int(11) DEFAULT NULL,
  `health_insurance_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `patients`
--

INSERT INTO `patients` (`id`, `name`, `last_name`, `fathers_name`, `phone_numb`, `location`, `birthday`, `last_visit`, `med_card_id`, `health_insurance_id`) VALUES
(1, 'Роман', 'Мясников', 'Сергеевич', '89654410839', 'Россия, Москва, Пролетарский пр-т 8к2', '2000-02-28', '0000-00-00', 1, 1),
(3, 'Алексей', 'Мясникян', 'АЛЕКСЕЕВИЧ', '88005553534', '0000-00-00', '0000-00-00', '0000-00-00', 3, 3),
(4, 'Нет сведений', 'Нет сведений', 'Нет сведений', '00000000000', 'БОМЖ', '2000-01-01', '2022-10-16', 4, 4),
(5, 'кек', 'лол', 'Кекович', '31231231231', 'ываываыва', '0000-00-00', '0042-03-22', 5, 5),
(6, 'Иван', 'Иванов', 'Иванович', '88005553535', 'ывавыаыва', '2000-02-28', '0000-00-00', 6, 6);

-- --------------------------------------------------------

--
-- Структура таблицы `registration_coupon`
--

CREATE TABLE `registration_coupon` (
  `id` int(11) NOT NULL,
  `num_coupon` int(11) DEFAULT NULL,
  `reg_date` date DEFAULT NULL,
  `doctors_id` int(11) DEFAULT NULL,
  `doctors_schedule_id` int(11) DEFAULT NULL,
  `patients_id` int(11) DEFAULT NULL,
  `patients_med_card_id` int(11) DEFAULT NULL,
  `patients_health_insurance_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cabinet`
--
ALTER TABLE `cabinet`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `number_UNIQUE` (`number`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Индексы таблицы `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD UNIQUE KEY `phone_numb_UNIQUE` (`phone_numb`),
  ADD KEY `id_idx` (`cabinet_id`);

--
-- Индексы таблицы `health_insurance`
--
ALTER TABLE `health_insurance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Индексы таблицы `management`
--
ALTER TABLE `management`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login_UNIQUE` (`login`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Индексы таблицы `med_card`
--
ALTER TABLE `med_card`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Индексы таблицы `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD UNIQUE KEY `phone_numb_UNIQUE` (`phone_numb`),
  ADD KEY `health_insurance_fk_idx` (`health_insurance_id`),
  ADD KEY `med_card_fk_idx` (`med_card_id`);

--
-- Индексы таблицы `registration_coupon`
--
ALTER TABLE `registration_coupon`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `id_idx` (`doctors_id`),
  ADD KEY `id_idx1` (`patients_id`),
  ADD KEY `id_idx2` (`patients_med_card_id`),
  ADD KEY `id_idx3` (`patients_health_insurance_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `health_insurance`
--
ALTER TABLE `health_insurance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `management`
--
ALTER TABLE `management`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `med_card`
--
ALTER TABLE `med_card`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `registration_coupon`
--
ALTER TABLE `registration_coupon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `cabinet_fk` FOREIGN KEY (`cabinet_id`) REFERENCES `cabinet` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `registration_coupon`
--
ALTER TABLE `registration_coupon`
  ADD CONSTRAINT `doctors_fk` FOREIGN KEY (`doctors_id`) REFERENCES `doctors` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `health_insurance_fk` FOREIGN KEY (`patients_health_insurance_id`) REFERENCES `health_insurance` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `med_card_fk` FOREIGN KEY (`patients_med_card_id`) REFERENCES `med_card` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `patients_fk` FOREIGN KEY (`patients_id`) REFERENCES `patients` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
