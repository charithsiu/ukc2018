<?php
require __DIR__ . '/db/ksea_dbconn.include.php';
require __DIR__ . '/db/login_check.include.php';
require __DIR__ . '/action_page.php';
require __DIR__ . '/submit_action_page.php';
require __DIR__ . '/registeration_status.php';
require_once( CFCORE_PATH . 'classes/admin.php' );



/**
 *Plugin Name:UKC 2018 Plugin
 *This is Custom Plugin for form handling By Charith Atapattu.
 **/

add_filter( 'caldera_forms_summary_magic_fields', function( $fields, $form ) {
	//change your field ID
	if( isset( $fields[ 'fld_8656675'] ) ){
        $fn= Caldera_Forms::get_field_data( 'fld_8656675', $form );
        $hide= Caldera_Forms::get_field_data( 'fld_7525201', $form );
		echo "<script>alert('$fn:.$hide');</script>";
	}
	return $fields;
	
}, 10, 2 );



add_filter( 'caldera_forms_render_get_field_type-cfcf_next_nav', function( $field, $form ){
	//change your form ID to target a specific form
    //remove conditional to target all connected forms
    echo"<script>alert('test')</script>";
	if( 'CF5ace80b6dc395' == $form[ 'ID' ] ){
        echo"<script>alert('test')</script>";
		$field[ 'label' ] = 'Previous Step';
	}
		return $field;

}, 10, 2 );



 add_filter( 'my_custom_pre_filter', 'my_custom_pre' );
function my_custom_pre( $data ) {

   
    

    /*


        if (!$_SESSION["wc"] || (trim($data['paypal_transaction_id'])=='xxx')){  //'something' != $data[ 'lodging_cost_total_discount' ]
            
            $waivercode = $data['type_your_waiver_code_here'];
            $c_email = $data['easychair_email'];
            $_SESSION["TestEmail"]=$c_email;
            //echo"<script>alert('$c_email')</script>";
             $result = checkWaiverCode($waivercode,$c_email);
             // $t=$_SESSION["wc"];
               // echo"<script>alert('$t')</script>";
            // echo"<script>alert('$c_email')</script>";
             if($result==1){
                $val = "<h5 style='color:green;'> Congratulations waiver code applied successfully.<br>Valid email address.</h5>" ;
                echo"<script>console.log('Congratulations waiver code applied successfully.')</script>";
             }else if($result==2){
                 $val = "<h5 style='color:green;'>Congratulations waiver code applied successfully.</h5><br><h5 style='color:red;'>Email address is invalid.</h5>" ;
                echo"<script>console.log('Congratulations waiver code applied successfully.')</script>";
             }else if($result==3){
                $val = "<h5 style='color:red;'>Sorry Invalid waiver code.</h5><br><h5 style='color:green;'>Email address is valid.</h5>" ;
                echo"<script>console.log('Sorry !!!, Waiver code is unsuccessful.')</script>";
            }else if($result==4){
                $val = "<h5 style='color:red;'>Sorry Invalid waiver code.</h5><br><h5 style='color:red;'>Email address is invalid.</h5>" ;
                echo"<script>console.log('Sorry !!!, Waiver code is unsuccessful.')</script>"; 
            }else if($result ==5){
                $val = "<h5 style='color:green;'>Valid waiver code.</h5>" ;
                echo"<script>console.log('Waiver code is valid.')</script>";
            }else if($result ==6){
                $val = "<h5 style='color:red;'>Sorry. Invalid waiver code.</h5>" ;
                echo"<script>console.log('Waiver code is invalid.')</script>";
            }else if($result ==7){
                $val = "<h5 style='color:green;'>Valid Email.</h5>" ;
                echo"<script>console.log('Email address is valid.')</script>";
            }else if($result ==8){
                $val = "<h5 style='color:red;'>Sorry. Invalid Email.</h5>" ;
                echo"<script>console.log('Email address is invalid.')</script>";
            }else{
                $val = "<h5 style='color:red;'>Sorry.Data is not correct.</h5>" ;
                echo"<script>console.log('incorrect data.')</script>";
            }
            //$_SESSION['email'] =$data["e_mail"];
             return array(
                  'type' => 'error',
                 'note' => __($val, 'my-text-domain' )
             );


        }else{
            $val = "<h3>Thank you !!!. You have registered for UKC2018.</h3>";
            return array(
                'type' => 'success',
               'note' => __($val, 'my-text-domain' )
           );

        }
*/

} 

 /*  add_action('my_text_action', 'my_test_function');
  function my_test_function( $data ){
     // update_option( 'test_form_option', $data );
     echo"<script>alert('test')</script>";
  } */


