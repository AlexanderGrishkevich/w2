<?php

namespace Search\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Post\Model\PostTable;

class SearchController extends AbstractActionController {

    public function indexAction() {
        $country = $this->params()->fromQuery('country');
        $region = $this->params()->fromQuery('region');
        $city = $this->params()->fromQuery('city');
        
        $query = htmlspecialchars($this->params()->fromQuery('query'));
        $orderBy = $this->params()->fromQuery('order_by');
        $order = $this->params()->fromQuery('order');
        if ($orderBy != 'price') {
            $orderBy = 'create_date';
        }
        $url = '/search/index?query=' . $query . '&country=' . $country . '&region=' . $region . '&city=' . $city . '&order_by=';
        if ($order != 'ASC') {
            $order = 'DESC';
        } 
        $postTable = new PostTable($this->getServiceLocator()->get('dbAdapter'));
        $searchResults = $postTable->search($query, $orderBy, $order, $country, $region, $city);
        
        $cityUrl = '/search/index?query=' . $query . '&order_by=' . $orderBy . '&order=' . $order;
        return array(
            'order' => $order,
            'url' => $url,
            'searchResults' => $searchResults,
            'postTable' => $postTable,
            'cityUrl' => $cityUrl,
            'country' => $country,
            'region' => $region,
            'city' => $city,
        );
    }

    public function ajaxSearchAction() {

        $postTable = new PostTable($this->getServiceLocator()->get('dbAdapter'));

        $request = $this->getRequest();
        $response = $this->getResponse();

        if ($request->isPost()) {
            $postData = $request->getPost();
            $queryText = $postData->q;
            $searchResults = $postTable->searchAjax($queryText);
        }

        if ($searchResults->count()) {

            foreach ($searchResults as $searchResult) {
                $highlight_word = preg_replace('/' . $queryText . '/ui', '<span class="highlight">\\0</span>', $searchResult->title);

                echo '
                        <li class="element-result">
                            <a class="search-link" href="/post/details/' . $searchResult->id . '">' . $highlight_word . '</a>
                        </li>
                    ';
            }
            return $response;
        }
        return $response;
    }

}
