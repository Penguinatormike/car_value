<?php
namespace App\Calculator;


interface CalculatorInterface {
    public function calculate(int $targetMileage) : float;
}