add_action( 'caldera_forms_submit_complete', 'slug_process_form', 55 );




  add_action( 'rest_api_init', 'wpc_register_wp_api_endpoints' );
  function wpc_register_wp_api_endpoints() {
     // echo"<script>alert('test')</script>";
      register_rest_route( 'charith', '/search', array(
          'methods' => 'GET',
          'callback' => 'mc_cfes_output_json',
      ));
  }

  function mc_cfes_output_json() {

   // $arr = array ('a'=>1,'b'=>2,'c'=>3,'d'=>4,'e'=>5);
   //return json_encode($arr);
   $atts =array('id'=>'`','number'=>'10');
   $atts = shortcode_atts( array(
    'id' => '',
    'number' => '999'
), $atts, 'cf_entries' );
//in front-end admin class is not included
require_once( CFCORE_PATH . 'classes/admin.php' );
//get all entries (page 1 with 9999999 entries per page should do it:)
$data = Caldera_Forms_Admin::get_entries( $atts['id'], 9, $atts['number'] );

      $object = json_encode((array)$data['entries']);
     // echo"<script>console.log($object);</script>";

    return $object;
}

add_shortcode('cf_entries', 'mc_cfes_output');
  function mc_cfes_output($atts) {
      $atts = shortcode_atts( array(
          'id' => '',
          'number' => '999'
      ), $atts, 'cf_entries' );
      //in front-end admin class is not included
      require_once( CFCORE_PATH . 'classes/admin.php' );
      //get all entries (page 1 with 9999999 entries per page should do it:)
      $data = Caldera_Forms_Admin::get_entries( $atts['id'], 1, $atts['number'] );
      ob_start();
      ?>


          <div class="cf-entries">

              <p><span class="cf-entries-header name">Name</span> <span class="cf-entries-header events">Events</span> <span class="cf-entries-header comments">Comments</span></p>
          <?php
           // echo"<script>console.log($data['entries']);</script>";
          //foreach ( (array)$data['entries'] as $entry ) {
            $object = json_encode((array)$data['entries']);
            //echo"$object";
              //echo '<p class="cf-entry"><span class="cf-name">' . $entry['data']['first_name'] . '</span> <span class="cf-comment">' . $entry['data']['last_name'] . '</span> <span>' . $entry['data']['affiliationorganization'] . '</span></p>';
          //}
          ?>

          </div>

      <?php
      $output = ob_get_clean();
      return $output;
  }


