<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "little_leap";
$server_url='http://localhost/littleleap';


/*$servername = "littleleap.ci3mr64wtnk1.ap-south-1.rds.amazonaws.com";
$username = "admin";
$password = "littleleap$1234";
$dbname = "little_leap";
$server_url='https://littleleap.co.in';*/
$utm='';
if(isset($_GET['utm']))
{
$utm=$_GET['utm'];
// die;
}

if(isset($_POST['find_zoom_link']) && isset($_POST['demo_slot_time'])!='')
{
    $parent_name=$_POST['parent_name'];
    $parent_mobile=$_POST['parent_mobile'];
    $parent_email=$_POST['parent_email'];
    $childname=$_POST['child_name'];
    $age=$_POST['demo_slot_date'];
    $timeslot=$_POST['demo_slot_time'];
    $url = $server_url."/admin/api/finddemoclasslink";
//The data you want to send via POST
    $fields = [
    'parent_name'        => $parent_name,
    'parent_mobile'      => $parent_mobile,
    'parent_email'       =>$parent_email,
    'child_name'         =>$childname,
    'age'                =>$age,
    'timeslot'           =>$timeslot,
             ];
    //url-ify the data for the POST
    $fields_string = http_build_query($fields);
    //open connection
    $ch = curl_init();
    //set the url, number of POST vars, POST data
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST, true);
    curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
    $result = curl_exec($ch);
    $thankyou = "Thank you! We have received your booking. In case if you want to register for another child, please fill the form again or go back to home page.";
    $utm=$utm;

}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// echo "Connected successfully";


    
// $sql = "SELECT * FROM demo_class_slots order by slot_date DESC";

   $sql = "SELECT `zoom_link_schedule`.* FROM `zoom_link_schedule` LEFT JOIN `zoom_link_url` on `zoom_link_schedule`.`id`=`zoom_link_url`.`zoomid` where `zoom_link_url`.`is_assign`='not_done' group by `zoom_link_schedule`.`date_of_zoom_slot`";

$result = $conn->query($sql);

// print_r($result);
$zoomLinkDates=[];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // print_r($row);
        if(!in_array($row['date_of_zoom_slot'], $zoomLinkDates))
        {
            $zoomLinkDates[]=$row['date_of_zoom_slot'];
        }
    }
}

// print_r($zoomLinkDates);


$sql = "SELECT * FROM demo_class_slots";
$result = $conn->query($sql);
$slotedate=[];
$dataSlot=[];
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    // print_r($row['slot_date'] );

    $slot_avaliable=false;
    if(in_array($row['slot_time1'],$zoomLinkDates))
    {
        $slot_avaliable=true;
    }
    else{
        $row['slot_time1']='';  
    }

    if(in_array($row['slot_time2'], $zoomLinkDates))
    {
        $slot_avaliable=true;        
    }
    else{
        $row['slot_time2']='';  
    }

    if(in_array($row['slot_time3'], $zoomLinkDates))
    {
        $slot_avaliable=true;        
    }
    else{
        $row['slot_time3']='';  
    }

    if(in_array($row['slot_time4'], $zoomLinkDates))
    {
        $slot_avaliable=true;        
    }
    else{
        $row['slot_time4']='';  
    }

    if(in_array($row['slot_time5'], $zoomLinkDates))
    {
        $slot_avaliable=true;        
    }
    else{
        $row['slot_time5']='';  
    }

    if(in_array($row['slot_time6'], $zoomLinkDates))
    {
        $slot_avaliable=true;        
    }
    else{
        $row['slot_time6']='';  
    }

    if($slot_avaliable)
    {        
        $slotdate[]=$row['slot_date'];
        $dataSlot[$row['slot_date']]=$row;
    }
    // echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
  }
} else {
    echo "0 results";
}



$utm='';
if(isset($_GET['utm']))
{
$utm=$_GET['utm'];
// die;
}
$conn->close();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Little Leap</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    
    <!-- Fontawesome icon link -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" >

    <!-- Style CSS -->
    <link href="assets/css/style.css" rel="stylesheet">

