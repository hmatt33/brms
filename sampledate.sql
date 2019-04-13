//if you want to overwrite existing tables, drop(delete) them with
//DROP TABLE table_name;
//can also use the alter command to insert columns

Create Table Users (
    UserID int not null auto_increment,
    FirstName varchar(100) not null,
    LastName varchar(100) not null,
    Email varchar(100) not null,
    Username varchar(100) not null,
    Password varchar(100) not null,
    Edit varchar(10) not null DEFAULT 'Edit',
    Del varchar(10) not null DEFAULT 'Delete',
    UserLevel tinyint unsigned not null default 0;
    Primary Key(userID),
    Unique (Username)
);

insert into Users(FirstName, LastName, Email, Password, UserLevel)
values ('admin', 'admin', 'admin@brms.com', 'pass', 1);

insert into Users(FirstName, LastName, Email, Password)
values ('bob', 'Bob', 'bob@brms.com', 'pass');

Create Table Buildings (
    BuildingID int not null auto_increment,
    Name varchar(100) not null,
    Address varchar(100) not null,
    PhoneNumber int not null,
    TotalRooms int not null,
    TotalVacRooms int not null,
    Edit varchar(10) not null DEFAULT 'Edit',
    Del varchar(10) not null DEFAULT 'Delete',
    Primary Key(BuildingID)
);


insert into Buildings(Name, Address, PhoneNumber, TotalRooms, TotalVacRooms)
values ('Building 1', 'bridge ave', 1234567, 20, 10);

insert into Buildings(Name, Address, PhoneNumber, TotalRooms, TotalVacRooms)
values ('Building 2', 'bridge2 ave', 2234567, 30, 0);

insert into Buildings(Name, Address, PhoneNumber, TotalRooms, TotalVacRooms)
values ('Building 3', 'bridge3 ave', 3234567, 15, 15);

insert into Buildings(BuildingID, Name, Address, PhoneNumber,TotalRooms, TotalVacRooms)
values (4, 'Building 4', 'bridge4 ave', 4234567, 15, 15);

Create Table Residents  (
    ResidentID int not null auto_increment,
    BuildingID int not null,
    FirstName varchar(100) not null,
    LastName varchar(100) not null,
    Email varchar(100) not null,
    PhoneNumber varchar(100) not null,
    ApartNum varchar(100) not null,
    ResType varchar(100) not null,
    BillingAddress varchar(100),
    EmerContactInfo varchar(100) not null,
    Edit varchar(10) not null DEFAULT 'Edit',
    Del varchar(10) not null DEFAULT 'Delete',
    Primary Key(ResidentID),
    Index Build_ID (BuildingID),
    Foreign Key(BuildingID)
    References Buildings(BuildingID)
) Engine=INNODB;

