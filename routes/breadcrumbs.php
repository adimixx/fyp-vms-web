<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use Illuminate\Http\Request;
use App\Models\VehicleInventory;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('home'));
});

Breadcrumbs::for('vehicle.index', function (BreadcrumbTrail $trail) {
    $trail->push('Vehicle Management', route('vehicle.index'));
});

Breadcrumbs::for('vehicle.create', function (BreadcrumbTrail $trail) {
    $trail->parent('vehicle.index');
    $trail->push('New Vehicle', route('vehicle.create'));
});


Breadcrumbs::for('vehicle.show', function (BreadcrumbTrail $trail, VehicleInventory $vehicle) {
    $trail->parent('vehicle.index');
    $trail->push('Vehicle Details', route('vehicle.show', $vehicle));
});


Breadcrumbs::for('complaint.index', function (BreadcrumbTrail $trail) {
    $trail->push('Complaint Management', route('complaint.index'));
});

Breadcrumbs::for('complaint.create', function (BreadcrumbTrail $trail) {
    $trail->parent('complaint.index');
    $trail->push('New Complaint', route('complaint.create'));
});

