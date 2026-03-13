
<?php
class ComponentParser {
    public static function parse($html){
        return preg_replace_callback('/<([A-Z][A-Za-z0-9]+)(.*?)\/>/', function($matches){

            $component = $matches[1];
            $propsRaw = $matches[2];

            preg_match_all('/(\w+)="([^"]*)"/',$propsRaw,$props);

            $vars=[];
            foreach($props[1] as $i=>$key){
                $vars[$key]=$props[2][$i];
            }

            $file = __DIR__."/../app/components/".$component.".php";
            if(!file_exists($file)) return "";

            extract($vars);

            ob_start();
            require $file;
            return ob_get_clean();

        }, $html);
    }
}
