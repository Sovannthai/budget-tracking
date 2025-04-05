document.addEventListener('DOMContentLoaded', function() {
    // Initialize Choices selects only if they haven't been initialized yet
    const selects = {
        'choices-gender': {},
        'choices-language': {},
        'choices-skills': {
            removeItemButton: true,
            maxItemCount: 5,
            searchResultLimit: 4,
            renderChoiceLimit: 4
        },
        'choices-month': {},
        'choices-day': {
            searchEnabled: false,
            items: Array.from({ length: 31 }, (_, i) => (i + 1).toString()),
            choices: Array.from({ length: 31 }, (_, i) => ({
                value: (i + 1).toString(),
                label: (i + 1).toString()
            }))
        },
        'choices-year': {
            searchEnabled: false,
            items: Array.from({ length: 121 }, (_, i) => (2024 - i).toString()),
            choices: Array.from({ length: 121 }, (_, i) => ({
                value: (2024 - i).toString(),
                label: (2024 - i).toString()
            }))
        }
    };

    Object.entries(selects).forEach(([id, config]) => {
        const element = document.getElementById(id);
        if (element && !element.classList.contains('choices__input')) {
            new Choices(element, {
                ...{
                    searchEnabled: false,
                    itemSelectText: '',
                    shouldSort: false
                },
                ...config
            });
        }
    });
});

// Make sure month select has proper options
const monthChoices = [
    'January', 'February', 'March', 'April',
    'May', 'June', 'July', 'August',
    'September', 'October', 'November', 'December'
];

// Make sure language select has proper options
const languageChoices = [
    { value: 'English', label: 'English' },
    { value: 'French', label: 'French' },
    { value: 'Spanish', label: 'Spanish' }
];

// Handle Skills input
document.addEventListener('change', function(e) {
    if (e.target.id === 'choices-skills') {
        const skillsInput = document.getElementById('choices-skills');
        if (skillsInput) {
            const skills = skillsInput.value.split(',').filter(skill => skill.trim());
            skillsInput.value = skills.join(',');
        }
    }
});

// Initialize other components
function initializeComponents() {
    // Profile visibility switch
    const visibilitySwitch = document.getElementById('flexSwitchCheckDefault23');
    if (visibilitySwitch) {
        visibilitySwitch.addEventListener('change', function() {
            const label = document.getElementById('profileVisibility');
            if (label) {
                label.textContent = this.checked ? 'Switch to invisible' : 'Switch to visible';
            }
        });
    }
}

// Initialize all components when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initializeComponents();
});

var openFile = function (event) {
    var input = event.target;

    // Instantiate FileReader
    var reader = new FileReader();
    reader.onload = function () {
        imageFile = reader.result;

        document.getElementById("imageChange").innerHTML = '<img width="200" src="' + imageFile + '" class="rounded-circle w-100 shadow" />';
    };
    reader.readAsDataURL(input.files[0]);
};
