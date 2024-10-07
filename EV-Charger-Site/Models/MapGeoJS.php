<?php

class mapGeoJS
{
    //this function returns the javascript which find the users location
    function getLocationCode(){

        $code = "<script>
            let lat;
            let long;
            let status1 = document.getElementById('error');
            //let x = document.getElementById('output');
            if(!navigator.geolocation){
                //status1.innerHTML = 'Enable Location to view map';
            }else{
                status1.textContent = '';
                navigator.geolocation.getCurrentPosition(showPosition,errorCallback);
            }
            
            function showPosition(position){  //gets the lat and long values 
             //creates map focusing view on users location    
            let map = L.map('map').setView([position.coords.latitude , position.coords.longitude], 11);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png',{
            maxZoom: 19,
            attribution: '&copy; <a href=\'http://www.openstreetmap.org/copyright\'>OpenStreetMap</a>'
            }).addTo(map);
            
             L.circleMarker([position.coords.latitude , position.coords.longitude]).addTo(map)
                    .bindPopup('Current Location');";

            $code .= $this->getMarkers();

            //calls for error in obtaining user locations
            //create a map with set view having hard coded coordinate values so map loads
            $code .= " 
               function errorCallback(error){ //shows error to user
                alert('ERROR(' + error.code + ') ' + error.message );
                status1.innerHTML = 'Enable Location to view the closest charge points to your current location';
                
                let map = L.map('map').setView([53.4835 , -2.2707], 11);

                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png',{
                maxZoom: 19,
                attribution: '&copy; <a href=\'http://www.openstreetmap.org/copyright\'>OpenStreetMap</a>'
                }).addTo(map);";

            $code .= $this->getMarkers() . "
            </script>";

        return $code;
    }

    //gets the link required for leaftlet
    function getLeafletLink(){
        $leafletLink = '<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
             integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM="
             crossorigin=""></script>';

            return $leafletLink;
    }

    //gets the function to create markers on the map
    private function getMarkers(){
        $code = "var xhr = new XMLHttpRequest(); 
                    xhr.open('GET', 'markers.php', true);
                    xhr.send();

                    let popUpOption = {\"closeButton\" : false};

                    xhr.onreadystatechange = function (){
                        if (xhr.readyState == 4 && xhr.status == 200){
                            let data = JSON.parse(xhr.responseText);
                            data.forEach(function (obj){
                            let markerText = '<address>' + obj.address + '<br/>' + obj.postcode + '</address><p>£' + obj.cost + '</p>';
                            let marker =  L.marker([obj.lat, obj.lng]).addTo(map).on('mouseover', event=> { event.target.bindPopup(markerText).openPopup(); })
                            .on('mouseout', event=> { event.target.closePopup(); });;
                        })
                    }
                }
            }";

        return $code;
    }
}