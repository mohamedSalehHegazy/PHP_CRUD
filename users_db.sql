SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+02:00";

--
-- Database: `users_db`
--

-- --------------------------------------------------------

--
-- Table structure for tables
--

CREATE TABLE `users` (
  `id` int(12) NOT NULL,
  `name` varchar(65) NOT NULL,
  `email` varchar(65) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `files` (
  `id` int(12) NOT NULL,
  `UserId` int(12) NOT NULL,
  `file_name` varchar(65) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for tables
--
INSERT INTO `users` (`id`, `name`, `email`) VALUES
(1, 'Mohamed', 'mohamed@m.com'),
(2, 'Saleh', 'saleh@s.com');

INSERT INTO `files` (`id`, `UserId`, `file_name`) VALUES
(1, 1, 'mohamed_file'),
(2, 2, 'saleh_file');

--
-- Indexes for tables
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);
--
-- AUTO_INCREMENT for tables
--
ALTER TABLE `users`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;COMMIT;

ALTER TABLE `files`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;COMMIT;

ALTER TABLE `files`
  ADD FOREIGN KEY (UserId) REFERENCES users(id)
  ON DELETE CASCADE
  ON UPDATE CASCADE;