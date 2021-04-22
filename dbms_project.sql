CREATE TABLE reguser(
    `id` INT NOT NULL,
    `emailid` VARCHAR(255) NOT NULL,
    `password` VARCHAR(15) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `age` INT NOT NULL,
    `occupation` VARCHAR(255) NOT NULL,
    `mobilenumber1` BIGINT NOT NULL,
    `mobilenumber2` BIGINT DEFAULT NULL,
    `houseno` INT NOT NULL,
    `street` VARCHAR(255) NOT NULL,
    `city` VARCHAR(255) NOT NULL,
    `state` VARCHAR(255) NOT NULL,
    `pincode` INT NOT NULL CHECK
        (
            `pincode` >= 110001 AND `pincode` <= 855117
        ),
        `hos_id` INT DEFAULT NULL,
        `doc_id` INT DEFAULT NULL,
	 `regdate` timestamp NULL DEFAULT current_timestamp()
);
ALTER TABLE
    `reguser` ADD PRIMARY KEY(`id`);
ALTER TABLE 
	`reguser` MODIFY `id` int NOT NULL AUTO_INCREMENT;
ALTER TABLE `reguser`
ADD `slotno` INT NOT NULL DEFAULT 0;

ALTER TABLE `reguser`
ADD `slotdate` DATE ;



CREATE TABLE reghosp(
    `id` INT NOT NULL,
    `emailid` VARCHAR(255) NOT NULL,
      `name` VARCHAR(255) NOT NULL,
    `mobile` VARCHAR(10) NOT NULL,
    `password` VARCHAR(15) NOT NULL,
    `street` VARCHAR(255) NOT NULL,
    `city` VARCHAR(255) NOT NULL,
    `state` VARCHAR(255) NOT NULL,
    `pincode` INT NOT NULL CHECK
        (
            Pincode >= 110001 AND pincode <= 855117
        ) 
);
 ALTER TABLE
    `reghosp` ADD PRIMARY KEY(`id`);



CREATE TABLE doctor(
    `id` INT NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `qualifications` VARCHAR(255) NOT NULL,
    `houseno` INT NOT NULL,
    `street` VARCHAR(255) NOT NULL,
    `city` VARCHAR(255) NOT NULL,
    `state` VARCHAR(255) NOT NULL,
    `pincode` INT NOT NULL CHECK
        (
            `pincode` >= 110001 AND `pincode` <= 855117
        ),
    `hos_id` INT NOT NULL,
    FOREIGN KEY (`hos_id`) REFERENCES reghosp(`id`)
    );

ALTER TABLE `doctor`
	ADD PRIMARY KEY (`id`);



CREATE TABLE hosp_slots(
    `hos_id` INT NOT NULL,
    `num_slots` INT NOT NULL,
    `empty_1` INT NOT NULL,
    `empty_2` INT NOT NULL,
    `empty_3` INT NOT NULL,
    `date` DATE NOT NULL,
    FOREIGN KEY (`hos_id`) REFERENCES reghosp(`id`)
    );

ALTER TABLE `hosp_slots`
ADD PRIMARY KEY (`hos_id`, `date`);

create table weights(
    `class1` INT NOT NULL DEFAULT 50,
    `class2` INT NOT NULL DEFAULT 30,
    `class3` INT NOT NULL DEFAULT 20,
    `lastupdated` date 
);

INSERT INTO `weights` values (50, 30, 20, '2021-03-29');
UPDATE `weights`
SET `lastupdated`= '2021-03-27'
WHERE class1 = 50;



CREATE TABLE vaccine(
	`id` INT NOT NULL,
    `dom` DATE NOT NULL,
    `hospid` INT NOT NULL,
    `date_sent`DATE NOT NULL,
    FOREIGN KEY (`hospid`) REFERENCES reghosp(`id`)
);

ALTER TABLE `vaccine`
	ADD PRIMARY KEY (`id`);



CREATE TABLE vacuser(
	`id` INT NOT NULL,
    `vacno` INT NOT NULL,
    `vacid` INT NOT NULL,
    `vacdate` timestamp NULL DEFAULT current_timestamp(),
    FOREIGN KEY (`id`) REFERENCES reguser(`id`)
);

