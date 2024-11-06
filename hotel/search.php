<?php 
require('includes/hotel_connect.php');

$query = "SELECT a.*, CONCAT(b.name,' ',b.lName) AS Client
FROM rezervim AS a 
    INNER JOIN 
klient AS b ON a.clientID = b.clientID";

$flag = 0;


if(!empty($_POST['from_date']) && !empty($_POST['to_date'])){
    $flag = 1;

    $query .= ' WHERE resDate BETWEEN \''.$_POST['from_date'].'\' AND \''.$_POST['to_date'].'\' ';
}



if(isset($_POST['query']) && $flag == 0){
    $query .= " WHERE (resID LIKE '%{$_POST['query']}%' 
         OR CONCAT(b.name,' ',b.lName) LIKE '%{$_POST['query']}%'
         OR roomID LIKE '%{$_POST['query']}%'
         OR resDate LIKE '%{$_POST['query']}%'
         OR checkIn LIKE '%{$_POST['query']}%'
         OR checkOut LIKE '%{$_POST['query']}%'
         OR guests LIKE '%{$_POST['query']}%'
         OR price LIKE '%{$_POST['query']}%') ";
}

if(isset($_POST['query']) && $flag == 1){
    $query .= "AND (resID LIKE '%{$_POST['query']}%' 
    OR CONCAT(b.name,' ',b.lName) LIKE '%{$_POST['query']}%'
    OR roomID LIKE '%{$_POST['query']}%'
    OR resDate LIKE '%{$_POST['query']}%'
    OR checkIn LIKE '%{$_POST['query']}%'
    OR checkOut LIKE '%{$_POST['query']}%'
    OR guests LIKE '%{$_POST['query']}%'
    OR price LIKE '%{$_POST['query']}%') ";
}

$result = mysqli_query($dbc, $query);
echo '
<table id="data_table" width="100%" class="table table-bordered ">
<thead>
    <tr class="table-header"> 
        <th align="left">Reservation No.</th>
        <th align="left">Client</th>
        <th align="left">Room No.</th>
        <th align="left">Reservation Date</th>
        <th align="left">Check In Date</th>
        <th align="left">Check Out Date</th>
        <th align="left">No. of guests</th>
        <th align="left">Price</th>
        <th align="left" class="delete"></th>
    </tr> 
</thead>
<tbody id="export_table">
    
    ';
if(mysqli_num_rows($result) > 0){
    $bg = '#d8effe';
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        $bg = ($bg == '#b3dbf6' ? '#d8effe' : '#b3dbf6');
        echo '<tr data-row-id="'.$row['resID'].'" style="background-color:'.$bg.'">
                <td align="left" col-index="0">'.$row['resID'].'</td>
                <td align="left" class="editable-col inlineEdit" contenteditable="true" col-index="1" oldval="'.$row['Client'].'">'.$row['Client'].'</td>
                <td align="left" class="editable-col inlineEdit" contenteditable="true" col-index="2" oldval="'.$row['roomID'].'">'.$row['roomID'].'</td>
                <td align="left" class="editable-col inlineEdit" contenteditable="true" col-index="3" oldval="'.$row['resDate'].'">'.$row['resDate'].'</td>
                <td align="left" class="editable-col inlineEdit" contenteditable="true" col-index="4" oldval="'.$row['checkIn'].'">'.$row['checkIn'].'</td>
                <td align="left" class="editable-col inlineEdit" contenteditable="true" col-index="5" oldval="'.$row['checkOut'].'">'.$row['checkOut'].'</td>
                <td align="left" class="editable-col inlineEdit" contenteditable="true" col-index="6" oldval="'.$row['guests'].'">'.$row['guests'].'</td>';
                echo '<td align="center" class="editable-col inlineEdit" contenteditable="true" col-index="7" oldval="'.$row['price'].'">'.$row['price'].'</td>
                <td align="center" col-index="7" class="delete"><a href="delete_res.php?id=' . $row['resID'].'"><img src="includes/Trash-icon.png" width="20px" height="20px"></a></td>
            </tr>';
    }
        echo '</tbody>
        ';
}

?>

<script>  
    $(document).ready(function(){ 
        //Inline edit
        $('td.editable-col').on('focusout keydown', function(e){
            if((e.keyCode == 13)){
                $(this).blur(); 
                data = {};
                data['val'] = $(this).text();
                data['id'] = $(this).parent('tr').attr('data-row-id');
                data['index'] = $(this).attr('col-index');
                if($(this).attr('oldVal') === data['val'])
                    return false;
            
                $.ajax({   
                    type: "POST",  
                    url: "live_edit.php",  
                    cache:false,  
                    data: data,
                    dataType: "json",       
                    success: function(response)  
                    {   
                        if(response.status) {
                            $("#msg").removeClass('alert-danger');
                            $("#msg").addClass('alert-success').html(response.msg);
                        }else {
                            $("#msg").removeClass('alert-success');
                            $("#msg").addClass('alert-danger').html(response.msg);
                        }
                    }   
                });
            }else if(e.type == 'focusout'){
                data = {};
                data['val'] = $(this).text();
                data['id'] = $(this).parent('tr').attr('data-row-id');
                data['index'] = $(this).attr('col-index');
                if($(this).attr('oldVal') === data['val'])
                    return false;
            
                $.ajax({   
                    type: "POST",  
                    url: "live_edit.php",  
                    cache:false,  
                    data: data,
                    dataType: "json",       
                    success: function(response)  
                    {   
                        if(response.status) {
                            $("#msg").removeClass('alert-danger');
                            $("#msg").addClass('alert-success').html(response.msg);
                        }else {
                            $("#msg").removeClass('alert-success');
                            $("#msg").addClass('alert-danger').html(response.msg);
                        }
                    }   
                });
            }
        });
        
        //column search
        // var table = $('#data_table').DataTable({
        //     initComplete: function () {
        //         this.api()
        //         .columns()
        //         .every(function () {
        //             var that = this;
        //             $('input', this.footer()).on('keyup change clear', function () {
                        
        //                 if (that.search() !== this.value) {
                            
        //                     that.search(this.value).draw();
        //                 }
        //             });
        //         });
        //     },
        //     retrieve: true,
        //     bInfo: false,
        //     bPaginate: false,
        //     "dom": 'lrtip',
        //     "orderFixed": [ 0, 'asc' ],
        //     "language": {
        //         "emptyTable": "No appointments found"
        //     }
        // });
        // $('#data_table tfoot tr').appendTo('#data_table thead');
    });  
 </script>
