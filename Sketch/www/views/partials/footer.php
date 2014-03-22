<?php              
echo $this->inlineScript()
                ->prependFile($this->basePath('Assets/Bootstrap/v1/js/bootstrap.min.js'))
                ->prependFile($this->basePath('Assets/Stickyfooter/v1/js/stickyfooter.js'))
                ->prependFile($this->basePath('Assets/jquery/v11/jquery-ui-1.10.4.custom.min.js'))
                ->prependFile($this->basePath('Assets/jquery/v11/jquery.11.js'))
                ->appendFile($this->basePath("Assets/Prettyphoto/v1/js/prettyphoto.js"))    
                ->appendFile($this->basePath("Assets/Tools/v1/js/tools.min.js"))
                ->appendFile($this->basePath("Assets/Revolution/v1/js/revolution.min.js"))
                ->appendFile($this->basePath("Assets/Flexslider/v1/js/flexslider.min.js"))
                ->appendFile($this->basePath('js/custom.js'))
                ->minify()
                ;                    
?>
</body>
</html>