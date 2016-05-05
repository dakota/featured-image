<?php
/**
 * @var \Croogo\Core\View\CroogoView $this
 */
$this->Html->script('FeaturedImage.box', ['block' => true]);

$out = '';

$selectedBlock = '';
$options = ['class' => 'card-img img-fluid center-block thumbnail'];
if (isset($entity->featured_image)) :
    $selectedBlock .= $this->Image->resize($entity->featured_image->path, 400, 200, [], $options);
else:
    $selectedBlock .= $this->Html->image('#', $options);
endif;
$selectedBlock .= $this->Html->link(__d('croogo', 'Remove featured image'), '#', [
    'class' => 'btn btn-secondary remove-image'
]);
$out .= $this->Html->div('text-xs-center selected-image collapse ' . (isset($entity->featured_image) ? 'in' : ''), $selectedBlock);

$notSelectedBlock = $this->Html->link(__d('croogo', 'Select featured image'), [
    'plugin' => 'Croogo/FileManager',
    'controller' => 'Attachments',
    'action' => 'index',
    '?' => [
        'chooser' => true,
        'chooser_type' => 'image'
    ],
], [
    'class' => 'btn btn-secondary choose-image'
]);
$out .= $this->Html->div('text-xs-center select-image collapse ' . (isset($entity->featured_image) ? '' : 'in'), $notSelectedBlock);

$out .= $this->Form->input(
    'featured_image_meta_id',
    [
        'type' => 'hidden'
    ]
);
$out .= $this->Form->input('featured_image_id', [
    'type' => 'hidden'
]);

$this->Form->unlockField('featured_image_id');

echo $this->Html->div('', $out, ['id' => 'featured-image']);

$fileChooser = $this->element(
    'Croogo/Core.admin/modal',
    [
        'id' => 'image-chooser',
        'title' => __d('croogo', 'Choose an image'),
        'modalSize' => 'modal-lg'
    ]
);
$this->append('page-footer', $fileChooser);