add_filter( 'caldera_forms_render_get_field', function( $field )  {

    if ( 'first_name' == $field[ 'slug' ]  ) {

        $field[ 'config' ][ 'default' ] = $_SESSION["firstName"];
    }
    
    if ( 'last_name' == $field[ 'slug' ]  ) {
        $field[ 'config' ][ 'default' ] = $_SESSION["lastName"];
    }
    if ( 'valid_easychair_email' == $field[ 'slug' ]  ) {
        /* $s=$_SESSION["ecmail"];
        echo"<script>alert('in field:$s')</script>"; */
        $field[ 'config' ][ 'default' ] =  $_SESSION["ecmail"];
    }
    if ( 'valid_waiver_code' == $field[ 'slug' ]  ) {

        $field[ 'config' ][ 'default' ] =  $_SESSION["waiverCode"];
    }
    if ( 'ksea_email' == $field[ 'slug' ]  ) {
        //$s=$_SESSION["email"];
        //echo"<script>alert('in field:$s')</script>";
        $field[ 'config' ][ 'default' ] = $_SESSION["email"];
    }
    if ( 'affiliationorganization' == $field[ 'slug' ]  ) {
        $field[ 'config' ][ 'default' ] = $_SESSION["affiliation"];
    }
    if ( 'postiontitle' == $field[ 'slug' ]  ) {
        $field[ 'config' ][ 'default' ] = $_SESSION["title"];
    }
    if ( 'street_address' == $field[ 'slug' ]  ) {
        $field[ 'config' ][ 'default' ] =$_SESSION["homeStreet"];
    }
    if ( 'city' == $field[ 'slug' ]  ) {
        $field[ 'config' ][ 'default' ] = $_SESSION["homeCity"];
    }
    if ( 'state' == $field[ 'slug' ]  ) {
        $field[ 'config' ][ 'default' ] = $_SESSION["homeState"];
    }
    if ( 'zipcode' == $field[ 'slug' ]  ) {
        $field[ 'config' ][ 'default' ] = $_SESSION["homeZip"];
    }
    if ( 'member_type' == $field[ 'slug' ]  ) {
        $field[ 'config' ][ 'default' ] = $_SESSION["memberType"];
    }
     if ( 'membership_fee_status' == $field[ 'slug' ]  ) {
        $field[ 'config' ][ 'default' ] = $_SESSION["memberStatus"];

    }
    if( 'fld_4459770' == $field[ 'ID' ] ){
        $field[ 'config' ][ 'default' ] = $_SESSION['gender'];
    }
    /* if ( 'fld_7077593' == $field[ 'ID' ]  ) {
        $field[ 'config' ][ 'default' ] =$_SESSION["waiverCode"];
    } */
    if ( 'fld_709544' == $field[ 'ID' ]  ) {
        $field[ 'config' ][ 'default' ] =$_SESSION["lodge"];
    }
    if ( 'fld_9939011' == $field[ 'ID' ]  ) {
         // $s=$_SESSION["meal"];
       // echo"<script>alert('in field:$s')</script>";
        $field[ 'config' ][ 'default' ] =$_SESSION["meal"];
    }
    if ( 'fld_7495959' == $field[ 'ID' ]  ) {
        $field[ 'config' ][ 'default' ] =$_SESSION["registration"];
    }
    if( 'fld_5976034' == $field[ 'ID' ] ){
        $field[ 'config' ][ 'default' ] = $_SESSION['gender'];
    }
    if( 'fld_6162848' == $field[ 'ID' ] ){
        $field[ 'config' ][ 'default' ] = $_SESSION['gender'];
    }
     /*   if( 'easychair_confirm' == $field[ 'slug' ] ){
        
        $field[ 'config' ][ 'default' ] = $_SESSION["verifyemail"];
    } 
    if( 'do_you_have_a_waiver_code' == $field[ 'slug' ] ){
        $field[ 'config' ][ 'default' ] = $_SESSION["wc"];
    } */
    if( 'is_easychair_email_valid' == $field[ 'slug' ] ){
        //$tt=$_SESSION['verifyemail'];
        //echo"<script>alert('in field:$tt')</script>";
        $field[ 'config' ][ 'default' ] = $_SESSION["verifyemail"];
    }
    if( 'country' == $field[ 'slug' ] ){
        //$tt=$_SESSION['verifyemail'];
       // echo"<script>alert('in field:$tt')</script>";
        $field[ 'config' ][ 'default' ] = $_SESSION["homeCountry"];
    }

     if( 'fld_209453' == $field[ 'ID' ] ){
        //$tt=$_SESSION['regId'];
         //echo"<script>alert('in field:$tt')</script>";
        $field[ 'config' ][ 'default' ] =$_SESSION['regId'];
    } 

    /*
   meals_cost_total_discount   lodging_cost_total_discount
    if ( 'city2' == $field[ 'slug' ]  ) {
        $field[ 'config' ][ 'default' ] = $_SESSION["homeCity"];
    }
    if ( 'access_id_state' == $field[ 'slug' ]  ) {
        $field[ 'config' ][ 'default' ] = $_SESSION["homeState"];
    }
    if ( 'zip' == $field[ 'slug' ]  ) {
        $field[ 'config' ][ 'default' ] = $_SESSION["homeZip"];
    }
    if( 'fld_6121732' == $field[ 'ID' ] ){
        $field[ 'config' ][ 'default' ] = $_SESSION['gender'];
    }
    if ( 'date_of_birth' == $field[ 'slug' ]  ) {
       // $dob=$_SESSION['dob'];
        //echo"<script>alert('$dob')</script>";
        $field[ 'config' ][ 'default' ] = $_SESSION["dob"];
    }
    if ( 'e_mail2' == $field[ 'slug' ]  ) {
        $field[ 'config' ][ 'default' ] = $_SESSION["email"];
    }
    if ( 'phone_number' == $field[ 'slug' ]  ) {
        $field[ 'config' ][ 'default' ] = $_SESSION["homeCell"];
    }
    if ( 'guest1_first_name' == $field[ 'slug' ]  ) {
        $field[ 'config' ][ 'default' ] = $_SESSION["firstName"];
    }
    if ( 'guest1_last_name' == $field[ 'slug' ]  ) {
        $field[ 'config' ][ 'default' ] = $_SESSION["lastName"];
    }
    if ( 'guest1_date_of_birth' == $field[ 'slug' ]  ) {
        $field[ 'config' ][ 'default' ] = $_SESSION["dob"];
    } */if ( 'member_type_2' == $field[ 'slug' ]  ) {
        $field[ 'config' ][ 'default' ] = $_SESSION["memberType"];
    }


    return $field;

});

