<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<? include("../../../include/include_bt_and_jq_3.php"); ?>
<style>
  /* Always set the map height explicitly to define the size of the div
   * element that contains the map. */
  #map {
    height: 100%;
  }
  /* Optional: Makes the sample page fill the window. */
  html, body {
    height: 100%;
    margin: 0;
    padding: 0;
  }
</style>
<title></title>
</head>
<body>


<div id="map"></div>    
   
<script>
      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 15,
          center: {lat: 22.9965187, lng: 120.179425 }
        });

       

       

        // Add 5 markers to map at random locations.
        // For each of these markers, give them a title with their index, and when
        // they are clicked they should open an infowindow with text from a secret
        // message.
        var secretMessages = ['<img src="a.jpg"/><br/>台南<br/><a href="https://www.hotel-tainan.com.tw/" target="_blank">連結</a>', 'bbb<br/><a href="https://www.youtube.com/">is</a>', 'the', 'secret', 'message'];        
        for (var i = 0; i < secretMessages.length; ++i) {
          if(i==0)  
          { 
             var marker = new google.maps.Marker({
               draggable: true,  
               position: {lat: 22.9965187 + 0.01 * Math.random(),lng: 120.179425 + 0.01 * Math.random()},               
               map: map
             });
          }else{
             var marker = new google.maps.Marker({
               draggable: true,  
               position: {lat: 22.9965187 + 0.01 * Math.random(),lng: 120.179425 + 0.01 * Math.random()},
               icon: 'blue-dot.png',
               map: map
             });
          }
          attachSecretMessage(marker, secretMessages[i]);
        }
      }

      // Attaches an info window to a marker with the provided message. When the
      // marker is clicked, the info window will open with the secret message.
      function attachSecretMessage(marker, secretMessage) {
        var infowindow = new google.maps.InfoWindow({
          content: secretMessage
        });

        marker.addListener('mouseover', function() {
          infowindow.open(marker.get('map'), marker);
        });
        
        marker.addListener('mouseout', function() {
          infowindow.close();
        });
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCfUOtz9m46DdBfzC_lC8EKob4lN96cmtY&callback=initMap">
    </script>



</body>
</html>
