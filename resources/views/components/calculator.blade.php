<!-- Calculator Toggle Button -->
<button
    id="calcToggleBtn"
    class="fixed left-4 bottom-4 z-50 bg-purple-600 hover:bg-purple-700 text-white rounded-full p-4 shadow-lg transition-all duration-300"
    title="Calculator"
>
    <i class="bi bi-calculator text-2xl"></i>
</button>

<!-- Calculator Panel -->
<div id="calculatorPanel" class="fixed left-0 top-0 h-full w-80 bg-white shadow-xl z-40 transform -translate-x-full transition-transform duration-300">
    <div class="h-full flex flex-col border-r border-gray-200">
        <!-- Header -->
        <div class="flex justify-between items-center p-4 bg-gray-50 border-b">
            <h3 class="text-lg font-semibold text-gray-800">Calculator</h3>
            <button id="closeCalcBtn" class="text-gray-500 hover:text-gray-700">
                <i class="bi bi-x-lg text-xl"></i>
            </button>
        </div>

        <!-- Display -->
        <div class="p-4 bg-gray-50">
            <div id="calcHistory" class="text-sm text-gray-500 h-6 truncate">0</div>
            <div id="calcDisplay" class="text-3xl font-bold text-right truncate">0</div>
        </div>

        <!-- Keypad -->
        <div class="grid grid-cols-4 gap-2 p-3 flex-grow">
            <button class="calc-btn bg-red-500 hover:bg-red-600 text-white" data-action="clear">C</button>
            <button class="calc-btn bg-gray-200 hover:bg-gray-300" data-action="backspace">⌫</button>
            <button class="calc-btn bg-gray-200 hover:bg-gray-300" data-action="percentage">%</button>
            <button class="calc-btn bg-purple-600 hover:bg-purple-700 text-white" data-action="operator" data-operator="/">÷</button>

            <button class="calc-btn" data-action="number" data-number="7">7</button>
            <button class="calc-btn" data-action="number" data-number="8">8</button>
            <button class="calc-btn" data-action="number" data-number="9">9</button>
            <button class="calc-btn bg-purple-600 hover:bg-purple-700 text-white" data-action="operator" data-operator="*">×</button>

            <button class="calc-btn" data-action="number" data-number="4">4</button>
            <button class="calc-btn" data-action="number" data-number="5">5</button>
            <button class="calc-btn" data-action="number" data-number="6">6</button>
            <button class="calc-btn bg-purple-600 hover:bg-purple-700 text-white" data-action="operator" data-operator="-">-</button>

            <button class="calc-btn" data-action="number" data-number="1">1</button>
            <button class="calc-btn" data-action="number" data-number="2">2</button>
            <button class="calc-btn" data-action="number" data-number="3">3</button>
            <button class="calc-btn bg-purple-600 hover:bg-purple-700 text-white" data-action="operator" data-operator="+">+</button>

            <button class="calc-btn col-span-2" data-action="number" data-number="0">0</button>
            <button class="calc-btn" data-action="decimal">.</button>
            <button class="calc-btn bg-green-500 hover:bg-green-600 text-white" data-action="calculate">=</button>
        </div>
    </div>
</div>

<style>
    .calc-btn {
        padding: 1rem 0;
        border: none;
        border-radius: 8px;
        font-size: 1.2rem;
        font-weight: 500;
        background-color: #f8f9fa;
        transition: all 0.15s ease;
        cursor: pointer;
    }

    .calc-btn:hover {
        background-color: #e9ecef;
    }

    .calc-btn:active {
        transform: scale(0.96);
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let currentValue = '0';
    let calculationHistory = '';
    let firstOperand = null;
    let waitingForSecondOperand = false;
    let currentOperator = null;

    const display = document.getElementById('calcDisplay');
    const history = document.getElementById('calcHistory');
    const calculatorPanel = document.getElementById('calculatorPanel');
    const toggleBtn = document.getElementById('calcToggleBtn');
    const closeBtn = document.getElementById('closeCalcBtn');

    function toggleCalculator() {
        calculatorPanel.classList.toggle('-translate-x-full');
    }

    function updateDisplay() {
        display.textContent = currentValue;
        history.textContent = calculationHistory;
    }

    function inputNumber(number) {
        if (waitingForSecondOperand) {
            currentValue = number;
            waitingForSecondOperand = false;
        } else {
            currentValue = currentValue === '0' ? number : currentValue + number;
        }
        updateDisplay();
    }

    function inputDecimal() {
        if (waitingForSecondOperand) {
            currentValue = '0.';
            waitingForSecondOperand = false;
            return;
        }

        if (!currentValue.includes('.')) {
            currentValue += '.';
        }
        updateDisplay();
    }

    function handleOperator(operator) {
        const inputValue = parseFloat(currentValue);
        if (firstOperand === null) {
            firstOperand = inputValue;
        } else if (currentOperator) {
            const result = calculate(firstOperand, inputValue, currentOperator);
            currentValue = String(result);
            firstOperand = result;
        }

        waitingForSecondOperand = true;
        currentOperator = operator;
        calculationHistory = `${firstOperand} ${currentOperator}`;
        updateDisplay();
    }

    function calculateResult() {
        if (firstOperand === null || !currentOperator) return;

        const inputValue = parseFloat(currentValue);
        const result = calculate(firstOperand, inputValue, currentOperator);

        calculationHistory = `${firstOperand} ${currentOperator} ${inputValue} =`;
        currentValue = String(result);
        firstOperand = result;
        waitingForSecondOperand = true;
        currentOperator = null;
        updateDisplay();
    }

    function calculate(first, second, operator) {
        switch (operator) {
            case '+': return first + second;
            case '-': return first - second;
            case '*': return first * second;
            case '/': return second !== 0 ? first / second : 'Error';
            default: return second;
        }
    }

    function clearCalculator() {
        currentValue = '0';
        calculationHistory = '';
        firstOperand = null;
        waitingForSecondOperand = false;
        currentOperator = null;
        updateDisplay();
    }

    function backspace() {
        if (currentValue.length === 1) {
            currentValue = '0';
        } else {
            currentValue = currentValue.slice(0, -1);
        }
        updateDisplay();
    }

    function calculatePercentage() {
        currentValue = (parseFloat(currentValue) / 100).toString();
        updateDisplay();
    }

    toggleBtn.addEventListener('click', toggleCalculator);
    closeBtn.addEventListener('click', toggleCalculator);

    document.querySelectorAll('.calc-btn').forEach(button => {
        button.addEventListener('click', function () {
            const action = this.dataset.action;
            switch (action) {
                case 'number':
                    inputNumber(this.dataset.number);
                    break;
                case 'decimal':
                    inputDecimal();
                    break;
                case 'operator':
                    handleOperator(this.dataset.operator);
                    break;
                case 'calculate':
                    calculateResult();
                    break;
                case 'clear':
                    clearCalculator();
                    break;
                case 'backspace':
                    backspace();
                    break;
                case 'percentage':
                    calculatePercentage();
                    break;
            }
        });
    });

    updateDisplay();
});
</script>
