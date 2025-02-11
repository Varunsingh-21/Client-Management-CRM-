<!-- 
    Name: Varun Deep Singh
    Date: September 29th,2023
    File Name: functions.php
 -->
 
<?php
// function to add log data to the file
function append_to_file($action,$status,$email_address){
    $day=date("Ymd");
    $log=fopen('./logs/'.$day.'_log.txt','a');
    $now=date("Y-m-d G:i:s");
    fwrite($log,$action.' '.$status." at ".$now." User ".$email_address.strtolower($action)." \n");
    fclose($log);
}
//function to display forms at different pages
function display_form($form_user){
    echo '<form class="form-signin" enctype="multipart/form-data" action = "'.$_SERVER['PHP_SELF'].'" method="POST">';
    echo '<h1 class="h3 mb-3 font-weight-normal">Please Enter The Following.</h1>';
    foreach($form_user as $element){
        if($element['type'] == "text" || $element['type'] == 'email' || $element['type'] == "password"||$element["type"] == "datetime-local"||$element["type"] =="file"){
            echo '<label for="'.$element['name'].'" class="sr-only">'.$element['label'].'</label>';
            echo '<input type="'.$element['type'].'" name="'.$element['name'].'" id="'.$element['name'].'" class="form-control" placeholder="'.$element['label'].'" value="'.$element['value'].'" autofocus>';
        }
        elseif($element['type'] == "submit" || $element['type'] == "reset"){
            echo '<button class="btn btn-lg btn-primary btn-block" type="'.$element['type'].'">'.$element['label'].'</button>';
        }
        elseif($element['type'] == "select"){
            if($_SESSION['user']['usertype']!= ADMIN){
                echo '<select name="selection" class="form-control" >';
                echo'<option value="'.$_SESSION['user']['emailaddress'].'">';
                echo $_SESSION['user']['emailaddress'];
                echo '</option>';
                echo "</select>";
            }
            else{

                $sales=result_from_sales();
                echo '<select name="selection" class="form-control">';
                while($element1=pg_fetch_row($sales)){
                    echo'<option value='.'"'.$element1[2].'"'.'>';
                    echo $element1[0]." ".$element1[1]." ".$element1[2];
                    echo '</option>';
                }
                echo '</select>';
            }

        }
        elseif($element['type'] == 'textarea'){
            echo '<textarea name="notes" rows="3" colns="100" class="form-control">';
            echo '</textarea>';
    }
    elseif($element['type'] == 'select2'){
        $sales=results_from_clients();
        echo '<select name="selection2" class="form-control">';
        while($element1=pg_fetch_row($sales)){
            echo'<option value="'.$element1[1].'">';
            echo $element1[1];
            echo '</option>';
        }
        echo '</select>';
    }
}
echo '</form>';
}




/////////////////////////////////////////////////////////////////////////////


function display_table($feilds,$records,$count,$page)
{
    echo'<div>';
    echo'<table class="table table-striped">';
    echo'<thead>';
    echo'<tr>';
    foreach($feilds as $key => $value)
    {
        echo'<th scope="col">'.$value.'</th>';
    }
    echo'</tr>';
    echo'</thead>';
    echo'<tbody>';
    for($i=0; $i<count($records); $i++)
    {
        echo'<tr>';
        $j=1;
        foreach($records[$i] as $key1 => $value1)
        {
            if(str_contains($value1, 'upload')){
                echo '<td>'."<img src='".$value1."'" . "width=50px height=50px".'</td>';
            }
            else{
                echo'<td>'.$value1.'</td>';  
            }
            $j=$j+1;
        }
        echo'</tr>';
    }
        
    echo'</tbody>';
    echo'</table>';
    echo'<nav aria-label="Page navigation example">';
    echo'<ul class="pagination">';
    echo'<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.(($page>1)?--$page:$page).'">Previous</a></li>';
    for($i=0;$i <$count/RECORDS; $i++)
    {
        echo'<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.($i+1).'">'.($i+1).'</a></li>';
    }
    echo'<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.(($page<$count/RECORDS)?++$page:$page).'">Next</a></li>';
    echo'</ul>';
    echo'</nav>';
    echo'</div>';

    ///////////////////////////////////////////////////////////////////////
}




















            ?>
