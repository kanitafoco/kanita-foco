<?php
require_once 'dao/CategoryDao.php';
require_once 'dao/OrderDao.php';
require_once 'dao/OrderItemDao.php';
require_once 'dao/Dao.php';


$studentDao = new StudentDao();
$courseDao = new CourseDao();
$enrollmentDao = new EnrollmentDao();

//$studentDao->createStudent('John Doe', 'john@gmail.com', 'password123');
$student = $studentDao->getByEmail('john@gmail.com');
print_r($student);
echo "<br><br>";
$students = $studentDao->getAll();
print_r($students);
echo "<br><br>";

//$courseDao->createCourse('IBU 2002 Programming ', 5);
$courses = $courseDao->getAll();
print_r($courses);
echo "<br><br>";

//$enrollmentDao->enrollStudent(1, 1);
$enrollments = $enrollmentDao->getAllEnrollments();
echo "Enrollments:";
echo "<pre>";
print_r($enrollments);
echo "</pre>";
?>