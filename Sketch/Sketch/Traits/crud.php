<?php
namespace Sketch\Traits;

trait crud
{
    /**
     * 
     * @param type $id
     * @param type $hydrate
     * @return type
     */
    public function get($id,$hydrate = \Doctrine\ORM\Query::HYDRATE_ARRAY)
    {
        $r = $this->_em->createQueryBuilder()
                    ->select("p")
                    ->from($this->getClassName(),"p")
                    ->where("p.id = :id")
                    ->setParameter("id", $id)
                    ->getQuery()
                    ->getOneOrNullResult($hydrate);
        if($hydrate == 2){
            if(isset($r['extensions'])){
                foreach($r['extensions'] as $k => $value){
                    $r['extension'.$k] = $value;
                }
            }
        }else{
            if(isset($r->extensions)){
                foreach($r->extensions as $k => $value){
                    $row = 'extension'.$k;
                    $r->$row = $value;
                }
            }
        }
        return $r;
    }
    
    /**
     * 
     * @param type $id
     * @param type $data
     * @return boolean
     */
    public function set($id,$data){
        $current = $this->get($id,\Doctrine\ORM\Query::HYDRATE_OBJECT);
        if($current){
            $this->addData($current,$data);
            $this->_em->persist($current);
            $this->_em->flush();
        }else{
            return false;
        }
        return true;
    }
    
    /**
     * 
     * @param type $data
     * @return boolean
     */
    public function add($data){
        $repo = "\\".$this->getClassName();
        $new = new $repo;
        $this->addData($new,$data);
        $this->_em->persist($new);
        $this->_em->flush();
        return true;
    }
    
    /**
     * 
     * @param type $obj
     * @param type $data
     */
    private function addData($obj,$data){
        $cmf                = $this->_em->getMetadataFactory();
        $mapping            = $cmf->getMetadataFor($this->getClassName());  // Get Mapping Data
        $obj->extensions    = [];                                           // Empty Json Arrays
        
        foreach($data as $key => $value){
            if(isset($mapping->fieldMappings[$key])){
                $obj->$key = $this->prepareData($mapping->fieldMappings[$key],$value);
            }elseif(isset($mapping->fieldMappings['extensions'])){
                $obj->extensions  = $this->prepareData($mapping->fieldMappings['extensions'],$value,$key,$obj->extensions);
            }
        }
    }
    
    /**
     * 
     * @param type $dataType
     * @param type $value
     * @param type $key
     * @param type $currValue
     * @return type
     */
    private function prepareData($dataType,$value,$key='',$currValue=''){
        if($dataType['type'] == "text" || $dataType['type'] == "string"){
            return $value;
        }
        if($dataType['type'] == "json_array"){
            return array_merge($currValue,[$key => $value]);
        }
    }
}
