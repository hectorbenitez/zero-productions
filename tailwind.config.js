import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    // Riff Blade components build these variant classes dynamically ('rf-btn-'.$variant, 'rf-stamp-'.$tone)
    safelist: [{ pattern: /^rf-(btn|stamp)-/ }],

    theme: {
        extend: {
            // ZeroPass Riff type families (self-hosted via @fontsource in resources/css/app.css)
            fontFamily: {
                display: ['"Big Shoulders Display"', 'Oswald', 'Impact', '"Arial Narrow"', ...defaultTheme.fontFamily.sans],
                sans: ['Archivo', ...defaultTheme.fontFamily.sans],
                mono: ['"Space Mono"', ...defaultTheme.fontFamily.mono],
            },
            colors: {
                // Legacy blue palette, still used by the admin panel
                primary: {
                    50: '#eff6ff',
                    100: '#dbeafe',
                    200: '#bfdbfe',
                    300: '#93c5fd',
                    400: '#60a5fa',
                    500: '#3b82f6',
                    600: '#2563eb',
                    700: '#1d4ed8',
                    800: '#1e40af',
                    900: '#1e3a8a',
                    950: '#172554',
                },
                // ZeroPass Riff tokens, "stage" theme (source: koden-zero-design-system/system/tokens.json)
                void: '#0a0a0a',
                amp: '#121110',
                cab: '#1c1a18',
                steel: '#2c2926',
                rule: '#2a2724',
                'rule-strong': '#757069',
                bone: '#f2ede4',
                ash: '#b3ada2',
                smoke: '#8c857b',
                riff: '#c8231a',
                'on-riff': '#f7f3ec',
                'riff-text': '#ff5a47',
                'riff-deep': '#8f1610',
                volt: '#f5c400',
                'on-volt': '#0a0a0a',
                ok: '#5fd4b8',
                danger: '#ff7a66',
                focus: '#f5c400',
            },
            boxShadow: {
                poster: '6px 6px 0 0 #8f1610',
            },
            borderRadius: {
                xs: '2px',
            },
        },
    },

    plugins: [forms],
};
