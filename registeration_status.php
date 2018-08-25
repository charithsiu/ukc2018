<?php
$emailTemplate = "";

function checkStatus($registraionid){
    global $emailTemplate;

    $output_status=''; 
     if ( !defined('ABSPATH') )
     define('ABSPATH', dirname(__FILE__) . '/');
     require_once(ABSPATH . 'wp-config.php');
     $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);
     mysqli_select_db($connection, DB_NAME);
 
     if (!$connection)
     {
         echo "<script>alert('Failed to connect to MySQL:" . mysqli_connect_error()."');</script>";
         die("Connection failed: " . mysqli_connect_error());
     }
    
     //$sql1 = "SELECT reg_date FROM wp_registration_list WHERE registration_id='$registraionid' AND isDelete=0";
     $sql1 = 'SELECT member_type_field as "Member Type",
     IF(membership_fee_status_field = "1","Paid Member","Non Paid Member") as "Membership Fee Status",
     membership_fee_status_field as "Membership Fee Status",
     first_name_field as "First Name",
     last_name_field as "Last Name",
     organization_field as "Organization",
     position_title_field as "Position/Title",
     street_address_field as "Street",
     city_field as "City",
     state_field as "State",
     zip_field as "ZIP",
     country_field as "Country",
     gender_field as "Gender",
     ksea_email_field as "KSEA Email",
     valid_waive_code_field as "Waiver Code",
     is_easychair_email_valid_field as "Oral/Poster Presentation",
      CASE
       WHEN lodging_location_field = 0 THEN "Outside hotels"
       WHEN lodging_location_field = 1 THEN "St. Johns University"
       ELSE "For plenary speakers, Tech Talks, VIP, sponsors, &  former presidents "
       END as "Lodging Location",
       check_in_field as "check_in",
     CONCAT(check_out_field
     ,check_out_2_field
     ,check_out_3_field
     ,check_out_4_field
     ,check_out_5_field
     ,check_out_6_field) AS "Checkout Date",
     number_of_adults_field as "Number of Adults",
     CONCAT(number_of_children_field
     ,number_of_children_2_field
     ,number_of_children_3_field
     ,number_of_children_4_field
     ,number_of_children_5_field) as "Number of Children",
     single_occupancy_field as "Single Occupnacy",
     single_occupancy_sharing_field as "Single Roommate",
     single_roommate_first_name_field as "Single Roommate First Name",
     single_roommate_last_name_field as "Single Roommate Last Name",
     single_roommate_gender_field as "Single Roommate Gender",
     single_roommate_email_field as "Single Roommate Email",
     couple_occupancy_field as "Couple Occupancy",
     couple_occupancy_sharing_field as "Couple Roommate",
     couple_roommate_first_name_field as "Couple Roommate First Name",
     couple_roommate_last_name_field as "Couple Roommate Last Name",
     couple_roommate_gender_field as "Couple Roommate Gender",
     couple_roommate_email_field as "Couple Roommate Email",
     concat(family_occupancy1_field
     ,family_occupancy2_field) as "Family Occupancy",
     family_occupancy_sharing_field as "Family Occupancy Roommate",
     family_roommate_first_name_field as "Family Occupancy Roommate First Name",
     family_roommate_last_name_field as "Family Occupancy Roommate Last Name",
     family_roommate_gender_field as "Family Occupancy Roommate Gender",
     family_roommate_email_field as "Family Occupancy Roommate Email",
     price_per_night_field as "Price Per Night",
     number_of_nights_field as "Number of Nights",
     number_of_people_field as "Number of People",
     lodging_amount_field as "Lodging Amount",
     linen_storm_card_cost_field as "Linen/Storm Card",
     total_lodging_amount_field as "Total Lodging Amount",
     lodging_fee_final_field as "Lodging after Waiver",
     thursday_lunch_a_count_field as "Thursday Lunch A",
     thursday_lunch_b_count_field as "Thursday Lunch B",
     thursday_lunch_c_count_field as "Thursday Lunch C",
     friday_lunch_a_count_field as "Friday Lunch A",
     friday_lunch_b_count_field as "Friday Lunch B",
     friday_lunch_c_count_field as "Friday Lunch C",
     saturday_lunch_a_count_field as "Saturday Lunch A",
     saturday_lunch_b_count_field as "Saturday Lunch B",
     saturday_lunch_c_count_field as "Saturday Lunch C",
     lunch_total_field as "Lunch Total",
     thursday_dinner_count_field as "Thursday Dinner (Adult)",
     num_of_bbq_children_field as "Num of BBQ Children",
     thursday_dinner_total_field as "Thursday Dinner Total",
     thursday_dinner_count_with_waiver_code as "Thursday Dinner waiver Total",
     friday_dinner_cruise_count_field as "Friday Dinner Cruise (Adult)",
     num_of_cruise_children_field as "Num of Cruise Children",
     friday_dinner_cruise_count_with_waiver_code as "Friday Dinner with waiver Total",
     friday_dinner_total_field as "Friday Dinner Cruise Total",
     dinner_total_field as "Dinner Total",
     total_meals_amount_field as "Meal Total",
     meal_fee_final_field as "Meal After Waiver",
     concat(member_type_regular_field,
     member_type_graduate_field,
     member_type_undergradaute_field,
     member_type_staff_field,
     member_type_non_member_field) as "Member Type",
     total_registration_amount_field as "Total Regitration",
     registration_fee_final_field as "Registration after Waiver",
     final_total_amount_field as "Final Total Amount",
     ksea_login_id as "KSEA Loging ID",
     registration_id as "Registration ID",
     reg_date as "Registration Date"
     from wp_registration_list
     WHERE isDelete = 0
     and registration_id = "'.$registraionid.'"';

     $result1 = mysqli_query($connection, $sql1);
     if(mysqli_num_rows($result1) > 0){
 
         while($row1 = mysqli_fetch_assoc($result1)) {
             //echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
             $output_status	=	'You have already registered on '.$row1["Registration Date"];
             $postiontitle = $row1["Position/Title"];
             $first_name = $row1["First Name"];
             $last_name = $row1["Last Name"];
             $ksea_email = $row1["KSEA Email"];
             $lodging_fee_final_field = $row1["Lodging after Waiver"];
             $meal_fee_final_field = $row1["Meal After Waiver"];
             $registration_fee_final_field = $row1["Registration after Waiver"];
             $final_total_amount_field = $row1["Final Total Amount"];
             $affiliationorganization = $row1["Organization"];
             $gender_question = $row1["Gender"];
             $street_address = $row1["Street"];
             $state = $row1["State"];
             $city = $row1["City"];
             $country = $row1["Country"];
             $zipcode = $row1["ZIP"];
             $valid_waiver_code = $row1["Waiver Code"];
             $lodging_location = $row1["Lodging Location"];
             $check_in = $row1["check_in"];
             $check_out = $row1["Checkout Date"];
             $number_of_adults = $row1["Number of Adults"];
             $number_of_children = $row1["Number of Children"];
             $single_occupancy_field = $row1["Single Occupnacy"];
             $couple_occupancy = $row1["Couple Occupancy"];
             $family_occupancy1 = $row1["Family Occupancy"];
             $single_occupancy_sharing = $row1["Single Roommate"];
             $couple_occupancy_sharing = $row1["Couple Roommate"];
             $family_occupancy_sharing = $row1["Family Occupancy Roommate"];
             $single_roommate_first_name = $row1["Single Roommate First Name"];
             $couple_roommate_first_name = $row1["Couple Roommate First Name"];
             $family_roommate_first_name = $row1["Family Occupancy Roommate First Name"];
             $single_roommate_last_name = $row1["Single Roommate Last Name"];
             $couple_roommate_last_name = $row1["Couple Roommate Last Name"];
             $family_roommate_last_name = $row1["Family Occupancy Roommate Last Name"];

             $single_roommate_gender = $row1["Single Roommate Gender"];
             $couple_roommate_last_name = $row1["Couple Roommate Gender"];
             $family_roommate_last_name = $row1["Family Occupancy Roommate Gender"];

             $single_roommate_last_name = $row1["Single Roommate Email"];
             $couple_roommate_last_name = $row1["Couple Roommate Email"];
             $family_roommate_last_name = $row1["Family Occupancy Email"];
             $price_per_night = $row1["Price Per Night"];
             $number_of_nights = $row1["Number of Nights"];
             $number_of_people = $row1["Number of People"];
             $lodging_amount = $row1["Lodging Amount"];
             $cost_of_linen_storm_card = $row1["Linen/Storm Card"];
             $accumulated_total_cost_lodging = $row1["Total Lodging Amount"];
             $thursday_lunch_meal_type_a = $row1["Thursday Lunch A"];
             $thursday_lunch_meal_type_b = $row1["Thursday Lunch B"];
             $thursday_lunch_meal_type_c = $row1["Thursday Lunch C"];
             $friday_lunch_meal_type_a = $row1["Friday Lunch A"];
             $friday_lunch_meal_type_b = $row1["Friday Lunch B"];
             $friday_lunch_meal_type_c = $row1["Friday Lunch C"];
             $saturday_lunch_meal_type_a = $row1["Saturday Lunch A"];
             $saturday_lunch_meal_type_b = $row1["Saturday Lunch B"];
             $saturday_lunch_meal_type_c = $row1["Saturday Lunch C"];
             $lunch_total = $row1["Lunch Total"];
             $thursday_dinner_meal = $row1["Thursday Dinner Total"];
             $thursday_dinner_meal_with_waiver_code = $row1["Thursday Dinner waiver Total"];

             $num_of_bbq_children = $row1["Num of BBQ Children"];
             $thursday_dinner_bbq = $row1["Thursday Dinner Total"];
             $friday_dinner_meal = $row1["Friday Dinner Cruise (Adult)"];
             $friday_dinner_meal_with_waiver_code = $row1["Friday Dinner with waiver Total"];
             $num_of_cruise_children = $row1["Num of Cruise Children"];
             $friday_dinner_cruise = $row1["Friday Dinner Cruise Total"];
             $dinner_total = $row1["Dinner Total"];
             $total_meal_amount = $row1["Meal Total"];

             $member_type = $row1["Member Type"];
             $membership_fee_status = $row1["Membership Fee Status"];
             $is_presenter_discount = $row1["Oral/Poster Presentation"];
             $registration_fee = $row1["Total Regitration"];

             $emailTemplate = "Dear  $postiontitle <b>$first_name $last_name</b>,<br>";
             $emailTemplate.= "<p class='text-primary'>Thank you for registering to UKC 2018 which will be held at St. John’s University in Queens, NY, USA  on August 1 - August 4, 2018 (Wed – Sat).
             This is a confirmation that we have received your registration information and payment successfully.</p>
             <br><b>Email: $ksea_email<br>
             UKC 2018 Registration ID: $registraionid</b><br>
             Payment Received for Online Registration:<br>
             <p class='bg-success'>• Final Total Lodging Amount: $ $lodging_fee_final_field</br>
                 • Final Total Meals Amount: $ $meal_fee_final_field</br>
                 • Final Total Registration Amount: $ $registration_fee_final_field</br>
                 • Total Payment for UKC 2018: $ $final_total_amount_field</b></br></p>
             <p>STORM CARD: After finishing your registration, any person (7 years old or above) who will stay at St. John’s University lodging should apply for their building access card(<a href='https://stj.formstack.com/forms/ukc2018'> https://stj.formstack.com/forms/ukc2018</a>) to St. John’s University by Friday, July 20, 2018. If not, when you arrive at St. John’s University, you need to process the access card in person. It will cause your delay to access your building. For more information of the Storm card, please visit <a href='https://ukc2018.org/storm-card/'> https://ukc2018.org/storm-card/</a>
             To book your travel for UKC2018 at discounted price, click here. <a href='https://ukc2018.org/flight-discount-for-participants'>https://ukc2018.org/flight-discount-for-participants</a></p>
             
            Thank you for your on-line registration for UKC 2018.

             Sincerely,
             <p class='text-warning'> Kelly Han, Finance Manager
             KSEA
             1952 Gallows Rd. Suite 300
             Vienna, VA 22182
             Phone:703-748-1221 ext. 2
             Fax: 703-748-1331
             Email: ukc2018@gmail.com</p></b>";
             $emailTemplate.="<br><hr><br><p class='bg-info'>Please keep the following information for your records:</p>
             <p class='bg-primary'>1. Participant Information</p>
              <p>  Affiliation: $affiliationorganization<br>
                Gender: $gender_question<br>
                Street Address: $street_address<br>
                City: $city State/Province: $state<br>
                Country: $country Zip: $zipcode<br>
                Valid  Waiver Code (only one time use, if you received): $valid_waiver_code</p><br>";
            $emailTemplate.="<p class='bg-primary'>2. Lodging Information</p>
            <p>Lodging Location: $lodging_location<br>
            Check In:$check_in<br>
            Check Out: $check_out<br>
            Adults & Children (7 years or older): Born before August 1st, 2011: $number_of_adults<br>
            Children (Under 7 years): Born after August 1st, 2011: $number_of_children<br>
            Type of Accommodation: $single_occupancy_field $couple_occupancy $family_occupancy1 (70=Double Occupancy; 100=Single Occupancy; 150=Couple Occupancy; 180=Family Suite (Shared); 340=Family Suite (Whole))<br>
            Suite Sharing: $single_occupancy_sharing $couple_occupancy_sharing $family_occupancy_sharing<br>
            •	Roommate First Name: $single_roommate_first_name $couple_roommate_first_name $family_roommate_first_name
            •	Roommate Last Name: $single_roommate_last_name $couple_roommate_last_name $family_roommate_last_name<br>
            •	Roommate Gender: $single_roommate_gender $couple_roommate_gender $family_roommate_gender<br>
            •	Roommate Email: $single_roommate_email $couple_roommate_email $family_roommate_email<br>
            Price per Night: $ $price_per_night<br>
            How Many Night:  $number_of_nights<br>
            How Many People: $number_of_people<br>
            Lodging Amount: $ $lodging_amount<br>
            Linen ($15 per person) and Storm Card ($10 per an adult or a child including 7 years or older): $$cost_of_linen_storm_card<br>
            •	The linen packet includes 3 towels, 1 bed sheet, 1 fitted bed sheet, 1 blanket,1 face cloth and 1 pillow.<br>
            •	Notice 1. There are NO housekeeping and cleaning services during your staying at the St. John's University Lodging. So please keep clean your rooms.<br>
            •	Notice 2. You will receive an email regarding the StormCard after UKC 2018 registration. You need to keep your registration number for the StormCard.<br>
            Total Lodging Amount: $ $accumulated_total_cost_lodging
            Final Total Lodging Amount (with Waiver Code): $ $lodging_fee_final_field</p><br>";

            $emailTemplate.= "<p class='bg-primary'>3. Meal Information</p>
           <p> <br>Breakfast:
                Thursday Breakfast: $number_of_people<br>
                Friday Breakfast: $number_of_people<br>
                Saturday Breakfast: $number_of_people<br>
                Breakfast Total (free, included in your St. John’s lodging): $ 0.00<br>
            	Lunch (A-Ham & Cheese; B-Tuna Salad; C-Mozzarella & Tomato)<br>
                Thursday Lunch: A($thursday_lunch_meal_type_a) B($thursday_lunch_meal_type_b) C($thursday_lunch_meal_type_c)<br>
                Friday Lunch: A($friday_lunch_meal_type_a) B($friday_lunch_meal_type_b) C($friday_lunch_meal_type_c)<br>
                Saturday Lunch: A($saturday_lunch_meal_type_a) B($saturday_lunch_meal_type_b) C($saturday_lunch_meal_type_c)<br>
                Lunch Total (free for one registration): $ $lunch_total<br>
                Dinner:<br>
                Thursday BBQ at St. John’s Lawn<br>
            	Adult ($40): $thursday_dinner_meal $thursday_dinner_meal_with_waiver_code<br>
                Child ($ 0):$num_of_bbq_children<br>
                Free for children (under 7 years, born after August 1st, 2011)<br>
                'All You Can Eat' - Including drinks, beers, and wines!<br>
                Thursday BBQ Sub-Total: $$thursday_dinner_bbq<br>
            	----------------------------------------------<br>
                Friday NYC Night Cruise<br>
                Adult ($100): $friday_dinner_meal $friday_dinner_meal_with_waiver_code<br>
                Child ($25): $num_of_cruise_children<br>
                $25 for children (under 10 years, born after August 1st, 2008)<br>
                Cruise is limited to first 450 people!<br>
                Friday Cruise Sub-Total: $ $friday_dinner_cruise<br>
                ----------------------------------------------<br>
                Dinner Total: $ $dinner_total<br>
                Total Meals Amount (with Discount): $ $total_meal_amount<br>
                Final Total Meals Amount (with Discount and Waiver Code): $ $total_sub_total_discount</p><br>
                <p class='bg-primary'> 4. Registration Information</p>
            <p>Member Type: $member_type_regular $member_type_graduate $member_type_undergraduate $member_type_staff $member_type_non_member<br>
            <p class='text-warning'>Discount Info.<br></p>
                    • On Site Registration Fee without Any Discount:<br>
                    • Regular/Staff/Non Member: $650<br>
                    • Regular in YG/PF: $500<br>
                    • Post-Doc: &#36;450<br>
                    • Graduate: &#36;400<br>
                    • Undergraduate: &#36;200<br>
                    • &#36;200 Early Discounted Online Registration Fee (by 7/7/18)<br>
                    • &#36;100 Discounted Online Registration Fee (by 7/15/18)<br>
                    • &#36;70 KSEA Membership Discount : $membership_fee_status<br>
                    • &#36;100 Oral/Poster Presenter Discount(not for undergraduate): $is_presenter_discount<br>
                    • Total Registration Amount (with Discount): $ $registration_fee<br>
                    • Final Total Registration Amount: $ $registration_fee_discount</p><br>
             
                <p class='text-danger'><b>Final Total Amount (with Discount and Waiver Code): $ $final_total_amount_field</b></p>
            ";

             

         }
 
     }else{
        $output_status = 0;// 'We could not find your details. Please Register for UKC 2018.';
     }
     
     mysqli_close($connection);
     return $output_status;
 }

 function createTemplate(){

 }

