function validateInput() {
    const inputField = document.getElementById('userInput');
    const inputValue = inputField.value;
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const phonePattern = /^\+?\d{10,15}$/;

    if (emailPattern.test(inputValue)) {
        inputField.setAttribute('name', 'email');
        return true; 
    } else if (phonePattern.test(inputValue)) {
        inputField.setAttribute('name', 'phone');
        return true;
    }
}
