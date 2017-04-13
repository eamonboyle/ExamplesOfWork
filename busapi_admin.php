<div class="wrap">
   <h1>Bus Api</h1>
    <p>Please type your postcode</p>
    <p id="error" style="display: none; color: #FF0000;">Please fill in a postcode</p>
    <form id="form">
        <input type="text" id="postcode" placeholder="POSTCODE" value="bs42xj">
        <button type="submit" id="submit">
            Submit
        </button>
    </form>

    <script
      src="https://code.jquery.com/jquery-3.2.1.min.js"
      integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
      crossorigin="anonymous"></script>
    <script type="text/javascript">

        // interview test program 
        // takes a postcode
        // calls google / transport api 
        // outputs a list of nearby bus stops

        // declare variables
        var postcode, lat, lng;

        // On submit
        $('#form').on('submit', function(e) {

            // prevent the form from submitting
            e.preventDefault();

            // Hide the error
            $('#error').fadeOut();

            // remove the list
            $('.stops-list').remove();

            // Check if the postcode is present
            if($('#postcode').val().length) {

                // assign the postcode into a variable
                postcode = $('#postcode').val();

                // Postcode is present -- continue with the program
                // get the json lat lng from google api
                $.getJSON('http://maps.googleapis.com/maps/api/geocode/json?address=' + postcode, function(data) {

                    // get the lat / lng from the api
                    lat = data['results'][0]['geometry']['location']['lat'];
                    lng = data['results'][0]['geometry']['location']['lng'];
                    // get the bus stops from the transport api
                    $.getJSON('http://transportapi.com/v3/uk/bus/stops/near.json?lat=' + lat + '&lon=' + lng + '&app_id=1403ee9a&app_key=fa018b243dec452605ed2cf555e369b1', function(data2) {

                        // declare the empty stops array
                        var stops = [];
                        
                        // loop through all of the stops
                        $.each(data2['stops'], function(key, value) {
                            // add it to the stops array
                            stops.push(value['stop_name']);
                        });

                        // make the stops array unique
                        $.unique(stops);

                        // order the array alphabetically
                        stops.sort();

                        // output the list under the form
                        $( "<ul/>", {
                            "class": "stops-list",
                            "style": "padding: 0; margin: 0;",
                            html: stops.join( "<br>" )
                          }).appendTo( "body" );

                    });

                });

            } else {
                // The postcode is not present. Show the error
                $('#error').fadeIn();
            } // endif

        });

    </script>
</div>