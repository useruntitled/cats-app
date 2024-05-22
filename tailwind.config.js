/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                secondary: "#0b0b0b",
                glass: "#191919",
            },
            light: {
                colors: {
                    secondary: "#ffffff",
                },
            },
            boxShadow: {
                glow: ["0 0 0 .1rem rgba(225, 225, 225, 4%) inset"],
                glowMD: ["0 0 0 .2rem rgba(225, 225, 225, 4%) inset"],
            },
        },
    },
    darkMode: "selector",
};
