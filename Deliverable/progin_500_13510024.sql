-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 01, 2013 at 03:58 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `progin_405_13510032`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignee`
--

CREATE TABLE IF NOT EXISTS `assignee` (
  `username` varchar(20) NOT NULL,
  `id_task` int(11) NOT NULL,
  UNIQUE KEY `username` (`username`,`id_task`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assignee`
--

INSERT INTO `assignee` (`username`, `id_task`) VALUES
('', 0),
('akunih', 23),
('akunih', 26),
('akunih', 29),
('akunih', 33),
('akunih', 35),
('akunih', 36),
('akunih', 46),
('akunih', 51),
('apaajadeh', 25),
('apaajadeh', 26),
('apaajadeh', 29),
('apaajadeh', 32),
('ArieDoank', 16),
('ArieDoank', 21),
('ArieDoank', 23),
('ArieDoank', 24),
('ArieDoank', 25),
('ArieDoank', 28),
('ArieDoank', 32),
('ArieDoank', 33),
('ArieDoank', 35),
('ArieDoank', 40),
('ArieDoank', 46),
('ArieDoank', 51),
('EndyDoank', 23),
('EndyDoank', 37),
('EndyDoank', 38),
('EndyDoank', 39),
('EndyDoank', 47),
('sesuatu', 24),
('sesuatu', 38),
('sesuatu', 40),
('StefanDoank', 17),
('StefanDoank', 24),
('StefanDoank', 36),
('StefanDoank', 40),
('StefanDoank', 47),
('StefanDoank', 48),
('StefanDoank', 49),
('timojelek', 26),
('timojelek', 27),
('timojelek', 29);

-- --------------------------------------------------------

--
-- Table structure for table `attachment`
--

