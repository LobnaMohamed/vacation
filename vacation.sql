-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 27, 2017 at 02:57 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vacation`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetActiveType` ()  BEGIN
   SELECT *  FROM t_active;
   END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `contract`
--

CREATE TABLE `contract` (
  `ID` int(11) NOT NULL,
  `contractType` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contract`
--

INSERT INTO `contract` (`ID`, `contractType`) VALUES
(1, 'دائم'),
(2, 'مؤقت');

-- --------------------------------------------------------

--
-- Stand-in structure for view `empdata`
-- (See below for the actual view)
--
CREATE TABLE `empdata` (
`ID` int(11) unsigned
,`emp_code` int(10)
,`emp_name` varchar(150)
,`desc_job` varchar(200)
,`management` varchar(200)
,`activeStatus` varchar(15)
,`shift` varchar(20)
,`g_management` varchar(200)
,`job` varchar(250)
,`level` varchar(100)
,`contract` varchar(150)
);

-- --------------------------------------------------------

--
-- Table structure for table `managements`
--

CREATE TABLE `managements` (
  `ID` int(11) NOT NULL,
  `Management` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `managements`
--

INSERT INTO `managements` (`ID`, `Management`) VALUES
(1, 'IT'),
(2, 'ISO');

-- --------------------------------------------------------

--
-- Table structure for table `t_active`
--

CREATE TABLE `t_active` (
  `ID` int(11) NOT NULL,
  `active` varchar(15) NOT NULL COMMENT 'active employee or not'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_active`
--

INSERT INTO `t_active` (`ID`, `active`) VALUES
(1, 'بالخدمة'),
(2, 'خارج الخدمة');

-- --------------------------------------------------------

--
-- Table structure for table `t_case`
--

CREATE TABLE `t_case` (
  `ID` int(2) UNSIGNED NOT NULL,
  `case_desc` varchar(25) NOT NULL COMMENT 'type of vacation',
  `az` int(11) DEFAULT NULL COMMENT 'order of vacation'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_case`
--

INSERT INTO `t_case` (`ID`, `case_desc`, `az`) VALUES
(1, 'annual', 0),
(2, 'sick leave', 0);

-- --------------------------------------------------------

--
-- Table structure for table `t_data`
--

CREATE TABLE `t_data` (
  `ID` int(11) UNSIGNED NOT NULL,
  `emp_code` int(10) NOT NULL,
  `emp_name` varchar(150) NOT NULL,
  `contract_type` int(11) NOT NULL,
  `id_job` int(11) NOT NULL COMMENT 'job name',
  `desc_job` varchar(200) NOT NULL COMMENT 'current job',
  `level_id` int(11) NOT NULL,
  `management` varchar(200) NOT NULL,
  `g_management_id` int(11) NOT NULL,
  `day_night` int(11) NOT NULL,
  `active` int(11) NOT NULL,
  `Password` varchar(255) NOT NULL DEFAULT '1234567',
  `id_userGroup` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_data`
--

INSERT INTO `t_data` (`ID`, `emp_code`, `emp_name`, `contract_type`, `id_job`, `desc_job`, `level_id`, `management`, `g_management_id`, `day_night`, `active`, `Password`, `id_userGroup`) VALUES
(2, 1455, ' لبنى  محمد  محمود  متولى سالم', 1, 1, 'مهندسة', 1, 'اقطاع الحاسب الالى', 1, 1, 1, '20eabe5d64b0e216796e834f52d61fd0b70332fc', 4),
(3, 1152, 'walid', 1, 1, '', 1, 'IT', 1, 1, 1, '20eabe5d64b0e216796e834f52d61fd0b70332fc', 2),
(4, 167, 'moh abdelftah', 1, 1, 'eng', 1, 'IT', 1, 1, 1, '20eabe5d64b0e216796e834f52d61fd0b70332fc', 1),
(5, 1111, 'استحقاقات', 1, 1, 'قفاقفا', 1, 'استحقاقات', 2, 1, 1, '20eabe5d64b0e216796e834f52d61fd0b70332fc', 3),
(8, 248, 'wael nabil', 1, 1, 'trial', 1, 'IT', 2, 1, 1, '20eabe5d64b0e216796e834f52d61fd0b70332fc', 1),
(13, 8888, 'test', 1, 1, 'eng', 2, 'IT', 1, 2, 2, '20eabe5d64b0e216796e834f52d61fd0b70332fc', 4);

-- --------------------------------------------------------

--
-- Table structure for table `t_day_n`
--

CREATE TABLE `t_day_n` (
  `ID` int(11) NOT NULL,
  `day_n` varchar(20) NOT NULL COMMENT 'shift day or night'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_day_n`
--

INSERT INTO `t_day_n` (`ID`, `day_n`) VALUES
(1, 'نهارى'),
(2, 'ورادى');

-- --------------------------------------------------------

--
-- Table structure for table `t_job`
--

CREATE TABLE `t_job` (
  `ID` int(11) NOT NULL,
  `Job` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_job`
--

INSERT INTO `t_job` (`ID`, `Job`) VALUES
(1, 'engineer');

-- --------------------------------------------------------

--
-- Table structure for table `t_level`
--

CREATE TABLE `t_level` (
  `ID` int(11) NOT NULL,
  `level` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_level`
--

INSERT INTO `t_level` (`ID`, `level`) VALUES
(1, 'ادارة عليا'),
(2, 'الاول');

-- --------------------------------------------------------

--
-- Table structure for table `t_transe`
--

CREATE TABLE `t_transe` (
  `ID` int(11) NOT NULL,
  `emp_id` int(11) UNSIGNED DEFAULT NULL,
  `Mang_id` int(11) DEFAULT NULL,
  `trans_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_case` int(11) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `duration` float NOT NULL,
  `address` varchar(100) NOT NULL DEFAULT 'بالملف',
  `Manager_agree` int(2) DEFAULT '3',
  `topManager_agree` int(2) DEFAULT '3',
  `AdminConfirm` int(2) DEFAULT '3',
  `manager_id` int(11) UNSIGNED DEFAULT NULL,
  `top_manager_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_transe`
--

INSERT INTO `t_transe` (`ID`, `emp_id`, `Mang_id`, `trans_date`, `id_case`, `start_date`, `end_date`, `duration`, `address`, `Manager_agree`, `topManager_agree`, `AdminConfirm`, `manager_id`, `top_manager_id`) VALUES
(23, 2, 1, '2017-08-09 11:19:35', 1, '2017-08-01', '2017-08-02', 1, 'بالملف', 1, 1, 1, 4, 4),
(24, 2, 2, '2017-08-17 11:32:44', 2, '2017-08-03', '2017-08-12', 9, 'بالملف', 1, 2, 2, 3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `user_group`
--

CREATE TABLE `user_group` (
  `ID` int(11) NOT NULL,
  `userGroup` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_group`
--

INSERT INTO `user_group` (`ID`, `userGroup`) VALUES
(1, 'مدير مباشر'),
(2, 'مدير أعلى'),
(3, 'موظف استحقاقات'),
(4, 'موظف');

-- --------------------------------------------------------

--
-- Table structure for table `vac_status`
--

CREATE TABLE `vac_status` (
  `ID` int(11) NOT NULL,
  `status` char(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vac_status`
--

INSERT INTO `vac_status` (`ID`, `status`) VALUES
(1, 'موافقة'),
(2, 'رفض'),
(3, 'معلق');

-- --------------------------------------------------------

--
-- Structure for view `empdata`
--
DROP TABLE IF EXISTS `empdata`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `empdata`  AS  select `d`.`ID` AS `ID`,`d`.`emp_code` AS `emp_code`,`d`.`emp_name` AS `emp_name`,`d`.`desc_job` AS `desc_job`,`d`.`management` AS `management`,`a`.`active` AS `activeStatus`,`dn`.`day_n` AS `shift`,`m`.`Management` AS `g_management`,`j`.`Job` AS `job`,`l`.`level` AS `level`,`c`.`contractType` AS `contract` from ((((((`t_data` `d` left join `t_active` `a` on((`d`.`active` = `a`.`ID`))) left join `t_day_n` `dn` on((`d`.`day_night` = `dn`.`ID`))) left join `managements` `m` on((`d`.`g_management_id` = `m`.`ID`))) left join `t_job` `j` on((`d`.`id_job` = `j`.`ID`))) left join `t_level` `l` on((`d`.`level_id` = `l`.`ID`))) left join `contract` `c` on((`d`.`contract_type` = `c`.`ID`))) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contract`
--
ALTER TABLE `contract`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `managements`
--
ALTER TABLE `managements`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `t_active`
--
ALTER TABLE `t_active`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `t_case`
--
ALTER TABLE `t_case`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `t_data`
--
ALTER TABLE `t_data`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `emp_code` (`emp_code`),
  ADD KEY `FK_shift` (`day_night`),
  ADD KEY `FK_active` (`active`),
  ADD KEY `FK_UserGroup` (`id_userGroup`),
  ADD KEY `FK_GManagement` (`g_management_id`),
  ADD KEY `FK_job` (`id_job`),
  ADD KEY `FK_Level` (`level_id`);

--
-- Indexes for table `t_day_n`
--
ALTER TABLE `t_day_n`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `t_job`
--
ALTER TABLE `t_job`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `t_level`
--
ALTER TABLE `t_level`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `t_transe`
--
ALTER TABLE `t_transe`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_case` (`id_case`),
  ADD KEY `FK_manager` (`manager_id`),
  ADD KEY `FK_topManager` (`top_manager_id`),
  ADD KEY `FK_topManagerAgree` (`topManager_agree`),
  ADD KEY `FK_adminConfirm` (`AdminConfirm`),
  ADD KEY `FK_empID` (`emp_id`),
  ADD KEY `FK_managID` (`Mang_id`),
  ADD KEY `FK_ManagerAgree` (`Manager_agree`);

--
-- Indexes for table `user_group`
--
ALTER TABLE `user_group`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `vac_status`
--
ALTER TABLE `vac_status`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contract`
--
ALTER TABLE `contract`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `managements`
--
ALTER TABLE `managements`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `t_active`
--
ALTER TABLE `t_active`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `t_case`
--
ALTER TABLE `t_case`
  MODIFY `ID` int(2) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `t_data`
--
ALTER TABLE `t_data`
  MODIFY `ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `t_day_n`
--
ALTER TABLE `t_day_n`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `t_job`
--
ALTER TABLE `t_job`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `t_level`
--
ALTER TABLE `t_level`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `t_transe`
--
ALTER TABLE `t_transe`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `user_group`
--
ALTER TABLE `user_group`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `vac_status`
--
ALTER TABLE `vac_status`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `t_data`
--
ALTER TABLE `t_data`
  ADD CONSTRAINT `FK_GManagement` FOREIGN KEY (`g_management_id`) REFERENCES `managements` (`ID`),
  ADD CONSTRAINT `FK_Level` FOREIGN KEY (`level_id`) REFERENCES `t_level` (`ID`),
  ADD CONSTRAINT `FK_UserGroup` FOREIGN KEY (`id_userGroup`) REFERENCES `user_group` (`ID`),
  ADD CONSTRAINT `FK_active` FOREIGN KEY (`active`) REFERENCES `t_active` (`ID`),
  ADD CONSTRAINT `FK_job` FOREIGN KEY (`id_job`) REFERENCES `t_job` (`ID`),
  ADD CONSTRAINT `FK_shift` FOREIGN KEY (`day_night`) REFERENCES `t_day_n` (`ID`) ON UPDATE CASCADE;

--
-- Constraints for table `t_transe`
--
ALTER TABLE `t_transe`
  ADD CONSTRAINT `FK_ManagerAgree` FOREIGN KEY (`Manager_agree`) REFERENCES `vac_status` (`ID`),
  ADD CONSTRAINT `FK_adminConfirm` FOREIGN KEY (`AdminConfirm`) REFERENCES `vac_status` (`ID`),
  ADD CONSTRAINT `FK_case` FOREIGN KEY (`id_case`) REFERENCES `t_case` (`ID`),
  ADD CONSTRAINT `FK_empID` FOREIGN KEY (`emp_id`) REFERENCES `t_data` (`ID`),
  ADD CONSTRAINT `FK_managID` FOREIGN KEY (`Mang_id`) REFERENCES `managements` (`ID`),
  ADD CONSTRAINT `FK_manager` FOREIGN KEY (`manager_id`) REFERENCES `t_data` (`ID`),
  ADD CONSTRAINT `FK_topManager` FOREIGN KEY (`top_manager_id`) REFERENCES `t_data` (`ID`),
  ADD CONSTRAINT `FK_topManagerAgree` FOREIGN KEY (`topManager_agree`) REFERENCES `vac_status` (`ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
