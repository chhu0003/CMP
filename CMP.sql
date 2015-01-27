SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


-- -----------------------------------------------------
-- Table `users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `users` ;

CREATE  TABLE IF NOT EXISTS `users` (
  `ID` INT NOT NULL AUTO_INCREMENT ,
  `user_login` VARCHAR(60) NOT NULL ,
  `user_pass` VARCHAR(100) NOT NULL ,
  `user_fname` VARCHAR(50) NOT NULL ,
  `user_lname` VARCHAR(50) NOT NULL ,
  `user_email` VARCHAR(100) NOT NULL ,
  `user_role` INT NOT NULL COMMENT 'User role as int for simple checks:\n10 = coordinator\n9 = assistant \n8 = professor' ,
  PRIMARY KEY (`ID`) ,
  UNIQUE INDEX `user_login_UNIQUE` (`user_login` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `programs`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `programs` ;

CREATE  TABLE IF NOT EXISTS `programs` (
  `ID` INT NOT NULL AUTO_INCREMENT ,
  `program_name` VARCHAR(100) NOT NULL ,
  `program_code` VARCHAR(45) NOT NULL ,
  `program_version` VARCHAR(45) NOT NULL COMMENT 'Program Year' ,
  `program_flowchart` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`ID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `courses`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `courses` ;

