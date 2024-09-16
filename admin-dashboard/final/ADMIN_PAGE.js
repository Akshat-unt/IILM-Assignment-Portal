function register(type) {
  switch(type) {
      case 'student':
          alert("Redirecting to Student Registration Page...");
          // window.location.href = 'student_registration.html'; // Add real link
          break;
      case 'faculty':
          alert("Redirecting to Faculty Registration Page...");
          // window.location.href = 'faculty_registration.html'; // Add real link
          break;
      case 'course':
          alert("Redirecting to Course Registration Page...");
          // window.location.href = 'course_registration.html'; // Add real link
          break;
      default:
          alert("Unknown registration type");
  }
}

function manage(type) {
  switch(type) {
      case 'student':
          alert("Redirecting to Student Management Page...");
          // window.location.href = 'student_management.html'; // Add real link
          break;
      case 'teacher':
          alert("Redirecting to Teacher Management Page...");
          // window.location.href = 'teacher_management.html'; // Add real link
          break;
      case 'course':
          alert("Redirecting to Course Management Page...");
          // window.location.href = 'course_management.html'; // Add real link
          break;
      default:
          alert("Unknown management type");
  }
}
