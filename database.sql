-- Create the database
CREATE DATABASE IF NOT EXISTS `online-voting-system`;
USE `online-voting-system`;

-- Create the user table
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `role` int(11) NOT NULL COMMENT '1=Voter, 2=Group/Candidate',
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0=Not Voted, 1=Voted',
  `votes` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mobile` (`mobile`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create uploads directory (Note: You need to create this folder manually in your project root)
