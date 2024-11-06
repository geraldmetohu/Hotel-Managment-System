<?php
$title = 'Reservations';
include('includes/header.html');
require('includes/hotel_connect.php');
if (!isset($_SESSION['emp_id']) && !isset($_SESSION['user']['staffID'])) {
    header('location: index.php');
}
echo '<h1 id="amenities" class="text-center">Reservations</h1><hr>';

$q = "SELECT a.*, CONCAT(b.name,' ',b.lName) AS Client
        FROM rezervim AS a 
            INNER JOIN 
        klient AS b ON a.clientID = b.clientID";
$r = mysqli_query($dbc, $q);
?>

<div class="col-md-3">
    <input placeholder="From Date" type="text" name="from_date" id="from_date" class="form-control"
        onfocus="(this.type = 'date')" onblur="(this.type = 'text')" />
</div>

<div class="col-md-3">
    <input placeholder="To Date" type="text" name="to_date" id="to_date" class="form-control"
        onfocus="(this.type = 'date')" onblur="(this.type = 'text')" />
</div>

<div style="clear:both"></div>
<br />

<div class="col-md-6">
    <input type="text" name="search_text" id="search_text" placeholder="Search by Reservation Details"
        class="form-control" />
</div>

<div class="col-md-4">
    <input type="button" name="filter" id="filter" value="Filter" class="btn btn-primary" />
</div>

<div class="col-md-1">
    <a href="reserve.php" target="_blank" class="btn btn-success float-right"> Add Reservation </a>
</div>

<br>
<br>
<br>
<div id="order_table">
    <table id="data_table" width="100%" class="table table-hover">
        <thead>
            <tr class="table-header">
                <th align="left">Room No.</th>
                <th align="left">Client</th>
                <th align="left">Reservation Date</th>
                <th align="left">Check In Date</th>
                <th align="left">Check Out Date</th>
                <th align="left">No. of guests</th>
                <th align="left">Price</th>
                <th align="left" class="delete"></th>
            </tr>
        </thead>
        <tbody id="export_table">

            <?php
            $bg = '#d8effe';
            while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                $bg = ($bg == '#b3dbf6' ? '#d8effe' : '#b3dbf6');
                echo '<tr data-row-id="' . $row['resID'] . '" style="background-color:' . $bg . '">
                <td align="left" col-index="1">' . $row['roomID'] . '</td>
                <td align="left" class="editable-col inlineEdit" contenteditable="true" col-index="2" oldval="' . $row['Client'] . '">' . $row['Client'] . '</td>
                <td align="left" class="editable-col inlineEdit" contenteditable="true" col-index="3" oldval="' . $row['resDate'] . '">' . $row['resDate'] . '</td>
                <td align="left" class="editable-col inlineEdit" contenteditable="true" col-index="4" oldval="' . $row['checkIn'] . '">' . $row['checkIn'] . '</td>
                <td align="left" class="editable-col inlineEdit" contenteditable="true" col-index="5" oldval="' . $row['checkOut'] . '">' . $row['checkOut'] . '</td>
                <td align="left" class="editable-col inlineEdit" contenteditable="true" col-index="6" oldval="' . $row['guests'] . '">' . $row['guests'] . '</td>';
                echo '<td align="center" class="editable-col inlineEdit" contenteditable="true" col-index="7" oldval="' . $row['price'] . '">' . $row['price'] . '</td>
                <td align="center" col-index="7" class="delete"><a href="delete_res.php?id=' . $row['resID'] . '"><img src="includes/Trash-icon.png" width="20px" height="20px"></a></td>
            </tr>';
            }
            ?>
        </tbody>
        <!-- <tfoot> 
            <tr id="search_row">
                <td><input type="text" id="1" size="15" class="col-search" placeholder="Search by ID" /></td>
                <td><input type="text" id="2" size="15" class="col-search" placeholder="Search by Client" /></td>
                <td><input type="text" id="3" size="15" class="col-search" placeholder="Search by Room" /></td>
                <td><input type="text" id="4" size="15" class="col-search" placeholder="Search by date" /></td>
                <td><input type="text" id="5" size="15" class="col-search" placeholder="Search by check in" /></td>
                <td><input type="text" id="6" size="15" class="col-search" placeholder="Search by check out" /></td>
                <td><input type="text" id="7" size="15" class="col-search" placeholder="Search by guests" /></td>
                <td><input type="text" id="7" size="15" class="col-search" placeholder="Search by price" /></td>
                <td></td>
            </tr>
        </tfoot> -->
    </table>
</div>

<!-- <div class="col-md-12">
    <button style="float:right" class="btn btn-info" id="export_button"><img src="includes/download.png" height="20px" width="25px">Export </button>
</div> -->

<script>
    $(document).ready(function () {
        //Inline edit
        $('td.editable-col').on('focusout keydown', function (e) {
            if ((e.keyCode == 13)) {
                $(this).blur();
                data = {};
                data['val'] = $(this).text();
                data['id'] = $(this).parent('tr').attr('data-row-id');
                data['index'] = $(this).attr('col-index');
                if ($(this).attr('oldVal') === data['val'])
                    return false;

                $.ajax({
                    type: "POST",
                    url: "live_edit.php",
                    cache: false,
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        if (response.status) {
                            $("#msg").removeClass('alert-danger');
                            $("#msg").addClass('alert-success').html(response.msg);
                        } else {
                            $("#msg").removeClass('alert-success');
                            $("#msg").addClass('alert-danger').html(response.msg);
                        }
                    }
                });
            } else if (e.type == 'focusout') {
                data = {};
                data['val'] = $(this).text();
                data['id'] = $(this).parent('tr').attr('data-row-id');
                data['index'] = $(this).attr('col-index');
                if ($(this).attr('oldVal') === data['val'])
                    return false;

                $.ajax({
                    type: "POST",
                    url: "live_edit.php",
                    cache: false,
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        if (response.status) {
                            $("#msg").removeClass('alert-danger');
                            $("#msg").addClass('alert-success').html(response.msg);
                        } else {
                            $("#msg").removeClass('alert-success');
                            $("#msg").addClass('alert-danger').html(response.msg);
                        }
                    }
                });
            }
        });

        //date, search filter
        $('#filter').click(function () {
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            var search = $('#search_text').val();
            if (from_date <= to_date) {
                $.ajax({
                    url: "search.php",
                    method: "POST",
                    data: { query: search, from_date: from_date, to_date: to_date },
                    success: function (data) {
                        $('#order_table').html(data);
                    }
                });
            } else if (from_date > to_date) {
                alert("Start Date MUST precede End Date");
            } else {
                alert("Please Select Both Dates");
            }
        });

        // //column search
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
        //     bInfo: false,
        //     bPaginate: false,
        //     "dom": 'lrtip',
        //     "orderFixed": [ 0, 'asc' ]
        // });
        // $('#data_table tfoot tr').appendTo('#data_table thead');

        // //export table 
        // $('#export_button').click(function(){
        //     $('#data_table').tableHTMLExport({
        //         type: 'csv',
        //         filename: 'res-data.csv',
        //         ignoreColumns: '.delete',
        //         ignoreRows: '#search_row'
        //     });
        // });
    });  
</script>

<?php
include('includes/footer.html');
?>