<?php
class CardView extends TPage
{
    public function __construct()
    {
        parent::__construct();
        
        $cards = new TCardView;
        
        $items = [];
        $items[] = (object) ['id' => 1, 'titulo' => 'Item 1', 'conteudo' => 'conteúdo do item 1'];
        $items[] = (object) ['id' => 2, 'titulo' => 'Item 2', 'conteudo' => 'conteúdo do item 2'];
        $items[] = (object) ['id' => 3, 'titulo' => 'Item 3', 'conteudo' => 'conteúdo do item 3'];
        $items[] = (object) ['id' => 4, 'titulo' => 'Item 4', 'conteudo' => 'conteúdo do item 4'];
        $items[] = (object) ['id' => 5, 'titulo' => 'Item 5', 'conteudo' => 'conteúdo do item 5'];
        $items[] = (object) ['id' => 6, 'titulo' => 'Item 6', 'conteudo' => 'conteúdo do item 6'];
        
        foreach ($items as $item)
        {
            $cards->addItem($item);
        }
        
        $cards->setTitleAttribute('titulo');
        $cards->setItemTemplate( '<b> Conteúdo: </b> {id} - {conteudo}');
        
        
        $acao_edit   = new TAction([$this, 'onEdit'],   ['id' => '{id}']);
        $acao_delete = new TAction([$this, 'onDelete'], ['id' => '{id}']);
        
        $cards->addAction( $acao_edit,    'Editar',  'fa:edit blue');
        $cards->addAction( $acao_delete,  'Excluir', 'fas:trash-alt red');

        parent::add($cards);
    }
    
    public static function onEdit($param)
    {
        new TMessage('info', '<b>onEdit</b><br>'. json_encode($param));
    }
    
    public static function onDelete($param)
    {
        new TMessage('info', '<b>onDelete</b><br>'. json_encode($param));
    }
}