<?php
class Stack {

    private $splstack;

    function __construct(SplStack $splstack)
    {
        $this->splstack = $splstack;
    }

    public function calculateSomme()
    {

        if ($this->splstack->count() > 1){
            $val1 = $this->splstack->pop();
            $val2 = $this->splstack->pop();
            $val = $val1 + $val2;
            $this->splstack->push($val);
            $this->calculateSomme();
        }
    }

    /**
     *
     * @return integer
     */
    public function displaySomme()
    {
        $result = $this->splstack->pop();
        return $result;
    }

}
?>