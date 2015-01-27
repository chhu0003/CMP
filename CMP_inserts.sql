-- -----------------------------------------------------
-- Data for table `users`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `users` (`ID`, `user_login`, `user_pass`, `user_fname`, `user_lname`, `user_email`, `user_role`) VALUES (NULL, 'jmizon', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 'Jerome', 'Mizon', 'jmizon@jmizon.com', 10);
INSERT INTO `users` (`ID`, `user_login`, `user_pass`, `user_fname`, `user_lname`, `user_email`, `user_role`) VALUES (NULL, 'jsmith', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 'John', 'Smith', 'jsmith@jsmith.com', 8);
INSERT INTO `users` (`ID`, `user_login`, `user_pass`, `user_fname`, `user_lname`, `user_email`, `user_role`) VALUES (NULL, 'srichards', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 'Sally', 'Richards', 'srichards@srichards.com', 9);

COMMIT;

-- -----------------------------------------------------
-- Data for table `programs`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `programs` (`ID`, `program_name`, `program_code`, `program_version`, `program_flowchart`) VALUES (NULL, 'Internet Applications and Web Development', 'IAWD', '3002X', 'IAWD');

COMMIT;

-- -----------------------------------------------------
-- Data for table `courses`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `courses` (`ID`, `course_number`, `course_name`, `course_description`, `course_level`, `course_hours_lab`, `course_hours_lecture`, `course_hours_study`, `course_hybrid`) VALUES (1, 'CST8260', 'Database System and Concepts', NULL, 1, '2', '2', '3', NULL);
INSERT INTO `courses` (`ID`, `course_number`, `course_name`, `course_description`, `course_level`, `course_hours_lab`, `course_hours_lecture`, `course_hours_study`, `course_hybrid`) VALUES (2, 'CST8209', 'Web Programming I', NULL, 1, '2', '2', '5', 1);
INSERT INTO `courses` (`ID`, `course_number`, `course_name`, `course_description`, `course_level`, `course_hours_lab`, `course_hours_lecture`, `course_hours_study`, `course_hybrid`) VALUES (3, 'CST8110', 'Introduction to Computer Programming', NULL, 1, '3', '2', '6', 1);
INSERT INTO `courses` (`ID`, `course_number`, `course_name`, `course_description`, `course_level`, `course_hours_lab`, `course_hours_lecture`, `course_hours_study`, `course_hybrid`) VALUES (4, 'CST8101', 'Computer Essentials', NULL, 1, '2', '2', '4', 1);
INSERT INTO `courses` (`ID`, `course_number`, `course_name`, `course_description`, `course_level`, `course_hours_lab`, `course_hours_lecture`, `course_hours_study`, `course_hybrid`) VALUES (5, 'MAT8001', 'Math Fundamentals', NULL, 1, '3', '0', '3', NULL);
INSERT INTO `courses` (`ID`, `course_number`, `course_name`, `course_description`, `course_level`, `course_hours_lab`, `course_hours_lecture`, `course_hours_study`, `course_hybrid`) VALUES (6, 'CST8300', 'Achieving Success In Changing Enviroments ', NULL, 1, '3', '0', '3', 1);
INSERT INTO `courses` (`ID`, `course_number`, `course_name`, `course_description`, `course_level`, `course_hours_lab`, `course_hours_lecture`, `course_hours_study`, `course_hybrid`) VALUES (7, 'CST8250', 'Database Design and Administration', NULL, 2, '3', '2', '4', NULL);
INSERT INTO `courses` (`ID`, `course_number`, `course_name`, `course_description`, `course_level`, `course_hours_lab`, `course_hours_lecture`, `course_hours_study`, `course_hybrid`) VALUES (8, 'CST8253', 'Web Programming II', NULL, 2, '2', '2', '5', NULL);
INSERT INTO `courses` (`ID`, `course_number`, `course_name`, `course_description`, `course_level`, `course_hours_lab`, `course_hours_lecture`, `course_hours_study`, `course_hybrid`) VALUES (9, 'CST8254', 'Network Operating Systems', NULL, 2, '2', '3', '4', NULL);
INSERT INTO `courses` (`ID`, `course_number`, `course_name`, `course_description`, `course_level`, `course_hours_lab`, `course_hours_lecture`, `course_hours_study`, `course_hybrid`) VALUES (10, 'CST8255', 'Web Imaging and Animations', NULL, 2, '2', '2', '4', NULL);
INSERT INTO `courses` (`ID`, `course_number`, `course_name`, `course_description`, `course_level`, `course_hours_lab`, `course_hours_lecture`, `course_hours_study`, `course_hybrid`) VALUES (11, 'ENL1813T', 'Communications I', NULL, 2, '3', '0', '3', NULL);
INSERT INTO `courses` (`ID`, `course_number`, `course_name`, `course_description`, `course_level`, `course_hours_lab`, `course_hours_lecture`, `course_hours_study`, `course_hybrid`) VALUES (12, 'GED3002', 'Gen. Ed.Elective', NULL, 2, '3', '0', '3', NULL);
INSERT INTO `courses` (`ID`, `course_number`, `course_name`, `course_description`, `course_level`, `course_hours_lab`, `course_hours_lecture`, `course_hours_study`, `course_hybrid`) VALUES (13, 'CST8256', 'Web Programming Languages I', NULL, 3, '2', '2', '5', NULL);
INSERT INTO `courses` (`ID`, `course_number`, `course_name`, `course_description`, `course_level`, `course_hours_lab`, `course_hours_lecture`, `course_hours_study`, `course_hybrid`) VALUES (14, 'CST8257', 'Web Applications Development', NULL, 3, '3', '2', '5', 1);
INSERT INTO `courses` (`ID`, `course_number`, `course_name`, `course_description`, `course_level`, `course_hours_lab`, `course_hours_lecture`, `course_hours_study`, `course_hybrid`) VALUES (15, 'CST8258', 'Web Project Management', NULL, 3, '2', '1', '3', 1);
INSERT INTO `courses` (`ID`, `course_number`, `course_name`, `course_description`, `course_level`, `course_hours_lab`, `course_hours_lecture`, `course_hours_study`, `course_hybrid`) VALUES (16, 'ENL8720', 'Technical Report Writing', NULL, 3, '3', '0', '4', NULL);
INSERT INTO `courses` (`ID`, `course_number`, `course_name`, `course_description`, `course_level`, `course_hours_lab`, `course_hours_lecture`, `course_hours_study`, `course_hybrid`) VALUES (17, 'GED3002', 'Gen. Ed.Elective', NULL, 3, '3', '0', '3', NULL);
INSERT INTO `courses` (`ID`, `course_number`, `course_name`, `course_description`, `course_level`, `course_hours_lab`, `course_hours_lecture`, `course_hours_study`, `course_hybrid`) VALUES (18, 'CST8259', 'Web Programming Languages II', NULL, 4, '3', '2', '5', NULL);
INSERT INTO `courses` (`ID`, `course_number`, `course_name`, `course_description`, `course_level`, `course_hours_lab`, `course_hours_lecture`, `course_hours_study`, `course_hybrid`) VALUES (19, 'CST8265', 'Web Security Basics', NULL, 4, '2', '3', '5', NULL);
INSERT INTO `courses` (`ID`, `course_number`, `course_name`, `course_description`, `course_level`, `course_hours_lab`, `course_hours_lecture`, `course_hours_study`, `course_hybrid`) VALUES (20, 'CST8267', 'eCommerce', NULL, 4, '3', '1', '3', NULL);
INSERT INTO `courses` (`ID`, `course_number`, `course_name`, `course_description`, `course_level`, `course_hours_lab`, `course_hours_lecture`, `course_hours_study`, `course_hybrid`) VALUES (21, 'CST8268', 'Project*', NULL, 4, '2', '2', '8', NULL);

