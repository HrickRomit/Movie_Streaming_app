-- SQL file for creating all tables

-- Watch history per user per movie
CREATE TABLE IF NOT EXISTS `watch_history` (
	`UserID` INT NOT NULL,
	`MovieID` INT NOT NULL,
	`watched_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`times_watched` INT NOT NULL DEFAULT 1,
	`last_position_seconds` INT NOT NULL DEFAULT 0,
	PRIMARY KEY (`UserID`, `MovieID`),
	KEY `idx_wh_user_time` (`UserID`, `watched_at`),
	CONSTRAINT `fk_wh_user` FOREIGN KEY (`UserID`) REFERENCES `User`(`UserID`) ON DELETE CASCADE,
	CONSTRAINT `fk_wh_movie` FOREIGN KEY (`MovieID`) REFERENCES `movies`(`MovieID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

