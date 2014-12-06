<?php

namespace Vkmusik\Controller;

use Zend\Mvc\Controller\AbstractActionController,
	Zend\View\Model\ViewModel;
        

class VkmusikController extends AbstractActionController {

    public function indexAction() {
        
        $token = '738e296210b0b11398610624ba6215386db94e9698c36f309a8680810e1bac4c178beb493bea7ae869103';
        $app_id = '4603000';
        $api_secret  = 'gZyN1MoeoxHb4Sz6Qc8f'; 
        $VK = new \Vkmusik\Manager\VK($app_id, $api_secret, $token);
        $count = 10;
        $resp = $VK->api('audio.search', array(
        'q' => "Кипелов", //сам запрос
        'auto_complete' => '1', //автоматическое исправление, если запрос в виде "Еру Иуфедуы" (The Beatles)
        'sort' => '2', // сортировка - по популярности
        'count' => '10', //количество результатов в ответе
        'offset' => '0' //оффсет (смещение, необходимо если делать постраничку или подгрузку на аяксе, ну это понятно)
        ));
        return new ViewModel(array('resp' => $resp, 'count' => $count));
    }
    
    public function privetAction() {
        print_r('lol');
        return new ViewModel();
    }

}