<?php 
session_start();
 if(!isset($_SESSION['userdata'])){
    header("location: ../")
 }

 
 $userdata = $_SESSION['userdata'];
 $groupsdata = $_SESSION['groupsdata'];

 if($_SESSION['status'])==0{
    $status = '<b style="color:red">Not Voted</b>';
 }
 else{
    $status = '<b style="color:green">Voted</b>';
 }
?>

<html>
    <head>
        <title>Online Voting System - Dashboard</title>
        <link rel="stylesheet" href="../css/stylesheet.css">
    </head>
    <body>
    <style>
        #backbtn{
            padding: 5px;
            font-size: 15px;
            background-color: #3498db;
            color: white;
            border-radius: 5px;
            float: left;
            margin: 15px;
        }

        #logoutbtn{
            padding: 5px;
            font-size: 15px;
            background-color: #3498db;
            color: white;
            border-radius: 5px;
            float: right;
        }

        #Profile{
            background-color: white;
            width: 30%;
            padding: 20px;
            float: left;
        }

        #Group{
            background-color:white;
            width: 60%;
            padding: 20px;
            float: right;
        }

        #votebtn{
            padding: 5px;
            font-size: 15px;
            background-color: #3498db;
            color: white;
            border-radius: 5px;
        }

        #mainSection{
            padding: 10px;
        }

        #mainpanel{
            padding: 10px;
        }

        #voted{
            padding: 5px;
            font-size: 15px;
            background-color: green;
            color: white;
            border-radius: 5px;
        }


    </style>

    <div id="mainSection">
        <center>
        <div id="headerSection">
            <button id="backbtn"><a href="../"></a>Back</button>
            <button id="logoutbtn"><a href="logout.php"><button id="logoutbtn">Logout</button></a>Logout</button>
            <h1>Online Voting System</h1>
        </div>
        </center>
        <hr>

        <div id="mainpanel">

        </div>
        <div id="mainpanel">
        <div id="profile">
            <img src="../uploads/<?php echo $userdata['photo'] ?>" height="100" width="100">
            <b>Name:</b> <?php echo $userdata['name']?> <br><br>
            <b>Mobile:</b> <?php echo $userdata['mobile']?> <br><br>
            <b>Address:</b><?php echo $userdata['address']?><br><br>
            <b>Status:</b><?php echo $userdata['status']?><br><br>
        </div>

        <div id="Group">
            <?php 
            if($_SESSION['groupsdata']){
                for ($i=0; $i<count($groupsdata); $i++){
                 ?>
                 <div>
                    <img style="float: right" src="../uploads/<?php echo $groupsdata[$i]['photo']?>" height="100" width="100">
                    <>Group Name: </b> <?php echo $groupsdata[$i]['name']?> <br><br>
                    <b>Votes: </b> <?php echo $groupsdata[$i]['votes']?> <br><br>
                    <form action="../api/vote.php" method="POST">
                        <input type="hiddenn" name="gvotes" value=" <?php echo $groupsdata[$i]['votes'] ?>">
                        <input type="hiddenn" name="gid" value=" <?php echo $groupsdata[$i]['id'] ?>">
                         <?php {
                         if($_SESSION['userdata']['status']==0)
                            ?>
                            <input type="submit" name="votebtn" value="Vote" id="votebtn">
                            <?php
                         }
                         else{
                         ?>
                        <button disabled type="submit" name="votebtn" value="Vote" ></button></button>
                        <?php 
                        }
                        ?>
                    </form>
                 </div>
                 <hr>
                 <?php
                }
            }
            else{

            }
            ?>

        </div>
        </div>

        


    </div>

    </body>
</html>