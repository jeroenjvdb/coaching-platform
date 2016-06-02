<?php

Breadcrumbs::register('group', function($breadcrumbs, $group)
{
    $breadcrumbs->push($group->name, route('groups.show', [
        'group' => $group->slug,
    ]));
});

Breadcrumbs::register('swimmer', function($breadcrumbs, $group, $swimmer)
{
    $breadcrumbs->parent('group', $group);
    $breadcrumbs->push($swimmer->first_name . ' ' . $swimmer->last_name, route('{group}.swimmer.show', [
        'group' => $group->slug,
        'swimmer' => $swimmer->slug,
    ]));
});

Breadcrumbs::register('{group}.training.index', function($breadcrumbs, $group)
{
    $breadcrumbs->parent('group', $group);
    $breadcrumbs->push('training' , route('{group}.training.index', [
        'group' => $group->slug,
    ]));
});

Breadcrumbs::register('{group}.training.show', function($breadcrumbs, $group, $training)
{
    $breadcrumbs->parent('{group}.training.index', $group);
    $breadcrumbs->push($training->starttime, route('{group}.training.show', [
        'group' => $group->slug,
        'swimmer' => $training->id,
    ]));
});

Breadcrumbs::register('{group}.stopwatch.index', function($breadcrumbs, $group)
{
    $breadcrumbs->parent('group', $group);
    $breadcrumbs->push('stopwatch', route('{group}.stopwatch.index', [
        'group' => $group->slug,
    ]));
});

Breadcrumbs::register('stopwatch.show', function($breadcrumbs, $group, $stopwatch)
{
    $breadcrumbs->parent('{group}.stopwatch.index', $group);
    $breadcrumbs->push($stopwatch->distance->distance . ' ' . $stopwatch->distance->stroke->name,
            route('{group}.stopwatch.show', [
                'group' => $group->slug,
                'id' => $stopwatch->id,
            ])
        );
});