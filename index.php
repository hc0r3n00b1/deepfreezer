<!doctype html>
<?php include 'db_connect.php'; ?>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
      <title>Deepfreeze!</title>
   </head>
   <body>
      <?php if(isset($_GET['msg'])) 
         echo '<div class="alert alert-dismissible fade show alert-secondary" role="alert">'.$_GET['msg'] .'<button type="button" href="index.php" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button></div>';
         ?>
      <div class="container mt-3">
         <h2>Deepfreeze Management System</h2>
         <br>
         <!-- Nav tabs -->
         <ul class="nav nav-tabs">
            <li class="nav-item">
               <a class="nav-link active" data-toggle="tab" href="#home">Current Inventory</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" data-toggle="tab" href="#menu3">Out Of Stock</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" data-toggle="tab" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Item</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" data-toggle="tab" href="#menu2">Manage Units</a>
            </li>
         </ul>
         <!-- Tab panes -->
         <div class="tab-content">
            <div id="home" class="container tab-pane active">
               <br>
               <h3>Manage Inventory</h3>
               <div class="container">
                  <table class="table">
                     <thead class="thead-dark">
                        <tr>
                           <th scope="col">Item Name</th>
                           <th scope="col">Qty</th>
                           <th scope="col">Add or Remove</th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr>
                           <?php
                              $sql = "SELECT *
                              FROM inventory
                              
                              INNER JOIN units ON inventory.unitID=units.unitID WHERE itemQty >= 1";
                              $result = $conn->query($sql); 
                              if (!empty($result) && $result->num_rows > 0) {
                                      while($row = $result->fetch_assoc()) {
                                      echo '<tr><td>'.$row['itemName'].'</td>
                                      <td>'.$row['itemQty'].'</td>
                                      <td>
                                          <form class="input-group" action="update.php" method="GET">
                                              <input id="itemID" name="itemID" type="hidden" value="'.$row['ID'].'">
                                              <button name="buttonPressed" value="minus" type="submit" class="btn btn btn-outline-dark">-</button>
                                              <input type="text" id="inventoryChange" name="inventoryChange" class="form-control" value="1">
                                              <div class="input-group-append">
                                                  <span class="input-group-text">'.$row['unitType'].'</span>
                                              </div>
                                              <button name="buttonPressed" value="plus" type="submit" class="btn btn btn-outline-dark">+</button>
                                          </form>
                                      </td><tr>';
                                      }
                                  } else {
                                      echo '<td align="center" colspan="3">No Records</td>';
                                  }
                              ?> 
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
               <div class="modal-dialog">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Item</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                     </div>
                     <div class="modal-body">
                        <table class="table">
                           <thead class="thead-dark">
                              <tr>
                                 <th scope="col">Item Name</th>
                                 <th scope="col">Qty</th>
                              </tr>
                           </thead>
                           <tbody>
                              <tr>
                                 <form class="input-group" action="addItem.php" method="GET">
                                    <td><input type="text" id="itemName" name="itemName" class="form-control"></td>
                                    <td><input type="text" id="initQty" name="initQty" class="form-control">
                                       <select class="form-select" id="inventoryType" name="inventoryType">
                                       <?php
                                          $result = $conn->query("SELECT * FROM units");
                                          if ($result->num_rows > 0) {
                                              while($row = $result->fetch_assoc()) {
                                                  unset($id, $name);
                                                  $id = $row['unitID'];
                                                  $unitType = $row['unitType']; 
                                                  echo '<option value="'.$id.'">'.$unitType.'</option>';
                                              }
                                          } else {
                                                  echo '<option selected="selected" disabled>No Units Found, Please add Unit Type</option>';
                                          }
                                          ?> 
                                       </select>
                                    </td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                     <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                     <button type="submit" class="btn btn-primary">Add</button>
                     </form>
                     </div>
                  </div>
               </div>
            </div>
            <div id="menu2" class="container tab-pane fade">
               <br>
               <h3>Manage Units</h3>
               <div class="container">
                  <table class="table">
                     <thead class="thead-dark">
                        <tr>
                           <th scope="col">Unit Name</th>
                           <th scope="col">Add/Delete</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                           $sql = "SELECT * FROM units";
                           $result = $conn->query($sql);
                           if (!empty($result) && $result->num_rows > 0) {
                               echo '<form class="input-group" action="unitUpdate.php" method="GET"><tr>
                               <td>'.$row['unitType'].'</td>
                               <td>
                               <input id="ID" name="ID" type="hidden" value="'.$row['unitID'].'">
                               <button type="submit" class="btn btn btn-outline-dark">-</button></td>
                               </tr></form>';
                               }
                               ?>
                     </tbody>
                     <tbody>
                        <form class="input-group" action="unitAdd.php" method="GET">
                           <tr>
                              <td>
                                 <input class="form-control" type="text" id="unitName" name="unitName">
                              </td>
                              <td>
                                 <button type="submit" class="btn btn btn-outline-dark">+</button>
                              </td>
                           </tr>
                        </form>
                     </tbody>
                  </table>
               </div>
            </div>
            <div id="menu3" class="container tab-pane fade">
               <br>
               <h3>Out Of Stock</h3>
               <div class="container">
                  <table class="table">
                     <thead class="thead-dark">
                        <tr>
                           <th scope="col">Item Name</th>
                           <th scope="col">Qty</th>
                           <th scope="col">Add or Remove</th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr>
                           <?php
                              $sql = "SELECT *
                              FROM inventory
                              
                              INNER JOIN units ON inventory.unitID=units.unitID
                              WHERE itemQty <= 0
                              ";
                              $result = $conn->query($sql);
                              
                              if (!empty($result) && $result->num_rows > 0) {
                                      while($row = $result->fetch_assoc()) {
                                      
                                      echo '<tr><td>'.$row['itemName'].'</td>
                                      <td>'.$row['itemQty'].'</td>
                                      <td>
                                          <form class="input-group" action="update.php" method="GET">
                                              <input id="itemID" name="itemID" type="hidden" value="'.$row['ID'].'">
                                              <input type="text" id="inventoryChange" name="inventoryChange" class="form-control" value="1">
                                              <div class="input-group-append">
                                                  <span class="input-group-text">'.$row['unitType'].'</span>
                                              </div>
                                              <button name="buttonPressed" value="plus" type="submit" class="btn btn btn-outline-dark">+</button>
                                              <button name="buttonPressed" value="delete" type="submit" class="btn btn btn-outline-dark">Delete Item</button>
                                          </form>
                                      </td><tr>';
                                      }
                                  } else {
                                      echo '<td align="center" colspan="3">No Records</td>';
                                  }
                              ?> 
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
      <script>
         $(document).ready(function(){
         
         var uri = window.location.toString();
         
         if (uri.indexOf("?") > 0) {
         
         var clean_uri = uri.substring(0, uri.indexOf("?"));
         
         window.history.replaceState({}, document.title, clean_uri);
         
         }
         
         });
      </script>
   </body>
</html>