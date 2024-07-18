import defaultTheme from "tailwindcss/defaultTheme";
import colors from "tailwindcss/colors";
import forms from "@tailwindcss/forms";
import typography from "@tailwindcss/typography";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./vendor/laravel/jetstream/**/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                display: ["Schoolbell", ...defaultTheme.fontFamily.sans],
                sans: ["Montserrat", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    DEFAULT: "#116DFF",
                    50: "#C9DEFF",
                    100: "#B4D1FF",
                    200: "#8BB8FF",
                    300: "#639FFF",
                    400: "#3A86FF",
                    500: "#116DFF",
                    600: "#0053D8",
                    700: "#003EA0",
                    800: "#002868",
                    900: "#001230",
                    950: "#000814",
                },
                secondary: {
                    DEFAULT: "#8B4CB7",
                    50: "#E0CFEC",
                    100: "#D6C0E6",
                    200: "#C4A3DA",
                    300: "#B186CE",
                    400: "#9E69C3",
                    500: "#8B4CB7",
                    600: "#6D3A91",
                    700: "#4F2A69",
                    800: "#311A41",
                    900: "#130A19",
                    950: "#040205",
                },
                black: {
                    DEFAULT: colors.neutral["900"],
                    ...colors.neutral,
                },
            },
            animation: {
                gradient: "animatedgradient 3s ease infinite alternate",
                floating: "floating 12s linear infinite",
            },
            keyframes: {
                animatedgradient: {
                    "0%": { backgroundPosition: "0% 50%" },
                    "50%": { backgroundPosition: "100% 50%" },
                    "100%": { backgroundPosition: "0% 50%" },
                },
                floating: {
                    "0%,50%,100%": { transform: "translateX(0) translateY(0)" },
                    "25%": { transform: "translateX(-5px) translateY(5px)" },
                    "75%": { transform: "translateX(5px) translateY(-5px)" },
                },
            },
        },
    },

    plugins: [forms, typography],
};
