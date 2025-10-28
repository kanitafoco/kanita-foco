<?php
require_once 'services/StudentService.php';
require_once 'services/CourseService.php';
require_once 'services/EnrollmentService.php';

$studentService = new StudentService();
$courseService = new CourseService();
$enrollmentService = new EnrollmentService();


$student = $studentService->getByEmail('ilma@gmail.com');
echo "<pre>Student:\n";
print_r($student);
echo "</pre>";

//$courseService->createCourse('IBU 061 Foundations of Frontend Development', 6);
$courses = $courseService->getAll();
echo "<pre>Courses:\n";
print_r($courses);
echo "</pre>";

//$enrollmentService->enrollStudent(1, 1); // assumes IDs 1 and 1 exist
$enrollments = $enrollmentService->getAllEnrollments();
echo "<pre>Enrollments:\n";
print_r($enrollments);
echo "</pre>";
?>