COMMIT;

-- -----------------------------------------------------
-- Data for table `course_prerequisites`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `course_prerequisites` (`ID`, `course_prerequisites_course_number`, `courses_ID`) VALUES (NULL, 'CST8260', 7);
INSERT INTO `course_prerequisites` (`ID`, `course_prerequisites_course_number`, `courses_ID`) VALUES (NULL, 'CST8209', 8);
INSERT INTO `course_prerequisites` (`ID`, `course_prerequisites_course_number`, `courses_ID`) VALUES (NULL, 'CST8110', 8);
INSERT INTO `course_prerequisites` (`ID`, `course_prerequisites_course_number`, `courses_ID`) VALUES (NULL, 'CST8209', 10);
INSERT INTO `course_prerequisites` (`ID`, `course_prerequisites_course_number`, `courses_ID`) VALUES (NULL, 'CST8253', 13);
INSERT INTO `course_prerequisites` (`ID`, `course_prerequisites_course_number`, `courses_ID`) VALUES (NULL, 'CST8260', 13);
INSERT INTO `course_prerequisites` (`ID`, `course_prerequisites_course_number`, `courses_ID`) VALUES (NULL, 'CST8209', 13);
INSERT INTO `course_prerequisites` (`ID`, `course_prerequisites_course_number`, `courses_ID`) VALUES (NULL, 'CST8209', 14);
INSERT INTO `course_prerequisites` (`ID`, `course_prerequisites_course_number`, `courses_ID`) VALUES (NULL, 'CST8253', 15);
INSERT INTO `course_prerequisites` (`ID`, `course_prerequisites_course_number`, `courses_ID`) VALUES (NULL, 'ENL1813T', 16);
INSERT INTO `course_prerequisites` (`ID`, `course_prerequisites_course_number`, `courses_ID`) VALUES (NULL, 'CST8257', 18);
INSERT INTO `course_prerequisites` (`ID`, `course_prerequisites_course_number`, `courses_ID`) VALUES (NULL, 'CST8257', 19);
INSERT INTO `course_prerequisites` (`ID`, `course_prerequisites_course_number`, `courses_ID`) VALUES (NULL, 'CST8257', 20);
INSERT INTO `course_prerequisites` (`ID`, `course_prerequisites_course_number`, `courses_ID`) VALUES (NULL, 'CST8258', 21);

