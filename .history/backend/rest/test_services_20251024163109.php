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


$courses = $courseService->getAll();
echo "<pre>Courses:\n";
print_r($courses);
echo "</pre>";


$enrollments = $enrollmentService->getAllEnrollments();
echo "<pre>Enrollments:\n";
print_r($enrollments);
echo "</pre>";
?>