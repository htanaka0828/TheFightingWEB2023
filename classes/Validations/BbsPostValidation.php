<?php
require_once './AbstractValidation.php';

class BbsPostValidation extends AbstractValidation {

    private $result = [
        'comment' => true
    ];

    public function __construct() {
        $this->init();
        parent::__construct();
    }

    public function validate($comment) {
        $this->init();

        // comment -> 1024文字(2のn乗です) / 許容する文字に制限は設けない
        if(mb_strlen($comment) > 1024) {
            $this->result['comment'] = false;
        }

        return $this->result;
    }

    public function getResult() {
        return $this->result;
    }

    private function init() {
        $this->result = [
            'comment' => true
        ];
    }
}