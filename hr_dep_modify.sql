-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 12 2022 г., 22:16
-- Версия сервера: 8.0.24
-- Версия PHP: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `hr_dep`
--

-- --------------------------------------------------------

--
-- Структура таблицы `anketa`
--

CREATE TABLE `anketa` (
  `id_anketa` int NOT NULL,
  `id_user` int NOT NULL,
  `fam` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `otch` varchar(255) DEFAULT NULL,
  `date_birthday` date NOT NULL,
  `pol` tinyint(1) NOT NULL,
  `mesto_rojdenia` varchar(255) NOT NULL,
  `grajdanstvo` varchar(255) NOT NULL,
  `obrazovanie` varchar(255) NOT NULL,
  `telephone` varchar(255) NOT NULL,
  `id_post` int NOT NULL,
  `resume` text NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `anketa`
--

INSERT INTO `anketa` (`id_anketa`, `id_user`, `fam`, `name`, `otch`, `date_birthday`, `pol`, `mesto_rojdenia`, `grajdanstvo`, `obrazovanie`, `telephone`, `id_post`, `resume`, `status`) VALUES
(2, 1, 'Будько', 'Боня', 'Зырович', '2038-02-26', 1, 'г. Марсианский', 'Марс', 'Перевысшее специальное марсианское', '93244221451', 1, 'Имею навыки убирать камни со африканской глыбы', 'Одобрена'),
(3, 3, 'Петров', 'Петр', 'Джекович', '1982-03-12', 1, 'г. Вологда', 'Россия', 'Неполное высшее', '89999992312', 2, 'Люблю работать с людьми. Целеустремленный, в меру упитанный.', 'Одобрена');

-- --------------------------------------------------------

--
-- Структура таблицы `lich_delo`
--

CREATE TABLE `lich_delo` (
  `id_lichdelo` int NOT NULL,
  `id_sotr` int NOT NULL,
  `id_anketa` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `lich_delo`
--

INSERT INTO `lich_delo` (`id_lichdelo`, `id_sotr`, `id_anketa`) VALUES
(1, 1, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `opisi`
--

CREATE TABLE `opisi` (
  `id_opisi` int NOT NULL,
  `id_sotr` int NOT NULL,
  `date_doc` date NOT NULL,
  `name_doc` varchar(255) NOT NULL,
  `lists_dela` int NOT NULL,
  `primech` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `opisi`
--

INSERT INTO `opisi` (`id_opisi`, `id_sotr`, `date_doc`, `name_doc`, `lists_dela`, `primech`) VALUES
(1, 1, '2022-05-12', 'Аттестат', 2, 'Отсутствует диплом');

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE `posts` (
  `id_post` int NOT NULL,
  `name_post` varchar(255) NOT NULL,
  `cash` int NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`id_post`, `name_post`, `cash`, `active`) VALUES
(1, 'Уборщик', 17000, 0),
(2, 'Сотрудник кадровой службы', 25000, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `prikazi`
--

CREATE TABLE `prikazi` (
  `id_prikaz` int NOT NULL,
  `name_prikaz` varchar(255) NOT NULL,
  `date_prikaz` date NOT NULL,
  `id_sotr` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `prikazi`
--

INSERT INTO `prikazi` (`id_prikaz`, `name_prikaz`, `date_prikaz`, `id_sotr`) VALUES
(1, 'Устройство на работу', '2022-05-12', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `sotr`
--

CREATE TABLE `sotr` (
  `id_sotr` int NOT NULL,
  `id_anketa` int NOT NULL,
  `id_post` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `sotr`
--

INSERT INTO `sotr` (`id_sotr`, `id_anketa`, `id_post`) VALUES
(1, 3, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `login` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `date_reg` datetime NOT NULL,
  `id_post` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id_user`, `login`, `pass`, `date_reg`, `id_post`) VALUES
(1, 'mail@mail.ru', '$2y$10$SI4Xzj8eO363Vd6BQSbSrOdejtzdLGm36TcZaFGcuouLkPZYEszt6', '2022-05-12 04:36:46', NULL),
(3, 'sotr@mail.ru', '$2y$10$F0q2siwJjGTNk7fEIhk.ueEWESVv.5g0.CQMU03i7X2CbiRXft72O', '2022-05-12 17:41:06', 2);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `anketa`
--
ALTER TABLE `anketa`
  ADD PRIMARY KEY (`id_anketa`),
  ADD KEY `id_post` (`id_post`),
  ADD KEY `id_user` (`id_user`);

--
-- Индексы таблицы `lich_delo`
--
ALTER TABLE `lich_delo`
  ADD PRIMARY KEY (`id_lichdelo`),
  ADD KEY `id_sotr` (`id_sotr`),
  ADD KEY `id_anketa` (`id_anketa`);

--
-- Индексы таблицы `opisi`
--
ALTER TABLE `opisi`
  ADD PRIMARY KEY (`id_opisi`),
  ADD KEY `id_sotr` (`id_sotr`);

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id_post`);

--
-- Индексы таблицы `prikazi`
--
ALTER TABLE `prikazi`
  ADD PRIMARY KEY (`id_prikaz`),
  ADD KEY `id_sotr` (`id_sotr`);

--
-- Индексы таблицы `sotr`
--
ALTER TABLE `sotr`
  ADD PRIMARY KEY (`id_sotr`),
  ADD KEY `id_anketa` (`id_anketa`),
  ADD KEY `id_post` (`id_post`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `login` (`login`),
  ADD KEY `id_post` (`id_post`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `anketa`
--
ALTER TABLE `anketa`
  MODIFY `id_anketa` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `lich_delo`
--
ALTER TABLE `lich_delo`
  MODIFY `id_lichdelo` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `opisi`
--
ALTER TABLE `opisi`
  MODIFY `id_opisi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `id_post` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `prikazi`
--
ALTER TABLE `prikazi`
  MODIFY `id_prikaz` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `sotr`
--
ALTER TABLE `sotr`
  MODIFY `id_sotr` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `anketa`
--
ALTER TABLE `anketa`
  ADD CONSTRAINT `anketa_ibfk_1` FOREIGN KEY (`id_post`) REFERENCES `posts` (`id_post`),
  ADD CONSTRAINT `anketa_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Ограничения внешнего ключа таблицы `lich_delo`
--
ALTER TABLE `lich_delo`
  ADD CONSTRAINT `lich_delo_ibfk_1` FOREIGN KEY (`id_sotr`) REFERENCES `sotr` (`id_sotr`),
  ADD CONSTRAINT `lich_delo_ibfk_2` FOREIGN KEY (`id_anketa`) REFERENCES `anketa` (`id_anketa`);

--
-- Ограничения внешнего ключа таблицы `opisi`
--
ALTER TABLE `opisi`
  ADD CONSTRAINT `opisi_ibfk_1` FOREIGN KEY (`id_sotr`) REFERENCES `sotr` (`id_sotr`);

--
-- Ограничения внешнего ключа таблицы `prikazi`
--
ALTER TABLE `prikazi`
  ADD CONSTRAINT `prikazi_ibfk_1` FOREIGN KEY (`id_sotr`) REFERENCES `sotr` (`id_sotr`);

--
-- Ограничения внешнего ключа таблицы `sotr`
--
ALTER TABLE `sotr`
  ADD CONSTRAINT `sotr_ibfk_1` FOREIGN KEY (`id_anketa`) REFERENCES `anketa` (`id_anketa`),
  ADD CONSTRAINT `sotr_ibfk_2` FOREIGN KEY (`id_post`) REFERENCES `posts` (`id_post`);

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_post`) REFERENCES `posts` (`id_post`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