</head>


<body>
    
    <main>

    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-12 brand-logo">
                    <a href="#"><img src="assets/images/little-leap.png"></a>
                </div>
            </div>
        </div>
    </div>

    
    
    <div class="container-fluid">
        <div class="container">
            <div class="row section1 align-items-center">
                <div class="col-md-7 d-md-block d-none">
                    <h1 class="font-poppins font-weight-700">Book an online class to empower your child with <span class="green-color">Valuable Foundational Skills</span></h1>
                    <ul>
                        <li>
                            <div class="icon-area">
                                <img src="assets/images/icon-1.png">
                            </div>
                            <div class="text-area">
                                <h2 class="font-poppins">Experience a unique curriculum</h2>
                                <p class="font-poppins">A unique continuous learning plan to build communication skills, confidence, creativity, critical thinking and leadership skills</p>
                            </div>
                        </li>
                        <li>
                            <div class="icon-area">
                                <img src="assets/images/icon-2.png">
                            </div>
                            <div class="text-area">
                                <h2 class="font-poppins">True active learning</h2>
                                <p class="font-poppins">Our focus is on learning through interaction, participation and activity-based programs</p>
                            </div>
                        </li>
                        <li>
                            <div class="icon-area">
                                <img src="assets/images/icon-3.png">
                            </div>
                            <div class="text-area">
                                <h2 class="font-poppins">Spend an hour with our expert educators</h2>
                                <p class="font-poppins">Trainers will spend 50 mins with children and 10 mins with parents to share insights on each child’s development</p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-md-7 d-md-none d-sm-block">
                    <h1 class="font-poppins font-weight-700">Book an online class to empower your child with <span class="green-color">Valuable Foundational Skills</span></h1>
                </div>
                <div class="col-md-5 justify-content-center py-3 form-container">


                    <div class="error" style="display: none;">
                      <div class="alert alert-danger alert-dismissible alert-fixed">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <div class="error-text"></div>
                      </div>
                    </div>  


                    <form class="row form-section" id="leadform" name="addVendorfrm" enctype="multipart/form-data" action="<?php echo $server_url;?>/book-a-free-demo/thankyou/" method="POST">

                            <?php if(isset($thankyou))
                            {
                                ?>
                            <div class="success">
                              <div class="alert alert-success alert-dismissible alert-fixed">
                                <!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> -->
                                <div class="success-text">
                                    <?php
                                    $thankyou="Thank You! We’ve received your booking! We’ll be sending the details on your Email and Mobile.";
                                    echo $thankyou; 
                                    ?>
                                    <br/>
                                    <br/>
                                    <?php
                                    echo "In case you want to register for another child, request you to please fill the form again.";
                                    ?>
                                </div>
                              </div>
                            </div>
                            <?php 
                            ?>  
                            <div class="text-center">
                                <a href='' class='book-btn-green bookforanotherchild'>Book for Another Child</a>
                            </div>
                            <div class="text-center">
                                <a class='book-btn-green' href='https://littleleap.co.in/'>Go to Home Page <i class="fa fa-home"></i> </a>                                
                            </div>

                            <?php
                            }
                            else
                            {
                             ?>   



                            <?php
                            $utm = '';
                            if(!empty($_GET['utm'])){
                                $utm = $_GET['utm'];
                            }
                            ?>
                        <input type="hidden" name="utm" value="<?php echo $utm; ?>">

                         <!-- @csrf -->
                        <div class="col-12">
                            <h2 class="font-poppins">Book a Free Demo Class Today!</h2>
                        </div>
                        <div class="col-12">
                            <input type="text" name="parent_name" id="name" placeholder="Parent's Name" required="required">
                        </div>
                        <div class="col-3 pr-0">
                            <select>
                                <option>+91</option>
                                <option>+91</option>
                            </select>
                        </div>
                        <div class="col-9 ">
                            <input type="tel" name="parent_mobile" id="phone" placeholder="Contact No"  maxlength="10" minlength="10" required="required">
                        </div>
                        <div class="col-12">
                            <input type="email" name="parent_email" id="email" placeholder="Email ID (Optional)">
                        </div>
                        <div class="col-12">
                            <input type="text" name="child_name" id="cname" placeholder="Child Name" required="required" >
                        </div>
                        <div class="col-12 ">
                            <select class="form-control" name="demo_slot_date" id="demo_slot_date" required>
                                <option value="">Select Child Age</option>
                                 <?php  foreach($slotdate as $value)
                                 {
                                    echo '<option value="'.$value.'">'.$value.'</option>';                                     
                                 }
                                ?>                                
                            </select>
                        </div>
                        <div class="col-12">                            
                            
                            <div id="demo_slot_time_radio">
                                
                            </div>

                            
                        </div>
                        <div class="col-12 text-center">
                            <p>Get important updates on WhatsApp, Email &amp; SMS</p>
                            <button type="submit" id="submit">Book a Free Demo Class</button>
                            <p>By proceeding, you agree to our <a href="#">Terms & Conditions</a></p>
                        </div>
                        <input type="hidden" name="find_zoom_link" value="1">
                    </form>
                    <?php
                    }
                    ?>
                </div>


                <div class="col-md-7 d-md-none d-sm-block">
                    <ul>
                        <li>
                            <div class="icon-area">
                                <img src="assets/images/icon-1.png">
                            </div>
                            <div class="text-area">
                                <h2 class="font-poppins">Experience a unique curriculum</h2>
                                <p class="font-poppins">A unique continuous learning plan to build communication skills, confidence, creativity, critical thinking and leadership skills</p>

                                <!-- <p class="font-poppins">A unique continuous learning plan to build <span>communication skills, confidence, creativity, critical thinking</span> and <span>leadership skills</span></p> -->
                            </div>
                        </li>
                        <li>
                            <div class="icon-area">
                                <img src="assets/images/icon-2.png">
                            </div>
                            <div class="text-area">
                                <h2 class="font-poppins">True active learning</h2>
                                <p class="font-poppins">Our focus is on learning through interaction, participation and activity-based programs</p>
                            </div>
                        </li>
                        <li>
                            <div class="icon-area">
                                <img src="assets/images/icon-3.png">
                            </div>
                            <div class="text-area">
                                <h2 class="font-poppins">Spend an hour with our expert educators</h2>
                                <p class="font-poppins">Trainers will spend 50 mins with children and 10 mins with parents to share insights on each child’s development</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="container section2">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="font-poppins font-weight-700">Why 100,000+ Parents Love Little Leap?</h1>
                </div>
            </div>
            <div class="row section2in align-items-center justify-content-center">
                <div class="col-md-5">
                    <div class="img-area">
                        <img src="assets/images/1.png" width="100%">
                    </div>
                </div>
                <div class="col-md-5 py-4">
                    <div class="text-area">
                        <h2 class="font-poppins">Development Expertise with a Team of Child Psychologists</h2>
                        <p class="font-poppins">Your children will have an exclusive chance to learn with child experts qualified, experienced and trained in skill development</p>
                    </div>
                </div>
            </div>
            <div class="row section2in align-items-center justify-content-center">
                <div class="col-md-6 d-md-none d-sm-block">
                    <div class="img-area">
                        <img src="assets/images/2.png" width="100%">
                    </div>
                </div>
                <div class="col-md-5 py-4">
                    <div class="text-area nopadd">
                        <h2 class="font-poppins">Visible Improvements<br>and Learnings</h2>
                        <p class="font-poppins">You will be able to see definite enhancement and constant upgrade in your child’s skill levels</p>
                    </div>
                </div>
                <div class="col-md-5 d-md-block d-none">
                    <div class="img-area">
                        <img src="assets/images/2.png" width="100%">
                    </div>
                </div>
            </div>
            <div class="row section2in align-items-center justify-content-center">
                <div class="col-md-5">
                    <div class="img-area">
                        <img src="assets/images/3.png" width="100%">
                    </div>
                </div>
                <div class="col-md-5 py-4">
                    <div class="text-area">
                        <h2 class="font-poppins">Super Fun and<br>Engaging Sessions</h2>
                        <p class="font-poppins">Your children will love and will ask you to attend more and more Little Leap Sessions</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid section3">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="font-poppins text-white font-weight-700">Happy Children, Happy Parents</h1>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-8 pt-5">

                    <!-- <iframe width="100%" height="500" src="https://www.youtube.com/embed/TEbL0eze6u8?controls=0?rel=0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
                    <div class="video-container">
                        <div class="js-video ng-isolate-scope" >
                            <div class="video-poster"></div>
                            <div class="black-overlay"></div>
                            <div class="video-text">
                                <h2 class="font-poppins">How's our program working out for your child?</h2>
                            </div> 
                            <!-- <div class="play"><i class="fas fa-play"></i></div>  -->
                            <iframe width="100%" class="video" height="529" src="https://www.youtube.com/embed/TEbL0eze6u8?autoplay=0" frameborder="0" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-10">
                    <div class="w-100 review-area">
                        <img src="assets/images/coma.svg" class="icon-review">
                        <div class="text-area">
                            <h2 class="font-arvo">Reach high, for stars lie hidden in your soul.<br>Dream deep, for every dream precedes the goal.</h2>
                        </div>
                        <div class="author">
                            <p>- Pamela Vaull Starr</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid section5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <a href="#" class="book-btn">Book a Free Demo Class</a>
                </div>
            </div>
        </div>
    </div>


    <footer class="container-fluid footer-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-3">
                    <div class="col-12 brand-logo">
                        <a href="#"><img src="assets/images/little-leap-white-logo.png"></a>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="footer-line">
                        India's first comprehensive platform to build foundational skills that shape your child's future                        
                    </div> 
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-12 copywrite text-center">
                    <p>© 2021 Holistic Minds Private Limited</p>
                </div>
            </div>
        </div>
    </footer>

    
    </main>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
    
