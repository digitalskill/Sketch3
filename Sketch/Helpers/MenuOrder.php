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
            $entity->pid = "1".".".$entity->sort;
            if($entity->parent != null){
                $pids = explode(".",$entity->parent->pid);
                $subNum = 0;
                foreach($pids as $num){
                    $subNum += $num;
                }
                $entity->pid = $entity->parent->pid.".".$subNum.".".$entity->sort;
            }
            $em->persist($entity);
            $this->childrensort($entity,$em);
            
            $em->flush();
        }
    }
    
    private function childrensort($entity,$em){
        if($entity->children != null){
            foreach($entity->children as $child){
                $pids = explode(".",$child->parent->pid);
                $subNum = 0;
                foreach($pids as $num){
                    $subNum += $num;
                }
                $child->pid = $child->parent->pid.".".$subNum.".".$child->sort;
                $em->persist($child);
                $this->childrensort($child,$em);
            }
        }
    }
}