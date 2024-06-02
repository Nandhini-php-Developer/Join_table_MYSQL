<html>
    <head>
        <title> two table insert </title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> insert table</title>
        <style>
              input[type=text],input[type=email],input[type=number], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

input[type=submit] {
  width: 100%;
  background-color: #048daa;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #45a049;
}

.form-div {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
  width: 40%;
}

#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #048daa;
  color: white;
}   
        </style>
    </head>
        <body>
        <div class="main-div">
        <form method="post" action="" >
        <h1> User Detais </h1>
        <div class="form-div">
        <form method="post" action="" >
            <label>  Name:</label>
            <input type="text" id="name" name="name" value=""><br>
            <label> Email: </label>
            <input type="email" id="email" name="email" value=""><br>
            <label> Age:</label>
            <input type="number" id="age" name="age" value=""><br>
            <label> Address: </label>
            <input type="text" id="address" name="address" value=""><br>
            <label> Phone: </label>
            <input type="text" id="phone" name="phone" value=""><br><br>
            <input type="submit" name="submit" value="submit">
        </form>
        </div>
            <?php

            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "details_test";
            
            $conn = new mysqli($servername, $username, $password, $database);
            
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }else{
                 //echo "database is connected user database name is " . $database;
            }

            
            //create table start
            $sql_tb1 =  'CREATE TABLE IF NOT EXISTS user (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL,
                age INT NOT NULL
            )';

            $sql_tb2 = 'CREATE TABLE IF NOT EXISTS user_details (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                address VARCHAR(255) NOT NULL,
                phone VARCHAR(20) NOT NULL,
                FOREIGN KEY (user_id) REFERENCES user(id)
            )';

            if (mysqli_query($conn, $sql_tb1)) {
                //echo "Table created successfully";
            }else {
                echo "Error creating table: " . mysqli_error($conn);
            }
            if (mysqli_query($conn, $sql_tb2)) {
                //echo "Table created successfully";
            }else {
                echo "Error creating table: " . mysqli_error($conn);
            }
            //create table end

            //INSERT PROCESS START

            if(isset($_POST['submit'])){
                $name=$_POST['name'];
                $email=$_POST['email'];
                $age=$_POST['age'];
                $addres=$_POST['address'];
                $phone_no=$_POST['phone'];
            if(!empty($name) && !empty($email))
            {
                $sql = "INSERT INTO user (name, email, age) VALUES ('$name' , '$email' , '$age')";
                
                if(mysqli_query($conn,$sql))
                {
                    $last_id = $conn->insert_id;
        
                    $user_id = $last_id;

                      //echo "new record successfully .last inserted id:". $last_id;
                      $sql_in = "INSERT INTO user_details (user_id, address, phone) VALUES ('$user_id' , '$addres' , '$phone_no')";
        
                      if (mysqli_query($conn, $sql_in)) {
                        //echo "Insert user details data successfullly";
                    }
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            }else{
                echo "fill all required";
            }
            
          }
            // SQL query to join User and UserDetails tables
            $sql = "SELECT user.id, user.name, user.email, user.age, user_details.address, user_details.phone 
            FROM user
            INNER JOIN user_details ON user.id = user_details.user_id";
        
            $result = $conn->query($sql);
            if ($result) {
            if($result->num_rows > 0){
                ?>
                <table id="customers">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NAME</th>
                            <th>EMAIL</th>
                            <th>AGE</th>
                            <th>ADDRESS</th>
                            <th>PHONE NUMBER</th>
                        </tr>
                    </thead>
                
                <?php
                while($row = $result->fetch_assoc()) {
                  
                    $id = $row['id'];
                    $name = $row['name'];
                    $email = $row['email'];
                    $age = $row['age'];
                    $address = $row['address'];
                    $phone_no = $row['phone'];
                    ?>
                    <tbody>
                        <tr>
                            <td><?php echo $id ?></td>
                            <td><?php echo $name ?></td>
                            <td><?php echo $email ?></td>
                            <td><?php echo $age ?></td>
                            <td><?php echo $address ?></td>
                            <td><?php echo $phone_no ?></td>
                            
                        </tr>
                    </tbody>
                  
                    <?php
                }
                ?>   
            </table> 
            <?php
            }
        }
          
        ?>
        </div>
        </body>
        </form>
        </html>