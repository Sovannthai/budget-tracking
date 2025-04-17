/**
 * Theme Toggle & Toast Notifications
 * 
 * For toast notifications, you can use the global showToast function:
 * 
 * // Success toast
 * showToast('Operation completed successfully!');
 * 
 * // Error toast
 * showToast('Something went wrong!', 'error');
 * 
 * // Warning toast
 * showToast('Please check your input!', 'warning');
 * 
 * // Info toast
 * showToast('This is an informational message.', 'info');
 * 
 * For AJAX operations, you can show toasts after the operation completes:
 * 
 * $.ajax({
 *     url: '/your-endpoint',
 *     method: 'POST',
 *     data: formData,
 *     success: function(response) {
 *         if (response.success) {
 *             showToast(response.msg);
 *         } else {
 *             showToast(response.msg, 'error');
 *         }
 *     },
 *     error: function() {
 *         showToast('An error occurred while processing your request.', 'error');
 *     }
 * });
 * 
 * You can also use toastr directly for more customization:
 * 
 * toastr.options = {
 *     "closeButton": true,
 *     "progressBar": true,
 *     "timeOut": "5000",
 *     "positionClass": "toast-top-right"
 * }
 * toastr.success('Message');
 * toastr.error('Message');
 * toastr.warning('Message');
 * toastr.info('Message');
 */

/**
 * Theme Toggle & Notification System
 * 
 * For notifications, you can use the global showToast function:
 * 
 * // Success notification
 * showToast('Operation completed successfully!');
 * 
 * // Error notification
 * showToast('Something went wrong!', 'error');
 * 
 * // Warning notification
 * showToast('Please check your input!', 'warning');
 * 
 * // Info notification
 * showToast('This is an informational message.', 'info');
 * 
 * For AJAX operations, you can show notifications after the operation completes:
 * 
 * $.ajax({
 *     url: '/your-endpoint',
 *     method: 'POST',
 *     data: formData,
 *     success: function(response) {
 *         if (response.success) {
 *             showToast(response.msg);
 *         } else {
 *             showToast(response.msg, 'error');
 *         }
 *     },
 *     error: function() {
 *         showToast('An error occurred while processing your request.', 'error');
 *     }
 * });
 * 
 * You can also use Notiflix directly for more customization:
 * 
 * // Initialize with custom options (optional)
 * Notiflix.Notify.init({
 *     width: '280px',
 *     position: 'right-top',
 *     distance: '10px',
 *     opacity: 1,
 *     borderRadius: '5px',
 *     rtl: false,
 *     timeout: 3000,
 *     messageMaxLength: 110,
 *     backOverlay: false,
 *     backOverlayColor: 'rgba(0,0,0,0.5)',
 *     plainText: true,
 *     showOnlyTheLastOne: false,
 *     clickToClose: false,
 * });
 * 
 * // Show notifications
 * Notiflix.Notify.success('Message');
 * Notiflix.Notify.failure('Message');
 * Notiflix.Notify.warning('Message');
 * Notiflix.Notify.info('Message');
 */

const storageKey = "theme-preference";

const onClick = () => {
    theme.value = theme.value === "light" ? "dark" : "light";
    setPreference();
};

const getColorPreference = () => {
    if (localStorage.getItem(storageKey))
        return localStorage.getItem(storageKey);
    else
        return window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
};

const setPreference = () => {
    localStorage.setItem(storageKey, theme.value);
    reflectPreference();
};

