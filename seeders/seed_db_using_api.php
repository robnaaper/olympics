<?php

$baseApiUrl = 'http://localhost:8000';

function postData($url, $data, $parameters = []) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Set POST data
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_POST, 1);

    // Set additional parameters in the request body
    if (!empty($parameters)) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array_merge($data, $parameters)));
    }

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}


// Dummy data for sportsmen
for ($i = 1; $i <= 100; $i++) {
    $sportsmenData = [
        'wins_count' => rand(1, 50),
        'full_name' => "Sportsman $i",
        'dob' => '1990-01-15',
        'country' => 'Country ' . $i,
    ];

    postData($baseApiUrl . '/sportsmen', $sportsmenData);
}

// Dummy data for sports
for ($i = 1; $i <= 100; $i++) {
    $sportsData = [
        'unit' => "Unit $i",
        'title' => "Sport $i",
        'world_record' => rand(9, 12) . '.' . rand(1, 99) . ' seconds',
        'olympic_record' => rand(9, 12) . '.' . rand(1, 99) . ' seconds',
    ];

    postData($baseApiUrl . '/sports', $sportsData);
}

// Dummy data for results
for ($i = 1; $i <= 100; $i++) {
    $resultsData = [
        'sportsman_id' => rand(1, 100),
        'sport_id' => rand(1, 100), // Added sport_id
        'title' => "Result $i",
        'result' => 'Place ' . rand(1, 10),
        'place' => rand(1, 10),
        'location' => "City $i",
        'date' => '2023-01-' . sprintf("%02d", $i),
    ];

    postData($baseApiUrl . '/results', $resultsData);
}

echo "Dummy data inserted successfully.\n";
echo "Dummy data inserted successfully.\n";
