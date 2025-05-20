<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Calculator extends Component
{
    public $currentValue = '0';
    public $calculationHistory = '';
    public $firstOperand = null;
    public $waitingForSecondOperand = false;
    public $operator = null;

    public function render()
    {
        return view('livewire.calculator');
    }

    public function number($digit)
    {
        if ($this->waitingForSecondOperand) {
            $this->currentValue = $digit;
            $this->waitingForSecondOperand = false;
        } else {
            $this->currentValue = $this->currentValue === '0' ? $digit : $this->currentValue . $digit;
        }
    }

    public function decimal()
    {
        if ($this->waitingForSecondOperand) {
            $this->currentValue = '0.';
            $this->waitingForSecondOperand = false;
            return;
        }

        if (strpos($this->currentValue, '.') === false) {
            $this->currentValue .= '.';
        }
    }

    public function operator($nextOperator)
    {
        $input = floatval($this->currentValue);

        if ($this->firstOperand === null) {
            $this->firstOperand = $input;
        } elseif ($this->operator) {
            $result = $this->calculateResult($this->firstOperand, $input, $this->operator);
            $this->currentValue = strval($result);
            $this->firstOperand = $result;
        }

        $this->waitingForSecondOperand = true;
        $this->operator = $nextOperator;
        $this->calculationHistory = $this->firstOperand . ' ' . $this->operator;
    }

    public function calculate()
    {
        if ($this->firstOperand === null || $this->operator === null) {
            return;
        }

        $input = floatval($this->currentValue);
        $result = $this->calculateResult($this->firstOperand, $input, $this->operator);

        $this->calculationHistory = $this->firstOperand . ' ' . $this->operator . ' ' . $input . ' =';
        $this->currentValue = strval($result);
        $this->firstOperand = $result;
        $this->waitingForSecondOperand = true;
        $this->operator = null;
    }

    private function calculateResult($firstOperand, $secondOperand, $operator)
    {
        switch ($operator) {
            case '+':
                return $firstOperand + $secondOperand;
            case '-':
                return $firstOperand - $secondOperand;
            case '*':
                return $firstOperand * $secondOperand;
            case '/':
                return $secondOperand != 0 ? $firstOperand / $secondOperand : 'Error';
            default:
                return $secondOperand;
        }
    }

    public function clear()
    {
        $this->currentValue = '0';
        $this->calculationHistory = '';
        $this->firstOperand = null;
        $this->waitingForSecondOperand = false;
        $this->operator = null;
    }

    public function backspace()
    {
        $length = strlen($this->currentValue);

        if ($length === 1) {
            $this->currentValue = '0';
        } else {
            $this->currentValue = substr($this->currentValue, 0, -1);
        }
    }

    public function percentage()
    {
        $this->currentValue = (floatval($this->currentValue) / 100);
    }
}