add_action('check_status','show_status');
function show_status(){
    

    if(isset($_POST['nextregister']))
    {
   
        ?>
            <form id="myForm" action="https://ukc2018.org/online-registration/" method="post">
                <input type="hidden" name="first_name" value="Charith">
            </form>
    <script type="text/javascript">
        document.getElementById('myForm').submit();
    </script>

    <?php

 
}

if(isset($_POST['checkStatus'])){
    global $emailTemplate;

    if(isset($_POST)){
    $registraionid = $_POST["registerid"];   
    $result = checkStatus($registraionid);
    if($result=='0'){
        $wc_msg ='<span class="label label-danger">We could not find your details. Please Register for UKC 2018.<span class="glyphicon glyphicon-remove"></span></span>';
        $wc_tbl ='';
        $wc_tbl_head ='';
    }else{
        $wc_msg ='<span class="label label-success">'.$result.'<span class="glyphicon glyphicon-ok"></span></span>';
        $wc_tbl_head ='Your Registration details as follows:';
        //$wc_tbl= do_shortcode('[wpdatatable id=3 var1=' . $registraionid . ']');
        $wc_tbl = $emailTemplate;
    }
    

    }
    
}
?>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
    <div class="container">
    <div id="signupbox" style="margin-top:0px" class="mainbox col-md-8 col-md-offset-3 col-sm-8 col-sm-offset-2">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title"><h3>UKC2018 Registration Status</h3><br><sup>*</sup>  Please use the RegistrationID to check your registration status </div>       
                            
                        </div>  
                        <div class="panel-body" >
                       
                            <form id="signupform" class="form-horizontal" role="form" action="<?php echo $PHP_SELF;?>" method="post">
                                
                                <div id="signupalert" style="display:none" class="alert alert-danger">
                                    <p>Error:</p>
                                    <span></span>
                                </div>
                                    
                                <div class="form-group">
                                    <label for="icode" class="col-md-3 control-label">Registration number</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name ="registerid" id="registerid" placeholder="Registration ID" value="<?php echo isset($_POST['registerid']) ? $_POST['registerid'] : '' ?>" required>
                                        <span id="wcavailability" style="line-height:0px;"><?php echo''.$wc_msg; ?></span>
                                    </div>
                                </div>
                                  
                                <!-- <div class="form-group">
                                    <label for="email" class="col-md-3 control-label">Email</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name ="ecemail" id="ecemail" placeholder="Email Address" value="<?php echo isset($_POST['ecemail']) ? $_POST['ecemail'] : '' ?>">
                                        <span id="ecemailavailability" style="line-height:0px;">
                                    </div>
                                </div> -->
                                    
                                <div class="form-group">
                                    <!-- Button -->                                        
                                    <div class="col-md-offset-3 col-md-9">
                                        <button id="btn-signup" type="submit" class="btn btn-info" name="checkStatus"><i class="icon-hand-right"></i> &nbsp; Check Status</button>
                                        <span style="margin-left:8px;"></span>  
                                    </div>
                                </div>

                                <div class="panel-heading">
                                    <p class="bg-primary"><?php echo $wc_tbl_head; ?></p>
                                        <!-- <span class="label label-success" style="margin-left:8px;"><?php echo $wc_tbl_head; ?></span>  --> 
                                        <span id="tablevalues"  style="margin-left:0px;"> <?php echo $wc_tbl; ?></span>  
                                    
                                </div>
                                
                                
                                </form>
                                <!-- <button type="button" class="btn btn-info btn-lg">Register Now</button> -->
                                <form id="signupform" class="form-horizontal" role="form" action="<?php echo $PHP_SELF;?>" method="post">
                                <div style="border-top: 1px solid #999; padding-top:20px"  class="form-group">
                                    <div class="col-md-offset-3 col-md-9">
                                       <!--  <button type="button" class="btn btn-info btn-lg" href="https://ukc2018.org/online-registration/" >Register Now</button> -->
                                        <button id="btn-fbsignup" type="submit" name="nextregister" class="btn btn-success btn-lg-success"><i class="icon-facebook"></i> &nbsp;&nbsp; &nbsp;&nbsp; Register Now&nbsp;&nbsp;&nbsp; &nbsp; </button>
                                    </div>                                           
                                        
                                </div> 

                            </form>
                         </div>
                    </div>    
         </div>  

         </div>


<?php
 }
?>