ALTER TABLE `vacuser`
	ADD PRIMARY KEY (`id`, `vacno`);



CREATE TABLE feedback(
    `id` INT NOT NULL,
    `fbno` INT NOT NULL DEFAULT 1,
    `fb` VARCHAR(255) NOT NULL,
    `symptoms` VARCHAR(255) DEFAULT NULL,
    `fbdate` timestamp NULL DEFAULT current_timestamp(),
    FOREIGN KEY (`id`) REFERENCES reguser(`id`)
    );
ALTER TABLE `feedback`
	ADD PRIMARY KEY (`id`, `fbno`);

CREATE TABLE comp_doc(
	`userid` INT NOT NULL,
    `docid` INT NOT NULL,
    FOREIGN KEY (`docid`) REFERENCES doctor(`id`),
    FOREIGN KEY (`userid`) REFERENCES reguser(`id`)
);

ALTER TABLE `comp_doc`
	ADD PRIMARY KEY (`userid`,`docid`);


    
INSERT INTO `reghosp` (`id`, `emailid`, `name`, `mobile`, `password`, `street`, `city`, `state`, `pincode`) VALUES ('1', 'hosp1@gmail.com', 'hosp1', '9999999999', 'hosp1@60', 'Vuda Colony', 'Visakhapatnam', 'Andhra Pradesh', '530044');
INSERT INTO `reghosp` (`id`, `emailid`, `name`, `mobile`, `password`, `street`, `city`, `state`, `pincode`) VALUES ('2', 'hosp2@gmail.com', 'hosp2', '8888888888', 'hosp2@60', 'Kuda Colony', 'Kharagpur', 'West Bengal', '730044');
INSERT INTO `reghosp` (`id`, `emailid`, `name`, `mobile`, `password`, `street`, `city`, `state`, `pincode`) VALUES ('3', 'hosp3@gmail.com', 'hosp3', '7777777777', 'hosp3@60', 'MG Colony', 'Mumbai', 'Maharastra', '630344');
INSERT INTO `reghosp` (`id`, `emailid`, `name`, `mobile`, `password`, `street`, `city`, `state`, `pincode`) VALUES ('4', 'hosp4@gmail.com', 'hosp4', '6666666666', 'hosp4@60', 'GU Colony', 'Mumbai', 'Maharastra', '531234');
INSERT INTO `reghosp` (`id`, `emailid`, `name`, `mobile`, `password`, `street`, `city`, `state`, `pincode`) VALUES ('5', 'hosp5@gmail.com', 'hosp5', '6767676767', 'hosp5@60', 'Kim Street', 'Banglore', 'Karnataka', '531265');

INSERT INTO `doctor` (`id`, `name`, `qualifications`, `houseno`, `street`, `city`, `state`, `pincode`, `hos_id`) VALUES ('1', 'Sujatha', 'MBBS', '58', 'RA street', 'Visakhapatnam', 'Andhra Pradesh', '530048', '1');
INSERT INTO `doctor` (`id`, `name`, `qualifications`, `houseno`, `street`, `city`, `state`, `pincode`, `hos_id`) VALUES ('2', 'Ram', 'BMBS', '167', 'LR street', 'Visakhapatnam', 'Andhra Pradesh', '530047', '1');
INSERT INTO `doctor` (`id`, `name`, `qualifications`, `houseno`, `street`, `city`, `state`, `pincode`, `hos_id`) VALUES ('6', 'Chandana', 'MBBCh', '243', 'George street', 'Vizag', 'Andhra Pradesh', '532246', '1');
INSERT INTO `doctor` (`id`, `name`, `qualifications`, `houseno`, `street`, `city`, `state`, `pincode`, `hos_id`) VALUES ('3', 'Sirish', 'MBBS', '203', 'Samatha Nagar', 'Kharagpur', 'West Bengal', '720068', '2');
INSERT INTO `doctor` (`id`, `name`, `qualifications`, `houseno`, `street`, `city`, `state`, `pincode`, `hos_id`) VALUES ('4', 'Kruthi', 'MBBCh', '558', 'Vinayaka Nagar', 'Kharagpur', 'West Bengal', '740091', '2');
INSERT INTO `doctor` (`id`, `name`, `qualifications`, `houseno`, `street`, `city`, `state`, `pincode`, `hos_id`) VALUES ('5', 'Jeevak', 'BMBS', '642', 'LU Colony', 'Mumbai', 'Maharastra', '645892', '3');
INSERT INTO `doctor` (`id`, `name`, `qualifications`, `houseno`, `street`, `city`, `state`, `pincode`, `hos_id`) VALUES ('8', 'Pratyun', 'MBBCh', '554', 'Gandhi Nagar', 'Kharagpur', 'West Bengal', '740091', '2');
INSERT INTO `doctor` (`id`, `name`, `qualifications`, `houseno`, `street`, `city`, `state`, `pincode`, `hos_id`) VALUES ('7', 'Gavrav', 'BMBS', '642', 'Nehru Colony', 'Mumbai', 'Maharastra', '645895', '3');

