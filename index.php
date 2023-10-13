<?php   

    $server = '127.0.0.1';
    $username ='root';
    $password = '';
    $database = 'php';

    $conn = mysqli_connect($server,$username,$password,$database);
    
    if($conn->connect_errno){
        die('connection to MySQL failed : '.$conn->connect_error);
    }

    //creating item
    if(isset($_POST['add'])){
        $item = $_POST['item'];
        if(!empty($item)){
            $query="insert into todo (name) values ('$item')";
            if(mysqli_query($conn,$query)){
                echo '
                <center>
                    <div class="alert alert-info" role="alert">
                        Item added successfully
                    </div>
                </center>
                ';
            }
            else{
                echo mysqli_error($conn);
            }
        }
    }

    //mark as read
    if(isset($_GET['action'])){
        $itemId = $_GET['item'];
        if($_GET['action'] == 'done'){
            $query="update todo set status = 1 where id='$itemId'";
            if(mysqli_query($conn,$query)){
                echo '
                <center>
                    <div class="alert alert-success" role="alert">
                        Item marked as done
                    </div>
                </center>
                ';
            }
            else{
                echo mysqli_error($conn);
            }
        }
        elseif($_GET['action'] == 'delete'){
            $query = "delete from todo where id='$itemId'";
            if(mysqli_query($conn,$query)){
                echo '
                <center>
                    <div class="alert alert-danger" role="alert">
                        Item deleted successfully
                    </div>
                </center>
                ';
            }
            else{
                echo mysqli_error($conn);
            }
        }
    }
    

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Todo list Application</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <style>
            .done{
                text-decoration: line-through;
            }
        </style>
    </head>
    <body>
        <main>
            <div class="container pt-5">
                <div class="row">
                    <div class="col-sm-12 col-md-3"></div>
                        <div class="col-sm-12 col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <p><b>Todo List</b></p>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="<?=$_SERVER['PHP_SELF']?>">
                                        <div class="mb-3">
                                            <input type="text" class="form-control" name="item" placeholder="Add a item">
                                        </div>
                                        <input type="submit" class="btn btn-dark" name="add" value="Add Item">
                                    </form>
                                    <div class="mt-5 mb-5">
                                        
                                        <?php
                                            $query = "select * from todo";
                                            $result = mysqli_query($conn,$query);
                                            if($result->num_rows>0){
                                                $i = 1;
                                                while($row = $result->fetch_assoc()){
                                                    $done = $row['status'] == 1 ? "done" : "";                                                   
                                                echo '
                                                <div class="row mt-4">
                                                    <div class="col-sm-12 col-md-1"><h5>'.$i++.'.</h5></div>
                                                        <div class="col-sm-12 col-md-6"><h5 class="'.$done.'">'.$row['name'].'</h5></div>
                                                            <div class="col-sm-12 col-md-5">
                                                            <a href="?action=done&item='.$row['id'].'" class="btn btn-outline-dark">Mark as done</a>
                                                            <a href="?action=delete&item='.$row['id'].'" class="btn btn-outline-danger">Delete</a>
                                                         </div>
                                                    </div> 
                                                    ';
                                                }
                                            }
                                            else{
                                                echo '
                                                <center>
                                                    <img src="to-do-list.png" width="50px" alt="Empty List">
                                                    <br>
                                                    <span>Your list is empty</span>
                                                </center>
                                                ';
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(){
            $(".alert").fadeTo(5000,500).slideUp(500,function(){
                $('.alert').slideUp(500);
            })
        })
    </script>    
</body>
</html>