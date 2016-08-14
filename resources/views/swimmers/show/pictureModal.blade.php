<!-- Modal -->
<div id="pictures" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                afbeelding bijsnijden
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <img id="croppingImg" src="#" alt="">
            </div>
            <div class="modal-footer">
<?= Form::open([
                       'route' => ['{group}.swimmer.contact.update',
                               'group' => $group->slug,
                               'swimmer' => $swimmer->slug,
                       ],
                    'id' => 'cropping',
                       'class' => 'picture',
                       'data-is_form' => 'true',
                       'data-form' => 'picture',
                       'data-ajax' => 'false',
                       'files' => 'true',]) ?>
<?//= Form::file('picture', ['id' => 'croppedImg']) ?>
<?= Form::hidden('x', '', array('id' => 'x')) ?>
<?= Form::hidden('y', '', array('id' => 'y')) ?>
<?= Form::hidden('w', '', array('id' => 'w')) ?>
<?= Form::hidden('h', '', array('id' => 'h')) ?>
<?= Form::submit('Crop it!') ?>
<?= Form::close() ?>
            </div>
        </div>

    </div>
</div>
