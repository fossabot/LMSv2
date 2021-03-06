ALTER TABLE `hrms`.`DEPARTMENT` 
DROP FOREIGN KEY `FKDEPARTMENT001`;
ALTER TABLE `hrms`.`DEPARTMENT` 
DROP INDEX `FKDEPARTMENT001_idx` ;

update DEPARTMENT set cd_human_resource_header = null;


ALTER TABLE `hrms`.`DEPARTMENT` 
CHANGE COLUMN `cd_human_resource_header` `cd_employee_header` INT(11) NULL DEFAULT NULL ;

ALTER TABLE `hrms`.`DEPARTMENT` 
ADD INDEX `FKDEPARTMENT001_idx` (`cd_employee_header` ASC);
ALTER TABLE `hrms`.`DEPARTMENT` 
ADD CONSTRAINT `FKDEPARTMENT001`
  FOREIGN KEY (`cd_employee_header`)
  REFERENCES `hrms`.`EMPLOYEE` (`cd_employee`)
  ON DELETE RESTRICT
  ON UPDATE RESTRICT;
