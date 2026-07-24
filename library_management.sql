-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 22, 2026 at 08:00 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12


CREATE DATABASE IF NOT EXISTS library_management;
USE library_management;
--
-- Database: `library_management`
--

-- --------------------------------------------------------

--
DROP TABLE IF EXISTS admins;
DROP TABLE IF EXISTS books;
DROP TABLE IF EXISTS transactions;
Drop Table IF EXISTS users;
-- Table structure for table `admin`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admins` (`admin_id`, `username`, `password`) VALUES
(1, 'admin1', 'admin123'),
(2, 'admin2', 'admin456');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `author` varchar(100) NOT NULL,
  `isbn` varchar(20) NOT NULL,
  `quantity` int(11) NOT NULL CHECK (`quantity` >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `title`, `author`, `isbn`, `quantity`) VALUES
(201, 'Database System Concepts', 'Abraham Silberschatz', '9780073523323', 5),
(202, 'Clean Code', 'Robert C. Martin', '9780132350884', 4),
(203, 'Introduction to Algorithms', 'Thomas H. Cormen', '9780262033848', 6),
(204, 'Operating System Concepts', 'Abraham Silberschatz', '9781118063330', 3),
(205, 'Computer Networks', 'Andrew S. Tanenbaum', '9780132126953', 2),
(206, 'Artificial Intelligence', 'Stuart Russell', '9780136042594', 5),
(207, 'Java The Complete Reference', 'Herbert Schildt', '9781260440232', 4),
(208, 'Python Crash Course', 'Eric Matthes', '9781593279288', 8),
(209, 'Computer Organization', 'Carl Hamacher', '9780073380650', 3),
(210, 'The C Programming Language', 'Dennis Ritchie', '9780131103627', 5),
(211, 'Discrete Mathematics', 'Kenneth Rosen', '9780073383095', 4),
(212, 'Software Engineering', 'Ian Sommerville', '9780137035151', 5),
(213, 'Data Structures', 'Seymour Lipschutz', '9780070701984', 7),
(214, 'Web Technologies', 'Jeffrey C. Jackson', '9780131856035', 6),
(215, 'Machine Learning', 'Tom Mitchell', '9780070428072', 3);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `borrow_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `status` varchar(20) NOT NULL
) ;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `user_id`, `book_id`, `borrow_date`, `return_date`, `status`) VALUES
(1001, 101, 201, '2026-07-01', '2026-07-08', 'Returned'),
(1002, 102, 202, '2026-07-02', NULL, 'Borrowed'),
(1003, 103, 203, '2026-07-03', '2026-07-10', 'Returned'),
(1004, 104, 204, '2026-07-04', NULL, 'Borrowed'),
(1005, 105, 205, '2026-07-05', '2026-07-12', 'Returned'),
(1006, 106, 206, '2026-07-06', NULL, 'Borrowed'),
(1007, 107, 207, '2026-07-07', '2026-07-14', 'Returned'),
(1008, 108, 208, '2026-07-08', NULL, 'Borrowed'),
(1009, 109, 209, '2026-07-09', '2026-07-16', 'Returned'),
(1010, 110, 210, '2026-07-10', NULL, 'Borrowed'),
(1011, 101, 211, '2026-07-11', NULL, 'Borrowed'),
(1012, 102, 212, '2026-07-12', '2026-07-19', 'Returned'),
(1013, 103, 213, '2026-07-13', NULL, 'Borrowed'),
(1014, 104, 214, '2026-07-14', '2026-07-21', 'Returned'),
(1015, 105, 215, '2026-07-15', NULL, 'Borrowed');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `phone`) VALUES
(101, 'Rahim Ahmed', 'rahim@gmail.com', 'rahim123', '01711111111'),
(102, 'Karim Hasan', 'karim@gmail.com', 'karim123', '01722222222'),
(103, 'Nusrat Jahan', 'nusrat@gmail.com', 'nusrat123', '01733333333'),
(104, 'Tanvir Islam', 'tanvir@gmail.com', 'tanvir123', '01744444444'),
(105, 'Mim Akter', 'mim@gmail.com', 'mim123', '01755555555'),
(106, 'Sakib Hossain', 'sakib@gmail.com', 'sakib123', '01766666666'),
(107, 'Farhan Islam', 'farhan@gmail.com', 'farhan123', '01777777777'),
(108, 'Jannatul Ferdous', 'jannat@gmail.com', 'jannat123', '01788888888'),
(109, 'Arif Khan', 'arif@gmail.com', 'arif123', '01799999999'),
(110, 'Nabila Islam', 'nabila@gmail.com', 'nabila123', '01811111111');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`),
  ADD UNIQUE KEY `isbn` (`isbn`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`);
COMMIT;


