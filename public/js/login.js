document.addEventListener('DOMContentLoaded', function() {
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const container = document.getElementById('container');

    if (signUpButton && signInButton && container) {
        signUpButton.addEventListener('click', (e) => {
            e.preventDefault();
            container.classList.add("right-panel-active");
        });

        signInButton.addEventListener('click', (e) => {
            e.preventDefault();
            container.classList.remove("right-panel-active");
        });
    }
});
