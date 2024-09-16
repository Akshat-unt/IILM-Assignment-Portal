document.addEventListener('DOMContentLoaded', function () {
  const assignmentsList = document.getElementById('submitted-assignments-list');

  // Data for assignments
  const subjects = {
      maths: [
          { assignmentName: 'Math Assignment 1', teacher: 'Prof. Sharma', unit: 'Algebra', status: 'Submitted', grade: 'A' },
          { assignmentName: 'Math Assignment 2', teacher: 'Prof. Sharma', unit: 'Trigonometry', status: 'Submitted', grade: 'B+' }
      ],
      physics: [
          { assignmentName: 'Physics Lab Report', teacher: 'Dr. Rao', unit: 'Electromagnetism', status: 'Submitted', grade: 'A-' }
      ],
      evs: [
          { assignmentName: 'EVS Fieldwork', teacher: 'Mr. Sinha', unit: 'Pollution Control', status: 'Submitted', grade: 'B+' }
      ],
      'communication-skills': [
          { assignmentName: 'Communication Skills Presentation', teacher: 'Ms. Mehta', unit: 'Public Speaking', status: 'Submitted', grade: 'A-' }
      ],
      'c-programming': [
          { assignmentName: 'C Programming Assignment 1', teacher: 'Dr. Mishra', unit: 'Loops', status: 'Submitted', grade: 'A' }
      ]
  };

  // Function to populate submitted assignments
  function displaySubmittedAssignments() {
      // Clear previous assignments
      assignmentsList.innerHTML = '';

      // Add new assignments
      for (const [subject, assignments] of Object.entries(subjects)) {
          assignments.forEach((assignment) => {
              const row = document.createElement('tr');

              row.innerHTML = `
                  <td>${capitalizeFirstLetter(subject)}</td>
                  <td>${assignment.assignmentName}</td>
                  <td>${assignment.teacher}</td>
                  <td>${assignment.unit}</td>
                  <td>${assignment.status}</td>
                  <td>${assignment.grade}</td>
              `;

              assignmentsList.appendChild(row);
          });
      }
  }

  // Capitalize the first letter of each word
  function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
  }

  displaySubmittedAssignments();
});
