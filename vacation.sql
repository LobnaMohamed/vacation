-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 11, 2017 at 02:39 PM
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
(2, 'مؤقت'),
(3, 'مكافأة شاملة'),
(4, 'إعارة');

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
(1, 'اجهزة المعاونة'),
(2, 'التكنولوجيا و التطوير و الدراسات'),
(3, 'تخطيط الانتاج'),
(4, 'الهندسية'),
(5, 'الزيوت و الخلط و التعبئة'),
(6, 'الوحدات المساعدة و صب الشموع'),
(7, 'المالية'),
(8, 'الأمن'),
(9, 'التقطير التفريغى وانتاج السولار'),
(10, 'التسويق و المبيعات'),
(11, 'الامانة العامة لمجلس الادارة'),
(12, 'الاعلام و الاتصالات الخارجية'),
(13, 'الصيانة'),
(14, 'الهندسة المدنية'),
(15, 'المعامل الكيماوية'),
(16, 'السلامة والصحة المهنية وحماية البيئة'),
(17, 'الاستثمار'),
(18, 'المرافق و التسهيلات'),
(19, 'الهندسة الكهربائية'),
(20, 'الإدارية'),
(21, 'الطبية'),
(22, 'المهمات'),
(23, 'متابعة انشطة التشغيل و تاكيد الجودة'),
(24, 'المكتب الفنى لرئيس مجلس الادارة و العضو المنتدب'),
(25, 'هندسة التحكم الالى'),
(26, 'التنظيم و تخطيط الموارد البشرية'),
(27, 'التدريب و تنمية الموارد البشرية'),
(28, 'الشئون القانونية'),
(29, 'مساعد رئيس الشركة للهندسة الكهربائية و التحكم الالى');

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
(1, 'رئيس مجلس الإدارة والعضو المنتدب'),
(2, 'مساعد رئيس الشركة'),
(3, 'مدير عام'),
(4, 'مدير إدارة'),
(5, 'مدير عام مساعد'),
(6, 'مدير إدارة بإدارة'),
(7, 'رئيس قسم'),
(8, 'ملاحظ ماهر'),
(9, 'مشرف أمن متقدم'),
(10, 'سباك متقدم'),
(11, 'ملاحظ'),
(12, 'رئيس قسم بقسم'),
(13, 'سباك'),
(14, 'نجار'),
(15, 'مشرف خدمات ادارية متقدم'),
(16, 'جلاب عينات متقدم'),
(17, 'مشرف تعبئة متقدم'),
(18, 'فنى صيانة ماهر'),
(19, 'مراقب ماهر '),
(20, 'مشرف خدمات ادارية'),
(21, 'ادارى ماهر'),
(22, 'مراقب امن صناعى ماهر'),
(23, 'فنى قيادة ونش شوكة ماهر'),
(24, 'فنى قيادة سيارات ماهر'),
(25, 'فنى اجهزة الكترونية ماهر'),
(26, 'أخصائى'),
(27, 'فنى كهرباء ماهر'),
(28, 'محلل كيميائى ماهر'),
(29, 'مراقب ترحيلات ماهر'),
(30, 'أخصائى أول'),
(31, 'مراقب مخازن ماهر'),
(32, 'مشرف أمن'),
(33, 'فنى ماهر'),
(34, 'جلاب عينات'),
(35, 'مشرف تعبئة'),
(36, 'رئيس عمال'),
(37, 'محلل كيميائى'),
(38, 'فنى قيادة سيارات'),
(39, 'فنى صيانة'),
(40, 'ادارى'),
(41, 'فنى تمريض ماهر'),
(42, 'مراقب تكرير'),
(43, 'فنى تمريض'),
(44, 'فنى اختبارات'),
(45, 'مهندس ممتاز'),
(46, 'مراقب مخازن'),
(47, 'فنى قيادة ونش شوكة'),
(48, 'أخصائى ممتاز'),
(49, 'مراقب ترحيلات'),
(50, 'محاسب ممتاز'),
(51, 'محاسب أول'),
(52, 'كيميائى ممتاز'),
(53, 'فنى كهرباء'),
(54, 'مساعد فنى'),
(55, 'مساعد مراقب تكرير'),
(56, 'حرفى'),
(57, 'مساعد محلل'),
(58, 'فنى اجهزة الكترونية'),
(59, 'مساعد فنى قيادة سيارات'),
(60, 'تكنولوجى ممتاز'),
(61, 'كيميائى أول'),
(62, 'مساعد ادارى'),
(63, 'مهندس أول'),
(64, 'صيدلى أول'),
(65, 'مراجع أول'),
(66, 'عامل خدمات'),
(67, 'مساعد مراقب'),
(68, 'تكنولوجى أول'),
(69, 'محامى أول'),
(70, 'كيميائى'),
(71, 'ممرض'),
(72, 'مختبر'),
(73, 'كاتب'),
(74, 'مشغل معدات اطفاء'),
(75, 'عامل صيانة'),
(76, 'مشغل اجهزة'),
(77, 'مساعد رسام انشائى'),
(78, 'مندوب مشتريات'),
(79, 'امين مخزن'),
(80, 'مهندس'),
(81, 'محاسب'),
(82, 'عامل خدمات معملية'),
(83, 'كهربائى'),
(84, 'مشغل اجهزة الكترونية'),
(85, 'عامل صيانة و انشاءات'),
(86, 'سائق ونش'),
(87, 'مراجع'),
(88, 'تكنولوجى'),
(89, 'طبيب'),
(90, 'طبيب اسنان ممتاز'),
(91, 'سكرتير');

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
(2, 'الاول'),
(3, 'الثانى'),
(4, 'الثالث');

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `managements`
--
ALTER TABLE `managements`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
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
  MODIFY `ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_day_n`
--
ALTER TABLE `t_day_n`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `t_job`
--
ALTER TABLE `t_job`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;
--
-- AUTO_INCREMENT for table `t_level`
--
ALTER TABLE `t_level`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `t_transe`
--
ALTER TABLE `t_transe`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
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
