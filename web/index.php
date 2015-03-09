<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();

$app['debug'] = true;

$app->register(
    new Silex\Provider\TwigServiceProvider(),
    ['twig.path' => __DIR__ . '/../views']
);

$app['skill_file_parser'] = function () {
    return new \BadgeBatch\SkillFileParser();
};

$app['skill_repository'] = function () use ($app) {
    return new \BadgeBatch\SkillRepository(__DIR__ . '/../data', $app['skill_file_parser']);
};

$app['skill_matrix'] = function () use ($app) {
    return new \BadgeBatch\SkillMatrix($app['skill_repository']);
};

$app->get(
    '/',
    function () use ($app) {

        /** @var \BadgeBatch\SkillRepository $skillRepository */
        $skillRepository = $app['skill_repository'];

        return $app['twig']->render(
            'index.html.twig',
            ['matrix' => $app['skill_matrix']->get()]
        );
    }
);

$app->run();