CREATE  TABLE IF NOT EXISTS `courses` (
  `ID` INT NOT NULL AUTO_INCREMENT ,
  `course_number` VARCHAR(50) NOT NULL ,
  `course_name` VARCHAR(100) NOT NULL ,
  `course_description` VARCHAR(1500) NULL ,
  `course_level` INT NOT NULL ,
  `course_hours_lab` VARCHAR(45) NULL ,
  `course_hours_lecture` VARCHAR(45) NULL ,
  `course_hours_study` VARCHAR(45) NULL ,
  `course_hybrid` INT NULL COMMENT '0 = false\n1 = true' ,
  PRIMARY KEY (`ID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `course_prerequisites`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `course_prerequisites` ;

CREATE  TABLE IF NOT EXISTS `course_prerequisites` (
  `ID` INT NOT NULL AUTO_INCREMENT ,
  `course_prerequisites_course_number` VARCHAR(50) NOT NULL ,
  `courses_ID` INT NOT NULL ,
  PRIMARY KEY (`ID`) ,
  INDEX `fk_course_prerequisites_courses1_idx` (`courses_ID` ASC) ,
  CONSTRAINT `fk_course_prerequisites_courses1`
    FOREIGN KEY (`courses_ID` )
    REFERENCES `courses` (`ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `students`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `students` ;

CREATE  TABLE IF NOT EXISTS `students` (
  `ID` INT NOT NULL AUTO_INCREMENT ,
  `student_number` VARCHAR(50) NOT NULL ,
  `student_fname` VARCHAR(50) NOT NULL ,
  `student_lname` VARCHAR(50) NOT NULL ,
  `student_email` VARCHAR(100) NULL ,
  `student_phone` VARCHAR(45) NULL ,
  PRIMARY KEY (`ID`, `student_number`) );


-- -----------------------------------------------------
-- Table `student_grades`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `student_grades` ;

CREATE  TABLE IF NOT EXISTS `student_grades` (
  `ID` INT NOT NULL AUTO_INCREMENT ,
  `letter_grade` VARCHAR(45) NULL ,
  `numeric_grade` FLOAT NULL ,
  `courses_ID` INT NOT NULL ,
  `students_ID` INT NOT NULL ,
  `students_student_number` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`ID`) ,
  INDEX `fk_student_grades_courses1_idx` (`courses_ID` ASC) ,
  INDEX `fk_student_grades_students1_idx` (`students_ID` ASC, `students_student_number` ASC) ,
  CONSTRAINT `fk_student_grades_courses1`
    FOREIGN KEY (`courses_ID` )
    REFERENCES `courses` (`ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_student_grades_students1`
    FOREIGN KEY (`students_ID` , `students_student_number` )
    REFERENCES `students` (`ID` , `student_number` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `books`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `books` ;

CREATE  TABLE IF NOT EXISTS `books` (
  `ID` INT NOT NULL AUTO_INCREMENT ,
  `book_title` VARCHAR(100) NOT NULL ,
  `book_isbn` VARCHAR(150) NULL ,
  `book_edition` VARCHAR(45) NULL ,
  `book_author` VARCHAR(45) NULL ,
  `book_publisher` VARCHAR(45) NULL ,
  `book_type` VARCHAR(45) NULL COMMENT 'Hard Cover / Soft Cover' ,
  `book_quantity` INT NULL ,
  `book_required` INT NOT NULL COMMENT '0 = false\n1 = true' ,
  `courses_ID` INT NOT NULL ,
  PRIMARY KEY (`ID`) ,
  INDEX `fk_books_courses1_idx` (`courses_ID` ASC) ,
  CONSTRAINT `fk_books_courses1`
    FOREIGN KEY (`courses_ID` )
    REFERENCES `courses` (`ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `users_has_programs`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `users_has_programs` ;

CREATE  TABLE IF NOT EXISTS `users_has_programs` (
  `users_ID` INT NOT NULL ,
  `programs_ID` INT NOT NULL ,
  PRIMARY KEY (`users_ID`, `programs_ID`) ,
  INDEX `fk_users_has_programs_programs1_idx` (`programs_ID` ASC) ,
  INDEX `fk_users_has_programs_users1_idx` (`users_ID` ASC) ,
  CONSTRAINT `fk_users_has_programs_users1`
    FOREIGN KEY (`users_ID` )
    REFERENCES `users` (`ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_has_programs_programs1`
    FOREIGN KEY (`programs_ID` )
    REFERENCES `programs` (`ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `professors`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `professors` ;

CREATE  TABLE IF NOT EXISTS `professors` (
  `ID` INT NOT NULL AUTO_INCREMENT ,
  `professor_fname` VARCHAR(50) NOT NULL ,
  `professor_lname` VARCHAR(50) NULL ,
  `professor_email` VARCHAR(100) NOT NULL ,
  `professor_phone` VARCHAR(45) NULL ,
  PRIMARY KEY (`ID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `student_courses`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `student_courses` ;

CREATE  TABLE IF NOT EXISTS `student_courses` (
  `ID` INT NOT NULL AUTO_INCREMENT ,
  `student_courses_semester` VARCHAR(45) NOT NULL ,
  `courses_ID` INT NOT NULL ,
  `students_ID` INT NOT NULL ,
  `students_student_number` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`ID`) ,
  INDEX `fk_student_courses_courses1_idx` (`courses_ID` ASC) ,
  INDEX `fk_student_courses_students1_idx` (`students_ID` ASC, `students_student_number` ASC) ,
  CONSTRAINT `fk_student_courses_courses1`
    FOREIGN KEY (`courses_ID` )
    REFERENCES `courses` (`ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_student_courses_students1`
    FOREIGN KEY (`students_ID` , `students_student_number` )
    REFERENCES `students` (`ID` , `student_number` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `course_equivalence`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `course_equivalence` ;

CREATE  TABLE IF NOT EXISTS `course_equivalence` (
  `ID` INT NOT NULL AUTO_INCREMENT ,
  `course_equivalence_course_number` VARCHAR(50) NOT NULL ,
  `course_equivalence_name` VARCHAR(45) NOT NULL ,
  `course_equivalence_description` VARCHAR(45) NULL ,
  PRIMARY KEY (`ID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `courses_has_professors`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `courses_has_professors` ;

CREATE  TABLE IF NOT EXISTS `courses_has_professors` (
  `courses_ID` INT NOT NULL ,
  `professors_ID` INT NOT NULL ,
  PRIMARY KEY (`courses_ID`, `professors_ID`) ,
  INDEX `fk_courses_has_professors_professors1_idx` (`professors_ID` ASC) ,
  INDEX `fk_courses_has_professors_courses1_idx` (`courses_ID` ASC) ,
  CONSTRAINT `fk_courses_has_professors_courses1`
    FOREIGN KEY (`courses_ID` )
    REFERENCES `courses` (`ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_courses_has_professors_professors1`
    FOREIGN KEY (`professors_ID` )
    REFERENCES `professors` (`ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `courses_has_course_equivalence`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `courses_has_course_equivalence` ;

CREATE  TABLE IF NOT EXISTS `courses_has_course_equivalence` (
  `courses_ID` INT NOT NULL ,
  `course_equivalence_ID` INT NOT NULL ,
  PRIMARY KEY (`courses_ID`, `course_equivalence_ID`) ,
  INDEX `fk_courses_has_course_equivalence_course_equivalence1_idx` (`course_equivalence_ID` ASC) ,
  INDEX `fk_courses_has_course_equivalence_courses1_idx` (`courses_ID` ASC) ,
  CONSTRAINT `fk_courses_has_course_equivalence_courses1`
    FOREIGN KEY (`courses_ID` )
    REFERENCES `courses` (`ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_courses_has_course_equivalence_course_equivalence1`
    FOREIGN KEY (`course_equivalence_ID` )
    REFERENCES `course_equivalence` (`ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
