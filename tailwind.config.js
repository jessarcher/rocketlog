const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: {
        content: [
            './vendor/laravel/jetstream/**/*.blade.php',
            './storage/framework/views/*.php',
            './resources/views/**/*.blade.php',
            './resources/js/**/*.vue',
        ],
        options: {
            safelist: ['sortable-chosen', 'sortable-ghost'],
        },
    },

    darkMode: 'class',

    theme: {
        extend: {
            animation: {
                'pulse-fast': 'pulse 1.5s cubic-bezier(0.4, 0, 0.6, 1) infinite',
            },
            fontFamily: {
                sans: ['Inter var', ...defaultTheme.fontFamily.sans],
            },
            typography(theme) {
                return {
                    dark: {
                        css: {
                            color: theme("colors.gray.300"),
                            '[class~="lead"]': {color: theme("colors.gray.400")},
                            a: {color: theme("colors.gray.300")},
                            strong: {color: theme("colors.gray.200")},
                            "ul > li::before": {backgroundColor: theme("colors.gray.700")},
                            hr: {borderColor: theme("colors.gray.800")},
                            blockquote: {
                                color: theme("colors.gray.300"),
                                borderLeftColor: theme("colors.gray.800"),
                            },
                            h1: {color: theme("colors.gray.300")},
                            h2: {color: theme("colors.gray.300")},
                            h3: {color: theme("colors.gray.300")},
                            h4: {color: theme("colors.gray.300")},
                            code: {color: theme("colors.gray.300")},
                            "a code": {color: theme("colors.gray.300")},
                            pre: {
                                color: theme("colors.gray.200"),
                                backgroundColor: theme("colors.gray.800"),
                            },
                            thead: {
                                color: theme("colors.gray.300"),
                                borderBottomColor: theme("colors.gray.700"),
                            },
                            "tbody tr": {borderBottomColor: theme("colors.gray.800")},
                        },
                    },
                };
            },
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
            typography: ['dark'],
            display: ['dark'],
            animation: ['group-hover'],
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
