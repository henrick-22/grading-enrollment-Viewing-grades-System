-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2024 at 07:51 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `itc127 -2024`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblaccounts`
--

CREATE TABLE `tblaccounts` (
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `usertype` varchar(20) NOT NULL,
  `userstatus` varchar(20) NOT NULL,
  `createdby` varchar(50) NOT NULL,
  `datecreated` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblaccounts`
--

INSERT INTO `tblaccounts` (`username`, `password`, `usertype`, `userstatus`, `createdby`, `datecreated`, `email`) VALUES
('123456', '123456', 'STUDENT', 'ACTIVE', 'admin', '05/04/2024', ''),
('18-00487', '123456', 'STUDENT', 'ACTIVE', 'admin', '2024-05-23', ''),
('20-00719', '1234', 'STUDENT', 'ACTIVE', 'admin', '05/04/2024', ''),
('321313', 'dasdsa', 'STUDENT', 'ACTIVE', 'admin', '2024-05-23', ''),
('admin', 'admin', 'ADMINISTRATOR', 'ACTIVE', 'user1', '05/04/2024', ''),
('adsasdadsda', 'dsasadsada', 'STUDENT', 'ACTIVE', 'admin', '2024-05-23', ''),
('michelle', 'sdadsa', 'STUDENT', 'ACTIVE', 'admin', '2024-05-23', ''),
('registrar', 'registrar', 'REGISTRAR', 'ACTIVE', 'admin', '2024-03-16', ''),
('staff', '123456', 'REGISTRAR', 'ACTIVE', 'admin', '2024-03-16', ''),
('student1', '123456', 'STUDENT', 'ACTIVE', 'admin', '2024/04/07', '');

-- --------------------------------------------------------

--
-- Table structure for table `tblgrades`
--

CREATE TABLE `tblgrades` (
  `studentnumber` varchar(20) NOT NULL,
  `code` varchar(20) NOT NULL,
  `grade` varchar(20) NOT NULL,
  `createdby` varchar(15) NOT NULL,
  `datecreated` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblgrades`
--

INSERT INTO `tblgrades` (`studentnumber`, `code`, `grade`, `createdby`, `datecreated`) VALUES
('20-00719', 'CS420', '1.75', 'admin', '05/04/2024'),
('20-00719', 'CS421', '1.50', 'admin', '05/04/2024'),
('20-00719', 'CS422', '2.00', 'admin', '05/04/2024'),
('20-00719', 'SC135', '1.25', 'admin', '05/23/2024'),
('20-88198', 'CS420', '1.50', 'admin', '05/04/2024'),
('20-88198', 'CS421', '2.00', 'admin', '05/04/2024');

-- --------------------------------------------------------

--
-- Table structure for table `tbllogs`
--

CREATE TABLE `tbllogs` (
  `datelog` varchar(50) NOT NULL,
  `timelog` varchar(50) NOT NULL,
  `action` varchar(50) NOT NULL,
  `module` varchar(50) NOT NULL,
  `ID` varchar(255) NOT NULL,
  `performedby` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbllogs`
--

INSERT INTO `tbllogs` (`datelog`, `timelog`, `action`, `module`, `ID`, `performedby`) VALUES
('05/22/2024', '04:27:26', 'Update', 'Accounts Management', '123456', 'admin'),
('05/23/2024', '12:00:23', 'Create', 'Accounts Management', 'asdadas', 'admin'),
('05/23/2024', '12:27:20', 'Create', 'Accounts Management', 'michelle', 'admin'),
('2024-05-23', '00:29:10', 'Create', 'Accounts Management', 'michelle', 'admin'),
('05/23/2024', '01:07:07', 'Add', 'Grades Management', '20-00719', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tblstudents`
--

CREATE TABLE `tblstudents` (
  `studentnumber` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `firstname` varchar(20) NOT NULL,
  `middlename` varchar(20) NOT NULL,
  `course` varchar(20) NOT NULL,
  `yearlevel` varchar(20) NOT NULL,
  `createdby` varchar(20) NOT NULL,
  `datecreated` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblstudents`
--

INSERT INTO `tblstudents` (`studentnumber`, `password`, `lastname`, `firstname`, `middlename`, `course`, `yearlevel`, `createdby`, `datecreated`) VALUES
('18-00487', '123456', 'romena', 'John henrick', 'R', 'BSCS', '4', 'admin', '2024-05-23'),
('20-00719', '123456', 'Valdez', 'Arje ', 'T', 'BSCS', '4', 'admin', '05/03/2024'),
('3123132', 'saddsadsadsa', 'dadddas', 'dsaada', 'd', 'BHSPH', '1', 'admin', '05/23/2024'),
('321313', 'dasdsa', 'sadadsd', 'adsa', 'sdads', 'BARCH', '2', 'admin', '2024-05-23'),
('adsasdadsda', 'dsasadsada', 'sdasds', 'asddasdsasa', 'asdasdsaddsa', 'BARCH', '2', 'admin', '2024-05-23');

-- --------------------------------------------------------

--
-- Table structure for table `tblsubjects`
--

CREATE TABLE `tblsubjects` (
  `code` varchar(50) NOT NULL,
  `description` varchar(50) NOT NULL,
  `unit` varchar(20) NOT NULL,
  `course` varchar(50) NOT NULL,
  `prerequisite1` varchar(50) NOT NULL,
  `prerequisite2` varchar(50) NOT NULL,
  `prerequisite3` varchar(50) NOT NULL,
  `createdby` varchar(50) NOT NULL,
  `datecreated` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblsubjects`
--

INSERT INTO `tblsubjects` (`code`, `description`, `unit`, `course`, `prerequisite1`, `prerequisite2`, `prerequisite3`, `createdby`, `datecreated`) VALUES
('CS420', 'Information Assurance ', '3', 'BSCS', '', '', '', 'admin', '05/03/2024'),
('CS421', 'Thesis 2', '3', 'BSCS', '', '', '', 'admin', '05/03/2024'),
('CS422', 'HCI Lec and Lab', '4', 'BSCS', 'CS421', '', '', 'admin', '05/03/2024'),
('CS423 ', 'Elective 4', '2', 'BSCS', 'CS422', 'CS421', '', 'admin', '05/03/2024'),
('ITC127', 'Computer Programming 3', '2', 'BSCS', '', '', '', 'admin', '05/04/2024'),
('SC135', 'Understanding Self', '3', 'BSCS', '', '', '', 'admin', '05/04/2024');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblaccounts`
--
ALTER TABLE `tblaccounts`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `tblgrades`
--
ALTER TABLE `tblgrades`
  ADD PRIMARY KEY (`studentnumber`,`code`);

--
-- Indexes for table `tblstudents`
--
ALTER TABLE `tblstudents`
  ADD PRIMARY KEY (`studentnumber`,`password`);

--
-- Indexes for table `tblsubjects`
--
ALTER TABLE `tblsubjects`
  ADD PRIMARY KEY (`code`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
