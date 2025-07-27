document.addEventListener('DOMContentLoaded', function() {
    const themeToggle = document.getElementById('theme-toggle')
    if(themeToggle){
        themeToggle.addEventListener('change', function() {
            this.checked ? setThemeValue('dark') : setThemeValue('light')
        });

        themeToggle.checked = localStorage.getItem('theme') === 'dark';
        themeToggle.dispatchEvent(new Event('change'));
    }

    function setThemeValue (value='light') {
        document.documentElement.setAttribute('data-mode', value)
        localStorage.setItem('theme', value)
    }
})

