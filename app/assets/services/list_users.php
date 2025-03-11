<?php

if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['username'] !== 'admin') {
  header("Location: /Minifourchan");
}

$sql = "SELECT username, email, user_id FROM users ORDER BY user_id ASC";
$results = $conn->query($sql);

foreach ($results as $result){
  echo '<table>
          <tbody>
            <tr>
              <th width="30px">' . $result['user_id'] . '</th>
              <th width="100px">' . $result['username'] . '</th>
              <th width="200px">' . $result['email'] . '</th>
              <th>[<a href="?user=' . $result['username'] . '">View Posts</a>]</th>
              <th>[<a href="#a" user_id="' . $result['user_id'] . '" class="delBtn">Delete User</a>]</th>
            </tr>
          </tbody>
        </table>';
}
?>

<div class="overlay">
      <h1>Radera användare?</h1>
      <p>Vill du verkligen radera vald användare?</p>
      <button class="remove">Ja</button>
      <button class="close">Stäng</button>
    </div>
