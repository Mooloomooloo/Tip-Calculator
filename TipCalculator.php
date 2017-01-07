<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title>Tip Calculator</title>
    
    <meta charset="utf-8">
    <meta name="author" content="Raymond Leung">
    <meta name="description" content="The tip calculator allows the user to choose a
    tip percentage and then calculates the total payment.">
    
    <link href="style.css" type="text/css" rel="stylesheet" >
  </head>

  <body>

    <?php
      $subtotal = ""; // bill amount
      $percent = 15; // default tip percentage
      $subtErr = ""; // error message to be printed
      
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // sets $percent each time submit is pressed
        if (isset($_POST["submit"])) {
          $percent = $_POST["option"];
        }
        
        // checks if input is empty
        if (empty($_POST["subt"])) {
          $subtErr = "Error: Subtotal is empty.";
        }
        // checks if input is numerical
        else if (!is_numeric($_POST["subt"])) {
          $subtErr = "Error: Subtotal must be a numerical entry.";
        }
        // checks if input is greater than 0
        else if (floatval($_POST["subt"]) <= 0) {
          $subtErr = "Error: Subtotal must be greater than 0.";
        }
        // no input errors, sets $subtotal to input
        else {
          $subtotal = $_POST["subt"];
        }
      }
    ?>

    
    <div class="title" align="center">
      <h2>Tip Calculator</h2>
    </div>
    
    <br>
    
    <div class="form" align="center">
      <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <?php
          if ($subtErr != "") {
            echo "<p class='fieldErr'>Bill subtotal: $</p>"; // input had an error
          }
          else {
            echo "Bill subtotal: &#36;"; // input is fine
          }
        
        ?>
        <!-- user inputs subtotal here -->
        <input type="text" name="subt" value="<?php echo $subtotal ?>"> 
      
        <br>
        <br>
      
        Tip Percentage:
        <br>
      
        <!-- creates the radio buttons for tip percentages -->
        <?php
          for ($p = 10; $p <=20; $p += 5) {
        ?>
            <input type='radio' name='option' 
              <?php if ( isset($percent) && $percent==$p) echo "checked"; ?>
            value="<?php echo $p ?>">
            <?php
              echo "$p" . "%";
          }
        ?>
      
      <br>
      <br>
      
      <!-- Creates submit button -->
      <input type="submit" name="submit" value="Submit">
      
    </form>
    
    <br>
    
    <div class="output" align="center">
      <?php 
        // prints error message if there is one
        if ($subtErr != "" && isset($_POST['submit'])) { 
      ?>
          <p class="resultErr">
            <?php echo $subtErr ?>
          </p>
      <?php
        }
        // otherwise print result
        else if ($subtErr == "" && isset($_POST['submit'])) { 
      ?>
          <p class="result">
            Tip: $
            <?php
              $tip = intval($percent)/100 * floatval($subtotal);
              echo number_format($tip, 2);
            ?>
            
            <br>
            
            Total: $
            <?php
              $total = $tip + floatval($subtotal);
              echo number_format ($total, 2); 
            ?>
          </p>
      <?php
        }
      ?>
    </div>

  </body>
</html>