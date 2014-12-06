<?php

namespace Post\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Upload\Model\UploadTable;
use Post\Model\AttachmentTable;

class AttachmentController extends AbstractActionController
{
    public function indexAction()
    {
        return array();
    }

    public function deleteAction()
    {
        $request = $this->getRequest();
        $response = $this->getResponse();

        $uploadTable = new UploadTable($this->getServiceLocator()->get('dbAdapter'));
        $attachmentTable = new AttachmentTable($this->getServiceLocator()->get('dbAdapter'));

        if ($request->isPost()) {
            $postData = $request->getPost();
            $rowset = $attachmentTable->deleteAttachment($postData->post_id, $postData->upload_id);
            if ($rowset) {
                $fullFilename = $uploadTable->getUploadById($postData->upload_id)->full_filename;
                if (file_exists($fullFilename)) {
                    unlink($fullFilename);
                }
                $uploadTable->deleteUpload($postData->upload_id);
                $status = 'ok';
            } else {
                $status = 'bad';
            }
        }
        $answer = array('status' => $status, 'attachment' => $rowset);
        $response->setContent(\Zend\Json\Json::encode($answer));
        $response->getHeaders()->addHeaders(array('Content-Type' => 'application/json'));

        return $response;
    }

}