<?php

namespace App\Presenters;

use Nette,
    Nette\Application\UI\Presenter,
    Nette\Application\UI\Form,
    App\Model\TransalatorManager;


final class HomepagePresenter extends Presenter{

    private $transalatorManager;

    public function __construct(TransalatorManager $transalatorManager){
        $this->transalatorManager = $transalatorManager;
    }

    public function renderDefault(){
        $this->template->backText = $this->transalatorManager->getText();
    }

    public function actionDefault(){

    }

    protected function createComponentForm(){
        $form = new Form();

        $form->getElementPrototype()->class = 'form';
        $form->addText('text', 'TEXT:')
            ->setType('text')
            ->setRequired('Zadejte text k překladu')
            ->addCondition($form::FILLED)
            ->addFilter(function ($value) {
                return str_replace(' ', '', $value);
            });
        $form->addSubmit('send', 'ODESLAT');
        $form->onSuccess[] = [$this, 'formSucceded'];
        return $form;
    }

    public function formSucceded(Form $form, \stdClass $value){
        $this->transalatorManager->setText($value->text);
    }
}
