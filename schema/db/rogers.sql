-- phpMyAdmin SQL Dump
-- version 3.1.2deb1ubuntu0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 27, 2010 at 03:16 PM
-- Server version: 5.0.75
-- PHP Version: 5.2.6-3ubuntu4.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `lean_cuisine`
--

-- --------------------------------------------------------

--
-- Table structure for table `prizematrix`
--

CREATE TABLE IF NOT EXISTS `prizematrix` (
  `idprizematrix` int(10) unsigned NOT NULL auto_increment,
  `day` int(10) unsigned NOT NULL,
  `prize` varchar(255) default NULL,
  `num_votes` int(10) unsigned NOT NULL,
  `num_r_votes` int(11) unsigned NOT NULL,
  `num_l_votes` int(11) unsigned NOT NULL,
  `val` float default NULL,
  `thresh_1` float default NULL,
  `thresh_2` float default NULL,
  `thresh_3` float default NULL,
  `thresh_4` float default NULL,
  `question` varchar(255) NOT NULL,
  `l_choice` varchar(255) NOT NULL,
  `r_choice` varchar(255) NOT NULL,
  `current_thresh` int(10) unsigned NOT NULL default '1',
  `youtube_id` varchar(32) default NULL,
  `prize_desc` longtext,
  PRIMARY KEY  (`idprizematrix`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `prizematrix`
--

INSERT INTO `prizematrix` (`idprizematrix`, `day`, `prize`, `num_votes`, `num_r_votes`, `num_l_votes`, `val`, `thresh_1`, `thresh_2`, `thresh_3`, `thresh_4`, `question`, `l_choice`, `r_choice`, `current_thresh`, `youtube_id`, `prize_desc`) VALUES
(1, 1, '$25 Cash', 989, 44, 945, 25, 25, 75, 200, 500, 'What would you eat UNLIMITED amounts of?', 'Mac N Cheese', 'Instant Noodles', 4, 'VHHmPlBwMh8', 'Will you spend $25 on Mac N Cheese and Instant Noodles? Or do you spoil yourself and get something a little more expensive?'),
(2, 2, 'The Game of Life Board Game', 146, 98, 48, 50, 50, 150, 400, 1000, 'What did you use UNLIMITEDLY at recess?', 'Yo-Yo', 'Skip Rope', 2, 'jrMzywOiR1Y', 'Life is full of surprises. One day you’re voting on an awesome showdown and then all of a sudden you’re sitting around a table enjoying an exciting journey through life.'),
(3, 3, 'Motorola FLIP OUT', 351, 249, 102, 600, 600, 1800, 4800, 12000, 'if ARCHIE had the Rogers Unlimited Student Plan who should he put on his Unlimited My5 calling?', 'Betty', 'Veronica', 3, 'kYNRWESkJl4', 'Tap out messages at a rapid-fire pace with this compact Smartphone that’s small enough to pocket easily, yet powerful enough to gather your social networks in one place. '),
(4, 4, 'Bruce Lee &amp; Chuck Norris Movies ', 738, 336, 402, 50, 50, 150, 400, 1000, 'Who kicks UNLIMITED ass?', 'Chuck Norris', 'Bruce Lee', 4, 'uI9q8zYBoqc', 'We’re turning your embarrassing DVD collection into roundhouse kick of awesomeness by joining together some of the toughest movies ever created.'),
(5, 5, 'Sony Xperia X10 Mini ', 1011, 61, 950, 600, 600, 1800, 4800, 12000, 'If the sky''s the limit, what''s more AWESOME in it?', 'Thunder', 'Lightning', 1, '-f5vMHc_Jv8', 'Reach any app you like through the four corners of your home screen with the smallest android phone in the world. '),
(6, 6, 'Blackberry 9300 ', 1139, 199, 940, 600, 600, 1800, 4800, 12000, 'What UNLIMITED Student Plan feature will you use unlimitedly?', 'Social Networking', 'Picture and Video', 1, 'G8-L1FSwMX8', 'The next big thing in the Blackberry Curve Smartphone family comes loaded with features that include BBM™, GPS, Wi-Fi® and 3G network support. '),
(7, 7, 'Pins for Free Songs from urMusic ', 1059, 119, 940, 0, 0, 0, 0, 0, 'Who rocks your UNLIMITED world?', 'Eminem', 'Kanye', 1, 'fX0L3R4jFUs', 'Fill your personal jukebox with the hottest tracks from urMusic.ca '),
(8, 8, 'Blackberry 8520', 1022, 80, 942, 600, 600, 1800, 4800, 12000, 'Which team would you UNLIMITEDLY text?', 'Team Jacob', 'Team Edward', 1, '-epOBXkjLFk', 'The hottest Blackberry around offers dedicated media keys, an easy track pad navigation, media sharing, Wi-Fi and more. '),
(9, 9, 'Pirate &amp; Ninja Halloween costumes', 1028, 88, 940, 50, 50, 150, 400, 1000, 'UNLIMITED life at sea or in the Shadows? ', 'Ninja', 'Pirate', 1, 'W1D-eCAoK4c', NULL),
(10, 10, '$50 Cash for school supplies', 947, 7, 940, 50, 50, 150, 400, 1000, 'What is your tool of choice during exam time?', 'Pencil', 'Pen', 1, 'UqLnRyPAGJg', 'What is your tool of choice during exam time?'),
(11, 11, 'Sony Xperia X10', 1087, 147, 940, 700, 700, 2100, 5600, 14000, 'What phone goes better with the UNLIMITED Student Plan?', 'Xperia X10', 'Blackberry Bold', 1, '8p6kXD94Bd4', 'The world’s premiere social networking phone puts everyone you know one touch away. '),
(12, 12, '$15 Off at Wireless Box Office', 1073, 133, 940, 15, 15, 45, 120, 300, 'Where''s the most AWESOME place to watch live music?', 'Big Arenas', 'Small Venues', 1, '6pqdV_Lsoko', 'Get concert tickets delivered instantly to your phone! Today we’re hooking you up with a PIN for $15 Off at Wireless Box Office. '),
(13, 13, 'Saved by the Bell DVDs', 949, 9, 940, 60, 60, 180, 480, 1200, 'Who had more UNLIMITED game at Bayside?', 'Zack Morris', 'AC Slater', 1, 'JvWSohrPK0Q', 'Time-Out! Relive all the great years at Bayside over and over again. '),
(14, 14, 'Mullet Wig', 1104, 164, 940, 25, 25, 75, 200, 500, 'When spring break comes around is it…', 'Unlimited Business', 'Unlimited Party', 1, 'd-M8Yw7-Waw', 'Satisfy your curiosity of how a mullet looks and feels on you. Who knows it might inspire you to grow a real one.  ');

-- --------------------------------------------------------

--
-- Table structure for table `registered`
--

CREATE TABLE IF NOT EXISTS `registered` (
  `idregistered` int(11) NOT NULL auto_increment,
  `fb_uid` bigint(20) unsigned default NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `voted` varchar(255) NOT NULL,
  `allow_promo` int(1) unsigned default NULL,
  PRIMARY KEY  (`idregistered`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `registered`
--

INSERT INTO `registered` (`idregistered`, `fb_uid`, `fname`, `lname`, `email`, `phone`, `ts`, `voted`, `allow_promo`) VALUES
(1, 100001449890980, 'x', 'y', 'z', '', '2010-08-26 17:14:46', '', 0),
(2, 874335003, 'fname', 'lname', 'example@example.com', '', '2010-08-26 17:38:50', '', 1),
(3, 0, 'fname', 'lname', 'example@example.com', '', '2010-08-27 13:30:30', ',8,8,8,8,8,8,8,8,1,1,8,5,4,2,9', 1),
(4, 723238725, 'asdf', 'asdf', 'asdf@asdf.com', '', '2010-08-26 19:08:36', '', 0),
(5, 646836969, 'james', 'dead', 'jeremy@netmobs.com', '', '2010-08-27 11:17:39', '', 0),
(6, 646836969, 'james', 'dead', 'jeremy@netmobs.com', '', '2010-08-27 11:19:06', '', 0),
(7, 646836969, 'james', 'dead', 'jeremy@netmobs.com', '', '2010-08-27 11:19:33', '', 0),
(8, 0, 'james', 'dead', 'jeremy@netmobs.com', '', '2010-08-27 13:30:30', ',9', 0),
(12, 669745467, 'Logan', 'Aube', 'logan@bnotions.ca', '', '2010-08-27 15:13:32', '', 0),
(13, 0, 'Logan', 'Aube', 'logan@bnotions.ca', '', '2010-08-27 15:13:41', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `threshholds`
--

CREATE TABLE IF NOT EXISTS `threshholds` (
  `idthresholds` int(10) unsigned NOT NULL,
  `threshold` int(10) unsigned NOT NULL,
  `prizes` int(10) unsigned NOT NULL,
  `votes` int(10) unsigned NOT NULL,
  `odds` float default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `threshholds`
--

INSERT INTO `threshholds` (`idthresholds`, `threshold`, `prizes`, `votes`, `odds`) VALUES
(0, 1, 1, 299, 0.0033),
(0, 2, 3, 749, 0.004),
(0, 3, 8, 1749, 0.0045),
(0, 4, 20, 3999, 0.005);