COMMIT;

-- -----------------------------------------------------
-- Data for table `students`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `students` (`ID`, `student_number`, `student_fname`, `student_lname`, `student_email`, `student_phone`) VALUES (NULL, '111111111', 'Eric', 'Tubby', 'tubb0006@algonquinlive.com', '6131234567');
INSERT INTO `students` (`ID`, `student_number`, `student_fname`, `student_lname`, `student_email`, `student_phone`) VALUES (NULL, '111111112', 'Nicolas', 'Fournier', 'cavalier_nick@hotmail.com', '6131234561');
INSERT INTO `students` (`ID`, `student_number`, `student_fname`, `student_lname`, `student_email`, `student_phone`) VALUES (NULL, '111111113', 'Ryan', 'Gaterell', 'gate0026@algonquinlive.com', '6131234562');
INSERT INTO `students` (`ID`, `student_number`, `student_fname`, `student_lname`, `student_email`, `student_phone`) VALUES (NULL, '111111114', 'Sebastien', 'Lallemand', 'sebmlall@hotmail.com', '6131234563');
INSERT INTO `students` (`ID`, `student_number`, `student_fname`, `student_lname`, `student_email`, `student_phone`) VALUES (NULL, '111111115', 'Hetalben', 'Pandav', 'pand0033@algonquinlive.com', '6131234564');
INSERT INTO `students` (`ID`, `student_number`, `student_fname`, `student_lname`, `student_email`, `student_phone`) VALUES (NULL, '111111116', 'Stephane', 'Sauve', 'space_for_more@hotmail.com', '6131234565');

COMMIT;

-- -----------------------------------------------------
-- Data for table `student_grades`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `student_grades` (`ID`, `letter_grade`, `numeric_grade`, `courses_ID`, `students_ID`, `students_student_number`) VALUES (NULL, NULL, NULL, 1, 1, '111111111');
INSERT INTO `student_grades` (`ID`, `letter_grade`, `numeric_grade`, `courses_ID`, `students_ID`, `students_student_number`) VALUES (NULL, NULL, NULL, 2, 1, '111111111');
INSERT INTO `student_grades` (`ID`, `letter_grade`, `numeric_grade`, `courses_ID`, `students_ID`, `students_student_number`) VALUES (NULL, NULL, NULL, 1, 2, '111111112');
INSERT INTO `student_grades` (`ID`, `letter_grade`, `numeric_grade`, `courses_ID`, `students_ID`, `students_student_number`) VALUES (NULL, NULL, NULL, 2, 2, '111111112');
INSERT INTO `student_grades` (`ID`, `letter_grade`, `numeric_grade`, `courses_ID`, `students_ID`, `students_student_number`) VALUES (NULL, NULL, NULL, 1, 3, '111111113');
INSERT INTO `student_grades` (`ID`, `letter_grade`, `numeric_grade`, `courses_ID`, `students_ID`, `students_student_number`) VALUES (NULL, NULL, NULL, 2, 3, '111111113');
INSERT INTO `student_grades` (`ID`, `letter_grade`, `numeric_grade`, `courses_ID`, `students_ID`, `students_student_number`) VALUES (NULL, NULL, NULL, 1, 4, '111111114');
INSERT INTO `student_grades` (`ID`, `letter_grade`, `numeric_grade`, `courses_ID`, `students_ID`, `students_student_number`) VALUES (NULL, NULL, NULL, 2, 4, '111111114');
INSERT INTO `student_grades` (`ID`, `letter_grade`, `numeric_grade`, `courses_ID`, `students_ID`, `students_student_number`) VALUES (NULL, NULL, NULL, 1, 5, '111111115');
INSERT INTO `student_grades` (`ID`, `letter_grade`, `numeric_grade`, `courses_ID`, `students_ID`, `students_student_number`) VALUES (NULL, NULL, NULL, 2, 5, '111111115');
INSERT INTO `student_grades` (`ID`, `letter_grade`, `numeric_grade`, `courses_ID`, `students_ID`, `students_student_number`) VALUES (NULL, NULL, NULL, 1, 6, '111111116');
INSERT INTO `student_grades` (`ID`, `letter_grade`, `numeric_grade`, `courses_ID`, `students_ID`, `students_student_number`) VALUES (NULL, NULL, NULL, 2, 6, '111111116');

