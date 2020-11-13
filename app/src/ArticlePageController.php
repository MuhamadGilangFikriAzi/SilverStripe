<?php

namespace SilverStripe\Lessons;

use PageController;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;

class ArticlePageController extends PageController{

    public function ContactForm(){
        $myForm = Form::create(
            $controller,
            'ContactForm',
            FieldList::create(
                TextField::create('YourName', 'Your Name'),
                TextareaField::create('YourComment', 'Your Comment')
            ),
            FieldList::create(
                FormAction::create('sendContactForm', 'Submit')
            ),
            RequiredFields::create('YourName', 'YourComment')
        );

        return $myForm;
    }

    public function sendContactForm($data, $form){
        $name = $data['YourName'];
        $message = $data['YourMessage'];
        if(strlen($message) < 10){
            $form->addErrorMessage('YourMessage','Your message is to short', 'bad');
            return $this->redirectBack();
        }

        return $this->redirect('/some/sucess/url');
    }

    public function CommentForm(){
        $form = Form::create(
            $this,
            __FUNCTION__,
            FieldList::create(
                TextField::create('Name','')
                    ->setAttribute('pleaceholder','Name*')
                    ->addExtraClass('form-control'),
                EmailField::create('Email','')
                    ->setAttribute('pleaceholder','Email*')
                    ->addExtraClass('form-control'),
                TextareaField::create('Comment','')
                    ->setAttribute('pleaceholder', 'Comment*')
                    ->addExtraClass('form-control')
            ),
            FieldList::create(
                FormAction::create('handleComment','Post Comment')
            ),
            RequiredFields::create('Name','Email','Comment'),

        );

        return $form;
    }
}