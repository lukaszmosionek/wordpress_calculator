document.addEventListener('DOMContentLoaded', function () {
    const calcScreenOperation = document.getElementById('calc-operation');
    const calcScreenResult = document.getElementById('calc-result');
    const buttons = document.querySelectorAll('.calc-btn');
    const saveButton = document.getElementById('save-calculation');

    let operation = '';
    let result = '';

    buttons.forEach(button => {
        button.addEventListener('click', () => {
            const value = button.getAttribute('data-value');
            const action = button.getAttribute('data-action');

            if (value) {
                operation += value;
                calcScreenOperation.innerText = operation;
            } else if (action) {
                if (action === 'clear') {
                    operation = '';
                    result = '';
                    calcScreenOperation.innerText = '';
                    calcScreenResult.innerText = '';
                } else if (action === 'equals') {
                    try {
                        result = eval(operation);
                        calcScreenResult.innerText = result.toLocaleString();
                    } catch (e) {
                        calcScreenResult.innerText = 'Error';
                    }
                } else {
                    operation += action === 'add' ? '+' :
                                 action === 'subtract' ? '-' :
                                 action === 'multiply' ? '*' :
                                 action === 'divide' ? '/' : '';
                    calcScreenOperation.innerText = operation;
                }
            }
        });
    });

    saveButton.addEventListener('click', () => {
        if (operation && result) {
            const data = new FormData();
            data.append('action', 'save_calculation');
            data.append('calculation', operation);
            data.append('result', result);

            fetch(ajaxurl, {
                method: 'POST',
                body: data,
            }).then(response => response.text()).then(response => {
                console.log('Calculation saved:', response);
            }).catch(error => {
                console.error('Error saving calculation:', error);
            });
        }
    });
});