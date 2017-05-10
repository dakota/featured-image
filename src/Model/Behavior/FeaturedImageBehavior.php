<?php

namespace FeaturedImage\Model\Behavior;

use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Event\Event;
use Cake\ORM\Behavior;
use Cake\ORM\Entity;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;

/**
 * Class FeaturedImage
 */
class FeaturedImageBehavior extends Behavior
{
    public function implementedEvents()
    {
        return parent::implementedEvents() + [
            'Model.Meta.formatFields' => 'getFeaturedImage',
            'Model.Meta.prepareFields' => 'prepareFeaturedImage'
        ];
    }

    /**
     * Loads the featured image (if any)
     *
     * @return void
     */
    public function getFeaturedImage(Event $event, Entity $entity)
    {
        $featuredImage = Hash::extract($entity->meta, '{n}[key=featured_image]');
        if (empty($featuredImage)) {
            return;
        }
        $featuredImage = end($featuredImage);
        $entity->featured_image_meta_id = $featuredImage->id;
        $entity->featured_image_id = $featuredImage->value;
        try {
            $entity->featured_image = TableRegistry::get('Croogo/FileManager.Attachments')
                ->get($entity->featured_image_id);
        } catch (RecordNotFoundException $e) {
            //Image does not exist
            unset($entity->featured_image_id);
        }

        $entity->meta = collection($entity->meta)->reject(function ($item) {
            return $item->key === 'featured_image';
        })->toList();
    }

    public function prepareFeaturedImage(Event $event, $data)
    {
        if (!isset($data['featured_image_id'])) {
            return;
        }

        $data['meta'][] = [
            'id' => $data['featured_image_meta_id'],
            'key' => 'featured_image',
            'value' => $data['featured_image_id']
        ];
        unset($data['featured_image_id'], $data['featured_image_meta_id']);
    }
}
