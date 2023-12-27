<?php

require 'vendor/autoload.php';
require_once 'core/DatabaseSingleton.php';


use core\DatabaseSingleton;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

$app = AppFactory::create();

$pdo = (DatabaseSingleton::getInstance())->getPDO();

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$app->get('/sportsmen', function (Request $request, Response $response) use ($pdo) {
    $stmt = $pdo->query("SELECT * FROM sportsmen");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $response->getBody()->write(json_encode($data));

    return $response->withHeader('Content-Type', 'application/json');
});

$app->post('/sportsmen', function (Request $request, Response $response, $args) use ($pdo) {
    $data = $request->getParsedBody();
    $stmt = $pdo->prepare("INSERT INTO sportsmen (wins_count, full_name, dob, country) VALUES (?, ?, ?, ?)");
    $stmt->execute([$data['wins_count'], $data['full_name'], $data['dob'], $data['country']]);
    $response->getBody()->write(json_encode($data));

    return $response->withHeader('Content-Type', 'application/json');
});

$app->put('/sportsmen/{id}', function (Request $request, Response $response, $args) use ($pdo) {
    $id = $args['id'];
    $data = $request->getParsedBody();

    $stmt = $pdo->prepare("UPDATE sportsmen SET wins_count = ?, full_name = ?, dob = ?, country = ? WHERE id = ?");
    $stmt->execute([$data['wins_count'], $data['full_name'], $data['dob'], $data['country'], $id]);

    $response->getBody()->write(json_encode(['message' => 'Sportsman updated successfully']));

    return $response->withHeader('Content-Type', 'application/json');
});

$app->delete('/sportsmen/{id}', function (Request $request, Response $response, $args) use ($pdo) {
    $id = $args['id'];
    $stmt = $pdo->prepare("DELETE FROM sportsmen WHERE id = ?");
    $stmt->execute([$id]);

    $response->getBody()->write(json_encode(['message' => 'Sportsman deleted successfully']));

    return $response->withHeader('Content-Type', 'application/json');
});


$app->get('/results', function (Request $request, Response $response, $args) use ($pdo) {
    $stmt = $pdo->query("SELECT * FROM results");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/results/{id}', function (Request $request, Response $response, $args) use ($pdo) {
    $id = $args['id'];
    $stmt = $pdo->prepare("SELECT * FROM results WHERE id = ?");
    $stmt->execute([$id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$data) {
        return $response->withStatus(404)->getBody()->write(json_encode(['message' => 'Result not found']));
    }
    return $response->withHeader('Content-Type', 'application/json');
});

$app->post('/results', function (Request $request, Response $response, $args) use ($pdo) {
    $data = $request->getParsedBody();
    $stmt = $pdo->prepare("INSERT INTO results (sportsman_id, sport_id, title, result, place, location, date) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$data['sportsman_id'], $data['sportsman_id'], $data['title'], $data['result'], $data['place'], $data['location'], $data['date']]);
    $response->getBody()->write(json_encode(['message' => 'Result added successfully']));

    return $response->withHeader('Content-Type', 'application/json');
});

$app->put('/results/{id}', function (Request $request, Response $response, $args) use ($pdo) {
    $id = $args['id'];
    $data = $request->getParsedBody();

    $stmt = $pdo->prepare("UPDATE results SET sportsman_id = ?,sport_id = ?, title = ?, result = ?, place = ?, location = ?, date = ? WHERE id = ?");
    $stmt->execute([$data['sportsman_id'],$data['sportsman_id'], $data['title'], $data['result'], $data['place'], $data['location'], $data['date'], $id]);

    $response->getBody()->write(json_encode(['message' => 'Result updated successfully']));

    return $response->withHeader('Content-Type', 'application/json');
});

$app->delete('/results/{id}', function (Request $request, Response $response, $args) use ($pdo) {
    $id = $args['id'];
    $stmt = $pdo->prepare("DELETE FROM results WHERE id = ?");
    $stmt->execute([$id]);

    $response->getBody()->write(json_encode(['message' => 'Result deleted successfully']));

    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/sports', function (Request $request, Response $response, $args) use ($pdo) {
    $stmt = $pdo->query("SELECT * FROM sports");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return json_encode($response->getBody()->write($data));

    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/sports/{id}', function (Request $request, Response $response, $args) use ($pdo) {
    $id = $args['id'];
    $stmt = $pdo->prepare("SELECT * FROM sports WHERE id = ?");
    $stmt->execute([$id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$data) {
        return $response->withStatus(404)->getBody()->write(json_encode(['message' => 'Sport not found']));
    }

    return json_encode($response->getBody()->write($data));

    return $response->withHeader('Content-Type', 'application/json');
});

$app->post('/sports', function (Request $request, Response $response, $args) use ($pdo) {
    $data = $request->getParsedBody();
    $stmt = $pdo->prepare("INSERT INTO sports (unit, title, world_record, olympic_record) VALUES (?, ?, ?, ?)");
    $stmt->execute([$data['unit'], $data['title'], $data['world_record'], $data['olympic_record']]);
    $response->getBody()->write(json_encode(['message' => 'Sport added successfully']));

    return $response->withHeader('Content-Type', 'application/json');
});

$app->put('/sports/{id}', function (Request $request, Response $response, $args) use ($pdo) {
    $id = $args['id'];
    $data = $request->getParsedBody();

    $stmt = $pdo->prepare("UPDATE sports SET unit = ?, title = ?, world_record = ?, olympic_record = ? WHERE id = ?");
    $stmt->execute([$data['unit'], $data['title'], $data['world_record'], $data['olympic_record'], $id]);

    $response->getBody()->write(json_encode(['message' => 'Sport updated successfully']));

    return $response->withHeader('Content-Type', 'application/json');
});

$app->delete('/sports/{id}', function (Request $request, Response $response, $args) use ($pdo) {
    $id = $args['id'];
    $stmt = $pdo->prepare("DELETE FROM sports WHERE id = ?");
    $stmt->execute([$id]);

    $response->getBody()->write(json_encode(['message' => 'Sport deleted successfully']));

    return $response->withHeader('Content-Type', 'application/json');
});


$app->run();
