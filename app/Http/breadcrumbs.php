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
    $breadcrumbs->push('training' , route('training.index', [
    ]));
});

Breadcrumbs::register('{group}.training.show', function($breadcrumbs, $group, $training)
{
    $breadcrumbs->parent('{group}.training.index', $group);
    $breadcrumbs->push($training->starttime, route('training.show', [
        'swimmer' => $training->id,
    ]));
});

Breadcrumbs::register('stopwatch.index', function($breadcrumbs, $group)
{
    $breadcrumbs->parent('group', $group);
    $breadcrumbs->push('stopwatch', route('stopwatch.index', [
        'group' => $group->slug,
    ]));
});

Breadcrumbs::register('stopwatch.show', function($breadcrumbs, $group, $stopwatch)
{
    $breadcrumbs->parent('stopwatch.index', $group);
    $breadcrumbs->push($stopwatch->distance->distance . ' ' . $stopwatch->distance->stroke->name,
            route('stopwatch.show', [
                'group' => $group->slug,
                'id' => $stopwatch->id,
            ])
        );
});