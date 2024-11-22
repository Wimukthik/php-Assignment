<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>China Provinces</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2>China Provinces with Latitudes and Longitudes</h2>
        <table class="table table-bordered" id="provincesTable">
            <thead>
                <tr>
                    <th>Province</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Initialize cURL
                $curl = curl_init();

                // Set cURL options
                curl_setopt_array($curl, [
                    CURLOPT_URL => "https://covid-19-statistics.p.rapidapi.com/reports?iso=CHN",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HTTPHEADER => [
                        "X-RapidAPI-Host: covid-19-statistics.p.rapidapi.com",
                        "X-RapidAPI-Key: 7be528c5f7msh12910bb5f622d04p1dcc31jsna7c98f8d0b63"
                    ],
                ]);

                // Execute cURL request
                $response = curl_exec($curl);
                curl_close($curl);
                $data = json_decode($response, true);

                // Extract province names, latitudes, and longitudes
                foreach ($data['data'] as $province) {
                    $provinceName = htmlspecialchars($province['region']['province']);
                    $latitude = htmlspecialchars($province['region']['lat']);
                    $longitude = htmlspecialchars($province['region']['long']);
                    echo "<tr>
                            <td>$provinceName</td>
                            <td>$latitude</td>
                            <td>$longitude</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
