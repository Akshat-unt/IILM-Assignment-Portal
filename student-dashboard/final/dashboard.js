document.addEventListener('DOMContentLoaded', function () {
  const sidebar = document.getElementById('sidebar');
  const hamburgerMenu = document.getElementById('hamburger-menu');
  const container = document.getElementById('container');
  
  // Function to toggle sidebar
  function toggleSidebar() {
      sidebar.classList.toggle('active');
  }

  // Attach click event to the hamburger menu
  hamburgerMenu.addEventListener('click', toggleSidebar);
});

  // Data for assignments
  const subjects = {
      maths: [
          { assignmentName: 'Math Assignment 1', teacher: 'Prof. Sharma', unit: 'Algebra', status: 'Pending', grade: 'N/A' },
          { assignmentName: 'Math Assignment 2', teacher: 'Prof. Sharma', unit: 'Trigonometry', status: 'Submitted', grade: 'A' }
      ],
      physics: [
          { assignmentName: 'Physics Lab Report', teacher: 'Dr. Rao', unit: 'Electromagnetism', status: 'Pending', grade: 'N/A' }
      ],
      evs: [
          { assignmentName: 'EVS Fieldwork', teacher: 'Mr. Sinha', unit: 'Pollution Control', status: 'Submitted', grade: 'B+' }
      ],
      'communication-skills': [
          { assignmentName: 'Communication Skills Presentation', teacher: 'Ms. Mehta', unit: 'Public Speaking', status: 'Pending', grade: 'N/A' }
      ],
      'c-programming': [
          { assignmentName: 'C Programming Project', teacher: 'Mrs. Patel', unit: 'Loops', status: 'Pending', grade: 'N/A' }
      ]
  };

  function displayAssignments(subject) {
      assignmentsList.innerHTML = ''; // Clear previous assignments
      subjects[subject].forEach(assignment => {
          const row = document.createElement('tr');
          row.innerHTML = `
              <td>${assignment.assignmentName}</td>
              <td>${assignment.teacher}</td>
              <td>${assignment.unit}</td>
              <td>${assignment.status}</td>
              <td>${assignment.grade}</td>
              <td>
                  <form action="uploadAssignment.php" method="post" enctype="multipart/form-data">
                      <input type="file" name="fileToUpload" accept=".pdf,.doc,.docx,.xls,.xlsx" required>
                      <input type="submit" value="Upload">
                  </form>
              </td>
          `;
          assignmentsList.appendChild(row);
      });
  }

  function toggleSidebar() {
      sidebar.classList.toggle('active');
      container.classList.toggle('shifted');
  }

  hamburgerMenu.addEventListener('click', toggleSidebar);

  // Attach click event listeners to the subject list
  document.getElementById('maths').addEventListener('click', () => displayAssignments('maths'));
  document.getElementById('physics').addEventListener('click', () => displayAssignments('physics'));
  document.getElementById('evs').addEventListener('click', () => displayAssignments('evs'));
  document.getElementById('communication-skills').addEventListener('click', () => displayAssignments('communication-skills'));
  document.getElementById('c-programming').addEventListener('click', () => displayAssignments('c-programming'));