CREATE TABLE IF NOT EXISTS `attachment` (
  `id_attachment` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(100) NOT NULL,
  PRIMARY KEY (`id_attachment`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=71 ;

--
-- Dumping data for table `attachment`
--

INSERT INTO `attachment` (`id_attachment`, `path`) VALUES
(1, 'img/foto_anonim.png'),
(2, 'img/Arie.jpg'),
(3, 'img/Attachment1.txt'),
(4, 'img/Attachment2.txt'),
(5, 'img/Video.mp4'),
(22, 'att/att11.jpg'),
(28, 'att/att01.jpg'),
(29, 'att/att12.jpg'),
(30, 'att/att23.jpg'),
(31, 'att/att02.jpg'),
(32, 'att/att03.jpg'),
(33, 'att/att01.jpg'),
(34, 'att/att01.jpg'),
(35, 'att/att01.jpg'),
(36, 'att/att02.jpg'),
(37, 'att/att0Jadwal Asisten RPL.xlsx'),
(38, 'att/att0Jadwal Asisten RPL.xlsx'),
(39, 'att/att03.jpg'),
(40, 'att/att01.jpg'),
(41, 'att/att12.jpg'),
(42, 'att/att23.jpg'),
(43, 'att/att03.jpg'),
(44, 'att/att01.jpg'),
(45, 'att/att12.jpg'),
(46, 'att/att23.jpg'),
(47, 'att/att02.jpg'),
(48, 'att/att03.jpg'),
(49, 'att/att01.jpg'),
(50, 'att/att03.jpg'),
(51, 'att/att0dl.txt'),
(52, 'att/att0'),
(53, 'uploaded/individu_imk (endy).docx'),
(54, 'uploaded/Jadwal Asisten RPL.xlsx'),
(55, 'uploaded/jadwal_asisten_rpl.xlsx'),
(56, 'uploaded/AvengersRPL.txt'),
(57, 'uploaded/bbm voice.jpeg'),
(58, 'uploaded/catatan.txt'),
(59, 'uploaded/AvengersRPL.txt'),
(60, 'uploaded/catatan.txt'),
(61, 'uploaded/DB.java'),
(62, 'uploaded/dl.txt'),
(63, 'uploaded/Mini.MP3'),
(64, 'uploaded/Arie.jpg'),
(65, 'uploaded/arie.avi'),
(66, 'uploaded/Lagu_Supporter_HMIF.htm'),
(67, 'uploaded/Desert.jpg'),
(68, 'att/att03.jpg'),
(69, 'att/att02.jpg'),
(70, 'att/att02.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id_cat` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id_cat`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id_cat`, `name`) VALUES
(1, 'Cheating'),
(2, 'Offensive Weapon'),
(3, 'Harmful Drugs'),
(4, 'Conspiracy'),
(5, 'Robbery'),
(6, 'Drunken'),
(7, 'Forcible Rape'),
(8, 'Murder'),
(9, 'Poisoning'),
(10, 'Hacking'),
(14, 'stefansesuatu');

-- --------------------------------------------------------

--
-- Table structure for table `categorycreator`
--

CREATE TABLE IF NOT EXISTS `categorycreator` (
  `username` varchar(20) NOT NULL,
  `id_cat` int(11) NOT NULL,
  UNIQUE KEY `username` (`username`,`id_cat`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categorycreator`
--

INSERT INTO `categorycreator` (`username`, `id_cat`) VALUES
('ArieDoank', 3),
('ArieDoank', 6),
('ArieDoank', 9),
('ArieDoank', 13),
('ArieDoank', 14),
('EndyDoank', 1),
('EndyDoank', 4),
('EndyDoank', 7),
('EndyDoank', 10),
('StefanDoank', 2),
('StefanDoank', 5),
('StefanDoank', 8),
('timojelek', 11);

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id_comment` int(11) NOT NULL AUTO_INCREMENT,
  `id_task` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `time` varchar(20) NOT NULL,
  `content` varchar(140) NOT NULL,
  PRIMARY KEY (`id_comment`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id_comment`, `id_task`, `username`, `time`, `content`) VALUES
(7, 1, '', '9 : 26 - 23/3', 'Nyohohohohoh'),
(8, 1, '', '9 : 27 - 23/3', 'aaa'),
(12, 1, 'null', '21:44', 'aaa'),
(13, 1, 'null', '21:45', 'ggffg'),
(16, 21, 'ArieDoank', '22:0', 'aaax'),
(17, 21, 'ArieDoank', '22:0', 'asdf'),
(18, 21, 'ArieDoank', '22:11', ''),
(19, 48, 'StefanDoank', '4:52', 'aaaaa'),
(20, 48, 'StefanDoank', '4:53', 'aaaaaaa'),
(21, 48, 'StefanDoank', '4:53', 'aaaaaaabb'),
(22, 51, 'ArieDoank', '3 : 26 - 29/4', 'a'),
(23, 51, 'ArieDoank', '3 : 27 - 29/4', 'a'),
(24, 25, 'ArieDoank', '-6 : 38 - 1/5', 'a');

-- --------------------------------------------------------

--
-- Table structure for table `joincategory`
--

CREATE TABLE IF NOT EXISTS `joincategory` (
  `id_cat` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  UNIQUE KEY `id_cat` (`id_cat`,`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `joincategory`
--

INSERT INTO `joincategory` (`id_cat`, `username`) VALUES
(0, 'sesuatu'),
(0, 'StefanDoank'),
(1, 'EndyDoank'),
(1, 'sesuatu'),
(2, 'EndyDoank'),
(2, 'StefanDoank'),
(3, 'akunih'),
(3, 'apaajadeh'),
(3, 'ArieDoank'),
(3, 'EndyDoank'),
(3, 'StefanDoank'),
(6, 'akunih'),
(6, 'apaajadeh'),
(6, 'ArieDoank'),
(6, 'EndyDoank'),
(6, 'sesuatu'),
(6, 'StefanDoank'),
(6, 'timo onjoe'),
(10, 'apaajadeh'),
(10, 'EndyDoank'),
(10, 'StefanDoank'),
(11, 'akunih'),
(11, 'apaajadeh'),
(11, 'EndyDoank'),
(11, 'timojelek'),
(13, 'ArieDoank'),
(13, 'timojelek,EndyDoank'),
(14, 'akunih'),
(14, 'ArieDoank'),
(14, 'StefanDoank');

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE IF NOT EXISTS `tag` (
  `id_tag` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL,
  PRIMARY KEY (`id_tag`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=55 ;

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`id_tag`, `name`) VALUES
(53, ''),
(52, ' idola'),
(51, '123'),
(43, 'ab'),
(30, 'abc'),
(44, 'ac'),
(50, 'acde'),
(45, 'ad'),
(46, 'ae'),
(41, 'aja'),
(40, 'apa'),
(54, 'apayaa'),
(25, 'arie'),
(39, 'asasa'),
(48, 'b'),
(38, 'banget'),
(42, 'boleh'),
(33, 'bunuh'),
(49, 'c'),
(31, 'def'),
(24, 'endi'),
(32, 'ghi'),
(35, 'idola'),
(2, 'male'),
(37, 'sesuatu'),
(34, 'stefan'),
(1, 'student'),
(26, 'tes1'),
(27, 'tes2'),
(28, 'tes3'),
(3, 'unyu'),
(36, 'wanita');

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE IF NOT EXISTS `task` (
  `id_task` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `deadline` varchar(20) NOT NULL,
  `id_cat` int(11) NOT NULL,
  `pemilik` varchar(20) NOT NULL,
  KEY `id_task` (`id_task`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52 ;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`id_task`, `name`, `status`, `deadline`, `id_cat`, `pemilik`) VALUES
(20, 'tugas3', 0, '2013-03-14', 3, 'ArieDoank'),
(21, 'tugas4', 1, '2013-04-09', 3, 'ArieDoank'),
(23, 'BunuhStefan', 1, '2013-04-17', 6, 'ArieDoank'),
(24, 'testugas', 1, '2013-04-18', 6, 'ArieDoank'),
(25, 'tugasku', 0, '2013-04-11', 6, 'ArieDoank'),
(26, 'tesdeh', 0, '2013-04-10', 11, 'timojelek'),
(29, 'tesupload', 0, '2013-04-17', 11, 'timojelek'),
(32, 'task11', 0, '2013-04-17', 6, 'ArieDoank'),
(33, 'tugas12', 0, '2013-04-18', 6, 'ArieDoank'),
(35, 'taasasa', 0, '2013-04-11', 3, 'ArieDoank'),
(36, 'assdasa', 0, '2013-04-10', 6, 'StefanDoank'),
(37, 'tes1234', 0, '2013-04-10', 1, 'EndyDoank'),
(38, 'GantungStefan', 0, '2013-04-05', 1, 'EndyDoank'),
(39, 'tesada', 0, '2013-04-11', 1, 'EndyDoank'),
(40, 'killstefan', 0, '2013-04-11', 0, 'ArieDoank'),
(46, 'tesaja', 0, '2013-04-04', 14, 'ArieDoank'),
(47, 'GergajiStefan', 0, '2013-04-11', 2, 'StefanDoank'),
(48, 'tusukstefan', 0, '2013-04-10', 3, 'StefanDoank'),
(49, 'SetrikaStefan', 0, '2013-04-10', 2, 'StefanDoank'),
(50, '', 0, '', 3, 'ArieDoank'),
(51, 'GantungRIo', 0, '2013-04-11', 3, 'ArieDoank');

-- --------------------------------------------------------

--
-- Table structure for table `taskattachment`
--

CREATE TABLE IF NOT EXISTS `taskattachment` (
  `id_task` int(11) NOT NULL,
  `id_attachment` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `taskattachment`
--

INSERT INTO `taskattachment` (`id_task`, `id_attachment`) VALUES
(17, 31),
(21, 28),
(23, 37),
(24, 37),
(25, 32),
(26, 28),
(26, 29),
(26, 30),
(29, 32),
(32, 32),
(33, 28),
(35, 51),
(36, 52),
(38, 0),
(38, 0),
(39, 0),
(39, 0),
(39, 0),
(40, 0),
(40, 0),
(46, 68),
(47, 64),
(48, 65),
(48, 66),
(49, 67),
(51, 32),
(0, 31),
(0, 31);

-- --------------------------------------------------------

--
-- Table structure for table `taskcreator`
--

CREATE TABLE IF NOT EXISTS `taskcreator` (
  `id_taskcreator` int(11) NOT NULL AUTO_INCREMENT,
  `id_task` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  PRIMARY KEY (`id_taskcreator`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=59 ;

--
-- Dumping data for table `taskcreator`
--

INSERT INTO `taskcreator` (`id_taskcreator`, `id_task`, `username`) VALUES
(1, 1, 'EndyDoank'),
(2, 2, 'StefanDoank'),
(3, 3, 'ArieDoank'),
(22, 14, 'ArieDoank'),
(23, 15, 'ArieDoank'),
(24, 16, 'ArieDoank'),
(26, 18, 'ArieDoank'),
(27, 19, 'ArieDoank'),
(28, 19, 'ArieDoank'),
(29, 21, 'ArieDoank'),
(30, 22, 'ArieDoank'),
(31, 23, 'ArieDoank'),
(32, 24, 'ArieDoank'),
(33, 25, 'ArieDoank'),
(34, 26, 'timojelek'),
(35, 27, 'timojelek'),
(36, 27, 'timojelek'),
(37, 29, 'timojelek'),
(38, 30, 'ArieDoank'),
(39, 31, 'ArieDoank'),
(40, 32, 'ArieDoank'),
(41, 33, 'ArieDoank'),
(42, 34, 'ArieDoank'),
(43, 35, 'ArieDoank'),
(44, 36, 'StefanDoank'),
(45, 38, 'EndyDoank'),
(46, 39, 'EndyDoank'),
(47, 40, 'ArieDoank'),
(48, 41, 'ArieDoank'),
(49, 42, 'ArieDoank'),
(50, 43, 'ArieDoank'),
(51, 44, 'ArieDoank'),
(52, 45, 'ArieDoank'),
(53, 46, 'ArieDoank'),
(54, 47, 'StefanDoank'),
(55, 48, 'StefanDoank'),
(56, 49, 'StefanDoank'),
(57, 28, 'ArieDoank'),
(58, 51, 'ArieDoank');

-- --------------------------------------------------------

--
-- Table structure for table `tasktag`
--

CREATE TABLE IF NOT EXISTS `tasktag` (
  `id_task` int(11) NOT NULL,
  `id_tag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tasktag`
--

INSERT INTO `tasktag` (`id_task`, `id_tag`) VALUES
(16, 23),
(17, 24),
(17, 25),
(23, 33),
(23, 34),
(23, 35),
(23, 36),
(24, 37),
(24, 38),
(26, 26),
(26, 27),
(26, 28),
(27, 29),
(27, 29),
(29, 26),
(29, 27),
(29, 28),
(32, 47),
(32, 48),
(32, 49),
(33, 39),
(35, 26),
(35, 27),
(35, 28),
(39, 0),
(40, 0),
(40, 0),
(46, 30),
(46, 31),
(47, 52),
(47, 50),
(36, 1),
(36, 2),
(36, 3),
(36, 51),
(21, 53),
(21, 43),
(49, 34),
(28, 53),
(51, 54),
(0, 53),
(25, 39),
(25, 43),
(25, 53);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `username` varchar(20) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `avatar` varchar(100) NOT NULL,
  `birthday` varchar(20) NOT NULL,
  `email` varchar(35) NOT NULL,
  `password` varchar(20) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `fullname`, `avatar`, `birthday`, `email`, `password`) VALUES
('akunih', 'aku ini', 'img/akunih1.jpg', '2013-03-05', 'aku@ni.co', '12345123'),
('apaajadeh', 'apa aja', 'img/apaajadeh2.jpg', '2013-03-06', 'apa@aja.com', '12345123'),
('ArieDoank', 'Nicholas Imba', 'uploaded/Koala.jpg', '2013-06-12', '13510018@std.stei.itb.ac.id', '12345123'),
('EndyDoank', 'Nugroho Satrijandi', 'img/Endy.jpg', '2013-03-15', 'nugroho.satrijandi@gmail.com', 'nugroho123'),
('EndyDoankAja', 'Endy Doank Aja', 'uploaded/Arie.jpg', '2013-04-10', 'endy@doank.aja', '12345123'),
('Pusing', 'Banget De', '7216236-lg.jpg', '2013-04-19', 'pusing@banget.deh', '12345123'),
('sesuatu', 'sesuatu banget', 'img/sesuatu3.jpg', '2013-03-12', 'sesuatu@co.id', '12345123'),
('StefanDoank', 'Stefan Lauren GIla', 'img/StefanDoankavatar2.jpg', '1992-03-19', 'stefan.lauren@yahoo.com', 'stefan123'),
('timo onjoe', 'timoasa ajsajs', 'img/timo onjoeArie.jpg', '2013-04-18', 'timo@other.com', 'asdasdas'),
('timojelek', 'Timotius Kevin Leviathan', 'img/timojelek2.jpg', '2013-04-11', 'timo@apa.com', '12345123');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
