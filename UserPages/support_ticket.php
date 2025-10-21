<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Host IT Services - Support Ticket</title>
    <link rel="stylesheet" type="text/css" href="../CSS/user_style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="../JavaScript/user_script.js" defer></script>

    <script>
      // Gamification: Track tickets and award points
      document.addEventListener('DOMContentLoaded', function () {
        let points = parseInt(localStorage.getItem('supportPoints') || '0');
        let tickets = parseInt(localStorage.getItem('supportTickets') || '0');
        const pointsDisplay = document.getElementById('pointsDisplay');
        const ticketsDisplay = document.getElementById('ticketsDisplay');
        pointsDisplay.textContent = points;
        ticketsDisplay.textContent = tickets;

        const form = document.getElementById('supportForm');
        form.addEventListener('submit', function (e) {
          e.preventDefault();
          tickets++;
          points += 10; // 10 points per ticket
          localStorage.setItem('supportPoints', points);
          localStorage.setItem('supportTickets', tickets);
          pointsDisplay.textContent = points;
          ticketsDisplay.textContent = tickets;
          swal("Success!", "Your support ticket has been submitted! You earned 10 points!", "success");
          form.reset();
        });
      });
    </script>
  </head>

  <body>
    <?php include '../UserPages/User_Header.php';?>

    <div class="support-container">
      <div class="support-card">
        <h2>Submit a Support Ticket</h2>

        <div class="support-status">
          Tickets submitted: <span id="ticketsDisplay">0</span> | Points: <span id="pointsDisplay">0</span>
        </div>

        <form id="supportForm" enctype="multipart/form-data">
            <div class="form-group">
                <label for="ticketsubject">Subject</label>
                <input type="text" id="ticketsubject" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="ticketCategory">Category</label>
                <input type="text" id="ticketCategory" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="ticketPriority">Priority</label>
                <select id="ticketPriority" class="form-control" required>
                <option value="">Select Priority</option>
                <option value="Low">Low</option>
                <option value="Medium">Medium</option>
                <option value="High">High</option>
                </select>
            </div>

            <div class="form-group">
                <label for="ticketfile">Upload File (optional)</label>
                <input type="file" id="ticketfile" class="form-control-file" accept=".jpg,.png,.pdf,.docx">
            </div>

            <div class="form-group">
                <label for="ticketMessage">Message</label>
                <textarea id="ticketMessage" rows="5" class="form-control" required></textarea>
            </div>

            <div class="button-group">
                <button type="reset" class="button btn-secondary">Cancel</button>
                <button type="submit" class="button btn-primary">Submit Ticket</button>
            </div>
        </form>

      </div>
    </div>

    <?php include '../Components/footer.php';?>
  </body>
</html>