COMMIT;

-- -----------------------------------------------------
-- Data for table `books`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `books` (`ID`, `book_title`, `book_isbn`, `book_edition`, `book_author`, `book_publisher`, `book_type`, `book_quantity`, `book_required`, `courses_ID`) VALUES (NULL, 'Modern Database Management', NULL, '10e', 'Hoffer', NULL, NULL, NULL, 1, 1);
INSERT INTO `books` (`ID`, `book_title`, `book_isbn`, `book_edition`, `book_author`, `book_publisher`, `book_type`, `book_quantity`, `book_required`, `courses_ID`) VALUES (NULL, 'SQL Visual Quickstart Guide', NULL, '3e', 'Fehily', NULL, NULL, NULL, 1, 1);
INSERT INTO `books` (`ID`, `book_title`, `book_isbn`, `book_edition`, `book_author`, `book_publisher`, `book_type`, `book_quantity`, `book_required`, `courses_ID`) VALUES (NULL, 'MySQL Phrase Book', NULL, NULL, 'Greant', NULL, NULL, NULL, 1, 1);

COMMIT;

-- -----------------------------------------------------
-- Data for table `student_courses`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `student_courses` (`ID`, `student_courses_semester`, `courses_ID`, `students_ID`, `students_student_number`) VALUES (NULL, '14W', 1, 1, '111111111');
INSERT INTO `student_courses` (`ID`, `student_courses_semester`, `courses_ID`, `students_ID`, `students_student_number`) VALUES (NULL, '14W', 2, 1, '111111111');
INSERT INTO `student_courses` (`ID`, `student_courses_semester`, `courses_ID`, `students_ID`, `students_student_number`) VALUES (NULL, '14W', 1, 2, '111111112');
INSERT INTO `student_courses` (`ID`, `student_courses_semester`, `courses_ID`, `students_ID`, `students_student_number`) VALUES (NULL, '14W', 2, 2, '111111112');
INSERT INTO `student_courses` (`ID`, `student_courses_semester`, `courses_ID`, `students_ID`, `students_student_number`) VALUES (NULL, '14W', 1, 3, '111111113');
INSERT INTO `student_courses` (`ID`, `student_courses_semester`, `courses_ID`, `students_ID`, `students_student_number`) VALUES (NULL, '14W', 2, 3, '111111113');
INSERT INTO `student_courses` (`ID`, `student_courses_semester`, `courses_ID`, `students_ID`, `students_student_number`) VALUES (NULL, '14W', 1, 4, '111111114');
INSERT INTO `student_courses` (`ID`, `student_courses_semester`, `courses_ID`, `students_ID`, `students_student_number`) VALUES (NULL, '14W', 2, 4, '111111114');
INSERT INTO `student_courses` (`ID`, `student_courses_semester`, `courses_ID`, `students_ID`, `students_student_number`) VALUES (NULL, '14W', 1, 5, '111111115');
INSERT INTO `student_courses` (`ID`, `student_courses_semester`, `courses_ID`, `students_ID`, `students_student_number`) VALUES (NULL, '14W', 2, 5, '111111115');
INSERT INTO `student_courses` (`ID`, `student_courses_semester`, `courses_ID`, `students_ID`, `students_student_number`) VALUES (NULL, '14W', 1, 6, '111111116');
INSERT INTO `student_courses` (`ID`, `student_courses_semester`, `courses_ID`, `students_ID`, `students_student_number`) VALUES (NULL, '14W', 2, 6, '111111116');

COMMIT;
