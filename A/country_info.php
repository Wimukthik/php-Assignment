<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Country Information</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        #countryInfo {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Select a Country</h2>
        <select class="form-control" id="countrySelect">
            <option value="">Select a country</option>
        </select>

        <div id="countryInfo" class="mt-4">
            <h3>Country Details</h3>
            <img id="flag" src="" alt="Country Flag" style="width: 150px;">
            <p><strong>Official Name:</strong> <span id="officialName"></span></p>
            <p><strong>Capital City:</strong> <span id="capital"></span></p>
            <p><strong>Region:</strong> <span id="region"></span></p>
            <p><strong>Subregion:</strong> <span id="subregion"></span></p>
            <p><strong>Currencies:</strong> <span id="currencies"></span></p>
            <p><strong>Country Code:</strong> <span id="countryCode"></span></p>
            <p><strong>Population:</strong> <span id="population"></span></p>
            <p><strong>Area:</strong> <span id="area"></span> km²</p>
            <p><strong>Borders:</strong> <span id="borders"></span></p>
            <h5>Location:</h5>
            <div id="map" style="height: 400px;"></div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Fetch countries data and populate dropdown
            $.ajax({
                url: "https://restcountries.com/v3.1/all",
                method: "GET",
                success: function (data) {
                    data.forEach(country => {
                        const countryName = country.name.common;
                        const countryCode = country.cca3;
                        $("#countrySelect").append(`<option value="${countryCode}">${countryName}</option>`);
                    });
                },
                error: function (error) {
                    console.error("Error fetching countries:", error);
                }
            });

            // On country selection
            $("#countrySelect").change(function () {
                const selectedCountryCode = $(this).val();
                if (selectedCountryCode) {
                    $.ajax({
                        url: `https://restcountries.com/v3.1/alpha/${selectedCountryCode}`,
                        method: "GET",
                        success: function (data) {
                            const country = data[0];
                            $("#flag").attr("src", country.flags.png);
                            $("#officialName").text(country.name.official);
                            $("#capital").text(country.capital ? country.capital[0] : "N/A");
                            $("#region").text(country.region);
                            $("#subregion").text(country.subregion);
                            $("#currencies").text(Object.values(country.currencies).map(c => c.name).join(", "));
                            $("#countryCode").text(country.cca2);
                            $("#population").text(country.population);
                            $("#area").text(country.area);
                            $("#borders").text(country.borders ? country.borders.join(", ") : "None");

                            // Initialize Google Map
                            const lat = country.latlng[0];
                            const lng = country.latlng[1];
                            initMap(lat, lng);
                            $("#countryInfo").show();
                        },
                        error: function (error) {
                            console.error("Error fetching country details:", error);
                        }
                    });
                } else {
                    $("#countryInfo").hide();
                }
            });

            // Google Map initialization function
            function initMap(lat, lng) {
                const map = new google.maps.Map(document.getElementById("map"), {
                    center: { lat: lat, lng: lng },
                    zoom: 5,
                });
                new google.maps.Marker({
                    position: { lat: lat, lng: lng },
                    map: map,
                });
            }
        });
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD72Dx5k_cdHn6iJ9cfUyjuuB4n2u_gTaw&q"></script>
</body>
</html>