add_action('top_of_login_check','login_check');
function login_check(){
}


add_action('top_of_login_page','login_process');
function login_process(){
    if(isset($_POST['submit']))
    {
        $result = checklogin();
        if($result==1){
        ?>
            <form id="myForm" action="https://ukc2018.org/register-member-info/" method="post">
                <input type="hidden" name="first_name" value="Charith">
            </form>
    <script type="text/javascript">
        document.getElementById('myForm').submit();
    </script>

<?php

    }else if($result==0){
        $php_errormsg ='<p style="color:red;font-size:16px;">Invalid ID or password - Please check your login information.</p>';
    }else{
        $php_errormsg ='<p style="color:red;font-size:16px;">You have already Registered on '.$result.'</p>';
    }
}
if(isset($_POST['checkwaivecode'])){
    if(isset($_POST)){

    $result = checkWaiverCode();
    
    if($result==1){
        //$php_validationmsg = "<h5 style='color:green;'> Congratulations waiver code applied successfully.<br>Valid email address.</h5>" ;
        $wc_msg ='<span class="label label-success">Valid Waive Code<span class="glyphicon glyphicon-ok"></span></span>';
        $ecemail_msg ='<span class="label label-success">Valid Email<span class="glyphicon glyphicon-ok"></span></span>';
     }else if($result==2){
        //$php_validationmsg = "<h5 style='color:green;'>Congratulations waiver code applied successfully.</h5><br><h5 style='color:red;'>Email address is invalid.</h5>" ;
        $wc_msg ='<span class="label label-success">Valid Waive Code<span class="glyphicon glyphicon-ok"></span></span>';
        $ecemail_msg ='<span class="label label-danger">Invalid Email<span class="glyphicon glyphicon-remove"></span></span>';
     }else if($result==3){
        //$php_validationmsg = "<h5 style='color:red;'>Sorry Invalid waiver code.</h5><br><h5 style='color:green;'>Email address is valid.</h5>" ;
        $wc_msg ='<span class="label label-danger">Inalid Waive Code<span class="glyphicon glyphicon-remove"></span></span>';
        $ecemail_msg ='<span class="label label-success">Valid Email<span class="glyphicon glyphicon-ok"></span></span>';
    }else if($result==4){
        //$php_validationmsg = "<h5 style='color:red;'>Sorry Invalid waiver code.</h5><br><h5 style='color:red;'>Email address is invalid.</h5>" ;
        $wc_msg ='<span class="label label-danger">Invalid Waive Code<span class="glyphicon glyphicon-remove"></span></span>';
        $ecemail_msg ='<span class="label label-danger">Invalid Email<span class="glyphicon glyphicon-remove"></span></span>';
    }else if($result ==5){
        //$php_validationmsg = "<h5 style='color:green;'>Valid waiver code.</h5>" ;
        $wc_msg ='<span class="label label-success">Valid Waive Code<span class="glyphicon glyphicon-ok"></span></span>';
    }else if($result ==6){
        //$php_validationmsg = "<h5 style='color:red;'>Sorry. Invalid waiver code.</h5>" ;
        $wc_msg ='<span class="label label-danger">Invalid Waive Code<span class="glyphicon glyphicon-remove"></span></span>';
    }else if($result ==7){
        //$php_validationmsg = "<h5 style='color:green;'>Valid Email.</h5>" ;
        $ecemail_msg ='<span class="label label-success">Valid Email<span class="glyphicon glyphicon-ok"></span></span>';
    }else if($result ==8){
       // $php_validationmsg = "<h5 style='color:red;'>Sorry. Invalid Email.</h5>" ;
        $ecemail_msg ='<span class="label label-danger">Invalid Email<span class="glyphicon glyphicon-remove"></span></span>';
    }else{
        //$php_validationmsg = "<h5 style='color:red;'>Sorry.Data is not correct.</h5>" ;
        $ecemail_msg ='<span class="label label-danger">Invalid Data<span class="glyphicon glyphicon-remove"></span></span>';
        $wc_msg ='<span class="label label-danger">Invalid Data<span class="glyphicon glyphicon-remove"></span></span>';
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
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="panel-title"><h3>UKC2018 Member Registration Waiver Code Validation</h3><br><sup>*</sup> If you received it  from  KSEA, use it (only one time use!). Otherwise, skip this step.</div>
                        </div>  
                        <div class="panel-body" >
                       <!--  <div  id="login-alert" class="alert alert-danger col-sm-12">
                                <ul class="list-group">
                                <li class="list-group-item list-group-item-success"><b>Waiver Code:</b> Before signing-in, please first validate your waiver code if you received it from KSEA. Otherwise, disregard this step.</li>
                                <li class="list-group-item list-group-item-success"><b>Presenter’s Discount:</b> Please validate your EasyChair email if you  present your paper at UKC 2018. Otherwise, disregard this step.</li> 
                                </ul>
                            </div> -->
                            <form id="signupform" class="form-horizontal" role="form" action="<?php echo $PHP_SELF;?>" method="post">
                                
                                <div id="signupalert" style="display:none" class="alert alert-danger">
                                    <p>Error:</p>
                                    <span></span>
                                </div>
                                    
                                <div class="form-group">
                                    <label for="icode" class="col-md-3 control-label">Waiver Code</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name ="waivercode" id="waivercode" placeholder="Waiver Code" value="<?php echo isset($_POST['waivercode']) ? $_POST['waivercode'] : '' ?>">
                                        <span id="wcavailability" style="line-height:0px;"><?php echo''.$wc_msg; ?>
                                    </div>
                                </div>
                                  
                               <!--  <div class="form-group">
                                    <label for="email" class="col-md-3 control-label">Email</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name ="ecemail" id="ecemail" placeholder="Email Address" value="<?php echo isset($_POST['ecemail']) ? $_POST['ecemail'] : '' ?>">
                                        <span id="ecemailavailability" style="line-height:0px;"><?php echo ''.$ecemail_msg; ?>
                                    </div>
                                </div> -->
                                    
                                <div class="form-group">
                                    <!-- Button -->                                        
                                    <div class="col-md-offset-3 col-md-9">
                                        <button id="btn-signup" type="submit" class="btn btn-info" name="checkwaivecode"><i class="icon-hand-right"></i> &nbsp; Validate</button>
                                        <span style="margin-left:8px;"></span>  
                                    </div>
                                </div>
                                
                                <!-- <div style="border-top: 1px solid #999; padding-top:20px"  class="form-group">
                                    
                                    <div class="col-md-offset-3 col-md-9">
                                        <button id="btn-fbsignup" type="button" class="btn btn-primary"><i class="icon-facebook"></i> &nbsp;&nbsp; &nbsp;&nbsp; Next&nbsp;&nbsp;&nbsp; &nbsp; </button>
                                    </div>                                           
                                        
                                </div> -->
                                
                                
                                
                            </form>
                         </div>
                    </div>    
         </div>     
        <div id="loginbox" style="margin-top:0px;" class="mainbox col-md-8 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
            <div class="panel panel-info" >
                    <div class="panel-heading">
                        <div class="panel-title"><h3>Please sign in with KSEA ID/Password</h3></div>
                        <div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="http://ksea.org/user/FindPassword.aspx" target="_blank">Forgot ID/Password?</a></div>
                        
                    </div>     

                    <div style="padding-top:30px" class="panel-body" >

                        <div  id="login-alert" class="alert alert-danger col-sm-12">
                        <ul class="list-group">
                                <li class="list-group-item list-group-item-success">You should be an active KSEA member for the 2018-2019 fiscal year (May 1, 2018 and April 30, 2019). Please do not forget to <a href='https://ksea.org/login.aspx?type=renew' style="color:#13a880;" target="_blank">renew for the 2018 fiscal year</a> before registration.(After you press the renew button, log into <b>"My Membership Status"</b>. Then , click <b>"Go to My Profile Page"</b>. You can see <b>"Renew Membership" </b> button under your email.)</li>
                                <li class="list-group-item list-group-item-success">KSEA membership discount (&#36;70) is greater than the annual membership due (&#36;35 for regular members, &#36;15 for graduate students, &#36;0 and for undergraduate students).</li> 
                            </ul>
                        </div>
                          
                        
                        <form id="loginform" class="form-horizontal" role="form" action="<?php echo $PHP_SELF;?>" method="post">
                                   
                            
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input id="member_id" type="text" class="form-control" name="member_id" value="" placeholder="KSEA ID/Login ID" required>                                        
                                    </div>
                                
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input id="member_pw" type="password" class="form-control" name="member_pw" placeholder="password" required>
                                    </div>


                                <div style="margin-top:10px" class="form-group">
                                    <!-- Button -->

                                    <div class="col-sm-12 controls">
                                      <!--<a type="submit" name="submit" class="btn btn-success">Login  </a>
                                       <a id="btn-fblogin" href="#" class="btn btn-primary">Login with Facebook</a> -->
                                       <button id="btn-signup" type="submit" class="btn btn-info" name="submit"><i class="icon-hand-right"></i> &nbsp; Login </button>
                                       <span class="label label-danger"><?php echo $php_errormsg ?></span>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="col-md-12 control">
                                        <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
                                            KSEA Membership Expired?<a href="https://ksea.org/login.aspx?type=renew" target="_blank" >Renew Membership</a>
                                        </div>
                                    </div>
                                </div>    
                            </form>     
                        </div>                     
                    </div>  
            </div>
        
    </div>

<?php
 }

 add_action('clearCache','clearSystem');
 function clearSystem(){
    $wc = $_SESSION["waiverCode"];
    $meal = $_SESSION["meal"]	;
    $lodge= $_SESSION["lodge"];
    $regi = $_SESSION["registration"];
    $wcc= $_SESSION["wc"];
    $ecmail = $_SESSION["ecmail"];
    $verifyemail = $_SESSION["verifyemail"];

    $_SESSION = array();
    session_unset();
    session_destroy();
    session_start();

    $_SESSION["waiverCode"]	=$wc;
    $_SESSION["meal"]	= $meal;
    $_SESSION["lodge"]	=$lodge;
    $_SESSION["registration"]	=$regi;
    $_SESSION["wc"]=$wcc;
    $_SESSION["ecmail"]=$ecmail;
    $_SESSION["verifyemail"]=$verifyemail;
    $regID = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
    $_SESSION['regId']=$regID;

    
 }

add_action('non_member','show_non_member');
function show_non_member(){

    if(isset($_POST['next']))
    {
   
        ?>
            <form id="myForm" action="https://ukc2018.org/register-non-member-info/" method="post">
                <input type="hidden" name="first_name" value="Charith">
            </form>
    <script type="text/javascript">
        document.getElementById('myForm').submit();
    </script>

    <?php

 
}

if(isset($_POST['checkwaivecode'])){
    if(isset($_POST)){

    $result = checkWaiverCode();
    
    if($result==1){
        //$php_validationmsg = "<h5 style='color:green;'> Congratulations waiver code applied successfully.<br>Valid email address.</h5>" ;
        $wc_msg ='<span class="label label-success">Valid Waive Code<span class="glyphicon glyphicon-ok"></span></span>';
        $ecemail_msg ='<span class="label label-success">Valid Email<span class="glyphicon glyphicon-ok"></span></span>';
     }else if($result==2){
        //$php_validationmsg = "<h5 style='color:green;'>Congratulations waiver code applied successfully.</h5><br><h5 style='color:red;'>Email address is invalid.</h5>" ;
        $wc_msg ='<span class="label label-success">Valid Waive Code<span class="glyphicon glyphicon-ok"></span></span>';
        $ecemail_msg ='<span class="label label-danger">Invalid Email<span class="glyphicon glyphicon-remove"></span></span>';
     }else if($result==3){
        //$php_validationmsg = "<h5 style='color:red;'>Sorry Invalid waiver code.</h5><br><h5 style='color:green;'>Email address is valid.</h5>" ;
        $wc_msg ='<span class="label label-danger">Inalid Waive Code<span class="glyphicon glyphicon-remove"></span></span>';
        $ecemail_msg ='<span class="label label-success">Valid Email<span class="glyphicon glyphicon-ok"></span></span>';
    }else if($result==4){
        //$php_validationmsg = "<h5 style='color:red;'>Sorry Invalid waiver code.</h5><br><h5 style='color:red;'>Email address is invalid.</h5>" ;
        $wc_msg ='<span class="label label-danger">Invalid Waive Code<span class="glyphicon glyphicon-remove"></span></span>';
        $ecemail_msg ='<span class="label label-danger">Invalid Email<span class="glyphicon glyphicon-remove"></span></span>';
    }else if($result ==5){
        //$php_validationmsg = "<h5 style='color:green;'>Valid waiver code.</h5>" ;
        $wc_msg ='<span class="label label-success">Valid Waive Code<span class="glyphicon glyphicon-ok"></span></span>';
    }else if($result ==6){
        //$php_validationmsg = "<h5 style='color:red;'>Sorry. Invalid waiver code.</h5>" ;
        $wc_msg ='<span class="label label-danger">Invalid Waive Code<span class="glyphicon glyphicon-remove"></span></span>';
    }else if($result ==7){
        //$php_validationmsg = "<h5 style='color:green;'>Valid Email.</h5>" ;
        $ecemail_msg ='<span class="label label-success">Valid Email<span class="glyphicon glyphicon-ok"></span></span>';
    }else if($result ==8){
       // $php_validationmsg = "<h5 style='color:red;'>Sorry. Invalid Email.</h5>" ;
        $ecemail_msg ='<span class="label label-danger">Invalid Email<span class="glyphicon glyphicon-remove"></span></span>';
    }else{
        //$php_validationmsg = "<h5 style='color:red;'>Sorry.Data is not correct.</h5>" ;
        $ecemail_msg ='<span class="label label-danger">Invalid Data<span class="glyphicon glyphicon-remove"></span></span>';
        $wc_msg ='<span class="label label-danger">Invalid Data<span class="glyphicon glyphicon-remove"></span></span>';
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
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="panel-title"><h3>UKC2018 Non-Member Registration Waiver Code Validation</h3><br><sup>*</sup>  If you received it  from  KSEA, use it (only one time use!). Otherwise, skip this step. </div>       
                            
                        </div>  
                        <div class="panel-body" >
                        <!-- <div  id="login-alert" class="alert alert-danger col-sm-12">
                                <ul class="list-group">
                                <li class="list-group-item list-group-item-success"><b>Waiver Code:</b> Before signing-in, please first validate your waiver code if you received it from KSEA. Otherwise, disregard this step.</li>
                                 <li class="list-group-item list-group-item-success">Presenter’s Discount:</b> Please validate your EasyChair email if you  present your paper at UKC 2018. Otherwise, disregard this step.</li>  
                                </ul>
                            </div> -->
                            <form id="signupform" class="form-horizontal" role="form" action="<?php echo $PHP_SELF;?>" method="post">
                                
                                <div id="signupalert" style="display:none" class="alert alert-danger">
                                    <p>Error:</p>
                                    <span></span>
                                </div>
                                    
                                <div class="form-group">
                                    <label for="icode" class="col-md-3 control-label">Waiver Code</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name ="waivercode" id="waivercode" placeholder="Waiver Code" value="<?php echo isset($_POST['waivercode']) ? $_POST['waivercode'] : '' ?>" required>
                                        <span id="wcavailability" style="line-height:0px;"><?php echo''.$wc_msg; ?>
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
                                        <button id="btn-signup" type="submit" class="btn btn-info" name="checkwaivecode"><i class="icon-hand-right"></i> &nbsp; Validate</button>
                                        <span style="margin-left:8px;"></span>  
                                    </div>
                                </div>
                                
                                
                                </form>
                                <form id="signupform" class="form-horizontal" role="form" action="<?php echo $PHP_SELF;?>" method="post">
                                <div style="border-top: 1px solid #999; padding-top:20px"  class="form-group">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button id="btn-fbsignup" type="submit" name="next" class="btn btn-primary"><i class="icon-facebook"></i> &nbsp;&nbsp; &nbsp;&nbsp; Next for Non-Member Registration&nbsp;&nbsp;&nbsp; &nbsp; </button>
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
