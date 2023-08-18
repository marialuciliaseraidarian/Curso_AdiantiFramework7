<?php
class VideoCard extends TPage
{
    public function __construct()
    {
        parent::__construct();
        
        $cards = new TCardView;
        $cards->setUseButton();
        
        $items = [];
        $items[] = (object) ['id' => 1, 'titulo' => 'Melhorias do Framework 4.0', 'origem' => 'M91oklMkJTU'];
        $items[] = (object) ['id' => 2, 'titulo' => 'Melhorias do Framework 5.0', 'origem' => 'IF5f1cnGl04'];
        $items[] = (object) ['id' => 3, 'titulo' => 'Melhorias do Framework 5.5', 'origem' => 'HnC0gg1ik8o'];

        foreach ($items as $item)
        {
            $cards->addItem($item);
        }
        
        $cards->setTitleAttribute('titulo');
        $cards->setItemTemplate('<iframe width="100%" height="300px" src="https://www.youtube.com/embed/{origem}""></iframe>');
        
        $action = new TAction([$this, 'onGotoVideo'], ['origem' => '{origem}']);
        $cards->addAction($action, 'Vai para Youtube', 'far:play-circle red');
        
        parent::add( $cards );
    }
    
    public static function onGotoVideo($param)
    {
        $origem = $param['origem'];
        TScript::create("window.open('https://www.youtube.com/watch?v={$origem}')");
    }
}