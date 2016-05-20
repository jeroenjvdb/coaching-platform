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
    $breadcrumbs->push($swimmer->first_name . ' ' . $swimmer->last_name, route('swimmers.show', [
        'group' => $group->slug,
        'swimmer' => $swimmer->slug,
    ]));
});

Breadcrumbs::register('trainings.index', function($breadcrumbs, $group)
{
    $breadcrumbs->parent('group', $group);
    $breadcrumbs->push('training' , route('trainings.index', [
        'group' => $group->slug,
    ]));
});

Breadcrumbs::register('trainings.show', function($breadcrumbs, $group, $training)
{
    $breadcrumbs->parent('trainings.index', $group);
    $breadcrumbs->push($training->starttime, route('trainings.show', [
        'group' => $group->slug,
        'swimmer' => $training->id,
    ]));
});

Breadcrumbs::register('stopwatch.index', function($breadcrumbs, $group)
{
    $breadcrumbs->parent('group', $group);
    $breadcrumbs->push('stopwatch', route('stopwatches.index', [
        'group' => $group->slug,
    ]));
});

Breadcrumbs::register('stopwatch.show', function($breadcrumbs, $group, $stopwatch)
{
    $breadcrumbs->parent('stopwatch.index', $group);
    $breadcrumbs->push($stopwatch->distance->distance . ' ' . $stopwatch->distance->stroke->name,
            route('stopwatches.show', [
                'group' => $group->slug,
                'id' => $stopwatch->id,
            ])
        );
});