INSERT INTO `vaccine` (`id`, `dom`, `hospid`, `date_sent`) VALUES (333 ,  '2021-01-01', 1, '2021-03-17');
INSERT INTO `vaccine` (`id`, `dom`, `hospid`, `date_sent`) VALUES (444 ,  '2021-01-01', 1, '2021-03-17');
INSERT INTO `vaccine` (`id`, `dom`, `hospid`, `date_sent`) VALUES (555 ,  '2021-01-01', 1, '2021-03-17');
INSERT INTO `vaccine` (`id`, `dom`, `hospid`, `date_sent`) VALUES (666 ,  '2021-01-01', 1, '2021-03-17');
INSERT INTO `vaccine` (`id`, `dom`, `hospid`, `date_sent`) VALUES (777 ,  '2021-01-01', 2, '2021-03-17');
INSERT INTO `vaccine` (`id`, `dom`, `hospid`, `date_sent`) VALUES (888 ,  '2021-01-01', 3, '2021-03-17');

INSERT INTO `hosp_slots` (`hos_id`, `num_slots`, `empty_1`, `empty_2`, `empty_3`, `date`) VALUES (1, 100, 0, 0, 0, '2021-03-31');
INSERT INTO `hosp_slots` (`hos_id`, `num_slots`, `empty_1`, `empty_2`, `empty_3`, `date`) VALUES (1, 80, 0, 0, 0, '2021-04-01');
INSERT INTO `hosp_slots` (`hos_id`, `num_slots`, `empty_1`, `empty_2`, `empty_3`, `date`) VALUES (1, 100, 10, 5, 2, '2021-04-02');
INSERT INTO `hosp_slots` (`hos_id`, `num_slots`, `empty_1`, `empty_2`, `empty_3`, `date`) VALUES (1, 80, 40, 24, 16, '2021-04-03');
INSERT INTO `hosp_slots` (`hos_id`, `num_slots`, `empty_1`, `empty_2`, `empty_3`, `date`) VALUES (1, 80, 40, 24, 16, '2021-04-04');
INSERT INTO `hosp_slots` (`hos_id`, `num_slots`, `empty_1`, `empty_2`, `empty_3`, `date`) VALUES (2, 80, 0, 0, 0, '2021-03-31');
INSERT INTO `hosp_slots` (`hos_id`, `num_slots`, `empty_1`, `empty_2`, `empty_3`, `date`) VALUES (2, 100, 0, 0, 0, '2021-04-01');
INSERT INTO `hosp_slots` (`hos_id`, `num_slots`, `empty_1`, `empty_2`, `empty_3`, `date`) VALUES (2, 100, 20, 10, 10, '2021-04-02');
INSERT INTO `hosp_slots` (`hos_id`, `num_slots`, `empty_1`, `empty_2`, `empty_3`, `date`) VALUES (2, 80, 40, 24, 16, '2021-04-03');
INSERT INTO `hosp_slots` (`hos_id`, `num_slots`, `empty_1`, `empty_2`, `empty_3`, `date`) VALUES (2, 80, 40, 24, 16, '2021-04-04');