<script>
var slots={};
<?php 
// print_r($dataSlot);
// die;
foreach ($dataSlot as $key => $slot) {
    echo 'slots["'.$slot["slot_date"].'"]={slot_time1:"'.$slot["slot_time1"].'",slot_time2:"'.$slot["slot_time2"].'",slot_time3:"'.$slot["slot_time3"].'",slot_time4:"'.$slot["slot_time4"].'",slot_time5:"'.$slot["slot_time5"].'",slot_time6:"'.$slot["slot_time6"].'"};';
}

?>
console.log(slots);


APP_BASE_URL = "{{url('/')}}"
jQuery(document).ready(function() {

    jQuery("#demo_slot_date").change(function(event){

        var slot_date = $(this).val();

        //console.log(slots[slot_date]);        
        var time='<p>Choose Demo Class Slot Below-</p>';
        $.each( slots[slot_date], function( key, value ) {
            if(value.trim()){
                // alert(value);
                time+= '<div class="box demo_slot_time_radio">\
                <input id="'+key+'" type="radio" name="demo_slot_time"  required="required" value="'+value+'">\
                    <span class="check"></span>\
                    <label for="'+key+'">'+value+'</label>\
                </div>'
            }

            // alert( key + ": " + value );
        });                            
        
        $('#demo_slot_time_radio').html(time)


    });

    jQuery('.play i').click(function(event){
    event.preventDefault();
    //var url = $(this).html(); //this will not work    
    $(".js-video").append('<iframe width="100%" height="529" src="https://www.youtube.com/embed/TEbL0eze6u8?autoplay=1" frameborder="0" allowfullscreen></iframe>');
        $(this).hide();
        //$('video-poster').css('z-index','-1');
        
    });

    $('.bookforanotherchild').click(function(){

        window.location.reload;
    })
});

</script>


<script type="text/javascript">
    jQuery(document).ready(function(){
        $('#leadform').submit(function(){
        });

    })
</script>



</body>
</html>