CREATE TABLE IF NOT EXISTS `order_details` (
  `RefId` bigint(50) NOT NULL AUTO_INCREMENT,
  `BranchRefId` int(10) default null,
  `EmployeesRefId` int(10) default null,
  `OrderRefId` int(10) default null,
  `DonutRefId` int(10) default null,
  `Quantity` int(10) default null,
  `Total` int(10) default null,
  `Remarks` varchar(300) DEFAULT null,
  `LastUpdateDate` date DEFAULT NULL,
  `LastUpdateTime` time DEFAULT NULL,
  `LastUpdateBy` varchar(50) DEFAULT NULL,
  `Data` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`RefId`),
  UNIQUE KEY `RefId` (`RefId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0;

CREATE TABLE IF NOT EXISTS `order` (
  `RefId` bigint(50) NOT NULL AUTO_INCREMENT,
  `BranchRefId` int(10) default null,
  `EmployeesRefId` int(10) default null,
  `OrderDate` date default null,
  `OrderTime` varchar(255) default null,
  `Remarks` varchar(300) DEFAULT null,
  `LastUpdateDate` date DEFAULT NULL,
  `LastUpdateTime` time DEFAULT NULL,
  `LastUpdateBy` varchar(50) DEFAULT NULL,
  `Data` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`RefId`),
  UNIQUE KEY `RefId` (`RefId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0;

CREATE TABLE IF NOT EXISTS `employees` (
  `RefId` bigint(50) NOT NULL AUTO_INCREMENT,
  `branchRefId` int (10) default null,
  `FirstName` varchar(255) default null,
  `LastName` varchar(255) default null,
  `MiddleName` varchar(255) default null,
  `ExtName` varchar(255) default null,
  `Sex` varchar(10) default null,
  `CivilStatus` varchar(255) default null,
  `Remarks` varchar(300) DEFAULT null,
  `LastUpdateDate` date DEFAULT NULL,
  `LastUpdateTime` time DEFAULT NULL,
  `LastUpdateBy` varchar(50) DEFAULT NULL,
  `Data` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`RefId`),
  UNIQUE KEY `RefId` (`RefId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0;

CREATE TABLE IF NOT EXISTS `` (
  `RefId` bigint(50) NOT NULL AUTO_INCREMENT,
  `Username` varchar(300) default null,
  `Password` varchar(300) default null,
  `EncrytPassword` varchar(300) default null,
  `Remarks` varchar(300) DEFAULT null,
  `LastUpdateDate` date DEFAULT NULL,
  `LastUpdateTime` time DEFAULT NULL,
  `LastUpdateBy` varchar(50) DEFAULT NULL,
  `Data` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`RefId`),
  UNIQUE KEY `RefId` (`RefId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0;

CREATE TABLE IF NOT EXISTS `reservation` (
  `RefId` bigint(50) NOT NULL AUTO_INCREMENT,
  `CustomerRefId` int(10) default null,
  `EventRefId` int(10) default null,
  `ReservationDate` date default null,
  `ReservationTimeFrom` time default null,
  `ReservationTimeTo` time default null,
  `ExtraPerson` varchar(300) default null,
  `GrandTotal` int(15) default null,
  `Remarks` varchar(300) DEFAULT null,
  `LastUpdateDate` date DEFAULT NULL,
  `LastUpdateTime` time DEFAULT NULL,
  `LastUpdateBy` varchar(50) DEFAULT NULL,
  `Data` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`RefId`),
  UNIQUE KEY `RefId` (`RefId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0;

CREATE TABLE IF NOT EXISTS `reservation_misc` (
  `RefId` bigint(100) NOT NULL AUTO_INCREMENT,
  `ReservationRefId` int(10) default null,
  `ItemRefId` int(10) default null,
  `ItemQty` int(10) default null,
  `ItemTotal` int(10) default null,
  `Remarks` varchar(300) DEFAULT null,
  `LastUpdateDate` date DEFAULT NULL,
  `LastUpdateTime` time DEFAULT NULL,
  `LastUpdateBy` varchar(50) DEFAULT NULL,
  `Data` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`RefId`),
  UNIQUE KEY `RefId` (`RefId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0;

CREATE TABLE IF NOT EXISTS `Branch_Stock` (
  `RefId` bigint(50) NOT NULL AUTO_INCREMENT,
  `BranchRefId` int (10) default null,
  `DonutRefId` int(10) default null,
  `Stock` int(10) default null,
  `Remarks` varchar(300) DEFAULT null,
  `LastUpdateDate` date DEFAULT NULL,
  `LastUpdateTime` time DEFAULT NULL,
  `LastUpdateBy` varchar(50) DEFAULT NULL,
  `Data` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`RefId`),
  UNIQUE KEY `RefId` (`RefId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0;
