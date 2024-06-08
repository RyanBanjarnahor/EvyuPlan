<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('admin.home_index', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('admin.home_index'));
});

// Event breadcrumbs
Breadcrumbs::for('admin.event.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home_index');
    $trail->push('Events', route('admin.event.index'));
});

Breadcrumbs::for('admin.event.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.event.index');
    $trail->push('Create', route('admin.event.create'));
});

Breadcrumbs::for('admin.event.show', function (BreadcrumbTrail $trail, $event) {
    $trail->parent('admin.event.index');
    $trail->push($event->title, route('admin.event.show', $event));
});

Breadcrumbs::for('admin.event.edit', function (BreadcrumbTrail $trail, $event) {
    $trail->parent('admin.event.index');
    $trail->push('Edit '. $event->title, route('admin.event.edit', $event));
});

// Event Request breadcrumbs
Breadcrumbs::for('admin.eventRequest.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home_index');
    $trail->push('Event Requests', route('admin.eventRequest.index'));
});

Breadcrumbs::for('admin.eventRequest.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.eventRequest.index');
    $trail->push('Create', route('admin.eventRequest.create'));
});

Breadcrumbs::for('admin.eventRequest.show', function (BreadcrumbTrail $trail, $eventRequest) {
    $trail->parent('admin.eventRequest.index');
$trail->push($eventRequest->title, route('admin.eventRequest.show', $eventRequest));
});

Breadcrumbs::for('admin.eventRequest.edit', function (BreadcrumbTrail $trail, $eventRequest) {
    $trail->parent('admin.eventRequest.index');
    $trail->push('Edit '. $eventRequest->title, route('admin.eventRequest.edit', $eventRequest));
});

// User breadcrumbs
Breadcrumbs::for('admin.user.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home_index');
    $trail->push('Users', route('admin.user.index'));
});

Breadcrumbs::for('admin.user.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.user.index');
    $trail->push('Create', route('admin.user.create'));
});

Breadcrumbs::for('admin.user.edit', function (BreadcrumbTrail $trail, $user) {
    $trail->parent('admin.user.index');
    $trail->push('Edit '. $user->name, route('admin.user.edit', $user));
});

Breadcrumbs::for('admin.user.show', function (BreadcrumbTrail $trail, $user) {
    $trail->parent('admin.user.index');
    $trail->push($user->name, route('admin.user.show', $user));
});

// Category Type breadcrumbs categoryType
Breadcrumbs::for('admin.categoryType.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home_index');
    $trail->push('Users', route('admin.categoryType.index'));
});

Breadcrumbs::for('admin.categoryType.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.categoryType.index');
    $trail->push('Create', route('admin.categoryType.create'));
});

Breadcrumbs::for('admin.categoryType.edit', function (BreadcrumbTrail $trail, $categoryType) {
    $trail->parent('admin.categoryType.index');
    $trail->push('Edit '. $categoryType->name, route('admin.categoryType.edit', $categoryType));
});

Breadcrumbs::for('admin.categoryType.show', function (BreadcrumbTrail $trail, $categoryType) {
    $trail->parent('admin.categoryType.index');
    $trail->push($categoryType->name, route('admin.categoryType.show', $categoryType));
});



