<?php
namespace Sketch\Helpers;

include_once SKETCH_CORE.DIRECTORY_SEPARATOR."Sketch".DIRECTORY_SEPARATOR."Helpers".DIRECTORY_SEPARATOR."simple_html_dom_node.php" ;

class Form
{
    private $messages   = [];
    private $tmpMessages= [];
    private $data       = [];
    private $file       = '';
    public $valid      = true;
    private $validation = "data-validation";
    /**
     *
     * @param  type                 $file
     * @param  type                 $data
     * @return \Sketch\Helpers\Form
     */
    public function __construct($file,$data='')
    {
        $this->file = file_get_html($file);
        if ($data != '') {
            $this->addData($data);
        }

        return $this;
    }

    /**
     *
     * @param type $data
     */
    public function addData($data)
    {
        $this->data = $data;
        foreach ($this->data as $key => $value) {
            foreach ($this->file->find("input[name='".$key."']") as $elm) {
                $elm->value = $value;
                $this->data[$key] = $this->validate($elm,$value);
            }

            foreach ($this->file->find("textarea[name='".$key."']") as $elm) {
                $elm->innertext = $value;
                $this->data[$key] = $this->validate($elm,$value);
            }

            foreach ($this->file->find("checkbox[name='".$key."']") as $elm) {
                if ($elm->value == $value) {
                    $elm->checked = "checked";
                }
                $this->data[$key] = $this->validate($elm,$value);
            }

            foreach ($this->file->find("radio[name='".$key."']") as $elm) {
                if ($elm->value == $value) {
                    $elm->checked = "checked";
                }
                $this->data[$key] = $this->validate($elm,$value);
            }

            foreach ($this->file->find("select[name='".$key."']") as $elm) {
                $options = explode("</option>",$elm->innertext);
                $innertext = '';
                foreach ($options as $option) {
                    $val = explode("=",$option);
                    if (isset($val[1])) {
                        $val = substr($val[1],1,strpos(str_replace("'",'"',$val[1]),'"',1)-1);
                        if ($val == $value) {
                            $option = str_replace("value="," selected='selected' value=",$option);
                        }
                    }
                    $innertext .= $option."</option>";
                }
                $elm->innertext = $innertext;
                $this->data[$key] = $this->validate($elm,$value);
            }
        }
    }

    /**
     *
     * @param type $elm
     * @param type $value
     */
    public function validate($elm,$value)
    {
        // TODO - ADD TYPES OF VALIDATION email | number | text
        if ($elm->getAttribute($this->validation) == 'required') {
            if (trim($value)=='') {
                $msg = $elm->getAttribute('data-validation-error-msg') != ''? $elm->getAttribute('data-validation-error-msg') :
                                        "Please fill in ". $elm->getAttribute('name');
                $this->tmpMessages[] = array($elm,$msg);
                $this->valid = false;
            }
        }

        return $value;
    }

    /**
     *
     * @return Bool
     */
    public function isValid()
    {
        if ($this->valid != true) {
            foreach ($this->tmpMessages as $items) {
                $items[0]->parent()->class .= " has-error";
                $items[0]->class         =  $items[0]->class . " error";
                $items[0]->outertext    .= '<span class="help-block form-error">'.$items[1].'</span>';
            }
        }

        return $this->valid;
    }

    public function getValues()
    {
        return $this->data;
    }
    /**
     *
     * @return HTML
     */
    public function showForm()
    {
        return $this->file;
    }
}
