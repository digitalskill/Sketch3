<?php
namespace Sketch\Helpers;

class MenuOrder implements \Doctrine\Common\EventSubscriber
{
    public function getSubscribedEvents()
    {
        return array(
            'postPersist',
        );
    }
    public function postPersist(\Doctrine\ORM\Event\LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        $em = $eventArgs->getEntityManager();
        if ($entity instanceof \Sketch\Entities\Menu) {
            $entity->pid = $entity->parent != null ? $entity->parent->pid ."." . $entity->parent->id . "." . $entity->sort : $entity->id;
            $em->persist($entity);
            $em->flush();
        }
    }
}