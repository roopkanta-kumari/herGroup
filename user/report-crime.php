<style type="text/css">
   #map {
     width: auto;
     height: 500px;
   }
 </style>
<?php include '../header.php'; ?>

    <div class="container" style="margin-top:5%">



      <div class="row">

        <div class="col-sm-8 blog-main">

          <div class="row">

             <div id="map"></div>


               <form method="post" id="geocoding_form"  style="float: right;">
                 <label for="address">Address:</label>
                 <div class="input">
                   <input type="text" id="address" name="address" value=""/>
                   <input type="submit" class="btn" value="Search" />
                 </div>
               </form>

               <form method="post" id="geocoding_form_issue">
                 <label for="address">Description:</label>
                 <div class="input">
                   <textarea id="crimeDescription" rows="1" cols="110"  value="">
                  </textarea>
                   <input type="submit" class="btn btn-danger" value="Report"style="margin-bottom: 4%;" />
                 </div>
               </form>



           </div>


        </div><!-- /.blog-main -->

        <?php include '../sidebar.php'; ?>

      </div><!-- /.row -->

    </div><!-- /.container -->
    <script type="text/javascript">
        var map;

        var map;
        $(document).ready(function(){

        });


        $(document).ready(function(){
          GMaps.geolocate({
            success: function(position){
              callMyMap(position.coords.latitude, position.coords.longitude);
            },
            error: function(error){
              alert('Geolocation failed: '+error.message);
            },
            not_supported: function(){
              alert("Your browser does not support geolocation");
            },
            always: function(){
              console.log("Located you !")
            }
          });

          $('#geocoding_form').submit(function(e){
            e.preventDefault();
            GMaps.geocode({
              address: $('#address').val().trim(),
              callback: function(results, status){
                if(status=='OK'){
                  var latlng = results[0].geometry.location;
                  map.setCenter(latlng.lat(), latlng.lng());
                  map.addMarker({
                    lat: latlng.lat(),
                    lng: latlng.lng()
                  });
                }
              }
            });
          });

          $('#geocoding_form_issue').submit(function(e){
            e.preventDefault();
            GMaps.geocode({
              address: $('#address').val().trim(),
              callback: function(results, status){
                if(status=='OK'){
                  var latlng = results[0].geometry.location;
                  var lat = latlng.lat();
                  var lng = latlng.lng();
                  console.log("Post lat and long "+"Lat"+latlng.lat() +"long"+latlng.lng());
                  // insertdetails($userid,$lat, $long,$description, $time) ;

                  // map.setCenter(latlng.lat(), latlng.lng());
                  // map.addMarker({
                  //   lat: latlng.lat(),
                  //   lng: latlng.lng()
                  // });
                }
              }
            });
          });

          function callMyMap(lat,lon)
          {
            map = new GMaps({
              el: '#map',
              lat: lat,
              lng: lon
            });}

        });
      </script>
