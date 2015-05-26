<?php
App::uses('CakeEventListener', 'Event');

class ShopEventHandler implements CakeEventListener{

    public function implementedEvents(){
        return array(
            'Dropzone.DropzoneUploads.afterSuccessUpload' => array(
                'callable' => 'onAfterSuccessUpload',
            ),
        );
    }
    
    public function onAfterSuccessUpload($event){
        $controller = $event->subject;
        $attachmentId = $event->data['attachmentId'];

        $attachments = $controller->Session->read('Attachments');
        $attachments['Attachment'][] = $attachmentId;
        $controller->Session->write('Attachments', $attachments);
    }
}