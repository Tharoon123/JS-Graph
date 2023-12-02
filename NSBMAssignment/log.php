<html>
    <head>
        <title>
                Home Page
        </title>
        <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="my2.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    </head>
    <body>
        
        <?php        
        session_start();
        $Uname=$_POST["un"];
        $pass=$_POST["pw"];


        $dbhost="localhost";
        $dbuser="root";
        $pw="";
        $dbname="sensor_db";

        
        $conn=new PDO("mysql:host=$dbhost; dbname=$dbname",$dbuser,$pw);
        
        if($conn){
            //echo "connection Success";
            $sql="SELECT * FROM login";
            $query = $conn->prepare($sql);
            $query->execute();
            while($fetch = $query->fetch()){
                $admin[]=array(
                    'idnum'	=> $fetch['id'],
                    'userName'	=> $fetch['user'],
                    'pw'	=> $fetch['pw']
                );
            }
                        
            $jEncode=json_encode($admin);
            //echo $jEncode;
            $name=$admin[0]['userName'];
            $pw=$admin[0]['pw'];
            
            

        ?>
        <br>
            <center>
                <h1 id="dash">
                    <b>
                        Dashboard
                    </b>
                </h1>
            </center>
        
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <br>
                    <br>
                    <br>
                    
                <?php
                        if ($name==$Uname && $pw==$pass){
                            ?>
                            <script>
                                window.alert("Login SuccessFul");
                            </script>
                            <?php
                            
                            
                            $sql2="SELECT * FROM data_value";
                            $stmt=$conn->prepare($sql2);
                            $stmt->execute();

                            $result=$stmt->fetchAll();
                            if($result){
                                //echo "Table OK";
                                $maxsql=$conn->prepare("SELECT MAX(id) from data_value");
                                //$stmtMax=$conn->prepare($maxsql);
                                $maxsql->execute();
                                $resultMax=$maxsql->fetch();

                                echo $resultMax[0], "<br>";

                                /*$resultid []=array();
                                $idset=$conn->prepare("SELECT 'id' from data_value");
                                $idset->execute();
                                $resultid=$idset->fetchAll();
                                var_dump($resultid);
                                
                                for($y=0; $y<$resultMax[0]; $y++){
                                    echo $resultid[$y];
                                    
                                    if($y==$resultid[$y]['id']){
                                        echo "Yes";
                                    }else{
                                        echo "No";
                                    }
                                }*/

                                $temp[] =array();
                                $hum[] =array();
                                $time[] =array();

                                for($x=0; $x<$resultMax[0]; $x++){
                                    //echo $x;

                                    $temp[$x]=$result[$x]['temp'];
                                    $hum[$x]=$result[$x]['hum'];
                                    $time[$x]=$result[$x]['dateTime'];
                                    
                                    //var_dump($temp[$x]);

                                    

                                }
                                
                                ?>
                                <h1>
                                    Tempurature and Date Graph
                                </h1>
                                <canvas id="myChartTemp" style="width:100%;max-width:700px"></canvas>
                                <br>
                                <br>
                                <canvas id="myChartTempPie" style="width:100%;max-width:700px"></canvas>
                                
                                <script>
                                    
                                    //Table for the Tempurature
                                    const xValues = ["<?php 
                                        for($x=0; $x<$resultMax[0]; $x++){
                                            echo $time[$x];

                                        
                                             
                                    ?>","<?php

                                            //echo $time[$x]; 
                                    
                                    }?>"];

                                    const yValues = [<?php 
                                        for($x=0; $x<$resultMax[0]; $x++){
                                        echo $temp[$x]; 

                                    ?>, <?php 
                                        //echo $temp[$x]; 

                                        }?>];
                                    const barColors = ["red", "green","blue","orange","brown","red", "green","blue","orange","brown"];

                                    new Chart("myChartTemp", {
                                    type: "bar",
                                    data: {
                                        labels: xValues,
                                        datasets: [{
                                        backgroundColor: barColors,
                                        data: yValues
                                        }]
                                    }
                                    });
                                    
                                    new Chart("myChartTempPie", {
                                    type: "line",
                                    data: {
                                        labels: xValues,
                                        datasets: [{
                                        backgroundColor: barColors,
                                        data: yValues
                                        }]
                                    }
                                    });
                                </script>
                                <br>
                                <br>
                        
                </div>
               
                <div class="col-md-6">
                <br>
                <br>
                <h1>
                    Humidity and Date Graph
                </h1>
                <br>
                    
                                
                    <canvas id="myChartHum" style="width:100%;max-width:700px"></canvas>
                    <br>
                    <br>
                    <canvas id="myChartHumPie" style="width:100%;max-width:700px"></canvas>
                                
                                <script>

                                    //Table for Humidity 
                                    
                                    var xValues1 = ["<?php
                                            for($x=0; $x<$resultMax[0]; $x++){    
                                                echo $time[$x]; 
                                    ?>","<?php 
                                                //echo $time[$x]; 
                                            }?>"];
                                    var yValues1 = [<?php 
                                        for($x=0; $x<$resultMax[0]; $x++){
                                            echo $hum[$x]; 
                                    ?>, <?php 
                                        //echo $hum1; 
                                        }?> ];
                                    var barColors1 = ["red", "green","blue","orange","brown","red", "green","blue","orange","brown"];

                                    new Chart("myChartHum", {
                                    type: "bar",
                                    data: {
                                        labels: xValues1,
                                        datasets: [{
                                        backgroundColor: barColors1,
                                        data: yValues1
                                        }]
                                    }

                                    });

                                    new Chart("myChartHumPie", {
                                    type: "line",
                                    data: {
                                        labels: xValues1,
                                        datasets: [{
                                        backgroundColor: barColors1,
                                        data: yValues1
                                        }]
                                    }

                                    });

                                </script>
                                <br>
                                <br>
                                
                                <?php

                            }else{
                                echo "Table Error";
                            }
                            
                            ?>
                            
                        <?php
                        }else{  
                            ?>
                            <script>

                                window.alert("Login Error");
                                
                            </script>
                            <form method="post" action="Login.html">
                                <input type="submit" value="Login Page">
                            </form>

                            <?php
                            
                            //echo "<h2 id='error'>","Login Failed","</h2>";
                        }
                    
                    }else{
                        echo "Error";
                    }

                    ?>
                    
                    <form>
                        
                    </form>
                </div>
            </div>
        </div>
        <br>
        <br>
        <br>
        <!--<center>
            <form method="post" action="#">
                <input type="submit" value="Refresh Tables">
            </form>
        </center>-->
    </body>
</html>