const reflectPreference = () => {
    document.firstElementChild.setAttribute("data-theme", theme.value);

    document.querySelectorAll("[data-theme-target]").forEach(function (element) {
        element.setAttribute(
            element.dataset.themeTarget,
            theme.value === "dark" ? element.dataset.themeDark : element.dataset.themeLight
        );
    });

    if (theme.value === "dark") {
        document.cookie = "dark_mode=1; expires=" + new Date(new Date().setFullYear(new Date().getFullYear() + 10)).toUTCString() + "; path=/";
        document.body.classList.add("dark-mode");
    } else {
        document.cookie = "dark_mode=0; expires=" + new Date(new Date().setFullYear(new Date().getFullYear() + 10)).toUTCString() + "; path=/";
        document.body.classList.remove("dark-mode");
    }

    const themeToggle = document.querySelector("#theme-toggle");
    const themeToggleResponsive = document.querySelector("#theme-toggle-responsive");
    const themeToggleSidebar = document.querySelector("#theme-toggle-sidebar");
    const themeToggleAccProfile = document.querySelector("#theme-toggle-acc-profile");

    if (themeToggle) themeToggle.setAttribute("aria-label", theme.value);
    if (themeToggleResponsive) themeToggleResponsive.setAttribute("aria-label", theme.value);
    if (themeToggleSidebar) themeToggleSidebar.setAttribute("aria-label", theme.value);
    if (themeToggleAccProfile) themeToggleAccProfile.setAttribute("aria-label", theme.value);
    
    // Only update checkbox state if DOM is fully loaded
    if (document.readyState === 'complete' || document.readyState === 'interactive') {
        const toggleCheckboxes = document.querySelectorAll('#theme-toggle-responsive input[type="checkbox"]');
        toggleCheckboxes.forEach(checkbox => {
            checkbox.checked = theme.value === "dark";
        });
    }
};

const theme = {
    value: getColorPreference(),
};

// Apply theme immediately but don't update toggle positions yet
document.firstElementChild.setAttribute("data-theme", theme.value);
if (theme.value === "dark") {
    document.body.classList.add("dark-mode");
} else {
    document.body.classList.remove("dark-mode");
}

document.addEventListener('DOMContentLoaded', function() {
    // Now that DOM is loaded, fully apply the theme including toggle positions
    reflectPreference();
    
    // Setup event listeners for theme toggles
    const themeToggles = document.querySelectorAll('#theme-toggle-responsive');
    
    themeToggles.forEach(toggle => {
        const checkbox = toggle.querySelector('input[type="checkbox"]');
        checkbox.checked = theme.value === "dark";
        
        checkbox.addEventListener('change', function() {
            theme.value = this.checked ? "dark" : "light";
            setPreference();
            
            // Send AJAX request to update theme preference
            $.ajax({
                url: '/admin/update-theme',
                method: 'POST',
                data: {
                    dark_mode: this.checked ? 1 : 0
                },
                success: function(response) {
                    console.log('Theme preference updated');
                },
                error: function(xhr) {
                    console.error('Error updating theme preference');
                }
            });
        });
    });
    
    // Add click event listeners to other toggles if they exist
    document.querySelector("#theme-toggle")?.addEventListener("click", onClick);
    document.querySelector("#theme-toggle-sidebar")?.addEventListener("click", onClick);
    document.querySelector("#theme-toggle-acc-profile")?.addEventListener("click", onClick);
    
    // Listen for system theme changes
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', ({ matches: isDark }) => {
        // Only apply system preference if user hasn't set a preference
        if (!localStorage.getItem(storageKey)) {
            theme.value = isDark ? "dark" : "light";
            reflectPreference();
        }
    });
});

// Sidebar functionality (keeping this as is)
const sidebar = $("#eoc_sidebar");
const sidebarBody = $("#sidebar_body");
const sidebarToggle = $(".sidebar_toggle_header");

// Ensure the jQuery Cookie plugin is included in your project
const sidebarState = Cookies.get("eoc_sidebar");
if (sidebarState === "relative_position") {
    sidebar.removeClass("opened").addClass("relative_position");
    sidebarBody.removeClass("opened");
    sidebarToggle.removeClass("d-none");
} else {
    sidebar.removeClass("relative_position").addClass("opened");
    sidebarBody.addClass("opened");
    sidebarToggle.addClass("d-none");
}

function toggleSidebar() {
    if (sidebar.hasClass("opened")) {
        Cookies.set("eoc_sidebar", "relative_position", { expires: 3650, path: "/" });
        $.cookie("eoc_sidebar", "relative_position", { expires: 3650, path: "/" });
        sidebarToggle.removeClass("d-none");
    } else {
        Cookies.set("eoc_sidebar", "opened", { expires: 3650, path: "/" });
        $.cookie("eoc_sidebar", "opened", { expires: 3650, path: "/" });
        sidebarToggle.addClass("d-none");
    }
}

$(".sidebar_toggle").on("click", function () {
    toggleSidebar();
    setTimeout(() => {
        if ($.cookie("eoc_sidebar") === "relative_position") {
            sidebar.removeClass("opened").addClass("relative_position");
        } else {
            sidebar.removeClass("relative_position").addClass("opened");
        }
    }, 10);
});