<style type="text/css">
   #map {
     width: auto;
     height: 500px;
   }
 </style>

<?php include '../header.php'; ?>

    <div class="container" style="margin-top:3%">

      <div class="blog-header">
        <h1 class="blog-title">Reported Crime</h1>

      </div>

      <div class="row">

        <div class="col-sm-8 blog-main">

          <div class="span11">
       <div id="map"></div>
     </div>
     



        </div><!-- /.blog-main -->

        <?php include '../sidebar.php'; ?>

      </div><!-- /.row -->

    </div><!-- /.container -->

    <script type="text/javascript">
        var map;
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
        });

        function callMyMap(lat,lon)
        {
          console.log("lat"+lat+"--------lon "+lon);
          map = new GMaps({
            div: '#map',
            lat: lat,
            lng: lon,
            markerClusterer: function(map) {
              return new MarkerClusterer(map);
            }
          });

          var lat_span = lat - (lat-0.02);
          var lng_span = lon - (lon-0.02);

          for(var i = 0; i < 100; i++)
{
            var latitude = Math.random()*(lat_span) + (lat-0.02);
            var longitude = Math.random()*(lng_span) + (lon-0.02);

              console.log("lat"+latitude+"--------lon "+longitude)

            map.addMarker({
              lat: latitude,
              lng: longitude,
              title: 'Marker #' + i
            });
          }
}

      </script>
