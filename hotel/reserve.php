<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,minimum-scale=1">
		<title>Hotel Reservation Form</title>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<link rel="stylesheet" href="formStyle.css">
	</head>
	<body>
		<form class="hotel-reservation-form" method="post" action="checkRoom.php">
			<h1><i class="far fa-calendar-alt"></i>Hotel Reservation Form</h1>
			<div class="fields">
                <div class="wrapper">
                    <div>
                        <label for="arrival">Arrival</label>
                        <div class="field">
                            <input id="arrival" type="text" name="arrival" required autocomplete="off">
                        </div>
                    </div>
                    <div class="gap"></div>
                    <div>
                        <label for="departure">Departure</label>
                        <div class="field">
                            <input id="departure" type="text" name="departure" required autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="wrapper">
                    <div>
                        <label for="first_name">First Name</label>
                        <div class="field">
                            <i class="fas fa-user"></i>
                            <input id="first_name" type="text" name="first_name" placeholder="First Name" required>
                        </div>
                    </div>
                    <div class="gap"></div>
                    <div>
                        <label for="last_name">Last Name</label>
                        <div class="field">
                            <i class="fas fa-user"></i>
                            <input id="last_name" type="text" name="last_name" placeholder="Last Name" required>
                        </div>
                    </div>
                </div>
                <label for="email">Email</label>
                <div class="field">
                    <i class="fas fa-envelope"></i>
                    <input id="email" type="email" name="email" placeholder="Your Email" required>
                </div>
                <label for="phone">Phone</label>
                <div class="field">
                    <i class="fas fa-phone"></i>
                    <input id="phone" type="tel" name="phone" placeholder="Your Phone Number" required>
                </div>
                <div class="wrapper">
                    <div>
                        <label for="adults">Adults</label>
                        <div class="field">
                            <input type="number" id="adults" name="adults" min="1" max="10" value="1">
                        </div>
                    </div>
                    <div class="gap"></div>
                    <div>
                        <label for="children">Children</label>
                        <div class="field">
                            <input type="number" id="children" name="children" min="0" max="4" value="0">
                        </div>
                    </div>
                </div>
                <label for="room_pref">Room Preference</label>
                <div class="field">
                    <select id="room_pref" name="room_pref" required>
                        <option selected value="Any">Any Room</option>
                        <option value="Any">Any Room</option>
                        <option value="Single">Single</option>
                        <option value="Couples">Couple</option>
                        <option value="Standard">Standard</option>
                        <option value="Family">Family</option>
                        <option value="Suite">Suite</option>
                        <option value="Presidential Suite">Presidential Suite</option>
                    </select>
                </div>
                <input type="submit" value="Check Room">
			</div>
		</form>
	</body>
    <script>
        $(document).ready(function(){
            let validate = 0;

            $("#arrival").datepicker({
                dateFormat: "yy-mm-dd",
                showAnim: 'slideDown',
                minDate: 0,
                onSelect: function (date) {
                    validate = 1;
                    var date2 = $('#arrival').datepicker('getDate');
                    $('#departure').datepicker({
                        showAnim: 'slideDown',
                        dateFormat: 'yy-mm-dd'
                    });
                    date2.setDate(date2.getDate() + 1);
                    $('#departure').datepicker('setDate', date2);
                    $('#departure').datepicker('option', 'minDate', date2);
                }
            });

            $('#departure').on('click', function(){
                if(validate == 0){
                    alert('Please select arrival date first.');
                }
            });
            
        });
    </script>
</html>