<?php
/**
* Gather all data from Caldera Forms submission as PHP array
*/

function slug_process_form_test( $form ) {
    //echo "<script>alert('Done3..');</script>";
}

function slug_process_form( $form ) {
    
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
    //echo "<script>alert('success..');</script>";

    //echo "<script>alert('Done..');</script>";
   
    //put form field data into an array $data
    //$data= array();
   // foreach( $form[ 'fields' ] as $field_id => $field){
        $issm = Caldera_Forms::get_field_data( 'fld_2632313', $form ); 
        $sp = Caldera_Forms::get_field_data( 'fld_3533107', $form );
        $iasju = Caldera_Forms::get_field_data( 'fld_2892665', $form );
        $checkin = Caldera_Forms::get_field_data( 'fld_6337275', $form );
        //$checkout = Caldera_Forms::get_field_data( 'fld_5255442', $form );
        $numadults = Caldera_Forms::get_field_data( 'fld_5555764', $form );

        $num1 = Caldera_Forms::get_field_data( 'fld_8695269', $form );
        $num2 = Caldera_Forms::get_field_data( 'fld_7525731', $form );
        $num3 = Caldera_Forms::get_field_data( 'fld_1437000', $form );
        $num4 = Caldera_Forms::get_field_data( 'fld_6285044', $form );
        $num5 = Caldera_Forms::get_field_data( 'fld_6201737', $form );
		
		$a = Caldera_Forms::get_field_data( 'fld_3305495', $form );
        $b = Caldera_Forms::get_field_data( 'fld_6337275', $form );
        $c = Caldera_Forms::get_field_data( 'fld_8656675', $form );
        $d = Caldera_Forms::get_field_data( 'fld_3021383', $form );

        $numchild= $num1+ $num2+ $num3+ $num4+ $num5;


        $pernight = Caldera_Forms::get_field_data( 'fld_7240734', $form );
        $numnight = Caldera_Forms::get_field_data( 'fld_7084301', $form );
        $numpeople = Caldera_Forms::get_field_data( 'fld_3901592', $form );
        $storm = Caldera_Forms::get_field_data( 'fld_7141720', $form );
        $totlodg= Caldera_Forms::get_field_data( 'fld_2448720', $form );
        $totmeal= Caldera_Forms::get_field_data( 'fld_2475472', $form );
        $totreg= Caldera_Forms::get_field_data( 'fld_856084', $form );
        $grandtot= Caldera_Forms::get_field_data( 'fld_6307425', $form );

		$gender = Caldera_Forms::get_slug_data( 'gender', $form );
		
        $membertype = $_SESSION['memberType'];
        $fname =  $_SESSION["firstName"];
        $lname = $_SESSION["lastName"];
        $affiliation = $_SESSION['affiliation'];
        $title = $_SESSION['title'];
        $street =  $_SESSION['homeStreet'];
        $city = $_SESSION['homeCity'];
        $state = $_SESSION['homeState'];
        $zip =  $_SESSION['homeZip'];
        $email=$_SESSION['email'];
        $loginId = $_SESSION["KSEAId"];

        if($sp==''||$sp==NULL){
            $sp=0;
        }
        if($issm==''||$issm==NULL){
            $issm=0;
        }
        if($issm==''||$issm==NULL){
            $issm=0;
        }
 
     /*    echo "<script>alert('$checkin');</script>"; //empty
        echo "<script>alert('$issm');</script>"; //arrat
        echo "<script>alert('$sp');</script>"; //arrat
        echo "<script>alert('$iasju');</script>"; //arrat
        echo "<script>alert('$numadults ');</script>";
        echo "<script>alert('$numchild ');</script>";
        echo "<script>alert('$pernight ');</script>";
        echo "<script>alert('$storm ');</script>";
        echo "<script>alert('$numpeople ');</script>";
        echo "<script>alert('$numnight ');</script>";  */
 
		$sql = "INSERT INTO wp_registration_list(gender_field) VALUES ($gender)";
       
 
       
        if (mysqli_query($connection, $sql)) {
          //  echo "<script>alert('Inserted');</script>";
        } else {
          //  echo "<script>alert('Error');</script>";
        }
       
    //}
    //get embedded post ID.
    //$embeded_post_id = absint( $_POST[ '_cf_cr_pst' ] );
    /** DO SOMETHING WITH $data here **/
    mysqli_close($connection);
    
    
   
}

?>